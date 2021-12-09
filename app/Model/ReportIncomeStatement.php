<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\TrPayments;
use App\Model\TrPaymentsTuitionDetail;
use App\Model\TrPaymentsItemDetail;
use App\Model\TrPaymentsDepositDetail;
use App\Model\TrPurchaseOrders;
use App\Model\TrPurchaseOrderDetails;
use App\Model\TrPurchaseOrderStamps;
use App\Model\TrPurchaseOrderStampDetails;
use App\Model\TrStockOpname;
use DB;

class ReportIncomeStatement extends Model
{
    public function getReportIncomeStatementTuitionByFilter($datestart, $dateend)
    {
        $data = DB::table('tr_payment_tuition_details')
        ->select(
            'tr_payment_tuition_details.subtotal as subtotal'
        )
        ->join('tr_payments', 'tr_payments.id', '=', 'tr_payment_tuition_details.tr_payments_id')
        ->whereBetween('tr_payments.date', [$datestart, $dateend])
        ->orderBy('tr_payments.date', 'desc')
        ->get();
        return $data;
    }

    public function getReportIncomeStatementItemByFilter($datestart, $dateend)
    {
        $data = DB::table('tr_payment_item_details')
        ->select(
            'tr_payment_item_details.subtotal as subtotal'
            , 'categories.name as category'
        )
        ->join('tr_payments', 'tr_payments.id', '=', 'tr_payment_item_details.tr_payments_id')
        ->join('items', 'items.id', '=', 'tr_payment_item_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->whereBetween('tr_payments.date', [$datestart, $dateend])
        ->orderBy('tr_payments.date', 'desc')
        ->get();
        return $data;
    }

    public function getReportIncomeStatementDepositByFilter($datestart, $dateend)
    {
        $data = DB::table('tr_payment_deposit_details')
        ->select(
            'tr_payment_deposit_details.subtotal as subtotal'
        )
        ->join('tr_payments', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
        ->whereBetween('tr_payments.date', [$datestart, $dateend])
        ->orderBy('tr_payments.date', 'desc')
        ->get();
        return $data;
    }

    public function getReportIncomeStatementPOIByFilter($datestart, $dateend)
    {
        $data = DB::table('tr_purchase_order_details')
        ->select(
            'tr_purchase_order_details.subtotal as subtotal'
        )
        ->join('tr_purchase_orders', 'tr_purchase_orders.id', '=', 'tr_purchase_order_details.tr_purchase_orders_id')
        ->whereBetween('tr_purchase_orders.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_orders.date', 'desc')
        ->get();
        return $data;
    }

    public function getReportIncomeStatementPORByFilter($datestart, $dateend)
    {
        $data = DB::table('tr_purchase_order_stamp_details')
        ->select(
            'tr_purchase_order_stamp_details.subtotal as subtotal'
        )
        ->join('tr_purchase_order_stamps', 'tr_purchase_order_stamps.id', '=', 'tr_purchase_order_stamp_details.tr_purchase_order_stamps_id')
        ->whereBetween('tr_purchase_order_stamps.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_order_stamps.date', 'desc')
        ->get();
        return $data;
    }

    public function getReportIncomeStatementSOIByFilter($datestart, $dateend)
    {
        $data = DB::table('tr_stock_opname')
        ->select(
            'tr_stock_opname.price_sell_difference as price_sell_difference'
        )
        ->join('items', 'items.code', '=', 'tr_stock_opname.items_code')
        ->whereBetween('tr_stock_opname.date', [$datestart, $dateend])
        ->orderBy('tr_stock_opname.date', 'desc')
        ->get();
        return $data;
    }

    public function getReportIncomeStatementSORByFilter($datestart, $dateend)
    {
        $data = DB::table('tr_stock_opname')
        ->select(
            'tr_stock_opname.price_sell_difference as price_sell_difference'
        )
        ->join('stamps', 'stamps.code', '=', 'tr_stock_opname.items_code')
        ->whereBetween('tr_stock_opname.date', [$datestart, $dateend])
        ->orderBy('tr_stock_opname.date', 'desc')
        ->get();
        return $data;
    }

    //EXPORT EXCEL
    public function exportExcelIncomeStatementTuitionByFilter($datestart, $dateend)
    {
        $data = TrPaymentsTuitionDetail::select(
            'tr_payment_tuition_details.subtotal as subtotal'
        )
        ->join('tr_payments', 'tr_payments.id', '=', 'tr_payment_tuition_details.tr_payments_id')
        ->whereBetween('tr_payments.date', [$datestart, $dateend])
        ->orderBy('tr_payments.date', 'desc')
        ->get();
        return $data;
    }

    public function exportExcelIncomeStatementItemByFilter($datestart, $dateend)
    {
        $data = TrPaymentsItemDetail::select(
            'tr_payment_item_details.subtotal as subtotal'
            , 'categories.name as category'
        )
        ->join('tr_payments', 'tr_payments.id', '=', 'tr_payment_item_details.tr_payments_id')
        ->join('items', 'items.id', '=', 'tr_payment_item_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->whereBetween('tr_payments.date', [$datestart, $dateend])
        ->orderBy('tr_payments.date', 'desc')
        ->get();
        return $data;
    }

    public function exportExcelIncomeStatementDepositByFilter($datestart, $dateend)
    {
        $data =TrPaymentsDepositDetail::select(
            'tr_payment_deposit_details.subtotal as subtotal'
        )
        ->join('tr_payments', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
        ->whereBetween('tr_payments.date', [$datestart, $dateend])
        ->orderBy('tr_payments.date', 'desc')
        ->get();
        return $data;
    }

    public function exportExcelIncomeStatementPOIByFilter($datestart, $dateend)
    {
        $data = TrPurchaseOrderDetails::select(
            'tr_purchase_order_details.subtotal as subtotal'
        )
        ->join('tr_purchase_orders', 'tr_purchase_orders.id', '=', 'tr_purchase_order_details.tr_purchase_orders_id')
        ->whereBetween('tr_purchase_orders.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_orders.date', 'desc')
        ->get();
        return $data;
    }

    public function exportExcelIncomeStatementPORByFilter($datestart, $dateend)
    {
        $data = TrPurchaseOrderStampDetails::select(
            'tr_purchase_order_stamp_details.subtotal as subtotal'
        )
        ->join('tr_purchase_order_stamps', 'tr_purchase_order_stamps.id', '=', 'tr_purchase_order_stamp_details.tr_purchase_order_stamps_id')
        ->whereBetween('tr_purchase_order_stamps.date', [$datestart, $dateend])
        ->orderBy('tr_purchase_order_stamps.date', 'desc')
        ->get();
        return $data;
    }

    public function exportExcelIncomeStatementSOIByFilter($datestart, $dateend)
    {
        $data = TrStockOpname::select(
            'tr_stock_opname.price_sell_difference as price_sell_difference'
        )
        ->join('items', 'items.code', '=', 'tr_stock_opname.items_code')
        ->whereBetween('tr_stock_opname.date', [$datestart, $dateend])
        ->orderBy('tr_stock_opname.date', 'desc')
        ->get();
        return $data;
    }

    public function exportExcelIncomeStatementSORByFilter($datestart, $dateend)
    {
        $data = TrStockOpname::select(
            'tr_stock_opname.price_sell_difference as price_sell_difference'
        )
        ->join('stamps', 'stamps.code', '=', 'tr_stock_opname.items_code')
        ->whereBetween('tr_stock_opname.date', [$datestart, $dateend])
        ->orderBy('tr_stock_opname.date', 'desc')
        ->get();
        return $data;
    }
}
