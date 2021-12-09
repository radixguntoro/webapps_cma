<?php

namespace App\Http\Controllers\Apps\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\AutoNumber;
use Illuminate\Support\Facades\Auth;
use App\Model\Tuition;
use Validator;
use Response;
use Input;
use DB;

class TuitionCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_tuition = new Tuition();

        if ($request->get('search')) {
            $tuition = $model_tuition->getTuitionBySearch($request->get('search'));
        } else {
            $tuition = $model_tuition->getTuitionPagination();
        }
        return response($tuition);
    }

    public function insert(Request $request)
    {
        $tableName = "tuitions";
        $autoNumber = new AutoNumber();
        $primary = "code";
        $getCode = $autoNumber->generate($tableName, $primary);

        $model_tuition = new Tuition();
        $model_tuition->code = "TI".$getCode;
        $model_tuition->name = $request->name;
        $model_tuition->price = $request->price;
        $model_tuition->status = $request->status;
        $model_tuition->users_id = Auth::id();
        $model_tuition->save();
        return response()->json($model_tuition);
    }

    public function edit($id)
    {
        $model_tuition = new Tuition();
        $data_tuition = $model_tuition->getTuitionById($id)->first();

        return response()->json($data_tuition);
    }

    public function update(Request $request)
    {
        $model_tuition = Tuition::find($request->id);
        $model_tuition->name = $request->name;
        $model_tuition->price = $request->price;
        $model_tuition->status = $request->status;
        $model_tuition->users_id = Auth::id();
        $model_tuition->save();
        return response()->json($model_tuition);
    }

    public function searchTuitionSales(Request $request)
    {
        $model_tuition = new Tuition();
        $tuition = $model_tuition->searchTuitionSales($request->get('search'));
        return response($tuition);
    }

    public function getAll()
    {
        $model_tuition = new Tuition();
        $data_tuition = Tuition::all();

        return response()->json($data_tuition);
    }

    public function getTuitionDetail($id)
    {
        $data_tuition = Tuition::find($id);

        $tuition = array(
            "data_tuition" => $data_tuition
        );

        return response()->json($tuition);
    }

    public function searchTuition(Request $request)
    {
        $model_tuition = new Tuition();
        $tuition = $model_tuition->searchTuition($request->get('search'));
        return response($tuition);
    }
}
