<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;


class ChatController extends Controller
{

    public function index()
    {
        session_start();
    return view("patient.chat");


    }


    public function store(Request $r)
  {
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    if($_SESSION['user']->user_type == 'HOST' || $_SESSION['user']->user_type == 'DOCTOR'){
      $user_login = DB::table('stemi_request')->where('rq_host_hos_refno','=',$_SESSION['user']->us_hos_refno)->orderby('rq_id','desc')->first();
      $event['event_hosrefno']  = $_SESSION['user']->us_hos_refno;
      $event['event_usertype']  = "CLIENT";
      $event['event_message']   = "chat";
      $event['event_rqid']      = $r->rq_id;
      $event['event_status']    = 0;
      DB::table('stemi_event')->insert($event);
    }else{
      $user_login = DB::table('stemi_request')->where('rq_hos_refno','=',$_SESSION['user']->us_hos_refno)->orderby('rq_id','desc')->first();
      $event['event_hosrefno']  = $_SESSION['user']->us_hos_refno;
      $event['event_usertype']  = "HOST";
      $event['event_message']   = "chat";
      $event['event_rqid']      = $r->rq_id;
      $event['event_status']    = 0;
      DB::table('stemi_event')->insert($event);
    }


    $val['ms_room_refno'] = $user_login->rq_pt_refno;
    $val['ms_us_refno']   = $_SESSION['user']->us_hos_refno;
    $val['ms_us_group']   = $_SESSION['user']->user_type;
    $val['ms_message']    = $r->chat."";

    if($_FILES["file"]["name"] != "" || $_FILES["file"]["name"] != null)
      {
          if(move_uploaded_file($_FILES["file"]["tmp_name"],"ms_img/".Carbon::now()->format('YmdHis').$_FILES["file"]["name"]))
          {
              $val['ms_img'] = Carbon::now()->format('YmdHis').$_FILES["file"]["name"];
          }
      }
    DB::table('stemi_message')->insert($val);



    return redirect()->back();
  }

}
