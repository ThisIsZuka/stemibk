@extends('app')
@section('content')
 {{--  CSS --}}
<link rel="stylesheet" href="{{URL::asset('public/stemi_css/chat/chat.css')}}">
 {{--  script --}}

<title>Chat</title>
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="txt">

                </div>
                <div class="form-group" >
                    <select id="hos_des" name="hos_us" class="txt-l" class="form-control">
                        {!!$hospital_chat!!}
                    </select>
                </div>

                <div class="txt-l">

                </div>
                <div class="inbox-chat messages-chat chat">
                    <div class="col-12 ">
                        <div id="chat_message" class="txt-time">

                        </div>
                    </div>
                </div>
                <div class="form-group" >
                    <input type="hidden" name="hos_us_name" id="hos_us_name" value="{{Session::get('user')->hos_name}}">
                    <input type="hidden" name="hos_us" id="hos_us" value="{{Session::get('user')->hos_refno}}">
                </div>
                <div  class="input-group input-chatbox ">
                        <textarea rows="2" class="form-control txt-l" name="message" id="message" placeholder="Aa"></textarea>
                        <span class="input-group-append">
                            <button class="btn btn-info btn-stemi-chat btn-block " id="start_chat" style="font-size: 45px"></i> ส่งข้อความ</button>
                        </span>
                </div>
                {{--/ col-12 --}}
            </div>
            {{-- /row --}}
        </div>
    {{-- / container fulid --}}
</div>





<script type="text/javascript">
   $(document).ready(function(){
  var socket = io('https://socket.stemi-global.com',{ secure: true, reconnect: true, rejectUnauthorized: false});
      $('#start_chat').click(function(){
         if($('#hos_des').val()==""){
            alert('เลือกโรงพยาบาล Chat ค่ะ');

         }else if($('#message').val()==""){
            alert('กรอกข้อความ chat');

         }else{
        var hos_des=$('#hos_des').val();
         // alert(hos_des);
         var us=$('#hos_us_name').val();
         var message=$('#message').val();
         var objDiv = $(".inbox-chat");
    	 var h = objDiv.get(0).scrollHeight;
    	 objDiv.animate({scrollTop: h});
         $('#chat_message').append('<div class="user-chat text-right">'+us+'<br>'+'<div class="message">'+message+'</div>'+'</div>');
       


         socket.emit('chatroom',{
            hos_us: $('#hos_us').val(),
            hos_us_name:$('#hos_us_name').val(),
            hos_des:hos_des,
            message:$('#message').val(),

         });
      }




   });

   });
</script>

@endsection
