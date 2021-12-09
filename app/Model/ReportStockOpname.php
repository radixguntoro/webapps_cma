<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\TrStockOpname;
use DB;

class ReportStockOpname extends Model
{
    protected $table = 'tr_stock_opname';
    public function getReportStockOpnameByFilter($datestart, $dateend)
    {
        $data = TrStockOpname::select(
            'tr_stock_opname.id as id'
            , 'tr_stock_opname.code as code'
            , 'tr_stock_opname.price_sell_app as price_sell_app'
            , 'tr_stock_opname.price_sell_difference as price_sell_difference'
            , 'tr_stock_opname.stock_in_system as stock_in_system'
            , 'tr_stock_opname.stock_in_physic as stock_in_physic'
            , 'tr_stock_opname.stock_difference as stock_difference'
            , 'tr_stock_opname.date as date'
            , 'tr_stock_opname.time as time'
            , 'items.id as item_id'
            , 'items.name as name'
            , 'categories.name as category'
        )
        ->join('items', 'items.code', '=', 'tr_stock_opname.items_code')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('tr_stock_opname.items_code', 'LIKE', 'BR%')
        ->whereBetween('tr_stock_opname.date', [$datestart, $dateend])
        ->orderBy('tr_stock_opname.date', 'desc')
        ->orderBy('tr_stock_opname.id', 'asc')
        ->get();
        return $data;
    }

    public function getExcelStockOpnameByFilter($datestart, $dateend)
    {
        $data = TrStockOpname::select(
            'tr_stock_opname.id as id'
            , 'tr_stock_opname.code as code'
            , 'tr_stock_opname.price_sell_app as price_sell_app'
            , 'tr_stock_opname.price_sell_difference as price_sell_difference'
            , 'tr_stock_opname.stock_in_system as stock_in_system'
            , 'tr_stock_opname.stock_in_physic as stock_in_physic'
            , 'tr_stock_opname.stock_difference as stock_difference'
            , 'tr_stock_opname.date as date'
            , 'tr_stock_opname.time as time'
            , 'items.id as item_id'
            , 'items.name as name'
            , 'categories.name as category'
        )
        ->join('items', 'items.code', '=', 'tr_stock_opname.items_code')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('tr_stock_opname.items_code', 'LIKE', 'BR%')
        ->whereBetween('tr_stock_opname.date', [$datestart, $dateend])
        ->orderBy('tr_stock_opname.date', 'desc')
        ->orderBy('tr_stock_opname.id', 'asc')
        ->get();
        return $data;
    }
}
