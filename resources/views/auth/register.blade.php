<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ยินดีต้อนรับเข้าสู่ Stemi Bangkok+</title>
    <link href="{{URL::asset('public/font_kanit/stylesheet.css')}}" rel="stylesheet" />
    <script src="{{url('')}}/public/stemi_js/jquery-3.4.1.min.js"></script>
<link rel="stylesheet" href="public/stemi_css/bootstrap.css">
<link rel="stylesheet" href="public/stemi_css/intro/animationintro.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body class=" bg-pan-left" style="background-color: rgb(255, 255, 255); height:100vh; font-family:kanit;">
    <div class="container" style="padding:10px;">
        <div class="container">
            <div class="row">
                <div class="col-12" style="text-align: center; margin-top: 30px;">
                    <img style="width:100px;"  class="bounceIn"   src='{{url("/")}}/public/stemi_images/logo.png'>
                </div>
                <div class="col-12" style=" text-align: center; margin-top: 30px;">
                    {{-- <a href="login">
                   <button type="button"  class="col-11 btn btn-light btn-lg fadeInUpBig " style="color: rgb(240 248 255); border-radius: 50px; font-size: 28px;   box-shadow: 0px 0px 17px 5px #e91e6336;   background: linear-gradient(149deg, rgb(45 75 245) 0%, rgb(239 43 151) 50%, rgb(247 3 97) 73%);
                ">เข้าสู่ระบบ</button>
                </a> --}}
                <h1>ลงทะเบียน</h1>
                </div>
                <div class="col-12 fadeInUpBig"  style="margin-top: 20px ">
                    <div class="col-12" style=" font-size: 18px;">
                        <h5>ชื่อผู้ใช้งาน</h5>
                        <span style="font-size:10px;">ชื่อโรงพยาบาล</span>
                        <input class="col-12 form-control" type="text" name="" id="username" >
                        รหัสผ่าน
                        <input class="col-12 form-control" type="text" name="" id="pass" >
                        สถานะชื่อผู้ใช้งาน
                        <input class="col-12 form-control" type="text" name="" id="Position" >
                        เบอร์โทร
                        <input class="col-12 form-control" type="text" name="" id="tel" >
                        Email
                        <input class="col-12 form-control" type="text" name="" id="email" >
                        <div class="col-12" style="margin-top: 30px">

                        <button id="register" type="button"  class="col-11 btn btn-light btn-lg fadeInUpBig " style="color: rgb(240 248 255); border-radius: 50px; font-size: 28px;   box-shadow: 0px 0px 17px 5px #e91e6336;   background: linear-gradient(149deg, rgb(45 75 245) 0%, rgb(239 43 151) 50%, rgb(247 3 97) 73%);
                        ">ลงทะเบียน</button>

                        </div>

                    </div>
                    <div class="col-12 " style="margin-top: 50px ">
                        <a  onclick="history.go(-1)">
                            <h5 style="text-align: center; color:blue;">กลับหนัาหลัก</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast col-11" style="position: absolute;top: 4%; left: 3%; width: 100%;" id="toast" role="alert" aria-live="assertive" aria-atomic="true" >
        <div class="toast-header">
          <img src="http://localhost/stemibk2/stemibk_production/public/stemi_images/logo.png" style="width:20px;" class="rounded mr-2" alt="...">
          <strong class="mr-auto">Stemi Bangkok</strong>
          <small class="text-muted">ตอนนี้</small>
          <button id="btn-ok" type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          การสมัครสำเร็จกรุณารอการตอบกลับทาง Email
        </div>
      </div>

</body>
</html>
<!--  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous"></script>
<script src="public/stemi_js/bootstrap.js"></script>
<script>
    $(document).ready(function(){
        $('#register').click(function(){
            if($('#email').val()===""){
                $('#email').css('border-color','red')
            }else{
                $.ajax({
                    url:'regisuser',
                    type:'get',
                    dataType:'JSON',
                    success:function(data){
                        if(data.data==="success"){
                            $("#toast").toast({
                                autohide: false,
                            });
                            $('#toast').toast('show')
                        }else{
                            alert("ไม่สำเร็จ")
                        }
                        $('#btn-ok').click(function(){
                            window.location.replace('{{URL('login')}}')
                        })

                    }
                })
            }
        })
    })
</script>
