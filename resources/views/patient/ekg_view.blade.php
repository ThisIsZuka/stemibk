@extends('app')
@section('content')
<link rel="stylesheet" href="{{URL::asset('public/assets/css/touchTouch.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/assets/css/style.css')}}">
<div class="container-fluid">
   <div class="row">
         <div class="col-12 thumbs">
            {!!$ekg_pic!!}
         </div>
         <div style="font-size:28px !important;">แชร์ Staff</div>
         <div class="col-12" id="select_doctor" class="form-group" style="text-align: center;">

            <select id="doctor_view" class="form-control form-control-lg col-12" style="margin-top: 20px;">
                <option id="doctor" value="{!! $iddoctor !!}">{!! $doctor !!}</option>
            </select>
          </div>
          <div id="confdoctor" class="col-12"> 

          </div>
          <div class="col-12" style="text-align: center;  margin-top:30px; margin-bottom:30px;">
            <button id="send_doctorview" type="button" class="btn-secondary btn btn-lg col-12">ส่งต่อ EKG</button>
        </div>
        <div style="border-bottom: 1px solid rgb(204 204 204)!important; border-color: rgb(244 67 54)!important;"></div>
        <div class="col-12 row" style="text-align:center;">
            <button type="button" data="กดรับตัวผู้ป่วย" class="btn btn-stemi-accept col-6" style="background-color: green;" id="red">รับผู้ป่วย</button>
            <button type="button" class="btn btn-stemi-fail col-6" style="background-color: red;" id="cancel" data="ปฏิเสธ">ปฏิเสธ</button>
        </div>
        <div class="col-12" style="margin-top: 30px;">
         <div class="txt-h">
            เหตุผลการปฏิเสธ
         </div>
      </div>
      <div class="col-12">
         <div class="form-group">
            <select class="form-control txt-l" id="reason">
               <option value="">
                 ระบุเหตุผล
              </option>
              {{-- <option value="ไม่มีเตียง">
               ไม่มีเตียง
            </option> --}}
            <option value="มี Intra Condication">
               มี Intra Condication
            </option>
            <option value="ขอ Investigate เพิ่มเติม">
              ขอ Investigate เพิ่มเติม
           </option>
           <option value="อื่นๆ">
            อื่นๆ...
         </option>
           {{-- <option value="ไม่มีเครื่องมือ">
            ไม่มีเครื่องมือ
         </option> --}}
      </select>

      <div id="cancel_alert" class="txt-alert"></div>
      <div id="no_accept_alert" class="txt-alert txt-l"></div>
      <input type="hidden" id="res_message" value="{{$req_hos}}">

      <!--   <input type="text" value="{{$req_hos}}"> -->
   </div>
</div>

<div class="col-12 text-center">

</div>
</div>

</div>
<script src="{{URL::asset('public/assets/js/touchTouch.jquery.js')}}"></script>
<script src="{{URL::asset('public/assets/js/script.js')}}"></script>
<script>


var socket = io('http://www.stemibangkok.com:9900', {
            secure: true,
            reconnect: true,
            rejectUnauthorized: false
        });
        
        socket.on('doctorconf',function (data) {
          
            $id=$('#doctor').val()
          
            if(data.ptid=$id){
               // alert("สำเร็จ")
               $('#confdoctor').html("<div class='col-12 alert alert-success fade-in' style='margin-top: 10px;'>ยืนยันการเรียบร้อย</div> ")
               $('#send_doctorview').attr('style','display:none;')
               $('#doctor_view').css('border-color','green')
            }
         })

         socket.on('doctorcancel',function (data) {
          
          $id=$('#doctor').val()
        
          if(data.ptid=$id){
            //  alert("สำเร็จ")
             $('#confdoctor').html("<div class='col-12 alert alert-danger fade-in' style='margin-top: 10px;'>การปฏิเสธ</div> ")
             $('#send_doctorview').attr('style','display:none;')
             $('#doctor_view').css('border-color','red')
          }
         
       })


        $('#send_doctorview').click(function(){
           var iddoctor =  $('#doctor').val();
            alert("test")
           socket.emit('notidoctor', {

                        id: $('#doctor').val()

                        });
          
            $.ajax({
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'{{url("senddoctorekg")}}',
                data:{
                    '_token': "{{ csrf_token() }}",
                    iddoctor: $('#doctor').val(),
                    idpatient:$('#patientid').val()
                },
                dataType:'json',
                success: function(data){

                  $.ajax({
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:'doctor_view',
                    dataType: 'json',
                    success: function (data) {
                        $('#doctorview').html(data.list).fadeIn("fast")
                       
                        
                      
                    }
                })

                }
            });



        });

        $('#cancel').click(function(){

        })

</script>
@endsection
