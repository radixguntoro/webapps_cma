<?php

namespace App\Http\Controllers\Apps\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ReportIncomeStatement;
use App\Model\User;
use App\Model\Student;
use Validator;
use Excel;
use DB;

class ReportIncomeStatementCtrl extends Controller
{
    public function filterReportIncomeStatement(Request $request)
    {
        $model_report_income_statement = new ReportIncomeStatement();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');
        if ($datestart || $dateend) {
            $report_income_tuition = $model_report_income_statement->getReportIncomeStatementTuitionByFilter($datestart, $dateend);
            $report_income_item = $model_report_income_statement->getReportIncomeStatementItemByFilter($datestart, $dateend);
            $report_income_deposit = $model_report_income_statement->getReportIncomeStatementDepositByFilter($datestart, $dateend);
            $report_income_poi = $model_report_income_statement->getReportIncomeStatementPOIByFilter($datestart, $dateend);
            $report_income_por = $model_report_income_statement->getReportIncomeStatementPORByFilter($datestart, $dateend);
            $report_income_soi = $model_report_income_statement->getReportIncomeStatementSOIByFilter($datestart, $dateend);
            $report_income_sor = $model_report_income_statement->getReportIncomeStatementSORByFilter($datestart, $dateend);

            $total_income_tuition = 0;
            foreach ($report_income_tuition as $key_report => $val) {
                $total_income_tuition += $val->subtotal;
            };

            $total_income_book = 0;
            foreach ($report_income_item as $key_report => $val) {
                if ($val->category=='Books') {
                    $total_income_book += $val->subtotal;
                }
            };

            $total_income_accessory = 0;
            foreach ($report_income_item as $key_report => $val) {
                if ($val->category=='Accessory') {
                    $total_income_accessory += $val->subtotal;
                }
            };

            $total_income_deposit = 0;
            foreach ($report_income_deposit as $key_report => $val) {
                $total_income_deposit += $val->subtotal;
            };

            $total_income_poi = 0;
            foreach ($report_income_poi as $key_report => $val) {
                $total_income_poi += $val->subtotal;
            };

            $total_income_por = 0;
            foreach ($report_income_por as $key_report => $val) {
                $total_income_por += $val->subtotal;
            };

            $total_income_soi = 0;
            foreach ($report_income_soi as $key_report => $val) {
                $total_income_soi += $val->price_sell_difference;
            };

            $total_income_sor = 0;
            foreach ($report_income_sor as $key_report => $val) {
                $total_income_sor += $val->price_sell_difference;
            };

            $data_income_statement = array(
                "total_income_tuition" => $total_income_tuition,
                "total_income_book" => $total_income_book,
                "total_income_accessory" => $total_income_accessory,
                "total_income_deposit" => $total_income_deposit,
                "total_income_poi" => $total_income_poi,
                "total_income_por" => $total_income_por,
                "total_income_soi" => $total_income_soi,
                "total_income_sor" => $total_income_sor,
            );

            return response($data_income_statement);
        }
    }

    public function exportExcel(Request $request)
    {
        $model_report_income_statement = new ReportIncomeStatement();
        $datestart = $request->get('datestart');
        $dateend = $request->get('dateend');

        $periode_start = date("d-m-Y", strtotime($datestart));
        $periode_end = date("d-m-Y", strtotime($dateend));

        if ($datestart || $dateend) {
            $report_income_tuition = $model_report_income_statement->getReportIncomeStatementTuitionByFilter($datestart, $dateend);
            $report_income_item = $model_report_income_statement->getReportIncomeStatementItemByFilter($datestart, $dateend);
            $report_income_deposit = $model_report_income_statement->getReportIncomeStatementDepositByFilter($datestart, $dateend);
            $report_income_poi = $model_report_income_statement->getReportIncomeStatementPOIByFilter($datestart, $dateend);
            $report_income_por = $model_report_income_statement->getReportIncomeStatementPORByFilter($datestart, $dateend);
            $report_income_soi = $model_report_income_statement->getReportIncomeStatementSOIByFilter($datestart, $dateend);
            $report_income_sor = $model_report_income_statement->getReportIncomeStatementSORByFilter($datestart, $dateend);

            $total_income_tuition = 0;
            foreach ($report_income_tuition as $key_report => $val) {
                $total_income_tuition += $val->subtotal;
            };

            $total_income_book = 0;
            foreach ($report_income_item as $key_report => $val) {
                if ($val->category=='Books') {
                    $total_income_book += $val->subtotal;
                }
            };

            $total_income_accessory = 0;
            foreach ($report_income_item as $key_report => $val) {
                if ($val->category=='Accessory') {
                    $total_income_accessory += $val->subtotal;
                }
            };

            $total_income_deposit = 0;
            foreach ($report_income_deposit as $key_report => $val) {
                $total_income_deposit += $val->subtotal;
            };

            $total_income_poi = 0;
            foreach ($report_income_poi as $key_report => $val) {
                $total_income_poi += $val->subtotal;
            };

            $total_income_por = 0;
            foreach ($report_income_por as $key_report => $val) {
                $total_income_por += $val->subtotal;
            };

            $total_income_soi = 0;
            foreach ($report_income_soi as $key_report => $val) {
                $total_income_soi += $val->price_sell_difference;
            };

            $total_income_sor = 0;
            foreach ($report_income_sor as $key_report => $val) {
                $total_income_sor += $val->price_sell_difference;
            };

            $data_excel = array(
                "periode_datestart" => $datestart,
                "periode_dateend" => $dateend,
                "total_income_tuition" => $total_income_tuition,
                "total_income_book" => $total_income_book,
                "total_income_accessory" => $total_income_accessory,
                "total_income_deposit" => $total_income_deposit,
                "total_income_poi" => $total_income_poi,
                "total_income_por" => $total_income_por,
                "total_income_soi" => $total_income_soi,
                "total_income_sor" => $total_income_sor
            );

            // cetak_r($data_excel);
            // return view('templates.apps.export.excelIncomeStatement', compact('data_excel'));

            $export_cxcel = Excel::create('REP-INCOMESTATEMENT-'.$periode_start.'-'.$periode_end, function($excel) use ($data_excel) {
                $excel->sheet('SHEET', function($sheet) use ($data_excel) {
                    $sheet->loadView('templates.apps.export.excelIncomeStatement', compact('data_excel'));
                });
            })->export('xls')->only('id');

            return $export_cxcel;
        }
    }
}
