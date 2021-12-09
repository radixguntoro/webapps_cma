<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportPurchaseOrderRewards;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportPurchaseOrderRewardsCtrl extends Controller
{
    public function filterReportPurchaseOrderRewards(Request $request)
    {
        $model_report_purchase_order_rewards = new ReportPurchaseOrderRewards();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');

        if ($datestart || $dateend) {
            $data = $model_report_purchase_order_rewards->getReportPurchaseOrderRewardsByFilter($datestart, $dateend);
            // cetak_r($report_purchase_order_rewards);
            $report_purchase_order_rewards = json_decode(json_encode($data), True);
            $date = array();
            $detail_id = array();

            foreach ($data as $key => $value) {
                $detail_id[$key] = $value['detail_id'];
                $date[$key] = $value['date'];
            }

            array_multisort($date, SORT_DESC, $detail_id, SORT_ASC, $report_purchase_order_rewards);

            $total_purchase_order_rewards = 0;
            foreach ($data as $key_report => $val_purchase_order_rewards) {
                $total_purchase_order_rewards += $val_purchase_order_rewards->subtotal;
            };

            $data_purchase_order_rewards = array(
                "report_purchase_order_rewards" => $report_purchase_order_rewards,
                "total_purchase_order_rewards" => $total_purchase_order_rewards,
            );

            return response($data_purchase_order_rewards);
        }
    }

    public function exportExcel(Request $request)
    {
        $model_report_purchase_order_rewards = new ReportPurchaseOrderRewards();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($datestart || $dateend) {
            $data = $model_report_purchase_order_rewards->getExcelPurchaseOrderRewardsByFilter($datestart, $dateend)->toArray();
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
            $export_cxcel = Excel::create('REP-PURCHASEORDERREWARD-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelPurchaseOrderRewards', compact('data_excel'));
                });
            })->export('xls')->only('id');

            return $export_cxcel;
        }
    }
}
