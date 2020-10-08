<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
