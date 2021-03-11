<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
class StemiHospitalController extends Controller
{
  public function index(Request $r)
  {
   $title="โรงพยาบาลแม่ข่าย";

   if(empty(Session::get('user')->us_hos_refno)){
    return redirect('login');
 }else{
   $current_zone=Session::get('user')->hos_zone;
   $current_host=Session::get('user')->hos_host;

   $hos_refno_current=Session::get('user')->hos_refno;

   $hospital= DB::table('stemi_hospital')
   ->where('hos_zone',$current_zone)
   ->where('hos_host',"HOST")
   ->where('hos_refno','!=',$hos_refno_current)
   ->orderBy('hos_status', 'DESC')
   ->get();



   $out_zone_hospital= DB::table('stemi_hospital')
   ->where('hos_zone','!=',$current_zone)
   ->where('hos_host',"HOST")
   ->orderBy('hos_status', 'DESC')
   ->get();

   // $url  = asset('/');
// โรงพยาบาลในโซน
   $hospital_list='<div class="txt-time">'.'ทั้งหมด '.count($hospital).' โรงพยาบาล'.'</div>';
   foreach ($hospital as $result) {
      if($result->hos_host=="HOST" && $result->hos_type=="GOV" ){
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
   <div class="txt-time">'.$result->hos_status.'</div>
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
<div class="txt_time">'.$result->hos_status.'</div>
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

   // dd($hospital_list);
return view ('patient.stemi_hospital')
->with(['title'=>$title])
->with(['hospital_list'=>$hospital_list])
->with(['out_zone_hospital_list'=>$out_zone_hospital_list]);
}
 
}


   public function loading_hos(){
      $title="โรงพยาบาลแม่ข่าย";

      if(empty(Session::get('user')->us_hos_refno)){
       return redirect('login');
    }else{
      $current_zone=Session::get('user')->hos_zone;
      $current_host=Session::get('user')->hos_host;
   
      $hos_refno_current=Session::get('user')->hos_refno;
   
      $hospital= DB::table('stemi_hospital')
      ->where('hos_zone',$current_zone)
      ->where('hos_host',"HOST")
      ->where('hos_refno','!=',$hos_refno_current)
      ->orderBy('hos_status', 'DESC')
      ->get();

      $out_zone_hospital= DB::table('stemi_hospital')
      ->where('hos_zone','!=',$current_zone)
      ->where('hos_host',"HOST")
      ->orderBy('hos_status', 'DESC')
      ->get();
   
      // $url  = asset('/');
   // โรงพยาบาลในโซน
      $hospital_list='<div class="txt-time">'.'ทั้งหมด '.count($hospital).' โรงพยาบาล'.'</div>';
      foreach ($hospital as $result) {
         if($result->hos_host=="HOST" && $result->hos_type=="GOV" ){
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
      <button  type="button" class="btn hospital hospital_select txt-p" ref="'.$result->hos_refno.'" name="'.$result->hos_name.'">'.$result->hos_name.'</button>
      <div class="txt"><a href="tel:'.$result->hos_phone.'">'.$result->hos_phone.'</a></div>
      <div class="txt-time">'.$result->hos_status.'</div>
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
   <button type="button" class="btn hospital hospital_select  txt-p" ref="'.$result->hos_refno.'" name="'.$result->hos_name.'">'.$result->hos_name.'</button>
   <div class="txt"><a href="tel:'.$result->hos_phone.'">'.$result->hos_phone.'</a></div>
   <div class="txt_time">'.$result->hos_status.'</div>
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
   return response()->json(['hos'=>$hospital_list,'hosout'=>$out_zone_hospital_list]);
   return view ('patient.stemi_hospital')
   ->with(['title'=>$title])
   ->with(['hospital_list'=>$hospital_list])
   ->with(['out_zone_hospital_list'=>$out_zone_hospital_list]);
   }
   }
}