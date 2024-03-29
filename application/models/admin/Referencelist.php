<?php

/**
 * Referencelist Model
 *
 */
class Referencelist extends Abstract_model {

    public $table           = "referencelist";
    public $pkey            = "reference_list_id";
    public $alias           = "";

    public $fields          = array(
                                'reference_list_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'reference_type_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Tipe Referensi ID'),
                                'name'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Nama Referensi'),                                
                                'val_1'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Nilai 1'),                                
                                'val_2'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Nilai 2'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "reference_list_id, reference_type_id, reference_type_code, name, val_1, val_2, created_date, created_by, update_date, update_by";
    public $fromClause      = "(select a.*, b.code reference_type_code 
                                from referencelist a
                                left join referencetype b on a.reference_type_id=b.reference_type_id)";

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

    public function getReferenceList($ref_type_id)
    {
        $this->db->order_by("reference_list_id", "asc");
        $this->db->where('reference_type_id', $ref_type_id);
        $q = $this->db->get('referencelist');
        return $q->result_array();
    }

}

/* End of file Roles.php */