<?php

function jsonDecode($data) {

	if (empty($data)) return array();

    $items = json_decode($data, true);

    if ($items == NULL){
        throw new Exception('JSON items could not be decoded');
    }

    return $items;
}

function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
}

function html_spaces($number=1) {
    $result = "";
    for($i = 1; $i <= $number; $i++) {
        $result .= "&nbsp;";
    }
    return $result;
}

function getCompany(){
    $ci = & get_instance();
    $ci->load->model('admin/company');
    $table = $ci->company;

    $sql = "SELECT   company_id, name, address, no_telp, no_hp, email, website, registration_num, subtitle, logo, tax_num, city, created_date, update_date, created_by, update_by, to_char(since_date, 'dd/mm/yyyy') since_date
                      FROM   company WHERE rownum = 1";

    $result = $table->db->query($sql);
    $rows = $result->row_array();

    if(count($rows) == 0){
        $row['company_id'] = '0';
        $row['name'] = 'PT. Xxxxxxxx Xxxxx';
        $row['address'] = 'Jln. Xxxxxxxx Xxxxxxxx';
        $row['no_telp'] = '-';
        $row['no_hp'] = '-';
        $row['email'] = '-';
        $row['website'] = '-';
        $row['registration_num'] = '-';
        $row['subtitle'] = 'PT. Xxxxxxxx Xxxxx';
        $row['logo'] = '-';
        $row['tax_num'] = '-';
        $row['city'] = '-';
        $row['created_date'] = '-';
        $row['update_date'] = '-';
        $row['created_by'] = '-';
        $row['update_by'] = '-';
        $row['since_date'] = '-';
    }else{
        if($rows['logo'] == ""){
            $rows['logo'] = 'upload/default-logo.PNG';
        }        
    }

    return $rows;
}

?>