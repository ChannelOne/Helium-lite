<?php

$data = [
    'success' => TRUE,
    'logo' => 'https://static.lizhi.io/icon/test.png',
    'name' => '测试软件',
    'description' => '这是一个测试软件',
    'platform' => [
        'windows' => TRUE,
        'linux' => FALSE,
        'mac' => FALSE,
        'ios' => FALSE,
        'android' => FALSE
    ],
    'licence_type' => '个人版',
    'download_url' => 'https://dl.lizhi.io',
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';
