<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    //index size
    'index-image-sizes' => [
        'large' => [
            'width' => 270,
            'height' => 280
        ],
        'skills' => [
            'width' => 344,
            'height' => 260
        ],
        'category' => [
            'width' => 600,
            'height' => 430
        ],
        'article' => [
            'width' => 1920,
            'height' => 1080
        ],
    ],

    'default-current-index-image' => 'large',


    //index size
    'cache-image-sizes' => [
        'large' => [
            'width' => 1920,
            'height' => 1080
        ],
    ],

    'default-current-cache-image' => 'large',

    'image-cache-life-time' => 10,

    'image-not-found' => ''

];
