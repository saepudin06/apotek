<?php

/**
 * Cashier Model
 *
 */
class Cashier extends Abstract_model {

    public $table           = "transactionorder_dt";
    public $pkey            = "transactionorder_dt_id";
    public $alias           = "";

    public $fields          = array();

    public $selectClause    = "*";
    public $fromClause      = "transactionorder_dt";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
        }
        return true;
    }



}

/* End of file Roles.php */