<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    protected $fillable = [
        'user_id','property_id'
    ];


}
