<?php

/**
 * Supplier Model
 *
 */
class Supplier extends Abstract_model {

    public $table           = "supplier";
    public $pkey            = "supplier_id";
    public $alias           = "";

    public $fields          = array(
                                'supplier_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Supplier ID'),
                                'supplier_type_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Supplier Type ID'),
                                'name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Name'),                                
                                'address'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Address'),                                
                                'no_telp'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Telphone'),    
                                'no_hp'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Handphone'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(select a.*, b.name supplier_type_name from supplier a
                               left join suppliertype b on a.supplier_type_id=b.supplier_type_id)";

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