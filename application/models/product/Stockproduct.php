<?php

/**
 * Stockproduct Model
 *
 */
class Stockproduct extends Abstract_model {

    public $table           = "stockproduct";
    public $pkey            = "stock_product_id";
    public $alias           = "";

    public $fields          = array();

    public $selectClause    = "stock_product_id, 
                               product_id, 
                               totalqty, 
                               description, 
                               to_char(created_date, 'dd/mm/yyyy') created_date, 
                               to_char(update_date, 'dd/mm/yyyy') update_date, 
                               update_by, 
                               created_by, 
                               store_info_id, 
                               s_in, 
                               s_out,
                               product_name, 
                               store_info";
    public $fromClause      = "vw_stockproduct";

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