<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportDepositBooks;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportDepositBooksCtrl extends Controller
{
    public function filterReportDepositBooks(Request $request)
    {
        $model_report_deposit_books = new ReportDepositBooks();

        $report_deposit_books = $model_report_deposit_books->getReportDepositBooksByFilter();

        $total_deposit_books = 0;

        foreach ($report_deposit_books as $key_report => $val_deposit_books) {
            $total_deposit_books += $val_deposit_books->deposit;
        };

        $data_deposit_books = array(
            "report_deposit_books" => $report_deposit_books,
            "total_deposit_books" => $total_deposit_books
        );

        return response($data_deposit_books);
    }

    public function exportExcel(Request $request)
    {
        $model_report_deposit_books = new ReportDepositBooks();

        $periode_start = date("d-m-Y");
        $periode_end = date("d-m-Y");

        $data = $model_report_deposit_books->getExcelDepositBooksByFilter()->toArray();

        $data_excel = json_decode(json_encode($data), True);
        $student_id = array();

        foreach ($data as $key => $value) {
            $student_id[$key] = $value['code'];
        }
        array_multisort($student_id, SORT_ASC, $data_excel);

        // return view('templates.apps.export.excelDepositBooks', compact('data_excel'));
        $export_cxcel = Excel::create('REP-DEPOSITBOOKS-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
            $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                $sheet->loadView('templates.apps.export.excelDepositBooks', compact('data_excel'));
            });
        })->export('xls');

        return $export_cxcel;
    }
}
