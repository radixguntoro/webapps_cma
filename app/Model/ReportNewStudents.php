<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\Student;
use DB;

class ReportNewStudents extends Model
{
    protected $table = 'students';

    public function getReportNewStudentsByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $data = DB::table('students')
            ->select(
                'students.id as id'
                , 'students.code as code'
                , 'students.name as name'
                , 'students.join_date as join_date'
                , 'students.deposit as deposit'
                , 'students.status as status'
                , 'users.name as admin'
            )
            ->join('users', 'users.id', '=', 'students.users_id')
            ->whereBetween('students.join_date', [$datestart, $dateend])
            ->orderBy('students.id', 'desc')
            ->get();
            return $data;
        } else if($student_id && $datestart && $dateend) {
            $data = DB::table('students')
            ->select(
                'students.id as id'
                , 'students.code as code'
                , 'students.name as name'
                , 'students.join_date as join_date'
                , 'students.deposit as deposit'
                , 'students.status as status'
                , 'users.name as admin'
            )
            ->join('users', 'users.id', '=', 'students.users_id')
            ->whereBetween('students.join_date', [$datestart, $dateend])
            ->where('students.id', $student_id)
            ->orderBy('students.id', 'desc')
            ->get();
            return $data;
        }
    }

    public function getExcelNewStudentsByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $data = Student::select(
                'students.id as id'
                , 'students.code as code'
                , 'students.name as name'
                , 'students.join_date as join_date'
                , 'students.deposit as deposit'
                , 'students.status as status'
                , 'users.name as admin'
            )
            ->join('users', 'users.id', '=', 'students.users_id')
            ->whereBetween('students.join_date', [$datestart, $dateend])
            ->get();

            return $data;
        } else if($student_id && $datestart && $dateend) {
            $data = Student::select(
                'students.id as id'
                , 'students.code as code'
                , 'students.name as name'
                , 'students.join_date as join_date'
                , 'students.deposit as deposit'
                , 'students.status as status'
                , 'users.name as admin'
            )
            ->join('users', 'users.id', '=', 'students.users_id')
            ->whereBetween('students.join_date', [$datestart, $dateend])
            ->where('students.id', $student_id)
            ->get();

            return $data;
        }
    }
}
