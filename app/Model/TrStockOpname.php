<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class TrStockOpname extends Model
{
    protected $table = 'tr_stock_opname';
    public function getTrStockOpnameBySearch($typing)
    {
        $data = DB::table('tr_stock_opname')
            ->select(
                'tr_stock_opname.id as id'
                , 'tr_stock_opname.code as code'
                , 'tr_stock_opname.price_purchase_app as price_purchase_app'
                , 'tr_stock_opname.price_purchase_phx as price_purchase_phx'
                , 'tr_stock_opname.price_purchase_difference as price_purchase_difference'
                , 'tr_stock_opname.price_sell_app as price_sell_app'
                , 'tr_stock_opname.price_sell_phx as price_sell_phx'
                , 'tr_stock_opname.price_sell_difference as price_sell_difference'
                , 'tr_stock_opname.stock_in_system as stock_in_system'
                , 'tr_stock_opname.stock_in_physic as stock_in_physic'
                , 'tr_stock_opname.stock_difference as stock_difference'
                , 'tr_stock_opname.status as status'
                , 'tr_stock_opname.date as date'
                , 'tr_stock_opname.created_at as created_at'
                , 'tr_stock_opname.users_id as user_id'
                , 'users.name as user_name'
				, 'items.name as item_name'
				, 'stamps.name as stamp_name'
            )
            ->leftJoin('users', 'users.id', '=', 'tr_stock_opname.users_id')
            ->leftJoin('items', 'items.code', '=', 'tr_stock_opname.items_code')
            ->leftJoin('stamps', 'stamps.code', '=', 'tr_stock_opname.items_code')
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orderBy('tr_stock_opname.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getTrStockOpnamePagination()
    {
        $data = DB::table('tr_stock_opname')
            ->select(
                'tr_stock_opname.id as id'
                , 'tr_stock_opname.code as code'
                , 'tr_stock_opname.price_purchase_app as price_purchase_app'
                , 'tr_stock_opname.price_purchase_phx as price_purchase_phx'
                , 'tr_stock_opname.price_purchase_difference as price_purchase_difference'
                , 'tr_stock_opname.price_sell_app as price_sell_app'
                , 'tr_stock_opname.price_sell_phx as price_sell_phx'
                , 'tr_stock_opname.price_sell_difference as price_sell_difference'
                , 'tr_stock_opname.stock_in_system as stock_in_system'
                , 'tr_stock_opname.stock_in_physic as stock_in_physic'
                , 'tr_stock_opname.stock_difference as stock_difference'
                , 'tr_stock_opname.status as status'
                , 'tr_stock_opname.date as date'
                , 'tr_stock_opname.created_at as created_at'
                , 'tr_stock_opname.users_id as user_id'
                , 'users.name as user_name'
                , 'items.name as item_name'
				, 'stamps.name as stamp_name'
            )
            ->leftJoin('users', 'users.id', '=', 'tr_stock_opname.users_id')
            ->leftJoin('items', 'items.code', '=', 'tr_stock_opname.items_code')
            ->leftJoin('stamps', 'stamps.code', '=', 'tr_stock_opname.items_code')
            ->where('tr_stock_opname.status', 'proses')
            ->orderBy('tr_stock_opname.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getItemAll($code)
    {
        $stamp = DB::table('stamps')
        ->select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.price as price_sell'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
            , DB::raw('(CASE WHEN stamps.code is not null THEN "reward" ELSE "reward" END) AS category')
        )
        ->where("stamps.status", 'A')
        ->where("stamps.code", $code);

        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.qty as qty'
            , 'items.status as status'
            , DB::raw('(CASE WHEN items.code is not null THEN "inventory" ELSE "inventory" END) AS category')
        )
        ->union($stamp)
        ->where("items.code", $code)
        ->where("items.status", 'A')
        ->get();

        return $data;
    }
}
