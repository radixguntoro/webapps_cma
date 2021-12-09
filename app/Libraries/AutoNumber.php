<?php

namespace App\Libraries;

use Input;
use DB;

class AutoNumber
{

	public function generate($tableName, $primary)
	{
		$query = DB::table($tableName)->select(DB::raw('MAX(RIGHT('.$primary.', 3)) as kode_max'));
		$date = date("ymdHis");
		if ($query->count()>0) {
			foreach ($query->get() as $value) {
				$kode = $date;
			}
		} else {
			$kode = $date;
		}

		return $kode;
	}

	public function generateCode($tableName, $primary, $key)
	{
		$query = DB::table($tableName)->latest('id')->first();;

		//check first day in a year
		if (count($query) > 0 && $query->date == date('Y-m-d')) {
			$expNum = substr($query->code, -4);
			if (date('l',strtotime(date('Y-01-01')))){
				$nextInvoiceNumber = date('ymd').$expNum+1;
			}
		} else {
			if (date('l',strtotime(date('Y-01-01')))){
				$nextInvoiceNumber = date('ymd').'000'.$key;
			} else {
				$nextInvoiceNumber = date('ymd').$expNum+1;
			}
		}

		return $nextInvoiceNumber;
	}
}
