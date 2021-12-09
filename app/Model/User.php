<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
    protected $table = "users";

    public function getUserBySearch($typing)
    {
        $data_user = DB::table('users')
            ->select(
                'users.id as id'
                , 'users.code as code'
                , 'users.join_date as join_date'
                , 'users.name as name'
                , 'users.email as email'
                , 'users.status as status'
                , 'users.permission as permission'
                , 'users.status as status'
            )
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orWhere("users.code", "LIKE", "%{$typing}%")
            ->orWhere("users.email", "LIKE", "%{$typing}%")
            ->whereNotIn('users.permission', [99])
            ->orderBy('users.id', 'desc')
            ->paginate(25);

        return $data_user;
    }

    public function getUserPagination()
    {
        $data_user = DB::table('users')
            ->select(
                'users.id as id'
                , 'users.code as code'
                , 'users.join_date as join_date'
                , 'users.name as name'
                , 'users.email as email'
                , 'users.status as status'
                , 'users.permission as permission'
                , 'users.status as status'
            )
            ->whereNotIn('users.permission', [99])
            ->orderBy('users.id', 'desc')
            ->paginate(25);

        return $data_user;
    }

    public function getUserById($id)
    {
        $data_user = DB::table('users')
            ->select(
                'users.id as id'
                , 'users.code as code'
                , 'users.join_date as join_date'
                , 'users.name as name'
                , 'users.email as email'
                , 'users.status as status'
                , 'users.permission as permission'
                , 'users.status as status'
            )
            ->where('users.id', $id)
            ->orderBy('users.id', 'desc')
            ->get();

        return $data_user;
    }
}
