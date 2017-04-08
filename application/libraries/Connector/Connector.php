<?php

class Connector extends CI_Driver_Library
{
    protected $_adapter = 'manually';
    protected $_default_adapter = 'manually';

    public $connector_db = [];

    public function __construct()
    {
        // 加载可用 driver 缓存
        $drivers_cache_file = APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'connector_drivers.json';

        if (file_exists($drivers_cache_file)) {
            $drivers_data = file_get_contents($drivers_cache_file);
            $this->valid_drivers = json_decode($drivers_data, TRUE);
        }
        else {
            $this->build_driver_cache();
        }

        // 加载 conenctor db 缓存
        $connector_cache_file = APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'connector_db.json';

        if (file_exists($connector_cache_file)) {
            $connector_data = file_get_contents($connector_cache_file);
            $this->connector_db = json_decode($connector_data, TRUE);
        }
        else {
            $this->build_db_cache();
        }
    }

    /**
     * 检测是否正确的Software ID
     * @param string $software_id
     * @return bool
     */
    public function is_valid_software_id($software_id)
    {
        return array_key_exists($software_id, $this->connector_db);
    }

    /**
     * 切换连接件 (通过software_id)
     * @param string $software_id
     * @throws Exception
     */
    public function switch_by_software_id($software_id)
    {
        if ( ! $this->is_valid_software_id($software_id)) {
            throw new Exception('软件连接件选择错误');
        }

        $this->switch_by_driver_name($this->connector_db[$software_id]['driver']);
    }

    /**
     * 切换连接件 (通过driver name)
     * @param string $driver
     * @throws Exception
     */
    public function switch_by_driver_name($driver)
    {
        if ( ! in_array($driver, $this->valid_drivers)) {
            throw new Exception('软件连接件选择错误');
        }

        $this->_adapter = $driver;
    }

    /**
     * 返回软件定义信息
     * @param string $software_id
     * @throws Exception
     * @return array
     */
    public function get_software_define($software_id)
    {
        if ( ! $this->is_valid_software_id($software_id)) {
            throw new Exception('未知的软件ID');
        }

        $software_define_file = APPPATH . 'storage' . DIRECTORY_SEPARATOR . 'software_define' . DIRECTORY_SEPARATOR . strtolower($software_id) . '.json';

        if (!file_exists($software_define_file)) {
            throw new Exception('软件定义不存在');
        }

        $software_define = file_get_contents($software_define_file);
        $software_define_array = json_decode($software_define, TRUE);

        return $software_define_array;
    }

    #region 重载函数
    /**
     * 格式化文本序列号
     * @param string $licence
     * @throws Exception
     * @return array
     */
    public function format_raw_licence($licence)
    {
        return $this->{$this->_adapter}->format_raw_licence($licence);
    }

    /**
     * 预处理订单
     * @throws Exception
     * @return bool 是否执行了处理操作
     */
    public function pre_process()
    {
        $CI = &get_instance();

        if (!$CI->oc->loaded()) {
            throw new Exception('未加载订单');
        }

        return $this->{$this->_adapter}->pre_process();
    }

    /**
     * 处理订单
     * @throws Exception
     * @return bool 是否执行了处理操作
     */
    public function process()
    {
        $CI = &get_instance();

        if (!$CI->oc->loaded()) {
            throw new Exception('未加载订单');
        }

        return $this->{$this->_adapter}->process();
    }

    /**
     * 生成邮件
     * @throws Exception
     * @return array
     */
    public function generate_email()
    {
        $CI = &get_instance();

        if (!$CI->oc->loaded()) {
            throw new Exception('未加载订单');
        }

        return $this->{$this->_adapter}->generate_email();
    }

    /**
     * 获取连接件绑定的软件ID
     * @return array
     */
    public function software_id_binding()
    {
        return $this->{$this->_adapter}->software_id_binding();
    }
    #endregion

    #region 构建缓存
    /**
     * 构建可用driver列表
     * @return integer
     */
    public function build_driver_cache()
    {
        $CI = &get_instance();

        $cache_file = APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'connector_drivers.json';

        $total = 0;
        $this->valid_drivers = [];

        $driver_path = __DIR__ . DIRECTORY_SEPARATOR . 'drivers' . DIRECTORY_SEPARATOR;
        $driver_file_list = new DirectoryIterator($driver_path);
        $driver_name_regex = '/^Connector_([a-zA-Z0-9_-]+)$/';

        foreach ($driver_file_list as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }

            if (preg_match($driver_name_regex, $file->getBasename('.php'), $matches) > 0) {
                $this->valid_drivers[] = $matches[1];
                $total++;
            }
        }

        file_put_contents($cache_file, json_encode($this->valid_drivers));
        return $total;
    }

    /**
     * 构建connector数据库 (用于映射从software_id到connector)
     * @return integer
     */
    public function build_db_cache()
    {
        $CI = &get_instance();

        $cache_file = APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'connector_db.json';

        $total = 0;
        $this->connector_db = [];

        foreach ($this->valid_drivers as $driver)
        {
            // 切换到指定连接件
            $this->switch_by_driver_name($driver);

            // 获取当前连接件的 software id 绑定信息
            $binding = $this->software_id_binding();

            foreach ($binding as $software_id => $software_name)
            {
                $this->connector_db[$software_id] = [
                    'software_id' => $software_id,
                    'driver'      => $driver,
                    'name'        => $software_name
                ];
                $total++;
            }
        }

        // 按 software_id 排序
        ksort($this->connector_db);

        file_put_contents($cache_file, json_encode($this->connector_db, JSON_PRETTY_PRINT));
        return $total;
    }

    /**
     * 获取cache原始文件内容
     * @param string $type 
     * @return string
     */
    public function get_raw_cache($type = 'driver')
    {
        switch ($type) {
            case 'driver':
                return file_get_contents(APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'connector_drivers.json');
            case 'db':
                return file_get_contents(APPPATH . 'cache' . DIRECTORY_SEPARATOR . 'connector_db.json');
            default:
                return json_encode([]);
        }
    }
    #endregion
}

interface Connector_IF
{
    /**
     * 格式化文本序列号
     * @param string $licence
     * @throws Exception
     * @return array
     */
    public function format_raw_licence($licences);

    /**
     * 预处理订单
     * @throws Exception
     * @return bool
     */
    public function pre_process();

    /**
     * 处理订单
     * @throws Exception
     * @return bool
     */
    public function process();

    /**
     * 生成邮件
     * @throws Exception
     * @return array
     */
    public function generate_email();

    /**
     * 获取连接件绑定的软件ID
     * @return array
     */
    public function software_id_binding();
}
