<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story_User extends Model
{
    //
    protected $table ='story_user';
    protected $fillable = [
        'story_id', 'user_id'
    ];
}
