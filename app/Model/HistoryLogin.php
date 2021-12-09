<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryLogin extends Model
{
    protected $table = 'history_login';
    public function getHistoryLoginBySearch($typing)
    {
        $data = DB::table('history_login')
            ->select(
                'history_login.id as id'
                , 'history_login.date as date'
                , 'history_login.time as time'
                , 'history_login.action as action'
                , 'history_login.users_id as users_id'
                , 'users.name as name'
            )
            ->join('users', 'users.id', '=', 'history_login.users_id')
            ->where("users.first_name", "LIKE", "%{$typing}%")
            ->orWhere("users.last_name", "LIKE", "%{$typing}%")
            ->orderBy('history_login.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getHistoryLoginByFilter($datestart, $dateend)
    {
        $data = DB::table('history_login')
            ->select(
                'history_login.id as id'
                , 'history_login.date as date'
                , 'history_login.time as time'
                , 'history_login.action as action'
                , 'history_login.users_id as users_id'
                , 'users.name as name'
            )
            ->join('users', 'users.id', '=', 'history_login.users_id')
            ->whereBetween('history_login.date', [$datestart, $dateend])
            ->orderBy('history_login.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getHistoryLoginPagination()
    {
        $data = DB::table('history_login')
            ->select(
                'history_login.id as id'
                , 'history_login.date as date'
                , 'history_login.time as time'
                , 'history_login.action as action'
                , 'history_login.users_id as users_id'
                , 'users.name as name'
            )
            ->join('users', 'users.id', '=', 'history_login.users_id')
            ->orderBy('history_login.id', 'desc')
            ->paginate(25);

        return $data;
    }
}
