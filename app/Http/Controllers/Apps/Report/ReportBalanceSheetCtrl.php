<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportBalanceSheet;
use Validator;
use Excel;
use DB;

class ReportBalanceSheetCtrl extends Controller
{
    public function index()
    {
        $model_dashboard = new ReportBalanceSheet();

        // Data Reward
        $data_reward_active = $model_dashboard->getDataRewardActive();
        $data_reward_nonactive = $model_dashboard->getDataRewardNonActive();

        $getBuyingPriceRewardActive = 0;
        foreach ($data_reward_active as $key_report => $val) {
            $getBuyingPriceRewardActive += ($val->qty * $val->price);
        };

        $getBuyingPriceRewardNonActive = 0;
        foreach ($data_reward_nonactive as $key_report => $val) {
            $getBuyingPriceRewardNonActive += ($val->qty * $val->price);
        };

        // Data Voucher
        $data_voucher_active = $model_dashboard->getDataVoucherActive();
        $data_voucher_nonactive = $model_dashboard->getDataVoucherNonActive();

        $getValueVoucherActive = 0;
        foreach ($data_voucher_active as $key_report => $val) {
            $getValueVoucherActive += ($val->qty * $val->price);
        };

        $getValueVoucherNonActive = 0;
        foreach ($data_voucher_nonactive as $key_report => $val) {
            $getValueVoucherNonActive += ($val->qty * $val->price);
        };

        // Data Payment
        $data_inventory = $model_dashboard->getDataInventory();

        $getInventoryBookSellingPriceActive = 0;
        $getInventoryBookBuyingPriceActive = 0;
        $getInventoryBookQtyActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Books' && $val->status == 'A') {
                $getInventoryBookQtyActive += count($val);
                $getInventoryBookSellingPriceActive += ($val->qty * $val->price_sell);
                $getInventoryBookBuyingPriceActive += ($val->qty * $val->price_buy);
            }
        };

        $getInventoryBookSellingPriceNonActive = 0;
        $getInventoryBookBuyingPriceNonActive = 0;
        $getInventoryBookQtyNonActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Books' && $val->status == 'N') {
                $getInventoryBookQtyNonActive += count($val);
                $getInventoryBookSellingPriceNonActive += ($val->qty * $val->price_sell);
                $getInventoryBookBuyingPriceNonActive += ($val->qty * $val->price_buy);
            }
        };

        $getInventoryAccessorySellingPriceActive = 0;
        $getInventoryAccessoryBuyingPriceActive = 0;
        $getInventoryAccessoryQtyActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Accessory' && $val->status == 'A') {
                $getInventoryAccessoryQtyActive += count($val);
                $getInventoryAccessorySellingPriceActive += ($val->qty * $val->price_sell);
                $getInventoryAccessoryBuyingPriceActive += ($val->qty * $val->price_buy);
            }
        };

        $getInventoryAccessorySellingPriceNonActive = 0;
        $getInventoryAccessoryBuyingPriceNonActive = 0;
        $getInventoryAccessoryQtyNonActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Accessory' && $val->status == 'N') {
                $getInventoryAccessoryQtyNonActive += count($val);
                $getInventoryAccessorySellingPriceNonActive += ($val->qty * $val->price_sell);
                $getInventoryAccessoryBuyingPriceNonActive += ($val->qty * $val->price_buy);
            }
        };

        $data = array(
            "count_student_active" => $model_dashboard->getCountStudentActive(),
            "count_student_nonactive" => $model_dashboard->getCountStudentNonActive(),
            "deposit_student_active" => $model_dashboard->getDepositStudentActive(),
            "deposit_student_nonactive" => $model_dashboard->getDepositStudentNonActive(),
            "count_reward_active" => $model_dashboard->getCountRewardActive(),
            "count_reward_nonactive" => $model_dashboard->getCountRewardNonActive(),
            "price_reward_active" => $getBuyingPriceRewardActive,
            "price_reward_nonactive" => $getBuyingPriceRewardNonActive,
            "count_voucher_active" => $model_dashboard->getCountVoucherActive(),
            "count_voucher_nonactive" => $model_dashboard->getCountVoucherNonActive(),
            "value_voucher_active" => $getValueVoucherActive,
            "value_voucher_nonactive" => $getValueVoucherNonActive,
            "inventory_book_qty_active" => $getInventoryBookQtyActive,
            "inventory_book_qty_nonactive" => $getInventoryBookQtyNonActive,
            "inventory_book_selling_active" => $getInventoryBookSellingPriceActive,
            "inventory_book_selling_nonactive" => $getInventoryBookSellingPriceNonActive,
            "inventory_book_buying_active" => $getInventoryBookBuyingPriceActive,
            "inventory_book_buying_nonactive" => $getInventoryBookBuyingPriceNonActive,
            "inventory_accessory_qty_active" => $getInventoryAccessoryQtyActive,
            "inventory_accessory_qty_nonactive" => $getInventoryAccessoryQtyNonActive,
            "inventory_accessory_selling_active" => $getInventoryAccessorySellingPriceActive,
            "inventory_accessory_selling_nonactive" => $getInventoryAccessorySellingPriceNonActive,
            "inventory_accessory_buying_active" => $getInventoryAccessoryBuyingPriceActive,
            "inventory_accessory_buying_nonactive" => $getInventoryAccessoryBuyingPriceNonActive,
            "chart_payments" => $model_dashboard->getDataChartPayments(),
        );

        return response($data);
    }

    public function exportExcel()
    {
        $model_dashboard = new ReportBalanceSheet();

        // Data Reward
        $data_reward_active = $model_dashboard->getDataRewardActive();
        $data_reward_nonactive = $model_dashboard->getDataRewardNonActive();

        $getBuyingPriceRewardActive = 0;
        foreach ($data_reward_active as $key_report => $val) {
            $getBuyingPriceRewardActive += ($val->qty * $val->price);
        };

        $getBuyingPriceRewardNonActive = 0;
        foreach ($data_reward_nonactive as $key_report => $val) {
            $getBuyingPriceRewardNonActive += ($val->qty * $val->price);
        };

        // Data Voucher
        $data_voucher_active = $model_dashboard->getDataVoucherActive();
        $data_voucher_nonactive = $model_dashboard->getDataVoucherNonActive();

        $getValueVoucherActive = 0;
        foreach ($data_voucher_active as $key_report => $val) {
            $getValueVoucherActive += ($val->qty * $val->price);
        };

        $getValueVoucherNonActive = 0;
        foreach ($data_voucher_nonactive as $key_report => $val) {
            $getValueVoucherNonActive += ($val->qty * $val->price);
        };

        // Data Payment
        $data_inventory = $model_dashboard->getDataInventory();

        $getInventoryBookSellingPriceActive = 0;
        $getInventoryBookBuyingPriceActive = 0;
        $getInventoryBookQtyActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Books' && $val->status == 'A') {
                $getInventoryBookQtyActive += count($val);
                $getInventoryBookSellingPriceActive += ($val->qty * $val->price_sell);
                $getInventoryBookBuyingPriceActive += ($val->qty * $val->price_buy);
            }
        };

        $getInventoryBookSellingPriceNonActive = 0;
        $getInventoryBookBuyingPriceNonActive = 0;
        $getInventoryBookQtyNonActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Books' && $val->status == 'N') {
                $getInventoryBookQtyNonActive += count($val);
                $getInventoryBookSellingPriceNonActive += ($val->qty * $val->price_sell);
                $getInventoryBookBuyingPriceNonActive += ($val->qty * $val->price_buy);
            }
        };

        $getInventoryAccessorySellingPriceActive = 0;
        $getInventoryAccessoryBuyingPriceActive = 0;
        $getInventoryAccessoryQtyActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Accessory' && $val->status == 'A') {
                $getInventoryAccessoryQtyActive += count($val);
                $getInventoryAccessorySellingPriceActive += ($val->qty * $val->price_sell);
                $getInventoryAccessoryBuyingPriceActive += ($val->qty * $val->price_buy);
            }
        };

        $getInventoryAccessorySellingPriceNonActive = 0;
        $getInventoryAccessoryBuyingPriceNonActive = 0;
        $getInventoryAccessoryQtyNonActive = 0;
        foreach ($data_inventory as $key_report => $val) {
            if ($val->category == 'Accessory' && $val->status == 'N') {
                $getInventoryAccessoryQtyNonActive += count($val);
                $getInventoryAccessorySellingPriceNonActive += ($val->qty * $val->price_sell);
                $getInventoryAccessoryBuyingPriceNonActive += ($val->qty * $val->price_buy);
            }
        };

        $data = $model_dashboard->getDataChartPayments()->toArray();

        $data_payment = json_decode(json_encode($data), True);

        $data_excel = array(
            "count_student_active" => $model_dashboard->getCountStudentActive(),
            "count_student_nonactive" => $model_dashboard->getCountStudentNonActive(),
            "deposit_student_active" => $model_dashboard->getDepositStudentActive(),
            "deposit_student_nonactive" => $model_dashboard->getDepositStudentNonActive(),
            "count_reward_active" => $model_dashboard->getCountRewardActive(),
            "count_reward_nonactive" => $model_dashboard->getCountRewardNonActive(),
            "price_reward_active" => $getBuyingPriceRewardActive,
            "price_reward_nonactive" => $getBuyingPriceRewardNonActive,
            "count_voucher_active" => $model_dashboard->getCountVoucherActive(),
            "count_voucher_nonactive" => $model_dashboard->getCountVoucherNonActive(),
            "value_voucher_active" => $getValueVoucherActive,
            "value_voucher_nonactive" => $getValueVoucherNonActive,
            "inventory_book_qty_active" => $getInventoryBookQtyActive,
            "inventory_book_qty_nonactive" => $getInventoryBookQtyNonActive,
            "inventory_book_selling_active" => $getInventoryBookSellingPriceActive,
            "inventory_book_selling_nonactive" => $getInventoryBookSellingPriceNonActive,
            "inventory_book_buying_active" => $getInventoryBookBuyingPriceActive,
            "inventory_book_buying_nonactive" => $getInventoryBookBuyingPriceNonActive,
            "inventory_accessory_qty_active" => $getInventoryAccessoryQtyActive,
            "inventory_accessory_qty_nonactive" => $getInventoryAccessoryQtyNonActive,
            "inventory_accessory_selling_active" => $getInventoryAccessorySellingPriceActive,
            "inventory_accessory_selling_nonactive" => $getInventoryAccessorySellingPriceNonActive,
            "inventory_accessory_buying_active" => $getInventoryAccessoryBuyingPriceActive,
            "inventory_accessory_buying_nonactive" => $getInventoryAccessoryBuyingPriceNonActive
        );
        // cetak_r($data_excel);
        $periode_start = date("d-m-Y");
        $periode_end = date("d-m-Y");
        // return view('templates.apps.export.excelBalanceSheet', compact('data_excel'));
        $export_cxcel = Excel::create('REP-BALANCESHEET-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
            $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                $sheet->loadView('templates.apps.export.excelBalanceSheet', compact('data_excel'));
            });
        })->export('xls');

        return $export_cxcel;
    }
}
