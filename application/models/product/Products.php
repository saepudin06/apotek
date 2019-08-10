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
    public $fromClause      = "(select a.product_id, 
                                        a.product_type_id, 
                                        a.bu_id, 
                                        a.measure_type_id, 
                                        a.package_type_id, 
                                        a.name, 
                                        a.stock_min, 
                                        a.initial_stock, 
                                        a.created_date, 
                                        a.update_date, 
                                        a.update_by, 
                                        a.created_by, 
                                        b.name product_type_name,
                                        c.name bu_name,
                                        d.name measure_type_name,
                                        e.name package_type_name
                                from products a 
                                left join producttype b on a.product_type_id=b.product_type_id
                                left join bunit c on a.bu_id=c.bu_id
                                left join productmeasurement d on a.measure_type_id=d.measure_type_id
                                left join productpackagetype e on a.package_type_id= e.package_type_id)";

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