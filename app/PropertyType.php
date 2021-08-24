<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = [
        'type_id',
        'property_id'
    ];

	public function propertyType(){
        return $this->hasMany(Type::class, 'id');
    }
}
