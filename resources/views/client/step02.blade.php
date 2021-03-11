@php
    session_start();
    $patient = DB::table('stemi_request')
    ->join('stemi_patient','stemi_request.rq_pt_refno','stemi_patient.pt_refno')
    ->where('rq_id','=',$rq_id)
    ->first();
    $rq_id = $_GET['rq_id'];
    $phone = DB::table('users')
    ->where([
    ['us_hos_refno',$patient->rq_host_hos_refno],
    ['user_type','HOST'],
])
->first();

$hospital = DB::table('stemi_hospital')
->where('hos_refno','=',$patient->rq_host_hos_refno)->first();
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="{{url('')}}/js/d65bdb08c2.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/d65bdb08c2.js" crossorigin="anonymous"></script>

    <title>Document</title>
    <style>
.btns{
    border-color: #fff;
    margin-top:3px;
    width: 100%;
   background-color: #72fb91;
    box-shadow:1px 1px 1px 1px #57a2f3;
}
.ac{
   border-radius: 50%;
   background-color: #007bff;
   color: #fff;
   width: 30px;
    height: 30px;
    border-color: #fff;
    padding-top: 5px;
    padding-right: 5px;
    border-style: outset;
    border-width: 1px;
}
.ac:hover{
   border-radius: 50%;
   background-color: #4b9ef7;
   color: #fff;
   width: 30px;
    height: 30px;
    border-color: #fff;
    padding-top: 5px;
    padding-right: 5px;
    border-style: inset;
    border-width: 1px;
}
small{
    color: dimgrey;
}
.as{
        border-color: #007bff;
        background-color: #fff;
        color: black;
        width: 100%;
        margin: 1%;
    }
    .ass{
        border-color: #007bff;
        background-color: #ecca62;
        color: black;
        width: 100%;
        margin: 1%;
    }
    .asa{
        border-color: #007bff;
        background-color: #6aec62;
        color: black;
        width: 100%;
        margin: 1%;
    }
    #map_canvas {
    width:100%;
    height:100%;
    margin:auto;
}
.hid{
    border: none;
    font-size: xx-small;
}

    </style>
</head>
<body>
    @php
    //$w_status = array('rq_response_status','=','ACCEPT');
    //$w_hos_refno = array('rq_hos_refno','=',$_SESSION['user']->us_hos_refno);
    //$patient = DB::table('stemi_request')
    //->join('stemi_patient','stemi_request.rq_pt_refno','stemi_patient.pt_refno')
    //->where([$w_status,$w_hos_refno])
    //->orderby('rq_id','desc')
    //->first();
    @endphp

    <div class="container">
        {{-- <h2>Small Modal</h2>
        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
          Open modal
        </button> --}}

        <!-- The Modal -->
        <div class="modal fade" id="myModal-2">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">

              <!-- Modal Header -->


              <!-- Modal body -->
              <div class="modal-body">
                <form method="POST" action="https://stemi-global.com/stemi2/public/clientmap">
                    {{ csrf_field() }}
                {{-- {{Form::open(['url'=>'clientmap'])}} --}}
                    <small style="padding-left: 45%;">เตรียมส่งผู้ป่วย</small><br>


                    <textarea style="border-color: #007bff;" class="form-control" name="message" id="" cols="30" rows="10"></textarea>
                    <button type="submit" name="btn_jobcancel" class="btn ass" value="jobcancel">
                        ปิดงานระหว่างทาง
                    </button>
                    <input type="hidden" value="{{@$rq_id}}" name="rq_id">
                    <br>
                    <button type="submit" name="btn_jobsuccess" class="btn asa" value="jobsuccess">
                        ปิดงานส่งผู้ป่วยเสร็จ
                    </button>
                    <button type="reset"class="btn as">
                        ยกเลิก
                    </button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>

    {{-- NAvBar --}}
<div class="col-12" style="background-color: #007bff;padding-top: 30px;padding-bottom: 4px;" >
    <div class="row">
        <div class="col-3">
            <a href="https://stemi-global.com/stemi2/public/patient"><i class="fas fa-chevron-left" style="color:white;"></i>
            <font style="color:#fff;">STEMI</font></a>
        </div>

        <div class="col-9" style="text-align: right;">
            <a href="#"><i class="fas fa-info-circle " style="color:white;"></i></a>
            &nbsp;
            <a href="#"><i class="fas fa-paper-plane " style="color:white;"></i></a>
            &nbsp;
            <a href="#"><i class="fas fa-server " style="color:white;"></i></a>
        </div>
    </div>

</div>
<div class="col-12">
    <div class="row" style="height: 500px;">

        <div id="map_canvas"></div>
            <div id="showDD" style="margin:auto;padding-top:5px;width:550px;">
                    <!--textbox กรอกชื่อสถานที่ และปุ่มสำหรับการค้นหา เอาไว้นอกแท็ก <form>-->
                <div id="mms">
                            From:
                            <input name="namePlace" type="hidden" id="namePlace" />
                            <br />
                            To:
                            <input name="toPlace" type="hidden" id="toPlace" />
                            <input type="button" name="SearchPlace" id="SearchPlace" value="Search" />
                            <input type="button" name="iClear" id="iClear" value="Clear" />
                            <hr />
                            <!--  <form> เก็บข้อมูลสำหรับนำไปบันทึกลงฐานข้อมูล หรือนำไปใช้อื่นๆ-->
                            <form id="form_get_detailMap" name="form_get_detailMap" method="post" action="">
                            From:
                            <input name="namePlaceGet" type="hidden" id="namePlaceGet" />
                            <br />
                            To:
                            <input name="toPlaceGet" type="hidden" id="toPlaceGet" /><br />
                            ระยะทางข้อความ
                            <input name="distance_text" type="hidden" id="distance_text" value=""  />
                            ระยะทางตัวเลข
                            <input name="distance_value" type="hidden" id="distance_value" value="0"  />
                            เมตร<br />
                            ระยะเวลาข้อความ
                            <input name="duration_text" type="hidden" id="duration_text" size="15" />
                            ระยะเวลาตัวเลข
                            <input name="duration_value" type="hidden" id="duration_value" value="0"  />
                            วินาที
                            <input type="submit" name="button" id="button" value="บันทึก" />
                            <br />
                            * ระยะทางโดยประมาณ ระยะเวลา กรณีขับรถ โดยประมาณ

                     <p id="myconsole"></p>

                     From:
                       <input name="namePlace" type="hidden" id="namePlace" />
                       <br />
                       To:
                       <input name="toPlace" type="hidden" id="toPlace" />
                       <input type="button" name="SearchPlace" id="SearchPlace" value="Search" />
                       <input type="button" name="iClear" id="iClear" value="Clear" />

                </div>



            </div>
        </div>
    </div>

</div>
<div class="col-12" style="background-color: #4b9ef7;padding-top: 4px;padding-bottom: 4px;" >
    <div class="row">
        <div class="col-4">



        </div>
        <div class="col-8" style="text-align: right;">
            <a href="#phone{{$phone->phone}}"><i class="fas fa-phone-alt ac" style="color:white;"></i></a>
            &nbsp;
            <a href="https://stemi-global.com/stemi2/public/chat?rq_id={{$rq_id}}#last"><i class="fas fa-comment ac" style="color:white;"></i></a>
        </div>
    </div>
</div>
<div class="col-12">
    <button data-toggle="modal" data-target="#myModal-2" type="button" class="btn btns eend">&nbsp;&nbsp;&nbsp; <b>จบงาน</b> &nbsp;&nbsp;&nbsp;</button>
</div>
</form>
<div class="col-12">
    <div class="row">
        <div class="col-3" style="margin-top: 3%;">
            <img width='100%;' style="border-radius:50%;" src='https://stemi-global.com/stemi2/public/images/user1.jpg'>
        </div>
        <div class="col-9">
            <small>ชื่อ - นามสกุล : {{@$patient->pt_name}}</small><br>
            <small>ส่งไปโรงพยาบาล : {{@$phone->hos_name}}</small><br>
            <small>เพศ : {{@$patient->pt_gender}}</small><br>
            <small>สิทธ์ : {{@$patient->pt_caretype}}</small><br>
            <small>ระยะทาง : 11</small><br>
            <small>อายุ : {{@$patient->pt_age}}</small><br>
            <small>เวลา : {{@$patient->pt_ptregister}}</small><br>
        </div>
        <div class="col-12">
            @if($patient->pt_id != "")
            <a href="{{url('')}}/img?pt_id={{$patient->pt_id}}">
                <div class="row" style="margin-top: 10px;margin-bottom:10px;">
                    @php
                    $picture = jsonDecode($patient->pt_ekg);
                    @endphp

                    @forelse($picture as $pic)
                    @if($pic!="")
                    <div class="col-4">
                        <img src="{{url('')}}/pic_index/{{$pic}}"
                            width="60px" height="60px">
                    </div>
                    @else
                    {{$pic}}
                    @endif
                    @empty
                    @endforelse
                </div>
            </a>
            @endif
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(".eend").click(function(){
        $(this).hide();
    });
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
   function getLocation() {
  if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(showPosition);
//alert('zzzzz');
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";

  }
}

function showPosition(position) {


    // $('#long').val(position.coords.latitude);
    // $('#lung').val(position.coords.longitude);
    //alert(position.coords.longitude);
  //return position;
}

getLocation();

var directionShow; // กำหนดตัวแปรสำหรับใช้งาน กับการสร้างเส้นทาง
var directionsService; // กำหนดตัวแปรสำหรับไว้เรียกใช้ข้อมูลเกี่ยวกับเส้นทาง
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
var my_Latlng; // กำหนดตัวแปรสำหรับเก็บจุดเริ่มต้นของเส้นทางเมื่อโหลดครั้งแรก
var initialTo; // กำหนดตัวแปรสำหรับเก็บจุดปลายทาง เมื่อโหลดครั้งแรก
var searchRoute; // กำหนดตัวแปร ไว้เก็บฃื่อฟังก์ชั้น ให้สามารถใช้งานจากส่วนอื่นๆ ได้
function initialize() { // ฟังก์ชันแสดงแผนที่
    GGM=new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
    directionShow=new  GGM.DirectionsRenderer({draggable:true});
    directionsService = new GGM.DirectionsService();
    // กำหนดจุดเริ่มต้นของแผนที่
    my_Latlng  = new GGM.LatLng({{$_SESSION['latitude']}},{{$_SESSION['longitude']}});
    //my_Latlng  = new GGM.LatLng(13.7421932,100.7017059);
    // กำหนดตำแหน่งปลายทาง สำหรับการโหลดครั้งแรก
    initialTo=new GGM.LatLng({{$hospital->hos_latitude}},{{$hospital->hos_longitude}});
    var my_mapTypeId=GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
    // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
    var my_DivObj=$("#map_canvas")[0];
    // กำหนด Option ของแผนที่
    var myOptions = {
        zoom: 13, // กำหนดขนาดการ zoom
        center: my_Latlng , // กำหนดจุดกึ่งกลาง จากตัวแปร my_Latlng
        mapTypeId:my_mapTypeId // กำหนดรูปแบบแผนที่ จากตัวแปร my_mapTypeId
    };
    map = new GGM.Map(my_DivObj,myOptions); // สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map
    directionShow.setMap(map); // กำหนดว่า จะให้มีการสร้างเส้นทางในแผนที่ที่ชื่อ map

    if(map){ // เงื่่อนไขถ้ามีการสร้างแผนที่แล้ว
         searchRoute(my_Latlng,initialTo); // ให้เรียกใช้ฟังก์ชัน สร้างเส้นทาง
    }

    // กำหนด event ให้กับเส้นทาง กรณีเมื่อมีการเปลี่ยนแปลง
    GGM.event.addListener(directionShow, 'directions_changed', function() {
        var results=directionShow.directions; // เรียกใช้งานข้อมูลเส้นทางใหม่
        // นำข้อมูลต่างๆ มาเก็บในตัวแปรไว้ใช้งาน
        var addressStart=results.routes[0].legs[0].start_address; // สถานที่เริ่มต้น
        var addressEnd=results.routes[0].legs[0].end_address;// สถานที่ปลายทาง
        var distanceText=results.routes[0].legs[0].distance.text; // ระยะทางข้อความ
        var distanceVal=results.routes[0].legs[0].distance.value;// ระยะทางตัวเลข
        var durationText=results.routes[0].legs[0].duration.text; // ระยะเวลาข้อความ
        var durationVal=results.routes[0].legs[0].duration.value; // ระยะเวลาตัวเลข
        // นำค่าจากตัวแปรไปแสดงใน textbox ที่ต้องการ
        //$("#namePlaceGet").val(addressStart);
        $("#toPlaceGet").val(addressEnd);
        $("#distance_text").val(distanceText);
        $("#distance_value").val(distanceVal);
        $("#duration_text").val(durationText);
        $("#duration_value").val(durationVal);
    });

}
$(function(){
    $("#mms").hide();
    // ส่วนของฟังก์ชัน สำหรับการสร้างเส้นทาง
    searchRoute=function(FromPlace,ToPlace){ // ฟังก์ชัน สำหรับการสร้างเส้นทาง
        if(!FromPlace && !ToPlace){ // ถ้าไม่ได้ส่งค่าเริ่มต้นมา ให้ใฃ้ค่าจากการค้นหา
            var FromPlace=$("#namePlace").val();// รับค่าชื่อสถานที่เริ่มต้น
            var ToPlace=$("#toPlace").val(); // รับค่าชื่อสถานที่ปลายทาง
        }
        // กำหนด option สำหรับส่งค่าไปให้ google ค้นหาข้อมูล
        var request={
            origin:FromPlace, // สถานที่เริ่มต้น
            destination:ToPlace, // สถานที่ปลายทาง
            travelMode: GGM.DirectionsTravelMode.DRIVING // กรณีการเดินทางโดยรถยนต์
        };
        // ส่งคำร้องขอ จะคืนค่ามาเป็นสถานะ และผลลัพธ์
        directionsService.route(request, function(results, status){
            if(status==GGM.DirectionsStatus.OK){ // ถ้าสามารถค้นหา และสร้างเส้นทางได้
                directionShow.setDirections(results); // สร้างเส้นทางจากผลลัพธ์
                // นำข้อมูลต่างๆ มาเก็บในตัวแปรไว้ใช้งาน
                var addressStart=results.routes[0].legs[0].start_address; // สถานที่เริ่มต้น
                var addressEnd=results.routes[0].legs[0].end_address;// สถานที่ปลายทาง
                var distanceText=results.routes[0].legs[0].distance.text; // ระยะทางข้อความ
                var distanceVal=results.routes[0].legs[0].distance.value;// ระยะทางตัวเลข
                var durationText=results.routes[0].legs[0].duration.text; // ระยะเวลาข้อความ
                var durationVal=results.routes[0].legs[0].duration.value; // ระยะเวลาตัวเลข
                // นำค่าจากตัวแปรไปแสดงใน textbox ที่ต้องการ
                $("#namePlaceGet").val(addressStart);
                $("#toPlaceGet").val(addressEnd);
                $("#distance_text").val(distanceText);
                $("#distance_value").val(distanceVal);
                $("#duration_text").val(durationText);
                $("#duration_value").val(durationVal);
                // ส่วนการกำหนดค่านี้ จะกำหนดไว้ที่ event direction changed ที่เดียวเลย ก็ได้
            }else{
                // กรณีไม่พบเส้นทาง หรือไม่สามารถสร้างเส้นทางได้
                // โค้ดตามต้องการ ในทีนี้ ปล่อยว่าง
            }
        });
    }

    // ส่วนควบคุมปุ่มคำสั่งใช้งานฟังก์ชัน
    $("#SearchPlace").click(function(){ // เมื่อคลิกที่ปุ่ม id=SearchPlace
        searchRoute();  // เรียกใช้งานฟังก์ชัน ค้นหาเส้นทาง
    });

    $("#namePlace,#toPlace").keyup(function(event){ // เมื่อพิมพ์คำค้นหาในกล่องค้นหา
        if(event.keyCode==13 && $(this).val()!=""){ //  ตรวจสอบปุ่มถ้ากด ถ้าเป็นปุ่ม Enter
            searchRoute();      // เรียกใช้งานฟังก์ชัน ค้นหาเส้นทาง
        }
    });

    $("#iClear").click(function(){
        $("#namePlace,#toPlace").val(""); // ล้างค่าข้อมูล สำหรับพิมพ์คำค้นหาใหม่
    });

});


setTimeout(function(){
$(function(){
    // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
    // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
    // v=3.2&sensor=false&language=th&callback=initialize
    //  v เวอร์ชัน่ 3.2
    //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
    //  language ภาษา th ,en เป็นต้น
    //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize
    $("<script/>", {
            "type": "text/javascript",
            src: "https://maps.googleapis.com/maps/api/js?key=AIzaSyB4hFUknS-ndG6VIulHn17-8POBICfcR9w&callback=initMap&v=3.37&sensor=false&language=th&callback=initialize"
          }).appendTo("body");
});

}, 1000);
      </script>


</body>
</html>
