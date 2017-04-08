<?php

$data = [
    'success' => TRUE,
    'name' => 'Moom',
    'logo' => 'https://static.lizhi.io/icon/moom.png',
    'description' => 'Mac 窗口大小/位置控制工具，效率提升神器',
    'platform' => [
        'windows' => FALSE,
        'linux' => FALSE,
        'mac' => TRUE,
        'ios' => FALSE,
        'android' => FALSE
    ],
    'licence_type' => '演示版',
    'download_url' => 'https://dl.lizhi.io/',
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';