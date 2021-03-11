<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
class StemiChatController extends Controller
{
  public function index(Request $r)
  {
     if(empty(Session::get('user')->us_hos_refno)){
      return view('auth.login');
      }else{
         $title="แชท";

         $hos_refno = $r->input('hos_refno') ;

         $hospital=DB::table('stemi_hospital')
         ->where('hos_refno','!=',Session::get('user')->us_hos_refno)
         ->get();
         $hospital_chat="<option value=''>เลือกโรงพยาบาล</option>";
         foreach ($hospital as $result) {
            
            if($hos_refno == $result->hos_refno)
            {
               $hospital_chat.='<option selected value='.$result->hos_refno.'>'.$result->hos_name.'</option>';
            }else
            {
               $hospital_chat.='<option value='.$result->hos_refno.'>'.$result->hos_name.'</option>';
            }

         }

         return view('patient.stemi_chat')
         ->with(['title'=>$title])
         ->with(['hospital_chat'=>$hospital_chat]);
      }
   }

   public function hospital(Request $r)
  {
     
         $title="แชท";

         $hos_refno = $r->input('hos_refno') ;

         $hospital=DB::table('stemi_hospital')
         ->where('hos_refno','!=',Session::get('user')->us_hos_refno)
         ->get();
         $hospital_chat="<option value=''>เลือกโรงพยาบาล</option>";
         foreach ($hospital as $result) {
            
            if($hos_refno == $result->hos_refno)
            {
               $hospital_chat.='<option selected value='.$result->hos_refno.'>'.$result->hos_name.'</option>';
            }else
            {
               $hospital_chat.='<option value='.$result->hos_refno.'>'.$result->hos_name.'</option>';
            }

         }

         return view('patient.stemi_chat_hospital')
         ->with(['title'=>$title])
         ->with(['hospital_chat'=> $hospital_chat]);
      
   }
}