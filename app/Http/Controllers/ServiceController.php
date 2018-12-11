<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function service_summary()
    {
        $services = DB::select('select service_name from service_details2');

        return view('servicesSummary', ['services'=>$services]);
    }

    public function services()
    {
        $services = DB::select('select service_name from service_details2');

        return view('services', ['services'=>$services]);
    }



    public function counter()
    {
        $autocharges = DB::table('transactions_1513991762415000038187743')->where('action' , 'AUTO_CHARGE')->count();
    //$a = DB::table('transactions_1513991762415000038187743')->join('transactions_1513991762415000000015575' , 'transactions_1513991762415000038187743'.action , '=' , 'ransactions_1513991762415000000015575.action' )
$unsubs = DB::table('transactions_1513991762415000038187743')->where('action' , 'UNSUBSCRIPTION')->count();
$subs = DB::table('transactions_1513991762415000038187743')->where('action' , 'SUBSCRIPTION')->count();
$total = DB::table('transactions_1513991762415000038187743')->count();
$totalcharge = DB::table('transactions_1513991762415000038187743')->where( 'action' , 'AUTO_CHARGE')->orwhere( 'action' , 'SUBSCRIPTION')->count();
return view('dashboard' , [ 'autocharges' => $autocharges , 'unsubs' => $unsubs , 'subs'=>$subs , 'total'=> $total , 'totalcharge'=>$totalcharge]);
}

    public function giveDetails(){

        $user = DB::table('tb_user')->select('msisdn')->get();
        $mobilenum = DB::table('transactions_1513991762415000000015575')->select('msisdn')->get();
        $certificate = DB::table('tb_users')->select('certification')->join('transactions_1513991762415000000015575' ,'transactions_1513991762415000000015575.msisdn' , '=' , 'tb_users.msisdn')->get();
        $CreatedOn = DB::table('tb_users')->select('CreatedOn')->join('transactions_1513991762415000000015575' , 'transactions_1513991762415000000015575.msisdn' , '=' , 'tb_users.msisdn' )->get();
        $status = DB::table('tb_users')->select('status')->join('transactions_1513991762415000000015575' , 'transactions_1513991762415000000015575.msisdn' , '=' , 'tb_users.msisdn' )->get();

        return view('services' , [ 'user'=>$user , 'mobilenum' => $mobilenum , 'certificate'=> $certificate , 'CreatedOn'=>$CreatedOn , 'status'=>$status]);
    }
}
