<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'][] = function () {
    date_default_timezone_set('Asia/Shanghai');
    define('RESOURCES_ENDPOINT', 'http://localhost/helium/resources/');
};
