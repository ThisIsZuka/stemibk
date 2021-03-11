<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use File;
class PatientProfileController extends Controller
{
   public function get_profile($id){
      $data_profile=DB::table('stemi_patient')
      ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
      ->where('pt_id','=',$id)->first();
      $data_hospitaldb=DB::select('select hos_name from stemi_hospital where hos_refno='.$data_profile->rq_hos_refno.' ');
      $data_ekg=DB::select('select * from stemi_patient_ekg where ekg_pt_refno='.$data_profile->rq_pt_refno.'');
      $hos_current=Session::get('user')->us_hos_refno;

      $profile="
      <div class='row'>
      <div class='col-12' style='text-align: center;'>
      <img src='".asset('/public/patient_pic')."/".$data_profile->pt_picture."' style='width: 120px !important;' class='img-fluid'>
      </div>
      <div class='col-12' style='font-size:25px !important;'>ชื่อ-นามสกุล</div>
      <div class='col-12 ' style='font-size:25px  !important;'>$data_profile->pt_name</div>
      <div class='col-12 ' style='font-size:25px !important;'>วันเกิด ".$data_profile->pt_dateofbirth."</div>
      <div class='col-12 ' style='font-size:25px !important;'>อายุ ".$data_profile->pt_age."</div>
      <div class='col-12 ' style='font-size:25px !important;'>เพศ ".$data_profile->pt_gender."</div>
      <div class='col-12 ' style='font-size:25px !important;'>โรคประจำตัว ".$data_profile->pt_disease."</div>
      <div class='col-12 ' style='font-size:25px !important;'>อาชีพ ".$data_profile->pt_occupation."</div>
      <div class='col-12 ' style='font-size:25px !important;'>ข้อมูล EKG
      </div>
      <div class='col-12 thumbs'>
      <div id='action_vwekg' class='viewimg' >
      <img class='popupimgekg'    src='".asset('public/public/public/ekg_file/').'/'.$hos_current.'/'.$data_ekg[0]->ekg_picture."'  >
      </div>
       
      </div>
      <div class='col-12 ' style='font-size:25px !important;'>วันที่ส่งตัว</div>
      <div class='col-12 ' style='font-size:25px !important;'>".$data_profile->pt_update."</div>
      <div class='col-12 ' style='font-size:25px !important;'>ส่งตัว</div>
      <div class='col-12 ' style='font-size:25px !important;'>".$data_hospitaldb[0]->hos_name."</div>
      <div id='galleryOverlay' style='display: none;' class=''><div id='gallerySlider' style='left: -800%;'><div class='placeholder'></div></div></div>
      </div>
      ";
      // dd($data_profile);
      return response()->json($profile);
   }
}
