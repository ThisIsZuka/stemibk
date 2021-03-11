<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use File;

class PatientController extends Controller

{
 public function doctor_view(Request $request){

    $doctorid=Session::get('user')->us_hos_refno;
        $list=DB::table('stemi_patient')
        ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
        ->Where('stemi_request.doctor_view','=',$doctorid)
        ->orderBy('pt_id','DESC')
        ->GET();

      

   // dd($list);

      
        if(count($list)==0){
            $data="ไม่มีข้อมูล";
            return view('patient.index')
            ->with(['accept_list'=>$data]);
        }else{

            $listdoctor='';
            
            foreach( $list AS $result){
          
                  $listdoctor.='
                  <div class="p-section">
                  <div class="row" style="padding: 18px;">
                   <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div>
                  <div class="txt-p col-6">'.$result->pt_name.'
                  <div class="txt-time ">วันที่เวลาบันทึก/รับผู้ป่วย</div>
                  <div class="txt-time">'.$result->pt_update.'</div>
                  </div>
                  <div><button id="ekg_view" data-id="'.$result->pt_refno.'"  class="ekg_view btn-secondary btn btn-stemi-accept">ดูผล EKG <div><i class="fa fa-heartbeat" aria-hidden="true"></i></div></button></div></div>
                  </div>
                  ';

            }

            // <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div>
         
           
    
            // return view("patient.index")
            // ->with(['view'=>$view])
            // ->with(['fail_list'=>""])
            // ->with(['accept_list'=>""])
            // ->with(['list_doctor'=>$list_doctor]);



            return response()->json(['data'=>'success','list'=>$listdoctor]);

            // return view("patient.index")
            // ->with(['listdoctor'=>$listdoctor]);
            // ->with(['fail_list'=>""])
            // ->with(['accept_list'=>$list]);
        }


 }

  public function index(Request $r)

  {
   $tab = $r->input('tab') ;
   $title='รายการข้อมูลผู้ป่วย';
   if(empty(Session::get('user')->us_hos_refno)){
      return view('auth.login');
   }
   $hos_current=Session::get('user')->us_hos_refno;

   $client = array("rq_hos_refno","=",Session::get('user')->us_hos_refno);
   $host   = array("rq_host_hos_refno","=",Session::get('user')->us_hos_refno);

// สถานะกำลังส่งตัวผู้ป่วยจากโรงบาลต้นทาง
   $view=DB::table('stemi_patient')
   ->leftJoin('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->leftJoin('stemi_request_cancel','stemi_request.rq_id','=','stemi_request_cancel.cancel_rq_id')
   ->leftJoin('stemi_hospital','stemi_request.rq_hos_refno','=','stemi_hospital.hos_refno')
   ->where('stemi_request.rq_us_refno',$hos_current)
   ->where('stemi_request.rq_sending_status','=',1)
   ->groupBy('stemi_patient.pt_id')
   ->orderby('pt_id','desc')
   ->get();


// สถานะรับตัวผู้ป่วยจากต้นทาง
   $accept=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->join('stemi_hospital','stemi_patient.pt_us_refno','=','stemi_hospital.hos_refno')
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

   // สถานะปฏิเสธ
   $reject=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->leftJoin('stemi_request_cancel','stemi_request.rq_id','=','stemi_request_cancel.cancel_rq_id')
   ->where('stemi_request.rq_hos_refno',$hos_current)
   ->where('stemi_request.rq_response_status','=',3)
   ->orderby('cancel_id','desc')
   ->get();


   $view_list="";
   foreach ($view as $result) {
      $view_list.='<div class="p-section">
      <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div>
      <div class="txt-p">'.$result->pt_name.'</div>
      <div class="txt-time">วันที่เวลาบันทึก/รับผู้ป่วย</div>
      <div class="txt-time">'.$result->pt_update.'</div>

      <div><button class="btn btn-stemi-accept">ดูผล EKG</button></div></div>';
   }

   $accept_list="";
   foreach ($accept as $result) {

      $accept_list.='<div class="p-section">
      <div class="row">
      <div class="col-4">
      <div style="margin-bottom:10px;" class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div>
      <button id="ekg_view"  data_id="'.$result->pt_refno.'" class="btn btn-stemi-accept" >ดูผล EKG</button>
      </div>
      <div class="col-6">
      <div class="txt-p">'.$result->pt_name.'</div>
      <div class="txt-time">วันที่เวลาบันทึก/รับผู้ป่วย</div>
      <div class="txt-time">'.$result->pt_update.'</div>
      <div> <button onclick=onclickMapHospital('.$result->pt_id.',"'.$result->hos_phone.'") class="btn btn-stemi-info">ตำแหน่ง</button></div>
      </div>
      <div class="col-2">
      <i  id="'.$result->pt_id.'" class="fa fa-address-card-o patent_profile" aria-hidden="true" style="font-size:7vh;
       margin-top: 29px;"></i>   
      <div  style="margin-top:50px;">

        <i id="icon_she" class="fa fa-share-alt icon_she" style="font-size: 50px ;
      color: #c0c0c0;"></i></div>
      </div>
      </div>
      </div>';
   }


   $fail_list="";
   foreach ($fail as $result) {
      $fail_list.='
      <div class="p-section">
      <div class="row">
      <div class="col-4">
      <div style="margin-bottom:10px;" class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div>
      <button id="ekg_view"  data_id="'.$result->pt_refno.'" class="btn btn-stemi-accept" >ดูผล EKG</button>
      </div>
      <div class="col-6">
      <div class="txt-p">'.$result->pt_name.'</div>
      <div class="txt-time">วันที่เวลาบันทึก/รับผู้ป่วย</div>
      <div class="txt-time">'.$result->pt_update.'</div>
      <div class="txt-time">สาเหตุ: </div>
      </div>
      </div>
      </div>
      ';
   }

//    <div class="p-section">
//       <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'"></div>
//       <div class="txt-p">'.$result->pt_name.'</div>
//       <div class="txt-time">วันที่เวลาบันทึก: '.$result->pt_update.'</div></div>
//       <!-- <div><a href="{{url("ekg_view")}}" class="btn btn-stemi-accept">ดูผล EKG</a</div></div> --!>

   $reject_list="";
   foreach ($reject as $result) {
      $reject_list.='

      <div class="p-section">
      <div class="row">
      <div class="col-4">
      <div style="margin-bottom:10px;" class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div>
      <button id="ekg_view"  data_id="'.$result->pt_refno.'" class="btn btn-stemi-accept" >ดูผล EKG</button>
      </div>
      <div class="col-6">
      <div class="txt-p">'.$result->pt_name.'</div>
      <div class="txt-time">วันที่เวลาบันทึก/รับผู้ป่วย</div>
      <div class="txt-time">'.$result->pt_update.'</div>
      <div class="txt-time">สาเหตุ: '.$result->cancel_message.'</div>
      </div>

      </div>
      </div>

      ';
   }

   $doctorid=Session::get('user')->us_hos_refno;

   $list=DB::table('stemi_patient')
   ->leftJoin('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->Where('stemi_request.doctor_view','=',$doctorid)
   ->GET();

//    <div class="col-2">
//    <div style="margin-top:50px;">
//      <i class="fa fa-share-alt" aria-hidden="true" style="font-size: 50px ;
//    color: #c0c0c0;"></i></div>
//    </div>
     //   <div class="p-section">
    //   <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'"></div>
    //   <div class="txt-p">'.$result->pt_name.'</div>
    //   <div class="txt-time">วันที่เวลาบันทึก: '.$result->pt_update.'</div>
    //   <div class="txt-time">สาเหตุ: '.$result->cancel_message.'</div>
    //   </div>
    //   <!-- <div><a href="{{url("ekg_view")}}" class="btn btn-stemi-accept">ดูผล EKG</a</div></div> --!>

    foreach( $list AS $result){

        $list.='
        <div class="p-section">
        <div class="txt-p"><img src="'.asset('/').'public/patient_pic'.'/'.$result->pt_picture.'" class="img-fluid"></div>
        <div class="txt-p">'.$result->pt_name.'</div>
        <div class="txt-time">วันที่เวลาบันทึก/รับผู้ป่วย</div>
        <div class="txt-time">'.$result->pt_update.'</div>
        <div><button class="btn btn-stemi-accept">ดูผล EKG</button></div></div>
        ';

    }

   return view("patient.index")
   ->with(['view'=>$view])
   ->with(['accept_list'=>$accept_list])
   ->with(['fail_list'=>$fail_list])
   ->with(['reject_list'=>$reject_list])
   ->with(['list_doctor'=>$list])
   ->with(['title'=>$title])
   ->with(['tab'=>$tab]);
}

public function patient_load(Request $request)
{
   $patient_load = DB::table('stemi_patient')->paginate(15);
   $data = '';
   if ($request->ajax()) {
      foreach ($patient_load as $post) {
         $data.='<li>'.$post->pt_id.' <strong>'.$post->pt_name.'</strong></li>';
      }
      return $data;
   }
   return view('patient.patient_load');
}
// create patient หน้าส่งตัวผู้ป่วย
public function create()
{
    $current = Carbon::now();
    $time=$current->toTimeString();
    $datenow=$current->toDateString();
    $datenow=date('Y-m-d');

  if (Session::has('user')){
     $title='ส่งตัวผู้ป่วย';
     $date='<option value="">ระบุวันที่</option>';
     for($i=1;$i<=31;$i++)
     {
      $date.='<option value='.sprintf("%02d", $i).'>'.sprintf("%02d", $i).'</option>';
   }
   $month_thai=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
   $month='<option value="">ระบุเดือน</option>';
   for($i=0;$i<count($month_thai);$i++) {
      $m=$i+1;
      $month.='<option value="'.sprintf("%02d", $m).'">'.$month_thai[$i].'</option>';
   }
   $a=date("Y");
   $b=$a+543;
   $c=$b-110;
   $year='<option>เลือก พ.ศ</option>';
   for($i=$c;$i<=$b;$i++){
      $year.='<option>'.$i.'</option>';
   }
   $fee=array("บัตรทอง","ประกันสังคม","จ่ายเอง","ข้าราชการ","อื่นๆ");
   $fee_list='<option value="">ระบุสิทธิการักษา</option>';
   for($i=0;$i<count($fee);$i++) {
      $fee_list.='<option value="'.$fee[$i].'">'.$fee[$i].'</option>';
   }

   $gender=array("ไม่ระบุ","ชาย","หญิง");
   $gender_list='<option value="">ระบุเพศ</option>';
   for($i=0;$i<count($gender);$i++) {
      $gender_list.='<option value="'.$gender[$i].'">'.$gender[$i].'</option>';
   }


// hospital
   $current_zone=Session::get('user')->hos_zone;
   $current_host=Session::get('user')->hos_host;

   $hos_refno_current=Session::get('user')->hos_refno;

   $hospital= DB::table('stemi_hospital')
   ->where('hos_zone',$current_zone)
   ->where('hos_host',"HOST")
   ->where('hos_refno','!=',$hos_refno_current)

   ->orderby('hos_status','desc')

   ->get();

   $out_zone_hospital= DB::table('stemi_hospital')
   ->where('hos_zone','!=',$current_zone)
   ->where('hos_host',"HOST")
      ->orderby('hos_status','desc')

   ->get();

   // $url  = asset('/');
// โรงพยาบาลในโซน
   $hospital_list='<div class="txt-time">'.'ทั้งหมด '.count($hospital).' โรงพยาบาล'.'</div>';
   foreach ($hospital as $result) {
      if($result->hos_host=="HOST"){
         $img='<img src="'.asset('/').'public/images/hot1.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
      }else{
       $img='<img src="'.asset('/').'public/images/hot2.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
    }

    if($result->hos_status=="CLOSE"){
      $h_style="h_close";
   }else if($result->hos_status=="OPEN"){
      $h_style="h_open";
   }


   $hospital_list.='<div class="row '.$h_style.'">

   <div class="col-3">'
   .$img.
   '</div>
   <div class="col-6">
   <button type="button" class="btn hospital txt-p" ref="'.$result->hos_refno.'" name="'.$result->hos_name.'">'.$result->hos_name.'</button>
   <div class="txt"><a href="tel:'.$result->hos_phone.'">'.$result->hos_phone.'</a></div>
   </div>
   <div class="col-3">
   <div class="txt-time">
   
   </div>
   <div class="txt-time">
 
   </div>
   </div>
   </div>';
}

// โรงพยาบาลนอกโซน
$out_zone_hospital_list='<div class="txt-time">'.'ทั้งหมด '.count($out_zone_hospital).' โรงพยาบาล'.'</div>';
foreach ($out_zone_hospital as $result) {

   if($result->hos_host=="HOST"){
      $img='<img src="'.asset('/').'public/images/hot1.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
   }else{
    $img='<img src="'.asset('/').'public/images/hot2.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
 }


 if($result->hos_status=="CLOSE"){
   $h_style="h_close";
}else if($result->hos_status=="OPEN"){
   $h_style="h_open";
}


$out_zone_hospital_list.='<div class="row '.$h_style.'">

<div class="col-3">'
.$img.
'</div>
<div class="col-6">


<button type="button" class="btn hospital txt-p" ref="'.$result->hos_refno.'" name="'.$result->hos_name.'">'.$result->hos_name.'</button>
<div class="txt"><a href="tel:'.$result->hos_phone.'">'.$result->hos_phone.'</a></div>

</div>
<div class="col-3">
<div class="txt-time">

</div>
<div class="txt-time">

</div>
</div>
</div>';
}

return view("patient.create")
->with(['datenow'=>$datenow])
->with(['timecreate'=>$time])
->with(['date'=>$date])
->with(['current'=>$current])
->with(['month'=>$month])
->with(['year'=>$year])
->with(['fee_list'=>$fee_list])
->with(['title'=>$title])
->with(['gender_list'=>$gender_list])
->with(['hospital_list'=>$hospital_list])
->with(['out_zone_hospital_list'=>$out_zone_hospital_list]);

}else{
   return view('auth.login');
}
}
// create patient


// ขอตอบรับการส่งตัวผู้ป่วย
public function waiting_for_response(Request $request)
{
  if (Session::has('user')){
      $pt_id = $request->input('pt_id');

      $sql = "SELECT RQ.*,PT.pt_name,PT.pt_gender,HO.hos_name,HO.hos_phone
               FROM stemi_request RQ
               LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
               LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
               WHERE PT.pt_id = '$pt_id'";

      $query = DB::select($sql);

      return view('patient.patientwaitingforresponse')->with(['data'=> $query[0]])->with(['pt_id'=> $pt_id]);

  }

}
// ขอตอบรับการส่งตัวผู้ป่วย

// Start โหลด Map
public function load_map(Request $request)
{
  if (Session::has('user')){
      $pt_id = $request->input('pt_id');
      $phone = $request->input('phone');

      $sql = "SELECT RQ.*,
                     PT.pt_name,
                     PT.pt_gender,
                     PT.pt_latitude,
                     PT.pt_longitude,
                     HO.hos_name,
                     HO.hos_phone,
                     HO.hos_latitude,
                     HO.hos_longitude
               FROM stemi_request RQ
               LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
               LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
               WHERE PT.pt_id = '$pt_id'";

      $query = DB::select($sql);

      return view('patient.patientmap')
            ->with(['data'=> $query[0]])
            ->with(['pt_id'=> $pt_id])
            ->with(['phone'=> $phone]);

  }

}
// End โหลด Map


public function load_location_ios(Request $request){

   $status = false;
   $pt_id = $request->input('pt_id');
   $arrData = [];

   $sql = "SELECT 	RQ.*,PT.pt_name,
               PT.pt_gender,
               HO.hos_name,
               HO.hos_latitude,
               HO.hos_longitude,
               PT.pt_latitude,
               PT.pt_longitude,
               ifnull(HOC.hos_refno,'') AS client_hos_refno,
               CN.cancel_message
               FROM stemi_request RQ
               LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
               LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
               LEFT JOIN stemi_hospital HOC ON PT.pt_us_refno = HOC.hos_refno
               LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id AND CN.active <> 0
            WHERE PT.pt_id = '$pt_id'";

   $query = DB::select($sql);

   if(count($query) > 0)
   {
      $status = true;
      $arrData = $query[0] ;

   }

   echo  json_encode(array(
      'status' => $status,
      'data' => [$arrData]

  ));
}

// Start โหลด Map
public function load_map_hospital(Request $request)
{
  if (Session::has('user')){
      $pt_id = $request->input('pt_id');
      $phone = $request->input('phone');

      $sql = "SELECT RQ.*,
                     PT.pt_name,
                     PT.pt_gender,
                     PT.pt_latitude,
                     PT.pt_longitude,
                     HO.hos_name,
                     HO.hos_phone,
                     HO.hos_latitude,
                     HO.hos_longitude
               FROM stemi_request RQ
               LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
               LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
               WHERE PT.pt_id = '$pt_id'";

      $query = DB::select($sql);

      return view('patient.patientmaphospital')
            ->with(['data'=> $query[0]])
            ->with(['pt_id'=> $pt_id])
            ->with(['phone'=> $phone]);

  }

}
// End โหลด Map


// save patient บันทึกการส่งตัวผู้ป่วย
public function send_patient(Request $request){

   $image = $request->input('image');
   $file = $request->input('file');
   $hos_req=$request->input('hos_req');
   // dd($file);

   // $file=$request->hasFile('file');


   if($file){
      list($type, $image) = explode(';', $image);
      list(, $image) = explode(',', $image);
      $image = base64_decode($image);
      $image_name = time() . '.png';

      file_put_contents('public/patient_pic/' . $image_name, $image);
      $avatar = $image_name;
   }else{
    $avatar='';
 }
 $birthdate=$request->input('year').'-'.$request->input('month').'-'.$request->input('date');
 $pt_refno                   = microtime(true) * 10000;

 $data = array(
   'pt_refno' => $pt_refno,
   'pt_us_refno' => Session::get('user')->us_hos_refno,
   'pt_hn'=>$request->input('pt_hn'),
   'pt_name'=>$request->input('pt_name'),
   'pt_idcard'=>$request->input('pt_idcard'),
   'pt_dateofbirth'=>$birthdate,
   'pt_caretype'=>$request->input('pt_caretype'),
   'pt_gender'=>$request->input('pt_gender'),
   'pt_age'=>$request->input('pt_age'),
   'pt_occupation'=>$request->input('pt_occupation'),
   'pt_disease'=>$request->input('pt_disease'),
   'pt_picture' => $avatar, );
 $pt=DB::table('stemi_patient')->insertGetId($data);
 $hos_current=Session::get('user')->us_hos_refno;
 $datetime=carbon::now()->todatetimeString();
 $data_request = array(
   'rq_refno' => microtime(true) * 10000,
   'rq_pt_refno'=>$pt_refno,
   'rq_us_refno'=>$hos_current,
   'rq_hos_refno'=>$hos_req,
   'rq_sending_status'=>1,
   'rq_sent_datetime'=>$datetime
);

// สร้าง folder เก็บไฟล์ ekg ชื่อ folder ตาม hos_refno
 $path = public_path('public/public/ekg_file/'.$hos_current.'');
 //$path =('public/public/ekg_file/'.$hos_current.'');
 //if(!File::isDirectory($path)){
    //File::makeDirectory($path, 0777, true, true);
    if(!file_exists($path)){
      mkdir($path,0777,true);
 }
// copy file ไป folder ที่สร้าง
 //$attached=$request->input('attached');
 $attached=$request->input('attached');
 $temppice= ('public/server/php/'.$hos_current.'/'.$attached);
 //$temppic = ('public/server/php/'.$hos_current.'/'.$attached);
 $temppic = ('public/server/php/'.$hos_current.'/');
 //$newpic =('public/ekg_file/'.$hos_current.'/'.$attached);
 $newpic =('public/public/public/ekg_file/'.$hos_current.'/');
 if($attached !=="" || $attached !==null){
  $attached=(explode(",",$attached));
  for ($i=0; $i < count($attached); $i++) {
   //copy('public/server/php/filess123/'.$attached[$i].'', 'public/ekg_file/'.$hos_current.'/'.$attached[$i]);
   copy($temppic.$attached[$i],$newpic.$attached[$i]);
   $img_ekg = array('ekg_picture' =>$attached[$i],
      'ekg_pt_refno'=>$pt_refno,
      'ekg_us_refno'=>$hos_current );
// บันทึกลง ฐานข้อมูล ekg
   DB::table('stemi_patient_ekg')->insert($img_ekg);
   unlink($temppic.$attached[$i]);
}
}

DB::table('stemi_request')->insert($data_request);


    $datetime_event=$request->input('date_create');

    @session_start();
    $id_hospital=$_SESSION['hoslefno'];
    $time_create=$request->input('time_create');

$event_dashboard=array(
    'id_hospital'=>$id_hospital,
    'id_clien'=>$hos_req,
    'rq_patient'=>$pt_refno,
    'date_event'=>$datetime_event,
    'rq_time_sent'=>$datetime,
    'rq_time_create'=>$time_create
);
$data_dashboard=DB::table('stemi_dashboard')->insert($event_dashboard);

$hos_name=Session::get('user')->hos_name;
$hos_rq_name=Session::get('user')->hos_name;

return response()->json(array(
 'success' => true,
 'pt_id'=>$pt,
 'pt_name'=>$request->input('pt_name'),
 'pt_gender'=>$request->input('pt_gender'),
 'hos_name'=>$hos_rq_name,
 'pt_refno'=> $pt_refno

));
// บอกสถานะไปยังหน้า success
}

// แก้ไขข้อมูลอัพเดทข้อมูลผู้ป่วย
public function get_edititem(Request $request){
    $id=$request->input('id');
    // dd($id);
    $data=DB::table('stemi_patient')->where('pt_id','=',$id)->get();
    $picture='';
    foreach($data AS $data){
        if($data->pt_picture==""){
        $picture.='
        <img  style="height: 131px;" src="'.asset('public').'/stemi_images/avatar.png" >
        ';

        }else{
            $picture.='
            <img  style="height: 131px;" src="'.asset('public').'/patient_pic/'.$data->pt_picture.'" >
            ';
        }

    }
    return response()->json([$data,$picture]);
}

public function updateedit_patient(Request $request){
    $pt_id=$request->input('pt_id');
    $pt_name=$request->input('pt_name');
    $pt_dateofbirth=$request->input('pt_dateofbirth');
    $pt_gender=$request->input('pt_gender');
    $pt_age=$request->input('pt_age');
    $pt_idcard=$request->input('pt_idcard');
    $pt_occupation=$request->input('pt_occupation');
    $pt_careType=$request->input('pt_careType');
    $pt_chronic=$request->input('pt_chronic');
    $pt_injurydatetime=$request->input('pt_injurydatetime');
    $pt_takedatetime=$request->input('pt_takedatetime');
    $pt_createekgtime=$request->input('pt_createekgtime');
    // dd($pt_injurydatetime);
    $data=DB::table('stemi_patient')
    ->where('pt_id',$pt_id)
    ->update([
    'pt_name'=>$pt_name,
    'pt_dateofbirth'=>$pt_dateofbirth,
    'pt_gender'=>$pt_gender,
    'pt_age'=>$pt_age,
    'pt_idcard'=>$pt_idcard,
    'pt_occupation'=>$pt_occupation,
    'pt_caretype'=>$pt_careType,
    'pt_chronic'=>$pt_chronic,
    'pt_careTypemore'=>request('pt_careTypemore'),
    'pt_injurydatetime'=>$pt_injurydatetime,
    'pt_takedatetime'=>$pt_takedatetime,
    'pt_createekgtime'=>$pt_createekgtime]);
    // dd($data);
    return response()->json("success");
}
// หน้าแก้ไขข้อมูลผู้ป่วย หรือส่งผู้ป่วยอีกครั้ง
public function patient_edit($id)
{
  $pt_id=$id;
  $title="แก้ไขข้อมูลผู้ป่วย";

  if(empty(Session::get('user')->us_hos_refno)){
   return view('auth.login');
}else{
  $patient = DB::table('stemi_patient')
  ->where("stemi_patient.pt_id","=",$pt_id)
   // ->join("stemi_patient","stemi_patient.pt_refno","stemi_request.rq_pt_refno")
  ->first();
// dd($patient->pt_dateofbirth);
  $date_se = explode("-", $patient->pt_dateofbirth);

  $date='<option value="">ระบุวันที่</option>';
  for($i=1;$i<=31;$i++)
  {

   if($i==$date_se[1]){
      $select='selected';
   }else{
    $select='';
 }

 $date.='<option value='.sprintf("%02d", $i).' '.$select.'>'.sprintf("%02d", $i).'</option>';
}
$month_thai=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$month='<option value="">ระบุเดือน</option>';
for($i=0;$i<count($month_thai);$i++) {
   $m=$i+1;

   if($m==$date_se[1]){
      $select='selected';
   }else{
    $select='';
 }

 $month.='<option value="'.sprintf("%02d", $m).'" '.$select.'>'.$month_thai[$i].'</option>';
}
$a=date("Y");
$b=$a+543;
$c=$b-110;

$date_se[0];
$year='<option value="'.$date_se[0].'">เลือก พ.ศ</option>';


for($i=$c;$i<=$b;$i++){

   if($i==$date_se[0]){
      $select='selected';
   }else{
    $select='';
 }

 $year.='<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
$fee=array("บัตรทอง","ประกันสังคม","จ่ายเอง","ข้าราชการ","อื่นๆ");
$fee_list='<option value="">ระบุสิทธิการักษา</option>';
for($i=0;$i<count($fee);$i++) {
   if($fee[$i]==$patient->pt_caretype){
     $select='selected';
  }else{
     $select='';
  }


  $fee_list.='<option value="'.$fee[$i].'" '.$select.'>'.$fee[$i].'</option>';
}
$gender=array("ไม่ระบุ","ชาย","หญิง");
$gender_list='<option value="">ระบุเพศ</option>';
for($i=0;$i<count($gender);$i++) {

   if($gender[$i]==$patient->pt_gender){
     $select='selected';
  }else{
     $select='';
  }

  $gender_list.='<option value="'.$gender[$i].'" '.$select.'>'.$gender[$i].'</option>';
}
// เลือกโรงพยาบาล
$current_zone=Session::get('user')->hos_zone;
$current_host=Session::get('user')->hos_host;
$hos_refno_current=Session::get('user')->hos_refno;
// โรงพยาบาลในโซน
$hospital= DB::table('stemi_hospital')
->where('hos_zone',$current_zone)
->where('hos_host',"HOST")
->where('hos_refno','!=',$hos_refno_current)
->orderby('hos_status','desc')
->get();
// โรงพยาบาลนอกโซน
$out_zone_hospital= DB::table('stemi_hospital')
->where('hos_zone','!=',$current_zone)
->where('hos_host',"HOST")
->orderby('hos_status','desc')
->get();
   // $url  = asset('/');
//loop  โรงพยาบาลในโซน
$hospital_list='<div class="txt-time">'.'ทั้งหมด '.count($hospital).' โรงพยาบาล'.'</div>';
foreach ($hospital as $result) {
    if($result->hos_status=="CLOSE"){
      $h_style="h_close";
   }else if($result->hos_status=="OPEN"){
      $h_style="h_open";
   }
   if($result->hos_host=="HOST"){
      $img='<img src="'.asset('/').'public/images/hot1.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
   }else{
    $img='<img src="'.asset('/').'public/images/hot2.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
 }
 $hospital_list.='<div class="row hos_section '.$h_style.'">
 <div class="col-3">'.$img.'</div>
 <div class="col-6">
 <button type="button" class="btn hospital txt-p" ref="'.$result->hos_refno.'" name="'.$result->hos_name.'">'.$result->hos_name.'</button>
 <div class="txt"><a href="tel:'.$result->hos_phone.'">'.$result->hos_phone.'</a></div>
 </div>
 <div class="col-3">
 <div class="txt-time">
 ระยะทาง  KG
 </div>
 <div class="txt-time">
 ใช้เวลาประมาณ  นาที
 </div>
 </div>
 </div>';
}

//loop โรงพยาบาลนอกโซน
$out_zone_hospital_list='<div class="txt-time">'.'ทั้งหมด '.count($out_zone_hospital).' โรงพยาบาล'.'</div>';
foreach ($out_zone_hospital as $result) {
    if($result->hos_status=="CLOSE"){
      $h_style="h_close";
   }else if($result->hos_status=="OPEN"){
      $h_style="h_open";
   }
   if($result->hos_host=="HOST"){
      $img='<img src="'.asset('/').'public/images/hot1.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
   }else{
    $img='<img src="'.asset('/').'public/images/hot2.png" class="img-fluid" style="border:2px solid #ccc;    border-radius: 100%;">';
 }
 $out_zone_hospital_list.='<div class="row hos_section '.$h_style.'">

 <div class="col-3">'
 .$img.
 '</div>
 <div class="col-6">

 <button type="button" class="btn hospital txt-p" ref="'.$result->hos_refno.'" name="'.$result->hos_name.'">'.$result->hos_name.'</button>
 <div class="txt"><a href="tel:'.$result->hos_phone.'">'.$result->hos_phone.'</a></div>
 </div>
 <div class="col-3">
 <div class="txt-time">
 ระยะทาง 50 KG
 </div>
 <div class="txt-time">
 ใช้เวลาประมาณ 12 นาที
 </div>
 </div>
 </div>';
}


$ekg_picture=DB::table('stemi_patient_ekg')
->where('ekg_pt_refno','=',$patient->pt_refno)
->get();
$ekg_list="";
foreach ($ekg_picture as $ekg) {
   $ekg_list.='<img src="'.asset('/public/ekg_file').'/'.$hos_refno_current.'/'.$ekg->ekg_picture.'"  class="img-fluid">';
}

// dd($patient->pt_refno);
return view("patient.edit")
->with(['pt_id'=>$pt_id])
->with(['date'=>$date])
->with(['month'=>$month])
->with(['year'=>$year])
->with(['fee_list'=>$fee_list])
->with(['title'=>$title])
->with(['gender_list'=>$gender_list])
->with(['patient'=>$patient])
->with(['hospital_list'=>$hospital_list])
->with(['out_zone_hospital_list'=>$out_zone_hospital_list])
->with(['ekg_list'=>$ekg_list]);
}
}
// edit patient
public function edit($id)
{
 session_start();
    // dd($id);
 $_SESSION['rq_id'] = $id;
 $view['rs'] = DB::table('stemi_request')
 ->where("rq_id","=",$id)
 ->join("stemi_patient","stemi_patient.pt_refno","stemi_request.rq_pt_refno")
 ->first();
    // dd($view['rs']);
 if($view['rs'] == null){
  return redirect('patient');
}
return view("patient.edit",$view);
}
// edit patient

// save update patient
public function update_patient(Request $request){
   $patient_request_id=$request->input('patient_request_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => '' , 'stemi_request.rq_get_sending_status' => 0 , 'stemi_request.rq_timecountdown' => 117]);
 return response()->json(array(
    'success' => true));
}
public function check_accept(Request $request){
   $status = true;
   $message = "";
   $response_status = "";
   $pt_id = $request->input('pt_id');
   $rq_timecountdown = $request->input('rq_timecountdown');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$pt_id)
   ->update(['stemi_request.rq_timecountdown' => $rq_timecountdown]);

   $sql = "SELECT RQ.*,PT.pt_name,PT.pt_gender,HO.hos_name,CN.cancel_message
            FROM stemi_request RQ
            LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
            LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
            LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id
            WHERE PT.pt_id = '$pt_id'";
   $query = DB::select($sql);
//    dd($query);
   $rq_pt_refno=$query[0]->rq_pt_refno;
//    dd($rq_pt_refno);
   if(count($query) > 0)
   {
      $status = true;
      if($query[0]->rq_response_status == 1)
      {
         $response_status = "success";
      }else if($query[0]->rq_response_status == 3)
      {
         $response_status = "reject";
         $message = $query[0]->cancel_message ;
      }else
      {
         $response_status = "fail";
         $status = false;
      }

   }

   echo  json_encode(array(
      'status' => $status,
      'rq_pt_refno'=>$rq_pt_refno,
      'responsestatus' => $response_status,
      'pt_id' => $pt_id ,
      'message' => $message,
      'total' => count($query)
  ));
}

public function check_request(Request $request){
// //    $hos_namesend=$request[0]->hos_name;
//
   $us_hos_refno = Session::get('user')->us_hos_refno ;
//    $hos_name=Session::get('user')->hos_name;
//    dd( $hos_name);
   $status = false;
   $sending_status = "";
   $rq_response_status = "";
   $traveling_status = "";

   $sql = " SELECT *
            FROM stemi_patient PT
            LEFT JOIN stemi_request RQ on PT.pt_refno = RQ.rq_pt_refno
            LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id AND CN.active <> 0
            LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
            where RQ.rq_sending_status = 1
            AND RQ.rq_get_sending_status != 1
            AND RQ.rq_hos_refno = '$us_hos_refno'
            order by  pt_id desc";

   $query = DB::select($sql);


//    $hosnamesend=$query[0]->pt_us_refno;
    // $hospitalname=DB::table('stemi_hospital')
    // ->where('hos_refno','=',$hosnamesend)
    // ->get();
    // $hospitalnamesend=$hospitalname[0]->hos_name;
    // // dd($hospitalnamesend);
   if(count($query) > 0)
   {
      $status = true;
      $sending_status = $query[0]->rq_sending_status ;
    //   $hosnamesend=$query[0]->pt_us_refno;
    //   $hospitalname=DB::table('stemi_hospital')
    //   ->where('hos_refno','=',$hosnamesend)
    //   ->get();
    //   $hospitalnamesend=$hospitalname[0]->hos_name;
   }else{
            $sql = " SELECT *
            FROM stemi_patient PT
            LEFT JOIN stemi_request RQ on PT.pt_refno = RQ.rq_pt_refno
            LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id AND CN.active <> 0
            LEFT JOIN stemi_hospital HO ON PT.pt_us_refno = HO.hos_refno
            where RQ.rq_response_status in (6,7)
            AND RQ.rq_get_response_status != 1
            AND RQ.rq_hos_refno = '$us_hos_refno'
            order by  pt_id desc";

            $query = DB::select($sql);

            if(count($query) > 0)
            {
               $patient_request_id = $query[0]->pt_id;
               $patient_request_update=DB::table('stemi_patient')
               ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
               ->where('stemi_patient.pt_id','=',$patient_request_id)
               ->update(['stemi_request.rq_get_response_status' => 1 ]);

               $status = true;
               $rq_response_status = $query[0]->rq_response_status;
            //    $hosnamesend=$query[0]->pt_us_refno;
            //    $hospitalname=DB::table('stemi_hospital')
            //    ->where('hos_refno','=',$hosnamesend)
            //    ->get();
            //    $hospitalnamesend=$hospitalname[0]->hos_name;

            }else{
               $sql = " SELECT *
               FROM stemi_patient PT
               LEFT JOIN stemi_request RQ on PT.pt_refno = RQ.rq_pt_refno
               LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id AND CN.active <> 0
               LEFT JOIN stemi_hospital HO ON PT.pt_us_refno = HO.hos_refno
               where RQ.rq_get_traveling_status in (1,2,3)
               AND RQ.rq_hos_refno = '$us_hos_refno'
               order by  pt_id desc";

               $query = DB::select($sql);

               if(count($query) > 0)
               {
                  $patient_request_id = $query[0]->pt_id;
                  $patient_request_update=DB::table('stemi_patient')
                  ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
                  ->where('stemi_patient.pt_id','=',$patient_request_id)
                  ->update(['stemi_request.rq_get_traveling_status' => 0 ]);
                  $status = true;
                  $traveling_status = $query[0]->rq_get_traveling_status;
                //   $hosnamesend=$query[0]->pt_us_refno;
                //   $hospitalname=DB::table('stemi_hospital')
                //   ->where('hos_refno','=',$hosnamesend)
                //   ->get();
                //   $hospitalnamesend=$hospitalname[0]->hos_name;


               }
            }

   }

//    return response()->json(['hos_namesend'=>$hospitalnamesend,'data'=>$query]);

   echo  json_encode(array(
      'status' => $status,
      'data' => $query ,
    //   'hos_namesend'=>$hospitalnamesend,
      'sending_status' => $sending_status ,
      'response_status' => $rq_response_status ,
      'traveling_status' => $traveling_status
  ));
//   return view('patient.app')
//   ->with(['hos_namesend'=>$hospitalnamesend]);
}

// ผู้ป่วยรับการแจ้งเตือนแล้ว
public function update_getsend(Request $request){

   $pt_refno=$request->input('pt_refno');
   $patient_request_id=$request->input('patient_request_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$patient_request_id)
   ->update(['stemi_request.rq_get_sending_status' => 1 ]);

    $data=DB::table('stemi_patient')
    ->join('stemi_hospital','stemi_patient.pt_us_refno','=','stemi_hospital.hos_refno')
    ->where('stemi_patient.pt_refno','=',$pt_refno)
    ->get();

    $hospital=$data[0]->hos_name;
   return response()->json(array(
    'success' => true,'hos_namesend'=>$hospital));
}

// อัพเดทเวลา dashboard ปุ่มนำทาง
public function update_navigator(Request $request ){
    $datetime=Carbon::now();
    $datetime->toDayDateTimeString();
    $patient_request_id=$request->input('patient_request_id');
    DB::table('stemi_dashboard')
    ->where('rq_patient',$patient_request_id)
    ->update(['rq_time_tracking'=>$datetime]);
}
// ปิดอัพเดทเวลา dashboard ปุ่มนำทาง

// รับผู้ป่วย
public function update_accept(Request $request){
   $pt_refno=$request->input('pt_refno');
   $datetimeaccept=Carbon::now();
   $datetimeaccept->toDayDateTimeString();
   $patient_request_id=$request->input('patient_request_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_refno','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => 1 ]);
//    dd($request);
   DB::table('stemi_dashboard')
   ->where('rq_patient',$pt_refno)
   ->update(['rq_time_hosresponse'=>$datetimeaccept]);
   return response()->json(array(
    'success' => true));
}

// พลาดรับ
public function update_fail(Request $request){
   $patient_request_id=$request->input('patient_request_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_refno','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => 2 , 'stemi_request.rq_get_sending_status' => 1]);
   return response()->json(array(
    'success' => true));
}

// โรงพยาบาลแม่ข่ายปฏิเสธ
public function update_reject(Request $request){
   $patient_request_id=$request->input('patient_request_id');
   $reason=$request->input('reason');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_refno','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => 3]);

   $sql = "SELECT RQ.*,PT.pt_refno,PT.pt_name,PT.pt_gender,HO.hos_refno,HO.hos_name
            FROM stemi_request RQ
            LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
            LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
            WHERE PT.pt_id = '$patient_request_id'";

   $query = DB::select($sql);
   $arrayData='';

   if(count($query) > 0)
   {
      $cancel_rq_id = $query[0]->rq_id;
      $hos_refno = $query[0]->hos_refno;
      $arrayData = array(
                           array('cancel_rq_id' => ((!empty($cancel_rq_id))?$cancel_rq_id:""),
                                 'cancel_hos_refno' => ((!empty($hos_refno))?$hos_refno:""),
                                 'cancel_message' => ((!empty($reason))?$reason:"") ,
                                 'active' => 1
                                 )
                     );

      DB::table('stemi_request_cancel')
      ->where('cancel_rq_id','=',$cancel_rq_id)
      ->update(['active' => 0]);
   }

   // DB::table('stemi_request_cancel')->insert($arrayData);

   return response()->json(array(
    'success' => true));
}

// ปิดงาน ส่งตัวผู้ป่วยระหว่างทาง
public function update_sendalong(Request $request){

   $patient_request_id=$request->input('pt_id');
   $reason=$request->input('reason');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => 6,'stemi_request.rq_jobend_datetime' => date('Y-m-d h:i:s'),'stemi_request.rq_get_response_status' => 0]);

   $sql = "SELECT RQ.*,PT.pt_refno,PT.pt_name,PT.pt_gender,HO.hos_refno,HO.hos_name
            FROM stemi_request RQ
            LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
            LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
            WHERE PT.pt_id = '$patient_request_id'";

   $query = DB::select($sql);
   $arrayData ;

   if(count($query) > 0)
   {
      $cancel_rq_id = $query[0]->rq_id;
      $hos_refno = $query[0]->hos_refno;
      $arrayData = array(
                           array('cancel_rq_id' => ((!empty($cancel_rq_id))?$cancel_rq_id:""),
                                 'cancel_hos_refno' => ((!empty($hos_refno))?$hos_refno:""),
                                 'cancel_message' => ((!empty($reason))?$reason:"") ,
                                 'active' => 1
                                 )
                     );

      DB::table('stemi_request_cancel')
      ->where('cancel_rq_id','=',$cancel_rq_id)
      ->update(['active' => 0]);
   }

   DB::table('stemi_request_cancel')->insert( $arrayData );

   $pt_rq_refno=$request->input('pt_rq_refno');
   $datetime=Carbon::now();
   $datetime->toDateTimeString();
   $update=DB::table('stemi_dashboard')
   ->Where('rq_patient',$pt_rq_refno)
   ->Update(['rq_time_end'=>$datetime]);

   return response()->json(array(
    'success' => true));
}

// ปิดงาน ส่งตัวผู้ป่วย
public function update_send_patient(Request $request){
   $patient_request_id=$request->input('pt_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => 7 ,'stemi_request.rq_jobend_datetime' => date('Y-m-d h:i:s'),'stemi_request.rq_get_response_status' => 0]);
   return response()->json(array(
    'success' => true));
}

// ย้อนกลับ สถานะ ปิดงาน ส่งตัวผู้ป่วย
public function update_reverse_status(Request $request){
   $patient_request_id=$request->input('pt_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => 1 ,'stemi_request.rq_get_traveling_status' => 3]);
   return response()->json(array(
    'success' => true));
}

// ยกเลิกการส่งตัว
public function update_cancel(Request $request){
   $patient_request_id=$request->input('patient_request_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$patient_request_id)
   ->update(['stemi_request.rq_response_status' => 4 , 'stemi_request.rq_get_sending_status' => 1]);
   return response()->json(array(
    'success' => true));
}

// กำลังเดินทาง
public function update_traveling_status(Request $request){
   $patient_request_id=$request->input('pt_id');
   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$patient_request_id)
   ->update(['stemi_request.rq_get_traveling_status' => 1]);
   echo  json_encode(array(
      'status' => true,
  ));
}

// กำลังถึง 10 นาที
public function update_traveling_10_m_status(Request $request){
   $patient_request_id=$request->input('pt_id');
   $status = false ;
   $sql = " SELECT *
            FROM stemi_patient PT
            LEFT JOIN stemi_request RQ on PT.pt_refno = RQ.rq_pt_refno
            LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id AND CN.active <> 0
            LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
            where RQ.rq_get_traveling_status2 != 1
            AND PT.pt_id = '$patient_request_id'
            order by  pt_id desc";

   $query = DB::select($sql);

   if(count($query) > 0)
   {
      $status = true;
      $patient_request_update=DB::table('stemi_patient')
      ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
      ->where('stemi_patient.pt_id','=',$patient_request_id)
      ->update(['stemi_request.rq_get_traveling_status' => 2 , 'stemi_request.rq_get_traveling_status2' => 1]);
   }


   return response()->json(array(
    'status' => $status));
}


public function update_location(Request $request){
   $pt_id=$request->input('pt_id');
   $pt_latitude=$request->input('pt_latitude');
   $pt_longitude=$request->input('pt_longitude');

   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$pt_id)
   ->update(['stemi_patient.pt_latitude' => $pt_latitude , 'stemi_patient.pt_longitude' => $pt_longitude]);


   // error_log($patient_request_update->toSql());

   echo  json_encode(array(
      'status' => true,

  ));
}

public function update_distance_matrix(Request $request){
   $pt_id=$request->input('pt_id');
   $distancevalue=$request->input('distancevalue');
   $distancetext=$request->input('distancetext');
   $durationvalue=$request->input('durationvalue');
   $durationtext=$request->input('durationtext');

   $patient_request_update=DB::table('stemi_patient')
   ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
   ->where('stemi_patient.pt_id','=',$pt_id)
   ->update([  'stemi_patient.distancevalue' => $distancevalue ,
               'stemi_patient.distancetext' => $distancetext ,
               'stemi_patient.durationvalue' => $durationvalue ,
               'stemi_patient.durationtext' => $durationtext
            ]);


   // error_log($patient_request_update->toSql());

   return response()->json(array(
    'success' => true));
}

public function load_location(Request $request){

   $status = false;
   $pt_id = $request->input('pt_id');

   $sql = "SELECT 	RQ.*,PT.pt_name,
               PT.pt_gender,
               HO.hos_name,
               HO.hos_latitude,
               HO.hos_longitude,
               PT.pt_latitude,
               PT.pt_longitude,
               ifnull(HOC.hos_refno,'') AS client_hos_refno,
               CN.cancel_message
               FROM stemi_request RQ
               LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
               LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
               LEFT JOIN stemi_hospital HOC ON PT.pt_us_refno = HOC.hos_refno
               LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id AND CN.active <> 0
            WHERE PT.pt_id = '$pt_id'";

   $query = DB::select($sql);

   if(count($query) > 0)
   {
      $status = true;

   }

   echo  json_encode(array(
      'status' => $status,
      'data' => $query[0]

  ));
}

public function load_location_map(Request $request){

   $status = false;
   $pt_id = $request->input('pt_id');

   $sql = "SELECT
               ifnull(PT.pt_latitude,'') AS pt_latitude,
               ifnull(PT.pt_longitude,'') AS pt_longitude,
               ifnull(HO.hos_refno,'') AS main_hos_refno,
               ifnull(HO.hos_name,'') AS main_hos_name,
               ifnull(HO.hos_latitude,'') AS main_hos_latitude,
               ifnull(HO.hos_longitude,'') AS main_hos_longitude,
               ifnull(HOC.hos_refno,'') AS client_hos_refno,
               ifnull(HOC.hos_name,'') AS client_hos_name,
               ifnull(HOC.hos_latitude,'') AS client_hos_latitude,
               ifnull(HOC.hos_longitude,'') AS client_hos_longitude
            FROM stemi_request RQ
            LEFT JOIN stemi_patient PT ON RQ.rq_pt_refno = PT.pt_refno
            LEFT JOIN stemi_hospital HO ON RQ.rq_hos_refno = HO.hos_refno
            LEFT JOIN stemi_hospital HOC ON PT.pt_us_refno = HOC.hos_refno
            LEFT JOIN stemi_request_cancel CN ON RQ.rq_id = CN.cancel_rq_id AND CN.active <> 0
            WHERE PT.pt_id = '$pt_id'";

   $query = DB::select($sql);

   if(count($query) > 0)
   {
      $status = true;

   }

   echo  json_encode(array(
      'status' => $status,
      'data' => $query[0]

  ));





}


public function sendpt_ambulance(Request $request){
    $ptrefno=$request->input('ptrefno');
    $idambulance=$request->input('idambulance');
    $name=$request->input('name');
   //  dd($idambulance);
    $data=DB::table('stemi_request')
    ->where('stemi_request.rq_pt_refno','=',$ptrefno)
    ->update(['stemi_request.staff_ambulance'=>$idambulance]);


//    var_dump($data);
// exit();
    return response()->JSON(['name'=>$name,'idambulance'=>$idambulance]);

}

public function list_ambulance(Request $request){
    $id=$request->input('id_patient');

    $data=DB::table('stemi_patient')
    ->join('users','stemi_patient.pt_us_refno','=','users.us_hos_refno')
    ->where('stemi_patient.pt_id','=',$id)
    ->where('users.user_type','=','AMBULANCE')
    ->get();
    

    $listambulance='';
    foreach($data AS $data){
        $listambulance.='
            <select id="selectshare" class="form-control form-control-lg">
                <option value="'.$data->us_refno.'">'.$data->name.'</option>
            </select>
            <input id="idpt" value="'.$id.'" style="display:none;">
            <input id="ptrefno" value="'.$data->pt_refno.'" style="display:none;">
            <input id="name" value="'.$data->name.'" style="display:none;">
        ';
    }

   //  dd($listambulance);

    return response()->json([$data,$listambulance]);
}

public function ambulan_schedule(Request $request){
    $idambulance=Session::get('user')->us_refno;
   //  $idambulance=$request->input('idambulance');
   //  dd($idambulance);
    $data=DB::table('stemi_request')
    ->join('stemi_patient','stemi_request.rq_pt_refno','=','stemi_patient.pt_refno')
    ->join('stemi_hospital','stemi_request.rq_hos_refno','=','stemi_hospital.hos_refno')
    ->where('stemi_request.staff_ambulance','=',$idambulance)
    ->orderBy('rq_id','DESC')
    ->get();
    $ambulan='';
    foreach($data AS $data){
        // dd($data);
        $ambulan.='
        <div style="margin-top:30px;" class="col-xl-3 col-sm-6 col-12 ">
        <div id="'.$data->pt_id.'" class="card fade-in">
          <div class="card-content ">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <div class="font-large-2 float-left"></div>
                    <img style="width: 75px;" src="'.asset('/').'public/patient_pic'.'/'.$data->pt_picture.'">
                </div>
                <div class="media-body text-right">
                  <h3>ชื่อ '.$data->pt_name.'</h3>
                  <span style="font-size: 18px;">ส่งไปตัวไปยัง '.$data->hos_name.'</span>
                </div>
              </div>
              <div style="margin-top: 20px;" class="media-body text-right">
                <button style="background: rgb(238 28 79);" onclick=onclickMapHospital('.$data->pt_id.',"'.$data->hos_phone.'") class="btn btn-lg btn-stemi-info">นำทาง<i class="fa fa-location-arrow" style="margin-left:10px;" aria-hidden="true"></i></button>
                <button style=" "
                     onclick="onClickCloseJob('.$data->pt_id.')"
                     class="btn btn-stemi-again-accept btn-lg">ปิดงาน</button>
                </div>
            </div>
          </div>
        </div>
      </div>
        ';
    }


      // dd($ambulan);
    return response()->JSON([$data,$ambulan]);

}

public function delete_partien(Request $request){
   $id=$request->input('id');

   $delete=db::table('stemi_request')
            ->where('rq_pt_refno','=',$id)
            ->update(['rq_response_status'=>8]);
   return response()->json(array('data' => "ลบสำเร็จ"));

   }

}
