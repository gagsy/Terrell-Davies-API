<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
    protected $fillable = [
        'feature_id',
        'property_id'
    ];

    public function feature()
	{
		return $this->belongsTo(Feature::class);
    }

    public function property()
	{
		return $this->belongsTo(Property::class);
    }
}
