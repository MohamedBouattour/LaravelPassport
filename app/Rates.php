<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coffe_id','user_id','value'
    ];

}
