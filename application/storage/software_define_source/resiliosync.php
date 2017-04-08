<?php

$data = [
    'success' => TRUE,
    'name' => 'Resilio Enterprise',
    'logo' => 'https://static.lizhi.io/icon/resilio_sync.png',
    'description' => '1分钟自建云盘，全平台自动同步，个人多设备数据管理/团队协作利器',
    'platform' => [
        'windows' => TRUE,
        'linux' => FALSE,
        'mac' => TRUE,
        'ios' => TRUE,
        'android' => TRUE
    ],
    'licence_type' => '演示版',
    'download_url' => 'https://dl.lizhi.io',
    'extra' => [
        [
            'type' => 'typec',
            'input' => [
                [
                    'name' => 'company',
                    'desc' => '公司名',
                    'hint' => '这里输入公司名',
                    'type' => 'text',
                    'regex' => '/^[a-zA-Z0-9 .,]+$/'
                ],
                [
                    'name' => 'address',
                    'desc' => '公司地址',
                    'hint' => '这里输入公司地址',
                    'type' => 'text',
                    'regex' => '/^[a-zA-Z0-9 .,]+$/'
                ]
            ]
        ]
    ],
    'validation' => [
        [
            'name' => 'company',
            'desc' => '公司名',
            'type' => 'text',
            'value' => '/^[a-zA-Z0-9 .,]+$/',
            'required' => TRUE
        ],
        [
            'name' => 'address',
            'desc' => '公司地址',
            'type' => 'text',
            'value' => '/^[a-zA-Z0-9 .,]+$/',
            'required' => TRUE
        ],
    ]
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';