<?php

/**
 * Purchase_request Model
 *
 */
class Purchase_request extends Abstract_model {

    public $table           = "purchase_request";
    public $pkey            = "purchase_request_id";
    public $alias           = "";

    public $fields          = array(
                                'purchase_request_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Purchase Request ID'),
                                'code'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Code'),
                                'amount'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Amount'),
                                'pr_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Date'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "purchase_request_id, code, amount, to_char(pr_date, 'dd/mm/yyyy') pr_date, created_date, created_by, update_date, update_by";
    public $fromClause      = "purchase_request";

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
            
            $this->record['amount'] = 0;

            $this->db->set('pr_date',"to_date('".$this->record['pr_date']."','dd/mm/yyyy')",false);
            unset($this->record['pr_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('pr_date',"to_date('".$this->record['pr_date']."','dd/mm/yyyy')",false);
            unset($this->record['pr_date']);
        }
        return true;
    }



}

/* End of file Roles.php */