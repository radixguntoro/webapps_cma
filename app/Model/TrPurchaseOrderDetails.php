<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class TrPurchaseOrderDetails extends Model
{
    protected $table = 'tr_purchase_order_details';

    public $timestamps = false;

    public function getDataTransactionPurchasesDetail($id) {
        $data = DB::table('tr_purchase_order_details')
        ->select(
            'tr_purchase_order_details.id as id'
            , 'tr_purchase_order_details.item_id as item_id'
            , 'tr_purchase_order_details.discount as discount'
            , 'tr_purchase_order_details.percent_profit_per_box as percent_profit_per_box'
            , 'tr_purchase_order_details.percent_profit_per_strip as percent_profit_per_strip'
            , 'tr_purchase_order_details.percent_profit_per_tablet as percent_profit_per_tablet'
            , 'tr_purchase_order_details.ppn as ppn'
            , 'tr_purchase_order_details.price_discount as price_discount'
            , 'tr_purchase_order_details.price_discount as price_first'
            , 'tr_purchase_order_details.price_purchase_per_box as price_purchase_per_box'
            , 'tr_purchase_order_details.price_purchase_per_strip as price_purchase_per_strip'
            , 'tr_purchase_order_details.price_purchase_per_tablet as price_purchase_per_tablet'
            , 'tr_purchase_order_details.price_sell as price_sell'
            , 'tr_purchase_order_details.price_sell as price'
            , 'tr_purchase_order_details.price_sell_per_box as price_sell_per_box'
            , 'tr_purchase_order_details.price_sell_per_strip as price_sell_per_strip'
            , 'tr_purchase_order_details.price_sell_per_tablet as price_sell_per_tablet'
            , 'tr_purchase_order_details.qty as qty'
            , 'tr_purchase_order_details.qty_in_tablet as qty_total'
            , 'tr_purchase_order_details.subtotal as subtotal'
            , 'tr_purchase_order_details.subtotal as price_last'
            , 'tr_purchase_order_details.transaction_purchases_id as transaction_purchases_id'
            , 'tr_purchase_order_details.unit as unit'
            , 'items.name as name'
            , 'items.price_sell_per_box as item_price_sell_per_box'
            , 'items.price_sell_per_strip as item_price_sell_per_strip'
            , 'items.price_sell_per_tablet as item_price_sell_per_tablet'
            , 'items.percent_profit_per_box as item_percent_profit_per_box'
            , 'items.percent_profit_per_strip as item_percent_profit_per_strip'
            , 'items.percent_profit_per_tablet as item_percent_profit_per_tablet'
            , 'items.price_purchase_per_box as item_price_purchase_per_box'
            , 'items.price_purchase_per_strip as item_price_purchase_per_strip'
            , 'items.price_purchase_per_tablet as item_price_purchase_per_tablet'
            , 'items.qty_in_box as qty_in_box'
            , 'items.qty_in_strip as qty_in_strip'
            , 'items.qty_in_tablet as qty_in_tablet'
        )
        ->join('items', 'items.id', '=', 'tr_purchase_order_details.item_id')
        ->where('tr_purchase_order_details.transaction_purchases_id', $id)
        ->get();

        return $data;
    }
}
