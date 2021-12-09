<?php

namespace App\Http\Controllers\Apps\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use App\Model\TrChangeBooks;
use App\Model\TrChangeBookDetails;
use App\Model\HistoryTrChangeBooks;
use App\Model\Item;
use App\Model\Student;
use App\Model\User;
use Cart;
use DB;

class TrChangeBooksCtrl extends Controller
{
    public function index()
    {
        return view('layouts.base-layout');
    }

    public function filterTrChangeBooks(Request $request)
    {
        $model_tr_change_books = new TrChangeBooks();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        $student = $request->get('student');
        if ($student || $datestart || $dateend) {
            $data = $model_tr_change_books->getTrChangeBooksByFilter($student, $datestart, $dateend);
            return response($data);
        }
    }

    public function searchItemManual($id)
    {
        $cart_item = Item::where('id', $id)->get()->first();
        return response()->json($cart_item);
    }

    public function insert(Request $request)
    {

        try {
            DB::beginTransaction();

            // Menyimpan Transaksi Pembayaran
            $model_tr_changebooks = new TrChangeBooks();
            $model_tr_changebooks->date = date("Y-m-d", strtotime($request->date));
            $model_tr_changebooks->subtotal = $request->subtotal;
            $model_tr_changebooks->deposit_before = $request->deposit_before;
            $model_tr_changebooks->deposit_after = $request->deposit_after;
            $model_tr_changebooks->note = $request->note;
            $model_tr_changebooks->students_id = $request->student_id;
            $model_tr_changebooks->users_id = Auth::user()->id;
            $model_tr_changebooks->save();

            $cart_item = json_decode(json_encode($request->cart_item));

            // Menyimpan Transaksi Detil Item
            foreach ($cart_item as $key => $val_item) {
                $model_tr_changebook_detail = new TrChangeBookDetails();
                $model_tr_changebook_detail->price = $val_item->price;
                $model_tr_changebook_detail->qty = $val_item->qty;
                $model_tr_changebook_detail->deposit_before = $val_item->deposit_before;
                $model_tr_changebook_detail->deposit_after = $val_item->deposit_after;
                $model_tr_changebook_detail->items_id = $val_item->item_id;
                $model_tr_changebook_detail->tr_change_books_id = $model_tr_changebooks->id;
                $model_tr_changebook_detail->save();
                Item::where('id', $val_item->item_id)->decrement('qty', $val_item->qty);
            }

            Student::where('id', $request->student_id)->update(['deposit' => $request->deposit_after]);

            // Menyimpan Transaksi Penjualan di Histori Transaksi Penjualan
            $model_his_tr_changebooks = new HistoryTrChangeBooks();
            $model_his_tr_changebooks->action = "Insert Change Book Transaction";
            $model_his_tr_changebooks->date = date("Y-m-d");
            $model_his_tr_changebooks->time = date("H:i:s");
            $model_his_tr_changebooks->tr_change_books_id = $model_tr_changebooks->id;
            $model_his_tr_changebooks->users_id = Auth::user()->id;
            $model_his_tr_changebooks->save();

            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            return "Error" . " " . $e;
            DB::rollback();
        }
    }

    public function deleteTrChangeBooks($id)
    {
        try {
            DB::beginTransaction();

            // Menyimpan Transaksi Pembayaran
            $tr_changebooks = TrChangeBooks::where('id', $id)->get()->first();

            $tr_changebooks_detail = TrChangeBookDetails::where('tr_change_books_id', $id)->get();
            
            // Menyimpan Transaksi Detil Item
            foreach ($tr_changebooks_detail as $key => $val_item) {
                $data = Item::where('id', $val_item->items_id)->increment('qty', $val_item->qty);
                // echo "<pre>";print_r($data);die;
            }

            Student::where('id', $tr_changebooks->students_id)->increment('deposit', $tr_changebooks->subtotal);

            // Menyimpan Transaksi Penjualan di Histori Transaksi Penjualan
            HistoryTrChangeBooks::where('tr_change_books_id', $id)->delete();
            TrChangeBookDetails::where('tr_change_books_id', $id)->delete();
            TrChangeBooks::where('id', $id)->delete();
            
            DB::commit();
            return 1;
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
        }
    }
}
