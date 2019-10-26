<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Purchase_order_det_controller
* @version 07/05/2015 12:18:00
*/
class Purchase_order_det_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','purchase_order_det_id');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $purchase_order_id = getVarClean('purchase_order_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('transaction/purchase_order_det');
            $table = $ci->purchase_order_det;
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
            $table->setCriteria("purchase_order_id=".$purchase_order_id);

            if(!empty($i_search)) {
                $table->setCriteria("( upper(invoice_num_ref) like upper('%".$i_search."%') OR
                                       upper(purchase_request) like upper('%".$i_search."%') OR
                                       upper(supplier_name) like upper('%".$i_search."%') 
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

    function crudAll(){
        $ci = & get_instance();
        $ci->load->model('transaction/purchase_order_det');
        $table = $ci->purchase_order_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST['data'];

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $action = '';

        try{


            $success = 0;
            $failed = 0;
            $msg = '';
            for($i=0; $i<count($items); $i++){

                $status = $items[$i]['status'];
                $key_id = $items[$i]['purchase_order_det_id'];

                if($status == 'Tidak'){
                    $action = 'D';
                    $items[$i]['purchase_request_id'] = null;
                    $items[$i]['purchase_order_id'] = null;
                    $items[$i]['qty'] = null;
                    $items[$i]['basic_price'] = null;
                    $items[$i]['purchase_req_det_id'] = null;
                }else{ //status == Ya
                    if(empty($key_id)){
                        $action = 'I';
                    }else{
                        $action = 'U';
                    }
                }

                
                 $sql = "BEGIN "
                    . " P_CRUD_PURCHASE_ORDER_DT ("
                    . " :i_action, "
                    . " :i_purchase_request_id,"
                    . " :i_purchase_order_id,"
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_amount,"
                    . " :i_purchase_req_det_id,"
                    . " :i_purchase_order_det_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

                $stmt = oci_parse($table->db->conn_id, $sql);

                $amount = (int)$items[$i]['qty'] * (int)$items[$i]['basic_price'];

                //  Bind the input parameter
                oci_bind_by_name($stmt, ':i_action', $action);
                oci_bind_by_name($stmt, ':i_purchase_request_id', $items[$i]['purchase_request_id']);
                oci_bind_by_name($stmt, ':i_purchase_order_id', $items[$i]['purchase_order_id']);
                oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);            
                oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
                oci_bind_by_name($stmt, ':i_qty', $items[$i]['qty']);
                oci_bind_by_name($stmt, ':i_basic_price', $items[$i]['basic_price']);
                oci_bind_by_name($stmt, ':i_amount', $amount);
                oci_bind_by_name($stmt, ':i_purchase_req_det_id', $items[$i]['purchase_req_det_id']);
                oci_bind_by_name($stmt, ':i_purchase_order_det_id', $items[$i]['purchase_order_det_id']);

                // Bind the output parameter
                oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
                oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


                ociexecute($stmt);

                if($o_msg_code == 0){
                    $success = $success + 1;
                }else{
                    $msg .= "\n1 Data gagal disimpan : ".$o_msg;
                }
            }

            $data['rows'] = $items;
            $data['success'] = true;
            $data['message'] = $success." Data berhasil disimpan".$msg;

            // if($o_msg_code == 0){
            //     $data['rows'] = $items;
            //     $data['success'] = true;
            //     $data['message'] = $o_msg;
            // }else{
            //     $data['rows'] = $items;
            //     $data['success'] = false;
            //     $data['message'] = $o_msg;
            // }

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }
        return $data;
    }

    function create() {


        $ci = & get_instance();
        $ci->load->model('transaction/purchase_order_det');
        $table = $ci->purchase_order_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $action = 'I';
        try{

            $sql = "BEGIN "
                    . " P_CRUD_PURCHASE_ORDER_DT ("
                    . " :i_action, "
                    . " :i_purchase_request_id,"
                    . " :i_purchase_order_id,"
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_amount,"
                    . " :i_purchase_req_det_id,"
                    . " :i_purchase_order_det_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_purchase_request_id', $items['purchase_request_id']);
            oci_bind_by_name($stmt, ':i_purchase_order_id', $items['purchase_order_id']);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);            
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_qty', $items['qty']);
            oci_bind_by_name($stmt, ':i_basic_price', $items['basic_price']);
            oci_bind_by_name($stmt, ':i_amount', $items['amount']);
            oci_bind_by_name($stmt, ':i_purchase_req_det_id', $items['purchase_req_det_id']);
            oci_bind_by_name($stmt, ':i_purchase_order_det_id', $items['purchase_order_det_id']);

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
        $ci->load->model('transaction/purchase_order_det');
        $table = $ci->purchase_order_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $action = 'U';
        try{

            $sql = "BEGIN "
                    . " P_CRUD_PURCHASE_ORDER_DT ("
                    . " :i_action, "
                    . " :i_purchase_request_id,"
                    . " :i_purchase_order_id,"
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_amount,"
                    . " :i_purchase_req_det_id,"
                    . " :i_purchase_order_det_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_purchase_request_id', $items['purchase_request_id']);
            oci_bind_by_name($stmt, ':i_purchase_order_id', $items['purchase_order_id']);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);            
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_qty', $items['qty']);
            oci_bind_by_name($stmt, ':i_basic_price', $items['basic_price']);
            oci_bind_by_name($stmt, ':i_amount', $items['amount']);
            oci_bind_by_name($stmt, ':i_purchase_req_det_id', $items['purchase_req_det_id']);
            oci_bind_by_name($stmt, ':i_purchase_order_det_id', $items['purchase_order_det_id']);

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
        $ci->load->model('transaction/purchase_order_det');
        $table = $ci->purchase_order_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $data = jsonDecode($jsonItems);

        $userdata = $ci->session->userdata;
        $items = $data["id_"];
        $action = 'D';
        $null = null;
        
        try{

            $sql = "BEGIN "
                    . " P_CRUD_PURCHASE_ORDER_DT ("
                    . " :i_action, "
                    . " :i_purchase_request_id,"
                    . " :i_purchase_order_id,"
                    . " :i_bu_id,"
                    . " :i_user,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_amount,"
                    . " :i_purchase_req_det_id,"
                    . " :i_purchase_order_det_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_purchase_request_id', $null);
            oci_bind_by_name($stmt, ':i_purchase_order_id', $null);
            oci_bind_by_name($stmt, ':i_bu_id', $null);            
            oci_bind_by_name($stmt, ':i_user', $null);
            oci_bind_by_name($stmt, ':i_qty', $null);
            oci_bind_by_name($stmt, ':i_basic_price', $null);
            oci_bind_by_name($stmt, ':i_amount', $null);
            oci_bind_by_name($stmt, ':i_purchase_req_det_id', $null);
            oci_bind_by_name($stmt, ':i_purchase_order_det_id', $items);

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


    function readChild() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','purchase_order_det_id');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $purchase_order_id = getVarClean('purchase_order_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('transaction/purchase_order_det_child');
            $table = $ci->purchase_order_det_child;

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

            $table->setCriteria("purchase_order_id=".$purchase_order_id);
    

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

/* End of file Purchase_order_det_controller.php */