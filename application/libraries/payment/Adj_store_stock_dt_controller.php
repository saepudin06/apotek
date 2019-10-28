<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Adj_store_stock_dt_controller
* @version 07/05/2015 12:18:00
*/
class Adj_store_stock_dt_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','adj_store_stock_dt_id');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $adj_store_stock_id = getVarClean('adj_store_stock_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('payment/adj_store_stock_dt');
            $table = $ci->adj_store_stock_dt;
            // $userdata = $ci->session->userdata;

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
            $table->setCriteria("adj_store_stock_id=".$adj_store_stock_id);

            if(!empty($i_search)) {
                $table->setCriteria("( upper(product) like upper('%".$i_search."%') OR
                                        upper(store) like upper('%".$i_search."%') OR
                                        upper(description) like upper('%".$i_search."%')
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
        $ci->load->model('payment/adj_store_stock_dt');
        $table = $ci->adj_store_stock_dt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $action = 'I';
        $table->actionType = 'CREATE';
        $table->setRecord($items);
        try{

             
            $sql = "BEGIN "
                    . " P_CRUD_ADJ_STORE_DT ("
                    . " :i_action, "
                    . " :i_adjs_dt_id,"
                    . " :i_adjs_id,"
                    . " :i_product_id,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_user,"
                    . " :i_store_id,"
                    . " :i_dc,"
                    . " :i_desc,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_adjs_dt_id', $items['adj_store_stock_dt_id']);
            oci_bind_by_name($stmt, ':i_adjs_id', $items['adj_store_stock_id']);
            oci_bind_by_name($stmt, ':i_product_id', $items['product_id']);                        
            oci_bind_by_name($stmt, ':i_qty', $items['qty']);
            oci_bind_by_name($stmt, ':i_basic_price', $items['basic_price']);
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_store_id', $items['store_id']);
            oci_bind_by_name($stmt, ':i_dc', $items['dc']);
            oci_bind_by_name($stmt, ':i_desc', $items['description']);

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
        $ci->load->model('payment/adj_store_stock_dt');
        $table = $ci->adj_store_stock_dt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $action = 'U';
        $table->actionType = 'UPDATE';
        $table->setRecord($items);
        try{

            $sql = "BEGIN "
                    . " P_CRUD_ADJ_STORE_DT ("
                    . " :i_action, "
                    . " :i_adjs_dt_id,"
                    . " :i_adjs_id,"
                    . " :i_product_id,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_user,"
                    . " :i_store_id,"
                    . " :i_dc,"
                    . " :i_desc,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_adjs_dt_id', $items['adj_store_stock_dt_id']);
            oci_bind_by_name($stmt, ':i_adjs_id', $items['adj_store_stock_id']);
            oci_bind_by_name($stmt, ':i_product_id', $items['product_id']);                         
            oci_bind_by_name($stmt, ':i_qty', $items['qty']);
            oci_bind_by_name($stmt, ':i_basic_price', $items['basic_price']);
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_store_id', $items['store_id']);
            oci_bind_by_name($stmt, ':i_dc', $items['dc']);
            oci_bind_by_name($stmt, ':i_desc', $items['description']);

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
        $ci->load->model('payment/adj_store_stock_dt');
        $table = $ci->adj_store_stock_dt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $data = jsonDecode($jsonItems);

        $userdata = $ci->session->userdata;
        $items = $data["id_"];
        $action = 'D';
        $null = null;
        
        try{

            $sql = "BEGIN "
                    . " P_CRUD_ADJ_STORE_DT ("
                    . " :i_action, "
                    . " :i_adjs_dt_id,"
                    . " :i_adjs_id,"
                    . " :i_product_id,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_user,"
                    . " :i_store_id,"
                    . " :i_dc,"
                    . " :i_desc,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_adjs_dt_id', $items);
            oci_bind_by_name($stmt, ':i_adjs_id', $null);
            oci_bind_by_name($stmt, ':i_product_id', $null);                        
            oci_bind_by_name($stmt, ':i_qty', $null);
            oci_bind_by_name($stmt, ':i_basic_price', $null);
            oci_bind_by_name($stmt, ':i_user', $null);
            oci_bind_by_name($stmt, ':i_store_id', $null);
            oci_bind_by_name($stmt, ':i_dc', $null);
            oci_bind_by_name($stmt, ':i_desc', $null);

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

}

/* End of file Adj_store_stock_dt_controller.php */