<?php

namespace App\Http\Controllers\Apps\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use App\Model\TrPayments;
use App\Model\TrPaymentsTuitionDetail;
use App\Model\TrPaymentsItemDetail;
use App\Model\TrPaymentsDepositDetail;
use App\Model\HistoryTrPayments;
use App\Model\Tuition;
use App\Model\Item;
use App\Model\Student;
use App\Model\User;
use App\Model\Voucher;
use Cart;
use DB;

class TrPaymentsCtrl extends Controller
{
    public function index()
    {
        return view('layouts.base-layout');
    }

    public function searchTuitionManual($id)
    {
        $cart_tuition = Tuition::where('id', $id)->get()->first();
        return response()->json($cart_tuition);
    }

    public function searchItemManual($id)
    {
        $cart_item = Item::where('id', $id)->get()->first();
        return response()->json($cart_item);
    }

    public function insert(Request $request) {

        try{
            DB::beginTransaction();
            $valid_invoice = TrPayments::where('invoice', $request->invoice)->get();

            if (count($valid_invoice) > 0) {
                return "invalid";
            } else {
                // Menyimpan Transaksi Pembayaran
                $model_tr_payments = new TrPayments();
                $model_tr_payments->invoice = $request->invoice;
                $model_tr_payments->date = date("Y-m-d", strtotime($request->date));
                $model_tr_payments->cash = $request->cash;
                $model_tr_payments->debit = $request->debit;
                $model_tr_payments->transfer = $request->transfer;
                $model_tr_payments->method_total = $request->method_total;
                $model_tr_payments->subtotal = $request->subtotal;
                $model_tr_payments->discount = $request->discount;
                $model_tr_payments->discount_voucher = $request->discount_voucher;
                $model_tr_payments->grand_total = $request->grand_total;
                $model_tr_payments->balance = $request->balance;
                $model_tr_payments->note = $request->note;
                $model_tr_payments->students_id = $request->student_id;
                $model_tr_payments->users_id = Auth::user()->id;
                $model_tr_payments->save();

                Voucher::where('id', $request->voucher_id)->decrement('qty', 1);

                $cart_tuition = json_decode(json_encode($request->cart_tuition));
                $cart_item = json_decode(json_encode($request->cart_item));

                // Menyimpan Transaksi Detil Tuition
                foreach ($cart_tuition as $key => $val_tuition) {
                    $model_tr_payment_tuition = new TrPaymentsTuitionDetail();
                    $model_tr_payment_tuition->price = $val_tuition->price;
                    $model_tr_payment_tuition->discount = $val_tuition->discount;
                    $model_tr_payment_tuition->subtotal = $val_tuition->subtotal;
                    $model_tr_payment_tuition->tuitions_id = $val_tuition->tuition_id;
                    $model_tr_payment_tuition->tr_payments_id = $model_tr_payments->id;
                    $model_tr_payment_tuition->save();
                }

                // Menyimpan Transaksi Detil Item
                foreach ($cart_item as $key => $val_item) {
                    $model_tr_payment_item = new TrPaymentsItemDetail();
                    $model_tr_payment_item->price_start = $val_item->price;
                    $model_tr_payment_item->discount = $val_item->discount;
                    $model_tr_payment_item->price_end = $val_item->price - ($val_item->price * $val_item->discount);
                    $model_tr_payment_item->qty = $val_item->qty;
                    $model_tr_payment_item->subtotal = $val_item->subtotal;
                    $model_tr_payment_item->items_id = $val_item->item_id;
                    $model_tr_payment_item->tr_payments_id = $model_tr_payments->id;
                    $model_tr_payment_item->save();
                    Item::where('id', $val_item->item_id)->decrement('qty', $val_item->qty);
                }

                if ($request->deposit_total > 0) {
                    $model_tr_payment_deposit = new TrPaymentsDepositDetail();
                    $model_tr_payment_deposit->total = $request->deposit_total;
                    $model_tr_payment_deposit->discount = $request->deposit_discount;
                    $model_tr_payment_deposit->subtotal = $request->deposit_subtotal;
                    $model_tr_payment_deposit->last_deposit = $request->student_deposit;
                    $model_tr_payment_deposit->tr_payments_id = $model_tr_payments->id;
                    $model_tr_payment_deposit->save();
                    Student::where('id', $request->student_id)->increment('deposit', $request->deposit_total);
                }

                // Menyimpan Transaksi Penjualan di Histori Transaksi Penjualan
                $model_his_tr_payments = new HistoryTrPayments();
                $model_his_tr_payments->action = "Insert Payment Transaction";
                $model_his_tr_payments->date = date("Y-m-d");
                $model_his_tr_payments->time = date("H:i:s");
                $model_his_tr_payments->tr_payments_id = $model_tr_payments->id;
                $model_his_tr_payments->users_id = Auth::user()->id;
                $model_his_tr_payments->save();

                DB::commit();
                return "Success";
            }

        } catch(\Exception $e) {
            return "Error"." ".$e;
            DB::rollback();
        }
    }
}
