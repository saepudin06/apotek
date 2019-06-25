<?php
    function logging($message='') {

        $ci =& get_instance();
        $ci->load->model('administration/logs');
        $table = $ci->logs;

        $table->actionType = 'CREATE';
        $table->setRecord(
            array('log_desc' => $ci->session->userdata('user_name').' '.$message.' - Time : '.date('d-m-Y H:i:s'),
                  'log_user' => $ci->session->userdata('user_name'))
        );
        $table->create();
    }
?>