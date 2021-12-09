<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportStockGiftRewards;
use App\Model\User;
use App\Model\Stamp;
use Validator;
use Excel;
use DB;

class ReportStockGiftRewardsCtrl extends Controller
{
    public function filterReportStockGiftRewards(Request $request)
    {
        $model_report_stock_gift_rewards = new ReportStockGiftRewards();

        $report_stock_gift_rewards = $model_report_stock_gift_rewards->getReportStockGiftRewardsByFilter();

        $total_stock_gift_rewards = 0;
        $stamp_stock_gift_rewards = 0;

        foreach ($report_stock_gift_rewards as $key_report => $val_stock_gift_rewards) {
            $total_stock_gift_rewards += $val_stock_gift_rewards->qty;
            $stamp_stock_gift_rewards += $val_stock_gift_rewards->stamp;
        };

        $data_stock_gift_rewards = array(
            "report_stock_gift_rewards" => $report_stock_gift_rewards,
            "total_stock_gift_rewards" => $total_stock_gift_rewards,
            "stamp_stock_gift_rewards" => $stamp_stock_gift_rewards
        );

        return response($data_stock_gift_rewards);
    }

    public function exportExcel(Request $request)
    {
        $model_report_stock_gift_rewards = new ReportStockGiftRewards();

        $periode_start = date("d-m-Y");
        $periode_end = date("d-m-Y");

        $data = $model_report_stock_gift_rewards->getExcelStockGiftRewardsByFilter()->toArray();

        $data_excel = json_decode(json_encode($data), True);
        $stamp_id = array();

        foreach ($data as $key => $value) {
            $stamp_id[$key] = $value['id'];
        }
        array_multisort($stamp_id, SORT_DESC, $data_excel);

        // return view('templates.apps.export.excelStockGiftRewards', compact('data_excel'));
        $export_cxcel = Excel::create('REP-STOCKGIFTREWARD-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
            $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                $sheet->loadView('templates.apps.export.excelStockGiftRewards', compact('data_excel'));
            });
        })->export('xls');

        return $export_cxcel;
    }
}
