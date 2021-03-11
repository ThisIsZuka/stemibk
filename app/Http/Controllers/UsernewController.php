<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class UsernewController extends Controller
{

    public function index()
    {
        $val['user']=
        DB::table('users')
        ->join("stemi_hospital",'stemi_hospital.hos_refno','users.us_hos_refno')
        ->paginate(10);




        return view('user.index',$val);
    }


    public function create()
    {


        $val['hospital'] = DB::table('stemi_hospital')->get();
        return view('user.create',$val);
    }


    public function store(Request $r)
    {

        //dd($r);
        // +"id": 62
        // +"tn": null
        // +"user_type": "CLIENT"
        // +"name": "นพ. นายแพทย์ ๓"
        // +"email": "rppdr03"
        // +"lineid": null
        // +"phone": ""
        // +"password": "$2y$10$XX/cdVxe7Lh1ACWv5v1SW.UZ85fOOq5gHbs97lHflvT1SRZqgS5dm"
        // +"remember_token": ""
        // +"status": 0
        // +"user_hospital": 0
        // +"us_hos_refno": "20200625001"
        // +"us_refno": 0
        // +"us_token": ""

        // "fullname" => "dfdsfs"
        // "username" => "sssss"
        // "password" => "123456"
        // "hospital" => "1"
        // "user_type" => "DOCTOR"

        $val['user_type']       = $r->user_type;
        $val['name']            = $r->fullname;
        $val['email']           = $r->username;
        $val['password']        = '$2y$10$XX/cdVxe7Lh1ACWv5v1SW.UZ85fOOq5gHbs97lHflvT1SRZqgS5dm';
        $val['us_hos_refno']    = $r->hospital;
        DB::table('users')->insert($val);
        return redirect('user');
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $val['user'] = DB::table('users')
        ->join("stemi_hospital",'stemi_hospital.hos_refno','users.us_hos_refno')
        ->where('id',$id)
        ->first();
        $val['hospital'] = DB::table('stemi_hospital')->get();
        return view('user.edit',$val);
    }


    public function update(Request $r, $id)
    {
        $data['name']           = $r->fullname."";
        $data['email']          = $r->username."";
        $data['us_hos_refno']   = $r->hospital."";
        $data['hos_host']       = $r->user_type."";
        DB::table('users')->where('id',$id)->update($data);
        return redirect('user');
    }


    public function destroy($id)
    {

    }
}
