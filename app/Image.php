<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = [
        'path_image', 'chapter_id', 'stt'
    ];

    function Chapter(){
        return $this->belongsTo('App\Chapter');
    }
}
