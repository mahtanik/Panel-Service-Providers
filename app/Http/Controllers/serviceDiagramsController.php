<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class serviceDiagramsController extends Controller
{
    public function Fill()
    {
        $date = Carbon:: now()->toDateString();
        $month = substr($date , -5 , 2);

        $selectedService = Input::get('selectService');
        $services = DB::select('select service_name from service_details2');
        $id = DB::table('service_details2')->select('service_id')->where('service_name', $selectedService)->pluck('service_id')->first();
        $autocharges = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'AUTO_CHARGE')->count();
        $unsubs = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'UNSUBSCRIPTION')->count();
        $subs = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'SUBSCRIPTION')->count();
        $total = DB::table('tb_transactions')->where('serviceId',$id)->count();
        $totalcharges = DB::table('tb_transactions')->where('serviceId',$id)->where( 'action' , 'AUTO_CHARGE')->orwhere( 'action' , 'SUBSCRIPTION')->count();

        //Data for Diagrams - since we show for 3 different months, we calculate from current month and month-1 and month-2
        $autocharge1 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'AUTO_CHARGE')->whereMonth('CreatedOn' , $month-9)->count();
        $autocharge2 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'AUTO_CHARGE')->whereMonth('CreatedOn' , $month-8)->count();
        $autocharge3 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'AUTO_CHARGE')->whereMonth('CreatedOn' , $month-7)->count();

        $unsub1 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'UNSUBSCRIPTION')->whereMonth('CreatedOn' , $month-9)->count();
        $unsub2 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'UNSUBSCRIPTION')->whereMonth('CreatedOn' , $month-8)->count();
        $unsub3 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'UNSUBSCRIPTION')->whereMonth('CreatedOn' , $month-7)->count();

        $sub1 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'SUBSCRIPTION')->whereMonth('CreatedOn' , $month-9)->count();
        $sub2 = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'SUBSCRIPTION')->whereMonth('CreatedOn' , $month-8)->count();
        $sub3= DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'SUBSCRIPTION')->whereMonth('CreatedOn' , $month-7)->count();

        $total1 = DB::table('tb_transactions')->where('serviceId',$id)->whereMonth('CreatedOn' , $month-9)->count();
        $total2 = DB::table('tb_transactions')->where('serviceId',$id)->whereMonth('CreatedOn' , $month-8)->count();
        $total3 = DB::table('tb_transactions')->where('serviceId',$id)->whereMonth('CreatedOn' , $month-7)->count();

        $details = array(array($autocharge1 , $unsub1 , $sub1 , $total1 , $month-9) , array($autocharge2 , $unsub2 , $sub2 , $total2 , $month-8) , array($autocharge3 , $unsub3 , $sub3 , $total3, $month-7));

        return view('servicesDiagrams', ['details'=>$details , 'selectedService'=>$selectedService , 'services'=>$services  , 'autocharges' => $autocharges, 'unsubs' => $unsubs, 'subs' => $subs, 'total' => $total , 'totalcharges' => $totalcharges ]);

    }

}
