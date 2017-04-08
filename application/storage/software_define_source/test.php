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
    'extra' => [
        [
            'type' => 'typea',
            'input_name' => 'extra_account',
            'input_desc' => '账号',
            'input_hint' => '这里输入账号信息',
            'input_type' => 'email',
            'reg_url' => 'https://lizhi.io'
        ],
        [
            'type' => 'typeb',
            'selection_name' => 'extra_account_type',
            'selection_desc' => '账号类型',
            'selection_hint' => '选择注册的账号类型',
            'selection_value' => [
                [
                    'desc' => 'Google',
                    'value' => 'google'
                ],
                [
                    'desc' => 'Twitter',
                    'value' => 'twitter'
                ],
                [
                    'desc' => 'Facebook',
                    'value' => 'facebook'
                ]
            ],
            'input_name' => 'extra_3p_account',
            'input_desc' => '第三方账号',
            'input_hint' => '这里输入账号信息',
            'input_type' => 'email',
            'reg_url' => 'https://lizhi.io'
        ],
        [
            'type' => 'typec',
            'input' => [
                [
                    'name' => 'extra_username_c',
                    'desc' => '用户名',
                    'hint' => '这里输入用户名',
                    'type' => 'email',
                ],
                [
                    'name' => 'extra_password',
                    'desc' => '密码',
                    'hint' => '这里输入密码',
                    'type' => 'text',
                    'regex' => '/^[a-zA-Z0-9]+$/'
                ]
            ]
        ]
    ],
    'validation' => [
        [
            'name' => 'extra_account',
            'desc' => '账号',
            'type' => 'email',
            'required' => TRUE
        ],
        [
            'name' => 'extra_account_type',
            'desc' => '账号类型',
            'type' => 'option',
            'value' => ['google', 'twitter', 'facebook'],
            'required' => FALSE
        ],
        [
            'name' => 'extra_3p_account',
            'desc' => '账号',
            'type' => 'email',
            'required' => FALSE
        ],
        [
            'name' => 'extra_username_c',
            'desc' => '账号',
            'type' => 'text',
            'value' => '/^[a-zA-Z0-9]+$/',
            'required' => FALSE
        ],
        [
            'name' => 'extra_password',
            'desc' => '密码',
            'type' => 'text',
            'value' => '/^[a-zA-Z0-9]+$/',
            'required' => FALSE
        ]
    ]
];

define('DS', DIRECTORY_SEPARATOR);
$realtive_path = __DIR__ . DS . '..' . DS . 'software_define' . DS . strtolower(pathinfo(__FILE__, PATHINFO_FILENAME)) . '.json';
$json_data = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($realtive_path, $json_data);
echo 'done';