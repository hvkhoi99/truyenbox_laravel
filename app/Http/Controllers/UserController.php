<?php

namespace App\Http\Controllers;

use App\User;
use App\Story_User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    private $status_code    =        200;

    public function follow(Request $request)
    {
        try {
            $data = $request->all();
            $follow = Story_User::create($data);
            return response()->json($follow);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function unFollow($user_id, $story_id)
    {
        try {
            return Story_User::where([['user_id', $user_id], ['story_id', $story_id]])->delete();
            // return response()->json($story_category);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function checkFollow($user_id, $story_id)
    {
        try {
            $count = Story_User::where([['user_id', $user_id], ['story_id', $story_id]])->count();
            return $count;
            // return response()->json($story_category);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator          =       Validator::make(
                $request->all(),
                [
                    "email"             =>          "required|email",
                    "password"          =>          "required"
                ]
            );

            if ($validator->fails()) {
                return response()->json(["status" => "failed", "validation_error" => $validator->errors()]);
            }

            // check if entered email exists in db
            $email_status       =       User::where("email", $request->email)->first();
            if (!is_null($email_status)) {
                $password_status    =   User::where("email", $request->email)->where("password", md5($request->password))->first();
                if (!is_null($password_status)) {
                    $user           =       $password_status;
                    // if ($user->role != 'user') {
                    return response()->json(["status" => $this->status_code, "success" => true, "message" => "You have logged in successfully", "data" => $user]);
                    // }
                    // else{
                    //     return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. You not Admin !!!."]);
                    // }
                } else {
                    return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. Incorrect password."]);
                }
            } else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. Email doesn't exist."]);
            }
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function userSignUp(Request $request)
    {
        $validator              =        Validator::make(
            $request->all(),
            [
                "name"              =>          "required",
                "email"             =>          "required|email",
                "password"          =>          "required",
                "password_confirm"  =>          "required|same:password",
            ],
            [
                'required' => ':attribute kh??ng ???????c ????? tr???ng',
                'email' => 'B???n ph???i nh???p ????ng ?????nh d???ng c???a email',
                'same' => 'X??c nh???n m???t kh???u kh??ng ????ng'
            ],
            [
                'name' => 'T??n',
                'email' => 'Email',
                'password' => 'M???t kh???u',
                'password_confirm' => 'X??c nh???n m???t kh???u',
            ]
        );

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }

        $userDataArray          =       array(
            "name"              =>          $request->name,
            "email"              =>          $request->email,
            "password"           =>          md5($request->password),
        );

        $user_status            =           User::where("email", $request->email)->first();

        if (!is_null($user_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Email ???? ???????c s??? d???ng"]);
        }

        $user                   =           User::create($userDataArray);

        if (!is_null($user)) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "????ng k?? th??nh c??ng", "data" => $user]);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "????ng k?? kh??ng th??nh c??ng"]);
        }
    }
}
