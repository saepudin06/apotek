<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Goods_recieve_nt_controller
* @version 07/05/2015 12:18:00
*/
class Goods_recieve_nt_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','goods_recieve_nt_id');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $status = getVarClean('status','str','');   

        try {

            $ci = & get_instance();
            $ci->load->model('transaction/goods_recieve_nt');
            $table = $ci->goods_recieve_nt;
            $userdata = $ci->session->userdata;

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
            $table->setCriteria("bu_id=".$userdata['bu_id']);

            if(!empty($status)) {
                $table->setCriteria("nvl(status,'IN-PROCESS')= '".$status."'");
            }

            if(!empty($i_search)) {
                $table->setCriteria("( upper(code) like upper('%".$i_search."%') OR
                                       upper(status) like upper('%".$i_search."%')
                                     )");
            }

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

    function create() {


        $ci = & get_instance();
        $ci->load->model('transaction/goods_recieve_nt');
        $table = $ci->goods_recieve_nt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $table->actionType = 'CREATE';
        $table->setRecord($items);

        $errors = array();
        $userdata = $ci->session->userdata;
        $action = 'I';

        try{

            $sql = "BEGIN "
                    . " P_CRUD_GOODS_RECIEVE("
                    . " :i_action, "
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " to_date(:i_due_date_payment, 'DD/MM/YYYY'),"
                    . " :i_purchase_order_id,"
                    . " :i_grn_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);  
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_due_date_payment', $items['due_date_payment']);    
            oci_bind_by_name($stmt, ':i_purchase_order_id', $items['purchase_order_id']);
            oci_bind_by_name($stmt, ':i_grn_id', $items['goods_recieve_nt_id']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
            oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


            ociexecute($stmt);

            if($o_msg_code == 0){
                $data['rows'] = $items;
                $data['success'] = true;
                $data['message'] = $o_msg;
            }else{
                $data['rows'] = $items;
                $data['success'] = false;
                $data['message'] = $o_msg;
            }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }

        return $data;

    }

    function update() {

        $ci = & get_instance();
        $ci->load->model('transaction/goods_recieve_nt');
        $table = $ci->goods_recieve_nt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        //exit;
        $table->actionType = 'UPDATE';
        $table->setRecord($items);
        
        $userdata = $ci->session->userdata;
        $action = 'U';
        try{

            $sql = "BEGIN "
                    . " P_CRUD_GOODS_RECIEVE("
                    . " :i_action, "
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " to_date(:i_due_date_payment, 'DD/MM/YYYY'),"
                    . " :i_purchase_order_id,"
                    . " :i_grn_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);  
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_due_date_payment', $items['due_date_payment']);    
            oci_bind_by_name($stmt, ':i_purchase_order_id', $items['purchase_order_id']);
            oci_bind_by_name($stmt, ':i_grn_id', $items['goods_recieve_nt_id']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
            oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


            ociexecute($stmt);

            if($o_msg_code == 0){
                $data['rows'] = $items;
                $data['success'] = true;
                $data['message'] = $o_msg;
            }else{
                $data['rows'] = $items;
                $data['success'] = false;
                $data['message'] = $o_msg;
            }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }

        return $data;

    }

    function destroy() {

        $ci = & get_instance();
        $ci->load->model('transaction/goods_recieve_nt');
        $table = $ci->goods_recieve_nt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $data = jsonDecode($jsonItems);

        $userdata = $ci->session->userdata;
        $items = $data["id_"];
        $action = 'D';
        $null = null;
        
        try{

            $sql = "BEGIN "
                    . " P_CRUD_GOODS_RECIEVE("
                    . " :i_action, "
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " to_date(:i_due_date_payment, 'DD/MM/YYYY'),"
                    . " :i_purchase_order_id,"
                    . " :i_grn_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_bu_id', $null);  
            oci_bind_by_name($stmt, ':i_user', $null);
            oci_bind_by_name($stmt, ':i_due_date_payment', $null);    
            oci_bind_by_name($stmt, ':i_purchase_order_id', $null);
            oci_bind_by_name($stmt, ':i_grn_id', $items);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
            oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


            ociexecute($stmt);

            if($o_msg_code == 0){
                $data['rows'] = null;
                $data['success'] = true;
                $data['message'] = $o_msg;
                $data['total'] = 1;
                $data['records'] = 0;
                $data['page'] = 1;
            }else{
                $data['rows'] = null;
                $data['success'] = false;
                $data['message'] = $o_msg;
                $data['total'] = 1;
                $data['records'] = 0;
                $data['page'] = 1;
            }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }
        return $data;
    }

     function process() {


        $ci = & get_instance();
        $ci->load->model('transaction/goods_recieve_nt');
        $table = $ci->goods_recieve_nt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $items = jsonDecode($jsonItems);

        $errors = array();
        $userdata = $ci->session->userdata;

        try{

            $sql = "BEGIN "
                    . " PRC_ADD_STRO_STOCK_PER("
                    . " :i_grn_id,"
                    . " :i_user,"
                    . " :i_bu_id,"                    
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_grn_id', $items['goods_recieve_nt_id']);            
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);  
            

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
            oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


            ociexecute($stmt);

            if($o_msg_code == 0){
                $data['rows'] = array();
                $data['success'] = true;
                $data['message'] = $o_msg;
            }else{
                $data['rows'] = array();
                $data['success'] = false;
                $data['message'] = $o_msg;
            }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
        }

        return $data;

    }

    function processall() {


        $ci = & get_instance();
        $ci->load->model('transaction/goods_recieve_nt');
        $table = $ci->goods_recieve_nt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');


        $errors = array();
        $userdata = $ci->session->userdata;

        try{

            $sql = "BEGIN "
                    . " P_COLLECT_ADD_STORE_STOCK("
                    . " :i_user,"
                    . " :i_bu_id,"                    
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);             
            

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
            oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


            ociexecute($stmt);

            if($o_msg_code == 0){
                $data['rows'] = array();
                $data['success'] = true;
                $data['message'] = $o_msg;
            }else{
                $data['rows'] = array();
                $data['success'] = false;
                $data['message'] = $o_msg;
            }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
        }

        return $data;

    }

}

/* End of file Goods_recieve_nt_controller.php */