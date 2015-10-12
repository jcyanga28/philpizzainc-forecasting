<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {
	
	function __construct(){
        parent::__construct();
        
        if($this->session->userdata('user_id') == ""){
        	$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>You need to login to access this area.</b></div>');
        	redirect('');
    
    
        }
    }

    protected function _pageNotFound(){
        $role_id = $this->session->userdata('role_id');
        
        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);
        
        $data['content'] = 'page_not_found';
        $this->load->view('backend/template',$data);
        return;
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/Admin_Controller.php */