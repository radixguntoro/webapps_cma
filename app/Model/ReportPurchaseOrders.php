<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\TrPurchaseOrders;
use App\Model\Item;
use DB;

class ReportPurchaseOrders extends Model
{
    protected $table = 'tr_purchase_orders';

    public function getReportPurchaseOrdersByFilter($datestart, $dateend)
    {
        $data = TrPurchaseOrders::select(
            'tr_purchase_orders.id as id'
            , 'tr_purchase_orders.invoice as invoice'
            , 'tr_purchase_orders.date as date'
            , 'tr_purchase_orders.note as note'
            , 'tr_purchase_order_details.id as detail_id'
            , 'tr_purchase_order_details.qty as qty'
            , 'tr_purchase_order_details.qty_bonus as qty_bonus'
            , 'tr_purchase_order_details.price_sell as price_sell'
            , 'tr_purchase_order_details.price_buy as price_buy'
            , 'tr_purchase_order_details.discount as discount'
            , 'tr_purchase_order_details.subtotal as subtotal'
            , 'items.name as item_name'
            , 'categories.name as category'
            , 'users.name as admin'
        )
        ->join('tr_purchase_order_details', 'tr_purchase_order_details.tr_purchase_orders_id', '=', 'tr_purchase_orders.id')
        ->join('items', 'items.id', '=', 'tr_purchase_order_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->join('users', 'users.id', '=', 'tr_purchase_orders.users_id')
        ->whereBetween('tr_purchase_orders.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_orders.invoice', 'asc')
        ->get();
        return $data;
    }

    public function getExcelPurchaseOrdersByFilter($datestart, $dateend)
    {
        $data = TrPurchaseOrders::select(
            'tr_purchase_orders.id as id'
            , 'tr_purchase_orders.invoice as invoice'
            , 'tr_purchase_orders.date as date'
            , 'tr_purchase_orders.note as note'
            , 'tr_purchase_order_details.id as detail_id'
            , 'tr_purchase_order_details.qty as qty'
            , 'tr_purchase_order_details.qty_bonus as qty_bonus'
            , 'tr_purchase_order_details.price_sell as price_sell'
            , 'tr_purchase_order_details.price_buy as price_buy'
            , 'tr_purchase_order_details.discount as discount'
            , 'tr_purchase_order_details.subtotal as subtotal'
            , 'items.name as item_name'
            , 'categories.name as category'
            , 'users.name as admin'
        )
        ->join('tr_purchase_order_details', 'tr_purchase_order_details.tr_purchase_orders_id', '=', 'tr_purchase_orders.id')
        ->join('items', 'items.id', '=', 'tr_purchase_order_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->join('users', 'users.id', '=', 'tr_purchase_orders.users_id')
        ->whereBetween('tr_purchase_orders.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_orders.invoice', 'asc')
        ->get();

        return $data;
    }
}
