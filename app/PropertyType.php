<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = [
        'type_id',
        'property_id'
    ];

    public function type()
	{
		return $this->belongsTo(Type::class);
    }

    public function property()
	{
		return $this->belongsTo(Property::class);
    }
}
