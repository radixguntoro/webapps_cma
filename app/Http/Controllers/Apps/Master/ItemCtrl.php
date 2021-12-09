<?php

namespace App\Http\Controllers\Apps\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use Illuminate\Support\Facades\Auth;
use App\Model\Item;
use Validator;
use Response;
use Input;
use DB;

class ItemCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_item = new Item();

        if ($request->get('search')) {
            $item = $model_item->getItemBySearch($request->get('search'));
        } else {
            $item = $model_item->getItemPagination();
        }
        return response($item);
    }

    public function insert(Request $request)
    {
        $valid_name = Item::where('name', $request->name)->get();

        if (count($valid_name) > 0) {
            return "invalid";
        } else {
            $tableName = "items";
            $primary = "code";
            $autoNumber = new AutoNumber();
            $getCode = $autoNumber->generate($tableName, $primary);

            $model_item = new Item();
            $model_item->code = "BR".$getCode;
            $model_item->name = $request->name;
            $model_item->price_buy = $request->price_buy;
            $model_item->price_sell = $request->price_sell;
            $model_item->price_starter_kids = $request->price_starter_kids;
            $model_item->qty = $request->qty;
            $model_item->status = $request->status;
            $model_item->starter_kids = $request->starter_kids;
            $model_item->categories_id = $request->category_id;
            $model_item->users_id = Auth::id();
            $model_item->save();
            return response()->json($model_item);
        }
    }

    public function edit($id)
    {
        $model_item = new Item();
        $data_item = $model_item->getItemById($id)->first();

        return response()->json($data_item);
    }

    public function update(Request $request)
    {
        $model_item = Item::find($request->id);
        $model_item->name = $request->name;
        $model_item->price_buy = $request->price_buy;
        $model_item->price_sell = $request->price_sell;
        $model_item->price_starter_kids = $request->price_starter_kids;
        $model_item->qty = $request->qty;
        $model_item->status = $request->status;
        $model_item->starter_kids = $request->starter_kids;
        $model_item->categories_id = $request->category_id;
        $model_item->users_id = Auth::id();
        $model_item->save();
        return response()->json($model_item);
    }

    public function searchItemSales(Request $request)
    {
        $model_item = new Item();
        $item = $model_item->searchItemSales($request->get('search'));
        return response($item);
    }

    public function getItemDetail($id)
    {
        $data_item = Item::find($id);

        $item = array(
            "data_item" => $data_item
        );

        return response()->json($item);
    }

    public function recordSupplier($id)
    {
        $data_item = DB::table('transaction_purchases')
            ->select(
                'items.name as item_name'
                , 'suppliers.name as supplier_name'
            )
            ->join('transaction_purchases_detail', 'transaction_purchases_detail.transaction_purchases_id', '=', 'transaction_purchases.id')
            ->join('suppliers', 'suppliers.id', '=', 'transaction_purchases.supplier_id')
            ->join('items', 'items.id', '=', 'transaction_purchases_detail.item_id')
            ->where('transaction_purchases_detail.item_id', $id)
            ->orderBy('suppliers.name', 'asc')
            ->distinct()
            ->get();

        return response()->json($data_item);
    }

    public function searchItem(Request $request)
    {
        $model_item = new Item();
        $item = $model_item->searchItem($request->get('search'));
        return response($item);
    }

    public function searchBook(Request $request)
    {
        $model_item = new Item();
        $item = $model_item->searchBook($request->get('search'));
        return response($item);
    }

    public function searchItemAll(Request $request)
    {
        $model_item = new Item();
        $item = $model_item->searchItemAll($request->get('search'));
        return response($item);
    }

    public function getStarterKids($starter_kids)
    {
        $model_item = new Item();
        $item = $model_item->getStarterKids($starter_kids);

        return response()->json($item);
    }
}
