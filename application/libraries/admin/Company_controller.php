<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Company_controller
* @version 07/05/2015 12:18:00
*/
class Company_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','company_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $i_search = getVarClean('i_search','str','');

        try {

            $ci = & get_instance();
            $ci->load->model('admin/company');
            $table = $ci->company;

            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();
            if(!empty($i_search)) {
                $table->setCriteria("( upper(name) like upper('%".$i_search."%') OR 
                                       upper(registration_num) like upper('%".$i_search."%')
                                     )");
            }

            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;
            
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :
                $data = $this->create();
            break;

            case 'edit' :
                $data = $this->update();
            break;

            case 'del' :
                $data = $this->destroy();
            break;

            default :
                $data = $this->read();
            break;
        }

        return $data;
    }

    function create() {


        $ci = & get_instance();
        $ci->load->model('admin/company');
        $table = $ci->company;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }


        $table->actionType = 'CREATE';
        $errors = array();

        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|JPG|JPEG|png|PNG|gif|GIF';
        $config['max_size'] = '10000000';
        $config['overwrite'] = TRUE;
        $config['file_name'] = "logo";

        $ci->load->library('upload');
        $ci->upload->initialize($config);

        if (isset($items[0])){
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{

                    if ($_FILES['logo']['name'] != ''){
                        if (!$ci->upload->do_upload("logo")) {
                            throw new Exception( $ci->upload->display_errors() );
                        }else{
                            $filedata = $ci->upload->data();
                            $file_name = $filedata['file_name'];
                            $items[$i]['logo'] = "upload/".$file_name;
                        }
                    }

                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->create();

                    $table->db->trans_commit(); //Commit Trans

                }catch(Exception $e){

                    $table->db->trans_rollback(); //Rollback Trans
                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data added successfully';
            }
            $data['rows'] =$items;
        }else {

            try{

                if ($_FILES['logo']['name'] != ''){
                    if (!$ci->upload->do_upload("logo")) {
                        throw new Exception( $ci->upload->display_errors() );
                    }else{
                        $filedata = $ci->upload->data();
                        $file_name = $filedata['file_name'];
                        $items['logo'] = "upload/".$file_name;
                    }
                }

                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->create();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data added successfully';
                

            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function update() {

        $ci = & get_instance();
        $ci->load->model('admin/company');
        $table = $ci->company;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $items = $_POST;

        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }

        //exit;

        $table->actionType = 'UPDATE';

        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|JPG|JPEG|png|PNG|gif|GIF';
        $config['max_size'] = '10000000';
        $config['overwrite'] = TRUE;
        $config['file_name'] = "logo";

        $ci->load->library('upload');
        $ci->upload->initialize($config);

        if (isset($items[0])){
            
            $errors = array();
            $numItems = count($items);
            for($i=0; $i < $numItems; $i++){
                try{

                    if ($_FILES['logo']['name'] != ''){
                        if (!$ci->upload->do_upload("logo")) {
                            throw new Exception( $ci->upload->display_errors() );
                        }else{
                            $filedata = $ci->upload->data();
                            $file_name = $filedata['file_name'];
                            $items[$i]['logo'] = "upload/".$file_name;
                        }
                    }

                    $table->db->trans_begin(); //Begin Trans

                        $table->setRecord($items[$i]);
                        $table->update();

                    $table->db->trans_commit(); //Commit Trans

                    $items[$i] = $table->get($items[$i][$table->pkey]);
                }catch(Exception $e){
                    $table->db->trans_rollback(); //Rollback Trans

                    $errors[] = $e->getMessage();
                }
            }

            $numErrors = count($errors);
            if ($numErrors > 0){
                $data['message'] = $numErrors." from ".$numItems." record(s) failed to be saved.<br/><br/><b>System Response:</b><br/>- ".implode("<br/>- ", $errors)."";
            }else{
                $data['success'] = true;
                $data['message'] = 'Data update successfully';
            }
            $data['rows'] =$items;
        }else {
            
            try{

                if ($_FILES['logo']['name'] != ''){
                    if (!$ci->upload->do_upload("logo")) {
                        throw new Exception( $ci->upload->display_errors() );
                    }else{
                        $filedata = $ci->upload->data();
                        $file_name = $filedata['file_name'];
                        $items['logo'] = "upload/".$file_name;
                    }
                }

                $table->db->trans_begin(); //Begin Trans

                    $table->setRecord($items);
                    $table->update();

                $table->db->trans_commit(); //Commit Trans

                $data['success'] = true;
                $data['message'] = 'Data update successfully';
                
                $data['rows'] = $table->get($items[$table->pkey]);
            }catch (Exception $e) {
                $table->db->trans_rollback(); //Rollback Trans

                $data['message'] = $e->getMessage();
                $data['rows'] = $items;
            }

        }
        return $data;

    }

    function destroy() {

        $ci = & get_instance();
        $ci->load->model('admin/company');
        $table = $ci->company;

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        $jsonItems = getVarClean('items', 'str', '');
        $data = jsonDecode($jsonItems);

        $items = $data["id_"];

        try{
            $table->db->trans_begin(); //Begin Trans

            $total = 0;
            if (is_array($items)){
                foreach ($items as $key => $value){
                    if (empty($value)) throw new Exception('Empty parameter');
                    $table->remove($value);
                    $data['rows'][] = array($table->pkey => $value);
                    $total++;
                }
            }else{
                $items = (int) $items;
                if (empty($items)){
                    throw new Exception('Empty parameter');
                }
                $table->remove($items);
                $data['rows'][] = array($table->pkey => $items);
                $data['total'] = $total = 1;
            }

            $data['records'] = 0;
            $data['page'] = 1;
            $data['success'] = true;
            $data['message'] = $total.' Data deleted successfully';
            
            $table->db->trans_commit(); //Commit Trans

        }catch (Exception $e) {
            $table->db->trans_rollback(); //Rollback Trans
            $data['message'] = $e->getMessage();
            $data['rows'] = array();
            $data['total'] = 0;
        }
        return $data;
    }

    function getcompany() {

            $data = array('rows' => array(), 'success' => false, 'message' => '');

            $ci = & get_instance();
            $ci->load->model('admin/company');
            $table = $ci->company;

            $sql = "SELECT   company_id, name, address, no_telp, no_hp, email, website, registration_num, subtitle, logo, tax_num, city, created_date, update_date, created_by, update_by, to_char(since_date, 'dd/mm/yyyy') since_date
                      FROM   company WHERE rownum = 1";

            $result = $table->db->query($sql);
            $rows = $result->row_array();

            $data['success'] = true;
            $data['message'] = 'sukses';
            $data['rows'] = $rows;
          
            echo json_encode($data);
            exit;

    }

    function remove_img() {
        $data = array('rows' => array(), 'success' => false, 'message' => '');

        $ci = & get_instance();
        $ci->load->model('admin/company');
        $table = $ci->company;

        $company_id = getVarClean('company_id', 'int', 0);

        $sql = "UPDATE company SET
                logo = ''
                WHERE company_id = ?";

        $table->db->query($sql, array($company_id));
        

        $data['success'] = true;
        $data['message'] = 'sukses';
      
        echo json_encode($data);
        exit;
        
    }

}

/* End of file Company_controller.php */