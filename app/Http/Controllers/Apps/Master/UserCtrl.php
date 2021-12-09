<?php

namespace App\Http\Controllers\Apps\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use App\Model\User;
use Validator;
use Auth;
use Response;
use Input;
use Session;
use DB;

class UserCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_user = new User();

        if ($request->get('search')) {
            $users = $model_user->getUserBySearch($request->get('search'));
        } else {
            $users = $model_user->getUserPagination();
        }
        return response($users);
    }

    public function insert(Request $request)
    {
        $tableName = "users";
        $primary = "code";
        $autoNumber = new AutoNumber();
        $getCode = $autoNumber->generate($tableName, $primary);

        $model_user = new User();
        $model_user->code = $getCode;
        $model_user->name = $request->name;
        $model_user->join_date = date("Y-m-d", strtotime($request->join_date));
        $model_user->email = $request->email;
        $model_user->password = bcrypt($request->password);
        $model_user->permission = $request->permission;
        $model_user->status = $request->status;
        $model_user->save();
        return response()->json($model_user);
    }

    public function edit($id)
    {
        $model_user = User::where('id', $id)->get();
        $data_user = [];
        foreach ($model_user as $key => $value) {
            $data_user = array (
                "name" => $value->name,
                "join_date" => $value->join_date,
                "email" => $value->email,
                "permission" => $value->permission,
                "status" => $value->status
            );
        }

        return response()->json($data_user);
    }

    public function update(Request $request)
    {
        $model_user = User::find($request->id);
        $model_user->name = $request->name;
        $model_user->join_date = date("Y-m-d", strtotime($request->join_date));
        $model_user->email = $request->email;
        $model_user->permission = $request->permission;
        if (!empty($request->password)) {
            $model_user->password = bcrypt($request->password);
        }
        $model_user->status = $request->status;
        $model_user->save();
        return response()->json($model_user);
    }

    public function getUserDetail($id)
    {
        $data_user = User::find($id);

        $user = array(
            "data_user" => $data_user
        );

        return response()->json($user);
    }

    public function getAll()
    {
        $model_user = new User();
        $data_user = User::whereNotIn("users.permission", [0])->get();

        return response()->json($data_user);
    }

    public function checkAuth()
    {
        $result_check = Auth::check();
        return response()->json($result_check);
    }
}
