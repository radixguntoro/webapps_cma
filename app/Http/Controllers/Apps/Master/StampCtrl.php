<?php

namespace App\Http\Controllers\Apps\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use Illuminate\Support\Facades\Auth;
use App\Model\Stamp;
use Validator;
use Response;
use Input;
use DB;

class StampCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_stamp = new Stamp();

        if ($request->get('search')) {
            $stamp = $model_stamp->getStampBySearch($request->get('search'));
        } else {
            $stamp = $model_stamp->getStampPagination();
        }
        return response($stamp);
    }

    public function insert(Request $request)
    {
        $valid_name = Stamp::where('name', $request->name)->get();

        if (count($valid_name) > 0) {
            return "invalid";
        } else {
            $tableName = "stamps";
            $primary = "code";
            $autoNumber = new AutoNumber();
            $getCode = $autoNumber->generate($tableName, $primary);

            $model_stamp = new Stamp();
            $model_stamp->code = "ST".$getCode;
            $model_stamp->name = $request->name;
            $model_stamp->stamp = $request->stamp;
            $model_stamp->price = $request->price;
            $model_stamp->qty = $request->qty;
            $model_stamp->status = $request->status;
            $model_stamp->users_id = Auth::id();
            $model_stamp->save();
            return response()->json($model_stamp);
        }
    }

    public function edit($id)
    {
        $model_stamp = new Stamp();
        $data_stamp = $model_stamp->getStampById($id)->first();

        return response()->json($data_stamp);
    }

    public function update(Request $request)
    {
        $model_stamp = Stamp::find($request->id);
        $model_stamp->name = $request->name;
        $model_stamp->stamp = $request->stamp;
        $model_stamp->price = $request->price;
        $model_stamp->qty = $request->qty;
        $model_stamp->status = $request->status;
        $model_stamp->users_id = Auth::id();
        $model_stamp->save();
        return response()->json($model_stamp);
    }

    public function searchStampSales(Request $request)
    {
        $model_stamp = new Stamp();
        $stamp = $model_stamp->searchStampSales($request->get('search'));
        return response($stamp);
    }

    public function getAll()
    {
        $model_stamp = new Stamp();
        $data_stamp = Stamp::all();

        return response()->json($data_stamp);
    }

    public function getStampDetail($id)
    {
        $data_stamp = Stamp::find($id);

        $stamp = array(
            "data_stamp" => $data_stamp
        );

        return response()->json($stamp);
    }

    public function searchStamp(Request $request)
    {
        $model_stamp = new Stamp();
        $stamp = $model_stamp->searchStamp($request->get('stamp'));
        return response($stamp);
    }
}
