<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    protected $fillable = [
        'label',
        'recipient_name',
        'phone',
        'region_code',
        'province_code',
        'city_code',
        'barangay_code',
        'region_name',
        'province_name',
        'city_name',
        'barangay_name',
        'street_line',
        'postal_code',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
