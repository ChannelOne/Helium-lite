<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->user_model->require_full_login();
    }

    public function index()
    {
        $rendering = [
            'title'   => '首页',
            'sidebar' => $this->helper_model->generate_sidebar('home'),
            'body'    => $this->load->view('home/home', NULL, TRUE)
        ];

        $this->load->view('common/frame', $rendering);
    }
}
