@extends('app')
@section('content')
<!-- Generic page styles -->
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/uikit/uikit.min.css')}}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

<style>
   #navigation {
     margin: 10px 0;
  }
  .fade:not(.show) {
     opacity: 100% !important;
  }
  @media (max-width: 767px) {
     #title,
     #description {
       display: none;
    }
 }
 .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #ca004e;
    border-color: #dee2e6 #dee2e6 #fff;
 }
 a{
   color: #000;
}

</style>
<!-- blueimp Gallery styles -->
<!--<link rel="stylesheet"href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css"/>-->
<link rel="stylesheet" href="{{URL::asset('public/assets/css/blueimp-gallery.min.css')}}">
<style type="text/css">.blueimp-gallery-svgasimg>.close{}</style>

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/jquery.fileupload.css')}}" />
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/jquery.fileupload-ui.css')}}" />
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="{{URL::asset('public/stemi_css/jquery.fileupload-noscript.css')}}"/></noscript>
<noscript
><link rel="stylesheet" href="{{URL::asset('public/stemi_css/jquery.fileupload-ui-noscript.css')}}"
/></noscript>
</head>
<body>

   <div class="modal" id="ekg_modal">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
         <div class="modal-body">
            <div class="txt">อัพโหลดรูป EKG </div>
                <form id="fileupload" action="" method="POST" enctype="multipart/form-data"
            >
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript
            ><input
            type="hidden"
            name="redirect"
            value="https://blueimp.github.io/jQuery-File-Upload/"
            /></noscript>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
             <div class="col-lg-12">
               <!-- The fileinput-button span is used to style the file input field as button -->
               <span class="btn btn-stemi-accept fileinput-button">
                 <i class="fa fa-camera" aria-hidden="true"></i>
                 <span>เลือกไฟล์...</span>
                 <input type="file" name="files[]" multiple />
              </span>
              <button type="submit" class="btn btn-stemi-confirm start">
                 <i class="glyphicon glyphicon-upload"></i>
                 <span>อัพโหลดรูป(ทั้งหมด)</span>
              </button>
        <button type="button" class="btn btn-stemi-cancel delete">
           <i class="glyphicon glyphicon-trash"></i>
           <span>ลบรูป EKG ทั้งหมด</span>
        </button>
        <input type="checkbox" class="toggle" />
        <!-- The global file processing state -->
        <span class="fileupload-process"></span>
     </div>
     <!-- The global progress state -->
     <div class="col-lg-5 fileupload-progress fade">
      <!-- The global progress bar -->
      <div
      class="progress progress-striped active"
      role="progressbar"
      aria-valuemin="0"
      aria-valuemax="100"
      >
      <div
      class="progress-bar progress-bar-success"
      style="width: 0%;"
      ></div>
   </div>
   <!-- The extended global progress state -->
   <div class="progress-extended">&nbsp;</div>
</div>
</div>
<!-- The table listing the files available for upload/download -->
<div class="txt">ข้อแนะนำ</div>
<div class="txt-l">เมื่อคุณต้องการใช้งานรูปภาพให้กด อัพโหลดรูป</div>

<div role="presentation" class="table table-striped">
 <div class="files" style="text-align: center;"></div>
</div>
</form>





<div
id="blueimp-gallery"
class="blueimp-gallery blueimp-gallery-controls"
aria-label="image gallery"
aria-modal="true"
role="dialog"
data-filter=":even"
>
<div class="slides" aria-live="polite"></div>
<h3 class="title"></h3>
<a
class="prev"
aria-controls="blueimp-gallery"
aria-label="previous slide"
aria-keyshortcuts="ArrowLeft"
></a>
<a
class="next"
aria-controls="blueimp-gallery"
aria-label="next slide"
aria-keyshortcuts="ArrowRight"
></a>
<a
class="close"
aria-controls="blueimp-gallery"
aria-label="close"
aria-keyshortcuts="Escape"
></a>
<a
class="play-pause"
aria-controls="blueimp-gallery"
aria-label="play slideshow"
aria-keyshortcuts="Space"
aria-pressed="false"
role="button"
></a>
<ol class="indicator"></ol> 
</div>

<div class="text-center">
   <button type="button" class="btn btn-stemi-cancel" id="close">ยืนยัน</button>
</div>
</div>
</div>
<!-- The blueimp Gallery widget -->

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
   {% for (var i=0, file; file=o.files[i]; i++) { %}
   <tr class="template-upload fade{%=o.options.loadImageFileTypes.test(file.type)?' image':''%}">
     <td>
      <span class="preview"></span>
   </td>
   <td>
      <p class="name txt-l">{%=file.name%}</p>
      <strong class="error text-danger"></strong>
   </td>
   <td>
      <p class="size">Processing...</p>
      <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
   </td>
   <td>
      {% if (!o.options.autoUpload && o.options.edit && o.options.loadImageFileTypes.test(file.type)) { %}
      <button class="btn btn-success edit" data-index="{%=i%}" disabled>
         <i class="glyphicon glyphicon-edit"></i>
         <span>Edit</span>
      </button>
      {% } %}
      {% if (!i && !o.options.autoUpload) { %}
      <button class="btn btn-primary start col-sm-12 col-md-12 col-lg-12" disabled style="    font-style: normal;" >
        <i class="glyphicon glyphicon-upload">อัพโหลดรูป</i>
        <span>Start</span>
     </button>
     {% } %}
     {% if (!i) { %}
     <button class="btn btn-stemi-cancel cancel col-sm-12 col-md-12 col-lg-12" style="background: linear-gradient(90deg, rgba(255,0,0,1) 0%, rgba(255,67,67,1) 49%, rgba(208,6,45,1) 100%);     font-style: normal;">
        <i class="glyphicon glyphicon-ban-circle">ลบรูป</i>
        <span>Cancel</span>
     </button>
     {% } %}
  </td>
</tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
   {% for (var i=0, file; file=o.files[i]; i++) { %}
   <tr class="template-download fade{%=file.thumbnailUrl?' image':''%}">
     <td>
      <span class="preview">
       {% if (file.thumbnailUrl) { %}

       <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
       {% } %}
    </span>
 </td>
 <td>
   <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
 </p>
 {% if (file.error) { %}
 <div><span class="label label-danger">Error</span> {%=file.error%}</div>
 {% } %}
</td>
<td>
   <span class="size">{%=o.formatFileSize(file.size)%}</span>
</td>
<td>
   {% if (file.deleteUrl) { %}
   <button class="btn btn-stemi-cancel delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
     <i class="glyphicon glyphicon-trash">ลบรูปภาพ</i>
     <span>Delete</span>
  </button>
  <input type="checkbox" name="delete" value="1" class="toggle">
  {% } else { %}
  <button class="btn btn-stemi-cancel cancel">
     <i class="glyphicon glyphicon-ban-circle"></i>
     <span>Cancel</span>
  </button>
  {% } %}
</td>
</tr>
{% } %}
</script>
</div>
</div>
</div>



<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="{{URL::asset('public/stemi_js/vendor/jquery.ui.widget.js')}}"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<!--<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>-->
<script src="{{URL::asset('public/assets/js/tmpl.min.js')}}"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="{{URL::asset('public/assets/js/load-image.all.min.js')}}"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<!--<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>-->
<script src="{{URL::asset('public/assets/js/canvas-to-blob.min.js')}}"></script>
<!-- blueimp Gallery script -->
<!--<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>-->
<script src="{{URL::asset('public/assets/js/jquery.blueimp-gallery.min.js')}}"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{URL::asset('public/stemi_js/jquery.iframe-transport.js')}}"></script>
<!-- The basic File Upload plugin -->
<script src="{{URL::asset('public/stemi_js/jquery.fileupload.js')}}"></script>
<!-- The File Upload processing plugin -->
<script src="{{URL::asset('public/stemi_js/jquery.fileupload-process.js')}}"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{URL::asset('public/stemi_js/jquery.fileupload-image.js')}}"></script>
<!-- The File Upload audio preview plugin -->
<script src="{{URL::asset('public/stemi_js/jquery.fileupload-audio.js')}}"></script>
<!-- The File Upload video preview plugin -->
<script src="{{URL::asset('public/stemi_js/jquery.fileupload-video.js')}}"></script>
<!-- The File Upload validation plugin -->
<script src="{{URL::asset('public/stemi_js/jquery.fileupload-validate.js')}}"></script>
<!-- The File Upload user interface plugin -->
<script src="{{URL::asset('public/stemi_js/jquery.fileupload-ui.js')}}"></script>
<!-- The main application script -->
<script src="{{URL::asset('public/stemi_js/demo.js')}}"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
      <script src="js/cors/jquery.xdr-transport.js"></script>
   <![endif]-->



   <div class="container-fluid">
    <form id="submit">
      <link rel="stylesheet" href="{{URL::asset('public/stemi_css/croppie.min.css')}}">
      <script src="{{URL::asset('public/assets/js/croppie.js')}}"></script>
    <script src="{{URL::asset('public/assets/js/exif.js')}}"></script>
      <style type="text/css">
        .cr-boundary {
         border: 6px dashed #ccc !important;
         border-radius: 100%;
         background-color: #fafafa;
         margin-top: 10px
      }
      .croppie-container .cr-resizer, .croppie-container .cr-viewport{
         border:0px !important;
         box-shadow: 0 0 0px 0px rgba(0,0,0,.5);
      }
      .cr-slider{
         /*display: none;*/
      }
      .croppie-container{
         background-color: #fff !important;
      }
   </style>
   <div class="col-6 mx-auto">
      <div>
        <div id="upload-demo"></div>
     </div>
     <div>
      <input type="file" name="file" id="image" />
   </div>
</div>


<script type="text/javascript">
 var resize = $('#upload-demo').croppie({
  enableExif: true,
  enableOrientation: true,
  viewport: {
    width: 150,
    height: 150,
    type: 'circle'
 },
 boundary: {
   width: 150,
   height: 150,
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


<div class="txt-h">

</div>


{{-- <div class="txt">
   รหัสผู้ป่วย
</div>
<div class="input-group mb-3">
   <input type="text" class="form-control txt-l" id="hn" name="hn"  placeholder="รหัสผู้ป่วย"  aria-describedby="basic-addon2">
   <div class="input-group-append">
     <span class="input-group-text" id="basic-addon2">
      <a href="#scan"><i class="fa fa-qrcode" aria-hidden="true" style="font-size: 74px;"></i></a></span>
   </div>
</div> --}}

<div class="form-group txt">
   ชื่อ - นามสกุล*
   <input type="text"  name="pt_name" id="pt_name" class="uk-input txt-l" style='border-radius: 20px;'   placeholder="ระบุชื่อ-นามสกุล">
   <div id="name_alert" class="txt-alert"></div>
</div>




<p>
 <a class="btn btm-stemi-more" data-toggle="collapse" data-target="#collapseExample">
   <i class="fa fa-pencil" aria-hidden="true">ระบุเพิ่มเติม</i>
</a>

</p>
<div class="collapse" id="collapseExample">
 <div class="card card-body bg-light">
   <div class="row">
      <div class="form-group col-lg-4 col-12 txt">
         วัน
         <select id="date" class="uk-select txt-l" name="day">
          {!!$date!!}
       </select>
    </div>
    <div class="form-group col-lg-4 col-12 txt">
       เดือน
       <select class="uk-select txt-l-cr" id="month" name="month">
         {!!$month!!}
      </select>
   </div>
   <div class="form-group col-lg-4 col-12 txt">
     ปี ( พ.ศ. )
     <select id="year" class="uk-select txt-l" name="year" class="year" style="width: 100%;">
      {!!$year!!}
   </select>
</div>
</div>

<div class="form-group txt">
   เพศ
   <select class="uk-select txt-l" name="pt_gender" id="pt_gender" autocomplete="on">
      {!!$gender_list!!}
   </select>
   <div id="gender_alert" class="txt-alert"></div>
</div>

<div class="form-group txt">
   อายุ
   <input type="text" style='border-radius: 20px;'   name="pt_age" id="pt_age" class="uk-input txt-l  auto-save" placeholder="ระบุอายุ" autocomplete="on">
</div>

<div class="form-group txt">
   เลขบัตรประชาชน
   <input type="number" style='border-radius: 20px;'  id="pt_idcard" name="pt_idcard" class="uk-input txt-l  auto-save" placeholder="ระบุเลขบัตรประจำตัวประชาชน" autocomplete="on">
</div>


<div class="form-group txt">
  อาชีพ
  <input type="text" style='border-radius: 20px;'   name="pt_occupation" class="uk-input txt-l  auto-save" id="pt_occupation" placeholder="ระบุอาชีพ" autocomplete="on">
</div>

<div class="form-group txt">
   สิทธิการรักษา
   <select class="uk-select txt-l"  name="pt_caretype" id="pt_caretype" autocomplete="on">
      {!!$fee_list!!}
   </select>
</div>
{{-- <div class="form-group">
 <textarea class="form-control" id="texra" rows="3">
 </textarea>
</div> --}}
<div class="form-group txt">
   โรคประจำตัวผู้ป่วย
   <input type="text" style='border-radius: 20px;'   name="pt_disease" class="form-control txt-l  auto-save" id="pt_disease" placeholder="ระบุโรคประจำตัว" autocomplete="on">
</div>
</div>
</div>

<div class="">
   <div class="row">
     <div class="col-7" >
       <div class="form-group txt">
          เวลาเจ็บหน้าอก
          <input name="injury_date_d" class="uk-input datepicker_thai txt" data-date-format="mm/dd/yyyy">
       </div>
    </div>

    <div class="col-5 txt" >
      เวลา
      <input type="time"  name="injury_date_m"  class="uk-input txt">
      {{-- <!--value="{{date('H:i')}}"--> --}}
   </div>
   <div class="">
     <div class="row">
       <div class="col-7" >
          <div class="form-group txt">
           วันที่และเวลาแรกรับผู้ป่วย
           <input type="hidden" name=""  class="datenow">
           {{-- value="{{date('Y-m-d')}}" --}}
           <input name="want_date_d" class="uk-input  datepicker_thai txt" max="{{date('Y-m-d')}}" data-date-format="mm/dd/yyyy">
        </div>
     </div>
     <div class="col-5 txt" >
      เวลา
      <input type="time" name="want_date_m"
      max="{{date('H:i')}}"
      value="" class="uk-input  datehuhubm txt" id="">
      {{-- value="{{date('H:i')}}" --}}
   </div>
</div>
</div>
<div class="">
  <div class="row">
   <div class="col-7 txt">
      <div class="form-group txt">
       วันที่และเวลาทำ EKG
       <input name="pt_ekgtime_d" id="pt_ekgtime_d" class="uk-input  datepicker_thai txt" min="{{date('Y-m-d')}}" data-date-format="mm/dd/yyyy">
    </div>
 </div>
 <div class="col-5 txt">
   เวลา
   <input  type="time" name="pt_ekgtime_m" "
   value="" class="uk-input  txt">
   {{-- value="{{date('H:i')}} --}}
</div>
</div>
</div>


<div class="">
   <div class="">
     <div class="row">
        <div class="col-7" >
         <div class="form-group txt">
             {{-- วันที่และเวลากรอกข้อมูล --}}
            <input type="text" class="uk-input   txt"  value="{!!$datenow!!}"  id="sum_date"
            name="sum_date" hidden>
         </div>
      </div>
      <div class="col-5 txt" >
          {{-- เวลา --}}
         <input type="text"  value="{!!$current!!}" id="timecreate" class="uk-input  txt" hidden>
      </div>
   </div>
</div>
</div>

{{-- <div class="col-12">
   <div class="form-group txt">
     ข้อมูลการตรวจ EKG
     <textarea class="form-control txt-l" rows="3">ระบุข้อมูลการตรวจ EKG
     </textarea>
  </div>
</div> --}}
{{--
<div class="col-12 txt">
   แนปรูป EKG**
</div> --}}


<div class="col-12">
   <div class="form-group">
      <button  class="btn btn-stemi-ekg fileinput-button" type="button" id="upload_ekg">
        <i class="fa fa-camera" aria-hidden="true"></i>
        <span class="txt-cr">อัพโหลดรูป EKG...</span>
     </button>
     <input type="hidden" id="attached">
     <div id="ekg_alert" class="txt txt-alert"></div>
  </div>
</div>

<div class="col-12 text-center">
   <div id="loading">

   </div>
</div>

<div class="col-12 txt">
   <div class="form-group txt">
     โรงพยาบาลที่ส่งตัว
     <input type="text" style='border-radius: 20px;'  name="hospital" class="uk-input txt-l" disabled="disabled" id="req_hospital">
     <!-- โรงพยาบาลปลายทาง แม่ข่าย -->
     <input type="hidden" id="message" class="form-control txt-l" name="message">
     <!-- โรงพยาบาลต้นทาง ลูกข่าย หรือแม่ข่าย -->
     <input type="hidden" id="message_from" class="form-control txt-l" value="{{Session::get('user')->us_hos_refno}}">
     <input type="hidden" name="hos_refno" value="" >

  </div>
</div>

<div class="col-12 mb-4">
   <div class="form-group">
      <button id="select_hos" type="button" name="hospital"
      class="btn btn-stemi-ekg btn-block"><i class="fa fa-hospital-o" aria-hidden="true" ><div class="txt">เลือกโรงพยาบาล</div></i>
   </button>
   <div id="req_alert" class="txt txt-alert"></div>
</div>
</div>

{{-- <div class="col-12 mb-4">
 <div class="form-group">
   <button type="button" name="save_data" class="btn btn-stemi-save btn-block" id="save_data">
      <div class="txt">บันทึกข้อมูล</div>
   </button>
</div>
</div> --}}


<div class="col-12 mb-4">
 <div class="form-group">
    <button type="submit" name="btn_save" class="btn btn-send-patient btn-block" id="save_patient">
      <i class="fa fa-paper-plane" aria-hidden="true" ><div class="txt">ส่งตัวผู้ป่วย</div></i>
   </button>
</div>
</div>
<div class="col-12">
   <div class="form-group">
      <a href="{{url('')}}/patient" class="btn btn-stemi-cancel-p btn-block"><div class="txt"> ยกเลิก</div>
      </a>
   </div>
</div>

<!-- <div class="col-12">
  <div class="form-group">
   <button type="button" name="btn_saveto" value="btn_saveto" class="btn btn-success btn-block" id="save">
      บันทึกข้อมูล
   </button>
</div>
</div> -->

<!-- <button class="btn btn-stemi-confirm btn-block" style="margin-bottom:300px;">บันทึก</button> -->
</form>


<div class="modal" tabindex="-1" role="dialog" id="hospital_list">
 <div class="modal-dialog modal-full" role="document">
  <div class="modal-content">

   <div class="modal-body">
      <div class="row">
         <div class="col-6">
            <div class="txt-l">เลือกโรงพยาบาล</div>
         </div>
         <div class="col-6 text-right">
            <div class="txt">
               <i class="fa fa-arrow-circle-left txt" aria-hidden="true" data-dismiss="modal">กลับ</i>
            </div>
         </div>
      </div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="hospital_in" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><div class="txt">ในโซน</div></a>
       </li>
       <li class="nav-item">
          <a class="nav-link" id="hospital_out" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><div class="txt">นอกโซน</div></a>
       </li>

    </ul>
    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab"></div>
     <div class="tab-pane fade" id="profile"  role="tabpanel" aria-labelledby="profile-tab"></div>
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


<?php
$jquery_ui_v="1.8.5";
$theme=array("0"=>"base","1"=>"black-tie","2"=>"blitzer","3"=>"cupertino","4"=>"dark-hive","5"=>"dot-luv",
 "6"=>"eggplant", "7"=>"excite-bike","8"=>"flick","9"=>"hot-sneaks","10"=>"humanity","11"=>"le-frog",
 "12"=>"mint-choc","13"=>"overcast","14"=>"pepper-grinder","15"=>"redmond","16"=>"smoothness",
 "17"=>"south-street","18"=>"start","19"=>"sunny","20"=>"swanky-purse","21"=>"trontastic","22"=>"ui-darkness",
 "23"=>"ui-lightness","24"=>"vader");
$jquery_ui_theme=$theme[2];
?>
<link type="text/css" rel="stylesheet"
href="{{url('')}}/public/<?=$jquery_ui_v?>/themes/<?=$jquery_ui_theme?>/jquery-ui.css" />
<script src="{{URL::asset('public/stemi_js/jqueryui_datepicker_thai_min.js?1')}}"></script>
<script type="text/javascript">
   $(function(){

     $(".datepicker_thai").datepicker_thai({
        // dateFormat: 'dd-mm-yy',
        showOn: 'button',
        buttonText: "เลือกวันที่",
      buttonImage: "", // ใส่ path รุป
      buttonImageOnly: false,
      currentText: "วันนี้",
      closeText: "ปิด",
      showButtonPanel: true,
      showOn: "both",
      altField:"#h_dateinput",
      // altFormat: "yy-mm-dd",
      langTh:true,
      yearTh:true,
      numberOfMonths: 1,
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,

   });
  });
</script>


<!-- <script src="{{URL::asset('js/jquery.min.js')}}"></script> -->
<script src="{{url('public/node_modules/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>
<style type="text/css">
   .ui-widget.ui-widget-content{
      font-size: 40px;
   }
   .ui-widget-header {
    border: 1px solid #ca004e !important;
    background: #ca004e !important;
    color: #ffffff !important;
    font-weight: bold;
 }
 .ui-datepicker .ui-datepicker-title select {
  font-size: 1em;
  margin: 0 0;
  margin: 0px 0;
  font-family: Kanit_ex;
}
/* Overide css code กำหนดความกว้างของปฏิทินและอื่นๆ */
#ui-datepicker-div {display: none;}
.ui-datepicker{
 /*width:220px;*/
 font-family:Kanit_ex;
 /*font-size:12px;*/
 text-align:center;
}
/*  css กำหนดปุ่ม ถ้ามีแสดง*/
.ui-datepicker-trigger{
 border: 1px solid #cccccc;
 background: #ececec !important;
 padding:3px;
 display: none;
}
</style>
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/jquery-ui.css')}}">
<script src="{{URL::asset('public/font_kanit/jquery-ui.js')}}"></script>
<link href="{{URL::asset('public/font_kanit/select2.min.css')}}" rel="stylesheet"/>
<script src="{{URL::asset('public/font_kanit/select2.min.js')}}"></script>
<script src="{{URL::asset('public/stemi_js/uikit/uikit.min.js')}}"></script>
<script src="{{URL::asset('public')}}/stemi_js/autosave/autosaveform.js"></script>
<script>
   $(document).ready(function(){
   //  var socket = io('http://localhost:9900',{ secure: true, reconnect: true, rejectUnauthorized: false});
    
   var formsave1 =new autosaveform({
  formid:'submit',
  pause: 1000//<--no comma following last option!   
   })

    
    $('#year').select2();
    $("#send_success").modal({
       show: false,
       backdrop: 'static'
    });
    $('#year_').select2();
    $('#close').click(function(){
      var img = $('.name a').map(function(){
       return $(this).attr('title');
    }).get();
      // alert(img);
      $('#ekg_modal').modal('hide');
      var img_ekg=$('#attached').val(img);

      if($('#attached').val() =="" || $('#attached').val()==null){
         $('#upload_ekg').html('อัพโหลดรูป EKG ');
         $('#upload_ekg').removeClass('btn-stemi-accept');
         $('#upload_ekg').addClass('btn-stemi-ekg');
      }else{
         $('#upload_ekg').removeClass('btn-stemi-ekg');
         $('#upload_ekg').addClass('btn-stemi-accept');
         $('#upload_ekg').html('อัพโหลดรูป EKG แล้ว');
      }
   });

    $('#upload_ekg').click(function(){
      $('#ekg_modal').modal('show');
   });
    $('#save_data').click(function(){
      alert('xxx');
   });
    $('#pt_name').keyup(function(){
      if($('#pt_name').val() !==" " || $('#pt_name').val() !==null){
         $('#name_alert').html('');
         $('#pt_name').removeClass('border-alert');
      }
   });
    $('#pt_gender').change(function(){
      if($('#pt_gender').val() !==" " || $('#pt_gender').val() !==null){
         $('#gender_alert').html('');
         $('#pt_gender').removeClass('border-alert');
      }
   });
    $('#submit').submit(function (e) {
      e.preventDefault();
      resize.croppie('result', {
       type: 'canvas',
       size: 'viewport'
    }).then(function (img) {

      if($('#pt_name').val()==""){
            // alert('กรุณาระบุชื่อ');
            $('#pt_name').addClass('border-alert');
            $('#name_alert').html('กรุณาระบุชื่อ');
            $('#pt_name').focus();

          }
      //       else if($('#pt_gender').val()==""){
      // //    //   $('#pt_gender').addClass('border-alert');
      // //    //   $('#gender_alert').html('กรุณาระบุเพศ');
      // //    //   $('#pt_gender').focus();

      //   }
      else if($('#attached').val()==""){
         $('#upload_ekg').focus();
         $('#ekg_alert').html('แนปรูป EKG');
         $('#upload_ekg').addClass('border-alert');
            // alert('กรุณาระบุเพศ');
         }else if($('#req_hospital').val()==""){

           $('#req_alert').html('กรุณาระบุโรงพยาบาล');
        }else{


          $.ajax({
           url:'{{url("send_patient")}}',
           type: "POST",
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           dataType: 'json',
           beforeSend: function () {
            jQuery('#loading').html('<i class="fa fa-spinner fa-pulse  fa-fw" style="font-size: 120px;color:#ccc; position: absolute;z-index: 9999;" id="load"></i>');
         },
         data: {
            "image": img,
            '_token': "{{ csrf_token() }}",
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
            'attached':$('#attached').val(),
            'file':$('#image').val(),
            'hos_req':$('#message').val(),
            'date_create':$('#sum_date').val(),
            'time_create':$('#timecreate').val()
         },
         success: function (data) {
            console.log(data);
            if(data.success=true){
               $('#load').css('display','none');
               $('#send_txt').html('ส่งตัวผู้ป่วยสำเร็จ');
               $('#send_success').modal('show');
               // $('#send_success').fadeIn(500);
               setTimeout(function () {
                 $('#send_success').modal('hide');
              }, 1000);
               // $('#send_success').fadeOut(6000);
               setTimeout(function () {
               //   window.location.href = "{{url('patient')}}";
                 window.location.href = "{{url('patient_waiting_for_response?pt_id=')}}" + data.pt_id;
              }, 100);
         // $('#send_success').fadeIn(1000);
         // $('#submit')[0].reset();
         // window.location.href="{{url('patient')}}";
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
       }
    });
 });
// ฟังก์ชั่น การโหลด โรงพยาบาล ขั้นตอนเลือกโรงพยาบาลที่จะส่งผู้ป่วย
function loading_hospital(){
   jQuery('#loading').html(
                '<i class="fa fa-spinner fa-pulse  fa-fw" style="font-size: 120px;color:#ccc; position: absolute;z-index: 9999;" id="load"></i>');
      $.ajax({
         type:'get',
         url: 'loading_hos',
         dataType: 'json',
         success: function (data) {
            $('#loading').html('none')
            // $('#home').html(data.hospital_list)
            $('#home').html(data.hos);
            $('#profile').html(data.hosout);
            $(".hospital_select").on("click",function(){
            // alert("เข้า");
            var name=$(this).attr('name');
            var ref=$(this).attr('ref');
            $('#req_hospital').val(name);
            $('#message').val(ref);
            $('#hospital_list').modal('hide');
            });
         }
      })

}

$('#hospital_in').click(function(){
   loading_hospital();
})
$('#hospital_out').click(function(){
   loading_hospital();
})
 $('#select_hos').click(function(){
      jQuery('#loading').html(
                '<i class="fa fa-spinner fa-pulse  fa-fw" style="font-size: 120px;color:#ccc; position: absolute;z-index: 9999;" id="load"></i>'
                );
      $.ajax({
         type:'get',
         url: 'loading_hos',
         dataType: 'json',
         success: function (data) {
            $('#loading').html('none')
            // $('#home').html(data.hospital_list)
            $('#home').html(data.hos);
            $('#profile').html(data.hosout);
            $('#hospital_list').modal('show');
            $(".hospital_select").on("click",function(){
            // alert("เข้า");
            var name=$(this).attr('name');
            var ref=$(this).attr('ref');
            $('#req_hospital').val(name);
            $('#message').val(ref);
            $('#hospital_list').modal('hide');
            });
         }
      })

   });
function loading_hos(){
}
   //  $('.hospital').click(function(){
   //    var name=$(this).attr('name');
   //    var ref=$(this).attr('ref');
   //    $('#req_hospital').val(name);
   //    $('#message').val(ref);
   //    $('#hospital_list').modal('hide');
   // });
    $("#year").change(function(){
      var y= new Date();
      var year = y.getFullYear()+543;
      var yea = $("#year").val();
      if(yea != ""){
         $("#pt_age").val(year-yea);
      };
   });
 });

//  try {
//       webkit.messageHandlers.onCreatePatientWebIOS.postMessage("message");
//    } catch(err) {
//             console.log(err);
//    }

//  ปิด
</script>
<body>
</div>
@endsection


















