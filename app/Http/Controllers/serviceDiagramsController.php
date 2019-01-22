<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class serviceDiagramsController extends Controller
{
    public function Diagrams(Request $request){


        $serviceId = $request->get('ss');

        //Data for Diagrams - since we show for 3 different months, we calculate from current month and month-1 and month-2
        $autocharge1 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'AUTO_CHARGE')->whereMonth('CreatedOn' , $month-9)->count();
        $autocharge2 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'AUTO_CHARGE')->whereMonth('CreatedOn' , $month-8)->count();
        $autocharge3 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'AUTO_CHARGE')->whereMonth('CreatedOn' , $month-7)->count();

        $unsub1 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'UNSUBSCRIPTION')->whereMonth('CreatedOn' , $month-9)->count();
        $unsub2 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'UNSUBSCRIPTION')->whereMonth('CreatedOn' , $month-8)->count();
        $unsub3 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'UNSUBSCRIPTION')->whereMonth('CreatedOn' , $month-7)->count();

        $sub1 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'SUBSCRIPTION')->whereMonth('CreatedOn' , $month-9)->count();
        $sub2 = DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'SUBSCRIPTION')->whereMonth('CreatedOn' , $month-8)->count();
        $sub3= DB::table('tb_transactions')->where('serviceId',$serviceId)->where('action', 'SUBSCRIPTION')->whereMonth('CreatedOn' , $month-7)->count();

        $total1 = DB::table('tb_transactions')->where('serviceId',$serviceId)->whereMonth('CreatedOn' , $month-9)->count();
        $total2 = DB::table('tb_transactions')->where('serviceId',$serviceId)->whereMonth('CreatedOn' , $month-8)->count();
        $total3 = DB::table('tb_transactions')->where('serviceId',$serviceId)->whereMonth('CreatedOn' , $month-7)->count();


    }

    public function Fill()
    {

        $selectedService = Input::get('selectService');
        $services = DB::select('select service_name from service_details2');
        $id = DB::table('service_details2')->select('service_id')->where('service_name', $selectedService)->pluck('service_id')->first();
        $autocharges = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'AUTO_CHARGE')->count();
        $unsubs = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'UNSUBSCRIPTION')->count();
        $subs = DB::table('tb_transactions')->where('serviceId',$id)->where('action', 'SUBSCRIPTION')->count();
        $total = DB::table('tb_transactions')->where('serviceId',$id)->count();
        $totalcharges = DB::table('tb_transactions')->where('serviceId',$id)->where( 'action' , 'AUTO_CHARGE')->orwhere( 'action' , 'SUBSCRIPTION')->count();



        return view('servicesDiagrams', ['id'=>$id , 'selectedService'=>$selectedService , 'services'=>$services  , 'autocharges' => $autocharges, 'unsubs' => $unsubs, 'subs' => $subs, 'total' => $total , 'totalcharges' => $totalcharges ]);

    }

}
