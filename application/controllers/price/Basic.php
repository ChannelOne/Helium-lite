<?php

class Basic extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->user_model->require_full_login();
    }

    public function index($start = 0)
    {
        $this->privilege_model->require_privilege(Privilege_model::USER_PRIVILEGE, 'PRICE_BASIC_LIST');

        $body_data = [
            'software_id_json' => $this->connector->get_raw_cache('db'),
            'currency'         => $this->config->item('currency'),
            'csrf_token'       => $this->security->get_csrf_token_name(),
            'csrf_hash'        => $this->security->get_csrf_hash(),
            'search_endpoint'  => site_url('price/basic/search'),
            'edit_endpoint'    => site_url('price/basic/edit'),
            'privilege'        => [
                'price_basic_edit' => $this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, 'PRICE_BASIC_EDIT')
            ]
        ];

        $rendering = [
            'title'   => '基础定价管理',
            'sidebar' => $this->helper_model->generate_sidebar('price', 'price_basic'),
            'body'    => $this->load->view('price/price_basic_list', $body_data, TRUE),
            'footer_js' => [
                'AdminLTE/vue/vue.min.js',
                'price/basic_list.js',
            ],
            'header_css' => [
                'price/basic_list.css',
            ],
        ];

        $this->load->view('common/frame', $rendering);
    }

    public function search()
    {
        $this->privilege_model->require_privilege(Privilege_model::USER_PRIVILEGE, 'PRICE_BASIC_LIST');

        $software_id = $this->input->post('software_id');

        // 如果请求不是json，则当作单个software_id对待
        if (preg_match('/^\w+$/', $software_id) > 0) {
            $software_id_list = [$software_id];
        }
        else {
            $software_id_list = json_decode($software_id, TRUE);
        }

        // 请求为空
        if (empty($software_id_list)) {
            $this->_json_response();
        }

        // 过滤请求software_id
        $query_list = [];
        foreach ($software_id_list as $each) {
            if ($this->connector->is_valid_software_id($each)) {
                $query_list[] = $each;
            }
        }

        // 过滤后结果为空
        if (empty($query_list)) {
            $this->_json_response();
        }

        // 获取结果
        $result = $this->price_basic_model->get_price($query_list);

        // 重新填充结果内不存在数据
        $result_software_id = [];
        foreach ($result as $each) {
            $result_software_id[$each['software_id']] = TRUE;
        }

        foreach ($query_list as $each) {
            if ( ! array_key_exists($each, $result_software_id)) {
                $result[] = [
                    'software_id' => $each,
                    'price' => 0,
                    'currency' => 'CNY',
                    'min_sale' => 0
                ];
            }
        }

        $result['success'] = TRUE;
        $this->_json_response($result);
    }

    public function edit()
    {
        $this->privilege_model->require_privilege(Privilege_model::USER_PRIVILEGE, 'PRICE_BASIC_EDIT');

        $this->form_validation->set_rules("software_id", '软件ID', 'trim|required|regex_match[/^[A-Z_]+$/]');
        $this->form_validation->set_rules("currency", '货币', 'trim|required|in_list[' . implode(',', $this->config->item('currency')) . ']');
        $this->form_validation->set_rules("price", '成本价格', 'required|is_natural');
        $this->form_validation->set_rules("min_sale", '最低售价', 'required|is_natural');

        if ($this->form_validation->run() === FALSE) {
            $message = [
                'error' => TRUE,
                'message' => $this->form_validation->error_string()
            ];

            $this->_json_response($message);
        }

        $software_id = $this->input->post('software_id');

        $price_data = [
            'software_id' => $software_id,
            'price'       => $this->input->post('price'),
            'currency'    => $this->input->post('currency'),
            'min_sale'    => $this->input->post('min_sale')
        ];

        try {
            $this->price_basic_model->edit_price($software_id, $price_data);
            $this->_json_response(['success' => TRUE]);
        }
        catch (Exception $e) {
            $message = [
                'error' => TRUE,
                'message' => $this->db->error()['message']
            ];

            $this->_json_response($message);
        }
    }

    public function _json_response($response = [])
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($response);
        exit();
    }
}
