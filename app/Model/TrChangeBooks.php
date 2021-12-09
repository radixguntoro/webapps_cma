<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class trChangeBooks extends Model
{
    protected $table = 'tr_change_books';

    public function getTrChangeBooksByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $data = DB::table('tr_change_books')
                ->select(
                    'tr_change_books.id as id',
                    'tr_change_books.date as date',
                    'tr_change_books.subtotal as subtotal',
                    'tr_change_books.deposit_before as deposit_before',
                    'tr_change_books.deposit_after as deposit_after',
                    'tr_change_books.note as note',
                    'students.name as student_name',
                    'students.code as student_id'
                )
                ->join('users', 'users.id', '=', 'tr_change_books.users_id')
                ->join('students', 'students.id', '=', 'tr_change_books.students_id')
                ->whereBetween('tr_change_books.date', [$datestart, $dateend])
                ->orderBy('tr_change_books.date', 'desc')
                ->get();
            return $data;
        } else if ($student_id && $datestart && $dateend) {
            $data = DB::table('tr_change_books')
                ->select(
                    'tr_change_books.id as id',
                    'tr_change_books.date as date',
                    'tr_change_books.subtotal as subtotal',
                    'tr_change_books.deposit_before as deposit_before',
                    'tr_change_books.deposit_after as deposit_after',
                    'tr_change_books.note as note',
                    'students.name as student_name',
                    'students.code as student_id'
                )
                ->join('users', 'users.id', '=', 'tr_change_books.users_id')
                ->join('students', 'students.id', '=', 'tr_change_books.students_id')
                ->whereBetween('tr_change_books.date', [$datestart, $dateend])
                ->where('students.id', $student_id)
                ->orderBy('tr_change_books.date', 'desc')
                ->get();
            return $data;
        }
    }
}
