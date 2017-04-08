<?php

$data = [
    'success' => TRUE,
    'name' => 'RescueTime',
    'logo' => 'https://static.lizhi.io/icon/rescuetime.png',
    'description' => '跨平台时间分析管理工具，资源占用少，有效提升工作效率',
    'platform' => [
        'windows' => TRUE,
        'linux' => FALSE,
        'mac' => TRUE,
        'ios' => FALSE,
        'android' => TRUE
    ],
    'licence_type' => '演示版',
    'download_url' => 'https://dl.lizhi.io',
    'extra' => [
        [
            'type' => 'typea',
            'input_name' => 'account',
            'input_desc' => '账号',
            'input_hint' => '这里输入账号信息',
            'input_type' => 'email',
            'reg_url' => 'https://lizhi.io'
        ],
    ],
    'validation' => [
        [
            'name' => 'account',
            'desc' => '账号',
            'type' => 'email',
            'required' => TRUE
        ]
    ]
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';