<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name', 'view', 'path_image', 'story_id', 'pages'
    ];

    function Story(){
        return $this->belongsTo('App\Story');
    }

    function Images(){
        return $this->hasMany('App\Image');
    }
}
