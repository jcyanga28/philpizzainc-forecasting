<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller{

	public function index()
	{

		$msg = "";

		$data['msg'] = $msg;
		$data['content'] = 'index'; 	
		$this->load->view('template', $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/dashboard.php */