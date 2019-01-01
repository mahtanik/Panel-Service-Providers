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

        $details = DB::select('select serviceId,CreatedOn,SUM(CASE WHEN action="SUBSCRIPTION" THEN 1 ELSE 0 END) AS "SUBSCRIPTION",SUM(CASE WHEN action="UNSUBSCRIPTION" THEN 1 ELSE 0 END) AS "UNSUBSCRIPTION",SUM(CASE WHEN action="AUTO_CHARGE" THEN 1 ELSE 0 END) AS "AUTO_CHARGE" from tb_transactions GROUP BY serviceId,CreatedOn ORDER BY CreatedOn ');
        //dd($details);

        $j = 0;
        $user_number=array();
        $user_action=array();
        $user_CreatedOn = array();

        $users = DB::table('tb_transactions')->where('serviceId',$ids)
            ->take(20)->get();

        foreach ($users as $user) {
            $user_number[$j] = $user->msisdn;
            $user_action[$j]= $user->action;
            $user_CreatedOn[$j] = $user->CreatedOn;
            $j++;
        }

        return view('servicesSummary', ['user_action'=>$user_action , 'users'=>$users , 'user_CreatedOn'=>$user_CreatedOn , 'user_number'=>$user_number  , 'ids'=>$ids , 'details'=>$details  , 'services' => $services , 'selectedService' => $selectedService]);
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
        $users = array();
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
        $user_CreatedOn = array();
        $users = DB::table('tb_users')->where('service_id',$ids)
            ->take(20)->get();
        foreach ($users as $user) {
            $user_number[$j] = $user->msisdn;
            $user_charges[$j]= $user->auto_charge;
            $user_certificate[$j]= $user->certification;
            $user_status[$j]= $user->status;
            $user_CreatedOn[$j] = $user->CreatedOn;
            $j++;
        }
            return view('services', ['user_CreatedOn'=>$user_CreatedOn , 'user_certificate'=>$user_certificate , 'user_number'=>$user_number , 'user_status'=>$user_status , 'user_charges'=>$user_charges , 'users'=>$users  , 'date' => $date, 'services' => $services, 'selectedService' => $selectedService, 'ids' => $ids, 'subs' => $subs, 'unsubs' => $unsubs, 'autocharges' => $autocharges]);

        }


}
