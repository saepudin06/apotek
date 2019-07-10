<?php

/**
 * Purchase_req_det Model
 *
 */
class Purchase_req_det extends Abstract_model {

    public $table           = "purchase_req_det";
    public $pkey            = "purchase_req_det_id";
    public $alias           = "";

    public $fields          = array(
                                'purchase_req_det_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Purchase Request Det ID'),
                                'purchase_request_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Purchase Request ID'),
                                'product_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product ID'),
                                'basic_price'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Basic Price'),
                                'amount'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Amount'),
                                'qty'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Qty'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(select a.*, b.name product_name
                                from purchase_req_det a
                                left join products b on a.product_id=b.product_id)";

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