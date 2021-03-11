<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
class MapController extends Controller
{
 public function index()
 {
    if (Session::has('user')){
      $title="นำทางส่งผู้ป่วย";

      return view('patient.map')->with(['title'=>$title]);
   }else{
      return view('auth.login');
   }
}
}