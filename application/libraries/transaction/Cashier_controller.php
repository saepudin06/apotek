<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

        $sql = "SELECT a.product_id, a.name product_name, b.product_label, c.sell_price
                FROM products a
                LEFT JOIN productdetails b ON a.product_id = b.product_id
                LEFT JOIN producttariffdetails c ON b.prd_details_id = c.prd_details_id
                WHERE b.product_label = ?";

        $result = $table->db->query($sql, array($product_label));
        $rows = $result->row_array();

        $data['total'] = count($rows);
        $data['success'] = true;
        $data['message'] = 'sukses';
        $data['rows'] = $rows;
      
        echo json_encode($data);
        exit;
    }


}

/* End of file Cashier_controller.php */