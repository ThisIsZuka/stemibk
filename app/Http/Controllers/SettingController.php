<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use File;
class SettingController extends Controller
{
   public function get_setting(){
      $current_hos=Session::get('user')->us_hos_refno;
      $setting=DB::table('users')
      ->join('stemi_hospital','users.us_hos_refno','=','stemi_hospital.hos_refno')
      ->where('users.us_hos_refno','=',$current_hos)
      ->get();

      $phone=$setting[0]->hos_phone;
      $active=$setting[0]->hos_status;
      $hostpital=$setting[0]->hos_status;
      Session(['hostpital'=>$hostpital]);
      // dd($setting);
      return response()->json(array(
        'phone' =>$phone ,
        'status'=>$active,
     ));

   }
   public function save_setting(Request $request){
       
      $current_hos=Session::get('user')->us_hos_refno;
      $mobile=$request->input('mobile');
      $status_chk=$request->input('status_chk');
      Session(['hostpital'=>$status_chk]);
      $setting=DB::table('stemi_hospital')
      ->where('hos_refno', $current_hos)
      ->update(['hos_phone' => $mobile ,'hos_status'=>$status_chk]);
      
      return response()->json(array(
        'success' =>true

     ));
   }

// public function save_setting(Request $request){
//     $current_hos=Session::get('user')->us_hos_refno;
//     $mobile=$request->input('mobile');
//     $status_hos=$request->input('status_chk');
//     $setting=DB::table('stemi_hospital')
//     ->where('hos_refno', $current_hos)
//     ->update(['hos_phone' => $mobile,'hos_status'=>$status_hos]);
//       return response()->json(array(
//       'success'=>true,'status_hospital'=>$status_hos));
//  }
}
