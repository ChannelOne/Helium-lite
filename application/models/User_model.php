<?php

/**
 * @property bool $system_user 是否系统用户
 * @property int $user_id 用户ID
 * @property string $display_name 用户显示名
 * @property string $email 用户邮箱
 * @property string $mobile 用户手机号
 * @property string $bind_sku_node 绑定SKU节点 (仅用于销售报表)
 */
class User_model extends CI_Model
{
    public $system_user = FALSE;

    public $user_id = 0;
    public $display_name = '';
    public $email = '';
    public $mobile = '';
    public $bind_sku_node = '';

    public function __construct()
    {
        parent::__construct();

        if ($this->session->is_login === TRUE) {
            $this->user_id       = $this->session->user['user_id'];
            $this->display_name  = $this->session->user['display_name'];
            $this->email         = $this->session->user['email'];
            $this->mobile        = $this->session->user['mobile'];
            $this->bind_sku_node = $this->session->user['sku_tree_node'];
        }

        if ($this->session->login_expire > time()) {
            $this->session->login_expire = time() + $this->config->item('login_timeout');
        }
        else if ($this->session->login_expire > 0) {
            $this->login_model->logout(TRUE);
        }
    }

    /**
     * 获取用户信息
     * @param int $user_id
     * @return array|null
     */
    public function get_user_info($user_id = NULL)
    {
        $user_id = (int)$user_id ?? 0;

        if ($user_id <= 0) {
            return NULL;
        }

        $query = $this->db->select()->from('user')->where(['user_id' => $user_id])->limit(1)->get();
        return $query->first_row('array');
    }

    /**
     * 获取用户列表
     * @return array
     */
    public function get_all_users()
    {
        $query = $this->db->select('user_id, display_name')->from('user')->get();
        $result = $query->result_array();

        $users = [];
        foreach ($result as $each) {
            $users[$each['user_id']] = $each['display_name'];
        }

        return $users;
    }

    /**
     * 用户是否登陆（邮箱密码）
     * @return bool
     */
    public function is_login()
    {
        return $this->session->is_login === TRUE;
    }

    /**
     * 用户是否完全登陆（两部认证）
     * @return bool
     */
    public function is_full_login()
    {
        return ($this->session->is_login === TRUE && $this->session->is_full_login === TRUE);
    }

    /**
     * 要求用户登录
     */
    public function require_login()
    {
        if (!$this->is_login()) {
            redirect('login');
        }
    }

    /**
     * 要求用户完全登陆
     */
    public function require_full_login()
    {
        if (!$this->is_full_login()) {
            redirect('login');
        }
    }

    /**
     * 标明当前为系统用户
     */
    public function declare_system()
    {
        $this->system_user = TRUE;
        $this->user_id = $this->config->item('system_uid');
    }
}
