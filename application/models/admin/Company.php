<?php

/**
 * Company Model
 *
 */
class Company extends Abstract_model {

    public $table           = "company";
    public $pkey            = "company_id";
    public $alias           = "";

    public $fields          = array(
                                'company_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Nama'),                                
                                'address'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Alamat'),                                
                                'no_telp'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Telphone'),    
                                'no_hp'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Handphone'),    
                                'email'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Email'),    
                                'website'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Website'),    
                                'registration_num'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'No. Registrasi'),    
                                'subtitle'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Subtitle'),    
                                'logo'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Logo'),    
                                'tax_num'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tax NPWP'),    
                                'city'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Kabupaten/Kota'),    
                                'since_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tanggal Didirikan'),    
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "company_id, name, address, no_telp, no_hp, email, website, registration_num, subtitle, logo, tax_num, city, created_date, update_date, created_by, update_by, to_char(since_date, 'dd/mm/yyyy') since_date";
    public $fromClause      = "company";

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

            $this->db->set('since_date',"to_date('".$this->record['since_date']."','dd/mm/yyyy')",false);
            unset($this->record['since_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('since_date',"to_date('".$this->record['since_date']."','dd/mm/yyyy')",false);
            unset($this->record['since_date']);

        }
        return true;
    }



}

/* End of file Roles.php */