<?php

class Price_basic_model extends CI_Model
{
    public function list_price($limit = 50, $offset = 0)
    {
        $total = $this->db_count();

        if ($offset > $total) {
            $offset = floor($total / $limit) + ($total % $limit);
        }

        $query = $this->db->select()->from('price_info')->order_by('id', 'ASC')->limit($limit, $offset)->get();
        return $query->result_array();
    }

    public function get_price($software_id)
    {
        if (is_array($software_id)) {
            $query = $this->db->select()->from('price_info')->where_in('software_id', $software_id)->get();
            return $query->result_array();
        }
        else {
            $query = $this->db->select()->from('price_info')->where('software_id', $software_id)->limit(1)->get();
            return $query->first_row('array') ?? NULL;
        }
    }

    public function edit_price($software_id, $data)
    {
        if (empty($this->get_price($software_id))) {
            $query = $this->db->insert('price_info', $data);
        }
        else {
            $query = $this->db->where('software_id', $software_id)->update('price_info', $data);
        }

        if (!$query) {
            throw new Exception($this->db->error()['message']);
        }
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
