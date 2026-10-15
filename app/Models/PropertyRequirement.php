<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRequirement extends Model
{
    use HasFactory;

    protected $table = 'property_requirements';

    protected $fillable = [
        'code',
        'property_type',
        'city',
        'state',
        'budget',
        'description',
        'contact_name',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'budget' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (PropertyRequirement $req) {
            if (empty($req->code)) {
                $req->code = 'RQ-' . str_pad((string) (static::max('id') + 1), 6, '0', STR_PAD_LEFT);
            }
        });
    }
}
