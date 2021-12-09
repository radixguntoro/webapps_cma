<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Item;
use App\Model\ReportItems;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportItemsCtrl extends Controller
{
    public function filterReportItems(Request $request)
    {
        $model_report_items = new ReportItems();

        $report_items = $model_report_items->getReportItemsByFilter();

        $total_price_buy = 0;
        $total_price_sell = 0;

        foreach ($report_items as $key_report => $val_items) {
            $total_price_buy += $val_items->price_buy * $val_items->qty;
            $total_price_sell += $val_items->price_sell * $val_items->qty;
        };

        $data_items = array(
            "report_items" => $report_items,
            "total_price_buy" => $total_price_buy,
            "total_price_sell" => $total_price_sell
        );

        return response($data_items);
    }

    public function exportExcel(Request $request)
    {
        $model_report_items = new ReportItems();

        $periode_start = date("d-m-Y");
        $periode_end = date("d-m-Y");

        $data = $model_report_items->getExcelItemsByFilter()->toArray();
        // $data_excel = $data = Items::get()->toArray();
        $data_excel = json_decode(json_encode($data), True);
        $item_id = array();
        foreach ($data as $key => $value) {
            $item_id[$key] = $value['id'];
        }
        array_multisort($item_id, SORT_DESC, $data_excel);

        // return view('templates.apps.export.excelItems', compact('data_excel'));
        $export_cxcel = Excel::create('REP-ITEMS-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
            $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                $sheet->loadView('templates.apps.export.excelItems', compact('data_excel'));
            });
        })->export('xls');

        return $export_cxcel;
    }
}
