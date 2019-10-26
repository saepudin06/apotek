<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Products_controller
* @version 07/05/2015 12:18:00
*/
class Products_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','name');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('product/products');
            $table = $ci->products;

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
            if(!empty($i_search)) {
                $table->setCriteria("( upper(name) like upper('%".$i_search."%') OR 
                                       upper(product_type_name) like upper('%".$i_search."%') OR
                                       upper(bu_name) like upper('%".$i_search."%') OR
                                       upper(measure_type_name) like upper('%".$i_search."%') OR
                                       upper(package_type_name) like upper('%".$i_search."%')
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
        $ci->load->model('product/products');
        $table = $ci->products;

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
                    . " P_CRUD_INSERT_PRODUCTS("
                    . " :i_action, "
                    . " :i_product_id,"
                    . " :i_product_type_id,"
                    . " :i_measure_type_id,"
                    . " :i_package_type_id,"
                    . " :i_stock_min,"
                    . " :i_initial_stock,"
                    . " :i_name,"
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);


            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_product_id', $items['product_id']);
            oci_bind_by_name($stmt, ':i_product_type_id', $items['product_type_id']);
            oci_bind_by_name($stmt, ':i_measure_type_id', $items['measure_type_id']);
            oci_bind_by_name($stmt, ':i_package_type_id', $items['package_type_id']);
            oci_bind_by_name($stmt, ':i_stock_min', $items['stock_min']);
            oci_bind_by_name($stmt, ':i_initial_stock', $items['initial_stock']);
            oci_bind_by_name($stmt, ':i_name', $items['name']);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);            
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);

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
        $ci->load->model('product/products');
        $table = $ci->products;

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
                    . " P_CRUD_INSERT_PRODUCTS("
                    . " :i_action, "
                    . " :i_product_id,"
                    . " :i_product_type_id,"
                    . " :i_measure_type_id,"
                    . " :i_package_type_id,"
                    . " :i_stock_min,"
                    . " :i_initial_stock,"
                    . " :i_name,"
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_product_id', $items['product_id']);
            oci_bind_by_name($stmt, ':i_product_type_id', $items['product_type_id']);
            oci_bind_by_name($stmt, ':i_measure_type_id', $items['measure_type_id']);
            oci_bind_by_name($stmt, ':i_package_type_id', $items['package_type_id']);
            oci_bind_by_name($stmt, ':i_stock_min', $items['stock_min']);
            oci_bind_by_name($stmt, ':i_initial_stock', $items['initial_stock']);
            oci_bind_by_name($stmt, ':i_name', $items['name']);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);            
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);

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
        $ci->load->model('product/products');
        $table = $ci->products;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $data = jsonDecode($jsonItems);

        $userdata = $ci->session->userdata;
        $items = $data["id_"];
        $action = 'D';
        $null = null;

        try{

            $sql = "BEGIN "
                    . " P_CRUD_INSERT_PRODUCTS("
                    . " :i_action, "
                    . " :i_product_id,"
                    . " :i_product_type_id,"
                    . " :i_measure_type_id,"
                    . " :i_package_type_id,"
                    . " :i_stock_min,"
                    . " :i_initial_stock,"
                    . " :i_name,"
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_product_id', $items['product_id']);
            oci_bind_by_name($stmt, ':i_product_type_id', $null);
            oci_bind_by_name($stmt, ':i_measure_type_id', $null);
            oci_bind_by_name($stmt, ':i_package_type_id', $null);
            oci_bind_by_name($stmt, ':i_stock_min', $null);
            oci_bind_by_name($stmt, ':i_initial_stock', $null);
            oci_bind_by_name($stmt, ':i_name', $null);
            oci_bind_by_name($stmt, ':i_bu_id', $null);            
            oci_bind_by_name($stmt, ':i_user', $null);

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

    function readLov() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','name');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        

        try {

            $ci = & get_instance();
            $ci->load->model('product/products');
            $table = $ci->products;
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
            if(!empty($i_search)) {
                $table->setCriteria("( upper(name) like upper('%".$i_search."%') OR 
                                       upper(product_type_name) like upper('%".$i_search."%') OR
                                       upper(bu_name) like upper('%".$i_search."%') OR
                                       upper(measure_type_name) like upper('%".$i_search."%') OR
                                       upper(package_type_name) like upper('%".$i_search."%')
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

    function readListProduct() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','name');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $stock_qty = getVarClean('stock_qty','str','');
        $product_name = getVarClean('product_name','str','');
        $purchase_request_id = getVarClean('purchase_request_id','int', 0);
        

        try {

            $ci = & get_instance();
            $ci->load->model('product/products');
            $table = $ci->products;
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

            if(!empty($product_name)) {
                $table->setCriteria("( upper(name) like upper('%".$product_name."%'))");
            }

            if(!empty($stock_qty)) {

                if($stock_qty == 'min'){
                    $table->setCriteria("stock_store <= stock_min");
                }

                if($stock_qty == 'max'){
                    $table->setCriteria("stock_store >= stock_min");
                }
                
            }

            if($purchase_request_id != 0){
                $table->setCriteria("not exists (
                                                select 1 
                                                from purchase_req_det b
                                                where  vw_info_product.product_id = b.product_id
                                                and b.purchase_request_id = ".$purchase_request_id."
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

}

/* End of file Products_controller.php */