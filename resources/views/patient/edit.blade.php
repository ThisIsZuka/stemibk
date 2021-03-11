@extends('app')
@section('content')

<link rel="stylesheet" href="{{URL::asset('public/stemi_css/uikit/uikit.min.css')}}">
<div class="container-fluid">
 <form id="submit">
    
  <link rel="stylesheet" href="{{URL::asset('public/stemi_css/croppie.min.css')}}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exif-js/2.3.0/exif.js"></script>
  <style type="text/css">
   .cr-boundary {
      border: 1px dashed #ccc !important;
      border-radius: 100%;

   }
   .croppie-container .cr-resizer, .croppie-container .cr-viewport{
      border:0px !important;
      box-shadow: 0 0 0px 0px rgba(0,0,0,.5);
   }
   .cr-slider{
      display: none;
   }
   .croppie-container{
      background-color: #fff !important;
   }

</style>

<style type="text/css">
		
		/* css กำหนดความกว้าง ความสูงของแผนที่ */
		#map_canvas { 
			width:550px;
			height:400px;
			margin:auto;
			margin-top:50px;
		}
		</style>




<div id="upload-demo"></div>
<input type="file" name="file" id="image"  />
<script type="text/javascript">
 var resize = $('#upload-demo').croppie({
  enableExif: true,
  enableOrientation: true,
  viewport: { 
    width: 100,
    height: 100,
    type: 'circle' 
 },
 boundary: {
   width: 100,
   height: 100
}
});
 $('#image').on('change', function () {
  var reader = new FileReader();
  reader.onload = function (e) {
   resize.croppie('bind', {
    url: e.target.result
 }).then(function () {
    console.log('onload images');
 });
}
reader.readAsDataURL(this.files[0]);
});

</script>
<div class="txt-h" style="margin-top:5vh;">
   ข้อมูลผู้ป่วย
</div>

{{-- <div class="txt">
   รหัสผู้ป่วย
</div>
<div class="input-group mb-3">
   <input type="text" class="form-control txt" id="hn" name="hn"  placeholder="รหัสผู้ป่วย"  aria-describedby="basic-addon2">
   <div class="input-group-append">
     <span class="input-group-text" id="basic-addon2">
      <a href="#scan"><i class="fa fa-qrcode" aria-hidden="true" style="font-size: 74px;"></i></a></span>
   </div>
   <!-- <div class="input-group-append">
     <span class="input-group-text" id="basic-addon2"><a href="#scan"><i class="fas fa-qrcode fa-2x" ></i></a></span>
   </div> -->
</div> --}}

<div class="form-group txt" style="margin-top:2vh;">
   ชื่อ - นามสกุล
   <div style="margin-top:2vh;">
   <input type="text" style="border-radius:20px;"  name="pt_name" id="pt_name" class="form-control txt-l" placeholder="ระบุชื่อ-นามสกุล" value="{{$patient->pt_name}}">
   </div>
</div>

<p>
   <a class="btn btm-stemi-more" data-toggle="collapse" data-target="#collapseExample">
     <i class="fa fa-pencil" aria-hidden="true"> ข้อมูล</i>
  </a>

<div class="collapse" id="collapseExample">
   <div class="col-12">
      <div class="row">
         <div class="col-7" >
            <div class="form-group txt">
               วันที่และเวลาแรกรับผู้ป่วย
               <input type="hidden" name="" value="{{date('Y-m-d')}}" class="datenow">
               <input name="want_date_d" class="form-control datepicker txt" max="{{date('Y-m-d')}}" data-date-format="mm/dd/yyyy">
            </div>
         </div>
         <div class="col-5 txt" >
            เวลา
            <input type="time" name="want_date_m" value="{{date('H:i')}}"
            max="{{date('H:i')}}"
            value="" class="form-control datehuhubm txt" id="">
         </div>
      </div>
   </div>
   <div class="col-12">
   <div class="row">
      <div class="col-7 txt">
      วันที่และเวลาทำ EKG
      <input name="pt_ekgtime_d" id="pt_ekgtime_d" class="form-control datepicker txt" min="{{date('Y-m-d')}}" data-date-format="mm/dd/yyyy">
   </div>
   <div class="col-5 txt">
      เวลา
      <input type="time" name="pt_ekgtime_m" value="{{date('H:i')}}"
      value="" class="form-control txt">
   </div>
   </div>
   </div>


         <div class="col-12">
            <div class="form-group txt">
            วันที่และเวลากรอกข้อมูล
            <div class="row">
               <div class="col-7" >
                  <input type="text" class="form-control txt-l datepicker"  id="sum_date"
                  name="sum_date" value="">
               </div>
               <div class="col-5" >
                  <input type="text" class="form-control txt-l" >
               </div>
            </div>
         </div>
         </div>

   
</div>
              
               {{-- <div class="col-5 txt" >
                  เวลา
                  <input type="time"  name="injury_date_m" value="{{date('H:i')}}" class="form-control txt">
               </div> --}}
              
{{-- <div class="col-12">
   <div class="form-group txt">
     ข้อมูลการตรวจ EKG
     <textarea class="form-control txt-l" rows="3">ระบุข้อมูลการตรวจ EKG
     </textarea>
  </div>
</div> --}}

<div class="col-12 txt">
  EKG
</div>
<div class="col-12">
   {!!$ekg_list!!}
</div>

{{-- <div class="col-12">
   <div class="form-group">
      <button  class="btn btn-stemi-ekg fileinput-button" type="button" id="upload_ekg">
       <i class="fa fa-camera" aria-hidden="true"></i>
       <span>อัพโหลดรูป EKG...</span>
    </button>
    <input type="text" id="attached">
 </div>
</div> --}}




<div class="col-12 txt" style="margin-top:5vh;">
   <div class="form-group">
     โรงพยาบาลที่ส่งตัว
     <input type="text" style="border-radius:20px;" name="hospital" class="form-control txt" disabled="disabled" id="req_hospital">
     <!-- โรงพยาบาลปลายทาง แม่ข่าย -->
     <input type="hidden" id="message" class="form-control txt-l">
     <!-- โรงพยาบาลต้นทาง ลูกข่าย หรือแม่ข่าย -->
     <input type="hidden" id="message_from" class="form-control txt-l" value="{{Session::get('user')->us_hos_refno}}">
     <input type="hidden" name="hos_refno" value="" >
  </div>
</div>

<div class="col-12 mb-4">
   <div class="form-group">
      <button id="select_hos" style="padding:0px !important; background-color: #ca004e !important; " type="button" name="hospital"
      class="btn btn-stemi-hospital btn-block"> <p style="font-size:15px; margin:10px !important;">เลือกโรงพยาบาล</p>
   </button>
</div>
</div>


<div class="col-12">
 <div class="form-group">

    <!-- <button id="send">send</button> -->

    <button type="submit" name="btn_save" class="btn btn-send-patient btn-block" style="border-radius:20px; padding: 0px !important;" id="send">
       <p style="font-size:15px; margin:10px !important;">ส่งตัวอีกครั้ง</p>
   </button>
</div>
</div>
<div class="col-12">
   <div class="form-group">
      <a style="border-radius: 20px;" href="{{url('')}}/patient" class="btn btn-stemi-cancel btn-block">ยกเลิก
      </a>
   </div>
</div>
</form>





<div class="modal" tabindex="-1" role="dialog" id="hospital_list">
 <div class="modal-dialog modal-full" role="document">
  <div class="modal-content">

   <div class="modal-body">
<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด POP UP</button>
      {{-- <div class="txt-l">โรงพยาบาล</div> --}}

      <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item">
           <a class="nav-link active" id="hospital_in" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><div class="txt">ในโซน</div></a>
        </li>
        <li class="nav-item">
           <a class="nav-link" id="hospital_out" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><div class="txt">นอกโซน</div></a>
        </li>
 
     </ul>
  <div class="tab-content" id="myTabContent" style="margin-top: 12px;">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  
       <div class="row">
         <div class="col-lg-12 col-12">
            <!-- <img src="{{url('')}}/images/hot1.png" class="img-fluid"> -->
            {!!$hospital_list!!}
         </div>
      </div>
   </div>
   <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      {!!$out_zone_hospital_list!!}
   </div>
   
</div>



</div>

</div>
</div>
</div>

<div class="modal" id="send_success">
   <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
         <div id="send_txt" class="txt-l"></div>
         <!-- <button type="button" class="btn btn-stemi-accept" data-dismiss="modal">ตกลง</button> -->
      </div>

   </div>
</div>
</div>
</div>
</div>
<script src="{{url('public/node_modules/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="{{URL::asset('public/font_kanit/jquery-ui.js')}}"></script>
<link href="{{URL::asset('public/font_kanit/select2.min.css')}}" rel="stylesheet" />
<script src="{{URL::asset('public/font_kanit/select2.min.js')}}"></script>
<script>
   $(document).ready(function(){
    $('#year_').select2();


    $('#select_hos').click(function(){
      $('#hospital_list').modal('show');
   });

    $('.hospital').click(function(){
      var name=$(this).attr('name');
      var ref=$(this).attr('ref');
      $('#req_hospital').val(name);
      $('#message').val(ref);
      $('#hospital_list').modal('hide');
   });


    $('#submit').submit(function (e) {
      e.preventDefault();
      resize.croppie('result', {
       type: 'canvas',
       size: 'viewport'
    }).then(function (img) {
       $.ajax({
        url:'{{url("update_patient")}}',
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        data: {
         "image": img,
         '_token': "{{ csrf_token() }}",
         'patient_request_id':{!!$pt_id!!},
         'pt_hn':$('#pt_hn').val(),
         'pt_name':$('#pt_name').val(),
         'pt_idcard':$('#pt_idcard').val(),
         'date':$('#date').val(),
         'month':$('#month').val(),
         'year':$('#year').val(),
         'pt_caretype':$('#pt_caretype').val(),
         'pt_age':$('#pt_age').val(),
         'pt_gender':$('#pt_gender').val(),
         'pt_occupation':$('#pt_occupation').val(),
         'pt_disease':$('#pt_disease').val(),
         'rq_response_status': ''
      },

      success: function (data) {

       if(data.success=true){
         // alert('xxxx');
       
         $('#send_success').modal('show');
         $('#send_txt').html('ส่งตัวผู้ป่วยสำเร็จ');
         setTimeout(function () {
            window.location.href = "{{url('patient_waiting_for_response?pt_id=')}}" + {!!$pt_id!!};
         //  $('#send_success').modal('hide');
       }, 1000);

        
         $('#submit')[0].reset();

         socket.emit('chat', { 
            name: $('#message').val(),
            lastname: $('#message_from').val(),
            pt_name:data.pt_name,
            pt_id:data.pt_id,
            hos_name:data.hos_name,
            pt_gender:data.pt_gender,
         });
      }
   }
});
    });
 });
    $("#year").change(function(){
      var yea = $("#year").val();

      var d = new Date();
      var n = d.getFullYear()+543;

      if(yea != ""){
         $("#pt_age").val(n-yea);
      };
   });
 });
</script>
</body>
</html>


@endsection



















