<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * 分发渲染页面
     */
    public function index()
    {
        if ($this->user_model->is_full_login()) {
            redirect('home');
        }
        else if ($this->user_model->is_login()) {
            $this->_second_phase();
        }
        else {
            $this->_first_phase();
        }
    }

    /**
     * 分发处理页面
     */
    public function process()
    {
        if ($this->input->post('phase') === '1') {
            $this->_first_phase_process();
        }
        else if ($this->input->post('phase') === '2') {
            $this->_second_phase_process();
        }
        else {
            redirect('login');
        }
    }

    /**
     * 登出
     */
    public function logout()
    {
        $this->login_model->logout();
        redirect('login');
    }

    /**
     * 渲染登陆第一步
     */
    public function _first_phase()
    {
        $this->load->view('login/login_first');
    }

    /**
     * 渲染登陆第二步
     */
    public function _second_phase()
    {
        $this->load->view('login/login_second');
    }

    /**
     * 处理登陆第一步
     * @throws Exception
     */
    public function _first_phase_process()
    {
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));

        try {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
                throw new Exception('邮箱无效');
            }

            if (preg_match('/^[a-zA-Z0-9!@#$%&*+\-]{6,32}$/', $password) === 0) {
                throw new Exception('密码错误');
            }

            $this->login_model->login_first_phase($email, $password);
            redirect('login');
        }
        catch (Exception $e) {
            $this->session->error_msg = $e->getMessage();
            redirect('login');
        }
    }

    /**
     * 处理登陆第二步
     * @throws Exception
     */
    public function _second_phase_process()
    {
        $token = trim($this->input->post('token'));

        try {
            if (preg_match('/^\d{6}$/', $token) === 0) {
                throw new Exception('两步认证失败');
            }

            $this->login_model->login_second_phase($token);
            redirect('home');
        }
        catch (Exception $e) {
            $this->session->error_msg = $e->getMessage();
            redirect('login');
        }
    }
}
