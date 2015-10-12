<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_list extends Admin_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('Admin_model');
		$this->load->model('Role_model');
		$this->load->model('Module_list_model');
	}	

	public function index(){
		
	} 

	public function allowed($role_id){

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

			}else{

				$id_role = $role_id;

				$role_id = $this->session->userdata('role_id');
		
				$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
				$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
				$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

				$data['jquery'] = array('table-sorter/table-sorter.js');
				
				$role = $this->Module_list_model->getRole($id_role);
				$module = $this->Module_list_model->_getModuleList($id_role);

				$data['roles'] = $role;
				$data['modules'] = $module;
				$data['content'] = 'module_list';
				$this->load->view('backend/template', $data);
			}
		}
			
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/module_list.php */
