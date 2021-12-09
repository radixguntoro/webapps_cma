<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportStudentLastBooks;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportStudentLastBooksCtrl extends Controller
{
    public function filterReportStudentLastBooks(Request $request)
    {
        $model_report_student_last_books = new ReportStudentLastBooks();

        $data = $model_report_student_last_books->getReportStudentLastBooksByFilter();

        $data_student = json_decode(json_encode($data), True);

        $date = array();
        $student_id = array();
        $second = array();

        foreach ($data as $key => $value) {
            $student_id[$key] = $value['code'];
            $date[$key] = $value['date'];
            $second[$key] = $value['second'];
        }

        array_multisort($student_id, SORT_DESC, $date, SORT_DESC, $second, SORT_DESC, $data_student);

        $report_student_last_books = $data_student;

        $data_student_last_books = array(
            "report_student_last_books" => $report_student_last_books,
        );

        return response($data_student_last_books);
    }

    public function exportExcel(Request $request)
    {
        $model_report_student_last_books = new ReportStudentLastBooks();

        $periode_start = date("d-m-Y");
        $periode_end = date("d-m-Y");

        $data = $model_report_student_last_books->getExcelStudentLastBooksByFilter()->toArray();

        $data_excel = json_decode(json_encode($data), True);
        $date = array();
        $student_id = array();
        $second = array();

        foreach ($data as $key => $value) {
            $student_id[$key] = $value['code'];
            $date[$key] = $value['date'];
            $second[$key] = $value['second'];
        }

        array_multisort($student_id, SORT_ASC, $date, SORT_ASC, $second, SORT_ASC, $data_excel);

        // return view('templates.apps.export.excelStudentLastBooks', compact('data_excel'));
        $export_cxcel = Excel::create('REP-STUDENTLASTBOOKS-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
            $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                $sheet->loadView('templates.apps.export.excelStudentLastBooks', compact('data_excel'));
            });
        })->export('xls');

        return $export_cxcel;
    }
}
