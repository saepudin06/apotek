<?php
/**
* Web Service Controller.
* @version 1.0 07/05/2015 12:29:36
* @author Wiliam Decosta
*/
class Ws extends CI_Controller {

	function index() {
		$this->load->view('ws_info');
	}

	/*function json($class_name, $func_name) {

		try {
			check_login(true);

			$class_location = explode(".",$class_name);
			if(count($class_location) > 1) {
			    $this->load->library($class_location[0]."/".$class_location[1]);
			    $class_name = $class_location[1];
			}else {
			    $this->load->library($class_name);
			}

			$result = $this->$class_name->$func_name();
		}catch(Exception $e) {
			$result = array('items' => array(), 'success' => false, 'message' => $e->getMessage());
		}

		header('Content-Type: application/json');
		echo json_encode($result);
        session_write_close();
	}*/

	function json($class_name, $func_name) {

		try {
			check_login();

			$class_location = explode(".",$class_name);
			if(count($class_location) > 1) {
			    $this->load->library($class_location[0]."/".$class_location[1]);
			    $class_name = $class_location[1];
			}else {
			    $this->load->library($class_name);
			}

			$result = $this->$class_name->$func_name();
			//$result['rows'] = $result['items'];
			//unset($result['items']);

			$result['current'] = (int)$result['current'];
			$result['rowCount'] = (int)$result['rowCount'];
			$result['total'] = (int)$result['total'];

		}catch(Exception $e) {
			$result = array('rows' => array(), 'success' => false, 'current' => 1, 'rowCount' => 1, 'total' => 0, 'message' => $e->getMessage());
		}

		header('Content-Type: application/json');
		echo json_encode($result);
        session_write_close();
	}


	function json_jqgrid($class_name, $func_name) {

		try {
			check_login();

			$class_location = explode(".",$class_name);
			if(count($class_location) > 1) {
			    $this->load->library($class_location[0]."/".$class_location[1]);
			    $class_name = $class_location[1];
			}else {
			    $this->load->library($class_name);
			}

			$result = $this->$class_name->$func_name();

			$result['page'] = (int)$result['page'];
			$result['records'] = (int)$result['records'];
			$result['total'] = (int)$result['total'];
			$result['message'] = $result['message'];
			$result['success'] = $result['success'];
		}catch(Exception $e) {
			$result = array('message' => $e->getMessage(), 'success' => false);
		}

		header('Content-Type: application/json');
		echo json_encode($result);
        session_write_close();
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/ws.php */