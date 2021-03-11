<?php

namespace App\Http\Controllers;

use App\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    //
    public function addComment(Request $request)
    {
        try {
            return Comment::create($request->all());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getCommentsByChapterId($id)
    {
        try {
            $comments = DB::table('comments')
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.content', 'comments.created_at', 'users.name')
                ->where('comments.chapter_id', '=', $id)
                ->orderBy('comments.id', 'DESC')
                ->get();
            return $comments;
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
