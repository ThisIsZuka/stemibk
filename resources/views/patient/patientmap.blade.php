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

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3zpp0cTi5Sn-8FUG7fUvUDC5NSTW08Ao&callback=initMap&libraries=&v=weekly"  defer></script>
    </script>
    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 96%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #floating-panel {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            /* background-color: #fff; */
            padding: 3px;
            /* border: 1px solid #999; */
            text-align: center;
            font-family: "Roboto", "sans-serif";
            line-height: 30px;
            padding-left: 10px;
        }

        
        #floating-panel-left-floor {
            position: absolute;
            bottom: 0px;
            left: 0px;
            z-index: 5;
            /* background-color: #fff; */
            padding: 3px;
            /* border: 1px solid #999; */
            text-align: center;
            font-family: "Roboto", "sans-serif";
            line-height: 30px;
            padding-left: 5px;
        }

        #floating-panel-right {
            position: absolute;
            top: 0px;
            right: 10px;
            z-index: 5;
            /* background-color: #fff; */
            padding: 5px;
            /* border: 1px solid #999; */
            text-align: center;
            font-family: "Roboto", "sans-serif";
            line-height: 30px;
            padding-left: 10px;
        }

        #divHeader
        {
            background-color: #238ae6 !important ;
        }

        #action-back
        {
            background-color: #238ae6 !important ;
            color: #FFF !important ;
        }

        .action-btn
        {
            color: #FFF !important ;
            background-color: #337ab7 !important ;
            border-radius: 25px;
        }


    </style>
    <script>

            $(document).ready(function(){

                console.log("============== Test Map =================");
                if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(function (position)
               {
                  lat = position.coords.latitude ;
                  lng = position.coords.longitude;
                  console.log("Lat : "+lat);
                  console.log("Lng : "+lng);
               
               });
            }

            });

            
    

        var lat = {!!$data->hos_latitude!!} ;
        var lng  = {!!$data->hos_longitude!!};
        
        var myresponse ;
        var mydirectionsRenderer;
        function initMap() {
            
            const directionsRenderer = new google.maps.DirectionsRenderer();
            const directionsService = new google.maps.DirectionsService();
            
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: {
                    lat: lat,
                    lng: lng
                }
            });
            
            if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(function (position)
               {
                  lat = position.coords.latitude ;
                  lng = position.coords.longitude;
                  directionsRenderer.setMap(map);
                  getDistance(lat,lng);
                  calculateAndDisplayRoute(directionsService, directionsRenderer);
               
               });
            }

            calculateAndDisplayRoute(directionsService, directionsRenderer);
               setInterval(function () {

                  if (navigator.geolocation) {
                     navigator.geolocation.getCurrentPosition(function (position)
                     {
                        lat = position.coords.latitude ;
                        lng = position.coords.longitude;
                        getDistance(lat,lng);
                        console.log(lat + " " + lng);
                        $.ajax({
                            type  : 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url   : '{{url("update_location")}}',
                            dataType : 'json',
                            data:{
                                pt_id: {!!$pt_id!!},
                                pt_latitude:lat,
                                pt_longitude: lng
                            },
                            success : function(data){
                                
                                directionsRenderer.setMap(map);
                                calculateAndDisplayRoute(directionsService, directionsRenderer);
                            }
                        });
                        
                     });
                  }
                  
            }, 5000);
            

        }

        var distancestate = true;
        function getDistance(lat1,lng1)
        {
            //Find the distance
            var distanceService = new google.maps.DistanceMatrixService();
            distanceService.getDistanceMatrix({
                origins: [lat1 + ',' + lng1],
                destinations: ["{!!$data->hos_latitude.','.$data->hos_longitude!!}" ],
                travelMode: google.maps.TravelMode.WALKING,
                unitSystem: google.maps.UnitSystem.METRIC,
                durationInTraffic: true,
                avoidHighways: false,
                avoidTolls: false
            },
            function (response, status) {
                if (status !== google.maps.DistanceMatrixStatus.OK) {
                    console.log('Error:', status);
                } else {
                    var distancevalue = response.rows[0].elements[0].distance.value ;
                    var distancetext = response.rows[0].elements[0].distance.text ;
                    var durationvalue = response.rows[0].elements[0].duration.value / 60 ;
                    var durationtext = response.rows[0].elements[0].duration.text ;

                    if(durationvalue > 0 && durationvalue <= 10 && distancestate)
                    {
                        
                        $.ajax({
                            type  : 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url   : '{{url("update_traveling_10_m_status")}}',
                            dataType : 'json',
                            data:{
                                pt_id: {!!$pt_id!!},
                            },
                            success : function(data){
                           
                                
                                if(data.status)
                                {
                                    distancestate = false;
                                    alert("แจ้งแม่ข่ายจะถึงภายใน 10 ");
                                }
                                
                            }
                        });
                    }

                    document.getElementById('durationtext').innerText = durationtext + " ( " + distancetext + " ) "; 
                    $.ajax({
                            type  : 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url   : '{{url("update_distance_matrix")}}',
                            dataType : 'json',
                            data:{
                                pt_id: {!!$pt_id!!},
                                distancevalue:distancevalue,
                                distancetext: distancetext,
                                durationvalue: durationvalue,
                                durationtext: durationtext,
                            },
                            success : function(data){
                                console.log(data);

                            }
                        });

                }
            });
        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer) {
            const selectedMode = 'DRIVING';
            directionsService.route({
                    origin: {
                        lat: lat,
                        lng: lng
                    },
                    destination: {
                        lat: {!!$data->hos_latitude!!},
                        lng: {!!$data->hos_longitude!!}
                    },
                    // Note that Javascript allows us to access the constant
                    // using square brackets and a string value as its
                    // "property."
                    travelMode: google.maps.TravelMode[selectedMode]
                },
                (response, status) => {
                    if (status == "OK") {
                        myresponse = response ;
                        mydirectionsRenderer = directionsRenderer ;
                        directionsRenderer.setDirections(response);
                    } else {
                        // window.alert("Directions request failed due to " + status);
                        console.log("Directions request failed due to " + status);
                    }
                }
            );
        }

    </script>

    <title>นำทาง</title>

</head>

<body>
   <div id="floating-panel-right">  
        <button  type="button" onclick="clickPhone()" class="btn action-btn">&nbsp;<i class="fa fa-phone fa-lg"></i></button>
        <button  type="button" onclick="clickChat()" class="btn action-btn"><i class="fa fa-comment fa-lg"></i> </button>
   </div>
    <div id="divHeader">
        <button id="action-back" type="button" onclick="clickHome()" class="btn  btn-lg"><i class="fa fa-arrow-left"></i> STEMI</button>
        <label id="durationtext" style="color:#FFF" ></label>
    </div>
    <div id="floating-panel-left-floor">
        <button  type="button" onclick="clickTraveling()" class="btn btn-success btn-lg">นำทาง</button>
        <button type="button" id="login" onclick="login.performClick(2);">OK</button>
        <!-- <button  type="button" id="save_test" class="btn btn-success btn-lg">Test</button> -->
    </div>
    <div id="map"></div>
</body>
<script>   

   function  clickHome()
   {
      window.location.href = "{{url('patient')}}" ;
   }

   function  clickChat()
   {
      window.location.href = "{{url('chat_stemi')}}" ;
   }

   function  clickPhone()
   {
        window.open('tel:'+{!!$phone!!});
   }

   function clickTraveling() {
   
        $.ajax({
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url("update_traveling_status")}}',
            dataType: 'json',
            data: {
                pt_id: {!!$pt_id!!},
            },
            success: function (data) {
               console.log(data);
               alert("แจ้งนำทางเรียบร้อยแล้ว");
            }

        });
    }


</script>

</html>
