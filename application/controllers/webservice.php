<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require(APPPATH.'/libraries/REST_Controller.php');

class Webservice extends REST_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Webservice_model');	
	
	}	

//--------webservice post maintenance-----------------//

	public function maintenance_post(){
		// print_r($_POST);

		//user//
		$user = json_decode($this->input->post('users'));

		$this->Webservice_model->webservice_UserMaintenancePost($user);
		
		//item//
		$item = json_decode($this->input->post('items'));

		$this->Webservice_model->webservice_ItemMaintenancePost($item);

		//location//
		$branch = json_decode($this->input->post('branch'));

		$this->Webservice_model->webservice_BranchMaintenancePost($branch);


		$data = array('status' => 'ok');
		// // // // print_r($data);
		$this->response($data, 200);
	} 
	

}
/* End of file welcome.php */
/* Location: ./application/controllers/webservice.php */
