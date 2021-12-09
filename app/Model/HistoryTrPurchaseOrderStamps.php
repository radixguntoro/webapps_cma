<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryTrPurchaseOrderStamps extends Model
{
    protected $table = 'history_tr_purchase_order_stamps';
    public function getHistoryTrPurchaseOrderStampsBySearch($typing)
    {
        $data = DB::table('history_tr_purchase_order_stamps')
            ->select(
                'history_tr_purchase_order_stamps.id as id'
                , 'history_tr_purchase_order_stamps.date as date'
                , 'history_tr_purchase_order_stamps.time as time'
                , 'history_tr_purchase_order_stamps.created_at as created_at'
                , 'history_tr_purchase_order_stamps.action as action'
                , 'history_tr_purchase_order_stamps.tr_purchase_order_stamps_id as tr_purchase_order_stamps_id'
                , 'history_tr_purchase_order_stamps.users_id as users_id'
                , 'users.name as name'
                , 'tr_purchase_order_stamps.id as id'
                , 'tr_purchase_order_stamps.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_purchase_order_stamps.users_id')
            ->join('tr_purchase_order_stamps', 'tr_purchase_order_stamps.id', '=', 'history_tr_purchase_order_stamps.tr_purchase_order_stamps_id')
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orderBy('history_tr_purchase_order_stamps.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getHistoryTrPurchaseOrderStampsByFilter($datestart, $dateend)
    {
        $data = DB::table('history_tr_purchase_order_stamps')
            ->select(
                'history_tr_purchase_order_stamps.id as id'
                , 'history_tr_purchase_order_stamps.date as date'
                , 'history_tr_purchase_order_stamps.time as time'
                , 'history_tr_purchase_order_stamps.created_at as created_at'
                , 'history_tr_purchase_order_stamps.action as action'
                , 'history_tr_purchase_order_stamps.tr_purchase_order_stamps_id as tr_purchase_order_stamps_id'
                , 'history_tr_purchase_order_stamps.users_id as users_id'
                , 'users.name as name'
                , 'tr_purchase_order_stamps.id as id'
                , 'tr_purchase_order_stamps.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_purchase_order_stamps.users_id')
            ->join('tr_purchase_order_stamps', 'tr_purchase_order_stamps.id', '=', 'history_tr_purchase_order_stamps.tr_purchase_order_stamps_id')
            ->whereBetween('history_tr_purchase_order_stamps.date', [$datestart, $dateend])
            ->orderBy('history_tr_purchase_order_stamps.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getHistoryTrPurchaseOrderStampsPagination()
    {
        $data = DB::table('history_tr_purchase_order_stamps')
            ->select(
                'history_tr_purchase_order_stamps.id as id'
                , 'history_tr_purchase_order_stamps.date as date'
                , 'history_tr_purchase_order_stamps.time as time'
                , 'history_tr_purchase_order_stamps.created_at as created_at'
                , 'history_tr_purchase_order_stamps.action as action'
                , 'history_tr_purchase_order_stamps.tr_purchase_order_stamps_id as tr_purchase_order_stamps_id'
                , 'history_tr_purchase_order_stamps.users_id as users_id'
                , 'users.name as name'
                , 'tr_purchase_order_stamps.id as id'
                , 'tr_purchase_order_stamps.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_purchase_order_stamps.users_id')
            ->join('tr_purchase_order_stamps', 'tr_purchase_order_stamps.id', '=', 'history_tr_purchase_order_stamps.tr_purchase_order_stamps_id')
            ->orderBy('history_tr_purchase_order_stamps.id', 'desc')
            ->paginate(25);

        return $data;
    }
}
