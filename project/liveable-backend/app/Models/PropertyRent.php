<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyRent extends Model
{
    protected $fillable = [
        'people_count',
        'checkin',
        'checkout',
        'property_id',
        'has_pet',
        'details',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    protected function casts(): array
    {
        return [
            'checkin' => 'date',
            'checkout' => 'date',
        ];
    }
}
