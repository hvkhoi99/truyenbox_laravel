<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_Story extends Model
{
    //
    protected $table = 'category_story';
    protected $fillable = [
        'story_id', 'category_id'
    ];
}
