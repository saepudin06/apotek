<?php

/**
 * Purchase_order_det Model
 *
 */
class Purchase_order_det extends Abstract_model {

    public $table           = "purchase_order_det";
    public $pkey            = "purchase_order_det_id";
    public $alias           = "";

    public $fields          = array(
                                'purchase_order_det_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Purchase Order Det ID'),
                                'purchase_req_det_id'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Purchase Request Det ID'),
                                'purchase_order_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Purchase Order ID'),
                                'qty'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Qty'),
                                'basic_price'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Basic Price'),
                                'exp_date'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Exp Date'),
                                'status_id'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Status'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(SELECT a.*, c.name product_name
                                FROM purchase_order_det a
                                LEFT JOIN purchase_req_det b ON a.purchase_req_det_id = b.purchase_req_det_id
                                LEFT JOIN products c ON b.product_id = c.product_id)";

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
            
            // $this->record['status_id'] = 1;

            // $this->db->set('exp_date',"to_date('".$this->record['exp_date']."','dd/mm/yyyy')",false);
            // unset($this->record['exp_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            // $this->db->set('exp_date',"to_date('".$this->record['exp_date']."','dd/mm/yyyy')",false);
            // unset($this->record['exp_date']);

        }
        return true;
    }


    public function getPODet($purchase_order_id, $orderby, $serach = '')
    {
        if($orderby == ""){
            $orderby = "asc";
        }

        $sql = "SELECT a.*, nvl(b.purchase_order_det_id,0) purchase_order_det_id, b.purchase_order_id, nvl(b.qty, a.qty) po_qty, nvl(b.basic_price, a.basic_price) po_basic_price,  nvl(b.status_id,1) status_id, nvl(d.val_1,'Purchase Request') status_code, c.name product_name
                FROM purchase_req_det a
                LEFT JOIN purchase_order_det b ON a.purchase_req_det_id=b.purchase_req_det_id AND b.purchase_order_id = ?
                LEFT JOIN products c ON a.product_id=c.product_id
                LEFT JOIN referencelist d ON b.status_id=d.reference_list_id
                WHERE c.name like '%".$serach."%'
                order by c.name ".$orderby;
        // print_r($sql);
        // exit;
        $q = $this->db->query($sql, array($purchase_order_id));
        return $q->result_array();
    }

    public function deleteItem($purchase_order_det_id) {
        $sql = "delete from purchase_order_det where purchase_order_det_id = ?";
        $this->db->query($sql, array($purchase_order_det_id));

    }

    public function updatePO($purchase_order_id) {
        $item = array();
        $sqlselect = "select nvl(sum(qty*basic_price),0) total
                        from purchase_order_det 
                        where purchase_order_id = 2";
        $q = $this->db->query($sqlselect, array($purchase_order_id));
        $item = $q->row_array();
        
        $sql = "update purchase_order set 
                amount = ?
                where purchase_order_id = ?";
        $this->db->query($sql, array($item['total'], $purchase_order_id));

    }
}

/* End of file Roles.php */