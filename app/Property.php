<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'type',
        'status',
        'price',
        'featuredImage',
        'galleryImage',
        'user_id',
        'agent',
        'feature',
        'bedroom',
        'bathroom',
        'garage',
        'toilet',
        'views',
        'metaDescription',
        'visible'
    ];

    public function user()
	{
		return $this->belongsTo(User::class);
    }
}
