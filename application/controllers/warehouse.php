<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');	
		$this->load->model('Warehouse_model');
	
	}	

	public function index(){
		$module_id = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			
			$this->getWarehouse_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}

	} 

	public function getWarehouse_Content($msg=''){
		$role_id = $this->session->userdata('role_id');

		$search = $this->input->get('search');
				
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['jquery'] = array('table-sorter/table-sorter.js');
		
		$data['msg'] = $msg;	
		$data['search'] = $search;
		$data['warehouse'] = $this->Warehouse_model->_getWarehouseContent($search);
		
		$data["content"] = 'warehouse';
		$this->load->view('backend/template', $data);


	}

	public function add($msg=''){
		$module_id = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}

		if(!$_POST){
			$this->getAdd_Warehouse();

		}else{
			$this->postAdd_Warehouse();

		}

	}

	public function postAdd_Warehouse(){

		$validation = array(
			array(
				"field" => "warehouse",
				"label" => "Warehouse Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Warehouse Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Warehouse Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getAdd_Warehouse();
		
		}else{

			$warehouse_id = $this->Warehouse_model->addWarehouse();	
			if($warehouse_id>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Warehouse Name is successfully added.</b></div>');
				redirect('warehouse/');
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Warehouse Name already exist.</b></div>');
				redirect('warehouse/add');
			}

		}

	}

	public function edit($id = null){
		$module = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exists($module,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}else{

			if(!$_POST){
				$this->getEdit_Warehouse($id);

			}else{
				$this->postEdit_Warehouse($id);

			}
		}	
	}

	public function getEdit_Warehouse($id){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['warehouse'] = $this->Warehouse_model->details($id);
		$data['content'] = 'edit';
		$this->load->view('backend/template', $data);

	}

	public function postEdit_Warehouse($id){
		
		$validation = array(
			array(
				"field" => "warehouse",
				"label" => "Warehouse Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Warehouse Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Warehouse Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if($this->form_validation->run() == FALSE){
			$this->getEdit_Warehouse($id);
		
		}else{

			if($this->Warehouse_model->updateWarehouse($id)){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Warehouse Name is successfully updated.</b></div>');
				redirect('warehouse/');
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Warehouse Name already exist.</b></div>');
				redirect('warehouse/edit/'.$id);
			}

		}

	}

	public function delete($id = null){
		$module = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exists($module,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}else{
			
			if(!$_POST){
				$this->getDelete_Warehouse($id);

			}else{
				if(!$this->Warehouse_model->delete($id)){
						redirect('warehouse/delete/'.$id);
				}else{
					$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Warehouse Name is successfully deleted.</b></div>');
					redirect('warehouse/');
				}
			}
		}	

	}

	public function getDelete_Warehouse($id){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['warehouse'] = $this->Warehouse_model->details($id);
		$data['content'] = 'delete';
		$this->load->view('backend/template', $data);

	}

	public function getAdd_Warehouse(){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['content'] = 'add';
		$this->load->view('backend/template', $data);
	}


}
/* End of file welcome.php */
/* Location: ./application/controllers/warehouse.php */
