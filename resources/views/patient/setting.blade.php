@php
        session_start();
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <script>
        // Ignore this in your implementation
        window.isMbscDemo = true;
    </script>
    <script type="text/javascript" src="{{url('')}}/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{{url('')}}/js/jquery-listswipe.js"></script>

    <title>Patient in process</title>
    <link rel="stylesheet" href="{{url('')}}/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{url('')}}/css/drawer.min.css"> --}}
    <script src="{{url('')}}/js/d65bdb08c2.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{url('')}}/js/bootstrap.min.js"></script>
    {{-- <script src="{{url('')}}/js/drawer.min.js"></script> --}}
    <script src="{{url('')}}/js/popper.min.js"></script>
    {{-- <script src="{{url('')}}/js/iscroll.min.js"></script> --}}

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

    @php

      $setting = DB::table('users')
              ->join('stemi_hospital','users.us_hos_refno','stemi_hospital.hos_refno')
              ->where('us_hos_refno','=',$_SESSION['user']->us_hos_refno)
              ->first();


    @endphp


    <script type="text/javascript">
        $(function() {
            $('.example-1').listSwipe();
        });
    </script>

    <style type="text/css">
body {
  font-family: 'Roboto',Arial, sans-serif;
  background: #EEE;
  margin: 0;
}

header {
  background: #AEAEAE;
  color: #FFF;
  padding: 15px 0;
}

header .title { font-size: 34px; }

.inner {
  position: relative;
  max-width: 1080px;
  margin: 0 auto;
  min-width: 320px;
  padding: 0 10px;
}
    </style>
<style type="text/css">
    /* jQuery List Swipe Example CSS */


    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: red;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

    .item-list { overflow: hidden; }

    .item-list .item {
      position: relative;
      display: table;
      width: 100%;
      background: #FFF;
      margin-top: 5px;
    }

    .item-list .item > div {
      padding: 10px;
    }

    .item-list .item .action {
      position: absolute;
      width: 80px;
      height: 100%;
      top: 0;
      border: 0;
      color: #FFF;
      outline: none;
    }

    .item-list .item .action:first-child::before, .item-list .item .action:last-child::before {
      position: absolute;
      top: 0;
      content: '';
      width: 2000px;
      height: 100%;
    }

    .item-list .item .action:first-child { left: -80px; }
    .item-list .item .action:first-child::before { right: 80px; }
    .item-list .item .action:last-child { right: -80px; }
    .item-list .item .action:last-child::before { left: 80px; }
    .item-list .item .action, .item-list .item .action_accept::before { background: #E74C3C; }
    .item-list .item .action, .item-list .item .action_decline::before { background: #E74C3C; }
.acc{
    background-color: #fff;
    color: red;
    border: none;
}
.add{
  border: none;
}
.fas{
    color: #fff;
}
.aaa{
    background: linear-gradient(90deg, rgba(0,123,255,1) 0%, rgba(176,241,237,1) 31%, rgba(0,123,255,1) 100%);
}
/* .btn{
    background-color: #fff;
    color: black;
} */

    </style>
</head>
<body>




    <div class="row col-12 no-gutters bg-primary" style="padding: 10px;padding-top: 30px;">
        <ul class="navbar-nav drawer-menu row">
            <li class="nav-item active col-12">
                <a href="{{url('')}}/patient" class="drawer-toggle"><i class="fas fa-chevron-left fa-2x"></i></a>
            </li>
        </ul>
        <div class="col" style="color:#fff; margin: auto;font-size: large;">ตั้งค่า</div>

        <form class="form-inline">
            <i class="fas fa-search fa-2x"></i>&nbsp;&nbsp;
        <a href="{{url('')}}/patient/create"><i class="fas fa-plus fa-2x"></i></a>
        </form>
    </div>


    @if($setting->user_type=="HOST")

    {{-- dfddddddddddddddddddddddddddd --}}

          {{-- {{Form::open(['url'=>'setting'])}} --}}


        <form method="POST" action="{{url('')}}/setting" class="row" style="margin-left: 4%;margin-right: 4%;margin-top: 5%;margin-bottom: 5%;">
          {{ csrf_field() }}


          @php
              $select="";
          if($setting->hos_status != "CLOSE"){
            $select = "checked";
          }
          $sta = "CLOSE";
          if($setting->hos_status =="CLOSE"){
            $sta = "OPEN";
          }else{
            $sta = "CLOSE";
          }
          @endphp
            {{-- <div class="row" style="width: 100%;"> --}}
              <div class="card" style="width: 100%;">
                <div class="card-body" style="padding: 0;">
                  <div class="row" style="padding: 5px">
                      <div class="col-8" style="align-self: center;">
                        <h5 style="margin: 0;color: currentcolor;padding-left:5px;">สถานการเปิดรับ</h5>
                      </div>
                      <div class="col-4" style="text-align:right;align-self: center;">
                        {{-- <i class="fa fa-toggle-off fa-3x" aria-hidden="true" style="color:#ff3300;padding-right:5px;"></i> --}}
                        <label class="switch" style="margin: 0;">
                          <input type="checkbox" {{$select}}>
                          <span class="slider round"></span>
                        </label>
                      </div>
                  </div>
                </div>
              </div>
              <input type="hidden" name="hos_status" value="{{$sta}}" id="">
              <button type="submit" class="btn btn-success" id="editbtn"> แก้ไข </button>
          {{-- </div> --}}

                  {{-- <div class="form-group col-9"> --}}
                    {{-- <select name="hos_status" class="form-control">
                      <option value="OPEN">เปิดรับผู้ป่วย</option>
                      <option value="CLOSE" {{$select}}>ปิดรับผู้ป่วย</option>
                    </select>
                  </div>
                    <div class="col-3">

                    </div> --}}
          </form>



    @endif


    {{-- <div mbsc-page class="demo-create-read-update-delete"> --}}
        {{-- <form action="#" class="row" id="sss" style="margin-left: 4%;margin-right: 4%;">
            <div class="col-12">
                <small id="emailHelp" class="form-text text-muted">การตั้งค่า</small>
                </div>
            <div class="col-9">
                <input class="form-control form-control-sm" name="search" type="text" placeholder="ค้นหา">
            </div>
            <div class="col-3" style="text-align:center;">
                <button class="btn btn-success btn-sm add" style="width: 100%;" type="submit"><i
                        class="fas fa-search"></i></button>
            </div>

        </form> --}}
    {{-- </div> --}}

{{-- @php
    dd($_SESSION['user']);
@endphp --}}
    <form action="{{url('')}}/setting/{{$_SESSION['user']->id}}" method="POST" style="margin-left: 4%;margin-right: 4%;" id="read" class="row" autocomplete="off">
      @method('PUT')
      @csrf
      <div class="card" style="width: 100%;">
        <div class="card-body" style="padding: 0;">
          <div class="row" style="padding: 5px;margin:0;">
              <div class="col-12" style="align-self: center;"><h5>หมายเลขโทรศัพท์</h5>
              <input type="text" name="phone" style="text-align: center;border-radius: 0;" class="form-control text-phone" id="" placeholder="@if($setting->phone == "") ไม่มีหมายเลขโทรศัพท์ @endif" value="{{$setting->phone}}">
              </div>
              <div class="col-12 btn-ht" style="margin-top: 15px;text-align:center;">
                <button type="submit" class="btn btn-success btn-sm" style="border-radius: 25px;width:50%;">บันทึก</button>
              </div>
          </div>
        </div>
      </div>
        {{-- <div class="col-12">
        <small id="emailHelp" class="form-text text-muted">หมายเลขโทรศัพท์</small>
        </div>
            <div class="col-9">
          <input type="text" class="form-control" name="phone"  id="editPhone" value="{{$setting->phone}}">
            </div>
            <div class="col-3">
          <button type="submit"  class="btn btn-primary"> <k id="eddit"> </button>
            </div> --}}
      </form>

      {{-- <form style="margin-left: 4%;margin-right: 4%;" id="edit" class="row">
        <div class="col-12">
            <small id="emailHelp" class="form-text text-muted">หมายเลขโทรศัพท์11</small>
            </div>
        <br>
            <div class="col-9">
          <input type="text" class="form-control"  id="editPhone" placeholder="0875824652">
        </div>
        <div class="col-3">
          <button type="submit"class="btn btn-primary" >บันทึก</button>
        </div> --}}

      </form>







</body>
<script src="{{url('')}}/js/jquery.min.js"></script>
<script>
  $("#editbtn").hide();
  $(".switch").click(function(){
    setTimeout(function(){ $("#editbtn").click(); }, 1000);
  });
  $(".btn-ht").hide();
  $(".text-phone").focus(function(){
    $(".btn-ht").show(200);
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
  $("#eddit").html("แก้ไข");
  $("#editPhone").click(function(){
    $("#eddit").html("บันทึก");
  });
$(document).ready(function() {
        $("#edit").hide();
        $("#sss").hide();
        $("#cedit").click(function(){
            $("#edit").show();
            $("#read").hide();
        });
        $(".fa-search").click(function(){
            $("#sss").slideToggle();
        });
});
</script>
</html>
