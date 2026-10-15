<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Turns a free-text property search ("2bhk near Vijay Nagar Indore under
 * 25k, furnished, bachelors ok") into structured filters the Eloquent
 * query builder can use.
 *
 * The model's only job is intent-parsing — it never touches the database
 * directly, and every field it returns is validated/whitelisted below
 * before it's used in a query. If the API call fails or returns something
 * unparseable, we fall back to treating the whole query as a keyword
 * search so the search box never just breaks.
 */
class AiSearchService
{
    private const ALLOWED_PROPERTY_TYPES = [
        'apartment', 'villa', 'plot', 'office',
        'pg_hostel', 'farm_land', 'home', 'other',
    ];

    private const ALLOWED_LISTING_TYPES = ['rent', 'sale'];
    private const ALLOWED_FURNISHING = ['unfurnished', 'semi', 'full'];

    public function parseQuery(string $query): array
{
    $fallback = ['keyword' => $query];

    $apiKey = config('services.groq.api_key');
    if (! $apiKey) {
        Log::warning('AiSearchService: GROQ_API_KEY not set, using keyword fallback.');
        return $fallback;
    }

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(8)->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => config('services.groq.model', 'openai/gpt-oss-20b'),
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt()],
                ['role' => 'user', 'content' => $query],
            ],
        ]);

        if (! $response->successful()) {
            Log::warning('AiSearchService: Groq API returned ' . $response->status() . ' — ' . $response->body());
            return $fallback;
        }

        $text = $response->json('choices.0.message.content');
        $parsed = json_decode($text, true);

        if (! is_array($parsed)) {
            return $fallback;
        }

        return $this->sanitize($parsed, $query);
    } catch (\Throwable $e) {
        Log::error('AiSearchService failed: ' . $e->getMessage());
        return $fallback;
    }
}
    private function systemPrompt(): string
    {
        return <<<PROMPT
You convert a free-text Indian property search into JSON filters. Reply with
ONLY a JSON object, no prose, no markdown fences. Use these exact keys, all
optional — omit any you cannot confidently infer:

{
  "city": string,
  "locality": string,
  "property_type": one of [apartment, villa, plot, office, pg_hostel, farm_land, home, other],
  "listing_type": one of [rent, sale],
  "bhk": integer,
  "min_price": number,
  "max_price": number,
  "furnishing": one of [unfurnished, semi, full],
  "keyword": string (any remaining descriptive terms, e.g. "bachelors", "near metro")
}

Interpret Indian shorthand: "25k" = 25000, "1.2cr" = 12000000, "1.5 lakh" = 150000.
If the query implies a budget ceiling ("under X", "within X"), set max_price only.
If it implies a range ("20-30k"), set both min_price and max_price.
PROMPT;
    }

    private function sanitize(array $parsed, string $originalQuery): array
    {
        $out = [];

        if (isset($parsed['city']) && is_string($parsed['city'])) {
            $out['city'] = trim($parsed['city']);
        }
        if (isset($parsed['locality']) && is_string($parsed['locality'])) {
            $out['locality'] = trim($parsed['locality']);
        }
        if (isset($parsed['property_type']) && in_array($parsed['property_type'], self::ALLOWED_PROPERTY_TYPES, true)) {
            $out['property_type'] = $parsed['property_type'];
        }
        if (isset($parsed['listing_type']) && in_array($parsed['listing_type'], self::ALLOWED_LISTING_TYPES, true)) {
            $out['listing_type'] = $parsed['listing_type'];
        }
        if (isset($parsed['furnishing']) && in_array($parsed['furnishing'], self::ALLOWED_FURNISHING, true)) {
            $out['furnishing'] = $parsed['furnishing'];
        }
        if (isset($parsed['bhk']) && is_numeric($parsed['bhk'])) {
            $out['bhk'] = (int) $parsed['bhk'];
        }
        if (isset($parsed['min_price']) && is_numeric($parsed['min_price'])) {
            $out['min_price'] = (float) $parsed['min_price'];
        }
        if (isset($parsed['max_price']) && is_numeric($parsed['max_price'])) {
            $out['max_price'] = (float) $parsed['max_price'];
        }
        if (isset($parsed['keyword']) && is_string($parsed['keyword'])) {
            $out['keyword'] = trim($parsed['keyword']);
        }

        // If the model returned literally nothing usable, fall back to keyword.
        if (empty($out)) {
            $out['keyword'] = $originalQuery;
        }

        return $out;
    }
}
