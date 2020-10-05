<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'cat_id',
        'type_id',
        'location_id',
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
		return $this->belongsTo(Category::class);
    }

    public function property_type()
	{
		return $this->belongsTo(Type::class);
    }

    public function property_loc()
	{
		return $this->belongsTo(Location::class);
    }

    public function images(){
        return $this->hasMany('App\PropertyGallery', 'property_id', 'id');
    }

    // public static function scopeSearch($query, $searchTerm)
    // {
    //     return $query->where('title', 'like', '%' .$searchTerm. '%')
    //                  ->orWhere('slug', 'like', '%' .$searchTerm. '%');
    // }
}
