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
        'other_images',
        'bedroom',
        'bathroom',
        'toilet',
        'video-link',
        'status',
        'feature',
        'ref_no',
        'user',
    ];

    public function user()
	{
		return $this->belongsTo(User::class);
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

    protected $casts = [ 'other_images' => 'array', 'user' => 'array' ];

    public function getOtherImagesAttribute(){
        return explode(',',$this->attributes['other_images']);
    }

}
