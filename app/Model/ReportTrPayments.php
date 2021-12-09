<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\TrPayments;
use DB;

class ReportTrPayments extends Model
{
    protected $table = 'tr_payments';

    public function getReportTrPaymentsByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $data = DB::table('tr_payments')
            ->select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->whereBetween('tr_payments.date', [$datestart, $dateend])
            ->orderBy('tr_payments.invoice', 'asc')
            ->get();
            return $data;
        } else if($student_id && $datestart && $dateend) {
            $data = DB::table('tr_payments')
            ->select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->whereBetween('tr_payments.date', [$datestart, $dateend])
            ->where('students.id', $student_id)
            ->orderBy('tr_payments.invoice', 'asc')
            ->get();
            return $data;
        }
    }

    public function getExcelTrPaymentsByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $tuition = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , 'tuitions.name as transaction'
                , DB::raw('(CASE WHEN tuitions.code is not null THEN "Tuition" ELSE "Tuition" END) AS category')
                , 'tr_payment_tuition_details.subtotal as tuition'
                , DB::raw('(CASE WHEN tr_payment_tuition_details.subtotal is not null THEN "" ELSE "" END) AS deposit_book')
                , DB::raw('(CASE WHEN tr_payment_tuition_details.subtotal is not null THEN "" ELSE "" END) AS inventory')
                , DB::raw('(CASE WHEN tr_payment_tuition_details.discount > 0 THEN (tr_payment_tuition_details.price * tr_payment_tuition_details.discount) ELSE 0 END) AS disc')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_tuition_details', 'tr_payments.id', '=', 'tr_payment_tuition_details.tr_payments_id')
            ->join('tuitions', 'tuitions.id', '=', 'tr_payment_tuition_details.tuitions_id')
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $item = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , 'items.name as transaction'
                , 'categories.name as category'
                , DB::raw('(CASE WHEN tr_payment_item_details.subtotal is not null THEN "" ELSE "" END) AS tuition')
                , DB::raw('(CASE WHEN tr_payment_item_details.subtotal is not null THEN "" ELSE "" END) AS deposit_book')
                , 'tr_payment_item_details.subtotal as inventory'
                , DB::raw('(CASE WHEN tr_payment_item_details.discount > 0 THEN ((tr_payment_item_details.price_start * tr_payment_item_details.discount) * tr_payment_item_details.qty) ELSE 0 END) AS disc')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_item_details', 'tr_payments.id', '=', 'tr_payment_item_details.tr_payments_id')
            ->join('items', 'items.id', '=', 'tr_payment_item_details.items_id')
            ->join('categories', 'categories.id', '=', 'items.categories_id')
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $data = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS transaction')
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS category')
                , DB::raw('(CASE WHEN tr_payment_deposit_details.subtotal is not null THEN "" ELSE "" END) AS tuition')
                , 'tr_payment_deposit_details.subtotal as deposit_book'
                , DB::raw('(CASE WHEN tr_payment_deposit_details.subtotal is not null THEN "" ELSE "" END) AS inventory')
                , DB::raw('(CASE WHEN tr_payment_deposit_details.discount > 0 THEN (tr_payment_deposit_details.total * tr_payment_deposit_details.discount) ELSE 0 END) AS disc')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_deposit_details', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
            ->union($tuition)
            ->union($item)
            ->whereBetween('tr_payments.date', [$datestart, $dateend])
            ->get();

            return $data;
        } else if($student_id && $datestart && $dateend) {
            $tuition = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , 'tuitions.name as transaction'
                , DB::raw('(CASE WHEN tuitions.code is not null THEN "Tuition" ELSE "Tuition" END) AS category')
                , 'tr_payment_tuition_details.subtotal as tuition'
                , DB::raw('(CASE WHEN tr_payment_tuition_details.subtotal is not null THEN "" ELSE "" END) AS deposit_book')
                , DB::raw('(CASE WHEN tr_payment_tuition_details.subtotal is not null THEN "" ELSE "" END) AS inventory')
                , DB::raw('(CASE WHEN tr_payment_tuition_details.discount > 0 THEN (tr_payment_tuition_details.price * tr_payment_tuition_details.discount) ELSE 0 END) AS disc')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_tuition_details', 'tr_payments.id', '=', 'tr_payment_tuition_details.tr_payments_id')
            ->join('tuitions', 'tuitions.id', '=', 'tr_payment_tuition_details.tuitions_id')
            ->where('students.id', $student_id)
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $item = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , 'items.name as transaction'
                , 'categories.name as category'
                , DB::raw('(CASE WHEN tr_payment_item_details.subtotal is not null THEN "" ELSE "" END) AS tuition')
                , DB::raw('(CASE WHEN tr_payment_item_details.subtotal is not null THEN "" ELSE "" END) AS deposit_book')
                , 'tr_payment_item_details.subtotal as inventory'
                , DB::raw('(CASE WHEN tr_payment_item_details.discount > 0 THEN ((tr_payment_item_details.price_start * tr_payment_item_details.discount) * tr_payment_item_details.qty) ELSE 0 END) AS disc')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_item_details', 'tr_payments.id', '=', 'tr_payment_item_details.tr_payments_id')
            ->join('items', 'items.id', '=', 'tr_payment_item_details.items_id')
            ->join('categories', 'categories.id', '=', 'items.categories_id')
            ->where('students.id', $student_id)
            ->whereBetween('tr_payments.date', [$datestart, $dateend]);

            $data = TrPayments::select(
                'tr_payments.id as id'
                , 'tr_payments.invoice as invoice'
                , 'tr_payments.cash as cash'
                , 'tr_payments.debit as debit'
                , 'tr_payments.transfer as transfer'
                , 'tr_payments.method_total as total'
                , 'tr_payments.subtotal as subtotal'
                , 'tr_payments.discount as discount'
                , 'tr_payments.discount_voucher as discount_voucher'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.balance as balance'
                , 'tr_payments.note as note'
                , 'tr_payments.date as date'
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS transaction')
                , DB::raw('(CASE WHEN students.deposit >= 0 THEN "Deposit Book" ELSE "Deposit Book" END) AS category')
                , DB::raw('(CASE WHEN tr_payment_deposit_details.subtotal is not null THEN "" ELSE "" END) AS tuition')
                , 'tr_payment_deposit_details.subtotal as deposit_book'
                , DB::raw('(CASE WHEN tr_payment_deposit_details.subtotal is not null THEN "" ELSE "" END) AS inventory')
                , DB::raw('(CASE WHEN tr_payment_deposit_details.discount > 0 THEN (tr_payment_deposit_details.total * tr_payment_deposit_details.discount) ELSE 0 END) AS disc')
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
            )
            ->join('users', 'users.id', '=', 'tr_payments.users_id')
            ->join('students', 'students.id', '=', 'tr_payments.students_id')
            ->join('tr_payment_deposit_details', 'tr_payments.id', '=', 'tr_payment_deposit_details.tr_payments_id')
            ->where('students.id', $student_id)
            ->union($tuition)
            ->union($item)
            ->whereBetween('tr_payments.date', [$datestart, $dateend])
            ->get();

            return $data;
        }
    }

    public function getReportPaymentsPagination()
    {
        $data = DB::table('tr_payments')
            ->select(
                'tr_payments.id as id'
                , 'tr_payments.code as code'
                , 'tr_payments.total_price as total_price'
                , 'tr_payments.discount_price as discount_price'
                , 'tr_payments.discount as discount'
                , 'tr_payments.grand_total as grand_total'
                , 'tr_payments.payment as payment'
                , 'tr_payments.balance as balance'
                , 'tr_payments.date as date'
                , 'tr_payments.time as time'
                , 'users.first_name as first_name'
                , 'users.last_name as last_name'
                , 'users.nik as nik'
            )
            ->join('users', 'users.id', '=', 'tr_payments.user_id')
            ->orderBy('tr_payments.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getReportTrPaymentItemDetail($id)
    {
        $data = DB::table('tr_payment_item_details')
            ->select(
                'tr_payment_item_details.id as id'
                , 'tr_payment_item_details.price_start as price_start'
                , 'tr_payment_item_details.price_end as price_end'
                , 'tr_payment_item_details.qty as qty'
                , 'tr_payment_item_details.discount as discount'
                , 'tr_payment_item_details.subtotal as subtotal'
                , 'items.name as name'
            )
            ->join('items', 'items.id', '=', 'tr_payment_item_details.items_id')
            ->where('tr_payment_item_details.tr_payments_id', $id)
            ->get();
        return $data;
    }

    public function getReportTrPaymentTuitionDetail($id)
    {
        $data = DB::table('tr_payment_tuition_details')
            ->select(
                'tr_payment_tuition_details.id as id'
                , 'tr_payment_tuition_details.price as price'
                , 'tr_payment_tuition_details.discount as discount'
                , 'tr_payment_tuition_details.subtotal as subtotal'
                , 'tuitions.name as name'
            )
            ->join('tuitions', 'tuitions.id', '=', 'tr_payment_tuition_details.tuitions_id')
            ->where('tr_payment_tuition_details.tr_payments_id', $id)
            ->get();
        return $data;
    }

    public function getReportTrPaymentDepositDetail($id)
    {
        $data = DB::table('tr_payment_deposit_details')
            ->select(
                'tr_payment_deposit_details.id as id'
                , 'tr_payment_deposit_details.total as total'
                , 'tr_payment_deposit_details.discount as discount'
                , 'tr_payment_deposit_details.subtotal as subtotal'
                , 'tr_payment_deposit_details.last_deposit as last_deposit'
            )
            ->where('tr_payment_deposit_details.tr_payments_id', $id)
            ->get();
        return $data;
    }
}
