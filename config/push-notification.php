<?php

return array(

    'askIOS' => array(
        'environment' => 'development',
        'certificate' => base_path('app/ck.pem'),
        'passPhrase' => 'password',
        'service' => 'apns'
    ),
    'askAndroid' => array(
        'environment' => 'development',
        'apiKey' => env('API_KEY'),
        'service' => 'gcm'
    )

);