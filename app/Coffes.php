<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorys extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coffename','lo','la','description','nbusers','totalrate','options','cat_id'
    ];

}
