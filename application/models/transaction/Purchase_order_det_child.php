<?php

/**
 * Purchase_order_det_child Model
 *
 */
class Purchase_order_det_child extends Abstract_model {

    public $table           = "purchase_order_det";
    public $pkey            = "purchase_order_det_id";
    public $alias           = "";

    public $fields          = array();

    public $selectClause    = "*";
    public $fromClause      = "vw_purchase_order_det_child";

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
            
            // $this->record['status_id'] = 1;

            // $this->db->set('exp_date',"to_date('".$this->record['exp_date']."','dd/mm/yyyy')",false);
            // unset($this->record['exp_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            // $this->db->set('exp_date',"to_date('".$this->record['exp_date']."','dd/mm/yyyy')",false);
            // unset($this->record['exp_date']);

        }
        return true;
    }

}

/* End of file Roles.php */