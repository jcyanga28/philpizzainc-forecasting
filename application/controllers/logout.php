<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Logout_model');

	}	

	public function index(){

		$user_log = strtolower($this->session->userdata('branch'));

		$data["message"] = "success! successfully logged out.";
		$data["ip"] = $_SERVER['REMOTE_ADDR'];
		$data["log_date"] = date('Y-m-d');
		$data["log_time"] = date('H:i:s');
		$data["user_log"] = $user_log;
		
		$result = $this->Logout_model->logs($data);

		if($result>0){
			$this->session->sess_destroy();
      		
	  		$msg = '<div class="alert-box success"><span class="alert_title"> success : </span><b> Thanks for visiting the website.</b></div>';
			
	  		$data["msg"] = $msg;
			$data["content"] = 'logout';
	  		$this->load->view('template', $data);

		}

	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/logout.php */
