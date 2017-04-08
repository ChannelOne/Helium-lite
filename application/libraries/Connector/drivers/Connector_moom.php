<?php

class Connector_moom extends CI_Driver implements Connector_IF
{
    public function format_raw_licence($licences)
    {
        $licence_regex = '/^[A-Za-z0-9-]+$/';

        if (preg_match($licence_regex, $licences) === 0) {
            throw new Exception('序列号格式错误');
        }

        $data = [
            'key' => $licences
        ];

        return $data;
    }

    public function pre_process()
    {
        // Do nothing
    }

    public function process()
    {

    }

    public function generate_email()
    {

    }

    public function software_id_binding()
    {
        $data = [
            'MOOM' => 'Moom'
        ];

        return $data;
    }
}
