<?php

class Price_rule_model extends CI_Model
{
    public function list_rule($limit = 50, $offset = 0)
    {
        $total = $this->db_count();

        if ($offset > $total) {
            $offset = floor($total / $limit) + ($total % $limit);
        }

        $query = $this->db->select()->from('price_rule')->order_by('id', 'ASC')->limit($limit, $offset)->get();
        return $query->result_array();
    }

    /**
     * 获取指定的动态定价
     * @param mixed $software_id 
     * @param mixed $dynamic_rule 
     * @return array
     */
    public function get_price($software_id, $dynamic_rule = NULL)
    {
        return [];
    }

    public function get_rule($dynamic_rule)
    {

    }

    public function add_rule($data)
    {


    }

    public function edit_rule()
    {


    }

    /**
     * 查询数据库中共有多少条记录
     * @return int
     */
    public function db_count()
    {
        $query = $this->db->select('count(`id`) as `count`')->from('price_info')->get();
        return $query->first_row('array')['count'];
    }
}
