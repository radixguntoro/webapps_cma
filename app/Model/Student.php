<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Student extends Model
{
    protected $table = "students";

    public function getStudentBySearch($typing)
    {
        $data_user = DB::table('students')
            ->select(
                'students.id as id'
                , 'students.code as code'
                , 'students.name as name'
                , 'students.join_date as join_date'
                , 'students.deposit as deposit'
                , 'students.status as status'
            )
            ->where("students.name", "LIKE", "%{$typing}%")
            ->orWhere("students.code", "LIKE", "%{$typing}%")
            ->orderBy('students.id', 'desc')
            ->paginate(25);

        return $data_user;
    }

    public function getStudentPagination()
    {
        $data_user = DB::table('students')
            ->select(
                'students.id as id'
                , 'students.code as code'
                , 'students.name as name'
                , 'students.join_date as join_date'
                , 'students.deposit as deposit'
                , 'students.status as status'
            )
            ->orderBy('students.id', 'desc')
            ->paginate(25);

        return $data_user;
    }

    public function getStudentById($id)
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
            ->where('students.id', $id)
            ->orderBy('students.id', 'desc')
            ->get();

        return $data;
    }

    public function searchStudent($typing)
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
        ->where("students.status", 'A')
        ->where("students.name", "LIKE", "%{$typing}%")
        ->orWhere("students.code", "LIKE", "%{$typing}%")
        ->orderBy('students.id', 'desc')
        ->paginate(10);

        return $data;
    }
}
