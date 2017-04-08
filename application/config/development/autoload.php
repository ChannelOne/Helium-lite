<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['config'] = ['helium'];

$autoload['drivers'] = ['connector'];

$autoload['helper'] = ['cookie', 'form', 'html', 'string', 'text', 'typography', 'url'];

$autoload['libraries'] = ['database', 'form_validation', 'parser', 'session'];

$autoload['model'] = ['helper_model', 'login_model','price_model', 'price/price_basic_model', 'price/price_rule_model', 'privilege_model', 'user_model'];
