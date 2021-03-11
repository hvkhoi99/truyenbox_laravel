<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    //
    private $status_code    =        200;
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return response()->json($users);
    }
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $user = User::create($data);
            return response()->json($user);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
    public function edit(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id)->update($request->all());
            return response()->json($user);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id)->delete();
            return response()->json($user); //return true
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
    public function search($name)
    {
        try {
            return User::where('name', 'like', "%{$name}%")->get();
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function get($id)
    {
        try {
            return User::find($id);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }
    }
    public function changePass(Request $request, $email)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "password_current" => "required",
                    "password" => "required",
                    "password_confirm" => "required|same:password"
                ],
                [
                    'required' => ':attribute không được để trống',
                    'same' => 'Xác nhận mật khẩu không đúng'
                ],
                [
                    'password_current' => 'Mật khẩu hiện tại',
                    'password' => 'Mật khẩu',
                    'password_confirm' => 'Xác nhận mật khẩu',
                ]
            );

            if ($validator->fails()) {
                return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
            }
            $email_status       =       User::where("email", $email)->first();

            if (!is_null($email_status)) {

                if (md5($request->password_current) == $email_status->password) {
                    $userDataArray    =    array(
                        "email"      =>    $email,
                        "password"   =>    md5($request->password),
                    );
                    $user             =    User::where('email', '=', $email)->update($userDataArray);

                    if (!is_null($user)) {
                        return response()->json(["status" => $this->status_code, "success" => true, "message" => "Đổi mật khẩu thành công", "data" => $user]);
                    } else {
                        return response()->json(["status" => "failed", "success" => false, "message" => "Đổi mật khẩu không thành công"]);
                    }
                } else {
                    return response()->json(["status" => "failed", "success" => false, "message" => "Mật khẩu hiện tại không đúng"]);
                }
            }
            else{
                return response()->json(["status" => "failed", "success" => false, "message" => "Email doesn't exist."]);
            }
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
                    if ($user->role != 'user') {
                        return response()->json(["status" => $this->status_code, "success" => true, "message" => "You have logged in successfully", "data" => $user]);
                    } else {
                        return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. You not Admin !!!."]);
                    }
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

    public function adminSignUp(Request $request)
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
                'required' => ':attribute không được để trống',
                'email' => 'Bạn phải nhập đúng định dạng của email',
                'same' => 'Xác nhận mật khẩu không đúng'
            ],
            [
                'name' => 'Tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'password_confirm' => 'Xác nhận mật khẩu',
            ]
        );

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }

        $userDataArray          =       array(
            "name"              =>          $request->name,
            "email"              =>          $request->email,
            "role"              =>           "admin",
            "password"           =>          md5($request->password),
        );

        $user_status            =           User::where("email", $request->email)->first();

        if (!is_null($user_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Email đã được sử dụng"]);
        }

        $user                   =           User::create($userDataArray);

        if (!is_null($user)) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Đăng ký thành công", "data" => $user]);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Đăng ký không thành công"]);
        }
    }
}
