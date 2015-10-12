<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');	
		$this->load->model('Branch_model');
	
	}	

	public function index(){
		$module_id = "2";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			$this->getBranch_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}

	} 

	public function getBranch_Content($msg=''){
		$role_id = $this->session->userdata('role_id');

		$search = $this->input->get('search');
				
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['jquery'] = array('table-sorter/table-sorter.js');
		
		$data['msg'] = $msg;	
		$data['search'] = $search;
		$data['branch'] = $this->Branch_model->_getBranchContent($search);
		
		$data["content"] = 'branch';
		$this->load->view('backend/template', $data);


	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/item.php */
