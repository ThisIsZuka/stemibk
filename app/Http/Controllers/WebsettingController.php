<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;

class WebsettingController extends Controller
{

    public function index()
    {
    // session_start();
    return view("patient.setting");

    }

    public function store(Request $r)
    {
        session_start();
//         $setting = DB::table('users')
//               ->join('stemi_hospital','users.us_hos_refno','stemi_hospital.hos_refno')
//               ->where('us_hos_refno','=',$_SESSION['user']->us_hos_refno)
//               ->first();
//         $setting->hos_status;





//    if($setting->user_type == 'HOST'){
//      if($setting->hos_status == 'CLOSE')
//      {
//         $val['hos_status']='OPEN';
//      }
//      if($setting->hos_status == 'OPEN')
//      {
//       $val['hos_status']='CLOSE';
//      }
//      DB::table('stemi_hospital')->where('hos_name','=',$setting->hos_name)->udate($val);
//    }
    $se = DB::table('stemi_hospital')->where('hos_refno',$_SESSION['user']->us_hos_refno)->first();
    // dd($r,$_SESSION['user']->us_hos_refno,$se,$r->hos_status);
    $data['hos_status']=$r->hos_status;
    DB::table('stemi_hospital')
    ->where('hos_refno',$se->hos_refno)
    ->update($data);

    return redirect('setting');

    }
    public function update(Request $r,$id)
    {
        // dd($r,$id);
        $val['phone'] = $r->phone;
        DB::table('users')->where('id',$id)->update($val);
        return redirect('setting');
    }

}
