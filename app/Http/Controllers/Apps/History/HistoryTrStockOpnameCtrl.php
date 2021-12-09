<?php

namespace App\Http\Controllers\Apps\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\historyTrStockOpname;
use App\Model\User;
use Validator;
use DB;

class historyTrStockOpnameCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_history_tr_stock_opname = new historyTrStockOpname();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        if ($datestart || $dateend) {
            $hitory_tr_stock_opname = $model_history_tr_stock_opname->getHistoryTrStockOpnameByFilter($datestart, $dateend);
            return response($hitory_tr_stock_opname);
        } else {
            $hitory_tr_stock_opname = $model_history_tr_stock_opname->getHistoryTrStockOpnamePagination();
            return response($hitory_tr_stock_opname);
        }
    }
}
