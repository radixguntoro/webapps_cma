<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportNewStudents;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportNewStudentsCtrl extends Controller
{
    public function filterReportNewStudents(Request $request)
    {
        $model_report_new_students = new ReportNewStudents();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');
        // cetak_r($datestart);
        if ($student || $datestart || $dateend) {
            $report_new_students = $model_report_new_students->getReportNewStudentsByFilter($student, $datestart, $dateend);
            $data_new_students = array(
                "report_new_students" => $report_new_students,
            );

            return response($data_new_students);
        }
    }

    public function exportExcel(Request $request)
    {
        $model_report_new_students = new ReportNewStudents();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($student || $datestart || $dateend) {
            $data = $model_report_new_students->getExcelNewStudentsByFilter($student, $datestart, $dateend)->toArray();
            // $data_excel = $data = News::get()->toArray();
            $data_excel = json_decode(json_encode($data), True);
            $date = array();
            foreach ($data as $key => $value) {
                $date[$key] = $value['join_date'];
            }
            array_multisort($date, SORT_DESC, $data_excel);
            // cetak_r($data_excel);
            // return view('templates.apps.export.excelNews', compact('data_excel'));
            $export_cxcel = Excel::create('REP-NEWSTUDENT-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelNewStudents', compact('data_excel'));
                });
            })->export('xls')->only('id');

            return $export_cxcel;
        }
    }
}
