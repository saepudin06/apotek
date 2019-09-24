<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Stockopname_controller
* @version 07/05/2015 12:18:00
*/
class Stockopname_dt_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');        
        $stockopname_id = getVarClean('stockopname_id','str','');        

        try {

            $ci = & get_instance();
            $ci->load->model('store/stockopname_dt');
            $table = $ci->stockopname_dt;
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

            // $table->setCriteria("bu_id=".$userdata['bu_id']);

            $table->setCriteria("stockopname_id=".$stockopname_id);

            if(!empty($i_search)) {
                $table->setCriteria("( upper(product_name) like upper('%".$i_search."%') OR
                                       upper(store_info) like upper('%".$i_search."%')
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
                // $data = $this->destroy();
            break;

            default :
                $data = $this->read();
            break;
        }

        return $data;
    }

    function create() {


        $ci = & get_instance();
        $ci->load->model('transaction/purchase_request');
        $table = $ci->purchase_request;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }


        $table->actionType = 'CREATE';
        $errors = array();

        if (isset($items[0])){
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{

                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->create();

                    $table->db->trans_commit(); //Commit Trans

                }catch(Exception $e){

                    $table->db->trans_rollback(); //Rollback Trans
                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data added successfully';
            }
            $data['rows'] =$items;
        }else {

            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->create();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data added successfully';
                

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }


    function updateSTODT() {
        
        $ci = & get_instance();
        $ci->load->model('store/stockopname_dt');
        $table = $ci->stockopname_dt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $status_dt = getVarClean('status_dt','str', '');
        $qty_real = getVarClean('qty_real','int', 0);
        $note_action = getVarClean('note_action','str', '');
        $stockopname_id = getVarClean('stockopname_id','int', 0);
        $stockopname_dt_id = getVarClean('stockopname_dt_id','int', 0);

        // echo $stockopname_id."-".$stockopname_dt_id ;

        // die();

        $userdata = $ci->session->userdata;
        
        try{

            $sql = "BEGIN "
                    . " p_upd_stopname_dt("
                    . " :i_user,"
                    . " :i_bu_id,"
                    . " :i_stock_opnm_id,"
                    . " :i_stockop_dt_id,"
                    . " :i_action_note,"
                    . " :i_status,"
                    . " :i_qty_real,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter            
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);            
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']); 
            oci_bind_by_name($stmt, ':i_stock_opnm_id', $stockopname_id); 
            oci_bind_by_name($stmt, ':i_stockop_dt_id', $stockopname_dt_id); 
            oci_bind_by_name($stmt, ':i_action_note', $note_action); 
            oci_bind_by_name($stmt, ':i_status', $status_dt); 
            oci_bind_by_name($stmt, ':i_qty_real', $qty_real); 
        

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

    function update() {

        $ci = & get_instance();
        $ci->load->model('transaction/purchase_request');
        $table = $ci->purchase_request;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        //exit;

        $table->actionType = 'UPDATE';

        if (isset($items[0])){
            
            $errors = array();
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{
                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->update();

                    $table->db->trans_commit(); //Commit Trans

                    $items[$i] = $table->get($items[$i][$table->pkey]);
                }catch(Exception $e){
                    $table->db->trans_rollback(); //Rollback Trans

                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data update successfully';
            }
            $data['rows'] =$items;
        }else {
            
            try{
                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->update();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';
                
                $data['rows'] = $table->get($items[$table->pkey]);
            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }


}

/* End of file Stockopname_controller.php */