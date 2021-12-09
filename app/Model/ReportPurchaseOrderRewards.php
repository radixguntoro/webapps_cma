<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\TrPurchaseOrderRewards;
use App\Model\Stamp;
use DB;

class ReportPurchaseOrderRewards extends Model
{
    protected $table = 'tr_purchase_order_stamps';

    public function getReportPurchaseOrderRewardsByFilter($datestart, $dateend)
    {
        $data = TrPurchaseOrderStamps::select(
            'tr_purchase_order_stamps.id as id'
            , 'tr_purchase_order_stamps.invoice as invoice'
            , 'tr_purchase_order_stamps.date as date'
            , 'tr_purchase_order_stamps.note as note'
            , 'tr_purchase_order_stamp_details.id as detail_id'
            , 'tr_purchase_order_stamp_details.qty as qty'
            , 'tr_purchase_order_stamp_details.price_buy as price_buy'
            , 'tr_purchase_order_stamp_details.discount as discount'
            , 'tr_purchase_order_stamp_details.subtotal as subtotal'
            , 'stamps.name as item_name'
            , 'users.name as admin'
        )
        ->join('tr_purchase_order_stamp_details', 'tr_purchase_order_stamp_details.tr_purchase_order_stamps_id', '=', 'tr_purchase_order_stamps.id')
        ->join('stamps', 'stamps.id', '=', 'tr_purchase_order_stamp_details.stamps_id')
        ->join('users', 'users.id', '=', 'tr_purchase_order_stamps.users_id')
        ->whereBetween('tr_purchase_order_stamps.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_order_stamps.invoice', 'asc')
        ->get();
        return $data;
    }

    public function getExcelPurchaseOrderRewardsByFilter($datestart, $dateend)
    {
        $data = TrPurchaseOrderStamps::select(
            'tr_purchase_order_stamps.id as id'
            , 'tr_purchase_order_stamps.invoice as invoice'
            , 'tr_purchase_order_stamps.date as date'
            , 'tr_purchase_order_stamps.note as note'
            , 'tr_purchase_order_stamp_details.id as detail_id'
            , 'tr_purchase_order_stamp_details.qty as qty'
            , 'tr_purchase_order_stamp_details.price_buy as price_buy'
            , 'tr_purchase_order_stamp_details.discount as discount'
            , 'tr_purchase_order_stamp_details.subtotal as subtotal'
            , 'stamps.name as item_name'
            , 'users.name as admin'
        )
        ->join('tr_purchase_order_stamp_details', 'tr_purchase_order_stamp_details.tr_purchase_order_stamps_id', '=', 'tr_purchase_order_stamps.id')
        ->join('stamps', 'stamps.id', '=', 'tr_purchase_order_stamp_details.stamps_id')
        ->join('users', 'users.id', '=', 'tr_purchase_order_stamps.users_id')
        ->whereBetween('tr_purchase_order_stamps.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_order_stamps.invoice', 'asc')
        ->get();

        return $data;
    }
}
