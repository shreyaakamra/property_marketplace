<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requester_name',
        'requester_phone',
        'requester_email',
        'listing_type',
        'bhk',
        'city',
        'locality',
        'min_price',
        'max_price',
        'min_area_sqft',
        'max_area_sqft',
        'furnishing',
        'preferred_amenities',
        'notes',
        'status',
    ];

    protected $casts = [
        'min_price'            => 'integer',
        'max_price'            => 'integer',
        'min_area_sqft'        => 'integer',
        'max_area_sqft'        => 'integer',
        'preferred_amenities'  => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Basic matching: find properties whose columns satisfy this
     * requirement's requested values/ranges. Column names here are meant
     * to match `properties` exactly — if a column gets renamed on that
     * table, update the right-hand side of the corresponding where() here.
     */
    public function matchingProperties(): Builder
    {
        $query = Property::query();

        if ($this->listing_type) {
            $query->where('listing_type', $this->listing_type);
        }

        if ($this->city) {
            $query->where('city', $this->city);
        }

        if ($this->locality) {
            $query->where('locality', 'like', '%' . $this->locality . '%');
        }

        // BHK: treat the requester's value as a minimum config (e.g. "2" means 2BHK or bigger).
        // properties.bhk is a string ("1","2","3", etc.) so this casts both sides to compare numerically.
        if ($this->bhk) {
            $query->whereRaw('CAST(bhk AS UNSIGNED) >= ?', [(int) $this->bhk]);
        }

        // Price: property's price must fall within [min_price, max_price] the requester gave.
        if (!is_null($this->min_price)) {
            $query->where('price', '>=', $this->min_price);
        }
        if (!is_null($this->max_price)) {
            $query->where('price', '<=', $this->max_price);
        }

        // Area (sqft): property's area must fall within the requested range.
        if (!is_null($this->min_area_sqft)) {
            $query->where('area_sqft', '>=', $this->min_area_sqft);
        }
        if (!is_null($this->max_area_sqft)) {
            $query->where('area_sqft', '<=', $this->max_area_sqft);
        }

        // Furnishing: exact match if the requester cares, otherwise any.
        if ($this->furnishing) {
            $query->where('furnishing', $this->furnishing);
        }

        // Only show live/available listings if properties tracks that.
        if (in_array('status', (new Property())->getFillable())) {
            $query->where('status', 'available');
        }

        return $query;

        // Not included in this pass: matching on preferred_amenities against
        // properties.amenities (would need a JSON contains/overlap check).
        // Flagged in README as a natural next step once basic matching ships.
    }

    public function matchCount(): int
    {
        return $this->matchingProperties()->count();
    }

    /**
     * Scope: open requirements that a given property would satisfy.
     * Useful on the property-detail page ("3 people are looking for this").
     */
    public function scopeMatchingProperty(Builder $query, Property $property): Builder
    {
        return $query
            ->where('status', 'open')
            ->where(function (Builder $q) use ($property) {
                $q->whereNull('listing_type')->orWhere('listing_type', $property->listing_type);
            })
            ->where(function (Builder $q) use ($property) {
                $q->whereNull('city')->orWhere('city', $property->city);
            })
            ->where(function (Builder $q) use ($property) {
                $q->whereNull('min_price')->orWhere('min_price', '<=', $property->price);
            })
            ->where(function (Builder $q) use ($property) {
                $q->whereNull('max_price')->orWhere('max_price', '>=', $property->price);
            })
            ->where(function (Builder $q) use ($property) {
                $q->whereNull('bhk')->orWhereRaw('CAST(bhk AS UNSIGNED) <= ?', [(int) $property->bhk]);
            });
    }
}