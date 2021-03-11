<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    protected $fillable = [
        'name', 'description'
    ];

    function Story(){
        return $this->hasOne('App\Story');
    }
}

