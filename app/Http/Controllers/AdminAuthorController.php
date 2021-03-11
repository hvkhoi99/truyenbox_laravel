<?php

namespace App\Http\Controllers;

use App\Author;
use App\Story;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthorController extends Controller
{
    public function index()
    {
        try {
            // $authors = Author::all();
            $authors = Author::orderBy('id', 'desc')->get();
            return response()->json($authors);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function add(Request $request)
    {
        try {
            $data = $request->all();
            $author = Author::create($data);
            return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $data = $request->all();
            $author = Author::findOrFail($id)->update($data);
            return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($id)
    {
        try {
            $author = Author::findOrFail($id)->delete();
            return response()->json($author); //return true
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function search($name)
    {
        try {
            $author = Author::where('name', 'like', "%{$name}%")->get();
            return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function get($id)
    {
        try {
            return Author::find($id);
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getAuthorByStoryId($id)
    {
        try {
            return Story::find($id)->Author;
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
            
        }
    }
}
