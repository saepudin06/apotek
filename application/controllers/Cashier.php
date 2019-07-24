<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view('cashier/index');
    }

}