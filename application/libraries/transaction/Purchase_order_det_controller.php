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
        $sidx = getVarClean('sidx','str','purchase_order_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $purchase_order_id = getVarClean('purchase_order_id','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaction/purchase_order_det');
            $table = $ci->purchase_order_det;

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
            $table->setCriteria("purchase_order_id = ".$purchase_order_id);

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

    function insertdata() {


        $ci = & get_instance();
        $ci->load->model('transaction/purchase_order_det');
        $table = $ci->purchase_order_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;


        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        // print_r($items); exit;
        
        $errors = array();

        try {
            
            // if(isset($items['purchase_req_det_id']) && count($items['purchase_req_det_id']) > 0){
                $table->db->trans_begin(); //Begin Trans
                    
                    // $table->deleteItem($items['role_id']);
                    
                    for($i=0; $i<count($items['purchase_req_det_id']); $i++){
                        $purchase_order_det_id = $items['purchase_order_det_id'][$i];
                        $purchase_req_det_id = $items['purchase_req_det_id'][$i];
                        $qty = $items['qty'][$i];
                        $basic_price = $items['basic_price'][$i];
                        $purchase_order_id = $items['purchase_order_id'];
                        

                        if(isset($items['check'][$purchase_req_det_id])){

                            // $table->deleteItem($purchase_order_det_id);
                            

                            if($purchase_order_det_id > 0){
                                $table->actionType = 'UPDATE';

                                $table->setRecord(
                                    array('purchase_req_det_id' => $purchase_req_det_id,
                                           'basic_price' => $basic_price,
                                           'purchase_order_id' => $purchase_order_id,
                                           'purchase_order_det_id' => $purchase_order_det_id,
                                           'qty' => $qty,
                                           'status_id' => 2
                                       )
                                );

                                $table->update();
                            
                            }else{
                                $table->actionType = 'CREATE';

                                $table->setRecord(
                                    array('purchase_req_det_id' => $purchase_req_det_id,
                                           'basic_price' => $basic_price,
                                           'purchase_order_id' => $purchase_order_id,
                                           'qty' => $qty,
                                           'status_id' => 2
                                       )
                                );
                                $table->create();
                            }
                            

                        }else{
                            // print_r($purchase_order_det_id); exit;
                            $table->db->trans_begin(); //Begin Trans
                            $table->deleteItem($purchase_order_det_id);
                            $table->db->trans_commit(); //Commit Trans
                        }
                    
                    }

                    $table->updatePO($items['purchase_order_id']);

                $table->db->trans_commit(); //Commit Trans
            // }

            $data['success'] = true;
            $data['message'] = 'Data added succesfully';
        } catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans

            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }
        return $data;

    }

}

/* End of file Purchase_order_det_controller.php */