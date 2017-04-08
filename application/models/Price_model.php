<?php

/**
 * Price_model short summary.
 *
 * Price_model description.
 *
 * @version 1.0
 * @author Bosheng
 */
class Price_model extends CI_Model
{
    public function get_price($software_id, $dynamic_rule = NULL)
    {
        $basic_price = $this->price_basic_model->get_price($software_id);
        $dynamic_rule = $this->price_rule_model->get_price($software_id, $dynamic_rule);

        $price_data = [
            'base_cost' => $basic_price['price'] ?? 0,
            'cost'      => $basic_price['price'] ?? 0,
            'currency'  => $basic_price['currency'] ?? 'CNY',
            'min_sale'  => $basic_price['min_sale'] ?? 0
        ];

        if ( ! empty($dynamic_rule)) {
            $price_data['override_rule_id'] = $dynamic_rule['id'];
            $price_data['override_cost']    = $dynamic_rule['cost'];
            $price_data['cost']             = $dynamic_rule['cost'];
            $price_data['min_sale']         = $dynamic_rule['min_sale'];
        }

        return $price_data;
    }
}