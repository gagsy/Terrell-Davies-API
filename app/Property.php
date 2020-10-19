<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use DB;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'type_id',
        'location',
        'title',
        'description',
        'state',
        'area',
        'total_area',
        'market_status',
        'parking',
        'locality',
        'budget',
        'image',
        'bedroom',
        'bathroom',
        'toilet',
        'video-link',
        'status',
        'feature'
    ];

    public function user_id(){
        $this->belongsTo('App\User', 'user_id');
    }

    public static function shortlistCount(){
        $user_id = auth('api')->user()->id;
        $shortlistCount = DB::table('short_lists')->where('user_id', $user_id)->sum('quantity');
        return $shortlistCount;
    }

    public function category()
	{
		return $this->belongsTo(Category::class);
    }

    public function type()
	{
		return $this->belongsTo(Type::class);
    }


    public function image(){
        return $this->hasMany('App\PropertyGallery', 'property_id', 'id');
    }

    protected $casts = [ 'image' => 'array' ];


    // public static function scopeSearch($query, $searchTerm)
    // {
    //     return $query->where('title', 'like', '%' .$searchTerm. '%')
    //                  ->orWhere('slug', 'like', '%' .$searchTerm. '%');
    // }
}
