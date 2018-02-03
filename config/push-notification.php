<?php

return array(

    'askIOS' => array(
        'environment' => 'development',
        'certificate' => '/path/to/certificate.pem',
        'passPhrase' => 'password',
        'service' => 'apns'
    ),
    'askAndroid' => array(
        'environment' => 'development',
        'apiKey' => env('API_KEY'),
        'service' => 'gcm'
    )

);