<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plant_model extends ME_Model{
		
	public $table = 'plant_maintenance';
	public $primary_id = 'id';

// warehouse
	public function warehouse_name($id){
		$this->db->where('id', $id);
		$this->db->select('warehouse');
		$row = $this->db->get('warehouse_maintenance')->row_array();

		return $row['warehouse'];
	}

// locations
	public function select_location(){

		$query = sprintf("SELECT * FROM location WHERE role_id > '1' AND role_id < '3'");

		return $this->db->query($query)->result_array();

	}

	public function addPlant($id){
		$plant = trim($this->input->post('plant',TRUE));

		if($this->_name_exist($plant,$id)){
			return 0;
		}else{

			$this->db->set('plant', strtoupper($plant));
			$this->db->set('warehouse_id', $id);
			$this->db->set('[user]', '0');
			$this->db->insert($this->table);
			return $this->db->insert_id();

		}

	}

	function _name_exist($plant,$id){
        $query = $this->db->get_where('plant_maintenance',array('plant' => $plant,'warehouse_id' => $id))->row_array();
        if(count($query) > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function details($id,$warehouse_id){
		$this->db->where('id', $id);
		$this->db->where('warehouse_id',$warehouse_id);
		return $this->db->get($this->table)->row_array();
	}

	public function updatePlant($id,$warehouse_id){
		$plant = trim($this->input->post('plant',TRUE));

		$plant_details = $this->details($id,$warehouse_id);
        if($plant_details['plant'] == $plant){
            return TRUE;
        }else{
            if($this->_name_exist($plant,$warehouse_id)){
                return  FALSE;

            }else{

                $this->db->where('id',$id);
                $this->db->where('warehouse_id',$warehouse_id);
                $this->db->set('plant',strtoupper($plant));
                $this->db->update($this->table);
                return TRUE;
            }
        }

	}

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		return TRUE;
		
	}

//check user
	public function _getplantContent($id,$search){
		$this->db->like('plant',$search);
        $this->db->order_by('plant','asc');
        $this->db->where('a.warehouse_id', $id);
        $this->db->where('a.[user] = b.location');
        return $this->db->get('plant_maintenance a, location b')->result_array(); 

	}

	public function assign_user($id){
		$query = sprintf("SELECT location,locationd FROM location where location NOT IN (SELECT [user] FROM plant_maintenance where warehouse_id = '$id') AND role_id = '3'");

		return $this->db->query($query)->result_array();
	}

	public function update_assignuser($data){
		$this->db->where('id', $data['id']);
		$this->db->where('warehouse_id', $data['warehouse_id']);
		$this->db->set('[user]', $data['user_id']);
		$this->db->update('plant_maintenance');

		return TRUE;
	}
	

}