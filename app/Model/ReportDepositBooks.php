<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\Student;
use DB;

class ReportDepositBooks extends Model
{
    protected $table = 'students';

    public function getReportDepositBooksByFilter()
    {
        $data = DB::table('students')
        ->select(
            'students.id as id'
            , 'students.code as code'
            , 'students.name as name'
            , 'students.join_date as join_date'
            , 'students.deposit as deposit'
            , 'students.status as status'
        )
        ->where('students.status', 'A')
        ->orderBy('students.code', 'asc')
        ->get();

        return $data;
    }

    public function getExcelDepositBooksByFilter()
    {
        $data = Student::select(
            'students.id as id'
            , 'students.code as code'
            , 'students.name as name'
            , 'students.join_date as join_date'
            , 'students.deposit as deposit'
            , 'students.status as status'
        )
        ->where('students.status', 'A')
        ->orderBy('students.code', 'asc')
        ->get();
        return $data;
    }
}
