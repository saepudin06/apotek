<?php

/**
 * Role_menus Model
 *
 */
class Role_menus extends Abstract_model {

    public $table           = "role_menus";
    public $pkey            = "";
    public $alias           = "";

    public $fields          = array(
                                'role_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Role'),
                                'sub_menu_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Menu'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "role_menus";

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

          
        }else {
            //do something
            //example:
            

        }
        return true;
    }

    public function deleteItem($role_id) {
        $sql = "delete from role_menus where role_id = ?";
        $this->db->query($sql, array($role_id));

    }


}

/* End of file Roles.php */