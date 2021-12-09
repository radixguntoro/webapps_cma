<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class TrPurchaseOrderStampDetails extends Model
{
    protected $table = 'tr_purchase_order_stamp_details';

    public $timestamps = false;

    public function getDataTransactionPurchasesDetail($id) {
        $data = DB::table('tr_purchase_order_stamp_details')
        ->select(
            'tr_purchase_order_stamp_details.id as id'
            , 'tr_purchase_order_stamp_details.stamp_id as stamp_id'
            , 'tr_purchase_order_stamp_details.discount as discount'
            , 'tr_purchase_order_stamp_details.percent_profit_per_box as percent_profit_per_box'
            , 'tr_purchase_order_stamp_details.percent_profit_per_strip as percent_profit_per_strip'
            , 'tr_purchase_order_stamp_details.percent_profit_per_tablet as percent_profit_per_tablet'
            , 'tr_purchase_order_stamp_details.ppn as ppn'
            , 'tr_purchase_order_stamp_details.price_discount as price_discount'
            , 'tr_purchase_order_stamp_details.price_discount as price_first'
            , 'tr_purchase_order_stamp_details.price_purchase_per_box as price_purchase_per_box'
            , 'tr_purchase_order_stamp_details.price_purchase_per_strip as price_purchase_per_strip'
            , 'tr_purchase_order_stamp_details.price_purchase_per_tablet as price_purchase_per_tablet'
            , 'tr_purchase_order_stamp_details.price_sell as price_sell'
            , 'tr_purchase_order_stamp_details.price_sell as price'
            , 'tr_purchase_order_stamp_details.price_sell_per_box as price_sell_per_box'
            , 'tr_purchase_order_stamp_details.price_sell_per_strip as price_sell_per_strip'
            , 'tr_purchase_order_stamp_details.price_sell_per_tablet as price_sell_per_tablet'
            , 'tr_purchase_order_stamp_details.qty as qty'
            , 'tr_purchase_order_stamp_details.qty_in_tablet as qty_total'
            , 'tr_purchase_order_stamp_details.subtotal as subtotal'
            , 'tr_purchase_order_stamp_details.subtotal as price_last'
            , 'tr_purchase_order_stamp_details.transaction_purchases_id as transaction_purchases_id'
            , 'tr_purchase_order_stamp_details.unit as unit'
            , 'stamps.name as name'
            , 'stamps.price_sell_per_box as stamp_price_sell_per_box'
            , 'stamps.price_sell_per_strip as stamp_price_sell_per_strip'
            , 'stamps.price_sell_per_tablet as stamp_price_sell_per_tablet'
            , 'stamps.percent_profit_per_box as stamp_percent_profit_per_box'
            , 'stamps.percent_profit_per_strip as stamp_percent_profit_per_strip'
            , 'stamps.percent_profit_per_tablet as stamp_percent_profit_per_tablet'
            , 'stamps.price_purchase_per_box as stamp_price_purchase_per_box'
            , 'stamps.price_purchase_per_strip as stamp_price_purchase_per_strip'
            , 'stamps.price_purchase_per_tablet as stamp_price_purchase_per_tablet'
            , 'stamps.qty_in_box as qty_in_box'
            , 'stamps.qty_in_strip as qty_in_strip'
            , 'stamps.qty_in_tablet as qty_in_tablet'
        )
        ->join('stamps', 'stamps.id', '=', 'tr_purchase_order_stamp_details.stamp_id')
        ->where('tr_purchase_order_stamp_details.transaction_purchases_id', $id)
        ->get();

        return $data;
    }
}
