<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TrPayments;
use App\Model\ReportTrPaymentStudents;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportTrPaymentStudentsCtrl extends Controller
{
    public function filterReportTrPaymentStudents(Request $request)
    {
        $model_report_tr_payments = new ReportTrPaymentStudents();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');
        if ($student || $datestart || $dateend) {
            $report_tr_payments = $model_report_tr_payments->getReportTrPaymentStudentsByFilter($student, $datestart, $dateend);
            // $return_tr_payments = $model_report_tr_payments->getReturnTransSalesByFilter($student, $datestart, $dateend);
            $total_tr_payments = 0;
            foreach ($report_tr_payments as $key_report => $val_tr_payments) {
                $total_tr_payments += $val_tr_payments->grand_total;
            };

            // $total_return_sales = 0;
            // foreach ($return_tr_payments as $key_return => $val_return_sales) {
            //     $total_return_sales += $val_return_sales->subtotal;
            // };

            $data_tr_payments = array(
                "report_tr_payments" => $report_tr_payments,
                "total_tr_payments" => $total_tr_payments,
                // "total_return_sales" => $total_return_sales,
            );

            return response($data_tr_payments);
        }
    }

    public function getReportTrPaymentStudentsDetail($id)
    {
        $model_tr_payments = new ReportTrPaymentStudents();
        $data_tr_payment_item_details = $model_tr_payments->getReportTrPaymentItemDetail($id);
        $data_tr_payment_tuition_details = $model_tr_payments->getReportTrPaymentTuitionDetail($id);
        $data_tr_payment_deposit_details = $model_tr_payments->getReportTrPaymentDepositDetail($id);

        $tr_payment_detail = array(
            "tr_payment_item_detail" => $data_tr_payment_item_details,
            "tr_payment_tuition_detail" => $data_tr_payment_tuition_details,
            "tr_payment_deposit_detail" => $data_tr_payment_deposit_details
        );

        return response()->json($tr_payment_detail);
    }

    public function exportExcel(Request $request)
    {
        $model_report_tr_payments = new ReportTrPaymentStudents();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($student || $datestart || $dateend) {
            $data = $model_report_tr_payments->getExcelTrPaymentsByFilter($student, $datestart, $dateend)->toArray();
            // $data_excel = $data = TrPayments::get()->toArray();
            $data_excel = json_decode(json_encode($data), True);
            $date = array();
            foreach ($data as $key => $value) {
                $date[$key] = $value['date'];
            }
            array_multisort($date, SORT_DESC, $data_excel);
            // cetak_r($data_excel);
            // return view('templates.apps.export.excelTrPayments', compact('data_excel'));
            $export_cxcel = Excel::create('REP-PAYMENTPERSTUDENT-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelTrPaymentStudents', compact('data_excel'));
                });
            })->export('xls')->only('id');

            return $export_cxcel;
        }
    }
}
