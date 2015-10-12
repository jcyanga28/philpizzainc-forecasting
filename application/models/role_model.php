<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends ME_Model{
	
	public $table = 'role';
	public $primary_id = 'role_id';

//check user
	public function _getRoleContent($search){
		$this->db->like('role',$search);
        $this->db->order_by('role','asc');
        return $this->db->get($this->table)->result_array(); 

	} 

	public function addRole(){
		$role = trim($this->input->post('role',TRUE));

		if($this->_name_exist($role)){
			return 0;
		}else{

			$this->db->set('role', strtoupper($role));
			$this->db->insert($this->table);
			return $this->db->insert_id();

		}

	}

	public function details($id_role){
		$this->db->where('role_id', $id_role);
		return $this->db->get($this->table)->row_array();
	}

	public function updateRole($role_id){
		$role = trim($this->input->post('role',TRUE));

		$role_details = $this->details($role_id);
        if($role_details['role'] == $role){
            return TRUE;
        }else{
            if($this->_name_exist($role)){
                return  FALSE;

            }else{

                $this->db->where('role_id',$role_id);
                $this->db->set('role',strtoupper($role));
                $this->db->update($this->table);
                return TRUE;
            }
        }

	}

	public function delete($role_id){
		$this->db->where('role_id', $role_id);
		$this->db->delete($this->table);
		return TRUE;
		
	}

	function exist($role_id){
		$this->db->where('role_id', $role_id);
		$row = $this->db->get($this->table)->row_array();

		 if($row){
            return TRUE;
        }else{
            return FALSE;
        }
        
	}

	function _name_exist($role){
        $query = $this->db->get_where('role',array('role' => $role))->row_array();
        if(count($query) > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}