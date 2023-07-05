<?php
class Custom_log extends CI_Log {

    public function __construct() {
        parent::__construct();
        // die("payeezzy");
        $config =& get_config();

        $log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH.'logs/';

        $new_log_file = $log_path . 'custom_';

        $this->_log_path = $new_log_file;
        $this->_enabled = TRUE;
        $this->_threshold = isset($config['log_threshold']) ? $config['log_threshold'] : 4;
        $this->_date_fmt = isset($config['log_date_format']) ? $config['log_date_format'] : 'Y-m-d H:i:s';
        // $this->_file_ext = isset($config['log_file_extension']) ? ltrim($config['log_file_extension'], '.') : 'php';
    }
}


?>