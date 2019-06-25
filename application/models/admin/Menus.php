<?php

/**
 * Menus Model
 *
 */
class Menus extends Abstract_model {

    public $table           = "menus";
    public $pkey            = "menu_id";
    public $alias           = "";

    public $fields          = array(
                                'menu_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Menu ID'),
                                'menu_title'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Menu'),
                                'menu_url'      => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Url'),
                                'menu_icon'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Icon'),
                                'menu_order'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Listing No'),
                                'menu_description'     => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "menus";

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
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }
        return true;
    }

    public function getMenu()
    {
        $this->db->order_by("menu_order", "asc");
        $q = $this->db->get('menus');
        return $q->result_array();
    }

    public function getRoleMenu($user_id)
    {
        $sql = "SELECT DISTINCT d.menu_id, d.menu_title, d.menu_url, d.menu_icon, d.menu_order
                FROM users a, role_menus b, sub_menus c, menus d
                WHERE a.role_id = b.role_id
                AND b.sub_menu_id = c.sub_menu_id
                AND c.menu_id = d.menu_id
                AND a.user_id = ?
                ORDER BY d.menu_order ASC";

        $q = $this->db->query($sql, array($user_id));
        return $q->result_array();
    }


}

/* End of file Menus.php */