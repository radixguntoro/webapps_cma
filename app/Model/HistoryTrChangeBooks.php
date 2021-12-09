<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryTrChangeBooks extends Model
{
    protected $table = 'history_tr_change_books';
    public function getHistoryTrChangeBooksBySearch($typing)
    {
        $data = DB::table('history_tr_change_books')
            ->select(
                'history_tr_change_books.id as id'
                , 'history_tr_change_books.date as date'
                , 'history_tr_change_books.time as time'
                , 'history_tr_change_books.created_at as created_at'
                , 'history_tr_change_books.action as action'
                , 'history_tr_change_books.tr_change_books_id as tr_change_books_id'
                , 'history_tr_change_books.users_id as users_id'
                , 'users.name as name'
                , 'tr_change_books.id as id'
            )
            ->join('users', 'users.id', '=', 'history_tr_change_books.users_id')
            ->join('tr_change_books', 'tr_change_books.id', '=', 'history_tr_change_books.tr_change_books_id')
            ->where("users.name", "LIKE", "%{$typing}%")
            ->orWhere("users.last_name", "LIKE", "%{$typing}%")
            ->orderBy('history_tr_change_books.id', 'desc')
            ->paginate(25);

        return $data;
    }

    public function getHistoryTrChangeBooksByFilter($datestart, $dateend)
    {
        $data = DB::table('history_tr_change_books')
            ->select(
                'history_tr_change_books.id as id'
                , 'history_tr_change_books.date as date'
                , 'history_tr_change_books.time as time'
                , 'history_tr_change_books.created_at as created_at'
                , 'history_tr_change_books.action as action'
                , 'history_tr_change_books.tr_change_books_id as tr_change_books_id'
                , 'history_tr_change_books.users_id as users_id'
                , 'users.name as name'
                , 'tr_change_books.id as id'
            )
            ->join('users', 'users.id', '=', 'history_tr_change_books.users_id')
            ->join('tr_change_books', 'tr_change_books.id', '=', 'history_tr_change_books.tr_change_books_id')
            ->whereBetween('history_tr_change_books.date', [$datestart, $dateend])
            ->orderBy('history_tr_change_books.id', 'desc')
            ->paginate(25);
        return $data;
    }

    public function getHistoryTrChangeBooksPagination()
    {
        $data = DB::table('history_tr_change_books')
            ->select(
                'history_tr_change_books.id as id'
                , 'history_tr_change_books.date as date'
                , 'history_tr_change_books.time as time'
                , 'history_tr_change_books.created_at as created_at'
                , 'history_tr_change_books.action as action'
                , 'history_tr_change_books.tr_change_books_id as tr_change_books_id'
                , 'history_tr_change_books.users_id as users_id'
                , 'users.name as name'
                , 'tr_change_books.id as id'
            )
            ->join('users', 'users.id', '=', 'history_tr_change_books.users_id')
            ->join('tr_change_books', 'tr_change_books.id', '=', 'history_tr_change_books.tr_change_books_id')
            ->orderBy('history_tr_change_books.id', 'desc')
            ->paginate(25);

        return $data;
    }
}
