<?php

/**
 * Purchase_order Model
 *
 */
class Purchase_order extends Abstract_model {

    public $table           = "purchase_order";
    public $pkey            = "purchase_order_id";
    public $alias           = "";

    public $fields          = array(
                                'purchase_order_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Purchase Order ID'),
                                'purchase_request_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Rencana Pembelian'),
                                'code'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Kode PO'),
                                'po_date'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Tanggal Pembelian'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "purchase_order_id,
                               purchase_request_id,
                               code,
                               pr_code,
                               bu_name,
                               TO_CHAR (po_date, 'dd/mm/yyyy') po_date,
                               TO_CHAR (created_date, 'dd/mm/yyyy') created_date, 
                               TO_CHAR (update_date, 'dd/mm/yyyy') update_date, 
                               update_by, 
                               created_by,
                               amount,
                               status_grn";
    public $fromClause      = "vw_po_info";

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

            $this->db->set('due_date_payment',"to_date('".$this->record['due_date_payment']."','dd/mm/yyyy')",false);
            unset($this->record['due_date_payment']);

            $this->db->set('po_date',"to_date('".$this->record['po_date']."','dd/mm/yyyy')",false);
            unset($this->record['po_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('due_date_payment',"to_date('".$this->record['due_date_payment']."','dd/mm/yyyy')",false);
            unset($this->record['due_date_payment']);

            $this->db->set('po_date',"to_date('".$this->record['po_date']."','dd/mm/yyyy')",false);
            unset($this->record['po_date']);
        }
        return true;
    }



}

/* End of file Roles.php */