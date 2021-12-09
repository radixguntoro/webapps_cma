<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\ConvertData;
use App\Model\TrChangeBooks;
use App\Model\ReportTrChangeBooks;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportTrChangeBooksCtrl extends Controller
{
    public function filterReportTrChangeBooks(Request $request)
    {
        $convert_data = new ConvertData();
        $model_report_tr_change_books = new ReportTrChangeBooks();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');
        if ($student || $datestart || $dateend) {
            $data = $model_report_tr_change_books->getReportTrChangeBooksByFilter($student, $datestart, $dateend);

            $report_tr_change_books = json_decode(json_encode($data), True);

            $date = array();
            $student_id = array();
            $deposit_balance = array();
            $second = array();

            foreach ($data as $key => $value) {
                $student_id[$key] = $value['student_id'];
                $date[$key] = $value['date'];
                $deposit_balance[$key] = $value['deposit_balance'];
                $second[$key] = $value['second'];
            }

            array_multisort($student_id, SORT_DESC, $date, SORT_DESC, $second, SORT_DESC, $report_tr_change_books);

            // cetak_r($report_tr_change_books);
            $data_tr_change_books = array(
                "report_tr_change_books" => $report_tr_change_books
            );

            return response($data_tr_change_books);
        }
    }

    public function getReportTrChangeBooksDetail($id)
    {
        $model_tr_change_books = new ReportTrChangeBooks();
        $data_tr_change_books_item_details = $model_tr_change_books->getReportTrChangeBookItemDetail($id);
        $data_tr_change_books_tuition_details = $model_tr_change_books->getReportTrChangeBookTuitionDetail($id);
        $data_tr_change_books_deposit_details = $model_tr_change_books->getReportTrChangeBookDepositDetail($id);

        $tr_change_books_detail = array(
            "tr_change_books_item_detail" => $data_tr_change_books_item_details,
            "tr_change_books_tuition_detail" => $data_tr_change_books_tuition_details,
            "tr_change_books_deposit_detail" => $data_tr_change_books_deposit_details
        );

        return response()->json($tr_change_books_detail);
    }

    public function exportExcel(Request $request)
    {
        $model_report_tr_change_books = new ReportTrChangeBooks();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($student || $datestart || $dateend) {
            $data = $model_report_tr_change_books->getExcelTrChangeBooksByFilter($student, $datestart, $dateend)->toArray();
            // $data_excel = $data = TrChangeBooks::get()->toArray();
            $data_excel = json_decode(json_encode($data), True);

            $date = array();
            $student_id = array();
            $deposit_balance = array();
            $second = array();

            foreach ($data as $key => $value) {
                $student_id[$key] = $value['student_id'];
                $date[$key] = $value['date'];
                $deposit_balance[$key] = $value['deposit_balance'];
                $second[$key] = $value['second'];
            }

            array_multisort($student_id, SORT_ASC, $date, SORT_ASC, $second, SORT_ASC, $data_excel);
            // cetak_r($data_excel);
            // return view('templates.apps.export.excelTrChangeBooks', compact('data_excel'));
            $export_cxcel = Excel::create('REP-CHANGEBOOK-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelTrChangeBooks', compact('data_excel'));
                });
            })->export('xls');

            return $export_cxcel;
        }
    }
}
