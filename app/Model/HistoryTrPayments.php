<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryTrPayments extends Model
{
    protected $table = 'history_tr_payments';
    public function getHistoryTrPaymentsBySearch($typing)
    {
        $data = DB::table('history_tr_payments')
            ->select(
                'history_tr_payments.id as id'
                , 'history_tr_payments.date as date'
                , 'history_tr_payments.time as time'
                , 'history_tr_payments.created_at as created_at'
                , 'history_tr_payments.action as action'
                , 'history_tr_payments.tr_payments_id as tr_payments_id'
                , 'history_tr_payments.users_id as users_id'
                , 'users.name as name'
                , 'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_payments.users_id')
            ->join('tr_payments', 'tr_payments.id', '=', 'history_tr_payments.tr_payments_id')
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orWhere("users.last_name", "LIKE", "%{$typing}%")
            ->orderBy('history_tr_payments.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getHistoryTrPaymentsByFilter($datestart, $dateend)
    {
        $data = DB::table('history_tr_payments')
            ->select(
                'history_tr_payments.id as id'
                , 'history_tr_payments.date as date'
                , 'history_tr_payments.time as time'
                , 'history_tr_payments.created_at as created_at'
                , 'history_tr_payments.action as action'
                , 'history_tr_payments.tr_payments_id as tr_payments_id'
                , 'history_tr_payments.users_id as users_id'
                , 'users.name as name'
                , 'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_payments.users_id')
            ->join('tr_payments', 'tr_payments.id', '=', 'history_tr_payments.tr_payments_id')
            ->whereBetween('history_tr_payments.date', [$datestart, $dateend])
            ->orderBy('history_tr_payments.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getHistoryTrPaymentsPagination()
    {
        $data = DB::table('history_tr_payments')
            ->select(
                'history_tr_payments.id as id'
                , 'history_tr_payments.date as date'
                , 'history_tr_payments.time as time'
                , 'history_tr_payments.created_at as created_at'
                , 'history_tr_payments.action as action'
                , 'history_tr_payments.tr_payments_id as tr_payments_id'
                , 'history_tr_payments.users_id as users_id'
                , 'users.name as name'
                , 'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
            )
            ->join('users', 'users.id', '=', 'history_tr_payments.users_id')
            ->join('tr_payments', 'tr_payments.id', '=', 'history_tr_payments.tr_payments_id')
            ->orderBy('history_tr_payments.id', 'desc')
            ->paginate(25);

        return $data;
    }
}
