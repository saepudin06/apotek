<?php

/**
 * Stockproductdetails Model
 *
 */
class Stockproductdetails extends Abstract_model {

    public $table           = "stockproductdetails";
    public $pkey            = "stockproductdetails_id";
    public $alias           = "";

    public $fields          = array();

    public $selectClause    = "stockproductdetails_id, 
                               product_id, 
                               qty, 
                               d_c, 
                               to_char(created_date, 'dd/mm/yyyy') created_date, 
                               to_char(update_date, 'dd/mm/yyyy') update_date, 
                               created_by, 
                               update_by, 
                               trx_type, 
                               trx_source, 
                               stock_product_id, 
                               to_char(exp_date, 'dd/mm/yyyy') exp_date, 
                               description,
                               product_name,
                               trx_type_name,
                               dc_name";
    public $fromClause      = "vw_stockproductdetails";

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
            
            $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

        }
        return true;
    }



}

/* End of file Roles.php */