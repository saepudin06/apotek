<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('generatehtml')) {

    function inputan($type, $names, $class, $placeholder, $required, $values, $tags)
    {
        if (empty($tags)) {
            $tagtemp = "";
        } else {
            $tagtemp = "";
            foreach ($tags as $name => $tag) {
                $tagtemp = $tagtemp . " $name='$tag' ";
            }
        }
        $requred = $required == 0 ? '' : "required='required'";
        return "<div class='$class'><input type='$type' name='$names' placeholder='$placeholder' class='form-control' $requred value='$values' $tagtemp></div>";
    }


    // ---------------------------------- Textarea --------------------------------------------
    function textarea($name, $id, $class, $rows, $values)
    {
        return "<div class='$class'><textarea name='" . $name . "' id='" . $id . "' rows='" . $rows . "' class='form-control'>" . $values . "</textarea></div>";
    }


    function email($name, $placeholder, $required, $value)
    {
        $requred = $required == 0 ? '' : "required='required'";
        return "<input type='email' placeholder='$placeholder' name='$name' $required class='input-large' value='$value'>";
    }

    function combodumy($name, $id)
    {
        return "<select name='$name' id='$id' class='form-control'><option value='0'>Pilih data</option></select>";
    }

    function bulan($default_select, $selected)
    {
        $arr_bulan = array('01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember');

        echo "<select name='bulan' id='bulan' class='form-control'>";
        if ($default_select != "") {
            echo "<option value=''> " . $default_select . " </option> ";
        }
        foreach ($arr_bulan as $key => $value) {
            if ($selected == $key) {
                echo "<option value=" . $key . " selected>" . $value . "</option>";
            } else {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }

        }
        echo "</select>";
    }

    function tahun($default_select, $selected)
    {
        echo "<select name='tahun' id='tahun' class='form-control'>";

        if ($default_select != "") {
            echo "<option value=''> " . $default_select . " </option> ";
        }

        $year = date("Y");
        for ($i = ($year); $i >= $year - 5; $i--) {

            if ($selected == $i) {
                echo "<option value=" . $i . " selected>" . $i . "</option>";
            } else {
                echo "<option value=" . $i . ">" . $i . "</option>";
            }

        }
        echo "</select>";


    }


    function buatcombo($nama, $id, $table, $field, $pk, $kondisi,$required, $default_select)
    {
        $CI =& get_instance();
        $CI->load->model('M_helper');

        if ($kondisi == null) {
            $data = $CI->M_helper->getCombo($table, $field, $pk)->result();
        } else {
            $data = $CI->M_helper->getComboByID($table, $field, $pk, $kondisi)->result();

        }

        if($required == "Y"){
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control required' required>";
        }else{
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control'>";
        }


        if ($default_select != "") {
            echo "<option value=''> " . $default_select . " </option> ";
        }

        foreach ($data as $r) {
            echo " <option value=" . $r->$pk . ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select>";
    }

     function buatcombo2($nama, $id, $table, $field, $pk, $kondisi,$required, $default_select)
    {
        $CI =& get_instance();
        $CI->load->model('M_helper');

        if ($kondisi == null) {
            $data = $CI->M_helper->getCombo2($table, $field, $pk)->result();
        } else {
            $data = $CI->M_helper->getComboByID2($table, $field, $pk, $kondisi)->result();

        }

        if($required == "Y"){
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control required' required>";
        }else{
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control'>";
        }


        if ($default_select != "") {
            echo "<option value=''> " . $default_select . " </option> ";
        }

        foreach ($data as $r) {
            echo " <option value=" . $r->$pk . ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select>";
    }


    function buatcombo3($nama, $id, $table, $field, $pk, $kondisi,$required, $emptyText, $default_select)
    {
        $CI =& get_instance();
        $CI->load->model('M_helper');

        if ($kondisi == null) {
            $data = $CI->M_helper->getCombo2($table, $field, $pk)->result();
        } else {
            $data = $CI->M_helper->getComboByID2($table, $field, $pk, $kondisi)->result();

        }

        if($required == "Y"){
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control required' required>";
        }else{
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control'>";
        }

        echo '<option value="">'.$emptyText.'</option>';

        foreach ($data as $r) {
            if($r->$pk == $default_select)
                echo " <option value=" . $r->$pk . " selected>" . strtoupper($r->$field) . "</option>";
            else
                echo " <option value=" . $r->$pk . ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select>";
    }

    function buatcombo4($nama, $id, $table, $field, $pk, $kondisi,$required, $emptyText, $default_select)
    {
        $CI =& get_instance();
        $CI->load->model('M_helper');

        if ($kondisi == null) {
            $data = $CI->M_helper->getCombo($table, $field, $pk)->result();
        } else {
            $data = $CI->M_helper->getComboByID($table, $field, $pk, $kondisi)->result();

        }

        if($required == "Y"){
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control required' required>";
        }else{
            echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control'>";
        }

        echo "<option value=''> " . $emptyText . " </option> ";

        foreach ($data as $r) {
            if($r->$pk == $default_select)
                echo " <option value=" . $r->$pk . " selected>" . strtoupper($r->$field) . "</option>";
            else
                echo " <option value=" . $r->$pk . ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select>";
    }


    function buatcombo_new($nama, $id, $table, $field, $pk, $kondisi, $default_select,$order_by,$order_type)
    {
        $CI =& get_instance();
        $CI->load->model('M_helper');

        if ($kondisi == null) {
            $data = $CI->M_helper->getComboNew($table, $field, $pk,$order_by,$order_type)->result();
        } else {
            $data = $CI->M_helper->getComboByIDNew($table, $field, $pk, $kondisi,$order_by,$order_type)->result();
        }
        echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control'>";

        if ($default_select != "") {
            echo "<option value=''> " . $default_select . " </option> ";
        }

        foreach ($data as $r) {
            echo " <option value=" . $r->$pk . ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select>";
    }

    function combo_segmen()
    {
        $CI =& get_instance();
        $CI->load->model('M_helper');

        $pgl_id = $CI->session->userdata('d_pgl_id');
        if ($pgl_id) {
            $q = $CI->db->query("SELECT DISTINCT(CODE_SGM) SEGMENS,CODE_SGM||' - '||SEGMENT_NAME SEGMEN_NAME
                                  FROM MV_PARAM_SEGMENT_CC
                                  WHERE ID IN
                                (
                                SELECT ID_CC FROM P_MAP_MIT_CC
                                    WHERE PGL_ID = " . $pgl_id . "
                                ) ORDER BY SEGMENS
                                ")->result();
        } else {
            $q = $CI->db->query("SELECT DISTINCT(CODE_SGM) SEGMENS,CODE_SGM||' - '||SEGMENT_NAME SEGMEN_NAME
                                  FROM MV_PARAM_SEGMENT_CC ORDER BY SEGMENS")->result();
        }

        echo "<select name='segment' id='segment'  class='form-control'>";

        echo "<option value=''> Pilih Segmen </option> ";


        foreach ($q as $r) {
            echo " <option value=" . $r->SEGMENS . ">" . $r->SEGMEN_NAME . "</option>";
        }
        echo "</select>";
    }

    function editcombo($nama, $table, $class, $field, $pk, $kondisi, $tags, $value)
    {
        $CI =& get_instance();
        $CI->load->model('M_helper');
        if (empty($tags)) {
            $tagtemp = "";
        } else {
            $tagtemp = "";
            foreach ($tags as $name => $tag) {
                $tagtemp = $tagtemp . " $name='$tag' ";
            }
        }
        if ($kondisi == null) {
            $data = $CI->M_helper->getAll($table)->result();
        } else {
            $data = $CI->db->get_where($table, $kondisi)->result();
        }
        echo "<div class='$class'><select class='form-control' name='" . $nama . "' $tagtemp>";
        foreach ($data as $r) {
            echo "<option value='" . $r->$pk . "' ";
            echo $r->$pk == $value ? "selected='selected'" : "";
            echo ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select></div>";
    }

    function getStringMonth($bulan)
    {
        $arr_bulan = array('01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember');

        return $arr_bulan[$bulan];
    }

    function getUserName(){
        $CI =& get_instance();
        return $CI->session->userdata('user_name');
    }


    function array_to_xml($array, &$xml_user_info) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml_user_info->addChild("$key");
                    array_to_xml($value, $subnode);
                }else{
                    $subnode = $xml_user_info->addChild("item$key");
                    array_to_xml($value, $subnode);
                }
            }else {
                $xml_user_info->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }

    function change_date_format($source = ''){
        if($source != ''){
            $date = DateTime::createFromFormat('d/m/Y', $source);
            $data = $date->format('Ymd').' 00:00:00';
            return $data;
        }else{
            return '';
        }
    }

    function getColomTable($table, $conn = 'default'){

        $CI =& get_instance();
        $CI->load->model('M_helper');

        $q = $CI->db->query("SELECT TABLE_NAME,
                                    COLUMN_NAME, NULLABLE, DATA_TYPE, column_id
                                FROM dba_tab_columns
                                    WHERE TABLE_NAME = upper('".$table."')
                                    AND COLUMN_NAME <> 'ACCOUNT_NUM'
                                    order by column_id asc
                            ")->result();
        return $q;

    }

    function genAttr($table){

        $data = getColomTable($table = $table, $conn = 'default');
        $ret ='';
        foreach ($data as $key => $value) {

            // temporary set required for all, change it from table accountattributes
            $required = $value->nullable == 'Y' ? 'required' : '';

            $dataType = $value->data_type == 'NUMBER' ? 'number' : 'text';
            $oKU = '';
            if($value->column_name == 'NPWP'){ // need to change to parameter
                //$oKU = "onkeypress='return isAlphaNumeric(event);'";
            }
            // change this condition to parameter ASAP
            if($value->column_name == 'IS_MONTHLY_INVOICE'){
                $ret .= "<div class='form-group'>
                            <label class='control-label col-md-4 '>".ucwords(strtolower(str_replace('_',' ',$value->column_name)))."
                            </label>
                            <div class='col-md-8'>
                            <select class='form-control uppercase ".$required."' ".$required." name='".$value->column_name."' id='".$value->column_name."'>

                                                            <option value='N'>No</option>
                                                            <option value='Y'>Yes</option>
                                                        </select>
                            </div>
                        </div>";
            }elseif($value->column_name == 'BUSINESS_SHARE'){
                $ret .=  "<div class='form-group'>
                            <label class='control-label col-md-4'>".ucwords(strtolower(str_replace('_',' ',$value->column_name)))."
                            </label>
                            <div class='col-md-8'>
                                <div class='input-group'>
                                    <input type='hidden' class='form-control' name='".$value->column_name."_ID' id='".$value->column_name."_ID' readonly>
                                    <input type='".$dataType."' class='a form-control uppercase  ".$required."' name='".$value->column_name."' id='".$value->column_name."' ".$required." ".$oKU."  readonly>
                                    <span class='input-group-btn'>
                                        <button class='btn btn-success' type='button' id='btn-lov-busines'>
                                        <i class='fa fa-search'></i>
                                    </span>
                                </div>
                            </div>
                        </div> ";
            }else{

                $ret .=  "<div class='form-group'>
                            <label class='control-label col-md-4'>".ucwords(strtolower(str_replace('_',' ',$value->column_name)))."
                            </label>
                            <div class='col-md-8'>
                                <input type='".$dataType."' class='a form-control uppercase ".$required."' name='".$value->column_name."' id='".$value->column_name."' ".$required." ".$oKU." maxlength='40'>
                            </div>
                        </div> ";

            }

        }
        return $ret;

    }

    function getSysdate(){

        $CI =& get_instance();
        $CI->load->model('M_helper');

        $q = $CI->db->query("select to_char( pack_lov.get_system_date, 'yyyy-mm-dd hh24:mi:ss')  dat from dual
                            ")->result();

        foreach ($q as $key => $value) {
            return $value->dat;
        }

    }

    function filterToolbarJqgrid($filters, $search){

    $where = "";

    if(($search==true) &&($filters != "")) {


        $filters = json_decode($filters);
        $where = "  ";
        $whereArray = array();
        $rules = $filters->rules;
        $groupOperation = $filters->groupOp;
        $i = 0;
        foreach($rules as $rule) {

            $fieldName = $rule->field;
            //$fieldData = mysql_real_escape_string($rule->data);
            $fieldData = $rule->data;
            switch ($rule->op) {
           case "eq":
                $fieldOperation = " = '".$fieldData."'";
                break;
           case "ne":
                $fieldOperation = " != '".$fieldData."'";
                break;
           case "lt":
                $fieldOperation = " < '".$fieldData."'";
                break;
           case "gt":
                $fieldOperation = " > '".$fieldData."'";
                break;
           case "le":
                $fieldOperation = " <= '".$fieldData."'";
                break;
           case "ge":
                $fieldOperation = " >= '".$fieldData."'";
                break;
           case "nu":
                $fieldOperation = " = ''";
                break;
           case "nn":
                $fieldOperation = " != ''";
                break;
           case "in":
                $fieldOperation = " IN (".$fieldData.")";
                break;
           case "ni":
                $fieldOperation = " NOT IN '".$fieldData."'";
                break;
           case "bw":
                $fieldOperation = " LIKE '".$fieldData."%'";
                break;
           case "bn":
                $fieldOperation = " NOT LIKE '".$fieldData."%'";
                break;
           case "ew":
                $fieldOperation = " LIKE '%".$fieldData."'";
                break;
           case "en":
                $fieldOperation = " NOT LIKE '%".$fieldData."'";
                break;
           case "cn":
                $fieldOperation = " LIKE '%".$fieldData."%'";
                break;
           case "nc":
                $fieldOperation = " NOT LIKE '%".$fieldData."%'";
                break;
            default:
                $fieldOperation = "";
                break;
                }
            if($fieldOperation != "") $whereArray[] = $fieldName.$fieldOperation;
            $i++;
        }
        if (count($whereArray)>0 && $i > 0) {
            $where .= join(" ".$groupOperation." ", $whereArray);
        } else {
            $where = "";
        }
    }
        return $where;
    }



}







