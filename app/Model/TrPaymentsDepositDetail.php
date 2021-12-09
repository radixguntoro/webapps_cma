<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class TrPaymentsDepositDetail extends Model
{
    protected $table = 'tr_payment_deposit_details';
    public $timestamps = false;
}
