<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyLocation extends Model
{
    protected $fillable = [
        'location_id',
        'property_id',
    ];

    public function location()
	{
		return $this->belongsTo(Location::class);
    }

    public function property()
	{
		return $this->belongsTo(Property::class);
    }
}
