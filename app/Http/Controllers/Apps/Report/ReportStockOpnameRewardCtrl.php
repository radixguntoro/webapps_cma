<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TrStockOpname;
use App\Model\ReportStockOpnameReward;
use App\Model\User;
use Validator;
use Excel;
use DB;

class ReportStockOpnameRewardCtrl extends Controller
{
    public function filterReportStockOpnameReward(Request $request)
    {
        $model_report_stock_opname = new ReportStockOpnameReward();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');

        if ($datestart || $dateend) {
            $data = $model_report_stock_opname->getReportStockOpnameByFilter($datestart, $dateend);

            $report_stock_opname = json_decode(json_encode($data), True);

            $date = array();
            $detail_id = array();

            foreach ($data as $key => $value) {
                $detail_id[$key] = $value['id'];
                $date[$key] = $value['date'];
            }

            array_multisort($date, SORT_DESC, $detail_id, SORT_DESC, $report_stock_opname);

            $total_stock_opname = 0;
            foreach ($data as $key_report => $val_stock_opname) {
                $total_stock_opname += $val_stock_opname->price_sell_difference;
            };

            $data_stock_opname = array(
                "report_stock_opname" => $report_stock_opname,
                "total_stock_opname" => $total_stock_opname,
            );

            return response($data_stock_opname);
        }
    }

    public function exportExcel(Request $request)
    {
        $model_report_stock_opname = new ReportStockOpnameReward();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($datestart || $dateend) {
            $data = $model_report_stock_opname->getExcelStockOpnameByFilter($datestart, $dateend)->toArray();
            // $data_excel = $data = News::get()->toArray();
            $data_excel = json_decode(json_encode($data), True);
            $date = array();
            $detail_id = array();

            foreach ($data as $key => $value) {
                $detail_id[$key] = $value['id'];
                $date[$key] = $value['date'];
            }

            array_multisort($date, SORT_DESC, $detail_id, SORT_ASC, $data_excel);
            // cetak_r($data_excel);
            // return view('templates.apps.export.excelNews', compact('data_excel'));
            $export_cxcel = Excel::create('REP-STOCKOPNAMEREWARD-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelStockOpnameReward', compact('data_excel'));
                });
            })->export('xls')->only('id');

            return $export_cxcel;
        }
    }
}
