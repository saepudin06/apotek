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
                                'goods_recieve_nt_id'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Goods Receive Note ID'),
                                'purchase_order_det_id'    => array('nullable' => true, 'type' => 'int', 'unique' => false, 'display' => 'Purchase Order Detail ID'),
                                'status'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Status'),
                                'exp_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tgl. Kedaluwarsa'),
                                'note'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Catatan'),
                                'store_info_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Info Penyimpanan'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "cd_unq,
                               product_name,
                               store_info,
                               created_date,
                               update_date,
                               update_by,
                               created_by,
                               TO_CHAR (exp_date, 'dd/mm/yyyy') exp_date,
                               note,
                               status,
                               goods_recieve_nt_id,
                               good_rcv_nt_dt_id,
                               qty,
                               basic_price,
                               amount,
                               store_info_id";
                               
    public $fromClause      = "vw_list_grn_dt";

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

            $this->db->set('exp_date',"to_date('".$this->record['exp_date']."','dd/mm/yyyy')",false);
            unset($this->record['exp_date']);
            
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);

            $this->db->set('exp_date',"to_date('".$this->record['exp_date']."','dd/mm/yyyy')",false);
            unset($this->record['exp_date']);
            $this->record['update_by'] = $userdata['user_name'];

        }
        return true;
    }



}

/* End of file Roles.php */