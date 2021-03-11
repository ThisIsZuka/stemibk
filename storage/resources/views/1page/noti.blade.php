@php

            define('FIREBASE_API_KEY', 'AAAAbB1UiuE:APA91bEO09fMfNk_s2E-7ufOcbTgqUfOLeFmnRVvrfmmXQSdUrLsStHf9O2a2KerdJmWha3Q74Oacvx8Zx8QBfvMgT9gRGcp-QnTbeHmnEXQl0UJrtlRAC6obynHjnW77SN8W8vRN3fc');
            $url = 'https://fcm.googleapis.com/fcm/send';
            $headers = array( 
                'Authorization: key='.FIREBASE_API_KEY, 
                'Content-Type: application/json'
            );
        
            //$token = DB::table('logistic.users')->where('id', $r->user_id)->first();
        
            //dd($job);
            $txt    = "คุณได้รับงาน";
            $sound  = "noti.mp3";
            // if($job->job_urgent==1){
            //     $txt    = "คุณได้รับงานด่วน";
            //     $sound  = "emergency.mp3";
            // }else{
            //     $txt    = "คุณได้รับงาน";
            //     $sound  = "noti.mp3";
            // }


            $data = array(
                //"to" => $token->firebase_token,
                "to" => "fuV0DF4NuYo:APA91bHz4ghR_sKz-xcctlq0B3w3OIzgeNzMyxyP3lKE6uIzZHZoW252EwbdAXCq0YOKTV3go8GJUDH1EuwYi42kOn_ZeQxBySBGwpdUuhJmTpvrwRv2YTngam3DesdEhIfF7kHAyODs",
                "notification" => array
                (
                    "title"         => $txt,
                    "body"          => 'โปรดรับงาน',
                    "sound"			=> $sound
                ),
                "priority"=> "high",
                "data" => array(
                    "body"=> "โปรดรับงาน",
                    "title"=> "คุณได้รับงาน",
                    "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
                    "id"=> "1",
                    "status"=> "done",
                    "image"=> "https://ibin.co/2t1lLdpfS06F.png",
                ),
            );





            $data_string = json_encode($data);
        
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL,$url);
            curl_setopt( $ch,CURLOPT_POST,true);
            curl_setopt( $ch,CURLOPT_HTTPHEADER,$headers);
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt( $ch,CURLOPT_POSTFIELDS,json_encode($data));
            $result = curl_exec($ch);
            curl_close($ch);
        
            echo $result;

@endphp            