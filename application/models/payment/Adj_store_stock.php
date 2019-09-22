<?php

/**
 * Adj_store_stock Model
 *
 */
class Adj_store_stock extends Abstract_model {

    public $table           = "adj_store_stock";
    public $pkey            = "adj_store_stock_id";
    public $alias           = "";

    public $fields          = array(
                                'adj_store_stock_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'adj_type_id'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Jenis Adjustment'),                                
                                'supplier_id'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Supplier'),                                
                                'bu_id_dest'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Unit Bisnis(Tujuan)'),                                
                                'invoice_num_ref'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'No. Referensi'),    
                                'payment_status'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status Pembayaran'),    
                                'status'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status'),    
                                'due_dat_payment'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Tgl. Jatuh Tempo'),    
                                'description'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "adj_store_stock_id, 
                                TO_CHAR(created_date, 'dd/mm/yyyy') created_date, 
                                TO_CHAR(update_date, 'dd/mm/yyyy') update_date, 
                                created_by, 
                                update_by, 
                                description, 
                                adj_type_id, 
                                supplier_id, 
                                bu_id_dest, 
                                status, 
                                TO_CHAR(due_dat_payment, 'dd/mm/yyyy') due_dat_payment, 
                                invoice_num_ref, 
                                payment_status,
                                supplier_name,
                                bu_name,
                                adj_type_name";

    public $fromClause      = "vw_adj_store_stock";

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

            $this->record['status'] = 'INITIAL';

            $this->db->set('due_dat_payment',"to_date('".$this->record['due_dat_payment']."','dd/mm/yyyy')",false);
            unset($this->record['due_dat_payment']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:

            $this->db->set('due_dat_payment',"to_date('".$this->record['due_dat_payment']."','dd/mm/yyyy')",false);
            unset($this->record['due_dat_payment']);
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

        }
        return true;
    }



}

/* End of file Roles.php */