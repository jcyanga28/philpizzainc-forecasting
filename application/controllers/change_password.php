<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');	
		$this->load->model('Change_password_model');
	
	}	

	public function index(){

		if(!$_POST){
			$this->getPassword_Content();
		
		}else{
			$this->editPassword();

		}

	} 

	public function getPassword_Content(){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data["content"] = 'change_password';
		$this->load->view('backend/template', $data);

	}

	public function editPassword(){
		
		$validation = array(
			array(
				"field" => "old_pwd",
				"label" => "Old Password :",
				"rules" => "trim|required"
				),
			array(
				"field" => "new_pwd",
				"label" => "New Password :",
				"rules" => "trim|required"
				),
			array(
				"field" => "retype_new_pwd",
				"label" => "Re-type Password :",
				"rules" => "trim|required"
				),);

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', '*fill up required fields.');
		$this->form_validation->set_message('is_unique', 'Role Name is already exist.');
		$this->form_validation->set_error_delimiters('<span  class="change_pwd">', '</span>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getPassword_Content();
		
		}else{

			 $old_pwd = md5($this->input->post('old_pwd'));
			 $new_pwd = $this->input->post('new_pwd');
			 $retype_new_pwd = $this->input->post('retype_new_pwd');

			 $getpwd = $this->Change_password_model->_getPasswordContent();
			 
			 if($old_pwd != $getpwd){
			 	$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> Warning : </span><b>Invalid old password.</b></div>');
				redirect('change_password/');
			 
			 }elseif($retype_new_pwd != $new_pwd){
			 	
			 	$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> Error : </span><b>Your re-type password does not match in new password.</b></div>');
				redirect('change_password/');
					
			 }else{

			 	$this->Change_password_model->_updatePassword($new_pwd);
			 	$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> Success : </span><b>Your password was successfully updated.</b></div>');
				redirect('change_password/');
			 }

		}

	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/item.php */
