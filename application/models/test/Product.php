<?php

/**
 * Product Model
 *
 */
class Product extends Abstract_model {

    public $table           = "product_test";
    public $pkey            = "product_id";
    public $alias           = "";

    public $fields          = array(
                                'product_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Product ID'),
                                'product_code'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Code'),
                                'product_name'      => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Name'),
                                'product_price'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Price'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "product_test";

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
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }
        return true;
    }

}

/* End of file Menus.php */