<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use Carbon\Carbon;

class ClientmapController extends Controller
{

  public function index()
  {
    session_start();
    if(isset($_GET['longitude'])){
      $_SESSION['longitude']= $_GET['longitude'];
      $_SESSION['latitude'] = $_GET['latitude'];
    }else{
      $_SESSION['longitude']= "100.539552";
      $_SESSION['latitude'] = "13.74444";
    }

    return view("client.step01");
  }

    public function store (Request $r)
    {
        date_default_timezone_set("Asia/Bangkok");
        $view['rq_id']=$r->rq_id;

        if(isset($r->btn_way)){
            $hos=DB::table('stemi_request')->where('rq_id',$r->rq_id)->first();
            $hospital_host = DB::table('stemi_hospital')->where('hos_refno',$hos->rq_host_hos_refno)->first();
            $val['rq_last_status']='อยู่ระหว่างนำส่งผู้ป่วย';
            $val['rq_start_datetime']=Carbon::now()->format('Y-m-d H:i:s');
            DB::table('stemi_request')->where('rq_id',$r->rq_id)->update($val);
            firebase($hos->rq_host_hos_refno,'HOST','อยู่ระหว่างนำส่งผู้ป่วย',$r->rq_id);
            $event['event_hosrefno']  = $hos->rq_host_hos_refno;
            $event['event_usertype']  = "HOST";
            $event['event_message']   = "อยู่ระหว่างนำส่งผู้ป่วย";
            $event['event_rqid']      = $r->rq_id;
            $event['event_status']    = 0;
            DB::table('stemi_event')->insert($event);



            //return redirect("clientmap/".$hospital_host->hos_name_eng."".$r->rq_id);
            return redirect("mapdirection?hospital=".$hospital_host->hos_name_eng."&rq_id=".$r->rq_id);


            //return redirect("clientmap/".$r->rq_id);
        }

        if(isset($r->btn_jobcancel)){
            $hos=DB::table('stemi_request')->where('rq_id',$r->rq_id)->first();
            firebase($hos->rq_host_hos_refno,'HOST','จบงานกลางทาง',$r->rq_id);
            $event['event_hosrefno']  = $hos->rq_host_hos_refno;
            $event['event_usertype']  = "HOST";
            $event['event_message']   = "จบงานกลางทาง";
            $event['event_rqid']      = $r->rq_id;
            $event['event_status']    = 0;
            DB::table('stemi_event')->insert($event);




            $val['rq_response_status']='SUCCESS';
            DB::table('stemi_request')->where('rq_id',$r->rq_id)->update($val);

            $value['cancel_rq_id']=$r->rq_id;
            $value['cancel_hos_refno']=$hos->rq_hos_refno;
            $value['cancel_message']=$r->message."";
            DB::table('stemi_request_cancel')->insert($value);

            return redirect("patient");
        }

        if(isset($r->btn_jobsuccess)){
            $hos=DB::table('stemi_request')->where('rq_id',$r->rq_id)->first();

            firebase($hos->rq_host_hos_refno,'HOST','ส่งผู้ป่วยเสร็จสิ้น',$r->rq_id);
            $event['event_hosrefno']  = $hos->rq_host_hos_refno;
            $event['event_usertype']  = "HOST";
            $event['event_message']   = "ส่งผู้ป่วยเสร็จสิ้น";
            $event['event_rqid']      = $r->rq_id;
            $event['event_status']    = 0;
            DB::table('stemi_event')->insert($event);







            $val['rq_jobend_datetime'] = Carbon::now()->format('Y-m-d H:i:s');
            $val['rq_response_status']='SUCCESS';
            DB::table('stemi_request')->where('rq_id',$r->rq_id)->update($val);
            return redirect("patient");
        }
    }

    public function edit ($id)
    {
        $view['rq_id']=$_GET['rq_id'];
        return redirect("client.step02",$view);
    }



}
