<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TrChangeStamps;
use App\Model\ReportTrChangeStamps;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportTrChangeStampsCtrl extends Controller
{
    public function filterReportTrChangeStamps(Request $request)
    {
        $model_report_tr_change_stamps = new ReportTrChangeStamps();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');
        if ($student || $datestart || $dateend) {
            $report_tr_change_stamps = $model_report_tr_change_stamps->getReportTrChangeStampsByFilter($student, $datestart, $dateend);
            // cetak_r($report_tr_change_stamps);

            $data_tr_change_stamps = array(
                "report_tr_change_stamps" => $report_tr_change_stamps,
            );

            return response($data_tr_change_stamps);
        }
    }

    public function getReportTrChangeStampsDetail($id)
    {
        $model_tr_change_stamps = new ReportTrChangeStamps();
        $data_tr_change_stamps_item_details = $model_tr_change_stamps->getReportTrChangeStampItemDetail($id);
        $data_tr_change_stamps_tuition_details = $model_tr_change_stamps->getReportTrChangeStampTuitionDetail($id);
        $data_tr_change_stamps_deposit_details = $model_tr_change_stamps->getReportTrChangeStampDepositDetail($id);

        $tr_change_stamps_detail = array(
            "tr_change_stamps_item_detail" => $data_tr_change_stamps_item_details,
            "tr_change_stamps_tuition_detail" => $data_tr_change_stamps_tuition_details,
            "tr_change_stamps_deposit_detail" => $data_tr_change_stamps_deposit_details
        );

        return response()->json($tr_change_stamps_detail);
    }

    public function exportExcel(Request $request)
    {
        $model_report_tr_change_stamps = new ReportTrChangeStamps();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($student || $datestart || $dateend) {
            $data = $model_report_tr_change_stamps->getExcelTrChangeStampsByFilter($student, $datestart, $dateend)->toArray();
            // $data_excel = $data = TrChangeStamps::get()->toArray();
            $data_excel = json_decode(json_encode($data), True);
            $date = array();
            foreach ($data as $key => $value) {
                $date[$key] = $value['date'];
            }
            array_multisort($date, SORT_DESC, $data_excel);

            // return view('templates.apps.export.excelTrChangeStamps', compact('data_excel'));
            $export_cxcel = Excel::create('REP-CHANGESTAMP-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelTrChangeStamps', compact('data_excel'));
                });
            })->export('xls')->only('id');

            return $export_cxcel;
        }
    }
}
