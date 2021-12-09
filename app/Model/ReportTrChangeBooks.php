<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\TrChangeBooks;
use DB;

class ReportTrChangeBooks extends Model
{
    protected $table = 'tr_change_books';

    public function getReportTrChangeBooksByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $deposit = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.date as date'
                , DB::raw('(CASE WHEN tr_payment_deposit_details.total > 0 THEN tr_payment_deposit_details.total + tr_payment_deposit_details.last_deposit  ELSE 0 END) AS deposit_balance')
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS category')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , DB::raw('(CASE WHEN tr_payments.id is not null THEN "" ELSE "" END) AS new_book')
                , 'tr_payments.note as note'
                , 'tr_payments.created_at as second'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_deposit_details', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $data = TrChangeBooks::select(
                'tr_change_books.id as id'
                , DB::raw('(CASE WHEN tr_change_books.id is not null THEN "" ELSE "" END) AS invoice')
                , 'tr_change_books.date as date'
                , DB::raw('(CASE WHEN tr_change_books.subtotal > 0 THEN tr_change_book_details.deposit_after ELSE 0 END) AS deposit_balance')
                , 'categories.name as category'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'items.name as new_book'
                , 'tr_change_books.note as note'
                , 'tr_change_books.created_at as second'
            )
            ->leftJoin('users', 'users.id', '=', 'tr_change_books.users_id')
            ->leftJoin('students', 'students.id', '=', 'tr_change_books.students_id')
            ->leftJoin('tr_change_book_details', 'tr_change_books.id', '=', 'tr_change_book_details.tr_change_books_id')
            ->leftJoin('items', 'items.id', '=', 'tr_change_book_details.items_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.categories_id')
            ->whereBetween('tr_change_books.date', [$datestart, $dateend])
            ->union($deposit)
            ->get();
            return $data;
        } else if($student_id && $datestart && $dateend) {
            $deposit = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.date as date'
                , DB::raw('(CASE WHEN tr_payment_deposit_details.total > 0 THEN tr_payment_deposit_details.total + tr_payment_deposit_details.last_deposit  ELSE 0 END) AS deposit_balance')
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS category')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , DB::raw('(CASE WHEN tr_payments.id is not null THEN "" ELSE "" END) AS new_book')
                , 'tr_payments.note as note'
                , 'tr_payments.created_at as second'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_deposit_details', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
            ->where('students.id', $student_id)
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $data = TrChangeBooks::select(
                'tr_change_books.id as id'
                , DB::raw('(CASE WHEN tr_change_books.id is not null THEN "" ELSE "" END) AS invoice')
                , 'tr_change_books.date as date'
                , DB::raw('(CASE WHEN tr_change_books.subtotal > 0 THEN tr_change_book_details.deposit_after ELSE 0 END) AS deposit_balance')
                , 'categories.name as category'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'items.name as new_book'
                , 'tr_change_books.note as note'
                , 'tr_change_books.created_at as second'
            )
            ->leftJoin('users', 'users.id', '=', 'tr_change_books.users_id')
            ->leftJoin('students', 'students.id', '=', 'tr_change_books.students_id')
            ->leftJoin('tr_change_book_details', 'tr_change_books.id', '=', 'tr_change_book_details.tr_change_books_id')
            ->leftJoin('items', 'items.id', '=', 'tr_change_book_details.items_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.categories_id')
            ->whereBetween('tr_change_books.date', [$datestart, $dateend])
            ->where('students.id', $student_id)
            ->union($deposit)
            ->get();
            return $data;
        }
    }

    public function getExcelTrChangeBooksByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $deposit = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.date as date'
                , DB::raw('(CASE WHEN tr_payment_deposit_details.total > 0 THEN tr_payment_deposit_details.total + tr_payment_deposit_details.last_deposit  ELSE 0 END) AS deposit_balance')
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS category')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , DB::raw('(CASE WHEN tr_payments.id is not null THEN "" ELSE "" END) AS new_book')
                , 'tr_payments.note as note'
                , 'tr_payments.created_at as second'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_deposit_details', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $data = TrChangeBooks::select(
                'tr_change_books.id as id'
                , DB::raw('(CASE WHEN tr_change_books.id is not null THEN "" ELSE "" END) AS invoice')
                , 'tr_change_books.date as date'
                , DB::raw('(CASE WHEN tr_change_books.subtotal > 0 THEN tr_change_book_details.deposit_after ELSE 0 END) AS deposit_balance')
                , 'categories.name as category'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'items.name as new_book'
                , 'tr_change_books.note as note'
                , 'tr_change_books.created_at as second'
            )
            ->leftJoin('users', 'users.id', '=', 'tr_change_books.users_id')
            ->leftJoin('students', 'students.id', '=', 'tr_change_books.students_id')
            ->leftJoin('tr_change_book_details', 'tr_change_books.id', '=', 'tr_change_book_details.tr_change_books_id')
            ->leftJoin('items', 'items.id', '=', 'tr_change_book_details.items_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.categories_id')
            ->whereBetween('tr_change_books.date', [$datestart, $dateend])
            ->union($deposit)
            ->get();
            return $data;
        } else if($student_id && $datestart && $dateend) {
            $deposit = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.date as date'
                , DB::raw('(CASE WHEN tr_payment_deposit_details.total > 0 THEN tr_payment_deposit_details.total + tr_payment_deposit_details.last_deposit  ELSE 0 END) AS deposit_balance')
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS category')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , DB::raw('(CASE WHEN tr_payments.id is not null THEN "" ELSE "" END) AS new_book')
                , 'tr_payments.note as note'
                , 'tr_payments.created_at as second'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_deposit_details', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
            ->where('students.id', $student_id)
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $data = TrChangeBooks::select(
                'tr_change_books.id as id'
                , DB::raw('(CASE WHEN tr_change_books.id is not null THEN "" ELSE "" END) AS invoice')
                , 'tr_change_books.date as date'
                , DB::raw('(CASE WHEN tr_change_books.subtotal > 0 THEN tr_change_book_details.deposit_after ELSE 0 END) AS deposit_balance')
                , 'categories.name as category'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'items.name as new_book'
                , 'tr_change_books.note as note'
                , 'tr_change_books.created_at as second'
            )
            ->leftJoin('users', 'users.id', '=', 'tr_change_books.users_id')
            ->leftJoin('students', 'students.id', '=', 'tr_change_books.students_id')
            ->leftJoin('tr_change_book_details', 'tr_change_books.id', '=', 'tr_change_book_details.tr_change_books_id')
            ->leftJoin('items', 'items.id', '=', 'tr_change_book_details.items_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.categories_id')
            ->where('students.id', $student_id)
            ->whereBetween('tr_change_books.date', [$datestart, $dateend])
            ->union($deposit)
            ->get();
            return $data;
        }
    }

    public function getReportTrChangeBooksItemDetail($id)
    {
        $data = DB::table('tr_change_book_details')
            ->select(
                'tr_change_book_details.id as id'
                , 'tr_change_book_details.price_start as price_start'
                , 'tr_change_book_details.price_end as price_end'
                , 'tr_change_book_details.qty as qty'
                , 'tr_change_book_details.discount as discount'
                , 'tr_change_book_details.subtotal as subtotal'
                , 'items.name as name'
            )
            ->join('items', 'items.id', '=', 'tr_change_book_details.items_id')
            ->where('tr_change_book_details.tr_change_books_id', $id)
            ->get();
        return $data;
    }
}
