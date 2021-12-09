<?php

namespace App\Http\Controllers\Apps\Inventory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use App\Model\TrStockOpname;
use App\Model\HistoryTrStockOpname;
use App\Model\Item;
use App\Model\Stamp;
use Cart;
use DB;

class TrStockOpnameCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_tr_stock_opname = new TrStockOpname();
        $search = $request->get('search');
        if ($search) {
            $tr_stock_opname = $model_tr_stock_opname->getTrStockOpnameBySearch($search);
            return response($tr_stock_opname);
        } else {
            $tr_stock_opname = $model_tr_stock_opname->getTrStockOpnamePagination();
            return response($tr_stock_opname);
        }
    }

    public function getItem($code)
    {
        $model_item = new TrStockOpname();
        $cart_item = $model_item->getItemAll($code)->first();
        return response()->json($cart_item);
    }

    public function insert(Request $request) {
        // echo "<pre>";print_r($request->item_code);die;
        try{
            DB::beginTransaction();

            // Menyimpan Transaksi Penjualan
            $tableName = "tr_stock_opname";
            $primary = "code";
            $autoNumber = new AutoNumber();
            $cart_item = json_decode(json_encode($request->cart_item));
            // Menyimpan Transaksi Detil Item
            foreach ($cart_item as $key => $val_item) {
                $getCode = $autoNumber->generateCode($tableName, $primary, ($key+1));
                $model_tr_stock_opname = new TrStockOpname();
                $model_tr_stock_opname->code = "SO".$getCode;
                $model_tr_stock_opname->price_purchase_app = $val_item->price_purchase_app;
                $model_tr_stock_opname->price_purchase_phx = $val_item->price_purchase_phx;
                $model_tr_stock_opname->price_purchase_difference = $val_item->price_purchase_difference;
                $model_tr_stock_opname->price_sell_app = $val_item->price_sell_app;
                $model_tr_stock_opname->price_sell_phx = $val_item->price_sell_phx;
                $model_tr_stock_opname->price_sell_difference = $val_item->price_sell_difference;
                $model_tr_stock_opname->items_code = $val_item->item_id;
                $model_tr_stock_opname->stock_in_system = $val_item->stock_in_system;
                $model_tr_stock_opname->stock_in_physic = $val_item->stock_in_physic;
                $model_tr_stock_opname->stock_difference = $val_item->stock_difference;
                $model_tr_stock_opname->status = "done";
                $model_tr_stock_opname->date = date('Y-m-d');
                $model_tr_stock_opname->time = date("H:i:s");
                $model_tr_stock_opname->users_id = Auth::user()->id;
                if ($val_item->category == "inventory") {
                    Item::where('code', $val_item->item_id)->update(['qty' => $val_item->stock_in_physic]);
                } else {
                    Stamp::where('code', $val_item->item_id)->update(['qty' => $val_item->stock_in_physic]);
                }
                $model_tr_stock_opname->save();

                // Menyimpan Transaksi Penjualan di Histori Transaksi Penjualan
                $model_his_tr_payments = new HistoryTrStockOpname();
                $model_his_tr_payments->action = "Insert Stock Opname";
                $model_his_tr_payments->date = date("Y-m-d");
                $model_his_tr_payments->time = date("H:i:s");
                $model_his_tr_payments->tr_stock_opname_id = $model_tr_stock_opname->id;
                $model_his_tr_payments->users_id = Auth::user()->id;
                $model_his_tr_payments->save();
            }

            DB::commit();

            return "Success";

        } catch(\Exception $e) {
            return "Error"." ".$e;
            DB::rollback();
        }
    }
}
