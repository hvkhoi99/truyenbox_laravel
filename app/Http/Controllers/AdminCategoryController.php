<?php

namespace App\Http\Controllers;

use App\Category;
use App\Story;
use Exception;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    //
    public function add(Request $request){
        try{
            return response()->json(Category::create($request->all()));
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function index(){
        try{
            return response()->json(Category::orderBy('id','desc')->get());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function edit(Request $request, $id){
        try{
            return response()->json(Category::findOrFail($id)->update($request->all()));
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($id){
        try{
            return response()->json(Category::findOrFail($id)->delete());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function search($name){
        try{
            return response()->json(Category::where('name', 'like', "%{$name}%")->get());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function get($id)
    {
        try {
            return Category::find($id);
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getCategoriesByStoryId($id){
        try {
            return Story::find($id)->Categories;
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
