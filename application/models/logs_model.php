<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs_model extends ME_Model{
	
	public $table = 'logs';
	public $primary_id = 'id';

//check user
	public function _getLogsContent($search){

		// $this->db->cache_on();
		$this->db->like('locationd',$search);
		$this->db->order_by('id','desc');
		return $this->db->get('logs')->result_array(); 

	} 


}