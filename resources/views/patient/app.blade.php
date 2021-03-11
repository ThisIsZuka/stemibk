
<link href="{{URL::asset('public/stemi_css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('public/font_kanit/stylesheet.css')}}" rel="stylesheet" />
<script src="{{url('')}}/public/stemi_js/jquery-3.4.1.min.js"></script>
<script src="{{url('')}}/public/stemi_js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/font-awesome/css/font-awesome.min.css')}}">
<script src="{{url('public/node_modules/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

{{-- CSS ส่วนของ nav-bottom --}}
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/menu-bottom/menu-bottom.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/media-device.css')}}">
<style type="text/css">
   .modal-full {
      min-width: 100%;
      min-height: 300px;
      margin-left: 7px;
   }
   .modal-full .modal-content {
      min-height: 100%;
      max-width: 100%;
      margin: 1px;
   }
   .form-control:disabled, .form-control[readonly]{
      background-color: #fff;
   }
</style>
<audio id="myAudio">
   <source src="{{url('')}}/public/emergency.ogg" type="audio/ogg">
     <source src="{{url('')}}/public/emergency.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
     </audio>
     <div class="modal" id="setting_modal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <div class="modal-body">
              <div class="txt">ตั้งค่า</div>
              <div class="txt-l">สถานะ:การเปิดรับผู้ป่วย</div>
              <div class="txt">
               <input type="checkbox" id="status_chk">เปิด/ปิด
                 <div id="status"></div>
              </div>
              <div class="txt">
                 <i class="fa fa-mobile" aria-hidden="true" style="font-size:70px;"></i> แก้ไขเบอร์โทร
                 <input type="text" class="form-control txt-l" name="mobile" id="mobile" placeholder="ระบุเบอร์โทรศัพท์">
              </div>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-stemi-cancel" data-dismiss="modal">ยกเลิก</button>
            <button type="button" class="btn btn-stemi-accept" id="save_setting">บันทึก</button>
         </div>
      </div>
   </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="res_modal">
  <div class="modal-dialog modal-full" role="document">
    <div class="modal-content">

      <div class="modal-body">
         <div class="txt-h">ข้อความจากแม่ข่าย โรงพยาบาล 1</div>

         <div id="press" class="txt-h"></div>
         <button type="button" class="btn btn-stemi-accept">นำทาง</button>
         <button type="button" class="btn btn-stemi-cancel" data-dismiss="modal">ตกลง</button>
      </div>
   </div>
</div>
</div>

<style type="text/css">
   .navbar-light .navbar-brand{
      color:#fff;
   }
   .navbar-light .navbar-nav .nav-link{
      color:#fff;
      font-family: Kanit_ex;
   }
</style>
<div class="navbar navbar-light" style="background-color: #ca004e;">
   <div>
      <a class="navbar-brand txt-l txt-white" href="#">
         {{$title}}

      </a>
   </div>
   <button class="btn txt-w" id="setting">
      <?php if(Session::get('user')->hos_status="OPEN"){;?>
        <i class="fa fa-cog" aria-hidden="true" style="font-size: 70px;"></i>
     <?php  }else if(Session::get('user')->hos_status='CLOSE'){;?>
       <i class="fa fa-cog" aria-hidden="true" style="font-size: 70px;"></i>
    <?php };?>
    <div>

    </div>
    <div class="txt-time">
       {{Session::get('user')->hos_status}}
    </div>
 </button>

 <div class="text-right txt-l txt-w">
   <div class="txt-user">
     {{Session::get('user')->name}}
  </div>
  <div class="txt-user">
    {{Session::get('user')->hos_name}}
    {{Session::get('user')->hos_refno}}
 </div>

 <input type="hidden" id="hos" value="{{Session::get('user')->us_hos_refno}}">

 <a href="{{url('logout')}}" class="btn btn-stemi"><i class="fa fa-sign-out" aria-hidden="true"></i> ออกจากระบบ</a>
</div>
</div>

<main class="py-1" style="margin-bottom: 200px;">
 @yield('content')
</main>


<div class="modal" tabindex="-1" role="dialog" id="request">
 <div class="modal-dialog modal-full" role="document">
  <div class="modal-content">

   <div class="modal-body text-center">
      <img src="{{url('')}}/public/stemi_images/light.gif">
      <div class="txt-h">ร้องขอการส่งตัวผู้ป่วย</div>
      <div class="txt-l">จาก</div>
      <div id="hos_request" class="txt"></div>
      <div class="txt-l">ร้องขอส่งตัวผู้ป่วย</div>
      <div id="pt_name_request" class="txt"></div>
      <div class="txt-l">เพศ</div>

      <div class="txt" id="pt_gender_request"></div>
      <!-- <div class="txt">..........อายุ....สิทธิการรักษา.....โรคประจำตัวผู้ป่วย....วันที่และเวลาทำ EKG ภาพผลตรวจ EKG</div> -->
      <div class="txt-l" id="ekg"></div>
      <div class="txt-time">วันเวลาที่ร้องขอ</div>
      <div class="txt-h" id="countdown"></div>
      <div class="txt-h">
         เหตุผลการปฏิเสธ
      </div>
      <div class="txt-h">
         <select class="form-control txt-l" id="reason">
            <option value="">
              ระบุเหตุผล
           </option>
           <option value="ไม่มีเตียง">
            ไม่มีเตียง
         </option>
         <option value="มี Intra Condication">
            มี Intra Condication
         </option>
         <option value="ขอ Investigate เพิ่มเติม">
           ขอ Investigate เพิ่มเติม
        </option>
        <option value="ไม่มีเครื่องมือ">
         ไม่มีเครื่องมือ
      </option>
   </select>
</div>

<div>
   <input type="hidden" id="res_message">
   <!-- <input type="text" class="form-control" id="accept"> -->
</div>
<button type="button" class="btn btn-stemi-accept" id="res" data="กดรับตัวผู้ป่วย">กดรับตัวผู้ป่วย</button>
<button type="button" class="btn btn-stemi-fail" id="cancel" data="ปฏิเสธ">ปฏิเสธ</button>
</div>
</div>
</div>
</div>
<!-- menu ด้านล่าง ใสๆๆๆ -->
<div class="nav_bottom">
   <div class="row">
      <div class="col-3">
         <a href="{{url('patient')}}" class="txt-guild">
            <div>
             <i class="fa fa-users" aria-hidden="true" style="font-size: 45px;"></i>
          </div>
          <div>
             รายการส่งตัว
          </div>
       </a>
    </div>

    <div class="col-2 txt-guild">
      <a href="{{url('stemi_hospital')}}" class="txt-guild">
         <div>
            <i class="fa fa-hospital-o" aria-hidden="true" style="font-size: 45px;"></i>
         </div>
         <div>
            แม่ข่าย
         </div>
      </a>
   </div>

   <div class="col-2">
     <a href="{{url('patient_create')}}" class="txt-guild">
      <div class="circle">
         <i class="fa fa-plus-circle" aria-hidden="true" style="
                font-size: 90px;
                border: 0px solid #595959;
                padding: 30px;
                border-radius: 100%;
                width: 88%;
                position: absolute;
                /* top: -70px; */
                z-index: 9999;
                background: rgb(202 0 78);
                color: #fff;">
         </i>
      </div>
      <div style="    position: absolute;
      top: 43px;
      margin-left: 56px;">

   </div>
</a>
</div>


<div class="col-2 txt-guild">
 <a href="{{url('map_google')}}" class="txt-guild">
   <div>
      <i class="fa fa-map-o" aria-hidden="true" style="font-size: 45px;"></i>
   </div>
   <div>
      นำทาง
   </div>
</a>
</div>

<div class="col-2 txt-guild">
  <div id="noti_message" class="txt-time"></div>
  <a href="{{url('chat_stemi')}}" class="txt-guild">

   <div>
      <i class="fa fa-comments-o" aria-hidden="true" style="font-size: 45px;"></i>
   </div>
   <div>

      แชท
   </a>
</div>
</div>
</div>
</div>

<!--  -->

<script type="text/javascript">

   $(document).ready(function(){
 var socket = io('https://socket.stemi-global.com',{ secure: true, reconnect: true, rejectUnauthorized: false});
      $('#save_setting').click(function(){

         $.ajax({
            type  : 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url   : '{{url("save_setting")}}',
            dataType : 'json',
            data:{
               '_token': "{{ csrf_token() }}",
               mobile:$('#mobile').val(),
               status_chk:$('#status_chk').val(),
            },
            success : function(data){
              $('#setting_modal').modal('hide');
              alert('บันทึกเรียบร้อย');
           }

        });
      });

      $('#setting').click(function(){
         $.ajax({
            type  : 'get',
            url   : '{{url("get_setting")}}',
            dataType : 'json',
            success : function(data){
               // alert(data.phone);
               $('#mobile').val(data.phone);
               $('#status').html(data.status);
               $('#setting_modal').modal('show');
            }
         });
      });
      var sound = document.getElementById("myAudio");
      function playAudio() {
        sound.play();
     }
     function pauseAudio() {
        sound.pause();
     }


     $('#ekg_modal').modal({
        show: false,
        backdrop: 'static'
     });

     $("#res_modal").modal({
        show: false,
        backdrop: 'static'
     });
     $("#request").modal({
        show: false,
        backdrop: 'static'
     });
     var hos=$('#hos').val();
      // alert(hos);

      $('#send').click(function(){
         socket.emit('chat', {
            name: $('#message').val(),
            lastname: $('#message_from').val(),
            pt_id: $("#pt_id").val()

         });
      });

      // ถ้ากดรับ
      $('#res').click(function(){
         pauseAudio();
         var accept= $(this).attr('data');
         $('#accept').val(accept);
         socket.emit('res', {
            name: $('#res_message').val(),
            lastname:"แม่ข่ายรับ",
            btn:'<button>นำทาง</button>',

         });
      });

// ถ้ากดปฏิเสธ
$('#cancel').click(function(){
   pauseAudio();
   socket.emit('res', {
      name: $('#res_message').val(),
      lastname:"แม่ข่ายปฏิเสธ เนื่องจาก"+$('#reason').val(),
      btn:'<button>ตกลง</button>',
   });
});

socket.on( 'res', function(data) {
   console.log(data);
   if((data.name)==hos){
      $('#press').html(data.lastname);
      $('#res_modal').modal('show');
      $('#chat').append('<div>'+data.name+'</div>');
   }
});

socket.on('chatroom', function(data) {
   // alert(data.hos_des);
   console.log(data);
   if((data.hos_des)==hos){
    $('#hos_des').val(data.hos_us).trigger('change');
    $('#noti_message').html('มีข้อความใหม่ค่ะ');
    $('#chat_message').append('<div class="txt">'+data.hos_us_name+':'+data.message+'</div>');
 }
});

socket.on( 'chat', function(data) {
   if((data.name)==hos){

            // window.location.href="{{url('map_google')}}";
            $('#ekg').html('<a href="{{url("view_ekg")}}/'+data.pt_id+'" class="btn btn-stemi-accept">รูปผล EKG</a>');
            $('#pt_name_request').html(data.pt_name);
            $('#hos_request').html(data.hos_name);
            $('#pt_gender_request').html(data.pt_gender);
            $('#res_message').val(data.lastname);
            $('#request').modal('show');
            $('#chat').append('<div>'+data.name+'</div>');
            playAudio();
            var timeLeft = 120;
            var elem = document.getElementById('some_div');
            var timerId = setInterval(countdown, 1000);

            function countdown() {
              if (timeLeft == -1) {
                clearTimeout(timerId);
                doSomething();
             } else {

               $('#countdown').html(timeLeft);
            // timeLeft + ' seconds remaining';
            timeLeft--;
         }
      }
      function doSomething() {
        $('#countdown').html('หมดเวลา');
       // $('#accept').val('"แม่ข่ายพลาดรับ (120 วินาที)');
       socket.emit('res', {
         name: $('#res_message').val(),
         lastname: "แม่ข่ายพลาดรับ (120 วินาที)",
      });
    }
 }
});
});




</script>
