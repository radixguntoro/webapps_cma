<?php

namespace App\Http\Controllers\Apps\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use App\Model\TrPurchaseOrders;
use App\Model\TrPurchaseOrderDetails;
use App\Model\HistoryTrPurchaseOrders;
use App\Model\Item;
use App\Model\Stamp;
use Cart;
use DB;

class TrPurchaseOrdersCtrl extends Controller
{
    public function index()
    {
        return view('layouts.base-layout');
    }

    public function searchItemManual($id)
    {
        $cart_item = Item::where('id', $id)->get()->first();
        return response()->json($cart_item);
    }

    public function insert(Request $request) {

        try{
            DB::beginTransaction();
            $valid_invoice = TrPurchaseOrders::where('invoice', $request->invoice)->get();

            if (count($valid_invoice) > 0) {
                return "invalid";
            } else {
                // Menyimpan Transaksi Pembayaran
                $model_tr_purchase_orders = new TrPurchaseOrders();
                $model_tr_purchase_orders->invoice = $request->invoice;
                $model_tr_purchase_orders->date = date("Y-m-d", strtotime($request->date));
                $model_tr_purchase_orders->total = $request->total;
                $model_tr_purchase_orders->discount = $request->discount;
                $model_tr_purchase_orders->grand_total = $request->grand_total;
                $model_tr_purchase_orders->note = $request->note;
                $model_tr_purchase_orders->users_id = Auth::user()->id;
                $model_tr_purchase_orders->save();

                $cart_item = json_decode(json_encode($request->cart_item));

                // Menyimpan Transaksi Detil Item
                foreach ($cart_item as $key => $val_item) {
                    $model_tr_purchase_order_item = new TrPurchaseOrderDetails();
                    $model_tr_purchase_order_item->qty = $val_item->qty;
                    $model_tr_purchase_order_item->qty_bonus = $val_item->qty_bonus;
                    $model_tr_purchase_order_item->price_sell = $val_item->price_sell;
                    $model_tr_purchase_order_item->price_buy = $val_item->price_buy;
                    $model_tr_purchase_order_item->discount = $val_item->discount;
                    $model_tr_purchase_order_item->subtotal = $val_item->subtotal;
                    $model_tr_purchase_order_item->items_id = $val_item->item_id;
                    $model_tr_purchase_order_item->tr_purchase_orders_id = $model_tr_purchase_orders->id;
                    $model_tr_purchase_order_item->save();
                    $qty = $val_item->qty + $val_item->qty_bonus;
                    Item::where('id', $val_item->item_id)->increment('qty', $qty);
                }

                // Menyimpan Transaksi Penjualan di Histori Transaksi Penjualan
                $model_his_tr_purchase_orders = new HistoryTrPurchaseOrders();
                $model_his_tr_purchase_orders->action = "Insert Purchase Order";
                $model_his_tr_purchase_orders->date = date("Y-m-d");
                $model_his_tr_purchase_orders->time = date("H:i:s");
                $model_his_tr_purchase_orders->tr_purchase_orders_id = $model_tr_purchase_orders->id;
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
