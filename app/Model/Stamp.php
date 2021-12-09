<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class Stamp extends Model
{
    protected $table = 'stamps';
    protected $fillable = [
        'name'
   	];

    public function getStampBySearch($typing)
    {
        $data = DB::table('stamps')
        ->select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.stamp as stamp'
            , 'stamps.price as price'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'stamps.users_id')
        ->where("stamps.name", "LIKE", "%{$typing}%")
        ->orWhere("stamps.code", "LIKE", "%{$typing}%")
        ->orderBy('stamps.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getStampPagination()
    {
        $data = DB::table('stamps')
        ->select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.stamp as stamp'
            , 'stamps.price as price'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'stamps.users_id')
        ->orderBy('stamps.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getStampById($id)
    {
        $data = DB::table('stamps')
        ->select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.stamp as stamp'
            , 'stamps.price as price'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'stamps.users_id')
        ->where('stamps.id', $id)
        ->get();

        return $data;
    }

    public function searchStamp($typing)
    {
        $data = DB::table('stamps')
        ->select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.stamp as stamp'
            , 'stamps.price as price'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'stamps.users_id')
        ->where("stamps.status", 'A')
        ->where("stamps.name", "LIKE", "%{$typing}%")
        ->orderBy('stamps.id', 'desc')
        ->paginate(10);

        return $data;
    }
}
