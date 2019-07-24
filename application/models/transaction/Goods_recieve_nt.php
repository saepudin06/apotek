<?php

/**
 * Goods_recieve_nt Model
 *
 */
class Goods_recieve_nt extends Abstract_model {

    public $table           = "goods_recieve_nt";
    public $pkey            = "goods_recieve_nt";
    public $alias           = "";   

    public $fields          = array(
                                'goods_recieve_nt'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'purchase_order_id'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Purchase Order ID'),
                                'status'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Status'),
                                'amount'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Amount'),
                                'notes'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Notes'),
                                'qty'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Qty'),
                                'grn_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Date'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "goods_recieve_nt, purchase_order_id, status, amount, notes, qty, to_char(grn_date,'dd/mm/yyyy') grn_date, invoice_num_ref";
    public $fromClause      = "(select a.*, b.invoice_num_ref
                                from goods_recieve_nt a
                                left join purchase_order b on a.purchase_order_id=b.purchase_order_id)";

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
            
            $this->record['amount'] = 0;
            $this->record['qty'] = 0;


            $this->db->set('grn_date',"to_date('".$this->record['grn_date']."','dd/mm/yyyy')",false);
            unset($this->record['grn_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('grn_date',"to_date('".$this->record['grn_date']."','dd/mm/yyyy')",false);
            unset($this->record['grn_date']);
        }
        return true;
    }



}

/* End of file Roles.php */