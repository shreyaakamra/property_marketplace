<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\AiSearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(private AiSearchService $aiSearch)
    {
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        $filters = $query !== ''
            ? $this->aiSearch->parseQuery($query)
            : [];

        $properties = Property::query()
            ->where('is_active', true)
            ->city($filters['city'] ?? null)
            ->type($filters['property_type'] ?? null)
            ->listingType($filters['listing_type'] ?? null)
            ->bhk($filters['bhk'] ?? null)
            ->furnishing($filters['furnishing'] ?? null)
            ->priceBetween($filters['min_price'] ?? null, $filters['max_price'] ?? null)
            ->keyword($filters['keyword'] ?? null)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'query' => $query,
            'filters' => $filters,
        ]);
    }
}
