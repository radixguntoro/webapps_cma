<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportPurchaseOrders;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportPurchaseOrdersCtrl extends Controller
{
    public function filterReportPurchaseOrders(Request $request)
    {
        $model_report_purchase_orders = new ReportPurchaseOrders();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');

        if ($datestart || $dateend) {
            $data = $model_report_purchase_orders->getReportPurchaseOrdersByFilter($datestart, $dateend);
            // cetak_r($report_purchase_orders);
            $report_purchase_orders = json_decode(json_encode($data), True);

            $date = array();
            $detail_id = array();

            foreach ($data as $key => $value) {
                $detail_id[$key] = $value['detail_id'];
                $date[$key] = $value['date'];
            }

            array_multisort($date, SORT_DESC, $detail_id, SORT_ASC, $report_purchase_orders);

            $total_purchase_orders = 0;
            foreach ($data as $key_report => $val_purchase_orders) {
                $total_purchase_orders += $val_purchase_orders->subtotal;
            };

            $data_purchase_orders = array(
                "report_purchase_orders" => $report_purchase_orders,
                "total_purchase_orders" => $total_purchase_orders,
            );

            return response($data_purchase_orders);
        }
    }

    public function exportExcel(Request $request)
    {
        $model_report_purchase_orders = new ReportPurchaseOrders();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($datestart || $dateend) {
            $data = $model_report_purchase_orders->getExcelPurchaseOrdersByFilter($datestart, $dateend)->toArray();
            // $data_excel = $data = News::get()->toArray();
            $data_excel = json_decode(json_encode($data), True);
            $date = array();
            $detail_id = array();

            foreach ($data as $key => $value) {
                $detail_id[$key] = $value['detail_id'];
                $date[$key] = $value['date'];
            }

            array_multisort($date, SORT_DESC, $detail_id, SORT_ASC, $data_excel);
            // cetak_r($data_excel);
            // return view('templates.apps.export.excelNews', compact('data_excel'));
            $export_cxcel = Excel::create('REP-PURCHASEORDER-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelPurchaseOrders', compact('data_excel'));
                });
            })->export('xls')->only('id');

            return $export_cxcel;
        }
    }
}
