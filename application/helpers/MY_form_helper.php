<?php

function csrf_input()
{
    $CI =& get_instance();
    $rendered = '';

    if (config_item('csrf_protection') === TRUE) {
        $rendered = '<input type="hidden" name="'.$CI->security->get_csrf_token_name().'" value="'.html_escape($CI->security->get_csrf_hash())."\" />\n";
    }

    return $rendered;
}
