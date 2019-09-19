<?php

/**
 * Invoice_receive Model
 *
 */
class Invoice_receive extends Abstract_model {

    public $table           = "";
    public $pkey            = "";
    public $alias           = "";   

    public $fields          = array();

    public $selectClause    = "invoice_id,
                               TO_CHAR(created_date, 'dd/mm/yyyy') created_date, 
                               TO_CHAR(update_date, 'dd/mm/yyyy') update_date, 
                               update_by,
                               created_by,
                               status,
                               TO_CHAR(invoice_date, 'dd/mm/yyyy') invoice_date,
                               invoice_num,
                               bu_id,
                               supplier_id,
                               invoice_ref,
                               amount,
                               trx_source,
                               TO_CHAR(due_date_payment, 'dd/mm/yyyy') due_date_payment,
                               type_source,
                               supplier_name";

    public $fromClause      = "vw_list_invoice";

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