<?php

/**
 * Products Model
 *
 */
class Products extends Abstract_model {

    public $table           = "products";
    public $pkey            = "product_id";
    public $alias           = "";

    public $fields          = array(
                                'product_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Product ID'),
                                'product_type_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Jenis Produk'),                                
                                'bu_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Unit Bisnis'),                                
                                'measure_type_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Ukuran'),                                
                                'package_type_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Satuan'),                                
                                'name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Nama'),     
                                'stock_min'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Min. Stok'),    
                                'initial_stock'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Stok Awal'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "vw_info_product";

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