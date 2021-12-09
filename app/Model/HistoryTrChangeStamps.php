<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryTrChangeStamps extends Model
{
    protected $table = 'history_tr_change_stamps';
    public function getHistoryTrChangeStampsBySearch($typing)
    {
        $data = DB::table('history_tr_change_stamps')
            ->select(
                'history_tr_change_stamps.id as id'
                , 'history_tr_change_stamps.date as date'
                , 'history_tr_change_stamps.time as time'
                , 'history_tr_change_stamps.created_at as created_at'
                , 'history_tr_change_stamps.action as action'
                , 'history_tr_change_stamps.tr_change_stamps_id as tr_change_stamps_id'
                , 'history_tr_change_stamps.users_id as users_id'
                , 'users.name as name'
                , 'tr_change_stamps.id as id'
            )
            ->join('users', 'users.id', '=', 'history_tr_change_stamps.users_id')
            ->join('tr_change_stamps', 'tr_change_stamps.id', '=', 'history_tr_change_stamps.tr_change_stamps_id')
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orWhere("users.last_name", "LIKE", "%{$typing}%")
            ->orderBy('history_tr_change_stamps.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getHistoryTrChangeStampsByFilter($datestart, $dateend)
    {
        $data = DB::table('history_tr_change_stamps')
            ->select(
                'history_tr_change_stamps.id as id'
                , 'history_tr_change_stamps.date as date'
                , 'history_tr_change_stamps.time as time'
                , 'history_tr_change_stamps.created_at as created_at'
                , 'history_tr_change_stamps.action as action'
                , 'history_tr_change_stamps.tr_change_stamps_id as tr_change_stamps_id'
                , 'history_tr_change_stamps.users_id as users_id'
                , 'users.name as name'
                , 'tr_change_stamps.id as id'
            )
            ->join('users', 'users.id', '=', 'history_tr_change_stamps.users_id')
            ->join('tr_change_stamps', 'tr_change_stamps.id', '=', 'history_tr_change_stamps.tr_change_stamps_id')
            ->whereBetween('history_tr_change_stamps.date', [$datestart, $dateend])
            ->orderBy('history_tr_change_stamps.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getHistoryTrChangeStampsPagination()
    {
        $data = DB::table('history_tr_change_stamps')
            ->select(
                'history_tr_change_stamps.id as id'
                , 'history_tr_change_stamps.date as date'
                , 'history_tr_change_stamps.time as time'
                , 'history_tr_change_stamps.created_at as created_at'
                , 'history_tr_change_stamps.action as action'
                , 'history_tr_change_stamps.tr_change_stamps_id as tr_change_stamps_id'
                , 'history_tr_change_stamps.users_id as users_id'
                , 'users.name as name'
                , 'tr_change_stamps.id as id'
            )
            ->join('users', 'users.id', '=', 'history_tr_change_stamps.users_id')
            ->join('tr_change_stamps', 'tr_change_stamps.id', '=', 'history_tr_change_stamps.tr_change_stamps_id')
            ->orderBy('history_tr_change_stamps.id', 'desc')
            ->paginate(25);

        return $data;
    }
}
