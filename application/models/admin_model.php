<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends ME_Model{

//check user

	public function ModuleAllow_Access($role_id){
		$this->db->where('a.role_id', $role_id);
		$this->db->where('a.module_id = b.module_id');
		$this->db->select('a.*, b.module');
		return $this->db->get('module_access a, module b')->result_array();
	
	}

	public function FileMaintenance_Header($role_id){
		$this->db->where('a.role_id', $role_id);
		$this->db->where('a.module_id <= 7');
		$this->db->where('a.module_id >= 1');
		$this->db->where('a.module_id = b.module_id');
		$this->db->select('a.*, b.*');
		$result = $this->db->get('module_access a, module b')->row_array();

		if($result){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function Forecasting_Header($role_id){
		$this->db->where('a.role_id', $role_id);
		$this->db->where('a.module_id <= 10');
		$this->db->where('a.module_id >= 8');
		$this->db->where('a.module_id = b.module_id');
		$this->db->select('a.*, b.*');
		$result = $this->db->get('module_access a, module b')->row_array();

		if($result){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function check_if_exist($module_id,$role_id){
		$this->db->where('role_id', $role_id);
		$this->db->where('module_id', $module_id);
		$row = $this->db->get('module_access')->row_array();

		if($row){
			return TRUE;
		
		}else{
			return FALSE;
			
		}
	}

	public function check_if_exists($module,$role_id){
		$this->db->where('role_id', $role_id);
		$this->db->where('module_id', $module);
		$row = $this->db->get('module_access')->row_array();

		if($row){
			return TRUE;
		
		}else{
			return FALSE;
			
		}
	}

	public function check_exists($module_id,$role){
		$this->db->where('role_id', $role);
		$this->db->where('module_id', $module_id);
		$row = $this->db->get('module_access')->row_array();

		if($row){
			return TRUE;
		
		}else{
			return FALSE;
			
		}	
	}


}