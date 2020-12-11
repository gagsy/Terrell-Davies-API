<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{

    protected $fillable = ['title','sender_id','receiver_id','content','read_at'];
}
