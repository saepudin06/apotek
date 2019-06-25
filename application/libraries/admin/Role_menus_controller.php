<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Role_menus_controller
* @version 07/05/2015 12:18:00
*/
class Role_menus_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','role_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $role_id = getVarClean('role_id','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('admin/role_menus');
            $table = $ci->role_menus;

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();
            $table->setCriteria("role_id = ".$role_id);

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;
            
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                $data = $this->create();
            break;

            case 'edit' :
                $data = $this->update();
            break;

            case 'del' :
                $data = $this->destroy();
            break;

            default :
                $data = $this->read();
            break;
        }

        return $data;
    }

    function insertdata() {


        $ci = & get_instance();
        $ci->load->model('admin/role_menus');
        $table = $ci->role_menus;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        // print_r($items); exit;
        $table->actionType = 'CREATE';
        $errors = array();

        try {
            
            if(isset($items['submenu']) && count($items['submenu']) > 0){
                $table->db->trans_begin(); //Begin Trans

                    $table->deleteItem($items['role_id']);

                    for($i=0; $i<count($items['submenu']); $i++){
                        $table->setRecord(
                            array('role_id' => $items['role_id'],
                                   'sub_menu_id' => $items['submenu'][$i])
                        );

                        $table->create();
                    }

                $table->db->trans_commit(); //Commit Trans
            }else{

                $table->db->trans_begin(); //Begin Trans
                $table->deleteItem($items['role_id']);
                $table->db->trans_commit(); //Commit Trans
            }

            $data['success'] = true;
            $data['message'] = 'Data updated succesfully';
        } catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans

            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }
        return $data;

    }

}

/* End of file Role_menus_controller.php */