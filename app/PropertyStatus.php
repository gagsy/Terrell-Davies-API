<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyStatus extends Model
{
    protected $fillable = [
        'status_id',
        'property_id'
    ];

    public function status()
	{
		return $this->belongsTo(Status::class);
    }

    public function property()
	{
		return $this->belongsTo(Property::class);
    }
}
