<?php

namespace App\Http\Controllers\Apps\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use Illuminate\Support\Facades\Auth;
use App\Model\Voucher;
use Validator;
use Response;
use Input;
use DB;

class VoucherCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_voucher = new Voucher();

        if ($request->get('search')) {
            $voucher = $model_voucher->getVoucherBySearch($request->get('search'));
        } else {
            $voucher = $model_voucher->getVoucherPagination();
        }
        return response($voucher);
    }

    public function insert(Request $request)
    {
        $tableName = "vouchers";
        $primary = "code";
        $autoNumber = new AutoNumber();
        $getCode = $autoNumber->generate($tableName, $primary);

        $model_voucher = new Voucher();
        $model_voucher->code = "VC".$getCode;
        $model_voucher->name = $request->name;
        $model_voucher->price = $request->price;
        $model_voucher->qty = $request->qty;
        $model_voucher->status = $request->status;
        $model_voucher->users_id = Auth::id();
        $model_voucher->save();
        return response()->json($model_voucher);
    }

    public function edit($id)
    {
        $model_voucher = new Voucher();
        $data_voucher = $model_voucher->getVoucherById($id)->first();

        return response()->json($data_voucher);
    }

    public function update(Request $request)
    {
        $model_voucher = Voucher::find($request->id);
        $model_voucher->name = $request->name;
        $model_voucher->price = $request->price;
        $model_voucher->qty = $request->qty;
        $model_voucher->status = $request->status;
        $model_voucher->users_id = Auth::id();
        $model_voucher->save();
        return response()->json($model_voucher);
    }

    public function searchVoucherSales(Request $request)
    {
        $model_voucher = new Voucher();
        $voucher = $model_voucher->searchVoucherSales($request->get('search'));
        return response($voucher);
    }

    public function getAll()
    {
        $model_voucher = new Voucher();
        $data_voucher = Voucher::where('status', 'A')->get();

        return response()->json($data_voucher);
    }

    public function getVoucherDetail($id)
    {
        $data_voucher = Voucher::find($id);

        $voucher = array(
            "data_voucher" => $data_voucher
        );

        return response()->json($voucher);
    }
}
