<?php

/**
 * Storeinfo Model
 *
 */
class Storeinfo extends Abstract_model {

    public $table           = "storeinfo";
    public $pkey            = "store_info_id";
    public $alias           = "";

    public $fields          = array(
                                'store_info_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Store Info ID'),
                                'store_type_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Store Type ID'),
                                'name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Name'),                                
                                'code'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Code'),                                
                                'description'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "store_info_id, store_type_id, store_type_name, name, code, description, created_date, created_by, update_date, update_by";
    public $fromClause      = "(select a.*, b.name store_type_name 
                                from storeinfo a
                                left join storetype b on a.store_type_id=b.store_type_id)";

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