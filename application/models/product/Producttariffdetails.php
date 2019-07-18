<?php

/**
 * Producttariffdetails Model
 *
 */
class Producttariffdetails extends Abstract_model {

    public $table           = "producttariffdetails";
    public $pkey            = "prod_tariff_id";
    public $alias           = "";

    public $fields          = array(
                                'prod_tariff_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'Product Tariff ID'),                                
                                'prd_details_id'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Product Detail ID'),
                                'sell_price'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Sell Price'),
                                'basic_price'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Basic Price'),
                                'tax'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Tax'),
                                'price_note'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Price Note'),
                                'start_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Start Date'),
                                'end_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'End Date'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "*";
    public $fromClause      = "(select a.prod_tariff_id, 
                                       a.prd_details_id, 
                                       a.sell_price, 
                                       a.basic_price, 
                                       a.tax, 
                                       a.created_date, 
                                       a.created_by, 
                                       a.update_date, 
                                       a.update_by, 
                                       a.price_note, 
                                       to_char(a.start_date, 'dd/mm/yyyy') start_date, 
                                       to_char(a.end_date, 'dd/mm/yyyy') end_date, 
                                       b.product_id,
                                       b.product_label,
                                       c.name product_name
                                       from producttariffdetails a 
                                left join productdetails b on a.prd_details_id=b.prd_details_id
                                left join products c on b.product_id=c.product_id )";

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

            $this->db->set('start_date',"to_date('".$this->record['start_date']."','dd/mm/yyyy')",false);
            unset($this->record['start_date']);

            $this->db->set('end_date',"to_date('".$this->record['end_date']."','dd/mm/yyyy')",false);
            unset($this->record['end_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('start_date',"to_date('".$this->record['start_date']."','dd/mm/yyyy')",false);
            unset($this->record['start_date']);

            $this->db->set('end_date',"to_date('".$this->record['end_date']."','dd/mm/yyyy')",false);
            unset($this->record['end_date']);

        }
        return true;
    }



}

/* End of file Roles.php */