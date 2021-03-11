<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;

class HospitalController extends Controller
{
  
  public function index()
  {
    session_start();
    return view("patient.hospital");
  }
}
