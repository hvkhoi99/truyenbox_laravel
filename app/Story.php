<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    //
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name', 'description', 'path_image', 'status', 'user_id', 'author_id', 'view', 'follow'
    ];

    function Author(){
        return $this->belongsTo('App\Author');
    }

    function Chapters(){
        return $this->hasMany('App\Chapter');
    }

    function Categories(){
        return $this->belongsToMany('App\Category');
    }

    function Users(){
        return $this->belongsToMany('App\User');
    }

}
