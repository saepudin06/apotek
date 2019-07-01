<?php

/**
 * Productdetails Model
 *
 */
class Productdetails extends Abstract_model {

    public $table           = "productdetails";
    public $pkey            = "prd_details_id";
    public $alias           = "";

    public $fields          = array(
                                'prd_details_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Product Detail ID'),                                
                                'product_id'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Product ID'),
                                'product_label'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Product Label'),
                                'production_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Production Date'),
                                'sales_start_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Sales Start Date'),
                                'sales_end_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Sales End Date'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(select a.prd_details_id, 
                                       a.product_id, 
                                       to_char(a.production_date, 'dd/mm/yyyy') production_date, 
                                       a.created_date, 
                                       a.created_by, 
                                       a.update_date, 
                                       a.update_by, 
                                       a.product_label, 
                                       to_char(a.sales_start_date, 'dd/mm/yyyy') sales_start_date, 
                                       to_char(a.sales_end_date, 'dd/mm/yyyy') sales_end_date, 
                                       b.name product_name 
                                       from productdetails a 
                                left join products b on a.product_id=b.product_id)";

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

            $this->db->set('production_date',"to_date('".$this->record['production_date']."','dd/mm/yyyy')",false);
            unset($this->record['production_date']);

            $this->db->set('sales_start_date',"to_date('".$this->record['sales_start_date']."','dd/mm/yyyy')",false);
            unset($this->record['sales_start_date']);

            $this->db->set('sales_end_date',"to_date('".$this->record['sales_end_date']."','dd/mm/yyyy')",false);
            unset($this->record['sales_end_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('production_date',"to_date('".$this->record['production_date']."','dd/mm/yyyy')",false);
            unset($this->record['production_date']);

            $this->db->set('sales_start_date',"to_date('".$this->record['sales_start_date']."','dd/mm/yyyy')",false);
            unset($this->record['sales_start_date']);

            $this->db->set('sales_end_date',"to_date('".$this->record['sales_end_date']."','dd/mm/yyyy')",false);
            unset($this->record['sales_end_date']);

        }
        return true;
    }



}

/* End of file Roles.php */