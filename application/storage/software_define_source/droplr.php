<?php

$data = [
    'success' => TRUE,
    'logo' => 'https://static.lizhi.io/icon/droplr.png',
    'name' => 'Droplr',
    'description' => '大名鼎鼎的在线分享工具，只需一次拖拽就能轻松分享图片',
    'platform' => [
        'windows' => TRUE,
        'linux' => FALSE,
        'mac' => TRUE,
        'ios' => TRUE,
        'android' => TRUE
    ],
    'licence_type' => '演示版',
    'download_url' => 'https://lizhi.io',
    'extra' => [
        [
            'type' => 'typeb',
            'selection_name' => 'account_type',
            'selection_desc' => '账号类型',
            'selection_hint' => '选择注册的账号类型',
            'selection_value' => [
                [
                    'desc' => 'Google',
                    'value' => 'google'
                ],
                [
                    'desc' => 'Slack',
                    'value' => 'slack'
                ],
                [
                    'desc' => 'Droplr',
                    'value' => 'droplr'
                ],
                [
                    'desc' => 'Facebook',
                    'value' => 'facebook'
                ]
            ],
            'input_name' => 'account',
            'input_desc' => '账号',
            'input_hint' => '这里输入账号信息',
            'input_type' => 'email',
            'reg_url' => 'https://lizhi.io'
        ]
    ],
    'validation' => [
        [
            'name' => 'account_type',
            'desc' => '账号类型',
            'type' => 'option',
            'value' => ['google', 'twitter', 'slack', 'droplr'],
            'required' => TRUE
        ],
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