<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller{
	function __construct(){
        parent::__construct();
        
        $this->load->model('Admin_model');
    }

	public function index(){
		$role_id = $this->session->userdata('role_id');	
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['content'] = 'backend/index'; 	
		$this->load->view('backend/template', $data);
	}

	public function logout(){

		redirect('logout/');
	
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */