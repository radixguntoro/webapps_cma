<?php

namespace App\Http\Controllers\Apps\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\historyTrChangeStamps;
use App\Model\User;
use Validator;
use DB;

class historyTrChangeStampsCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_history_tr_change_stamps = new historyTrChangeStamps();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        if ($datestart || $dateend) {
            $hitory_tr_change_stamps = $model_history_tr_change_stamps->gethistoryTrChangeStampsByFilter($datestart, $dateend);
            return response($hitory_tr_change_stamps);
        } else {
            $hitory_tr_change_stamps = $model_history_tr_change_stamps->gethistoryTrChangeStampsPagination();
            return response($hitory_tr_change_stamps);
        }
    }
}
