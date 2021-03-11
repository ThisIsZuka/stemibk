
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Stemi Bangkok</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link href="{{URL::asset('public/stemi_css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{URL::asset('public/font_kanit/stylesheet.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{URL::asset('public/assets/css/touchTouch.css')}}">
</head>
<body>
   <div class="container" style="margin-top: 35px;">
    <div class="row">
      <div class="col-lg-3 col-sm-12 col-xs-12 mx-auto">
        <div class="text-center txt-l">
         <img  src='{{url("/")}}/public/stemi_images/logo.png' style="width: 50%;">
         <div>
            Version 3.0
         </div>
      </div>
      <div>
         <form method="POST" action="{{url('check_login')}}" >
            @csrf
            <div class="input-icon form-group txt-l">
               ชื่อผู้ใช้งาน
               <i class="fas fa-user"></i>
               <input id="email" type="text" class="form-control frm-login" name="username" value="" placeholder="Username">
               <div id="email_alert" class="txt-mi"></div>
            </div>
            <div class="form-group txt-l">
               รหัสผ่าน
               <i class="fas fa-lock"></i>
               <input type="password" id="password" class="form-control frm-login" placeholder="Password" name="password" >
               <div id="password_alert" class="txt-mi"></div>
            </div>
            <div id="txt_res" class="txt-mi"></div>
            <div class="form-group" style="    padding: 18px;
            padding-left: 80px;">
               <button class="btn col-9 btn-stemi btn-lg  btn-block" id="login" type="button">
                  Login
               </button>


            </div>
         </form>
      </div>
   </div>
</div>
</body>
</html>
<script src="{{URL::asset('public/stemi_js/uikit/uikit.min.js')}}"></script>
<script src="{{url('public/stemi_js/jquery-3.4.1.min.js')}}"></script>
<script src="{{url('public/stemi_js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready(function(){

    $.fn.enterKey = function(fnc) {
     return this.each(function() {
       $(this).keypress(function(ev) {
         var keycode = (ev.keyCode ? ev.keyCode : ev.which);
         if (keycode == '13') {
           fnc.call(this, ev);
        }
     })
    })
  }

  $('#email,#password').enterKey(function() {
     if($('#email').val()=="" && $('#password').val()==""){
        $('#email_alert').html('กรุณาระบุ Username');
        $('#password_alert').html('กรุณาระบุ Password');

     }else if($('#email').val()==""){
      $('#email_alert').html('กรุณาระบุ Username');
   }else if($('#password').val()==""){
      $('#password_alert').html('กรุณาระบุ Password');
   }else{
     $.ajax({
      url:'{{url("check_login")}}',
      type: "POST",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      dataType: 'json',
      data: {
       '_token': "{{ csrf_token() }}",
       'username':$('#email').val(),
       'password':$('#password').val(),
    },
    success: function (data) {
      $('#txt_res').html(data.message);
      if(data.success==true){
         window.location.href="{{url('patient')}}";
      }else if(data.success==false){
      }

   }
});
  }
})



  $('#login').click(function(){

   if($('#email').val()=="" && $('#password').val()==""){
     $('#email_alert').html('กรุณาระบุ Username');
     $('#password_alert').html('กรุณาระบุ Password');

  }else if($('#email').val()==""){
   $('#email_alert').html('กรุณาระบุ Username');
}else if($('#password').val()==""){
   $('#password_alert').html('กรุณาระบุ Password');
}else{
  $.ajax({
   url:'{{url("check_login")}}',
   type: "POST",
   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
   dataType: 'json',
   data: {
    '_token': "{{ csrf_token() }}",
    'username':$('#email').val(),
    'password':$('#password').val(),
 },
 success: function (data) {
   $('#txt_res').html(data.message);
   if(data.success==true){
      window.location.href="{{url('patient')}}";
   }else if(data.success==false){
   }

}
});
}
})
});
</script>
