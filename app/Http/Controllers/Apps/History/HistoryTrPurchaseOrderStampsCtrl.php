<?php

namespace App\Http\Controllers\Apps\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\historyTrPurchaseOrderStamps;
use App\Model\User;
use Validator;
use DB;

class historyTrPurchaseOrderStampsCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_history_tr_purchase_order_stamps = new historyTrPurchaseOrderStamps();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        if ($datestart || $dateend) {
            $hitory_tr_purchase_order_stamps = $model_history_tr_purchase_order_stamps->gethistoryTrPurchaseOrderStampsByFilter($datestart, $dateend);
            return response($hitory_tr_purchase_order_stamps);
        } else {
            $hitory_tr_purchase_order_stamps = $model_history_tr_purchase_order_stamps->gethistoryTrPurchaseOrderStampsPagination();
            return response($hitory_tr_purchase_order_stamps);
        }
    }
}
