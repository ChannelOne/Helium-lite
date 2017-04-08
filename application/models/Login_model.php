<?php

class Login_model extends CI_Model
{
    /**
     * 登陆第一步：用户名密码登陆
     * @param string $email
     * @param string $password
     * @throws Exception
     */
    public function login_first_phase($email, $password)
    {
        // 获取用户信息
        $query = $this->db->select()->from('user')->where(['email' => $email])->limit(1)->get();
        $user = $query->row_array();

        // E:用户不存在
        if (empty($user)) {
            throw new Exception('用户不存在');
        }

        // E:用户被禁用
        if ((int)$user['disabled'] === 1) {
            throw new Exception('用户已禁用');
        }

        // E:密码验证失败
        if (!password_verify($password, $user['password'])) {
            throw new Exception('密码错误');
        }

        // 更新最后登陆时间
        $last_login_data = [
            'last_login_date' => time(),
            'last_login_ip'   => $this->input->ip_address()
        ];

        $result = $this->db->update('user', $last_login_data, ['user_id' => $user['user_id']]);

        if (!$result) {
            throw new Exception('系统内部错误');
        }

        $user_group_id   = (int)$user['user_group']   ?? $this->config->item('default_user_group');
        $skudb_group_id  = (int)$user['skudb_group']  ?? $this->config->item('default_skudb_group');
        $report_group_id = (int)$user['report_group'] ?? $this->config->item('default_report_group');

        // 获取用户组信息
        $query = $this->db->select()->from('privilege_group')->where(['type' => Privilege_model::USER_PRIVILEGE])->where(['id' => $user_group_id])->limit(1)->get();
        $user_group = $query->row_array();

        // E:用户组不存在
        if (empty($user_group)) {
            throw new Exception('用户组不存在');
        }

        // 用户组权限信息
        $user_group_privilege = explode(',', $user_group['privilege']);

        // 获取SKUDB组信息
        $query = $this->db->select()->from('privilege_group')->where(['type' => Privilege_model::SKUDB_PRIVILEGE])->where(['id' => $skudb_group_id])->limit(1)->get();
        $skudb_group = $query->row_array();
        $skudb_group_privilege = empty($skudb_group) ? [] : explode(',', $skudb_group['privilege']);

        // 获取REPORT组信息
        $query = $this->db->select()->from('privilege_group')->where(['type' => Privilege_model::REPORT_PRIVILEGE])->where(['id' => $report_group_id])->limit(1)->get();
        $report_group = $query->row_array();
        $report_group_privilege = empty($report_group) ? [] : explode(',', $report_group['privilege']);
   
        // 汇总权限信息
        $all_privilege = [
            'user'   => $user_group_privilege,
            'skudb'  => $skudb_group_privilege,
            'report' => $report_group_privilege
        ];

        // 设置session
        $this->session->is_login     = TRUE;
        $this->session->user         = $user;
        $this->session->privilege    = $all_privilege;
        $this->session->login_expire = time() + $this->config->item('login_timeout');
    }

    /**
     * 登陆第二部：两部认证登陆
     * @param string $token
     * @throws Exception
     */
    public function login_second_phase($token)
    {
        //TODO: DEV ENV
        if (ENVIRONMENT === 'development') {
            $this->session->is_full_login = TRUE;
            return;
        }

        // 加载两部认证模块
        $this->load->library('GoogleAuthenticator', NULL, 'tfa');

        // 从session中获取两部认证secret
        $secret = $this->session->user['tfa_secret'] ?? NULL;

        // E:Secret不存在
        if (empty($secret)) {
            throw new Exception('两步认证信息不存在');
        }

        // E:两步认证失败
        if (!$this->tfa->verifyCode($secret, $token)) {
            throw new Exception('两步认证失败');
        }

        // 设置session
        $this->session->is_full_login = TRUE;
    }

    /**
     * 登出
     * @param bool $is_timeout 是否登陆超时
     */
    public function logout($is_timeout = FALSE)
    {
        $this->session->is_login      = FALSE;
        $this->session->is_full_login = FALSE;
        $this->session->user          = NULL;
        $this->session->privilege     = NULL;
        $this->session->login_expire  = NULL;

        if ($is_timeout) {
            $this->session->error_msg ='登陆超时';
        }
        else {
            $this->session->info_msg = '成功登出';
        }
    }
}