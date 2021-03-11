<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Image;
use Exception;
use Illuminate\Http\Request;

class AdminChapterController extends Controller
{
    //
    public function add(Request $request){
        try{
            return response()->json(Chapter::create($request->all()));
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function index($story_id){
        try{
            return response()->json(Chapter::where('story_id', $story_id)->orderBy('id','desc')->get());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function edit(Request $request, $id){
        try{
            return response()->json(Chapter::findOrFail($id)->update($request->all()));
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($id){
        try{
            return response()->json(Chapter::findOrFail($id)->delete());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function search(Request $request){
        try{
            $name = $request->input('name');
            return response()->json(Chapter::where('name', 'like', "%{$name}%")->get());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function addImage(Request $request){
        try{
            return response()->json(Image::create($request->all()));
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function get($id)
    {
        try {
            return Chapter::find($id);
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
