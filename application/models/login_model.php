<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends MY_Model{

	function __construct(){
		parent::__construct();

		$restaurants_type = strtolower($this->input->post('connector'));

		if($restaurants_type=="ph"){
		   $this->db = $this->load->database('ph', TRUE);
		
		}
		if($restaurants_type=="dq"){
		   $this->db = $this->load->database('dq', TRUE);
				
		}
		if($restaurants_type=="tb"){
		   $this->db = $this->load->database('tb', TRUE);

		}

		if($restaurants_type=="phb"){
		   $this->db = $this->load->database('b', TRUE);

		}

	}

	public $table = 'location';
	public $primary_id = 'location';
	
	

//check user
	public function logs($data){

		$this->db->set('locationd', $data['user_log']);
		$this->db->set('ip', $data['ip']);
		$this->db->set('date', $data['log_date']);
		$this->db->set('time', $data['log_time']);
		$this->db->set('message', $data['message']);
		$this->db->insert('logs');

		return TRUE;

	}

	public function signin(){
		$username = strtolower($this->input->post('username'));
		$password = strtolower($this->input->post('password'));
		$connector = strtolower($this->input->post('connector'));
		
		// $length = strlen($password);
		// $word = str_split($password);

		// $pass_value = "";

		// for($x=0;$x<=$length-1;$x++){
			
		// 	$split = ord($word[$x]);
		// 	$total = $split * 2;
		// 	$pass_value = $pass_value . chr($total);			
			
		// }

		$this->db->where('locationd', strtolower($username));
		$this->db->where('password', $password);
		$result = $this->db->get($this->table)->row_array();

		$restaurant = $this->input->post('username');
		
		$explodes = explode(' ',$restaurant);
		
		$restaurant = strtolower($explodes[0]);

		if(count($result)>0){
		
			 $session_data = array(
			 'user_id' => $result['location'],
			 'role_id' => $result['role_id'],
			 'branch_id' => $result['location'],
			 'branch' => $result['locationd'],
			 'restaurant_type' => $restaurant,
			 'connector' => $connector,
			 );

	  	$this->session->set_userdata($session_data);

			return TRUE;
		}else{
			return 0;
		}

	} 
}