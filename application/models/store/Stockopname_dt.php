<?php

/**
 * Stockopname_dt Model
 *
 */
class Stockopname_dt extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";   

    public $fields          = array();

    public $selectClause    = "*";

    public $fromClause      = "vw_stockopname_dt";

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
            
           /* $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];
            
            $this->record['amount'] = 0;
            $this->record['qty'] = 0;


            $this->db->set('grn_date',"to_date('".$this->record['grn_date']."','dd/mm/yyyy')",false);
            unset($this->record['grn_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);
            */
          
        }else {
            //do something
            //example:
            
            /*$this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('grn_date',"to_date('".$this->record['grn_date']."','dd/mm/yyyy')",false);
            unset($this->record['grn_date']);*/
        }
        return true;
    }



}

/* End of file Roles.php */