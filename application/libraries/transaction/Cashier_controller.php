<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('escpos-php/autoload.php');

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
/**
* Json library
* @class Cashier_controller
* @version 07/05/2015 12:18:00
*/
class Cashier_controller {

    function getProduct(){
        $data = array('rows' => array(), 'success' => false, 'message' => '', 'total' => 0);

        $product_label = getVarClean('product_label','str','');

        $ci = & get_instance();
        $ci->load->model('transaction/cashier');
        $table = $ci->cashier;

        $sql = "SELECT a.product_id, a.name product_name, b.product_label, c.sell_price, c.basic_price
                FROM products a
                LEFT JOIN productdetails b ON a.product_id = b.product_id
                LEFT JOIN producttariffdetails c ON b.prd_details_id = c.prd_details_id
                WHERE b.product_label = ?
                AND trunc(SYSDATE) BETWEEN c.start_date
                                               AND NVL (c.end_date,
                                                        SYSDATE + 1)";

        $result = $table->db->query($sql, array($product_label));
        $rows = $result->row_array();

        $data['total'] = count($rows);
        $data['success'] = true;
        $data['message'] = 'sukses';
        $data['rows'] = $rows;
      
        echo json_encode($data);
        exit;
    }

    function insertTrans(){
        $ci = & get_instance();
        $ci->load->model('transaction/cashier');
        $table = $ci->cashier;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '', 'transactionorder_id' => 0);

        $items = $_POST;

        // print_r($items['details'][0]);
        // exit;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        $userdata = $ci->session->userdata;
        $status = 1;

        try {
            
             $sql = "BEGIN "
                    . " P_CRUD_TRANSACTIONORDER("
                    . " :i_qty, "
                    . " :i_ttl_amount,"
                    . " :i_status,"
                    . " :i_cus_payment,"
                    . " :i_user,"
                    . " :i_bu_id,"
                    . " :o_transactionorder_id,"
                    . " :o_msg_code,"
                    . " :o_msg"
                    . "); END;";

            $stmt = oci_parse($table->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_qty', $items['total_qty']);
            oci_bind_by_name($stmt, ':i_ttl_amount', $items['subtotal']);
            oci_bind_by_name($stmt, ':i_status', $status);
            oci_bind_by_name($stmt, ':i_cus_payment', $items['cash']);            
            oci_bind_by_name($stmt, ':i_user', $userdata['user_name']);
            oci_bind_by_name($stmt, ':i_bu_id', $userdata['bu_id']);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_transactionorder_id', $o_transactionorder_id, 2000000);
            oci_bind_by_name($stmt, ':o_msg_code', $o_msg_code, 2000000);
            oci_bind_by_name($stmt, ':o_msg', $o_msg, 2000000);

            ociexecute($stmt);

            if($o_msg_code == 0){


                for ($i=0; $i < count($items['details']); $i++) { 
                    $det = $items['details'][$i];

                    $sql_detail = "BEGIN "
                    . " P_CRUD_TRANSACTIONORDER_DT("
                    . " :i_transactionorder_id, "
                    . " :i_product_id,"
                    . " :i_qty,"
                    . " :i_sell_price,"
                    . " :i_amount,"
                    . " :i_user_det,"
                    . " :o_msg_code_det,"
                    . " :o_msg_det"
                    . "); END;";

                    $stmt_detail = oci_parse($table->db->conn_id, $sql_detail);

                    //  Bind the input parameter
                    oci_bind_by_name($stmt_detail, ':i_transactionorder_id', $o_transactionorder_id);
                    oci_bind_by_name($stmt_detail, ':i_product_id', $det['product_id']);
                    oci_bind_by_name($stmt_detail, ':i_qty', $det['qty']);
                    oci_bind_by_name($stmt_detail, ':i_sell_price', $det['product_price']);            
                    oci_bind_by_name($stmt_detail, ':i_amount', $det['total']);            
                    oci_bind_by_name($stmt_detail, ':i_user_det', $userdata['user_name']);

                    // Bind the output parameter
                    oci_bind_by_name($stmt_detail, ':o_msg_code_det', $o_msg_code_det, 2000000);
                    oci_bind_by_name($stmt_detail, ':o_msg_det', $o_msg_det, 2000000);

                    ociexecute($stmt_detail);

                    

                }                

                $data['success'] = true;                
                $data['message'] = $o_msg;
                $data['transactionorder_id'] = $o_transactionorder_id;
            }else{                
                $data['success'] = false;
                $data['message'] = $o_msg;
            }

        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
            $data['rows'] = $items;
        }

        return $data;
    }


    function printStruk(){
        
        $ci = & get_instance();
        $ci->load->model('transaction/cashier');
        $table = $ci->cashier;
        $userdata = $ci->session->userdata;

        $transactionorder_id = getVarClean('transactionorder_id','int',0);

        try {
            $printer = getPrinterName();
            $company = getCompany();

            $connector = new WindowsPrintConnector($printer['value']);

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text($company['name']."\n");
            $printer->text($company['address']."\n");
            $printer->text("No. telp: ".$company['no_telp']."\n\n"); 

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text();
            $printer->text(date("d/m/Y h:i:s")." (".$userdata['user_name'].")\n");
            $printer->text("--------------------------------\n");

            $sql = "SELECT * FROM vw_transactionorder_dt WHERE transactionorder_id = ?";
            $q = $ci->db->query($sql, array($transactionorder_id));
            $items = $q->result_array();

            $no = 1;
            foreach ($items as $item) {
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text($item['product_name']."\n");
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text($item['sell_price']."*".number_format($item['qty'],0,",",".")."             ".number_format($item['amount'],0,",",".")."\n");
            }

            $sqla = "SELECT transactionorder_id,
                            to_char(trx_date, 'dd/mm/yyyy hh24:mi:ss') trx_date,
                            to_char(created_date, 'yyyymmddhh24miss') created_date,
                            updated_date,
                            update_by,
                            created_by,
                            qty,
                            ttl_amount,
                            status,
                            cus_payment,
                            bu_id,
                            status_posting
                     FROM transactionorder 
                     WHERE transactionorder_id = ?";
            $qa = $ci->db->query($sqla, array($transactionorder_id));
            $row = $qa->row_array();

            $change = (float)$row["cus_payment"] - (float)$row["ttl_amount"];

            $printer->text("--------------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Total :  ".number_format($row["ttl_amount"],0,",",".")."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Cash  :  ".number_format($row["cus_payment"],0,",",".")."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("Change :  ".number_format($change,0,",",".")."\n\n");

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih atas kunjungan anda\n");
            $printer->text("Semoga lekas sembuh\n\n\n");
            // $printer->cut();
            
            /* Close printer */
            $printer->close();

            $data['success'] = true;                
            $data['message'] = 'berhasil cetak struk';

        } catch (Exception $e) {
            $data['success'] = false;                
            $data['message'] = 'gagal cetak struk :'.$e->getMessage();            
        }

        echo json_encode($data);
        exit;
    }


}

/* End of file Cashier_controller.php */