<?php

namespace App\Models;

class PropertyRent
{
    protected $fillable = [
        'property_id',
        'user_id',
        'details',
        'checkin',
        'checkout',
        'has_pet',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    protected function casts()
    {
        return [
            'checkin' => 'date',
            'checkout' => 'date',
            'has_pet' => 'boolean',
        ];
    }
}
