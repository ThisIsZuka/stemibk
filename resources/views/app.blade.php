<meta content="width=device-width, initial-scale=1" name="viewport" />

<link href="{{URL::asset('public/stemi_css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('public/font_kanit/stylesheet.css')}}" rel="stylesheet" />
<script src="{{url('')}}/public/stemi_js/jquery-3.4.1.min.js"></script>
<script src="{{url('')}}/public/stemi_js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/avnSkeleton/avnSkeleton.css')}}">
<script src="{{URL::asset('public/stemi_css/avnSkeleton/avnPlugin.js')}}"></script>
<script src="{{URL::asset('public/stemi_css/avnSkeleton/avnSkeleton.js')}}"></script>
<script src="{{url('public/node_modules/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>


{{-- CSS ส่วนของ nav-bottom --}}
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/menu-bottom/menu-bottom.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/mobile-small_device.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/mobile_device.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/tablet-small.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/tablet_device.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/assets/css/onoff.css')}}">

<link rel="stylesheet" href="{{URL::asset('public/assets/css/touchTouch.css')}}">
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

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #fff;
    }

    .text-modal-send{
        font-size: 20px!important;
    }



</style>
<audio id="myAudio">
    <!-- <source src="{{url('')}}/public/emergency.ogg" type="audio/ogg"> -->
    <source src="{{url('')}}/public/emergency.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<div class="modal fade " id="setting_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="txt">ตั้งค่า</div>
                <div class="txt-l">สถานะ:การเปิดรับผู้ป่วย</div>
                <div class="txt">
                    <label class="switch">
                        <input type="checkbox" id="onoff">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="txt">
                    <i class="fa fa-mobile" aria-hidden="true" style="font-size:70px;"></i> แก้ไขเบอร์โทร
                    <input type="text" class="form-control txt-l" name="mobile" id="mobile"
                        placeholder="ระบุเบอร์โทรศัพท์">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-stemi-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-md btn-stemi-accept" id="save_setting">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="res_modal">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="txt-h">ข้อความจากแม่ข่าย โรงพยาบาล</div>

                <div id="press" class="txt-h"></div>
                <button type="button" class="btn btn-stemi-accept">นำทาง</button>
                <button type="button" class="btn btn-stemi-cancel" data-dismiss="modal">ตกลง</button>
                <div id="map_canvas" style="width:100%; height:65vh;"></div>


            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .navbar-light .navbar-brand {
        color: #fff;
    }

    .navbar-light .navbar-nav .nav-link {
        color: #fff;
        font-family: Kanit_ex;
    }
</style>
<div class="navbar navbar-light nav_hader" style="background-color: #ca004e; border-radius: 0px 0px 1rem 1rem; height: 6rem;">
    <div>
        <a id="hos_host" class="navbar-brand txt-l txt-white" href="#">

        </a>
        <div>
            <a href="" id="status_hospital"></a>
            </div>
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

    <div class="text-right txt-l nav-css ">
        <div class="txt-user">
            {{Session::get('user')->name}}
        </div>
        <div class="txt-user">
            {{Session::get('user')->hos_name}}
            {{-- {{Session::get('user')->hos_refno}} --}}
        </div>

        <input type="hidden" id="hos" value="{{Session::get('user')->us_hos_refno}}">

        <a href="{{url('logout')}}" class="btn btn-stemi"><i class="fa fa-sign-out" aria-hidden="true"></i>
            ออกจากระบบ</a>
    </div>
</div>

<main class="py-1" style="margin-bottom: 200px;">
    @yield('content')
</main>

<!-- ปิดงาน -->
@include('patient.indexpatientsendingmodal')
<!-- ปิดงาน ระหว่างทาง -->
@include('patient.indexpatientsendingmodal2')
<!-- การย้อนกลับรายการ -->
@include('patient.indexreversestatus')
<!-- แจ้งเตือนกำลังเดินทาง -->
@include('patient.indexpatienttravelingmodal')
<!-- แจ้งเตือนกำลังเดินทางถึงภายใน 10 นาที -->
@include('patient.indexpatienttraveling10mmodal')
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/uikit/uikit.min.css')}}">

<div class="modal" tabindex="-1" role="dialog" id="request">
    <div class="" role="document">
        <div class="modal-content">

            <div class="modal-body col-12 row">
                <div class="col-12" style="text-align: center">
                    <div class="txt-h col-12" style="text-align: center; font-size:34px !important;">ร้องขอการส่งตัวผู้ป่วย</div>
                    <img width="100%" src="{{url('')}}/public/stemi_images/animation_640_khok2e57.gif">
                    <div class="txt-h col-12" style="font-size:35px !important; text-align:center;" id="countdown"></div>
          
                    <div class="txt-l" style="font-size:25px !important;" id="ekg"></div>
                </div>
                <div class="col-12 row">
                    <div  id="hos_request" style="font-size:25px !important;" class="col-12"></div>
                    <p class="col-12" style="font-size:25px !important;">ขอส่งผู้ป่วย</p>
                </div>
                <div class="col-12 row">
                    <p class="col-5" style="font-size:25px !important;" >ชื่อ-นามสกุล</p>
                    <div id="pt_name_request" style="font-size:25px !important; text-align:left;" class="col-7">ไม่ทราบ</div>
                   </div>
                <input type="hidden" id="patientid" name="patientid" value="" style="display: none">
                <input type="text" value="" name="pt_refno" id="pt_refno" style="display: none" >
                

                <div>
                    <input type="hidden" id="res_message">
                    <!-- <input type="text" class="form-control" id="accept"> -->
                </div>
                <br />
                <button type="button" style="display: none;" class="btn btn-stemi-accept" id="res"
                    data="กดรับตัวผู้ป่วย" >กดรับตัวผู้ป่วย</button>
                <button type="button" style="display: none;"  class="btn btn-stemi-fail" id="cancel" data="ปฏิเสธ" >ปฏิเสธ</button>
                <button type="button" style="display: none;"  class="btn btn-stemi-fail" id="close" data="ปฏิเสธ" >ปิด</button>
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
                    หน้าหลัก
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
                    <i class="fa fa-plus nav-icon" aria-hidden="true" style="">
                    </i>
                </div>
                <div style="position: absolute;top: 43px;margin-left:56px;">
                </div>
            </a>
        </div>


        <div class="col-2 txt-guild">
            <a href="{{url('dashboard')}}" class="txt-guild">
                <div>
                    <i class="fa fa-map-o" aria-hidden="true" style="font-size: 45px;"></i>
                </div>
                <div>
                    รายงาน
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
    {{-- <div class="col-2 txt-guild">
        <div id="noti_message" class="txt-time"></div>
        <a href="{{url('dashboard')}}" class="txt-guild">

            <div>
                <i class="fa fa-comments-o" aria-hidden="true" style="font-size: 45px;"></i>
            </div>
            <div>

                รายงาน
        </a>
    </div> --}}
</div>

</div>



    <div id="u_0_v" style="margin-top:30px; display:none;" class="col-xl-3 col-sm-6 col-12 ">
        <div class="lightui1 fade-in">
            <div class="lightui1-shimmer">
              <div class="_2iwr"></div>
              <div class="_2iws"></div>
              <div class="_2iwt"></div>
              <div class="_2iwu"></div>
              <div class="_2iwv"></div>
              <div class="_2iww"></div>
              <div class="_2iwx"></div>
              <div class="_2iwy"></div>
              <div class="_2iwz"></div>
              <div class="_2iw-"></div>
              <div class="_2iw_"></div>
              <div class="_2ix0"></div>
            </div>
        </div>
        <div class="lightui1 fade-in" style="margin-top:30px; display:none;">
            <div class="lightui1-shimmer">
              <div class="_2iwr"></div>
              <div class="_2iws"></div>
              <div class="_2iwt"></div>
              <div class="_2iwu"></div>
              <div class="_2iwv"></div>
              <div class="_2iww"></div>
              <div class="_2iwx"></div>
              <div class="_2iwy"></div>
              <div class="_2iwz"></div>
              <div class="_2iw-"></div>
              <div class="_2iw_"></div>
              <div class="_2ix0"></div>
            </div>
        </div>
        <div class="lightui1 fade-in" style="margin-top:30px; display:none;">
            <div class="lightui1-shimmer">
              <div class="_2iwr"></div>
              <div class="_2iws"></div>
              <div class="_2iwt"></div>
              <div class="_2iwu"></div>
              <div class="_2iwv"></div>
              <div class="_2iww"></div>
              <div class="_2iwx"></div>
              <div class="_2iwy"></div>
              <div class="_2iwz"></div>
              <div class="_2iw-"></div>
              <div class="_2iw_"></div>
              <div class="_2ix0"></div>
            </div>
        </div>
    </div>


<!--  -->
<script src="{{URL::asset('public/assets/js/touchTouch.jquery.js')}}"></script>
<script src="{{URL::asset('public/stemi_js/magnifik.js')}}"></script>


<script type="text/javascript">

    
    var audioNoti = new Audio("{{url('')}}/public/noti.mp3");
    var audioEmergency = new Audio("{{url('')}}/public/emergency.mp3");

    $(document).ready(function () {
        


        $('div').on('click','.viewimg',function(){
            $('.popupimgekg').magnifik({

// override default CSS prefix here
classPrefix: 'm-',

// override default CSS classes here
classNames: {
  // applied to the stage element
  zooming : 'zooming', 
  // applied to the close button
  close : 'close', 
  // applied to the top-level element
  control: 'magnifikControl', 
  // applied to the DIV wrapper
  canvas: 'magnifikCanvas', 
  // applied to the thumb
  thumb: 'magnifikThumb', 
  // applied to the full size image
  full: 'magnifikFull'
}

});
            
        })

        

        $("div").on('click','.ekg_view',function(){    
           
            audioEmergency.pause();
        $do = $(this).attr("data-id");
        $.ajax({
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url("ekg_view")}}',
            dataType: 'json',
            data: {
                '_token': "{{ csrf_token() }}",
                pt_id: $do,
            },
            success: function (data) {
                console.log(data.idpt)
                $("#ekg_pic").html(data.data);
                $("#modal_ekg").modal("show");
                $('#btn-cofstaff').html("<div  id-pt="+data.idpt+" style='height:7vh; margin-right:5px;     font-size: 22px !important;'  class='col col-sm-5 col-md-5 col-lg-5 btn btn-success btn-doctorconf'> ยืนยันการรับ </div> <div class='col col-sm-5 col-md-5 col-lg-5 btn btn-danger btn-doctorcancel' style='    font-size: 22px !important;'> ปฏิเสธ </div>")
            }
            })
        })
        $('div').on('click','.btn-doctorconf',function () {  
            
            $do = $(this).attr("id-pt");
            // alert($do)
            // alert('233');
            socket.emit('doctorconf',{
                ptid:$do,
                text:"เจ้าหน้าที่ Staff ยืนยันการรับเคส"
                
            })
           
            $('#modal_ekg').modal('hide');
        })
        
        $('div').on('click','.btn-doctorcancel', function(){
            $do=Array();
            $do = $(this).attr("id-pt");
            // alert($do)
            
            socket.emit('doctorcancel',{
                ptid:$do,
                text:"เจ้าหน้าที่ Staff ยืนยันการรับเคส"
                
            })
           
            $('#modal_ekg').modal('hide');
        })

        
        function loadinglistdoctor(){
            $.ajax({
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'doctor_view',
                dataType: 'json',
                success: function (data) {
                    $('#doctorview').html(data.list).fadeIn('slow')
                }
            })
        }
       

        

        var socket = io('http://www.stemibangkok.com:9900', {
            secure: true,
            reconnect: true,
            rejectUnauthorized: false
        });
        
        var hos_hostpital="{{Session::get('user')->hos_host}}"
        var user_type="{{Session::get('user')->user_type}}"

        /*alert(hos_hostpital)*/
        if(hos_hostpital==="HOST"){
            $('#hos_host').html("โรงพยาบาลแม่ข่าย");
            $('.icon_she').css('display','none');
            $('#doctorview').css('display','none');
            $('#aml').css('display','none');
        }if(hos_hostpital==="CLIENT"){
            $('#hos_host').html("โรงพยาบาลลูกข่าย")
            $('#setting').css("display","none");
            $('#status_hospital').css('display','none');
            $('#home-tab').css('display','none');
            $('#profile-tab').css('display','none');
            $('#contact-tab').css('display','none');
            $('#doctorview').css('display','none');
            $('.icon_she').css('display','block');
            $('#aml').css('display','none');
        }if(user_type==="DOCTOR"){
            $('#doctorview').css('display','block');
            $('#send-tab').html("รายการ");
            $('.nav_bottom').css('display','none');
            $('#setting').css("display","none");
            $('#status_hospital').css('display','none');
            $('#home-tab').css('display','none');
            $('#profile-tab').css('display','none');
            $('#contact-tab').css('display','none');
            $('#aml').css('display','none');
            $('#home').html();
            
            $.ajax({
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            url:'doctor_view',
            dataType: 'json',
                success: function (data) {

                    // alert(data.list);
                    $('#doctorview').html(data.list).fadeIn("slow");
                    

                }
            })
        }if(user_type==="AMBULANCE"){
            // alert("เจ้าหน้าที่รถฉุกเฉิน")
            $('#send-tab').html("รายการ")
            $('#home-tab').css('display','none');
            $('#profile-tab').css('display','none');
            $('#contact-tab').css('display','none');
            $('.nav_bottom').css('display','none');
            $('#send').html($('#u_0_v').css('display','block'))
            $('#amllist').css('display','block');
            $.ajax({
                url:'ambulan_schedule',
                post:'get',
                success: function(data){
                    $('#u_0_v').css('display','none')
                    $('#amllist').addClass('show')
                    $('#amllist').html(data)
                }
            })

        }

        
        setInterval(function(){
            $.ajax({
                url:'ambulan_schedule',
                post:'get',
                success: function(data){
                    $('#u_0_v').css('display','none')
                    $('#amllist').addClass('show')
                    $('#amllist').html(data)
                }
            })
        },5000)
    
        var hos_status = "{{(Session::get('hostpital'))}}"

        var open ="OPEN"
        if(hos_status===open){
            $('#status_hospital').html("เปิดรับผู้ป่วย");
            $('#status_hospital').css("color", "#00FF00");
            $("#onoff").attr("checked",":checked");
        }else{
            $('#status_hospital').html("ปิดรับผู้ป่วย");
            $('#status_hospital').css('color','#000000');
        }
        $("#onoff").change(function() {
            if ($(this).is(":checked")){
            $("#onoff").val("OPEN")
            $('#status_hospital').html("เปิดรับผู้ป่วย");
            $('#status_hospital').css("color", "#00FF00");
            } else {
            $("#onoff").val("CLOSE")
            $('#status_hospital').html("ปิดรับผู้ป่วย");
            $('#status_hospital').css('color','#000000');
            }
        });

        $('#save_setting').click(function (){
            var status= $("#onoff").val();
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url("save_setting")}}',
                dataType: 'json',
                data: {
                    '_token': "{{ csrf_token() }}",
                    mobile: $('#mobile').val(),
                    status_chk: status,
                },
                success: function (data) {
                    $('#setting_modal').modal('hide');
                    alert('บันทึกเรียบร้อย');

                }

            });
        });
        $('#setting').click(function () {
            $.ajax({
                type: 'get',
                url: '{{url("get_setting")}}',
                dataType: 'json',
                success: function (data) {
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
        var hos = $('#hos').val();
        // alert(hos);

        $('#send').click(function () {
            socket.emit('chat', {
                name: $('#message').val(),
                lastname: $('#message_from').val(),
                pt_id: $("#pt_id").val()

            });
        });

   

        $('#red').click(function () {
           alert($('#patientid').val());
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url("update_accept")}}',
                dataType: 'json',
                data: {
                    '_token': "{{ csrf_token() }}",
                    patient_request_id: $('#patientid').val(),
                    pt_refno:$('#pt_refno').val()

                },
                success: function (data) {
                    // $('#setting_modal').modal('hide');
                    // alert("รับตัวผู้ป่วย");
                    window.location.href = "{{url('patient')}}?tab=home-tab";
                    loadRequest();
                    $('#request').modal('hide');



                }

            });
        });


        // ถ้ากดรับ
        $('#res').click(function () {
        //    alert($('#patientid').val());
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url("update_accept")}}',
                dataType: 'json',
                data: {
                    '_token': "{{ csrf_token() }}",
                    patient_request_id: $('#patientid').val(),
                    pt_refno:$('#pt_refno').val()
                },
                success: function (data) {
                    // $('#setting_modal').modal('hide');
                    // alert("รับตัวผู้ป่วย");
                    window.location.href = "{{url('patient')}}?tab=home-tab";
                    loadRequest();
                    $('#request').modal('hide');

                }

            });
        });

        // ถ้ากดปิด
        $('#close').click(function () {
            onclickClose();
        });


        // ถ้ากดปฏิเสธ
        $('#cancel').click(function () {
            pauseAudio();

            $('#request').modal('hide');
            if($('#reason').val()==""){
                alert("กรุณาเลือกเหตุผลการปฏิเสธ");
                $('#reason').css('border-color','red');
            }else{


            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url("update_reject")}}',
                dataType: 'json',
                data: {
                    '_token': "{{ csrf_token() }}",
                    patient_request_id: $('#patientid').val(),
                    reason: $('#reason').val()
                },
                success: function (data) {
                  
                    window.location.href = "{{url('patient')}}?tab=contact-tab";
                    loadRequest();
                    $('#request').modal('hide');
                }

            });

          
            }
        });

       
        
        
  
        socket.on('chatroom', function (data) {
            // alert(data.hos_des);
            console.log(data);
            if ((data.hos_des) == hos) {
                $('#hos_des').val(data.hos_us).trigger('change');
                $('#noti_message').html('มีข้อความใหม่ค่ะ');
                $('#chat_message').append('<div class="txt">' + data.hos_us_name + ':' + data.message +
                    '</div>');
            }
        });

        var idhos=$('#hos').val();
        socket.on('notidoctor', function (data) {
            if(data.id=idhos){
                $.ajax({
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'doctor_view',
                dataType: 'json',
                success: function (data) {
                    playSound();
                    $('#doctorview').html(data.list).fadeIn("fast")
                    alert("มีเคสใหม่")
                }
            })
        }
    });

       
    });

    function loadRequest() {

        function loadingpatient(){
        $.ajax({
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:'doctor_view',
                    dataType: 'json',
                    success: function (data) {
                        $('#doctorview').html("<div class='p-section'> </div>").fadeIn("fast")
                    }
                })
        
        }
         


        var user_type="{{Session::get('user')->user_type}}"
        var interval = setInterval(function () {
           if(user_type==="DOCTOR"){
            clearInterval(interval);
           }
            // $.ajax({
            //         type: 'get',
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         url:'doctor_view',
            //         dataType: 'json',
            //         success: function (data) {
            //             $('#doctorview').html(data.list).fadeIn("fast")
            //         }
            //     })
        
       

            $.ajax({
                type: 'get',
                url: '{{url("patient_check_request")}}',
                dataType: 'json',
                data: {
                    pt_id: $('#pt_id').val(),
                },
                success: function (result) {
                    console.log(result);
                    
                    if (result.status) {
                        setTimeoutCount(false);
                        // playAudio();
                        clearInterval(interval);
                        var data = result.data[0];

                        if(result.sending_status == 1) // ส่งคำร้องขอ
                        {
                            $.ajax({
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{url("update_getsend")}}',
                            dataType: 'json',
                            data: {
                                '_token': "{{ csrf_token() }}",
                                patient_request_id: data.pt_id,
                                pt_refno:data.pt_refno
                            },
                            success: function (data) {
                                if (!data.success) {
                                    alert('เกิดข้อผิดพลาดให้การเชื่อมต่อ');
                                }
                                $('#doctor').html(data.doctor);
                                $('#doctor').val(data.iddoctor);
                                // $('#patientid').val(data.pt_id);
                                $('#hos_request').html(data.hos_namesend);
                                
                            }

                            });

                            playSound();
                            countDownTime(data.rq_timecountdown);
                            $('#patientid').val(data.pt_id);
                            $('#ekg').html('<a href="{{url("view_ekg")}}/' + data.pt_id +
                                '" class="btn btn-stemi-accept" style="font-size:25px !important;">ดูข้อมูล</a>');
                            $('#pt_name_request').html(data.pt_name);
                            $('#hos_request').html();
                            $('#pt_refno').attr('Value',data.pt_refno);
                            $('#pt_gender_request').html(data.pt_gender);
                            $('#res_message').val(data.lastname);
                            if(user_type==="DOCTOR"){
                                $('#request').modal('hidden');
                                
                                
                            }else{
                                $('#request').modal('show');
                            }
                                
                            
                          

                            // $('#select_doctor').html('<select id="doctor_view" class="form-control col-12"><option value="'+data.iddoctor+'">'+data.doctor+'</option></select>');
                        }else if(result.response_status == 6) //ปิดงานระหว่างทาง
                        {
                            playSoundNot();
                            $('#sending2_patient_name').html("ชื่อ: "+data.pt_name);
                            $('#sending2_cause').html("เนื่องจาก: "+data.cancel_message);
                            $('#sending2_hospital_name').html("ส่งจาก: "+data.hos_name);
                            $('#patientsendclosejobmodal2').modal({backdrop: 'static', keyboard: false});
                        }else if(result.response_status == 7) //ปิดงาน
                        {
                            playSoundNot();
                            $('#sending_patient_name').html("ชื่อ: "+data.pt_name);
                            $('#sending_hospital_name').html("ส่งจาก: "+data.hos_name);
                            $('#patientsendclosejobmodal').modal({backdrop: 'static', keyboard: false});
                        }else if(result.traveling_status == 3) // ย้อนสถานะ
                        {
                            playSoundNot();

                            $('#reversestatus_patient_name').html("ชื่อ: "+data.pt_name);
                            $('#reversestatus_hospital_name').html("ส่งจาก: "+data.hos_name);
                            $('#patientreversestatusclosejobmodal').modal({backdrop: 'static', keyboard: false});
                        }else if(result.traveling_status == 1) // กำลังเดินทาง
                        {
                            playSoundNot();

                            $('#patienttravelingid').val(data.pt_id);
                            $('#patienttravelingphone').val(data.hos_phone);
                            $('#patienttraveling_patient_name').html("ผู้ป่วย: "+data.pt_name);
                            $('#patienttraveling_hospital_name').html("ผู้ป่วยจาก: "+data.hos_name);
                            $('#patienttravelingmodal').modal({backdrop: 'static', keyboard: false});
                        }else if(result.traveling_status == 2) // ใกล้ถึงใน 10 นาที
                        {
                            playSoundNot();

                            $('#patienttravelingid').val(data.pt_id);
                            $('#patienttravelingphone').val(data.hos_phone);
                            $('#patienttraveling10m_patient_name').html("ผู้ป่วย: "+data.pt_name);
                            $('#patienttraveling10m_hospital_name').html("ผู้ป่วยจาก: "+data.hos_name);
                            $('#patienttraveling10mmodal').modal({backdrop: 'static', keyboard: false});
                        }

                    }

                }

            });

        }, 3000);
    }

    function playSound() {

        audioEmergency.muted = false;
        audioEmergency.allow = true;
        promise = audioEmergency.play();

        if (promise !== undefined) {
            promise.then(_ => {
                console.log("SOUND OK");
            // Autoplay started!
            }).catch(error => {
                console.log("SOUND CLOSE");

            // Autoplay was prevented.
            // Show a "Play" button so that user can start playback.
            });
        }
    }


    function playSoundNot() {

        audioNoti.currentTime = 0;
        audioNoti.muted = false;
        audioNoti.allow = true;
        promise = audioNoti.play();

        // var interval = setInterval(function () {
        //     audioNoti.pause();
        // }, 10000);

        if (promise !== undefined) {
            promise.then(_ => {
                console.log("SOUND OK");
            // Autoplay started!
            }).catch(error => {
                console.log("SOUND CLOSE");

            // Autoplay was prevented.
            // Show a "Play" button so that user can start playback.
            });
        }
    }

    function countDownTime(timecount) {
        setTimeout(function () {
          
            var time = parseInt(timecount); /* how long the timer will run (seconds) */
            var i = 1

            var interval = setInterval(function () {

                $('#countdown').text(time - i);

                if (i == time) {
                    setTimeoutCount(true);
                    clearInterval(interval);
                    
                    audioEmergency.pause();
                    audioEmergency.currentTime = 0;
                    console.log("Audio Emergency Time Out");
                    return;
                }
                i++;
            }, 1000);

        }, 0)
    }

    function onclickClose() {
        audioNoti.pause();

        loadRequest();
        $('#request').modal('hide');
        $('#patientsendclosejobmodal').modal('hide');
        $('#patientsendclosejobmodal2').modal('hide');
        $('#patientreversestatusclosejobmodal').modal('hide');
        $('#patientreversestatussendingclosejobmodal').modal('hide');
    }

    function setTimeoutCount(state = false) {

        if (state) {
            $('#countdown').text("หมดเวลา");
            $('#countdown').css("color",'red');
            document.getElementById('res').hidden = true;
            document.getElementById('cancel').hidden = true;
            document.getElementById('close').hidden = false;
        } else {
            document.getElementById('res').hidden = false;
            document.getElementById('cancel').hidden = false;
            document.getElementById('close').hidden = true;
        }
    }

    loadRequest();

    // แสดงลิสรายการส่งต่อรถแอมบูแลน
    $('.btn-stemi-shere').on('click',function(){

        $.ajax({
            url:'list_ambulance',
            type:'post',
            data:{
                '_token': "{{ csrf_token() }}",
                id_patient:$(this).attr('data'),
            },
            dataType:'json',
            success: function(data){
                $('#bodyambulance').html(data[1])
                $('#modal_ambulance').modal('show');
                
            
            }
        })

       
    })

    $('#conf_sendpt').click(function(){
        var socket = io('http://www.stemibangkok.com:9900', {
            secure: true,
            reconnect: true,
            rejectUnauthorized: false
        });
       $.ajax({
           type:'post',
           url:'sendpt_ambulance',
           data:{
            '_token': "{{ csrf_token() }}",
                idambulance:$('#selectshare').val(),
                idpt:$('#idpt').val(),
                ptrefno:$('#ptrefno').val(),
                name:$('#name').val(),
           },
           dataType:'JSON',
           success: function(data){
            console.log(data);
            socket.emit('amlsend',{
                text:"แชร์ผู้ป่วย",
                idambulance:$('#selectshare').val(),
                idpt:$('#idpt').val(),
                ptrefno:$('#ptrefno').val(),
                name:$('#name').val(),
                })
            $('#modal_ambulance').modal('hide');
            alert("การส่งต่อ"+data.name+"สำเร็จ")


           }
       })

       socket.on('amlsend',function(data){
           console.log(data)
           
        $idambulance=$('#selectshare').val();
        
        if(data.idambulance=$idambulance){
            $.ajax({
                url:'ambulan_schedule',
                post:'get',
                success: function(data){
                    $('#u_0_v').css('display','none')
                    $('#amllist').addClass('show')
                    $('#amllist').html(data)
                }
            })
            // $.ajax({
            //     url:'ambulan_schedule',
            //     type:'get',
              
            //     success: function(data){
            //         $('#u_0_v').css('display','none')
            //         $('#amllist').html(data)
            //         location.reload(true);
            //     }
            // })
        }else{

        }

       })
        
       
  

       
 

    })

</script>
