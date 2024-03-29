<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Purchase_req_det_controller
* @version 07/05/2015 12:18:00
*/
class Purchase_req_det_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','purchase_req_det_id');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $purchase_request_id = getVarClean('purchase_request_id','int',0);
        $product_name = getVarClean('product_name','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('transaction/purchase_req_det');
            $table = $ci->purchase_req_det;

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

            $table->setCriteria("purchase_request_id=".$purchase_request_id);
            if(!empty($product_name)) {
                $table->setCriteria("upper(product_name) like upper('%".$product_name."%')");
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
        $ci->load->model('transaction/purchase_req_det');
        $table = $ci->purchase_req_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');
        

        $items = $_POST['data'];

        // print_r($items['data'][0]['product_id']); exit;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $action = 'I';
        try{

            $success = 0;
            $failed = 0;
            $msg = '';
            for($i=0; $i<count($items); $i++){
                $sql = "BEGIN "
                        . " P_CRUD_PURCHASE_REQ_DET("
                        . " :i_action, "
                        . " :i_purchase_req_det_id,"
                        . " :i_purchase_request_id,"
                        . " :i_product_id,"
                        . " :i_amount,"
                        . " :i_qty,"
                        . " :i_basic_price,"
                        . " :i_user,"
                        . " :o_msg_code,"
                        . " :o_msg"
                        . "); END;";

                $stmt = oci_parse($table->db->conn_id, $sql);

                //  Bind the input parameter
                oci_bind_by_name($stmt, ':i_action', $action);
                oci_bind_by_name($stmt, ':i_purchase_req_det_id', $items[$i]['purchase_req_det_id']);
                oci_bind_by_name($stmt, ':i_purchase_request_id', $items[$i]['purchase_request_id']);
                oci_bind_by_name($stmt, ':i_product_id', $items[$i]['product_id']);
                oci_bind_by_name($stmt, ':i_amount', $items[$i]['amount']);
                oci_bind_by_name($stmt, ':i_qty', $items[$i]['qty']);
                oci_bind_by_name($stmt, ':i_basic_price', $items[$i]['basic_price']);
                oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);

                // Bind the output parameter
                oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
                oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


                ociexecute($stmt);

                if($o_msg_code == 0){
                    $success = $success + 1;
                }else{
                    $msg .= "\n1 Produk gagal disimpan : ".$o_msg;
                }
            }

            

            $data['rows'] = $items;
            $data['success'] = true;
            $data['message'] = $success." Produk berhasil disimpan".$msg;


        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }

        return $data;

    }

    function update() {

        $ci = & get_instance();
        $ci->load->model('transaction/purchase_req_det');
        $table = $ci->purchase_req_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST['data'];

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $action = 'U';
        $status = null;
        try{


            $success = 0;
            $failed = 0;
            $msg = '';
            for($i=0; $i<count($items); $i++){
                $sql = "BEGIN "
                        . " P_CRUD_PURCHASE_REQ_DET("
                        . " :i_action, "
                        . " :i_purchase_req_det_id,"
                        . " :i_purchase_request_id,"
                        . " :i_product_id,"
                        . " :i_amount,"
                        . " :i_qty,"
                        . " :i_basic_price,"
                        . " :i_user,"
                        . " :o_msg_code,"
                        . " :o_msg"
                        . "); END;";

                $stmt = oci_parse($table->db->conn_id, $sql);

                $amount = (int)$items[$i]['qty'] * (int)$items[$i]['basic_price'];

                //  Bind the input parameter
                oci_bind_by_name($stmt, ':i_action', $action);
                oci_bind_by_name($stmt, ':i_purchase_req_det_id', $items[$i]['purchase_req_det_id']);
                oci_bind_by_name($stmt, ':i_purchase_request_id', $items[$i]['purchase_request_id']);
                oci_bind_by_name($stmt, ':i_product_id', $items[$i]['product_id']);
                oci_bind_by_name($stmt, ':i_amount', $amount);
                oci_bind_by_name($stmt, ':i_qty', $items[$i]['qty']);
                oci_bind_by_name($stmt, ':i_basic_price', $items[$i]['basic_price']);
                oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);

                // Bind the output parameter
                oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
                oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


                ociexecute($stmt);

                if($o_msg_code == 0){
                    $success = $success + 1;
                }else{
                    $msg .= "\n1 Produk gagal disimpan : ".$o_msg;
                }
            }

            $data['rows'] = $items;
            $data['success'] = true;
            $data['message'] = $success." Produk berhasil disimpan".$msg;

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

    function destroy() {

        $ci = & get_instance();
        $ci->load->model('transaction/purchase_req_det');
        $table = $ci->purchase_req_det;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $data = jsonDecode($jsonItems);

        $items['purchase_req_det_id'] = $data["id_"];
        $items['purchase_request_id'] = $data["purchase_request_id"];
        $items['product_id'] = $data["product_id"];

        // print_r($items); exit;

        $userdata = $ci->session->userdata;
        $action = 'D';
        $null = null;

        try{
            $sql = "BEGIN "
                    . " P_CRUD_PURCHASE_REQ_DET("
                    . " :i_action, "
                    . " :i_purchase_req_det_id,"
                    . " :i_purchase_request_id,"
                    . " :i_product_id,"
                    . " :i_amount,"
                    . " :i_qty,"
                    . " :i_basic_price,"
                    . " :i_user,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_action', $action);
            oci_bind_by_name($stmt, ':i_purchase_req_det_id', $items['purchase_req_det_id']);
            oci_bind_by_name($stmt, ':i_purchase_request_id', $items['purchase_request_id']);
            oci_bind_by_name($stmt, ':i_product_id', $items['product_id']);
            oci_bind_by_name($stmt, ':i_amount', $null);
            oci_bind_by_name($stmt, ':i_qty', $null);
            oci_bind_by_name($stmt, ':i_basic_price', $null);
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
            oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);


            ociexecute($stmt);

            if($o_msg_code == 0){
                $data['rows'] = $items;
                $data['success'] = true;
                $data['message'] = $o_msg;
                $data['total'] = 1;
                $data['records'] = 0;
                $data['page'] = 1;
            }else{
                $data['rows'] = $items;
                $data['success'] = false;
                $data['message'] = $o_msg;
                $data['total'] = 1;
                $data['records'] = 0;
                $data['page'] = 1;
            }
            
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }

    function readLov() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','purchase_req_det_id');
        $sord = getVarClean('sord','str','desc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');
        $purchase_request_id = getVarClean('purchase_request_id','int',0);
        $purchase_order_id = getVarClean('purchase_order_id','int',0);

        try {

            $ci = & get_instance();
            $ci->load->model('transaction/purchase_req_det');
            $table = $ci->purchase_req_det;

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

            $table->setCriteria("purchase_request_id=".$purchase_request_id);
            if(!empty($purchase_order_id)) {
                $table->setCriteria("not exists (select 1 from purchase_order_det b
                       where vw_list_pr_details.purchase_req_det_id =b.purchase_req_det_id and purchase_order_id = ".$purchase_order_id.")");
            }

            if(!empty($i_search)) {
                $table->setCriteria("( upper(product_name) like upper('%".$i_search."%') OR 
                                       upper(status_code) like upper('%".$i_search."%')
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

    function download_excel() {
            set_time_limit(0);
            ini_set('max_execution_time', 0);
            
            $purchase_request_id = getVarClean('purchase_request_id','int',0);

            $ci = & get_instance();
            $ci->load->model('transaction/purchase_req_det');
            $table = $ci->purchase_req_det;
            $table->setCriteria("purchase_request_id=".$purchase_request_id);

            $count = $table->countAll();
            $items = $table->getAll(0, -1);

            $filename = "Deftar_permintaan_pembelian_".date('Ymdhis').".xls";

            include 'phpexcel/PHPExcel.php';
            include 'phpexcel/PHPExcel/IOFactory.php';  

            $excel = new PHPExcel();

            $style_col = array( 'font' => array('bold' => true), // Set font nya jadi bold      
                                'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)      
                                ),      
                                'borders' => array('allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )) 
                                );

            $style_row = array('alignment' => array( 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)      
                                                         ),      
                                                       'borders' => array('allborders' => array(
                                                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                                            ))    
                                                        );

            $style_total = array('font' => array('bold' => true),
                                 'alignment' => array( 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)      
                                                     ),      
                                'borders' => array('allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                    ))   
                                );

            $excel->setActiveSheetIndex(0)->setCellValue('A1', "Produk");
            $excel->setActiveSheetIndex(0)->setCellValue('B1', "Harga Awal");
            $excel->setActiveSheetIndex(0)->setCellValue('C1', "Jumlah");
            $excel->setActiveSheetIndex(0)->setCellValue('D1', "Total");

            $excel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($style_col);  

            $numrow = 2;
            foreach($items as $item) {   

                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $item['product_name']);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, (float)$item['basic_price']);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, (float)$item['qty']);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, (float)$item['amount']);

                $excel->getActiveSheet()->getStyle('A'.$numrow.':D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->getNumberFormat()->setFormatCode('#,##0.00'); 
                $excel->getActiveSheet()->getStyle('C'.$numrow)->getNumberFormat()->setFormatCode('#,##0.00'); 
                $excel->getActiveSheet()->getStyle('D'.$numrow)->getNumberFormat()->setFormatCode('#,##0.00'); 

                $numrow++;        

            
            }

            // Set width kolom    
            foreach(range('A','D') as $columnID)
            {
                $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }



            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)   
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);


            $excel->getActiveSheet(0)->setTitle('Permintaan_pembelian');
            $excel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$filename");
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $write->save('php://output');

    }

}

/* End of file Purchase_req_det_controller.php */