<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| PATHS
| -------------------------------------------------------------------
|
*/
$ci = & get_instance();
$ci->load->helper('url');

$config['WS_JQGRID'] = define('WS_JQGRID',base_url().'ws/json_jqgrid/');
$config['WS_BOOTGRID'] = define('WS_BOOTGRID',base_url().'ws/json/');
$config['WS_URL'] = define('WS_URL',base_url().'ws/json/');
/* End of file autoload.php */
/* Location: ./application/config/paths.php */