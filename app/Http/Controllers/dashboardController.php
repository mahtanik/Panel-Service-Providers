<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function counter()
    {
        //Summary of the data and changes in all services
        $autocharges1 = DB::table('transactions_1513991762415000038187743')->where('action' , 'AUTO_CHARGE')->count();
        $autocharges2 = DB::table('transactions_1513991762415000000015575')->where('action' , 'AUTO_CHARGE')->count();
        $autocharges = $autocharges1 + $autocharges2;

        $unsubs1 = DB::table('transactions_1513991762415000038187743')->where('action' , 'UNSUBSCRIPTION')->count();
        $unsubs2 = DB::table('transactions_1513991762415000000015575')->where('action' , 'UNSUBSCRIPTION')->count();
        $unsubs = $unsubs1 + $unsubs2;
        $subs = DB::table('transactions_1513991762415000038187743')->where('action' , 'SUBSCRIPTION')->count();

        $total1 = DB::table('transactions_1513991762415000038187743')->count();
        $total2 = DB::table('transactions_1513991762415000000015575')->count();
        $total = $total1 + $total2;

        $totalcharge1 = DB::table('transactions_1513991762415000038187743')->where( 'action' , 'AUTO_CHARGE')->orwhere( 'action' , 'SUBSCRIPTION')->count();
        $totalcharge2 = DB::table('transactions_1513991762415000000015575')->where( 'action' , 'AUTO_CHARGE')->orwhere( 'action' , 'SUBSCRIPTION')->count();
        $totalcharge = $total + $total2;

        // calcularing the top four services to dispaly in donut-chart
        $topfour = DB::table( 'transactions_1513991762415000000015575')->select('id')->groupBy('id')->offset(0)->limit(10)->get();

        return view('dashboard' , [ 'autocharges' => $autocharges , 'unsubs' => $unsubs , 'subs'=>$subs , 'total'=> $total , 'totalcharge'=>$totalcharge , 'topfour'=> $topfour]);
    }
}
