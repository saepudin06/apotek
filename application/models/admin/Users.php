<?php

/**
 * Users Model
 *
 */
class Users extends Abstract_model {

    public $table           = "users";
    public $pkey            = "user_id";
    public $alias           = "a";

    public $fields          = array(
                                'user_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => ' ID'),
                                'user_name'    => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Username'),
                                'user_full_name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Fullname'),
                                'user_email'      => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'E-mail'),
                                'user_password'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Password'),
                                'user_status'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Status'),
                                'role_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Role'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "a.user_id,
                                 a.user_name,
                                 a.user_full_name,
                                 a.user_email,
                                 a.user_password,
                                 a.user_status,
                                 a.created_by,
                                 a.created_date,
                                 a.updated_by,
                                 a.updated_date,
                                 a.role_id,
                                 b.role_name,
                                 CASE nvl(a.user_status,'0') WHEN '0' THEN 'Not Active'
                                                                WHEN '1' THEN 'Active'
                                                            END as status_active";
    public $fromClause      = "users a
                               left join roles b on a.role_id = b.role_id";

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

            $this->db->set('user_status','1', true);
            $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

            if (isset($this->record['user_password'])){
                if (trim($this->record['user_password']) == '') throw new Exception('Password Field is Empty');
                if (strlen($this->record['user_password']) < 6) throw new Exception('Mininum password length is 6 characters');
                $this->record['user_password'] = md5($this->record['user_password']);
            }

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else if($this->actionType == 'UPDATE_PWD'){
            
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }else{
            //do something
            //example:
            
            unset($this->record['user_password']);
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }
        return true;
    }



}

/* End of file Users.php */