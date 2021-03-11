<?php
//Show Date with user timezone
if (! function_exists('jsonDecode')) {
    function jsonDecode($value)
    {
        $value = json_decode($value);
        if($value==null){$value=array("");}
        return $value;
    }
}


//Show Date with user timezone
if (! function_exists('show_date')) {
    function show_date($date, $format="d/m/Y H:i")
    {
        if(!($date instanceof \Carbon\Carbon)) {
            if(is_numeric($date)) {
                 // Assume Timestamp
                 $date = \Carbon\Carbon::createFromTimestamp($date);
            } else {
                $date = \Carbon\Carbon::parse($date);
            }
        }

        return $date->setTimezone($_SESSION['user']->timezone)->format($format);
    }
}

//Set Datetime to insert_db
if (! function_exists('insert_db_date')) {
    function insert_db_date()
    {
        return "msmss";
    }
}

//Set Datetime to insert_db
if (! function_exists('moss')) {
    function moss()
    {
        return "mmmmm";
    }
}

if (! function_exists('getDistance')) {
    function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }
}






//Set Datetime to insert_db
if (! function_exists('age')) {
    function age($birthdate)
    {
        $age = "";
        if($birthdate!="")
        {
            $birthDate = explode("-", $birthdate);
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? (((date("Y")+543) - $birthDate[0]) - 1) : ((date("Y")+543) - $birthDate[0]));
        }
        return $age;
    }
}

//Set Datetime to insert_db
if (! function_exists('firebase')) {
    function firebase($wheretxt,$user_type,$txt,$rq_id)
    {

        define('FIREBASE_API_KEY', 'AAAAbB1UiuE:APA91bEO09fMfNk_s2E-7ufOcbTgqUfOLeFmnRVvrfmmXQSdUrLsStHf9O2a2KerdJmWha3Q74Oacvx8Zx8QBfvMgT9gRGcp-QnTbeHmnEXQl0UJrtlRAC6obynHjnW77SN8W8vRN3fc');
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key='.FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        $sound  = "noti.mp3";

        if($user_type=="CLIENT"){
            $sendfirebase = DB::table('users')
            ->leftjoin('stemi_request','stemi_request.rq_us_refno','users.id')
            ->where([
                ['us_hos_refno',$wheretxt],
                ['user_type',$user_type],
                ['rq_id',$rq_id],
            ])
            ->get();
        }else{
            $sendfirebase = DB::table('users')
            ->where([
                ['us_hos_refno',$wheretxt],
                ['user_type',$user_type]
            ])
            ->get();
        }




        foreach($sendfirebase as $send){

            $data = array(
                "to" => $send->us_token,
                //"to" => "fuV0DF4NuYo:APA91bHz4ghR_sKz-xcctlq0B3w3OIzgeNzMyxyP3lKE6uIzZHZoW252EwbdAXCq0YOKTV3go8GJUDH1EuwYi42kOn_ZeQxBySBGwpdUuhJmTpvrwRv2YTngam3DesdEhIfF7kHAyODs",
                "notification" => array
                (
                    "title"   => $txt,
                    "body"    => $rq_id."",
                    "sound"   => $sound
                ),
                "priority"  => "high",
                "data"      => array(
                    "body"=> "มีผู้ป่วย",
                    "title"=> "มีผู้ป่วย",
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
            // echo $result;
        }

    }

}

//Set Datetime to insert_db
if (! function_exists('firebase2')) {
    function firebase2($wheretxt,$user_type,$txt,$rq_id)
    {

        //define('FIREBASE_API_KEY', 'AAAAbB1UiuE:APA91bEO09fMfNk_s2E-7ufOcbTgqUfOLeFmnRVvrfmmXQSdUrLsStHf9O2a2KerdJmWha3Q74Oacvx8Zx8QBfvMgT9gRGcp-QnTbeHmnEXQl0UJrtlRAC6obynHjnW77SN8W8vRN3fc');
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key='.FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        $sound  = "noti.mp3";

        $sendfirebase = DB::table('users')
        ->where([
            ['us_hos_refno',$wheretxt],
            ['user_type',$user_type]
        ])
        ->get();

        foreach($sendfirebase as $send){

            $data = array(
                "to" => $send->us_token,
                //"to" => "fuV0DF4NuYo:APA91bHz4ghR_sKz-xcctlq0B3w3OIzgeNzMyxyP3lKE6uIzZHZoW252EwbdAXCq0YOKTV3go8GJUDH1EuwYi42kOn_ZeQxBySBGwpdUuhJmTpvrwRv2YTngam3DesdEhIfF7kHAyODs",
                "notification" => array
                (
                    "title"   => $txt,
                    "body"    => $rq_id."",
                    "sound"   => $sound
                ),
                "priority"  => "high",
                "data"      => array(
                    "body"=> "มีผู้ป่วย",
                    "title"=> "มีผู้ป่วย",
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
            // echo $result;
        }

    }

}

if (! function_exists('mysort1')) {
    function mysort1 ($x, $y) {
        return ($x['distance'] > $y['distance']);
    }
}
