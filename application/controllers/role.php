<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');
		$this->load->model('Role_model');
	}	

	public function index(){

		$module_id = "5";
		$role = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_exists($module_id,$role);

		if($result<=0){
			$this->_pageNotFound();
			return;
		
		}else{
			$this->getRole_Content();

		}
			
	} 

	public function add(){
		$module_id = "5";
		$role = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_exists($module_id,$role);

		if($result<=0){
			$this->_pageNotFound();
			return;
		
		}

		if(!$_POST){
			$this->getAdd_Role();

		}else{
			$this->postAdd_Role();

		}
	}

	public function postAdd_Role(){

		$validation = array(
			array(
				"field" => "role",
				"label" => "Role Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Role Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Role Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getAdd_Role();
		
		}else{

			$module_id = $this->Role_model->addRole();	
			if($module_id>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Role Name is successfully added.</b></div>');
				redirect('role/');
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Role Name already exist.</b></div>');
				redirect('role/add');
			}

		}

	}

	public function getAdd_Role(){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['content'] = 'add';
		$this->load->view('backend/template', $data);
	}

	public function edit($role_id = null){
		$module_id = "5";
		$role = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_exists($module_id,$role);

		if($result<=0){
			$this->_pageNotFound();
			return;
		
		}else{
			if((is_null($role_id)) || (!is_numeric($role_id)) || (!$this->Role_model->exist($role_id))){
				$this->_pageNotFound();
				return;
			}
			
			if(!$_POST){
				$this->getEdit_Role($role_id);

			}else{
				$this->postEdit_Role($role_id);

			}
		}	

	}

	public function getEdit_Role($role_id){
		$id_role = $role_id;

		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['role'] = $this->Role_model->details($id_role);
		$data['content'] = 'edit';
		$this->load->view('backend/template', $data);

	}

	public function postEdit_Role($role_id){
		
		$validation = array(
			array(
				"field" => "role",
				"label" => "Role Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Role Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Role Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getEdit_Role($role_id);
		
		}else{

			if($this->Role_model->updateRole($role_id)){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Role Name is successfully updated.</b></div>');
				redirect('role/');
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Role Name already exist.</b></div>');
				redirect('role/edit/'.$role_id);
			}

		}

	}

	public function delete($role_id = null){

		$module_id = "5";
		$role = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_exists($module_id,$role);

		if($result<=0){
			$this->_pageNotFound();
			return;
		
		}else{
			
			if((is_null($role_id)) || (!is_numeric($role_id)) || (!$this->Role_model->exist($role_id))){
				$this->_pageNotFound();
				return;
			}
			
			if(!$_POST){
				$this->getDelete_Role($role_id);

			}else{
				if(!$this->Role_model->delete($role_id)){
						redirect('role/delete/'.$role_id);
				}else{
					$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Role Name is successfully deleted.</b></div>');
					redirect('role/');
				}
			}
		}
			
	}

	public function getDelete_Role($role_id){
		$id_role = $role_id;
		
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['role'] = $this->Role_model->details($id_role);
		$data['content'] = 'delete';
		$this->load->view('backend/template', $data);

	}

	public function getRole_Content($msg=''){
		$role_id = $this->session->userdata('role_id');

		$search = $this->input->get('search');
				
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['jquery'] = array('table-sorter/table-sorter.js');
		
		$data['search'] = $search;

		$data['msg'] = $msg;
		$data['role'] = $this->Role_model->_getRoleContent($search);
		$data['content'] = 'role';
		$this->load->view('backend/template', $data);

	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/role.php */
