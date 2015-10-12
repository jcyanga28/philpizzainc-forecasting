<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_access_model extends ME_Model{
	
	public $table = 'module_access';
	public $primary_id = 'module_access_id';


	public function _getModuleAccessContent($search){
		$this->db->like('role', $search);
		$this->db->distinct();
		$this->db->where('a.role_id = b.role_id');
		$this->db->select('a.*');
		return $this->db->get('role a, module_access b')->result_array();

	}

	public function getFreeRole(){
		$query = $this->db->query("SELECT * FROM role WHERE role_id NOT IN (SELECT role_id FROM module_access)");
		return $query->result_array();

	}


	public function getModule(){
		return $this->db->get('module')->result_array();

	}

	public function addModuleAccess(){
		error_reporting(0);

		$role_id = $this->input->post('role_id');
		$module_id = $this->input->post('module');

		if(array_values($module_id)==0){
			return 0;
		}else{

			foreach ($module_id as $row) {
				$this->db->set('module_id', $row);
				$this->db->set('role_id', $role_id);
				$this->db->insert($this->table);
			}

			return TRUE;
		}

	}

	public function getRole($id_role){
		$this->db->where('role_id', $id_role);
		$this->db->select('role_id,role');
		return $this->db->get('role')->row_array();
	}

	public function _getModuleList($id_role){
	    $this->db->where('a.module_id = b.module_id');
	    $this->db->where('a.role_id', $id_role);
	    $this->db->select('b.*');
        return $this->db->get('module_access a, module b')->result_array(); 

	} 

	public function deleteAccess($role_id,$module_id){
		$this->db->where('module_id', $module_id);
		$this->db->where('role_id', $role_id);
		$this->db->delete($this->table);

		return TRUE;

	}

	public function _getModule_Notin_List($id_role){
		$query = $this->db->query("SELECT * FROM module WHERE module_id NOT IN (SELECT module_id FROM module_access WHERE role_id = '$id_role')");
		return $query->result_array();

	}

	public function insertAccess($role_id,$module_id){
		$this->db->set('module_id', $module_id);
		$this->db->set('role_id', $role_id);
		$this->db->insert('module_access');
		return $this->db->insert_id(); 
	}

	public function DeleteAllAccess($role_id){
		$this->db->where('role_id', $role_id);
		$this->db->delete('module_access');

		return TRUE;
	}


}