<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use PhpParser\Node\Expr\Cast;

class ServiceController extends Controller
{

    public function service_summary()
    {
        $services = DB::select('select service_name from service_details2');
        $selectedService = Input::get('selectService');

        $ids = DB::table('service_details2')->select('service_id')->where('service_name' , $selectedService)->pluck('service_id')->first();
        $date = DB::table('tb_transactions')->where('serviceId' , $ids )->take(30)->pluck('CreatedOn');

        $subs = DB::table('tb_transactions')->where('action' , 'SUBSCRIPTION')->where('serviceId' , $ids)->count();
        $unsubs = DB::table('tb_transactions')->where('action' ,'UNSUBSCRIPTION')->where('serviceId' , $ids)->count();
        $autocharges = DB::table('tb_transactions')->where('action' ,  'AUTO_CHARGE')->where('serviceId' , $ids)->count();

        return view('servicesSummary', ['services' => $services , 'selectedService' => $selectedService ,'date'=>$date , 'subs'=>$subs , 'unsubs'=>$unsubs , 'autocharges'=>$autocharges]);
    }

    public function services()
    {
        $services = DB::select('select service_name from service_details2');
        $selectedService = Input::get('selectService');

        $ids = DB::table('service_details2')->select('service_id')->where('service_name', $selectedService)->pluck('service_id')->first();
        $date = DB::table('tb_transactions')->where('serviceId', $ids)->distinct('CreatedOn')->pluck('CreatedOn')->take(30);
        $subs = array();
        $unsubs = array();
        $autocharges = array();
        $i = 0;

        foreach ($date as $day) {
            $subs[$i] = DB::table('tb_transactions')->where('action', 'SUBSCRIPTION')->where('serviceId', $ids)->whereDate('CreatedOn', $day)->count();
            $unsubs[$i] = DB::table('tb_transactions')->where('action', 'UNSUBSCRIPTION')->where('serviceId', $ids)->whereDate('CreatedOn', $day)->count();
            $autocharges[$i] = DB::table('tb_transactions')->where('action', 'AUTO_CHARGE')->where('serviceId', $ids)->whereDate('CreatedOn', $day)->count();
            $i++;
        }

        $j = 0;
        $user_number=array();
        $user_status=array();
        $user_charges=array();
        $user_certificate=array();

        $users = DB::table('tb_users')->where('service_id',$ids)->take(20)->get();
    //dd($users);
        foreach ($users as $user) {
            $user_number[$j] = $user->msisdn;
            $user_certificate[$j]= $user->certification;
            $user_charges[$j]= $user->auto_charge;
            $user_status[$j]= $user->status;
            $j++;
        }

            return view('services', ['users'=>$users , 'user_certificate'=>$user_certificate , 'user_number'=>$user_number , 'user_status'=>$user_status , 'user_charges'=>$user_charges , 'date' => $date, 'services' => $services, 'selectedService' => $selectedService, 'ids' => $ids, 'subs' => $subs, 'unsubs' => $unsubs, 'autocharges' => $autocharges]);

        }


}
