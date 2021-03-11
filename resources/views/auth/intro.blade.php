<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ยินดีต้อนรับเข้าสู่ Stemi Bangkok+</title>
    <link href="{{URL::asset('public/font_kanit/stylesheet.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="public/stemi_css/bootstrap.css">
<link rel="stylesheet" href="public/stemi_css/intro/animationintro.css">
</head>
<body class=" bg-pan-left" style="background-color: rgb(255, 255, 255); height:100vh; font-family:kanit;">
    <div class="container" style="padding:10px;">
        <div class="container">
            <div class="row">
                <div class="col-12" style="text-align: center; margin-top: 30px;">
                    <img style="width:300px;"  class="bounceIn"   src='{{url("/")}}/public/stemi_images/logo.png'>
                </div>
                <div class="col-12" style=" text-align: center; margin-top: 30px;">
                    <a href="login">
                   <button type="button"  class="col-11 btn btn-light btn-lg fadeInUpBig " style="color: rgb(240 248 255); border-radius: 50px; font-size: 28px;   box-shadow: 0px 0px 17px 5px #e91e6336;   background: linear-gradient(149deg, rgb(45 75 245) 0%, rgb(239 43 151) 50%, rgb(247 3 97) 73%);
                ">เข้าสู่ระบบ</button>
                </a>
                </div>
                <div class="col-12 fadeInUpBig"  style="margin-top: 20px ">
                    <div class="col-12" style="text-align: center; font-size: 18px;">
                      <a href="register" style="font-weight: 300px">Register</a>
                      {{-- /<a href="">Forget Password</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="public/stemi_js/bootstrap.js"></script>
