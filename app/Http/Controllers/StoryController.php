<?php

namespace App\Http\Controllers;
use App\Story_User;
use App\Story;
use App\User;

use Exception;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    //
    public function getStoriesManyView($number)
    {
        try {
            return Story::orderBy('view','desc')->limit($number)->get();
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getStoriesFollow($user_id)
    {
        try {
            return User::find($user_id)->Stories;
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
