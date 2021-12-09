<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\Stamp;
use DB;

class ReportStockGiftRewards extends Model
{
    protected $table = 'stamps';

    public function getReportStockGiftRewardsByFilter()
    {
        $data = DB::table('stamps')
        ->select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.stamp as stamp'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
        )
        ->where('stamps.status', 'A')
        ->orderBy('stamps.id', 'desc')
        ->get();

        return $data;
    }

    public function getExcelStockGiftRewardsByFilter()
    {
        $data = Stamp::select(
            'stamps.id as id'
            , 'stamps.code as code'
            , 'stamps.name as name'
            , 'stamps.stamp as stamp'
            , 'stamps.qty as qty'
            , 'stamps.status as status'
        )
        ->where('stamps.status', 'A')
        ->get();
        return $data;
    }
}
