<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch_model extends ME_Model{
	
	public $table = 'location';
	public $primary_id = 'location';

//check user
	public function _getBranchContent($search){
		$this->db->like('locationd',$search);
        $this->db->order_by('location','asc');
        return $this->db->get($this->table)->result_array(); 

	}
	

}