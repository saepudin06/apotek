<?php

/**
 * Financeperiod Model
 *
 */
class Financeperiod extends Abstract_model {

    public $table           = "financeperiod";
    public $pkey            = "finance_period_id";
    public $alias           = "";

    public $fields          = array(
                                'finance_period_id'       => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'year_period_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Periode Tahun ID'),
                                'code'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Periode Keuangan'),
                                'production_date'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Tanggal Dibuat'),
                                'description'      => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Keterangan'),
                                'created_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'update_date'  => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'update_by'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),

                            );

    public $selectClause    = "finance_period_id, year_period_id, year_code, code, to_char(production_date, 'dd/mm/yyyy') production_date, description, created_date, created_by, update_date, update_by";
    public $fromClause      = "(select a.*, b.code year_code 
                                from financeperiod a
                                left join yearperiod b on a.year_period_id=b.year_period_id)";

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

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

          
        }else {
            //do something
            //example:
            
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            $this->db->set('production_date',"to_date('".$this->record['production_date']."','dd/mm/yyyy')",false);
            unset($this->record['production_date']);
        }
        return true;
    }



}

/* End of file Roles.php */