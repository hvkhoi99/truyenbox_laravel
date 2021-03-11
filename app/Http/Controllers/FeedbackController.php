<?php

namespace App\Http\Controllers;

use App\Feedback;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    //
    public function index()
    {
        try {
            $feedbacks = DB::table('feedbacks')
                ->join('users', 'users.id', '=', 'feedbacks.user_id')
                ->orderBy('feedbacks.id', 'DESC')
                ->select('feedbacks.*', 'users.email')
                ->get();
            return $feedbacks;
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function add(Request $request)
    {
        try {
            return Feedback::create($request->all());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($id){
        try{
            return response()->json(Feedback::findOrFail($id)->delete());
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
