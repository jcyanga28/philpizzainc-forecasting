<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');		
		$this->load->model('Module_model');
	
	}	

	public function index(){
		$module_id = "3";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			$this->getModule_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}
	} 

	public function add(){
		$module_id = "3";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}

		if(!$_POST){
			$this->getAdd_Module();

		}else{
			$this->postAdd_Module();

		}
	}

	public function postAdd_Module(){

		$validation = array(
			array(
				"field" => "module",
				"label" => "Module Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Module Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Module Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getAdd_Module();
		
		}else{

			$module_id = $this->Module_model->addModule();	
			if($module_id>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Module Name is successfully added.</b></div>');
				redirect('module/');
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Module Name already exist.</b></div>');
				redirect('module/add');
			}

		}

	}

	public function getAdd_Module(){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['content'] = 'add';
		$this->load->view('backend/template', $data);
	}

	public function edit($module_id = null){
		$module = "3";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exists($module,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}else{

			if((is_null($module_id)) || (!is_numeric($module_id)) || (!$this->Module_model->exist($module_id))){
				$this->_pageNotFound();
				return;
			}
			
			if(!$_POST){
				$this->getEdit_Module($module_id);

			}else{
				$this->postEdit_Module($module_id);

			}
		}	
	}

	public function getEdit_Module($module_id){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['modules'] = $this->Module_model->details($module_id);
		$data['content'] = 'edit';
		$this->load->view('backend/template', $data);

	}

	public function postEdit_Module($module_id){
		
		$validation = array(
			array(
				"field" => "module",
				"label" => "Module Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Module Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Module Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getEdit_Module($module_id);
		
		}else{

			if($this->Module_model->updateModule($module_id)){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Module Name is successfully updated.</b></div>');
				redirect('module/');
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Module Name already exist.</b></div>');
				redirect('module/edit/'.$module_id);
			}

		}

	}

	public function delete($module_id = null){
		$module = "3";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exists($module,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}else{

			if((is_null($module_id)) || (!is_numeric($module_id)) || (!$this->Module_model->exist($module_id))){
				$this->_pageNotFound();
				return;
			}
			
			if(!$_POST){
				$this->getDelete_Module($module_id);

			}else{
				if(!$this->Module_model->delete($module_id)){
						redirect('module/delete/'.$module_id);
				}else{
					$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Module Name is successfully deleted.</b></div>');
					redirect('module/');
				}
			}
		}	

	}

	public function getDelete_Module($module_id){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['modules'] = $this->Module_model->details($module_id);
		$data['content'] = 'delete';
		$this->load->view('backend/template', $data);

	}

	public function getModule_Content($msg=''){
		$role_id = $this->session->userdata('role_id');

		$search = $this->input->get('search');
				
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['jquery'] = array('table-sorter/table-sorter.js');

		$data['search'] = $search;

		$data['msg'] = $msg;
		$data['modules'] = $this->Module_model->_getModuleContent($search);
		$data['content'] = 'modules';
		$this->load->view('backend/template', $data);

	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/module.php */
