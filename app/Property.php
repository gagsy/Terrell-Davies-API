<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'property_cat_id',
        'property_type_id',
        'title',
        'description',
        'state',
        'market-status',
        'locality',
        'budget',
        'featuredImage',
        'galleryImage',
        'agent',
        'feature',
        'bedroom',
        'bathroom',
        'garage',
        'toilet',
        'totalarea',
        'video-link',
        'metaDescription'
    ];

    public function property_cat()
	{
		return $this->belongsTo(PropertyCategory::class);
    }

    public function property_type()
	{
		return $this->belongsTo(PropertyType::class);
    }

    // public static function scopeSearch($query, $searchTerm)
    // {
    //     return $query->where('title', 'like', '%' .$searchTerm. '%')
    //                  ->orWhere('slug', 'like', '%' .$searchTerm. '%');
    // }
}
