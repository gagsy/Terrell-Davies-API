<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    protected $fillable = [
        'category_id',
        'property_id'
    ];

    public function property()
	{
		return $this->belongsTo(Property::class);
    }

    public function category()
	{
		return $this->belongsTo(Category::class);
    }
}
