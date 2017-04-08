<?php

$data = [
    'success' => TRUE,
    'name' => 'UltraEdit',
    'logo' => 'https://static.lizhi.io/icon/ultraedit.png',
    'description' => '最老牌、最强大的全平台文本编辑器',
    'platform' => [
        'windows' => TRUE,
        'linux' => TRUE,
        'mac' => TRUE,
        'ios' => FALSE,
        'android' => FALSE
    ],
    'licence_type' => '演示版',
    'download_url' => 'https://dl.lizhi.io/ultraedit',
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';