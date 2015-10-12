<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_error extends MY_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('Login_model');
	
	}	

	public function index(){

		$data['content'] = 'index'; 	
		$this->load->view('template', $data);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/login_error.php */