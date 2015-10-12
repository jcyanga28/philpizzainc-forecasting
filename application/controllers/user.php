<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');
		$this->load->model('User_model');
	}	

	public function index(){
		$module_id = "6";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			$this->getUser_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}
	} 

	public function getUser_Content($msg=''){
		$search = $this->input->get('search');

		$role_id = $this->session->userdata('role_id');
        
        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

        $data['jquery'] = array('table-sorter/table-sorter.js','script.js');

		$data['msg'] = $msg;	
		$data['search'] = $search;

		$data['user'] = $this->User_model->_getUserContent($search);
		$data['roles'] = $this->User_model->getRoles();

		$data["content"] = 'user';
		$this->load->view('backend/template', $data);


	}

	public function getuser_role(){
		$user_id = $this->input->post('user_id');

		if($user_id!=""){
		  print json_encode(array("status"=>"success","data"=>$user_id));
		
		}else{
		  $error_msg = "Error! Invalid data.";
		  print json_encode(array("status"=>"error","message"=>$error_msg));
	
		}
		
	}

	public function update_role(){
		$user_id = $this->input->post('user_id');
		$role = $this->input->post('userrole');

		if($user_id == "" || $role == ""){
			$error = "Error!";
			$error_msg = $error . ' ' . "Choose user role.";
			print json_encode(array("status"=>"error","message"=>$error_msg));

		}else{

			$result = $this->User_model->updateUserPwd($user_id,$role);
			
			if($result>0){
			print json_encode(array("status"=>"success","message"=>"User Role was successfully updated."));	
			}

		}
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/logout.php */
