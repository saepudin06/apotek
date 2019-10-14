<?php defined('BASEPATH') OR exit('No direct script access allowed');


class DownloadFile extends CI_Controller{


    function __construct() {
        parent::__construct();
    }


    function download()
    {
        $path = getVarClean('location', 'str', ''); 
        $this->load->helper('download');
        force_download($path, NULL);
        echo $path;
        exit;
    }

    
}