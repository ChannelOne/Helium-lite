<?php

$data = [
    'success' => TRUE,
    'logo' => 'https://static.lizhi.io/icon/betterzip.png',
    'name' => 'BetterZip',
    'description' => 'Mac 平台上首屈一指的文件解压打包工具',
    'platform' => [
        'windows' => FALSE,
        'linux' => FALSE,
        'mac' => TRUE,
        'ios' => FALSE,
        'android' => FALSE
    ],
    'licence_type' => '演示版',
    'download_url' => 'https://dl.lizhi.io/betterzip',
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';