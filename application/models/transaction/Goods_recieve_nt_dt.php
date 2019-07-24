<?php

/**
 * Goods_recieve_nt_dt Model
 *
 */
class Goods_recieve_nt_dt extends Abstract_model {

    public $table           = "goods_recieve_nt_dt";
    public $pkey            = "good_rcv_nt_dt_id";
    public $alias           = "";   

    public $fields          = array(
                                'good_rcv_nt_dt_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'goods_recieve_nt'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Goods Receive Note ID'),
                                'purchase_order_det_id'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Purchase Order Detail ID'),
                                'status'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Status'),
                                'basic_price'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Basic Price'),
                                'qty'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Qty'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(select a.*, e.name product_name, f.invoice_num_ref, due_date_payment
                                from goods_recieve_nt_dt a
                                left join goods_recieve_nt b on a.goods_recieve_nt = b.goods_recieve_nt
                                left join purchase_order_det c on a.purchase_order_det_id = c.purchase_order_det_id
                                left join purchase_req_det d on c.purchase_req_det_id = d.purchase_req_det_id
                                left join products e on d.product_id = e.product_id
                                left join purchase_order f on b.purchase_order_id = f.purchase_order_id)";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            
            $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];
            
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

        }
        return true;
    }



}

/* End of file Roles.php */