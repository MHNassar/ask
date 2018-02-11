<?php

return array(

    'askIOS' => array(
        'environment' => 'development',
        'certificate' => base_path('app/ck.pem'),
        'passPhrase' => '1234',
        'service' => 'apns'
    ),
    'askAndroid' => array(
        'environment' => 'development',
        'apiKey' => env('API_KEY'),
        'service' => 'gcm'
    )

);