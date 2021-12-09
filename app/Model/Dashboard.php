<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class Dashboard extends Model
{
    public function getCountStudentActive()
    {
        $data = DB::table('students')->where('status', "A")->count();

        return $data;
    }

    public function getCountStudentNonActive()
    {
        $data = DB::table('students')->where('status', "N")->count();

        return $data;
    }

    public function getDepositStudentActive()
    {
        $data = DB::table('students')->where('status', "A")->sum("deposit");

        return $data;
    }

    public function getDepositStudentNonActive()
    {
        $data = DB::table('students')->where('status', "N")->sum("deposit");

        return $data;
    }

    public function getCountRewardActive()
    {
        $data = DB::table('stamps')->where('status', "A")->count();

        return $data;
    }

    public function getCountRewardNonActive()
    {
        $data = DB::table('stamps')->where('status', "N")->count();

        return $data;
    }

    public function getDataRewardActive()
    {
        $data = DB::table('stamps')->where('status', "A")->get();

        return $data;
    }

    public function getDataRewardNonActive()
    {
        $data = DB::table('stamps')->where('status', "N")->get();

        return $data;
    }

    public function getCountVoucherActive()
    {
        $data = DB::table('vouchers')->where('status', "A")->count();

        return $data;
    }

    public function getCountVoucherNonActive()
    {
        $data = DB::table('vouchers')->where('status', "N")->count();

        return $data;
    }

    public function getDataVoucherActive()
    {
        $data = DB::table('vouchers')->where('status', "A")->get();

        return $data;
    }

    public function getDataVoucherNonActive()
    {
        $data = DB::table('vouchers')->where('status', "N")->get();

        return $data;
    }

    public function getDataInventory()
    {
        $data = DB::table('items')->select(
            'items.name as name'
            , 'items.price_sell as price_sell'
            , 'items.price_buy as price_buy'
            , 'items.qty as qty'
            , 'items.status as status'
            , 'categories.name as category'
            , 'categories.id as category_id'
        )
        ->join('categories', 'categories.id', '=', 'items.categories_id')
        ->get();

        return $data;
    }

    public function getDataChartPayments()
    {
        $data = DB::table('tr_payments')
                ->select(DB::raw('YEAR(date) as year, MONTH(date) as month, SUM(grand_total) as grand_total'))
                ->whereYear('date', date('Y'))
                ->groupBy(DB::raw('YEAR(date), MONTH(date)'))
                ->get();
        return $data;
    }
}
