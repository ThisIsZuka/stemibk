<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Items;
use Illuminate\Http\Request;
use Session;
use App\Patient;
use DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class EkgController extends Controller
{
   public function view_ekg($id){
      $hos_refno_current=Session::get('user')->hos_refno;
      $title="แม่ข่ายพิจารณาผล EKG";
      $ekg_view=DB::table('stemi_patient')
      ->join('stemi_patient_ekg','stemi_patient.pt_refno','=','stemi_patient_ekg.ekg_pt_refno')
      ->where('stemi_patient.pt_id','=',$id)->get();
      $path =('https://www.stemibangkok.com/public/public/public/ekg_file/');
      $ekg_pic="";
      foreach ($ekg_view as $ekg) {
         $ekg_pic.='<input type="hidden"  id="patientid" name="patientid" value="'.$ekg->pt_refno.'"><a href="'.$path.''.$ekg->ekg_us_refno.'/'.$ekg->ekg_picture.'" ><img style="width:100%; height:100px;" src="'.$path.''.$ekg->ekg_us_refno.'/'.$ekg->ekg_picture.'"></a>';
      }
    //   dd($ekg_view);
      $doctor=DB::table('users')
      ->where('us_hos_refno','=',$hos_refno_current)
      ->where('user_type','=','DOCTOR')
      ->get();
    //   dd($doctor);
      $req_hos=DB::table('stemi_patient')
      ->join('stemi_request','stemi_patient.pt_refno','=','stemi_request.rq_pt_refno')
      ->where('stemi_patient.pt_id','=',$id)->get();
      $rq_hos_refno=$req_hos[0]->rq_us_refno;
      return view('patient.ekg_view')
      ->with(['title'=>$title])
      ->with(['ekg_pic'=>$ekg_pic])
      ->with(['req_hos'=>$rq_hos_refno])
      ->with(['doctor'=>$doctor[0]->name])
      ->with(['iddoctor'=>$doctor[0]->us_hos_refno]);
   }
   public function send_doctorview(Request $request){
    $hos_refno_current=Session::get('user')->hos_refno;
        $id=$request->input('iddoctor');
        $idpatient=$request->input('idpatient');
        DB::table('stemi_request')
        ->where('rq_pt_refno','=',$idpatient)
        ->update(['doctor_view'=> $hos_refno_current]);

   }

   public function ekg_view(Request $request){
      $id=$request->input('pt_id');
      $pic_ekg="";
      $pic_ekg=DB::select("select * from stemi_patient_ekg Where ekg_pt_refno=$id");
      
      @session_start();
      $flie="";
      $flie=($_SESSION['hoslefno']);
      $ekg_pic="";
      $path =('https://www.stemibangkok.com/public/public/public/ekg_file/');
      foreach($pic_ekg as $result){
         $ekg_pic.='

            <a href="'.$path.''.$result->ekg_us_refno.'/'.$result->ekg_picture.'"  style="background-image:url();"><img style="width:100%; height:100px;" src="'.$path.''.$result->ekg_us_refno.'/'.$result->ekg_picture.'"></a>


         ';}

         $idpatient=$pic_ekg[0]->ekg_pt_refno;
      return response()->json(array('data'=>$ekg_pic,'idpt'=>$idpatient));
   }
}
