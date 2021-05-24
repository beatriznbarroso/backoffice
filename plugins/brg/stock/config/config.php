<?php

return [
    // This contains the Laravel Packages that you want this plugin to utilize listed under their package identifiers
    'packages' => [
        'maatwebsite/excel' => [
            'providers' => [
                '\Maatwebsite\Excel\ExcelServiceProvider',
            ],
            'aliases' => [
                'Excel' => '\Maatwebsite\Excel\Facades\Excel',
            ]
        ]
    ],
];