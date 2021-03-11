<?php

namespace App\Http\Controllers;

use Exception;
use App\Chapter;
use App\Image;
use Illuminate\Http\Request;

class AdminImageController extends Controller
{
    //
    function getImagesByChapterId($id) {
        try {
            $images = Chapter::find($id)->Images;
            return $images;
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
    function deleteImagesByChapterId($id) {
        try {
            return Image::where('chapter_id', $id)->delete();
            // $images = Chapter::find($id)->Images;
            // return $images->delete();
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    function editPath(Request $request, $id, $stt){
        try {
            return Image::where([['chapter_id', '=', $id], ['stt', '=', $stt]])->update($request->all());
            // return response()->json($author);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
