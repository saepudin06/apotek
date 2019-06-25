<?php

/**
 * Sub_menus Model
 *
 */
class Sub_menus extends Abstract_model {

    public $table           = "sub_menus";
    public $pkey            = "sub_menu_id";
    public $alias           = "";

    public $fields          = array(
                                'sub_menu_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Sub Menu ID'),
                                'menu_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Menu ID'),
                                'sub_menu_title'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Sub Menu'),
                                'sub_data_link'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Data Link'),
                                'sub_data_source'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Data Source'),
                                'sub_menu_icon'     => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Icon'),
                                'sub_menu_order'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Listing No'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "sub_menus";

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

    public function getSubMenu($menu_id)
    {
        $this->db->order_by("sub_menu_order", "asc");
        $this->db->where("menu_id", $menu_id);
        $q = $this->db->get('sub_menus');
        return $q->result_array();
    }

    public function getRoleSubMenu($menu_id, $user_id)
    {
        $sql = "SELECT c.sub_menu_id, c.menu_id, c.sub_menu_title, c.sub_data_link, c.sub_data_source, c.sub_menu_icon, c.sub_menu_order
                FROM users a, role_menus b, sub_menus c, menus d
                WHERE a.role_id = b.role_id
                AND b.sub_menu_id = c.sub_menu_id
                AND c.menu_id = d.menu_id
                AND c.menu_id = ?
                AND a.user_id = ?
                ORDER BY c.sub_menu_order ASC";

        $q = $this->db->query($sql, array($menu_id, $user_id));
        return $q->result_array();
    }


}

/* End of file Sub_menus.php */