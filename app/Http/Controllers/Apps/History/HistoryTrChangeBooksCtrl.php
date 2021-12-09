<?php

namespace App\Http\Controllers\Apps\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\historyTrChangeBooks;
use App\Model\User;
use Validator;
use DB;

class historyTrChangeBooksCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_history_tr_change_books = new historyTrChangeBooks();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        if ($datestart || $dateend) {
            $hitory_tr_change_books = $model_history_tr_change_books->gethistoryTrChangeBooksByFilter($datestart, $dateend);
            return response($hitory_tr_change_books);
        } else {
            $hitory_tr_change_books = $model_history_tr_change_books->gethistoryTrChangeBooksPagination();
            return response($hitory_tr_change_books);
        }
    }
}
