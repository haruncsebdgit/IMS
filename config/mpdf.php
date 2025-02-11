<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => '',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'MPdf',
    'display_mode'          => 'fullpage',
    'tempDir'               => storage_path('/framework'),
    'font_path' => [base_path('resources/fonts/')],
    'font_data' => [
        'bangla' => [
            'R'  => 'SiyamRupali.ttf',    // regular font
            'B'  => 'SiyamRupali.ttf',       // optional: bold font
            'I'  => 'SiyamRupali.ttf',     // optional: italic font
            'BI' => 'SiyamRupali.ttf', // optional: bold-italic font
            'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ]
        // ...add as many as you want.
    ]
];
