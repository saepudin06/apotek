<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Expendituremonth_controller
* @version 07/05/2015 12:18:00
*/
class Expendituremonth_d_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');
        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        // $i_search = getVarClean('i_search','str','');
        // $i_keyper = getVarClean('keyid','str','');
        $celValue = getVarClean('celValue','str','0');
        // $supplier_id = getVarClean('supplier_id','str', '');
        // $invoice_ref = getVarClean('invoice_ref','str', '');

        try {

            $ci = & get_instance();
            $ci->load->model('process/expendituremonth_d');
            $table = $ci->expendituremonth_d;
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

            if(!empty($celValue)){
                $table->setCriteria("( upper(keyid) like upper('%".$celValue."%') 
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

    function read_dt() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','');
        $sord = getVarClean('sord','str','');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $i_period = getVarClean('i_period','str','');
        // $supplier_id = getVarClean('supplier_id','str', '');
        // $invoice_ref = getVarClean('invoice_ref','str', '');

        try {

            $ci = & get_instance();
            $ci->load->model('process/expendituremonth_grp');
            $table = $ci->expendituremonth_grp;
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

            if(!empty($i_period)){
                $table->setCriteria("( upper(period_expenditure) like upper('%".$i_period."%') 
                                     )");
            }

            //GROUP_ACC 7   VARCHAR2 (203 Byte) Y
            if(!empty($i_search)) {
                $table->setCriteria("( upper(period_expenditure) like upper('%".$i_search."%') OR
                                       upper(bu_name) like upper('%".$i_search."%')  OR
                                       upper(group_acc) like upper('%".$i_search."%')  
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

}

/* End of file Invoice_receive_controller.php */