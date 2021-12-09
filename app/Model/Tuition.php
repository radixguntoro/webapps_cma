<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tuition extends Model
{
    protected $table = 'tuitions';
    protected $fillable = [
        'name'
   	];

    public function getTuitionBySearch($typing)
    {
        $data = DB::table('tuitions')
        ->select(
            'tuitions.id as id'
            , 'tuitions.code as code'
            , 'tuitions.name as name'
            , 'tuitions.price as price'
            , 'tuitions.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'tuitions.users_id')
        ->where("tuitions.name", "LIKE", "%{$typing}%")
        ->orWhere("tuitions.code", "LIKE", "%{$typing}%")
        ->orderBy('tuitions.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getTuitionPagination()
    {
        $data = DB::table('tuitions')
        ->select(
            'tuitions.id as id'
            , 'tuitions.code as code'
            , 'tuitions.name as name'
            , 'tuitions.price as price'
            , 'tuitions.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'tuitions.users_id')
        ->orderBy('tuitions.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getTuitionById($id)
    {
        $data = DB::table('tuitions')
        ->select(
            'tuitions.id as id'
            , 'tuitions.code as code'
            , 'tuitions.name as name'
            , 'tuitions.price as price'
            , 'tuitions.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'tuitions.users_id')
        ->where('tuitions.id', $id)
        ->get();

        return $data;
    }

    public function searchTuition($typing)
    {
        $data = DB::table('tuitions')
        ->select(
            'tuitions.id as id'
            , 'tuitions.code as code'
            , 'tuitions.name as name'
            , 'tuitions.price as price'
            , 'tuitions.status as status'
        )
        ->where("tuitions.status", 'A')
        ->where("tuitions.name", "LIKE", "%{$typing}%")
        ->orderBy('tuitions.id', 'desc')
        ->paginate(10);

        return $data;
    }
}
