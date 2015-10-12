<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlogin extends CI_Controller{
		
	public function index(){
		
		$connector = $this->input->post('connector');

			 $session_data = array(
			 'connector' => $connector,
			 );

		$this->session->set_userdata($session_data);

		$this->load->controllers('login');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/Userlogin.php */