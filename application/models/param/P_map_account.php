<?php

/**
 * P_map_account Model
 *
 */
class P_map_account extends Abstract_model {

    public $table           = "p_map_account";
    public $pkey            = "p_map_account_id";
    public $alias           = "";

    public $fields          = array(
                                'p_map_account_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),                             
                                'acc_num'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'No. Akun'),                                
                                'acc_name'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Nama Akun'),                                
                                'bu_id'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Unit Bisnis'),                                
                                'account_type'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Jenis Akun'),    
                                'acc_desc'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "p_map_account_id,
                                acc_num,
                                acc_name,
                                TO_CHAR(created_date, 'dd/mm/yyyy') created_date,
                                TO_CHAR(update_date, 'dd/mm/yyyy') update_date,
                                created_by,
                                updated_by,
                                bu_id,
                                account_type,
                                account_type_name,
                                acc_desc"; 

    public $fromClause      = "vw_map_account";

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
            $this->record['updated_by'] = $userdata['user_name'];
            $this->record['bu_id'] = $userdata['bu_id'];


            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }
        return true;
    }



}

/* End of file Roles.php */