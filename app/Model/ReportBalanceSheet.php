<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\Student;
use App\Model\Stamp;
use App\Model\Voucher;
use App\Model\Item;
use App\Model\TrPayments;
use DB;

class ReportBalanceSheet extends Model
{
    public function getCountStudentActive()
    {
        $data = Student::where('status', "A")->count();

        return $data;
    }

    public function getCountStudentNonActive()
    {
        $data = Student::where('status', "N")->count();

        return $data;
    }

    public function getDepositStudentActive()
    {
        $data = Student::where('status', "A")->sum("deposit");

        return $data;
    }

    public function getDepositStudentNonActive()
    {
        $data = Student::where('status', "N")->sum("deposit");

        return $data;
    }

    public function getCountRewardActive()
    {
        $data = Stamp::where('status', "A")->count();

        return $data;
    }

    public function getCountRewardNonActive()
    {
        $data = Stamp::where('status', "N")->count();

        return $data;
    }

    public function getDataRewardActive()
    {
        $data = Stamp::where('status', "A")->get();

        return $data;
    }

    public function getDataRewardNonActive()
    {
        $data = Stamp::where('status', "N")->get();

        return $data;
    }

    public function getCountVoucherActive()
    {
        $data = Voucher::where('status', "A")->count();

        return $data;
    }

    public function getCountVoucherNonActive()
    {
        $data = Voucher::where('status', "N")->count();

        return $data;
    }

    public function getDataVoucherActive()
    {
        $data = Voucher::where('status', "A")->get();

        return $data;
    }

    public function getDataVoucherNonActive()
    {
        $data = Voucher::where('status', "N")->get();

        return $data;
    }

    public function getDataInventory()
    {
        $data = Item::select(
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
        $data = TrPayments::select(DB::raw('YEAR(date) as year, MONTH(date) as month, SUM(grand_total) as grand_total'))
                ->whereYear('date', date('Y'))
                ->groupBy(DB::raw('YEAR(date), MONTH(date)'))
                ->get();
        return $data;
    }
}
