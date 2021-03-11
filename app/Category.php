<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name', 'description'
    ];

    function Stories(){
        return $this->belongsToMany('App\Story');
    }
}
