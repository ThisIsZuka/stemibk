<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <meta name="csrf-token" content="{{ csrf_token() }}" />
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
 <link rel="stylesheet" href="{{url('')}}/css/bootstrap.min.css">
 {{-- <script src="{{url('')}}/js/jquery.min.js"></script> --}}
 {{-- <script src="{{url('')}}/js/popper.min.js"></script> --}}
 {{-- <script src="{{url('')}}/js/bootstrap.min.js"></script> --}}
 <script src="{{url('')}}/js/d65bdb08c2.js"></script>
 {{-- <script src="{{url('')}}/js/bootstrap.min.js"></script> --}}
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <title>โรงพยาบาลแม่ข่าย</title>
 <style>
    .bggreen{
     background-color: #90EE90;
     border: 1px solid lightgreen;
     border-radius: 10px;
     margin-bottom: 3px;
     padding: 3px;
  }
  .bggray{
     background-color: #fb9a9a;
     border-radius: 10px;
     margin-bottom: 3px;
      padding: 3px;
  }
  .bgoff{
     background-color: #dcdcdc;
     border-radius: 10px;
     margin-bottom: 3px;
      padding: 3px;
  }
  b{
     color: #FF4500;
  }
    /* .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
        color: #007bff !important;
        } */
        .ct{
           text-align: center;
           margin: auto;
           margin-top: 10px;
        }

        body{
           background-color: #F8F8FF;
        }
        .menu1,.menu2,{
           color: #fff !important;
        }
        .menu1:hover, .menu1:active,.menu1:visited, .menu1:focus{
           color: #007bff !important;

        }
        .menu1:active,.menu1:visited, .menu1:focus,.menu2:active,.menu2:visited, .menu2:focus{
           /*color: #fff !important;*/
           /*text-shadow: 1px 1px 4px #007bff;*/
        }
        .menu2:hover{
           color: #fff !important;
           background-color: #007bff !important;
        }
        .map{
           background-color: #fff;
        }
        .modal-body{
           text-align: center;
        }
        .ms{
           width: 98%;
           margin: 1%;
        }
        a{
           color: black;
           font-weight: bold;
        }
        .active>.menu1{
          /*text-shadow: 1px 1px 4px #007bff;*/
       }

       small{
         font-size: 17px;
         color: #000 !important;
      }

/* a, a:hover, a:active, a:visited, a:focus {
    text-decoration:none;
    color: black;
    } */
 </style>
</head>
<body>
 {{-- <div style="position: absolute;padding-top: 35px;">&emsp;&emsp;<a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit"><i
  class="fas fa-chevron-left fa-lg" style="color:white;"></i></a></div> --}}
  <ul class="nav nav-tabs bg-primary" style="justify-content: flex-end;">
     {{-- <li><button type="button" class="btn map" data-toggle="modal" data-target="#exampleModal" style="padding-top: 33%;">
        <i class="fas fa-map-marker-alt fa-lg text-success"></i></button></li> --}}
        <li style="margin-right: auto;"><a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit"><i class="fas fa-chevron-left fa-lg" style="color:white;"></i></a></li>
        {{-- <li><a style="color:#fff;" href="{{url('hospital')}}">t Refresh</a></li>
        <li><a style="color:#fff;">{{rand(1,1000)}}</a></li> --}}
        <li class="active"><a class="menu1"  data-toggle="tab" href="#menu1"  aria-expanded="true">ในโชน</a></li>
        <li><a class="menu1"  data-toggle="tab" href="#menu2">นอกโชน</a></li>

        {{-- <li><a class="menu2" data-toggle="tab" href="#menu3"><i class="fas fa-map fa-lg" ></i></a></li> --}}

     </ul>


     <div class="tab-content" style="margin-top: 3px;">
      {{-- <div id="home" class="tab-pane fade in active"> --}}
       @php




       $zone = DB::table('stemi_hospital')->where('hos_refno','=',$_SESSION['user']->us_hos_refno)->first();


       $w_host     = array('hos_host'  ,'='    ,'HOST');
       $w_zone     = array('hos_zone'  ,'='    ,$zone->hos_zone);
       $out_zone   = array('hos_zone'  ,'!='   ,$zone->hos_zone);
       $w_status   = array('hos_status','='    ,'OPEN');
       $w_status2  = array('hos_status','='    ,'CLOSE');
       $w_noself   = array('hos_refno' ,'!='   ,$_SESSION['user']->us_hos_refno);
       $w_on       = array('us_token','!=','');
       $w_of       = array('us_token','');
       $x_status   = array('user_type','HOST');
       $x_name1     = array('name','เจ้าหน้าที่ ๑');
       $x_name2     = array('name','เจ้าหน้าที่ ๒');

       $hos_open   = DB::table('stemi_hospital')->where([$w_zone,$w_status,$w_host,$w_noself])->join('users','users.us_hos_refno','stemi_hospital.hos_refno')->groupBy('hos_name')->where([$w_on,$x_status])->orderBy('hos_latitude', 'desc')->get();
       $hos_close  = DB::table('stemi_hospital')->where([$w_zone,$w_status2,$w_host,$w_noself])->join('users','users.us_hos_refno','stemi_hospital.hos_refno')->where([$w_on,$x_status,$x_name1])->groupBy('hos_name')->where([$w_on,$x_status])->get();
       $hos_off    = DB::table('stemi_hospital')->where([$w_zone,$w_status2,$w_host,$w_noself])->join('users','users.us_hos_refno','stemi_hospital.hos_refno')->where([$w_of,$x_status,$x_name1])->groupBy('hos_name')->where([$w_of,$x_status])->get();

       $out_hos_open   = DB::table('stemi_hospital')->where([$out_zone,$w_status,$w_host,$w_noself])->join('users','users.us_hos_refno','stemi_hospital.hos_refno')->where([$w_on,$x_status])->groupBy('hos_name')->get();
       $out_hos_close  = DB::table('stemi_hospital')->where([$out_zone,$w_status2,$w_host,$w_noself])->join('users','users.us_hos_refno','stemi_hospital.hos_refno')->where([$w_on,$x_status,$x_name1])->groupBy('hos_name')->get();
       $out_hos_off    = DB::table('stemi_hospital')->where([$out_zone,$w_status2,$w_noself])->join('users','users.us_hos_refno','stemi_hospital.hos_refno')->where([$w_of,$x_status,$x_name1])->groupBy('hos_name')->get();

       // $i=0;
       // foreach($hos_close as $h){
       //     $h_close[$i]['hos_id']              =$h->hos_id;
       //     $h_close[$i]['hos_refno']           =$h->hos_refno;
       //     $h_close[$i]['hos_name']            =$h->hos_name;
       //     $h_close[$i]['hos_name_eng']        =$h->hos_name_eng;
       //     $h_close[$i]['hos_address']         =$h->hos_address;
       //     $h_close[$i]['hos_zone']            =$h->hos_zone;
       //     $h_close[$i]['hos_host']            =$h->hos_host;
       //     $h_close[$i]['hos_type']            =$h->hos_type;
       //     $h_close[$i]['hos_phone']           =$h->hos_phone;
       //     $h_close[$i]['hos_fax']             =$h->hos_fax;
       //     $h_close[$i]['hos_logo']            =$h->hos_logo;
       //     $h_close[$i]['hos_latitude']        =$h->hos_latitude;
       //     $h_close[$i]['hos_longitude']       =$h->hos_longitude;
       //     $h_close[$i]['hos_status']          =$h->hos_status;
       //     $h_close[$i]['hos_status_us_refno'] =$h->hos_status_us_refno;
       //     $h_close[$i]['hos_update']          =$h->hos_update;
       //     $h_close[$i]['distance']            = round(getDistance(13.73233,100.53463,$h->hos_latitude,$h->hos_longitude),1);
       //     $h_close[$i]['minute']              = round($h_close[$i]['distance']*2.8);
       //     $i++;
       // }
       // usort($h_close, 'mysort1');
       // $br = "<br>";

       // endforeach
       @endphp
       {{--
         @foreach ($h_close as $abc)
         @php
         $ab="";
         if(($abc['hos_type'])=="GOV"){
         $ab = "hot1.png";
      }elseif (($abc['hos_type'])=="NGOV") {
      $ab = "hot2.png";
   }elseif (($abc['hos_type'])==null) {
   $ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp




<div class="container bggray">
  <div class="row">
   <div class="col-4">
    <img width='100px;' src='{{url('')}}/images/{{$ab}}'>
 </div>

 @if(isset($_GET['hospital']))
 <div class="col-5">
   <div>
     <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc['hos_refno']}}">{{$abc['hos_name']}}</a>
  </div>

  <small style="color:#696969;">
     {{$abc['hos_phone']}}
  </small>
</div>

@else
<div class="col-5">
   <div>
      <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc['hos_refno']}}">
       @php
       $name = $abc['hos_name'];
       @endphp
       {{str_replace(" ", ' ',$abc['hos_name'])}}
    </a>
 </div>

 <small style="color:#696969;">
   {{$abc['hos_phone']}}
</small>
</div>

@endif


@php
@endphp

<div class="col-3">
 <div>{{$abc['minute']}} นาที</div>
 <div>{{$abc['distance']}} กม.</div>
</div>
</div>
<hr>
</div>

@endforeach  --}}
{{-- </div> --}}



<div id="menu1" class="tab-pane fade in active">

 @foreach ($hos_open as $abc)
 @php
 $ab="";
 if(($abc->hos_type)=="GOV"){
 $ab = "hot1.png";
}elseif (($abc->hos_type)=="NGOV") {
$ab = "hot2.png";
}elseif (($abc->hos_type)==null) {
$ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp

<div class="container bggreen">
   <div class="row">
    <div class="col-4">
     <img width='100px;' src='{{url('')}}/images/{{$ab}}'>
  </div>

  @if(isset($_GET['hospital']))
  <div class="col-5">
   <div>
      <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
      {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
   </div>

   <small style="color:#696969;">
      {{$abc->hos_phone}}
   </small>
</div>

@else
<div class="col-5">
  <div>
    <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
    {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
 </div>
 <small style="color:#696969;">
    {{$abc->hos_phone}}
 </small>
</div>

@endif


@php

$distance = round(getDistance(13.73233,100.53463,$abc->hos_latitude,$abc->hos_longitude),1);
$minute = round($distance*2.8);
@endphp

<div class="col-3">
   <div>{{$minute}} นาที</div>
   <div>{{$distance}} กม.</div>
</div>
</div>

</div>

@endforeach


@foreach ($hos_close as $abc)
@php
$ab="";
if(($abc->hos_type)=="GOV"){
$ab = "hot1.png";
}elseif (($abc->hos_type)=="NGOV") {
$ab = "hot2.png";
}elseif (($abc->hos_type)==null) {
$ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp

<div class="container bggray">
   <div class="row">
    <div class="col-4">
     <img width='100px;' src='{{url('')}}/images/{{$ab}}'>
  </div>

  @if(isset($_GET['hospital']))
  <div class="col-5">
   <div>
      <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
      {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
   </div>

   <small style="color:#696969;">
      {{$abc->hos_phone}}
   </small>
</div>

@else
<div class="col-5">
   <h5 style="margin-top: 5px;">
    <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
    {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
 </h5>
 <br>
 <small style="color:#696969;">
    {{$abc->hos_phone}}
 </small>
</div>

@endif


@php

$distance = round(getDistance(13.73233,100.53463,$abc->hos_latitude,$abc->hos_longitude),1);
$minute = round($distance*2.8);
@endphp

<div class="col-3">
 <div>{{$minute}} นาที</div>
 <div>{{$distance}} กม.</div>
</div>
</div>

</div>

@endforeach

@foreach ($hos_off as $abc)
@php
$ab="";
if(($abc->hos_type)=="GOV"){
$ab = "hot1.png";
}elseif (($abc->hos_type)=="NGOV") {
$ab = "hot2.png";
}elseif (($abc->hos_type)==null) {
$ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp

<div class="container bgoff">
   <div class="row">
    <div class="col-4">
     <img width='100px;' src='{{url('')}}/images/{{$ab}}'>
  </div>

  @if(isset($_GET['hospital']))
  <div class="col-5">
   <div>
      <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
      {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
   </div>

   <small style="color:#696969;">
      {{$abc->hos_phone}}
   </small>
</div>

@else
<div class="col-5">
  <div>
    <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
    {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
 </div>

 <small style="color:#696969;">
    {{$abc->hos_phone}}
 </small>
</div>

@endif


@php

$distance = round(getDistance(13.73233,100.53463,$abc->hos_latitude,$abc->hos_longitude),1);
$minute = round($distance*2.8);
@endphp

<div class="col-3">
 <div>{{$minute}} นาที</div>
 <div>{{$distance}} กม.</div>
</div>
</div>

</div>

@endforeach
</div>
<div id="menu2" class="tab-pane fade">

 @foreach ($out_hos_open as $abc)
 @php
 $ab="";
 if(($abc->hos_type)=="GOV"){
 $ab = "hot1.png";
}elseif (($abc->hos_type)=="NGOV") {
$ab = "hot2.png";
}elseif (($abc->hos_type)==null) {
$ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp

<div class="container bggreen">
   <div class="row">
    <div class="col-4">
     <img width='100px;' src='{{url('')}}/images/{{$ab}}'>
  </div>

  @if(isset($_GET['hospital']))
  <div class="col-5">
   <div>
      <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
      {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
   </div>

   <small style="color:#696969;">
      {{$abc->hos_phone}}
   </small>
</div>

@else
<div class="col-5">
 <div>
    <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">{{$abc->hos_name}}</a>
    {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
 </div>
 <small style="color:#696969;">
    {{$abc->hos_phone}}
 </small>
</div>

@endif



@php

$distance = round(getDistance(13.73233,100.53463,$abc->hos_latitude,$abc->hos_longitude),1);
$minute = round($distance*2.8);
@endphp

<div class="col-3">
 <div>{{$minute}} นาที</div>
 <div>{{$distance}} กม.</div>
</div>
</div>

</div>

@endforeach


@foreach ($out_hos_close as $abc)
@php
$ab="";
if(($abc->hos_type)=="GOV"){
$ab = "hot1.png";
}elseif (($abc->hos_type)=="NGOV") {
$ab = "hot2.png";
}elseif (($abc->hos_type)==null) {
$ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp

<div class="container bggray">
   <div class="row">
    <div class="col-4">
     <img width='100px;' src='{{url('')}}/images/{{$ab}}'>
  </div>

  @if(isset($_GET['hospital']))
  <div class="col-5">
    <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">
       <div>
         {{$abc->hos_name}}
         {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
      </div>

      <small style="color:#696969;">
         {{$abc->hos_phone}}
      </small></a>
   </div>

   @else

   <div class="col-5"><a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">
      <h5 style="margin-top: 5px;">
       {{$abc->hos_name}}
       {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
    </h5>
    <br>
    <small style="color:#696969;">
       {{$abc->hos_phone}}
    </small></a>
 </div>

 @endif



 @php

 $distance = round(getDistance(13.73233,100.53463,$abc->hos_latitude,$abc->hos_longitude),1);
 $minute = round($distance*2.8);
 @endphp

 <div class="col-3">
    <div>{{$minute}} นาที</div>
    <div>{{$distance}} กม.</div>
 </div>
</div>

</div>

@endforeach


@foreach ($out_hos_off as $abc)
@php
$ab="";
if(($abc->hos_type)=="GOV"){
$ab = "hot1.png";
}elseif (($abc->hos_type)=="NGOV") {
$ab = "hot2.png";
}elseif (($abc->hos_type)==null) {
$ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp

<div class="container bgoff">
   <div class="row">
    <div class="col-4">
     <img width='100px;' src='{{url('')}}/images/{{$ab}}'>
  </div>

  @if(isset($_GET['hospital']))
  <div class="col-5">
    <a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">
  <div>
      {{$abc->hos_name}}
      {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
   </div>
   <small style="color:#696969;">
      {{$abc->hos_phone}}
   </small></a>
</div>

@else

<div class="col-5"><a href="{{url('')}}/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}}">
   <h5 style="margin-top: 5px;">
    {{$abc->hos_name}}
    {{-- <br>https://stemi-global.com/stemi2/public/patient/{{@$_SESSION['rq_id']}}/edit?hos_refno={{$abc->hos_refno}} --}}
 </h5>
 <br>
 <small style="color:#696969;">
    {{$abc->hos_phone}}
 </small></a>
</div>

@endif



@php

$distance = round(getDistance(13.73233,100.53463,$abc->hos_latitude,$abc->hos_longitude),1);
$minute = round($distance*2.8);
@endphp

<div class="col-3">
   <div>{{$minute}} นาที</div>
   <div>{{$distance}} กม.</div>
</div>
</div>

</div>

@endforeach

</div>


{{-- <div id="menu2" class="tab-pane fade">
   @php
   $all = DB::table("stemi_hospital")->get();
   //dd($all);
   @endphp

   @foreach ($all as $ss)
   <div class="col-12 ac">
     <div class="row">
      <div class="col-3">
       @php
       $ab="";
       if(($ss->hos_type)=="GOV"){
       $ab = "hot1.png";
    }elseif (($ss->hos_type)=="NGOV") {
    $ab = "hot2.png";
 }elseif (($ss->hos_type)==null) {
 $ab = "hot1.png";
}else{
$ab = "hot1.png";
}
@endphp
<img width='100px;' src='https://stemi-global.com/stemi2/public/images/{{$ab}}'>
</div>
<div class="col-8">
 <h4><a href="https://stemi-global.com/stemi2/public/patient/create?hos_refno={{$ss->hos_refno}}">{{$ss->hos_name}}</a></h4><br>
 <small style="color:#696969;">{{$ss->hos_address}}</small>
</div>
<div class="col-1 ct">
 <b>32</b><br>นาที<br><b>25</b><br>กม.
</div>
</div>

</div>
@endforeach

</div> --}}


</div>


<div class="modal fade" id="exampleModal" role="dialog">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
      <span aria-hidden="true" style="padding-left: 95%;">&times;</span>
   </button>
   <div class="modal-body">
      <div class="col-12">
       <div class="row">
        <div class="col-12">เลือกสถานะโรงพยาบาล</div>
        <div class="col-12"><button type="button" class="btn btn-success ms">เปิดรับผู้ป่วย</button></div>
        <div class="col-12"><button type="button" class="btn btn-danger ms">ไม่รับผู้ป่วย</button></div>
        <div class="col-12"><button type="button" class="btn btn-secondary ms">ไม่ได้เข้าสู่ระบบ</button></div>
        <div class="col-12"><button type="button" class="btn btn-light ms">ทั้งหมด</button></div>
     </div>
  </div>

</div>
</div>
</div>
</div>


</body>
<script src="{{url('')}}/dsb/lib/jquery/jquery.min.js"></script>
<script>
        // $('.start').click(function(){
        //     alert();
        // });
        // $(".start").click();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        setInterval(function(){
          $.post("https://stemi-global.com/stemi2/public/jquery",
          {
           event   : "directpage",
           uid     : "{{$_SESSION['user']->id}}",
        },
        function(data, status){
           if(data!=""){
             window.location.replace(data);
          }
       });
       }, 3000);
    </script>

    </html>
