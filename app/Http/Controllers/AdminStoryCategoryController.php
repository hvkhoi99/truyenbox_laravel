<?php

namespace App\Http\Controllers;

use App\Category_Story;
use Exception;
use Illuminate\Http\Request;

class AdminStoryCategoryController extends Controller
{
    //
    public function add(Request $request)
    {
        try {
            $data = $request->all();
            $story_category = Category_Story::create($data);
            return response()->json($story_category);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteStoryCategories($id)
    {
        try {
            return Category_Story::where('story_id', $id)->delete();
            // return response()->json($story_category);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteStoryCategory($story_id,$category_id)
    {
        try {
            return Category_Story::where([['story_id', $story_id], ['category_id', $category_id]])->delete();
            // return response()->json($story_category);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    // public function getCategoriesIdByStoryId($id){
    //     try {
    //         $categoriesId = Category_Story::select('category_id')->where('story_id', '=', $id)->get();
    //         return response()->json($categoriesId);
    //     } catch (Exception $e) {
    //         $response['error'] = $e->getMessage();
    //         return response()->json($response);
    //     }
    // }
}


