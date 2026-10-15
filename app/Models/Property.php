<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'listing_type',   // rent | sale
        'property_type',  // apartment | villa | plot | office | pg_hostel | farm_land | home | other
        'city',
        'state',
        'locality',
        'price',
        'bhk',
        'area_sqft',
        'furnishing',     // unfurnished | semi | full
        'amenities',
        'contact_name',
        'contact_phone',
        'is_verified_owner',
        'is_active',
    ];

    protected $casts = [
        'amenities' => 'array',
        'is_verified_owner' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            if (empty($property->code)) {
                $property->code = 'PR-' . str_pad((string) (static::max('id') + 1), 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function scopeCity($query, ?string $city)
    {
        return $city ? $query->where('city', 'like', "%{$city}%") : $query;
    }

    public function scopeType($query, ?string $type)
    {
        return $type ? $query->where('property_type', $type) : $query;
    }

    public function scopeListingType($query, ?string $listingType)
    {
        return $listingType ? $query->where('listing_type', $listingType) : $query;
    }

    public function scopePriceBetween($query, ?float $min, ?float $max)
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    public function scopeBhk($query, ?int $bhk)
    {
        return $bhk ? $query->where('bhk', $bhk) : $query;
    }

    public function scopeFurnishing($query, ?string $furnishing)
    {
        return $furnishing ? $query->where('furnishing', $furnishing) : $query;
    }

    public function scopeKeyword($query, ?string $keyword)
    {
        if (! $keyword) {
            return $query;
        }
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('locality', 'like', "%{$keyword}%");
        });
    }
}
