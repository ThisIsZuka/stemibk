<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        {{-- <meta content="width=device-width, initial-scale=1" name="viewport" /> --}}
        <link href="{{ asset('public') }}/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="{{ asset('public') }}/assets/css/paper-dashboard.min.css" rel="stylesheet" />
        <link href="{{ asset('public') }}/assets/css/paper-dashboard.css" rel="stylesheet" />

        {{-- โหลด font-awsome --}}
        <link href="{{ asset('public') }}/assets/fontawesome/font-awesome.css" rel="stylesheet" />
        {{-- ปิด โหลด font-awsome --}}

        {{-- font google  --}}
        <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
        {{--  ปิด font google --}}



        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="{{ asset('public') }}/assets/css/demo.css" rel="stylesheet" />

    <title>dashboard</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@100&display=swap');
    html *{
        font-family: 'Prompt', sans-serif !important;
    }
</style>
<style type="text/css">


    .navbar-light .navbar-brand {
        color: #fff;
    }

    .navbar-light .navbar-nav .nav-link {
        color: #fff;
        font-family: Kanit_ex;
    }


    /* ปุ่ม hamberge */

    #menuToggle
{
  display: block;
  position: relative;
  top: -24px;
    left: 13px;

  z-index: 1;

  -webkit-user-select: none;
  user-select: none;
}

#menuToggle a
{
  text-decoration: none;
  color: #232323;

  transition: color 0.3s ease;
}

#menuToggle a:hover
{
  color: tomato;
}


#menuToggle input
{
  display: block;
  width: 40px;
  height: 32px;
  position: absolute;
  top: -7px;
  left: -5px;

  cursor: pointer;

  opacity: 0; /* hide this */
  z-index: 2; /* and place it over the hamburger */

  -webkit-touch-callout: none;
}

/*
 * Just a quick hamburger
 */
#menuToggle span
{
  display: block;
  width: 33px;
  height: 4px;
  margin-bottom: 5px;
  position: relative;

  background: #cdcdcd;
  border-radius: 3px;

  z-index: 1;

  transform-origin: 4px 0px;

  transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
              opacity 0.55s ease;
}

#menuToggle span:first-child
{
  transform-origin: 0% 0%;
}

#menuToggle span:nth-last-child(2)
{
  transform-origin: 0% 100%;
}

/*
 * Transform all the slices of hamburger
 * into a crossmark.
 */
#menuToggle input:checked ~ span
{
  opacity: 1;
  transform: rotate(45deg) translate(-2px, -1px);
  background: #232323;
}

/*
 * But let's hide the middle one.
 */
#menuToggle input:checked ~ span:nth-last-child(3)
{
  opacity: 0;
  transform: rotate(0deg) scale(0.2, 0.2);
}

/*
 * Ohyeah and the last one should go the other direction
 */
#menuToggle input:checked ~ span:nth-last-child(2)
{
  transform: rotate(-45deg) translate(0, -1px);
}

/*
 * Make this absolute positioned
 * at the top left of the screen
 */
#menu
{
  position: absolute;
  width: 300px;
  height: 941px;
  margin: -100px 0 0 -50px;
  padding: 50px;
  padding-top: 125px;

  background: #dededef7;
  list-style-type: none;
  -webkit-font-smoothing: antialiased;
  /* to stop flickering of text in safari */

  transform-origin: 0% 0%;
  transform: translate(-100%, 0);

  transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0);
}

#menu li
{
  padding: 10px 0;
  font-size: 22px;
}

/*
 * And let's slide it in from the left
 */
#menuToggle input:checked ~ ul
{
  transform: none;
}


/* ปิด hamberge */

</style>


<style>



.step {

  padding: 10px;

  display: flex;
  flex-direction: row;
  justify-content: flex-start;

  background-color: cream;
}

.v-stepper {
  position: relative;
/*   visibility: visible; */
}


/* regular step */
.step .circle {
  background-color: white;
  border: 3px solid gray;
  border-radius: 100%;
  width: 20px;    /* +6 for border */
  height: 20px;
  display: inline-block;
}

.step .line {
    top: 23px;
  left: 12px;
  margin-top: 8px;
/*   height: 120px; */
  height: 100%;

    position: absolute;
    border-left: 3px dotted rgb(243, 33, 17);
}

.step.completed .circle {
  visibility: visible;
  background-color: rgb(6,150,215);
  border-color: rgb(6,150,215);
}

.step.completed .line {
  border-left: 3px dotted rgb(243, 33, 17);
}

.step.active .circle {
visibility: visible;
  border-color: rgb(6,150,215);
}

.step.empty .circle {
    visibility: hidden;
}

.step.empty .line {
/*     visibility: hidden; */
/*   height: 150%; */
  top: 0;
  height: 150%;
}


.step:last-child .line {
  border-left: 3px solid white;
  z-index: -1; /* behind the circle to completely hide */
}

.content {
  margin-left: 20px;
  display: inline-block;
}


/* codepen override */
html *
{
   font-size: 15px !important;
   color: #000 !important;
   font-family: Arial !important;
}
</style>

{{-- ตาราง Modal KPI --}}
<style>
    .txt_td{
        font-size: 10px !important;
    }
    .txt_th{
        font-size: 10px !important;
    }

</style>
{{-- ปิด ตาราง Modal KPI --}}


<!--    Made by Erik Terwan    -->
<!--   24th of November 2015   -->
<!--        MIT License        -->
<nav role="navigation">

  </nav>
<div class="navbar navbar-light navigation " style="background-color: #ca004e; border-radius: 0px 0px 1.5rem 1.5rem;
height: 6rem;">
    <div id="menuToggle">
        <!--
        A fake / hidden checkbox is used as click reciever,
        so you can use the :checked selector on it.
        -->
        <input type="checkbox" />

        <!--
        Some spans to act as a hamburger.

        They are acting like a real hamburger,
        not that McDonalds stuff.
        -->
        <span></span>
        <span></span>
        <span></span>

        <!--
        Too bad the menu has to be inside of the button
        but hey, it's pure CSS magic.
        -->
        <ul id="menu">
          <a href="{{url('patient')}}"><li>หน้าหลัก</li></a>
          <a href="#"><li>แม่ขาย</li></a>
          <a href="#"><li>สร้างผู้ป่วย</li></a>
          <a href="#"><li>แผนที่</li></a>
          <a href="#"><li>แชท</li></a>
        </ul>
      </div>
    <div>
        <a id="hos_host" class="navbar-brand txt-l txt-white" href="#">

        </a>
        <div>
            <a href="" id="status_hospital"></a>
            </div>
    </div>
    <div class="text-right txt-l nav-css " style="padding: 1rem;">
        <div class="txt-user">
            {{Session::get('user')->name}}
        </div>
        <div class="txt-user">
            {{Session::get('user')->hos_name}}
            {{-- {{Session::get('user')->hos_refno}} --}}
        </div>

        <input type="hidden" id="hos" value="{{Session::get('user')->us_hos_refno}}">

        {{-- <a href="{{url('logout')}}" class="btn btn-stemi"><i class="fa fa-sign-out" aria-hidden="true"></i>
            ออกจากระบบ</a> --}}
    </div>
</div>
<body>
    <div class="content" id="content_body">

    <div class="" style="">
    โรงพยาบาล 1
    <div style="padding-left:34px;">
    (ลูกข่าย) <a id="stmi_kpi" data-toggle="modal" data-target=".modal_kpi"><button class="btn btn-sm btn-success" style="font-size: 10px !important;">Stemi KPI Sumary Report</button></a>
    </div>
    <div class="container row" style="">
      <div class="card " style="-webkit-box-shadow: 5px 5px 15px -7px #5E5E5E; 
      box-shadow: 5px 5px 15px -7px #5E5E5E; padding: 2rem; border-radius: 2rem;">
        <!-- completed -->
          <div class="step completed " data-aos="fade-down" data-aos-duration="1000">
            <div class="v-stepper">
              <div class=""  ><img src="{{URL::asset('public')}}/icon/hospital.png" alt=""></div>
              <div class="line" > </div>

            </div>

            <div class="content">
                <div>
                    <i class="add_location"></i>
                </div>
                แรกรับ
                <div>

                    กรอกข้อมูลผู้ป่วยและข้อมูลที่เกี่ยวข้อง
                </div>
            </div>
        </div>
        <div style="padding-top:15px;" >5 นาที</div>

        <!-- active -->
        <div class="step completed" data-aos="fade-down" data-aos-duration="1000">
          <div class="v-stepper">
            <div class=""><img src="{{URL::asset('public')}}/icon/hospital.png" alt=""></div>
            <div class="line"></div>

          </div>

          <div class="content">
            ข้อมูล EKG

          </div>
        </div>
        <div style="padding-top:15px;">5 นาที</div>

          <!-- empty -->
        <div class="step" data-aos="fade-down" data-aos-duration="1200">
            <div class="v-stepper">
              <div class=""><img src="{{URL::asset('public')}}/icon/hospital.png" alt=""></div>
              <div class="line"></div>
            </div>
            <div class="content">
                เริ่มประสานงาน
                <div>
                    เริ่มประสานงาน
                    (ประสานงานติดต่อรับข้อมูลแม่ข่าย)
                </div>
            </div>
        </div>
        <div style="padding-top:15px;">10 นาที</div>



        <!-- regular -->
        <div class="step" data-aos="fade-down" data-aos-duration="1400">
            <div class="v-stepper">
              <div class=""><img src="{{URL::asset('public')}}/icon/hospital.png" alt=""></div>
              <div class="line"></div>
            </div>

            <div class="content">
                Y/N การส่งข้อมูล
                <div>
                    (ยืนยันการรับส่งข้อมูล/ทั้งแม่ข่ายและลูกข่าย)
                </div>
            </div>
        </div>
        <div style="padding-top:15px;">10 นาที</div>

        <div class="step" data-aos="fade-down" data-aos-duration="1500">
            <div class="v-stepper">
              <div class=""><img src="{{URL::asset('public')}}/icon/hospital.png" alt=""></div>
              <div class="line"></div>
            </div>

            <div class="content">
                เคลื่อนย้ายผู้ป่วย
                <div>
                    (เริ่มส่งผู้ป่วย/ระบบติดตามเรื่มทำงาน)
                </div>
            </div>
        </div>

        <div class="step" data-aos="fade-down" data-aos-duration="1600">
            <div class="v-stepper">
              <div class=""><img src="{{URL::asset('public')}}/icon/hospital.png" alt=""></div>
              <div class="line"></div>
            </div>

            <div class="content">
                Refer Complete
                <div>
                    (การส่งตัว/การรับผู้ป่วยสำเร็จ)
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    <div class="container">
        <div class="row">
             <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">

                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">DiDo</p>
                                    <p class="card-title">90 นาที
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> อัพเดทสถานะ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">

                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Referral Time</p>
                                    <p class="card-title">10 นาที
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> อัพเดทสถานะ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">

                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Response Time</p>
                                    <p class="card-title">40 นาที
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> อัพเดทสถานะ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">

                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Prepare Time(min)</p>
                                    <p class="card-title">9 นาที
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> อัพเดทสถานะ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">

                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Decision Time(min)</p>
                                    <p class="card-title">14 นาที
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> อัพเดทสถานะ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">

                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">EKG Time(min)</p>
                                    <p class="card-title">3 นาที
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> อัพเดทสถานะ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">

                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Tracking Time(min)</p>
                                    <p class="card-title">45 นาที
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> อัพเดทสถานะ
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- modal KPI  --}}
    <div id="modal_kpi" class="modal modal_kpi fade bd-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content container">
            <table class="table table-bordered ">
                <thead>
                  <tr>
                    STEMI KPI Summary Report

                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <th class="txt_th"  scope="col" scope="row" colspan="2">KPI</th>
                      <th class="txt_th" scope="col" scope="row">เป้า</th>
                      <th class="txt_th" scope="col" scope="row">เป้าสูงสุด</th>
                      <th class="txt_th" scope="col" scope="row">ผล</th>
                      <th class="txt_th" scope="col" scope="row">จุดตรวจวัด</th>
                  </tr>
                  <tr>
                    <td class="txt_td">1.เวลาต่อกระบวนการ(นาที)</td>
                    <td class="txt_td">DiDO</td>
                    <td class="txt_td">90</td>
                    <td class="txt_td">120</td>
                    <td class="txt_td"></td>
                    <td class="txt_td">จุดที่ 1 ถึง จุดที่ 6</td>
                  </tr>
                  <tr>
                    <td class="txt_td">2.ระยะเวลาในการประสานงาน(นาที)</td>
                    <td class="txt_td">Referral Time</td>
                    <td class="txt_td">10</td>
                    <td class="txt_td">20</td>
                    <td class="txt_td"></td>
                    <td class="txt_td">จุดที่ 1 ถึง จุดที่ 4</td>
                  </tr>
                  <tr>
                    <td class="txt_td">3.เวลาในการตอบสนอง(นาที)</td>
                    <td class="txt_td">Response Time</td>
                    <td class="txt_td">60</td>
                    <td class="txt_td">90</td>
                    <td class="txt_td"></td>
                    <td class="txt_td">จุดที่ 2 ถึง จุดที่ 6</td>
                  </tr>
                  <tr>
                    <td class="txt_td">4.เวลาเตรียมความพร้อมรับผู้ป่วย(นาที)</td>
                    <td class="txt_td">DiDO</td>
                    <td class="txt_td">10</td>
                    <td class="txt_td">20</td>
                    <td class="txt_td"></td>
                    <td class="txt_td">จุดที่ 1 ถึง จุดที่ 6 (แม่ข่าย)</td>
                  </tr>
                  <tr>
                    <td class="txt_td">5.เวลาเตรียมตอบสนองการประสานงาน(นาที)</td>
                    <td class="txt_td">DiDO</td>
                    <td class="txt_td">90</td>
                    <td class="txt_td">120</td>
                    <td class="txt_td"></td>
                    <td class="txt_td">จุดที่ 1 ถึง จุดที่ 6</td>
                  </tr>
                  <tr>
                    <td class="txt_td">6.เวลาการส่งข้อมูล(นาที)</td>
                    <td class="txt_td">DiDO</td>
                    <td class="txt_td">90</td>
                    <td class="txt_td">120</td>
                    <td class="txt_td"></td>
                    <td class="txt_td">จุดที่ 1 ถึง จุดที่ 6</td>
                  </tr>
                  <tr>
                    <td class="txt_td">7.เวลาในการเคลื่อนย้ายผู้ป่วย(นาที)</td>
                    <td class="txt_td">DiDO</td>
                    <td class="txt_td">90</td>
                    <td class="txt_td">120</td>
                    <td class="txt_td"></td>
                    <td class="txt_td">จุดที่ 1 ถึง จุดที่ 6</td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
      </div>
    {{-- modal KPI  --}}
</body>
</html>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('public') }}/assets/fontawesome-free-5.15.1-web/js/fontawesome.js"></script>
    <script src="{{ asset('public') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('public') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('public') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('public') }}/assets/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{ asset('public') }}/assets/js/chartjs.min.js"></script>
    <script src="{{ asset('public') }}/assets/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
    <script src="{{ asset('public') }}/assets/js/demo.js"></script>
    <script src="{{ asset('public') }}/assets/js/jquery.sharrre.js"></script>

    <script>
        AOS.init();
      </script>

      {{-- ส่วนของ ปุ่ม Stemi KPI --}}
        <Script>
            $('#stmi_kpi').click(function(){
                $('#modal_kpi').attr('style','padding-right:0px');
            })
        </Script>
    {{-- ส่วนของ ปุ่ม Stemi KPI --}}
@push('scripts')

    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
            demo.initChartsPages();
        });
    </script>
@endpush
