<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');	
		$this->load->model('Store_model');
	
	}	

	public function index(){
		
		$id = $_GET['id'];
		$warehouse_id = $_GET['warehouse_id'];
		
		$module_id = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if((is_null($id)) || (!is_numeric($id))){
			$this->_pageNotFound();
			return;

		}

		if($result>0){
			
			$this->getStore_Content($id,$warehouse_id);
		
		}else{
			$this->_pageNotFound();
			return;
		
		}

	} 

	public function getStore_Content($id,$warehouse_id,$msg=''){
		$role_id = $this->session->userdata('role_id');
				
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['jquery'] = array('table-sorter/table-sorter.js');
		
		$data['msg'] = $msg;	

		$data['plant_name'] = $this->Store_model->plant_name($id);
		
		$data['store_notexist'] = $this->Store_model->_getStoreContent_notexist($id);
		$data['store_exist'] = $this->Store_model->_getStoreContent_exist($id);

		$data["content"] = 'store';
		$this->load->view('backend/template', $data);


	}

	public function add_access($id,$warehouse_id,$location){
		
		$result = $this->Store_model->addaccess($id,$location);

		if($result>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Store was successfully Added.</b></div>');
				redirect('store?id='.$id.'&warehouse_id='.$warehouse_id);
			
		}

	}

	public function remove_access($id,$warehouse_id,$location){
		
		$result = $this->Store_model->removeaccess($id,$location);

		if($result>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Store was successfully Removed.</b></div>');
				redirect('store?id='.$id.'&warehouse_id='.$warehouse_id);
			
		}

	}


}
/* End of file welcome.php */
/* Location: ./application/controllers/store.php */
