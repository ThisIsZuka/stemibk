<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <script>
        // Ignore this in your implementation
        window.isMbscDemo = true;
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="https://stemi-global.com/stemi2/public/js/jquery-listswipe.js"></script>

    <title>Patient in process</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.2/css/drawer.min.css">
    <script src="https://kit.fontawesome.com/js/d65bdb08c2.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.2/js/drawer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.2.0/iscroll.min.js"></script>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

    @php

      $setting = DB::table('users')
              ->join('stemi_hospital','users.us_hos_refno','stemi_hospital.hos_refno')
              ->where('us_hos_refno','=',auth::user()->us_hos_refno)
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
.btn{
    background-color: #fff;
    color: black;
}

    </style>
</head>
<body>




    <div class="row col-12 no-gutters bg-primary" style="padding: 10px;">
        <ul class="navbar-nav drawer-menu row">
            <li class="nav-item active col-12">
                <a href="https://stemi-global.com/stemi2/public/patient" class="drawer-toggle"><i class="fas fa-chevron-left fa-2x"></i></a>
            </li>
        </ul>
        <div class="col" style="color:#fff; margin: auto;font-size: large;">ตั้งค่า</div>

        <form class="form-inline">
            <i class="fas fa-search fa-2x"></i>&nbsp;&nbsp;
        <a href="https://stemi-global.com/stemi2/public/patient/create"><i class="fas fa-plus fa-2x"></i></a>
        </form>
    </div>


    @if($setting->user_type=="HOST")

    {{-- dfddddddddddddddddddddddddddd --}}

          {{-- {{Form::open(['url'=>'setting'])}} --}}
          <div class="col-md-12">
            <div class="row">
             <div class="col-md-12">
             <div class="col-md-9">1</div>
             <div class="col-md-3">1</div>
            </div>
            <div class="col-md-12">
             <div class="col-md-9">2</div>
             <div class="col-md-3">2</div>
            </div>
            </div>

           </div>

          <form method="POST" action="https://stemi-global.com/stemi2/public/setting" style="margin-left: 5%;
          margin-top: 5%;
          margin-bottom: 5%;
          margin-right: 13%;">
            {{ csrf_field() }}


          @php
              $select="";
          if($setting->hos_status=="CLOSE"){
            $select = "selected";
          }

          @endphp

                  <div class="form-group col-9">
                    <select name="hos_status" style="margin-top: 9px;" class="form-control">
                      <option value="OPEN">เปิดรับผู้ป่วย</option>
                      <option value="CLOSE" {{$select}}>ปิดรับผู้ป่วย</option>
                    </select>
                  </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-success"> แก้ไข </button>
                    </div>
          </form>



    @endif


    {{-- <div mbsc-page class="demo-create-read-update-delete"> --}}
        <form action="#" class="row" id="sss" style="margin-left: 4%;margin-right: 4%;">
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

        </form>
    {{-- </div> --}}


    <form action="{{url('')}}/setting" method="POST" style="margin-left: 4%;margin-right: 4%;" id="read" class="row">
      @method('PUT')
      @csrf
        <div class="col-12">
        <small id="emailHelp" class="form-text text-muted">หมายเลขโทรศัพท์</small>
        </div>
            <div class="col-9">
          <input type="text" class="form-control"  id="editPhone" placeholder="0875824652" readonly>
            </div>
            <div class="col-3">
          <button type="submit"  class="btn btn-primary" id="cedit">แก้ไข</button>
            </div>
      </form>

      <form style="margin-left: 4%;margin-right: 4%;" id="edit" class="row">
        <div class="col-12">
            <small id="emailHelp" class="form-text text-muted">หมายเลขโทรศัพท์</small>
            </div>
        <br>
            <div class="col-9">
          <input type="text" class="form-control"  id="editPhone" placeholder="0875824652">
        </div>
        <div class="col-3">
          <button type="submit"class="btn btn-primary" >บันทึก</button>
        </div>

      </form>







</body>
<script>
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
