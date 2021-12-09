<?php

namespace App\Http\Controllers\Apps\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Libraries\AutoNumber;
use App\Model\Student;
use Validator;
use Response;
use Input;
use DB;

class StudentCtrl extends Controller
{
    public function index(Request $request)
    {
        $model_student = new Student();

        if ($request->get('search')) {
            $users = $model_student->getStudentBySearch($request->get('search'));
        } else {
            $users = $model_student->getStudentPagination();
        }
        return response($users);
    }

    public function insert(Request $request)
    {
        $valid_invoice = Student::where('code', $request->code)->get();

        if (count($valid_invoice) > 0) {
            return "invalid";
        } else {
            $tableName = "students";
            $primary = "code";
            $autoNumber = new AutoNumber();
            $getCode = $autoNumber->generate($tableName, $primary);

            $model_student = new Student();
            $model_student->code = $request->code;
            $model_student->name = $request->name;
            $model_student->join_date = date("Y-m-d", strtotime($request->join_date));
            $model_student->deposit = 0;
            $model_student->status = $request->status;
            $model_student->users_id = Auth::id();
            $model_student->save();
            return response()->json($model_student);
        }
    }

    public function edit($id)
    {
        $model_student = Student::find($id);

        return response()->json($model_student);
    }

    public function update(Request $request)
    {
        $model_student = Student::find($request->id);
        $model_student->code = $request->code;
        $model_student->name = $request->name;
        $model_student->join_date = date("Y-m-d", strtotime($request->join_date));
        $model_student->deposit = $request->deposit;
        $model_student->status = $request->status;
        $model_student->users_id = Auth::id();
        $model_student->save();
        return response()->json($model_student);
    }

    public function getStudentDetail($id)
    {
        $data_student = Student::find($id);

        $student = array(
            "data_student" => $data_student
        );

        return response()->json($student);
    }

    public function searchStudent(Request $request)
    {
        $model_student = new Student();
        $student = $model_student->searchStudent($request->get('search'));
        return response($student);
    }

    public function getAll()
    {
        $model_student = new Student();
        $data_student = Student::where("status", 'A')->get();

        return response()->json($data_student);
    }
}
