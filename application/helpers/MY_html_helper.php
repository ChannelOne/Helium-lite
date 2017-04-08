<?php

/**
 * Summary of show_info_error
 * @return string
 */
function show_info_error()
{
    $CI =& get_instance();
    $rendered = '';

    $success_msg = $CI->session->success_msg;
    $info_msg    = $CI->session->info_msg;
    $warning_msg = $CI->session->warning_msg;
    $error_msg   = $CI->session->error_msg;

    if (isset($success_msg)) {
        $rendered .= "toastr[\"success\"](\"{$success_msg}\");";
    }

    if (isset($info_msg)) {
         $rendered .= "toastr[\"info\"](\"{$info_msg}\");";
    }

    if (isset($warning_msg)) {
         $rendered .= "toastr[\"warning\"](\"{$warning_msg}\");";
    }

    if (isset($error_msg)) {
         $rendered .= "toastr[\"error\"](\"{$error_msg}\");";
    }

    $CI->session->success_msg = NULL;
    $CI->session->info_msg    = NULL;
    $CI->session->warning_msg = NULL;
    $CI->session->error_msg   = NULL;

    return $rendered;
}

function resource_url($path)
{
    return RESOURCES_ENDPOINT . $path;
}

/**
 * 返回文本格式的序列号信息
 * @param array $licence
 * @return string
 */
function generate_licence_info_text($licence_json)
{
    $CI = &get_instance();

    if ( ! $CI->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, 'VIEW_LICENCE_INFO')) {
        return '无权限查看';
    }

    if (empty($licence_json)) {
        return '授权信息为空';
    }

    $licence_info = json_decode($licence_json, TRUE);

    if (empty($licence_info) && ! is_array($licence_info)) {
        return '授权信息为空';
    }

    $response = '';

    if (isset($licence_info['licence'])) {
        $response .= '授权码: ' . html_escape($licence_info['licence']) . '<br />';
    }

    if (isset($licence_info['licence_id'])) {
        $response .= '授权码ID: ' . html_escape($licence_info['licence_id']) . '<br />';
    }

    if (isset($licence_info['attachment_name']) && isset($licence_info['attachment_content'])) {
        $response .= "附件: <a href='data:application/octet-stream;base64,{$licence_info['attachment_content']}' download='{$licence_info['attachment_name']}'>{$licence_info['attachment_name']}</a><br />";
    }

    return $response;
}

/**
 * 生成附加信息查看html
 * @param mixed $extra_define
 * @param mixed $extra_info
 * @return string
 */
function generate_extra_info_view_html($extra_define, $extra_info)
{
    if (empty($extra_define)) {
        return '无附加信息';
    }

    $generation = '';

    foreach ($extra_define as $index => $each_define) {
        if ($index !== 0) {
            $generation .= "<br />\r\n";
        }

        if ($each_define['type'] === 'typea') {
            $input_value = $extra_info[$each_define['input_name']] ?? NULL;
            $generation .= html_escape($each_define['input_desc']) . ': ';
            $generation .= empty($input_value) ? '<i>未设定</i>' : html_escape($input_value);
        }
        else if ($each_define['type'] === 'typeb') {
            $selected_value = $extra_info[$each_define['selection_name']] ?? NULL;
            $selected_name = NULL;

            foreach ($each_define['selection_value'] as $each) {
                if ($each['value'] === $selected_value) {
                    $selected_name = $each['desc'];
                }
            }

            $generation .= html_escape($each_define['selection_desc']) . ': ';
            $generation .= html_escape($selected_name) ?? '<i>未设定</i>';

            $generation .= '<br />';

            $input_value = $extra_info[$each_define['input_name']] ?? NULL;
            $generation .= html_escape($each_define['input_desc']) . ': ';
            $generation .= empty($input_value) ? '<i>未设定</i>' : html_escape($input_value);
        }
        else if ($each_define['type'] === 'typec') {
            foreach ($each_define['input'] as $input_index => $each_input) {
                if ($input_index !== 0) {
                    $generation .= "<br />\r\n";
                }

                $input_value = $extra_info[$each_input['name']] ?? NULL;
                $generation .= html_escape($each_input['desc']) . ': ';
                $generation .= empty($input_value) ? '<i>未设定</i>' : html_escape($input_value);
            }
        }
    }

    return $generation;
}

/**
 * 生成附加信息编辑html
 * @param mixed $extra_define
 * @param mixed $extra_info
 * @return string
 */
function generate_extra_info_edit_html($extra_define, $extra_info)
{
    if (empty($extra_define)) {
        return '无附加信息';
    }

    $generation = '';

    foreach ($extra_define as $index => $each_define) {
        if ($index !== 0) {
            $generation .= "<br />\r\n";
        }

        if ($each_define['type'] === 'typea') {
            $input_value = $extra_info[$each_define['input_name']] ?? NULL;
            $generation .= html_escape($each_define['input_desc']) . ': ';
            $generation .= form_input($each_define['input_name'], $input_value);
        }
        else if ($each_define['type'] === 'typeb') {
            $selected_value = $extra_info[$each_define['selection_name']] ?? NULL;

            $selection_option = [];
            foreach ($each_define['selection_value'] as $each) {
                $selection_option[$each['value']] = $each['desc'];
            }

            $generation .= html_escape($each_define['selection_desc']) . ': ';
            $generation .= form_dropdown($each_define['selection_name'], $selection_option,  $selected_value);

            $generation .= '<br />';

            $input_value = $extra_info[$each_define['input_name']] ?? NULL;
            $generation .= html_escape($each_define['input_desc']) . ': ';
            $generation .= form_input($each_define['input_name'], $input_value);
        }
        else if ($each_define['type'] === 'typec') {
            foreach ($each_define['input'] as $input_index => $each_input) {
                if ($input_index !== 0) {
                    $generation .= "<br />\r\n";
                }

                $input_value = $extra_info[$each_input['name']] ?? NULL;
                $generation .= html_escape($each_input['desc']) . ': ';
                $generation .= form_input($each_input['name'], $input_value);
            }
        }
    }


    return $generation;
}

/**
 * 生成价格信息查看html
 * @param mixed $price_info
 * @return string
 */
function generate_price_info_view_html($price_info)
{
    $price_html  = '售价: ' . (isset($price_info['sale_price']) ? number_format($price_info['sale_price'] / 100, 2) : '0.00') . '<br />';
    $price_html .= '支付方式: ' . (isset($price_info['cardtype']) ? $price_info['cardtype'] : '未定义') . '<br />';
    $price_html .= '成本: ' . (isset($price_info['cost']) ? number_format($price_info['cost'] / 100, 2) : '0.00') . ' ' . ($price_info['currency'] ?? '[货币单位]') . '<br />';

    return $price_html;
}

function current_username()
{
    $CI = &get_instance();
    return $CI->user_model->display_name;
}

function gravatar_url($size = 80)
{
    $CI = &get_instance();
    $gravatar_url = 'https://www.gravatar.com/avatar/' . md5($CI->user_model->email) . '.jpg?s=' . $size;
    return $gravatar_url;
}
