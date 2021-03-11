<?php

namespace App\Http\Controllers;

use App\Category;
use App\Chapter;
use App\Story;
use Exception;
use Illuminate\Http\Request;

class AdminStoryController extends Controller
{
    //
    public function add(Request $request)
    {
        try {
            $data = $request->all();
            $story = Story::create($data);
            return response()->json($story);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function index()
    {
        try {
            return response()->json(Story::orderBy('id', 'desc')->get());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($id)
    {
        try {
            return response()->json(Story::findOrFail($id)->delete());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            return response()->json(Story::findOrFail($id)->update($request->all()));
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
    public function search($name)
    {
        try {
            return response()->json(Story::where('name', 'like', "%{$name}%")->get());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function get($id)
    {
        try {
            return Story::find($id);
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getStoryByChapterId($id)
    {
        try {
            return Chapter::find($id)->Story;
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getStoriesByCategoryId($id){
        try {
            return Category::find($id)->Stories;
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
