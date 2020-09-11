<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'content',
        'url',
        'image'
    ];

    public function category()
	{
		return $this->belongsTo(BlogCategory::class);
    }
}
