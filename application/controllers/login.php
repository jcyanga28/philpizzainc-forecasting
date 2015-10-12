<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('Login_model');
	
	}	

	public function index(){
		
		$validate = array(
			array("field" => "username", "rules" => "trim|required"),
			array("field" => "password", "rules" => "trim|required"));

		$this->form_validation->set_rules($validate);
		$this->form_validation->set_message('required', '*required fields.');
		$this->form_validation->set_error_delimiters('<span style="color:red;font-size:11px;font-style:italic;font-weight:bold;">', '</span>');

		if(!$this->form_validation->run()){
			$msg = "";
			$data['msg'] = $msg;
			$data['content'] = 'index'; 	
			$this->load->view('template', $data);

		// }elseif(!is_numeric($password)){
		// 	$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid Password inputted.</b></div>');
		// 	redirect('login_error/');


		}else{

			$connector = strtolower($this->input->post('connector'));
			$user_log = strtolower($this->input->post('username'));

			if($connector=="ph"||$connector=="dq"||$connector=="tb"||$connector=="phb"){
				$result = $this->Login_model->signin();

				if($result>0){
					$data["message"] = "success! successfully logged in.";
					$data["ip"] = $_SERVER['REMOTE_ADDR'];
					$data["log_date"] = date('Y-m-d');
					$data["log_time"] = date('H:i:s');
					$data["user_log"] = $user_log;
					$this->Login_model->logs($data);

					redirect('home/');

				}else{

					$data["message"] = "error! not successfully logged in.";
					$data["ip"] = $_SERVER['REMOTE_ADDR'];
					$data["log_date"] = date('Y-m-d');
					$data["log_time"] = date('H:i:s');
					$data["user_log"] = $user_log;
					$this->Login_model->logs($data);

					$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid username or password.</b></div>');
					redirect('login_error/');

				}

			}else{

					$data["message"] = "error! not successfully logged in.";
					$data["ip"] = $_SERVER['REMOTE_ADDR'];
					$data["log_date"] = date('Y-m-d');
					$data["log_time"] = date('H:i:s');
					$data["user_log"] = $user_log;
					$this->Login_model->logs($data);
					
					$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid username or password.</b></div>');
					redirect('login_error/');
			
			}
			

		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/login.php */