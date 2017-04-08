<?php

$data = [
    'success' => TRUE,
    'name' => 'Fantastical',
    'logo' => 'https://static.lizhi.io/icon/fantastical.png',
    'description' => '可能是 Mac 上最好用的日历',
    'platform' => [
        'windows' => FALSE,
        'linux' => FALSE,
        'mac' => TRUE,
        'ios' => FALSE,
        'android' => FALSE
    ],
    'licence_type' => '演示版',
    'download_url' => 'https://dl.lizhi.io/fantastical',
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';