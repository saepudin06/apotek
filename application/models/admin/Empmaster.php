<?php

/**
 * Empmaster Model
 *
 */
class Empmaster extends Abstract_model {

    public $table           = "empmaster";
    public $pkey            = "emp_id";
    public $alias           = "";

    public $fields          = array(
                                'emp_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Bussiness Unit ID'),
                                'bu_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Bussiness Unit ID'),                                
                                'name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Name'),                                
                                'address'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Address'),                                
                                'no_telp'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Telphone'),    
                                'no_hp'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Handphone'),    
                                'tax_no'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tax No.'),    
                                'no_ktp'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'NIK'),    
                                'birthdate'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Birthdate'),    
                                'placeofbirth'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Place of Birth'),   
                                'emergency_contact'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Emergency Contact'),    
                                'address_emrgncy'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Address Emrgncy'),    
                                'name_emrgency'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Name Emrgency'), 
                                'status'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Status?'), 
                                'production_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Production Date'), 
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(select a.emp_id, 
                                        a.bu_id, 
                                        a.name, 
                                        a.no_telp, 
                                        a.no_hp, 
                                        a.address, 
                                        a.no_ktp, 
                                        a.tax_no, 
                                        to_char(a.birthdate, 'dd/mm/yyyy') birthdate, 
                                        a.placeofbirth, 
                                        a.emergency_contact, 
                                        a.address_emrgncy, 
                                        a.name_emrgency, 
                                        a.created_date, 
                                        a.update_date, 
                                        a.update_by, 
                                        a.created_by, 
                                        a.status, 
                                        to_char(a.production_date, 'dd/mm/yyyy') production_date, 
                                        b.name bu_name, 
                                        decode(a.status, 1, 'Active', 'Not Active') status_name 
                                from empmaster a 
                                left join bunit b on a.bu_id=b.bu_id)";

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

            $this->db->set('production_date',"to_date('".$this->record['production_date']."','dd/mm/yyyy')",false);
            unset($this->record['production_date']);

            $this->db->set('birthdate',"to_date('".$this->record['birthdate']."','dd/mm/yyyy')",false);
            unset($this->record['birthdate']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('production_date',"to_date('".$this->record['production_date']."','dd/mm/yyyy')",false);
            unset($this->record['production_date']);

            $this->db->set('birthdate',"to_date('".$this->record['birthdate']."','dd/mm/yyyy')",false);
            unset($this->record['birthdate']);

        }
        return true;
    }



}

/* End of file Roles.php */