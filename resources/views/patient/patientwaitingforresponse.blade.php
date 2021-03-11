<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link href="{{URL::asset('public/stemi_css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('public/font_kanit/stylesheet.css')}}" rel="stylesheet" />
<script src="{{url('')}}/public/stemi_js/jquery-3.4.1.min.js"></script>
<script src="{{url('')}}/public/stemi_js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/font-awesome/css/font-awesome.min.css')}}">
<script src="{{url('public/node_modules/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>รอตอบรับ</title>
    <style>
        .bggreen {
            background-color: #90EE90;
            border: 1px solid lightgreen;
            border-radius: 10px;
            margin-bottom: 3px;
            padding: 3px;
        }

        .bggray {
            background-color: #fb9a9a;
            border-radius: 10px;
            margin-bottom: 3px;
            padding: 3px;
        }

        .bgoff {
            background-color: #dcdcdc;
            border-radius: 10px;
            margin-bottom: 3px;
            padding: 3px;
        }

        b {
            color: #FF4500;
        }

        /* .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
        color: #007bff !important;
        } */
        .ct {
            text-align: center;
            margin: auto;
            margin-top: 10px;
        }

        body {
            background-color: #F8F8FF;
        }

        .menu1,
        .menu2,
            {
            color: #fff !important;
        }

        .menu1:hover,
        .menu1:active,
        .menu1:visited,
        .menu1:focus {
            color: #007bff !important;

        }

        .menu1:active,
        .menu1:visited,
        .menu1:focus,
        .menu2:active,
        .menu2:visited,
        .menu2:focus {
            /*color: #fff !important;*/
            /*text-shadow: 1px 1px 4px #007bff;*/
        }

        .menu2:hover {
            color: #fff !important;
            background-color: #007bff !important;
        }

        .map {
            background-color: #fff;
        }

        .modal-body {
            text-align: center;
        }

        .ms {
            width: 98%;
            margin: 1%;
        }

        a {
            color: black;
            font-weight: bold;
        }

        .active>.menu1 {
            /*text-shadow: 1px 1px 4px #007bff;*/
        }

        small {
            font-size: 17px;
            color: #000 !important;
        }

        .item {
            /* position: relative;
            float: left; */
         }

         .item h2 {
            text-align:center;
            position: absolute;
            line-height: 125px;
            width: 95%;
         }

         svg {
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
         }

         .circle_animation {
         stroke-dasharray: 440; /* this value is the pixel circumference of the circle */
         stroke-dashoffset: 440;
         transition: all 1s linear;
         }

    </style>
</head>

<body>
    <div class="modal-body text-center">
      <input type="hidden" id="pt_id" name="pt_id" value="{!!$pt_id!!}">
        <br/>
        <div >
            <div class="item html">
               <h2 id="countdown">120</h2>
               <svg width="160" height="160" >
                  <g>
               <circle id="circle2" class="circle_animation2" r="69.85699" cy="81" cx="81" stroke-width="8" stroke="#555" fill="none"/>
               <circle id="circle" class="circle_animation" r="69.85699" cy="81" cx="81" stroke-width="8" stroke="#6fdb6f" fill="none"/>

               </g>
               </svg>
            </div>
         </div>

        <br/>
        <button type="button" class="btn btn-stemi-fail btn-lg" onclick="clickBtnCancel()" id="btn_cancel" data="ยกเลิกการขอส่งตัวผู้ป่วย">ยกเลิกการขอส่งตัวผู้ป่วย</button>
        <button type="button" class="btn btn-stemi-fail btn-lg" style="background-color: royalblue" onclick="clickBtnOK()" id="btn_ok" data="กลับหน้าหลัก">กลับหน้าหลัก</button>
        <button type="button" class="btn btn-stemi-accept btn-lg" style="background-color: royalblue"  onclick="clickBtnOK()" id="btn_ok2" data="กลับหน้าหลัก">กลับหน้าหลัก</button>
        <button type="button" class="btn btn-stemi-accept btn-lg " style="background-color: rgb(248, 126, 147)" onclick="onclickMap({!!$pt_id!!},'{ !!$data->hos_phone!! }')" id="btnPatientMap" data="นำทางไปยังโรงพยาบาล">กดเพื่อนำทาง</button>
         <div>
            <table class="table table-bordered" style="margin-top: 25px">
               <tbody>
                  <tr>
                     <td>สถานะ</td>
                     <td style="text-align: left"><div id="pt_waiting_acceptance_hospital">รอแม่ข่ายตอบกลับภายใน 120 วินาที</div></td>
                  </tr>
                  <tr>
                     <td>ร้องขอไปยัง</td>
                     <td style="text-align: left">{!!$data->hos_name!!}</td>
                  </tr>
                  <tr>
                     <td>ชื่อผู้ป่วย</td>
                     <td style="text-align: left">{!!$data->pt_name!!}</td>
                  </tr>
                  <tr>
                     <td>เพศ</td>
                     <td style="text-align: left">{!!$data->pt_gender!!}</td>
                  </tr>
               </tbody>
            </table>
            <input type="text" value="" id="pt_refno" name="pt_refno" hidden>
         </div>




    </div>

</body>
<script>

setTimeout(function() {

   var time = 120; /* how long the timer will run (seconds) */
   var initialOffset = '440';
   var i = 1

   setBtn('');

   /* Need initial run as interval hasn't yet occured... */
   $('.circle_animation').css('stroke-dashoffset', initialOffset-(1*(initialOffset/time)));
   $('.circle_animation2').css('stroke-dashoffset', 1);
   var interval = setInterval(function() {
      $('#countdown').text(time - i);
      if(i%3 == 0)
      {
         $.ajax({
                type: 'get',
                url: '{{url("patient_check_accept")}}',
                dataType: 'json',
                data: {
                  pt_id: $('#pt_id').val(),
                  rq_timecountdown: (time - i)
                },
                success: function (data) {
                  console.log(data);
                  $('#pt_refno').attr('Value',data.rq_pt_refno);
                  if(data.status)
                  {
                     if(data.responsestatus == "success")
                     {
                        $('#countdown').text("OK");
                        $('#pt_waiting_acceptance_hospital').text("ได้รับการตอบรับจากโรงพยาบาลแล้ว");

                        setBtn('ok');
                     }else if(data.responsestatus == "reject")
                     {
                        $('#countdown').text("Reject");
                        $('#pt_waiting_acceptance_hospital').text("ถูกปฏิเสธ "+((data.message != "")?("เนื่องจาก"+data.message):""));
                        setBtn('timeout');
                        var c = document.getElementById("circle");
                        c.setAttribute("stroke","#e81005");
                        var c2 = document.getElementById("circle2");
                        c2.setAttribute("stroke","#e81005");
                     }
                     clearInterval(interval);
                     return false;
                  }
                }
            });
      }


      if (i == time) {
         clearInterval(interval);
         $('#pt_waiting_acceptance_hospital').text("แม่ข่ายพลาดรับ (120 วินาที)");
         setBtn('timeout');
         var c = document.getElementById("circle");
         c.setAttribute("stroke","#e81005");
         failPost();
         return;
      }
      $('.circle_animation').css('stroke-dashoffset', initialOffset-((i+1)*(initialOffset/time)));
      i++;
   }, 1000);

   }, 0)



// อัพเดทเวลานำทาง 'Stemi_dashboard'
   $('#btnPatientMap').click(function(){
    $.ajax({
            type  : 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url   : '{{url("update_navigator")}}',
            dataType : 'json',
            data:{
               patient_request_id:$('#pt_refno').val(),
            },
            success : function(data){
              console.log("Fail : " + data);
           }

        });
   })
// ปิดอัพเดทเวลานำทาง 'Stemi_dashboard'

   function failPost()
   {
      $.ajax({
            type  : 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url   : '{{url("update_fail")}}',
            dataType : 'json',
            data:{
               patient_request_id:{!!$pt_id!!},
            },
            success : function(data){
              console.log("Fail : " + data);
           }

        });
   }

   function clickBtnCancel()
   {
      $.ajax({
            type  : 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url   : '{{url("update_cancel")}}',
            dataType : 'json',
            data:{
               patient_request_id:{!!$pt_id!!},
            },
            success : function(data){
              window.location.href = "{{url('patient')}}" ;
           }

        });

   }

   function clickBtnOK()
   {
      window.location.href = "{{url('patient')}}" ;
   }


   function setBtn(state)
   {

      if(state == "ok")
      {
         document.getElementById('btn_cancel').hidden = true;
         document.getElementById('btn_ok').hidden = true;
         document.getElementById('btn_ok2').hidden = false;
         document.getElementById('btnPatientMap').hidden = false;
      }else if(state == "timeout")
      {
         document.getElementById('btn_cancel').hidden = true;
         document.getElementById('btn_ok').hidden = false;
         document.getElementById('btn_ok2').hidden = true;
         document.getElementById('btnPatientMap').hidden = true;
      }else
      {
         document.getElementById('btn_cancel').hidden = true;
         document.getElementById('btn_ok').hidden = true;
         document.getElementById('btn_ok2').hidden = true;
         document.getElementById('btnPatientMap').hidden = true;
      }
   }

</script>

</html>
