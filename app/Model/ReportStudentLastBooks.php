<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\Student;
use DB;

class ReportStudentLastBooks extends Model
{
    protected $table = 'students';

    public function getReportStudentLastBooksByFilter()
    {
        $changebook = Student::select(
            'students.id as id'
            , 'students.code as code'
            , 'students.name as name'
            , 'students.status as status'
            , 'items.name as book_name'
            , 'tr_change_books.date as date'
            , 'tr_change_books.created_at as second'
        )
        ->leftJoin('tr_change_books', 'tr_change_books.students_id', '=', 'students.id')
        ->leftJoin('tr_change_book_details', 'tr_change_book_details.tr_change_books_id', '=', 'tr_change_books.id')
        ->leftJoin('items', 'items.id', '=', 'tr_change_book_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('categories.id', 1);

        $data = Student::select(
            'students.id as id'
            , 'students.code as code'
            , 'students.name as name'
            , 'students.status as status'
            , 'items.name as book_name'
            , 'tr_payments.date as date'
            , 'tr_payments.created_at as second'
        )
        ->leftJoin('tr_payments', 'tr_payments.students_id', '=', 'students.id')
        ->leftJoin('tr_payment_item_details', 'tr_payment_item_details.tr_payments_id', '=', 'tr_payments.id')
        ->leftJoin('items', 'items.id', '=', 'tr_payment_item_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('categories.id', 1)
        ->union($changebook)
        ->get();

        return $data;
    }

    public function getExcelStudentLastBooksByFilter()
    {
        $changebook = Student::select(
            'students.id as id'
            , 'students.code as code'
            , 'students.name as name'
            , 'students.status as status'
            , 'items.name as book_name'
            , 'tr_change_books.date as date'
            , 'tr_change_books.created_at as second'
        )
        ->leftJoin('tr_change_books', 'tr_change_books.students_id', '=', 'students.id')
        ->leftJoin('tr_change_book_details', 'tr_change_book_details.tr_change_books_id', '=', 'tr_change_books.id')
        ->leftJoin('items', 'items.id', '=', 'tr_change_book_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('categories.id', 1);

        $data = Student::select(
            'students.id as id'
            , 'students.code as code'
            , 'students.name as name'
            , 'students.status as status'
            , 'items.name as book_name'
            , 'tr_payments.date as date'
            , 'tr_payments.created_at as second'
        )
        ->leftJoin('tr_payments', 'tr_payments.students_id', '=', 'students.id')
        ->leftJoin('tr_payment_item_details', 'tr_payment_item_details.tr_payments_id', '=', 'tr_payments.id')
        ->leftJoin('items', 'items.id', '=', 'tr_payment_item_details.items_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('categories.id', 1)
        ->union($changebook)
        ->get();

        return $data;
    }
}
