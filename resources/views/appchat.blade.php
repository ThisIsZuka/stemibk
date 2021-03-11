<meta content="width=device-width, initial-scale=1" name="viewport" />

<link href="{{URL::asset('public/stemi_css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('public/font_kanit/stylesheet.css')}}" rel="stylesheet" />
<script src="{{url('')}}/public/stemi_js/jquery-3.4.1.min.js"></script>
<script src="{{url('')}}/public/stemi_js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/font-awesome/css/font-awesome.min.css')}}">
<script src="{{url('public/node_modules/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>


{{-- CSS ส่วนของ nav-bottom --}}
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/menu-bottom/menu-bottom.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/mobile-small_device.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/mobile_device.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/tablet-small.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/media-devices/tablet_device.css')}}">


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
                    <input type="checkbox" id="status_chk">เปิด/ปิด
                    <div id="status"></div>
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



<script type="text/javascript">

    var audioNoti = new Audio("{{url('')}}/public/noti.mp3");
    var audioEmergency = new Audio("{{url('')}}/public/emergency.mp3");

    $(document).ready(function () {

        var socket = io('https://socket.stemi-global.com', {
            secure: true,
            reconnect: true,
            rejectUnauthorized: false
        });
        $('#save_setting').click(function () {


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
                    status_chk: $('#status_chk').val(),
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

        // ถ้ากดรับ
        $('#res').click(function () {

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
                },
                success: function (data) {
                    // $('#setting_modal').modal('hide');

                    alert('รับตัวเรียบร้อย');
                    pauseAudio();
                    socket.emit('res', {
                        name: $('#res_message').val(),
                        lastname: "แม่ข่ายรับตัวผู้ป่วยแล้ว",
                        btn: '<button>นำทาง</button>',
                    });
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
                    // $('#setting_modal').modal('hide');

                    // alert('รับตัวเรียบร้อย');
                    // pauseAudio();
                    // socket.emit('res', {
                    //     name: $('#res_message').val(),
                    //     lastname: "แม่ข่ายรับตัวผู้ป่วยแล้ว",
                    //     btn: '<button>นำทาง</button>',
                    // });
                    window.location.href = "{{url('patient')}}?tab=contact-tab";
                    loadRequest();
                    $('#request').modal('hide');
                }

            });

            // socket.emit('res', {
            //     name: $('#res_message').val(),
            //     lastname: "แม่ข่ายปฏิเสธ เนื่องจาก" + $('#reason').val(),
            //     btn: '<button>ตกลง</button>',
            // });



        });

        /*
        socket.on('res', function (data) {
            console.log(data);
            if ((data.name) == hos) {

               initializechage('0','0');
                $('#press').html(data.lastname);
                $('#res_modal').modal('show');
                $('#chat').append('<div>' + data.name + '</div>');

                getLocation();
                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(savePosition, positionError, {
                            timeout: 10000
                        });
                    } else {
                        //Geolocation is not supported by this browser
                    }

                }

                function setTimeoutgetLocation() {
                    console.log("test");
                    setTimeout(function () {

                        getLocation();
                        setTimeoutgetLocation();

                    }, 1000 * 5);
                }

                // handle the error here
                function positionError(error) {
                    var errorCode = error.code;
                    var message = error.message;

                  //   alert(message);
                }

                function savePosition(position) {


                    initializechage2(position.coords.latitude,position.coords.longitude);

                    console.log("lat : " + position.coords.latitude);
                    console.log("lng : " + position.coords.longitude);
                    // $("#lat").val(position.coords.latitude);
                    // $("#lng").val(position.coords.longitude);

                    // $.post("geocoordinates.php", {lat: position.coords.latitude, lng: position.coords.longitude});
                }

                setTimeoutgetLocation();

            }
        });

        */

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

        /*
        socket.on('chat', function (data) {
            console.log("==========");
            console.log(data);
            if ((data.name) == hos) {

                $('#patientid').val(data.pt_id);
                $('#ekg').html('<a href="{{url("view_ekg")}}/' + data.pt_id +
                    '" class="btn btn-stemi-accept">รูปผล EKG</a>');
                $('#pt_name_request').html(data.pt_name);
                $('#hos_request').html(data.hos_name);
                $('#pt_gender_request').html(data.pt_gender);
                $('#res_message').val(data.lastname);
                $('#request').modal('show');
                $('#chat').append('<div>' + data.name + '</div>');
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
                        pt_id: data.pt_id
                    });
                }
            }
        });
        */
    });

    


    function loadRequest() {
        var interval = setInterval(function () {

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
                            },
                            success: function (data) {

                                if (!data.success) {
                                    alert('เกิดข้อผิดพลาดให้การเชื่อมต่อ');
                                }

                            }

                            });

                            playSound();
                            countDownTime(data.rq_timecountdown);
                            $('#patientid').val(data.pt_id);
                            $('#ekg').html('<a href="{{url("view_ekg")}}/' + data.pt_id +
                                '" class="btn btn-stemi-accept">รูปผล EKG</a>');
                            $('#pt_name_request').html(data.pt_name);
                            $('#hos_request').html(data.hos_name);
                            $('#pt_gender_request').html(data.pt_gender);
                            $('#res_message').val(data.lastname);
                            $('#request').modal('show');
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

        }, 5000);
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

</script>
