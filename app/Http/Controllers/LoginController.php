<?php
namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
   public function index(){

    $title='รายการข้อมูลผู้ป่วย';

    if(empty(Session::get('user')->us_hos_refno)){
      return view('auth.login');
   }

   $hos_current=Session::get('user')->us_hos_refno;

   $client = array("rq_hos_refno","=",Session::get('user')->us_hos_refno);
   $host   = array("rq_host_hos_refno","=",Session::get('user')->us_hos_refno);

   $view=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_request.rq_hos_refno',$hos_current)
   ->orderby('pt_id','desc')
   ->get();

   $accept=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_request.rq_hos_refno',$hos_current)
   ->where('stemi_request.rq_response_status','=',1)
   ->orderby('pt_id','desc')
   ->get();


   // สถานะรับปลายทางพลาดรับผู้ป่วย
   $fail=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_request.rq_hos_refno',$hos_current)
   ->where('stemi_request.rq_response_status','=',2)
   ->orderby('pt_id','desc')
   ->get();



  $fail_list="";
   foreach ($fail as $result) {
      $fail_list.='<div class="p-section">
      <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'"></div>
      <div class="txt-p">'.$result->pt_name.'</div>
      <div class="txt-time">วันที่เวลาบันทึก/รับผู้ป่วย'.$result->pt_name.'</div>
      <div><button class="btn btn-stemi-accept">ดูผล EKG</button></div></div>';
   }




   $accept_list="";
   foreach ($accept as $result) {
      $accept_list.='<div class="p-section">
      <div class="row">
      <div class="col-4">
      <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div></div>
      <div class="col-6">
      <div class="txt-p">'.$result->pt_name.'</div>
      <div class="txt-time">วันที่เวลาบันทึก/รับผู้ป่วย</div>
      <div><button class="btn btn-stemi-accept">ดูผล EKG</button></div>
      </div>
      <div class="col-2">
      <div><i class="fa fa-share-alt" aria-hidden="true" style="font-size: 50px;
      color: #ca004e;"></i> ส่งต่อ</div>
      </div>
      </div>

      </div>'
      ;
   }



   // header('Location: patient');
   // error_log("patient");

   return redirect('patient');
   // return view("patient.index")
   // ->with(['view'=>$view])
   // ->with(['title'=>$title])
   // ->with(['accept_list'=>$accept_list])
   // ->with(['fail_list'=>$fail_list])
   // ;

}

public function check_login(Request $request)
{
    $username = $request->input('username');
    $password=$request->input('password');
    $count = DB::table('users')->where('email','=',$request->username)->count();
    if($count>0){
        $user = DB::table('users')->where('email','=',$username)
        ->join('stemi_hospital', 'stemi_hospital.hos_refno', '=', 'users.us_hos_refno')
        ->first();
        $hos_lefno=$user->us_hos_refno;
        $hostpital=$user->hos_status;
        Session(['hostpital'=>$hostpital]);
        $check = Hash::check($password,$user->password);

        if($check){
            Session(['user' => $user]);
            @session_start();
            $_SESSION['hoslefno']=$hos_lefno;

// dd(session('user'));
            return response()->json(array(
                'success' => true,
                'message'=>'เข้าสู่ระบบสำเร็จ'));
        }else{
            return response()->json(array(
            'success' => false,
            'message' => 'Username หรือ Password ผิดพลาด กรุณาตรวจสอบ'));
        }
    }
}
public function logout(){
   @session_start();
   unset($_SESSION['hoslefno']);
   Session::forget('user');
   return redirect('/');

}
}

