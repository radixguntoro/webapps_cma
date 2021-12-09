<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $fillable = [
        'name'
   	];

    public function getVoucherBySearch($typing)
    {
        $data = DB::table('vouchers')
        ->select(
            'vouchers.id as id'
            , 'vouchers.code as code'
            , 'vouchers.name as name'
            , 'vouchers.price as price'
            , 'vouchers.qty as qty'
            , 'vouchers.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'vouchers.users_id')
        ->where("vouchers.name", "LIKE", "%{$typing}%")
        ->orWhere("vouchers.code", "LIKE", "%{$typing}%")
        ->orderBy('vouchers.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getVoucherPagination()
    {
        $data = DB::table('vouchers')
        ->select(
            'vouchers.id as id'
            , 'vouchers.code as code'
            , 'vouchers.name as name'
            , 'vouchers.price as price'
            , 'vouchers.qty as qty'
            , 'vouchers.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'vouchers.users_id')
        ->orderBy('vouchers.id', 'desc')
        ->paginate(25);

        return $data;
    }

    public function getVoucherById($id)
    {
        $data = DB::table('vouchers')
        ->select(
            'vouchers.id as id'
            , 'vouchers.code as code'
            , 'vouchers.name as name'
            , 'vouchers.price as price'
            , 'vouchers.qty as qty'
            , 'vouchers.status as status'
            , 'users.id as user_id'
            , 'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'vouchers.users_id')
        ->where('vouchers.id', $id)
        ->get();

        return $data;
    }
}
