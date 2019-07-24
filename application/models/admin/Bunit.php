<?php

/**
 * Bunit Model
 *
 */
class Bunit extends Abstract_model {

    public $table           = "bunit";
    public $pkey            = "bu_id";
    public $alias           = "";

    public $fields          = array(
                                'bu_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'company_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Perusahaan ID'),                                
                                'name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Nama'),                                
                                'address'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Alamat'),                                
                                'no_telp'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Telphone'),    
                                'no_hp'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Handphone'),    
                                'email'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Email'),    
                                'website'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Website'),    
                                'registration_num'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'No. Registrasi'),    
                                'subtitle'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Subtitle'),   
                                'tax_num'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'NPWP'),    
                                'city'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Kabupaten/Kota'), 
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(select a.*, b.name company_name from bunit a 
                                left join company b on a.company_id=b.company_id)";

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