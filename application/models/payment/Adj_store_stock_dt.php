<?php

/**
 * Adj_store_stock_dt Model
 *
 */
class Adj_store_stock_dt extends Abstract_model {

    public $table           = "adj_store_stock_dt";
    public $pkey            = "adj_store_stock_dt_id";
    public $alias           = "";

    public $fields          = array(
                                'adj_store_stock_dt_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'adj_store_stock_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Adj Store Stock ID'),
                                'product_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Product'),                                
                                'store_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Info Penyimpanan'),                                
                                'qty'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Jumlah'),                                
                                'dc'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Debit/Kredit'),                                
                                'basic_price'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Harga Awal'),                                
                                'attr1'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Attribute 1'),                                
                                'attr2'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Attribute 2'),                                
                                'description'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "adj_store_stock_id, 
                                product_id, 
                                store_id, 
                                qty, 
                                dc, 
                                TO_CHAR(created_date, 'dd/mm/yyyy') created_date, 
                                TO_CHAR(update_date, 'dd/mm/yyyy') update_date, 
                                created_by, 
                                update_by, 
                                description, 
                                attr1, 
                                attr2, 
                                adj_store_stock_dt_id, 
                                basic_price,
                                product_name,
                                store,
                                dc_name";

    public $fromClause      = "vw_adj_store_stock_dt";

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