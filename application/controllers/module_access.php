<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_access extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');
		$this->load->model('Module_access_model');
		$this->load->model('Role_model');
	}	

	public function index(){
		$module_id = "4";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			$this->getModuleAccess_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}

	} 


	public function getModuleAccess_Content($msg=''){
		$role_id = $this->session->userdata('role_id');

		$search = $this->input->get('search');
				
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['jquery'] = array('table-sorter/table-sorter.js');

		$data['search'] = $search;

		$data['msg'] = $msg;
		$data['role_access'] = $this->Module_access_model->_getModuleAccessContent($search);
		$data['content'] = 'module_access';
		$this->load->view('backend/template', $data);

	}

	public function add(){
		$module_id = "4";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}

		if(!$_POST){
			$this->getAdd_ModuleAccess();

		}else{
			$this->postAdd_Module();

		}
	}

	public function getAdd_ModuleAccess(){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		// $data['css'] = array('chosen.css');
		// $data['jquery'] = array('chosen.jquery.js');

		$data['role'] = $this->Module_access_model->getFreeRole();
		$data['modules'] = $this->Module_access_model->getModule();
		$data['content'] = 'add';
		$this->load->view('backend/template', $data);

	}

	public function postAdd_Module(){
		
		$validation = array(
			array(
				"field" => "role_id",
				"label" => "User Role",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>User Role is required.</b>');
		$this->form_validation->set_message('is_unique', 'User Role is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getAdd_ModuleAccess();
		
		}else{

			$module_access_id = $this->Module_access_model->addModuleAccess();	
			if($module_access_id>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Module Access is successfully added.</b></div>');
				redirect('module_access/');
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Please choose module.</b></div>');
				redirect('module_access/add');
			}

		}

	}

	public function edit($role_id){
		$module_id = "4";
		$role = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_exists($module_id,$role);

		if($result<=0){
			$this->_pageNotFound();
			return;
		
		}else{

			$this->getEdit_ModuleAccess($role_id);

		}

	}

	public function getEdit_ModuleAccess($role_id = null){

		if((is_null($role_id)) || (!is_numeric($role_id)) || (!$this->Role_model->exist($role_id))){
			$this->_pageNotFound();
			return;

		}else{

			$id_role = $role_id;

			$role_id = $this->session->userdata('role_id');
		
			$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
			$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
			$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

			$data['jquery'] = array('table-sorter/table-sorter.js');
			
			$role = $this->Module_access_model->getRole($id_role);
			$module = $this->Module_access_model->_getModuleList($id_role);

			$modulesnotallowed = $this->Module_access_model->_getModule_Notin_List($id_role);

			$data['role'] = $role;
			$data['modules'] = $module;
			$data['modulesnotallowed'] = $modulesnotallowed;

			$data['content'] = 'edit';
			$this->load->view('backend/template', $data);
		
		}

	}

	public function remove_access($role_id,$module_id){
		
		$this->Module_access_model->deleteAccess($role_id,$module_id);
		$this->edit($role_id);

	}

	public function add_access($role_id,$module_id){
		
		$this->Module_access_model->insertAccess($role_id,$module_id);
		$this->edit($role_id);

	}

	public function delete($role_id = null){
		$module_id = "4";
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
				$this->getDelete_ModuleAccess($role_id);
				
			}else{

				if(!$this->Module_access_model->DeleteAllAccess($role_id)){

				redirect('module_access/delete/'.$role_id);	

				}else{

				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Module Access is successfully deleted.</b></div>');
				redirect('module_access');	

				}
				
			}

		}	

	}
	
	public function getDelete_ModuleAccess($role_id){
		$id_role = $role_id;

		$role_id = $this->session->userdata('role_id');

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$role = $this->Module_access_model->getRole($id_role);
		$module = $this->Module_access_model->_getModuleList($id_role);

		$data['role'] = $role;
		$data['module'] = $module;

		$data['content'] = 'delete';
		$this->load->view('backend/template', $data);

	}	

}
/* End of file welcome.php */
/* Location: ./application/controllers/module_access.php */
