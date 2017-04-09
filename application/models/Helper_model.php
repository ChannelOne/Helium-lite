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
			
            $sidebar[] = $current;
        }

        return $sidebar;
    }

    public function ui_sidebar_count()
    {
        return [];
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
}
