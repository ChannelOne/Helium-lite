<?php

class Privilege_model extends CI_Model
{
    const USER_PRIVILEGE   = 'user';
    const SKUDB_PRIVILEGE  = 'skudb';
    const REPORT_PRIVILEGE = 'report';

    public $user_privilege   = [];
    public $skudb_privilege  = [];
    public $report_privilege = [];

    public function __construct()
    {
        parent::__construct();

        if ($this->session->is_login === TRUE) {
            $this->user_privilege   = $this->session->privilege['user'];
            $this->skudb_privilege  = $this->session->privilege['skudb'];
            $this->report_privilege = $this->session->privilege['report'];
        }
    }

    /**
     * 检查用户是否拥有指定权限
     * @param string|array $privilege
     * @return bool
     */
    public function have_privilege($type, $privilege)
    {
        $current_privilege = $this->get_privilege($type);

        if (in_array('EVERYTHING', $current_privilege)) {
            return TRUE;
        }

        if (is_array($privilege)) {
            foreach ($privilege as $each) {
                if (in_array($each, $current_privilege)) {
                    return TRUE;
                }
            }
        }
        else {
            return in_array($privilege, $current_privilege);
        }

        return FALSE;
    }

    /**
     * 要求用户拥有指定权限
     * @param string|array $privilege
     */
    public function require_privilege($type, $privilege)
    {
        if (!$this->have_privilege($type, $privilege)) {
            echo $this->exceptions->show_error('权限不足', '你当前没有权限使用此功能', 'error_general', 403);
            exit();
        }
    }

    /**
     * 获取指定类型的权限数据
     * @param string $type 
     * @return array|null
     */
    public function get_privilege($type)
    {
        switch($type) {
            case self::USER_PRIVILEGE:
                return $this->user_privilege;
            case self::SKUDB_PRIVILEGE:
                return $this->skudb_privilege;
            case self::REPORT_PRIVILEGE:
                return $this->report_privilege;
            default:
                return [];
        }
    }
}
