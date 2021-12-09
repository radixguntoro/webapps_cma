<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryTrPurchaseOrders extends Model
{
    protected $table = 'history_tr_purchase_orders';
    public function getHistoryTrPurchaseOrdersBySearch($typing)
    {
        $data = DB::table('history_tr_purchase_orders')
            ->select(
                'history_tr_purchase_orders.id as id'
                , 'history_tr_purchase_orders.date as date'
                , 'history_tr_purchase_orders.time as time'
                , 'history_tr_purchase_orders.created_at as created_at'
                , 'history_tr_purchase_orders.action as action'
                , 'history_tr_purchase_orders.tr_purchase_orders_id as tr_purchase_orders_id'
                , 'history_tr_purchase_orders.users_id as users_id'
                , 'users.name as name'
                , 'tr_purchase_orders.id as id'
                , 'tr_purchase_orders.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_purchase_orders.users_id')
            ->join('tr_purchase_orders', 'tr_purchase_orders.id', '=', 'history_tr_purchase_orders.tr_purchase_orders_id')
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orderBy('history_tr_purchase_orders.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getHistoryTrPurchaseOrdersByFilter($datestart, $dateend)
    {
        $data = DB::table('history_tr_purchase_orders')
            ->select(
                'history_tr_purchase_orders.id as id'
                , 'history_tr_purchase_orders.date as date'
                , 'history_tr_purchase_orders.time as time'
                , 'history_tr_purchase_orders.created_at as created_at'
                , 'history_tr_purchase_orders.action as action'
                , 'history_tr_purchase_orders.tr_purchase_orders_id as tr_purchase_orders_id'
                , 'history_tr_purchase_orders.users_id as users_id'
                , 'users.name as name'
                , 'tr_purchase_orders.id as id'
                , 'tr_purchase_orders.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_purchase_orders.users_id')
            ->join('tr_purchase_orders', 'tr_purchase_orders.id', '=', 'history_tr_purchase_orders.tr_purchase_orders_id')
            ->whereBetween('history_tr_purchase_orders.date', [$datestart, $dateend])
            ->orderBy('history_tr_purchase_orders.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getHistoryTrPurchaseOrdersPagination()
    {
        $data = DB::table('history_tr_purchase_orders')
            ->select(
                'history_tr_purchase_orders.id as id'
                , 'history_tr_purchase_orders.date as date'
                , 'history_tr_purchase_orders.time as time'
                , 'history_tr_purchase_orders.created_at as created_at'
                , 'history_tr_purchase_orders.action as action'
                , 'history_tr_purchase_orders.tr_purchase_orders_id as tr_purchase_orders_id'
                , 'history_tr_purchase_orders.users_id as users_id'
                , 'users.name as name'
                , 'tr_purchase_orders.id as id'
                , 'tr_purchase_orders.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_purchase_orders.users_id')
            ->join('tr_purchase_orders', 'tr_purchase_orders.id', '=', 'history_tr_purchase_orders.tr_purchase_orders_id')
            ->orderBy('history_tr_purchase_orders.id', 'desc')
            ->paginate(25);

        return $data;
    }
}
