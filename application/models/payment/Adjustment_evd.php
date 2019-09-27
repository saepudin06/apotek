<?php

/**
 * Adjustment_evd Model
 *
 */
class Adjustment_evd extends Abstract_model {

    public $table           = "adjustment_evd";
    public $pkey            = "adj_evd_id";
    public $alias           = "";

    public $fields          = array(
                                'adj_evd_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'adj_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Adj ID'),
                                'path_file'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Upload'),                                                          
                                'description'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "adj_evd_id, 
                                adj_id, 
                                TO_CHAR(created_date, 'dd/mm/yyyy') created_date, 
                                TO_CHAR(update_date, 'dd/mm/yyyy') update_date, 
                                created_by, 
                                update_by, 
                                description, 
                                path_file";

    public $fromClause      = "adjustment_evd";

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