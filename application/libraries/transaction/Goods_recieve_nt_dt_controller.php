<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Goods_recieve_nt_dt_controller
* @version 07/05/2015 12:18:00
*/
class Goods_recieve_nt_dt_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','good_rcv_nt_dt_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $goods_recieve_nt_id = getVarClean('goods_recieve_nt_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('transaction/goods_recieve_nt_dt');
            $table = $ci->goods_recieve_nt_dt;

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
            $table->setCriteria("goods_recieve_nt_id=".$goods_recieve_nt_id);

            if(!empty($i_search)) {
                $table->setCriteria("( upper(product_name) like upper('%".$i_search."%') OR
                                       upper(store_info) like upper('%".$i_search."%') OR
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

    function update() {

        $ci = & get_instance();
        $ci->load->model('transaction/goods_recieve_nt_dt');
        $table = $ci->goods_recieve_nt_dt;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        //exit;

        $userdata = $ci->session->userdata;
        
        try{

            $sql = "BEGIN "
                    . " P_CRUD_GOODS_RECIEVE_DT("
                    . " :i_user, "
                    . " :i_status,"
                    . " :i_grn_id,"
                    . " :i_grn_dt_id,"                    
                    . " :i_store_info_id,"
                    . " :i_note,"
                    . " to_date(:i_exp_date, 'DD/MM/YYYY'),"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_status', $items['status']);
            oci_bind_by_name($stmt, ':i_grn_id', $items['goods_recieve_nt_id']);  
            oci_bind_by_name($stmt, ':i_grn_dt_id', $items['good_rcv_nt_dt_id']);  
            oci_bind_by_name($stmt, ':i_store_info_id', $items['store_info_id']);              
            oci_bind_by_name($stmt, ':i_note', $items['note']);
            oci_bind_by_name($stmt, ':i_exp_date', $items['exp_date']);   

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

}

/* End of file Goods_recieve_nt_dt_controller.php */