<?php

class Helper_model extends CI_Model
{
    public function ui_sidebar_menu()
    {
        $sidebar = [];

        $sidebar[] = [
            'id' => 'home',
            'icon' => 'fa-gear',
            'name' => '首页',
            'link' => site_url('home')
        ];

        if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['ORDER_LIST'])) {
            $current = [
                'id' => 'order',
                'icon' => 'fa-gear',
                'name' => '订单管理',
                'link' => site_url('order')
            ];

            $sidebar[] = $current;
        }

        if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['QUEUE_LIST'])) {
            $current = [
                'id' => 'queue',
                'icon' => 'fa-gear',
                'name' => '列队管理',
                'link' => site_url('queue')
            ];

            $sidebar[] = $current;
        }

        if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['REDEEM_LIST'])) {
            $current = [
                'id' => 'redeem',
                'icon' => 'fa-gear',
                'name' => '兑换码管理',
                'link' => site_url('redeem')
            ];

            if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['REDEEM_LIST'])) {
                $current['child'][] = [
                    'id' => 'redeem_search',
                    'icon' => 'fa-gear',
                    'name' => '搜索兑换码',
                    'link' => site_url('redeem/search')
                ];
            }

            if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['REDEEM_EDIT'])) {
                $current['child'][] = [
                    'id' => 'redeem_generate',
                    'icon' => 'fa-gear',
                    'name' => '生成兑换码',
                    'link' => site_url('redeem/generate')
                ];
            }

            $sidebar[] = $current;
        }

        if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['PRICE_EDIT'])) {
            $current = [
                'id' => 'price',
                'icon' => 'fa-gear',
                'name' => '价格管理',
                'link' => site_url('price')
            ];

            if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['PRICE_EDIT'])) {
                $current['child'][] = [
                    'id' => 'price_basic',
                    'icon' => 'fa-gear',
                    'name' => '基础定价管理',
                    'link' => site_url('price/basic')
                ];
            }

            if ($this->privilege_model->have_privilege(Privilege_model::USER_PRIVILEGE, ['PRICE_EDIT'])) {
                $current['child'][] = [
                    'id' => 'price_dynamic',
                    'icon' => 'fa-gear',
                    'name' => '动态调价管理',
                    'link' => site_url('price/dynamic')
                ];
            }

            $sidebar[] = $current;
        }

        return $sidebar;
    }

    public function ui_sidebar_count()
    {
        $count = [];

        $count['order'] = $this->status_model->get_status_count(['EDITING', 'PENDING_PROCESS', 'MANUAL_PROCESS', 'PROCESS_FAILED', 'PENDING_REFUND', 'ISV_REFUND']);
        $count['queue'] = $this->queue_model->get_queue_count();

        return $count;
    }

    public function generate_sidebar($choose = NULL, $choose_sub = NULL)
    {
        $sidebar_data = [
            'sidebar_list'  => $this->ui_sidebar_menu(),
            'sidebar_count' => $this->ui_sidebar_count(),
            'choose'        => $choose,
            'choose_sub'    => $choose_sub
        ];

        return $this->load->view('common/sidebar', $sidebar_data, TRUE);
    }

    public function order_status_menu($status = NULL)
    {
        $status = strtoupper($status);

        $menus = [
            [
                'name' => '等待处理',
                'icon' => 'fa-inbox',
                'link' => site_url('order/status/pending_process'),
                'count' => $this->status_model->get_status_count('PENDING_PROCESS'),
                'active' => 'PENDING_PROCESS' === $status,
            ],
            [
                'name' => '正在编辑',
                'icon' => 'fa-edit',
                'link' => site_url('order/status/editing'),
                'count' => $this->status_model->get_status_count('EDITING'),
                'active' => 'EDITING' === $status,
            ],
            [
                'name' => '等待人工处理',
                'icon' => 'fa-child',
                'link' => site_url('order/status/manual_process'),
                'count' => $this->status_model->get_status_count('MANUAL_PROCESS'),
                'active' => 'MANUAL_PROCESS' === $status,
            ],
            [
                'name' => '处理失败',
                'icon' => 'fa-info',
                'link' => site_url('order/status/process_failed'),
                'count' => $this->status_model->get_status_count('PROCESS_FAILED'),
                'active' => 'PROCESS_FAILED' === $status,
            ],
            [
                'name' => '处理完成',
                'icon' => 'fa-check',
                'link' => site_url('order/status/processed'),
                'count' => NULL,
                'active' => 'PROCESSED' === $status,
            ],
            [
                'name' => '开发商退款',
                'icon' => 'fa-credit-card',
                'link' => site_url('order/status/isv_refund'),
                'count' => $this->status_model->get_status_count('ISV_REFUND'),
                'active' => 'ISV_REFUND' === $status,
            ],
            [
                'name' => '等待退款',
                'icon' => 'fa-eye',
                'link' => site_url('order/status/pending_refund'),
                'count' => $this->status_model->get_status_count('PENDING_REFUND'),
                'active' => 'PENDING_REFUND' === $status,
            ],
            [
                'name' => '退款完成',
                'icon' => 'fa-check',
                'link' => site_url('order/status/refunded'),
                'count' => NULL,
                'active' => 'REFUNDED' === $status,
            ],
        ];

        return $menus;
    }

    public function queue_status_menu($status = NULL)
    {
        $status = strtoupper($status);

        $menus = [
            [
                'name' => '等待处理',
                'icon' => 'fa-inbox',
                'link' => site_url('queue/status/process_queue'),
                'count' => $this->queue_model->get_queue_count(Queue_model::PROCESS_QUEUE),
                'active' => 'PROCESS_QUEUE' === $status,
            ],
            [
                'name' => '等待通知',
                'icon' => 'fa-envelope',
                'link' => site_url('queue/status/mail_queue'),
                'count' => $this->queue_model->get_queue_count(Queue_model::MAIL_QUEUE),
                'active' => 'MAIL_QUEUE' === $status,
            ],
            [
                'name' => '通知失败',
                'icon' => 'fa-info',
                'link' => site_url('queue/status/mail_fail_queue'),
                'count' => $this->queue_model->get_queue_count(Queue_model::MAIL_FAIL_QUEUE),
                'active' => 'MAIL_FAIL_QUEUE' === $status,
            ]
        ];

        return $menus;
    }

    /**
     * 过滤请求数据
     * @param mixed $validation_data
     * @param mixed $input_data
     * @throws Exception
     * @return string[]
     */
    public function filter_request($validation_data, $input_data)
    {
        $filtered_data = [];

        foreach ($validation_data as $validation) {
            $validate_successful = TRUE;
            $value = $input_data[$validation['name']] ?? NULL;
            $value = trim($value);

            if (empty($value) && $validation['required']) {
                throw new Exception('附加信息错误：' .$validation['desc'] . ' 不能为空');
            }

            if (empty($value)) {
                continue;
            }

            switch($validation['type']) {
                case 'email':
                    $validate_successful = filter_var($value, FILTER_VALIDATE_EMAIL) !== FALSE;
                    break;
                case 'text':
                    $validate_successful = preg_match($validation['value'], $value) > 0;
                    break;
                case 'option':
                    $validate_successful = in_array($value, $validation['value']);
                    break;
            }

            if (!$validate_successful) {
               throw new Exception('附加信息错误：' . $validation['desc'] . ' 格式错误');
            }

            $filtered_data[$validation['name']] = $value;
        }

        return $filtered_data;
    }
}
