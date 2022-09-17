<?php

define('key_weather', '91e78261248d939305bb93de71dc1841');


function getFolder()
{

    return app()->getLocale() == 'ar' ? 'css-rtl' : 'css';
}


function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    return $filename;
}

function notifcation($token_1,$title,$body){
    $SERVER_API_KEY = 'AAAAL0aXETQ:APA91bF9Ds292xAqItGidAR5XRf9ZFPAhhoSaS3h87ytL-P1Y_idUkRV7ETW5WStshr25xQ9NQZAs9yYlqJoYTeOxZO22YJZ4cnI3IFb4cgECrLmrIfaTFvQMGSxwhiDNd97GrAMtyiY';

  //  $token_1 = 'fQf4Q92dRriAj0rTVXM8_w:APA91bEr-6ycLtZjjvFe05sQCeTxBvr2LteB6YpEQmr7gYOwWbTFox2xJG83RRUIht6Qc9tT0p4bZw_r_1jnxAvJqD7YyNycbr6CTUq4NR15B4PEeyD4bqVDEWDfjI-6_uXNuIQdmxqY';

    $data = [

        "registration_ids" => [
            $token_1
        ],

        "notification" => [

            "title" => $title,

            "body" => $body,
            "android_channel_id" => "pushnotificationapp",
            "image"=>"https://cdn2.vectorstock.com/i/1000x1000/23/91/small-size-emoticon-vector-9852391.jpg",

            "sound" => "default" // required for sound on ios

        ],
        "data"=>["_id"=>1],

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',

    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);

  //  dd($response);
}


