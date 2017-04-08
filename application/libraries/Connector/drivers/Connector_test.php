<?php

class Connector_test extends CI_Driver implements Connector_IF
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
            'TEST'  => '测试连接件',
            'TEST1' => '测试连接件1',
            'TEST2' => '测试连接件2',
            'TEST3' => '测试连接件3',
            'TEST4' => '测试连接件4',
            'TEST5' => '测试连接件5',
            'TEST6' => '测试连接件6',
            'TEST7' => '测试连接件7',
            'TEST8' => '测试连接件8',
            'TEST9' => '测试连接件9',
            'TESTA' => '测试连接件A',
            'TESTB' => '测试连接件B',
            'TESTC' => '测试连接件C',
            'TESTD' => '测试连接件D',
            'TESTE' => '测试连接件E',
            'TESTF' => '测试连接件F',
        ];

        return $data;
    }
}
