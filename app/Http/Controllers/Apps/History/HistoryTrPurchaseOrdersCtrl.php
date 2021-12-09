<?php

namespace App\Http\Controllers\Apps\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\historyTrPurchaseOrders;
use App\Model\User;
use Validator;
use DB;

class historyTrPurchaseOrdersCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_history_tr_purchase_orders = new historyTrPurchaseOrders();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        if ($datestart || $dateend) {
            $hitory_tr_purchase_orders = $model_history_tr_purchase_orders->getHistoryTrPurchaseOrdersByFilter($datestart, $dateend);
            return response($hitory_tr_purchase_orders);
        } else {
            $hitory_tr_purchase_orders = $model_history_tr_purchase_orders->getHistoryTrPurchaseOrdersPagination();
            return response($hitory_tr_purchase_orders);
        }
    }
}
