<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout_model extends ME_Model{

	function __construct(){
		parent::__construct();

	}
		
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
 
}