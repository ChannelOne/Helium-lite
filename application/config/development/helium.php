<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config = [
    'system_uid'          => 1,
    'default_customer_id' => 1,

    'default_user_group'   => 1,
    'default_skudb_group'  => 2,
    'default_report_group' => 3,

    'login_timeout' => 1800,

    'queue_process_delay' => 100,
    'queue_mail_delay'    => 30,

    'no_mail_address'     => 'no_mail@lizhi.io',

    'currency' => ['AUD', 'CNY', 'EUR', 'USD'],
];
