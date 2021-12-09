<?php

namespace App\Http\Controllers\Apps\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use App\Model\TrChangeStamps;
use App\Model\TrChangeStampDetails;
use App\Model\HistoryTrChangeStamps;
use App\Model\Stamp;
use App\Model\Student;
use App\Model\User;
use Cart;
use DB;

class TrChangeStampsCtrl extends Controller
{
    public function index()
    {
        return view('layouts.base-layout');
    }

    public function searchStamp($id)
    {
        $cart_stamp = Stamp::where('id', $id)->get()->first();
        return response()->json($cart_stamp);
    }

    public function insert(Request $request) {

        try{
            DB::beginTransaction();

            // Menyimpan Transaksi Pembayaran
            $model_tr_changestamps = new TrChangeStamps();
            $model_tr_changestamps->date = date("Y-m-d", strtotime($request->date));
            $model_tr_changestamps->note = $request->note;
            $model_tr_changestamps->students_id = $request->student_id;
            $model_tr_changestamps->users_id = Auth::user()->id;
            $model_tr_changestamps->save();

            $cart_item = json_decode(json_encode($request->cart_item));

            // Menyimpan Transaksi Detil Item
            foreach ($cart_item as $key => $val_item) {
                $model_tr_changestamp_detail = new TrChangeStampDetails();
                $model_tr_changestamp_detail->price_sell = $val_item->price;
                $model_tr_changestamp_detail->stamp = $val_item->stamp;
                $model_tr_changestamp_detail->qty = $val_item->qty;
                $model_tr_changestamp_detail->stamps_id = $val_item->stamp_id;
                $model_tr_changestamp_detail->tr_change_stamps_id = $model_tr_changestamps->id;
                $model_tr_changestamp_detail->save();
                Stamp::where('id', $val_item->stamp_id)->decrement('qty', $val_item->qty);
            }

            // Menyimpan Transaksi Penjualan di Histori Transaksi Penjualan
            $model_his_tr_changestamps = new HistoryTrChangeStamps();
            $model_his_tr_changestamps->action = "Insert Change Stamp Transaction";
            $model_his_tr_changestamps->date = date("Y-m-d");
            $model_his_tr_changestamps->time = date("H:i:s");
            $model_his_tr_changestamps->tr_change_stamps_id = $model_tr_changestamps->id;
            $model_his_tr_changestamps->users_id = Auth::user()->id;
            $model_his_tr_changestamps->save();

            DB::commit();
            return "Success";

        } catch(\Exception $e) {
            return "Error"." ".$e;
            DB::rollback();
        }
    }
}
