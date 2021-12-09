<?php

namespace App\Http\Controllers\Apps\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\historyTrPayments;
use App\Model\User;
use Validator;
use DB;

class historyTrPaymentsCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_history_tr_payments = new historyTrPayments();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        if ($datestart || $dateend) {
            $hitory_tr_payments = $model_history_tr_payments->gethistoryTrPaymentsByFilter($datestart, $dateend);
            return response($hitory_tr_payments);
        } else {
            $hitory_tr_payments = $model_history_tr_payments->gethistoryTrPaymentsPagination();
            return response($hitory_tr_payments);
        }
    }
}
