<?php

namespace App\Http\Controllers;

use App\Chapter;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function getChaptersInMonth($year, $month, $number)
    {
        try {
            // return Chapter::orderBy('view', 'DESC')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->limit($number)->get();
            return DB::table('stories')
            ->join('chapters', 'stories.id', '=', 'chapters.story_id')
            -> orderBy('chapters.view', 'DESC')->whereYear('chapters.created_at', '=', $year)->whereMonth('chapters.created_at', '=', $month)->limit($number)
            ->select('chapters.id','chapters.name','chapters.view','chapters.story_id','chapters.created_at','stories.name as name_story','stories.status','stories.follow','stories.path_image' )
            ->get();

        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getChaptersToday($number)
    {
        try {
            // return Chapter::whereDate('created_at', Carbon::today())->orderBy('view', 'DESC')->limit($number)->get();
            return DB::table('stories')
            ->join('chapters', 'stories.id', '=', 'chapters.story_id')
            ->whereDate('chapters.created_at', Carbon::today())->orderBy('chapters.view', 'DESC')->limit($number)
            ->select('chapters.id','chapters.name','chapters.view','chapters.story_id','chapters.created_at','stories.name as name_story','stories.status','stories.follow','stories.path_image')
            ->get();
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getChaptersInWeek($number)
    {
        try {
            // return Chapter::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('view', 'DESC')->limit($number)->get();
            return DB::table('stories')
            ->join('chapters', 'stories.id', '=', 'chapters.story_id')
            ->whereBetween('chapters.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('chapters.view', 'DESC')->limit($number)
            ->select('chapters.id','chapters.name','chapters.view','chapters.story_id','chapters.created_at','stories.name as name_story','stories.status','stories.follow','stories.path_image' )
            ->get();
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function getChaptersByDay($day)
    {
        try {
            $chapters = DB::table('stories')
            ->join('chapters', 'stories.id', '=', 'chapters.story_id')
            ->select('chapters.*','stories.name as name_story','stories.path_image', 'stories.follow', 'stories.status', 'stories.description', 'stories.view as story_view')
            ->get();

            $chaptersDay = array();
            foreach($chapters as $chapter){
                $c = new Carbon($chapter->created_at);
                if($c->dayOfWeek == $day){
                    array_push($chaptersDay, $chapter);
                }
            }
            return $chaptersDay;
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    // public function getChaptersUpdate($number){
    //     try {
    //         // $chapters = Chapter::orderBy('id','DESC')->limit($number)->get();
    //         // return $chapters;
    //         $chapters = DB::table('stories')
    //         ->join('chapters', 'stories.id', '=', 'chapters.story_id')->select('chapters.*','stories.name as name_story','stories.path_image')
    //         ->get();

    //         return $chapters;
    //     } catch (Exception $e) {
    //         $response['error'] = $e->getMessage();
    //         return response()->json($response);
    //     }
    // }

}
