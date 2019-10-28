<?php

/**
 * Adjusment Model
 *
 */
class Adjusment extends Abstract_model {

    public $table           = "adjusment";
    public $pkey            = "adj_id";
    public $alias           = "";

    public $fields          = array(
                                'adj_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),                             
                                'd_c'   => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Debit/Kredit'),                                
                                'amount'   => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Total'),                                
                                'bu_id'   => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Unit Bisnis'),                                
                                'p_map_account_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'No. Akun atau Nama Akun'),     
                                'status'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status'),    
                                'adj_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tanggal'),    
                                'description'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "adj_id,
                                d_c,
                                acc_num,
                                TO_CHAR(created_date, 'dd/mm/yyyy') created_date,
                                TO_CHAR(update_date, 'dd/mm/yyyy') update_date,
                                created_by,
                                update_by,
                                description,
                                bu_id,
                                status,
                                amount,
                                TO_CHAR(adj_date, 'dd/mm/yyyy') adj_date,
                                p_map_account_id,
                                bu_name,
                                acc_name"; 

    public $fromClause      = "vw_adjusment";

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

            $this->record['bu_id'] = $userdata['bu_id'];
            $this->record['status'] = 'INITIAL';

            $this->db->set('adj_date',"to_date('".$this->record['adj_date']."','dd/mm/yyyy')",false);
            unset($this->record['adj_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:

            $this->db->set('adj_date',"to_date('".$this->record['adj_date']."','dd/mm/yyyy')",false);
            unset($this->record['adj_date']);
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

        }
        return true;
    }



}

/* End of file Roles.php */