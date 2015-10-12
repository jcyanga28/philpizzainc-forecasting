<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_model extends ME_Model{
	
	public $table = 'module';
	public $primary_id = 'module_id';

//check user
	public function _getModuleContent($search){
		$this->db->like('module',$search);
        $this->db->order_by('module','asc');
        return $this->db->get($this->table)->result_array(); 

	} 

	public function addModule(){
		$module = trim($this->input->post('module',TRUE));

		if($this->_name_exist($module)){
			return 0;
		}else{

			$this->db->set('module', strtoupper($module));
			$this->db->insert($this->table);
			return $this->db->insert_id();

		}

	}

	public function details($module_id){
		$this->db->where('module_id', $module_id);
		return $this->db->get($this->table)->row_array();
	}

	public function updateModule($module_id){
		$module = trim($this->input->post('module',TRUE));

		$module_details = $this->details($module_id);
        if($module_details['module'] == $module){
            return TRUE;
        }else{
            if($this->_name_exist($module)){
                return  FALSE;

            }else{

                $this->db->where('module_id',$module_id);
                $this->db->set('module',strtoupper($module));
                $this->db->update($this->table);
                return TRUE;
            }
        }

	}

	public function delete($module_id){
		$this->db->where('module_id', $module_id);
		$this->db->delete($this->table);
		return TRUE;
		
	}

	function exist($module_id){
		$this->db->where('module_id', $module_id);
		$row = $this->db->get($this->table)->row_array();

		 if($row){
            return TRUE;
        }else{
            return FALSE;
        }
        
	}

	function _name_exist($module){
        $query = $this->db->get_where('module',array('module' => $module))->row_array();
        if(count($query) > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}