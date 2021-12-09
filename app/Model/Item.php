<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'name','parent_id'
   	];

    public function getItemBySearch($typing)
    {
        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.price_buy as price_buy'
            , 'items.price_starter_kids as price_starter_kids'
            , 'items.starter_kids as starter_kids'
            , 'items.qty as qty'
            , 'items.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
            , 'categories.name as category_name'
        )
        ->join('users', 'users.id', '=', 'items.users_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where("items.name", "LIKE", "%{$typing}%")
        ->orWhere("items.code", "LIKE", "%{$typing}%")
        ->orderBy('items.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getItemPagination()
    {
        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.price_buy as price_buy'
            , 'items.price_starter_kids as price_starter_kids'
            , 'items.starter_kids as starter_kids'
            , 'items.qty as qty'
            , 'items.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
            , 'categories.name as category_name'
        )
        ->join('users', 'users.id', '=', 'items.users_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->orderBy('items.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getItemById($id)
    {
        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.price_buy as price_buy'
            , 'items.price_starter_kids as price_starter_kids'
            , 'items.qty as qty'
            , 'items.status as status'
            , 'items.starter_kids as starter_kids'
            , 'items.categories_id as category_id'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'items.users_id')
        ->where('items.id', $id)
        ->get();

        return $data;
    }

    public function searchItem($typing)
    {
        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.price_buy as price_buy'
            , 'items.price_starter_kids as price_starter_kids'
            , 'items.starter_kids as starter_kids'
            , 'items.qty as qty'
            , 'items.status as status'
            , 'items.categories_id as category_id'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'items.users_id')
        ->where("items.status", 'A')
        ->where("items.name", "LIKE", "%{$typing}%")
        ->orderBy('items.id', 'desc')
        ->paginate(10);

        return $data;
    }

    public function searchBook($typing)
    {
        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.price_buy as price_buy'
            , 'items.price_starter_kids as price_starter_kids'
            , 'items.starter_kids as starter_kids'
            , 'items.qty as qty'
            , 'items.status as status'
            , 'items.categories_id as category_id'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'items.users_id')
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->where("categories.id", 1)
        ->where("items.status", 'A')
        ->where("items.name", "LIKE", "%{$typing}%")
        ->orderBy('items.id', 'desc')
        ->paginate(10);

        return $data;
    }

    public function searchItemAll($typing)
    {
        $stamp = DB::table('stamps')
        ->select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.price as price_sell'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
        )
        ->where("stamps.status", 'A')
        ->where("stamps.name", "LIKE", "%{$typing}%");

        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.qty as qty'
            , 'items.status as status'
        )
        ->union($stamp)
        ->where("items.name", "LIKE", "%{$typing}%")
        ->where("items.status", 'A')
        ->get();

        return $data;
    }

    public function getStarterKids($starter_kids)
    {
        $data = DB::table('items')
        ->select(
            'items.id as id'
            , 'items.code as code'
            , 'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.price_buy as price_buy'
            , 'items.price_starter_kids as price_starter_kids'
            , 'items.starter_kids as starter_kids'
            , 'items.qty as qty'
            , 'items.status as status'
            , 'items.categories_id as category_id'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'items.users_id')
        ->where("items.status", 'A')
        ->where("items.starter_kids", $starter_kids)
        ->orderBy('items.id', 'desc')
        ->get();

        return $data;
    }
}
