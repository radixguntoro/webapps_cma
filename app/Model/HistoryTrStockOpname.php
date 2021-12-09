<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryTrStockOpname extends Model
{
    protected $table = 'history_tr_stock_opname';
    public function getHistoryTrStockOpnameBySearch($typing)
    {
        $data = DB::table('history_tr_stock_opname')
            ->select(
                'history_tr_stock_opname.id as id'
                , 'history_tr_stock_opname.date as date'
                , 'history_tr_stock_opname.time as time'
                , 'history_tr_stock_opname.created_at as created_at'
                , 'history_tr_stock_opname.action as action'
                , 'history_tr_stock_opname.tr_stock_opname_id as stock_opname_id'
                , 'history_tr_stock_opname.users_id as users_id'
                , 'tr_stock_opname.code as code'
                , 'users.name as name'
            )
            ->join('users', 'users.id', '=', 'history_tr_stock_opname.users_id')
            ->join('tr_stock_opname', 'tr_stock_opname.id', '=', 'history_tr_stock_opname.tr_stock_opname_id')
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orderBy('history_tr_stock_opname.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getHistoryTrStockOpnameByFilter($datestart, $dateend)
    {
        $data = DB::table('history_tr_stock_opname')
            ->select(
                'history_tr_stock_opname.id as id'
                , 'history_tr_stock_opname.date as date'
                , 'history_tr_stock_opname.time as time'
                , 'history_tr_stock_opname.created_at as created_at'
                , 'history_tr_stock_opname.action as action'
                , 'history_tr_stock_opname.tr_stock_opname_id as stock_opname_id'
                , 'history_tr_stock_opname.users_id as users_id'
                , 'tr_stock_opname.code as code'
                , 'users.name as name'
            )
            ->join('users', 'users.id', '=', 'history_tr_stock_opname.users_id')
            ->join('tr_stock_opname', 'tr_stock_opname.id', '=', 'history_tr_stock_opname.tr_stock_opname_id')
            ->whereBetween('history_tr_stock_opname.date', [$datestart, $dateend])
            ->orderBy('history_tr_stock_opname.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getHistoryTrStockOpnamePagination()
    {
        $data = DB::table('history_tr_stock_opname')
            ->select(
                'history_tr_stock_opname.id as id'
                , 'history_tr_stock_opname.date as date'
                , 'history_tr_stock_opname.time as time'
                , 'history_tr_stock_opname.created_at as created_at'
                , 'history_tr_stock_opname.action as action'
                , 'history_tr_stock_opname.tr_stock_opname_id as stock_opname_id'
                , 'history_tr_stock_opname.users_id as users_id'
                , 'tr_stock_opname.code as code'
                , 'users.name as name'
            )
            ->join('users', 'users.id', '=', 'history_tr_stock_opname.users_id')
            ->join('tr_stock_opname', 'tr_stock_opname.id', '=', 'history_tr_stock_opname.tr_stock_opname_id')
            ->orderBy('history_tr_stock_opname.id', 'desc')
            ->paginate(25);

        return $data;
    }
}
