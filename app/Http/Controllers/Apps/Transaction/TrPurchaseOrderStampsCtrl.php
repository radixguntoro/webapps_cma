<?php

namespace App\Http\Controllers\Apps\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use App\Model\TrPurchaseOrderStamps;
use App\Model\TrPurchaseOrderStampDetails;
use App\Model\HistoryTrPurchaseOrderStamps;
use App\Model\Stamp;
use Cart;
use DB;

class TrPurchaseOrderStampsCtrl extends Controller
{
    public function index()
    {
        return view('layouts.base-layout');
    }

    public function searchStampManual($id)
    {
        $cart_stamp = Stamp::where('id', $id)->get()->first();
        return response()->json($cart_stamp);
    }

    public function insert(Request $request) {

        try{
            DB::beginTransaction();
            $valid_invoice = TrPurchaseOrderStamps::where('invoice', $request->invoice)->get();

            if (count($valid_invoice) > 0) {
                return "invalid";
            } else {
                // Menyimpan Transaksi Pembayaran
                $model_tr_purchase_orders = new TrPurchaseOrderStamps();
                $model_tr_purchase_orders->invoice = $request->invoice;
                $model_tr_purchase_orders->date = date("Y-m-d", strtotime($request->date));
                $model_tr_purchase_orders->total = $request->total;
                $model_tr_purchase_orders->discount = $request->discount;
                $model_tr_purchase_orders->grand_total = $request->grand_total;
                $model_tr_purchase_orders->note = $request->note;
                $model_tr_purchase_orders->users_id = Auth::user()->id;
                $model_tr_purchase_orders->save();

                $cart_stamp = json_decode(json_encode($request->cart_stamp));

                // Menyimpan Transaksi Detil Stamp
                foreach ($cart_stamp as $key => $val_stamp) {
                    $model_tr_purchase_order_stamp = new TrPurchaseOrderStampDetails();
                    $model_tr_purchase_order_stamp->qty = $val_stamp->qty;
                    $model_tr_purchase_order_stamp->price_buy = $val_stamp->price_buy;
                    $model_tr_purchase_order_stamp->discount = $val_stamp->discount;
                    $model_tr_purchase_order_stamp->subtotal = $val_stamp->subtotal;
                    $model_tr_purchase_order_stamp->stamps_id = $val_stamp->stamp_id;
                    $model_tr_purchase_order_stamp->tr_purchase_order_stamps_id = $model_tr_purchase_orders->id;
                    $model_tr_purchase_order_stamp->save();
                    Stamp::where('id', $val_stamp->stamp_id)->increment('qty', $val_stamp->qty);
                }

                // Menyimpan Transaksi Penjualan di Histori Transaksi Penjualan
                $model_his_tr_purchase_orders = new HistoryTrPurchaseOrderStamps();
                $model_his_tr_purchase_orders->action = "Insert Purchase Order Gift";
                $model_his_tr_purchase_orders->date = date("Y-m-d");
                $model_his_tr_purchase_orders->time = date("H:i:s");
                $model_his_tr_purchase_orders->tr_purchase_order_stamps_id = $model_tr_purchase_orders->id;
                $model_his_tr_purchase_orders->users_id = Auth::user()->id;
                $model_his_tr_purchase_orders->save();

                DB::commit();
                return "Success";
            }

        } catch(\Exception $e) {
            return "Error"." ".$e;
            DB::rollback();
        }
    }
}
