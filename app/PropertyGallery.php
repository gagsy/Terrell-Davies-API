<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyGallery extends Model
{
    protected $fillable = [
        'property_id',
        'image'
    ];

    public function gallery()
    {
        return $this->belongsTo('App\Property');
    }
}
