<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Storeissuevoucher_controller
* @version 07/05/2015 12:18:00
*/
class Storeissuevoucher_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        // $supplier_id = getVarClean('supplier_id','str', '');
        // $invoice_ref = getVarClean('invoice_ref','str', '');

        try {

            $ci = & get_instance();
            $ci->load->model('store/storeissuevoucher');
            $table = $ci->storeissuevoucher;
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

           /* if(!empty($supplier_id)) {
                $table->setCriteria("supplier_id=".$supplier_id);
            }

            if(!empty($invoice_ref)) {
                $table->setCriteria("invoice_ref=".$invoice_ref);
            }*/

            if(!empty($i_search)) {
                $table->setCriteria("( upper(CODE) like upper('%".$i_search."%') OR
                                       upper(SIV_DATE) like upper('%".$i_search."%') OR
                                       upper(INFO_BU) like upper('%".$i_search."%') OR
                                       upper(STATUS) like upper('%".$i_search."%')
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

    // sub grid detail siv
    function read_dt() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');
        $celValue = getVarClean('celValue','str','0');
 

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        // $i_search = getVarClean('i_search','str','');
        // $supplier_id = getVarClean('supplier_id','str', '');
        // $invoice_ref = getVarClean('invoice_ref','str', '');

        try {

            $ci = & get_instance();
            $ci->load->model('store/storeissuevoucher_dt');
            $table = $ci->storeissuevoucher_dt;
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
            $table->setCriteria("store_issue_voucher_id=".$celValue);

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
           
            case 'edit' :
                $data = $this->update();
            break;

            default :
                $data = $this->read();
            break;
        }

        return $data;
    }

    
    function generate() {
        
        $ci = & get_instance();
        $ci->load->model('store/storeissuevoucher');
        $table = $ci->storeissuevoucher;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $supplier_id = getVarClean('supplier_id','int', 0);

        //exit;

        $userdata = $ci->session->userdata;
        
        try{

            $sql = "BEGIN "
                    . " p_collect_store_issue_vc("
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

/* End of file Storeissuevoucher_controller.php */