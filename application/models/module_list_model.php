<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_list_model extends ME_Model{
	
//check user
	public function getRole($role_id){
		$this->db->where('role_id', $role_id);
		$this->db->select('role');
		return $this->db->get('role')->row_array();
	}

	public function _getModuleList($role_id){
	    $this->db->where('a.module_id = b.module_id');
	    $this->db->where('a.role_id', $role_id);
	    $this->db->select('b.*');
        return $this->db->get('module_access a, module b')->result_array(); 

	} 

}