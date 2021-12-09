<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\Item;
use DB;

class ReportItems extends Model
{
    protected $table = 'items';

    public function getReportItemsByFilter()
    {
        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.qty as qty'
            , 'items.price_buy as price_buy'
            , 'items.price_sell as price_sell'
            , 'items.status as status'
            , 'categories.name as category'
        )
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('items.status', 'A')
        ->orderBy('items.id', 'desc')
        ->get();

        return $data;
    }

    public function getExcelItemsByFilter()
    {
        $data = Item::select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.qty as qty'
            , 'items.price_buy as price_buy'
            , 'items.price_sell as price_sell'
            , 'items.status as status'
            , 'categories.name as category'
        )
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where('items.status', 'A')
        ->get();
        return $data;
    }
}
