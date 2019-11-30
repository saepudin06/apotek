<?php

/**
 * Purchase_order_det Model
 *
 */
class Purchase_order_det extends Abstract_model {

    public $table           = "purchase_order_det";
    public $pkey            = "purchase_order_det_id";
    public $alias           = "";

    public $fields          = array(
                                'purchase_order_det_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Purchase Order Det ID'),
                                'purchase_req_det_id'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Detail Rencana Pembelian'),
                                'purchase_order_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Pembelian'),
                                'qty'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Jumlah'),
                                'basic_price'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Harga Awal'),
                                'amount'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Total'),
                                'supplier_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Supplier'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "vw_po_info_details";

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