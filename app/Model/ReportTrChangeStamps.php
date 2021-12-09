<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Model\TrChangeStamps;
use DB;

class ReportTrChangeStamps extends Model
{
    protected $table = 'tr_change_stamps';

    public function getReportTrChangeStampsByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $data = DB::table('tr_change_stamps')
            ->select(
                'tr_change_stamps.id as id'
                , 'tr_change_stamps.date as date'
                , 'tr_change_stamps.note as note'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'stamps.name as item_name'
                , 'stamps.stamp as stamp'
                , 'stamps.price as item_price'
            )
            ->join('users', 'users.id', '=', 'tr_change_stamps.users_id')
            ->join('students', 'students.id', '=', 'tr_change_stamps.students_id')
            ->join('tr_change_stamp_details', 'tr_change_stamps.id', '=', 'tr_change_stamp_details.tr_change_stamps_id')
            ->join('stamps', 'stamps.id', '=', 'tr_change_stamp_details.stamps_id')
            ->whereBetween('tr_change_stamps.date', [$datestart, $dateend])
            ->orderBy('tr_change_stamps.date', 'desc')
            ->get();
            return $data;
        } else if($student_id && $datestart && $dateend) {
            $data = DB::table('tr_change_stamps')
            ->select(
                'tr_change_stamps.id as id'
                , 'tr_change_stamps.date as date'
                , 'tr_change_stamps.note as note'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'stamps.name as item_name'
                , 'stamps.stamp as stamp'
                , 'stamps.price as item_price'
            )
            ->join('users', 'users.id', '=', 'tr_change_stamps.users_id')
            ->join('students', 'students.id', '=', 'tr_change_stamps.students_id')
            ->join('tr_change_stamp_details', 'tr_change_stamps.id', '=', 'tr_change_stamp_details.tr_change_stamps_id')
            ->join('stamps', 'stamps.id', '=', 'tr_change_stamp_details.stamps_id')
            ->whereBetween('tr_change_stamps.date', [$datestart, $dateend])
            ->where('students.id', $student_id)
            ->orderBy('tr_change_stamps.date', 'desc')
            ->get();
            return $data;
        }
    }

    public function getExcelTrChangeStampsByFilter($student_id, $datestart, $dateend)
    {
        if (!isset($student_id) && $datestart && $dateend) {
            $data = TrChangeStamps::select(
                'tr_change_stamps.id as id'
                , 'tr_change_stamps.date as date'
                , 'tr_change_stamps.note as note'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'stamps.name as item_name'
                , 'stamps.stamp as stamp'
                , 'stamps.price as item_price'
            )
            ->join('users', 'users.id', '=', 'tr_change_stamps.users_id')
            ->join('students', 'students.id', '=', 'tr_change_stamps.students_id')
            ->join('tr_change_stamp_details', 'tr_change_stamps.id', '=', 'tr_change_stamp_details.tr_change_stamps_id')
            ->join('stamps', 'stamps.id', '=', 'tr_change_stamp_details.stamps_id')
            ->whereBetween('tr_change_stamps.date', [$datestart, $dateend])
            ->get();
            return $data;
        } else if($student_id && $datestart && $dateend) {
            $data = TrChangeStamps::select(
                'tr_change_stamps.id as id'
                , 'tr_change_stamps.date as date'
                , 'tr_change_stamps.note as note'
                , 'users.name as admin'
                , 'students.name as student_name'
                , 'students.code as student_id'
                , 'stamps.name as item_name'
                , 'stamps.stamp as stamp'
                , 'stamps.price as item_price'
            )
            ->join('users', 'users.id', '=', 'tr_change_stamps.users_id')
            ->join('students', 'students.id', '=', 'tr_change_stamps.students_id')
            ->join('tr_change_stamp_details', 'tr_change_stamps.id', '=', 'tr_change_stamp_details.tr_change_stamps_id')
            ->join('stamps', 'stamps.id', '=', 'tr_change_stamp_details.stamps_id')
            ->whereBetween('tr_change_stamps.date', [$datestart, $dateend])
            ->where('students.id', $student_id)
            ->orderBy('tr_change_stamps.id', 'desc')
            ->get();
            return $data;
        }
    }

    public function getReportTrChangeStampsItemDetail($id)
    {
        $data = DB::table('tr_change_stamp_details')
            ->select(
                'tr_change_stamp_details.id as id'
                , 'tr_change_stamp_details.price_start as price_start'
                , 'tr_change_stamp_details.price_end as price_end'
                , 'tr_change_stamp_details.qty as qty'
                , 'tr_change_stamp_details.discount as discount'
                , 'tr_change_stamp_details.subtotal as subtotal'
                , 'stamps.name as name'
            )
            ->join('stamps', 'stamps.id', '=', 'tr_change_stamp_details.stamps_id')
            ->where('tr_change_stamp_details.tr_change_stamps_id', $id)
            ->get();
        return $data;
    }
}
