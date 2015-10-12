<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_model extends ME_Model{
		
	public $table = 'warehouse_maintenance';
	public $primary_id = 'id';

// locations
	public function select_location(){

		$query = sprintf("SELECT * FROM location WHERE role_id > '1' AND role_id < '3'");

		return $this->db->query($query)->result_array();

	}

	public function addWarehouse(){
		$warehouse = trim($this->input->post('warehouse',TRUE));

		if($this->_name_exist($warehouse)){
			return 0;
		}else{

			$this->db->set('warehouse', strtoupper($warehouse));
			$this->db->insert($this->table);
			return $this->db->insert_id();

		}

	}

	function _name_exist($warehouse){
        $query = $this->db->get_where('warehouse_maintenance',array('warehouse' => $warehouse))->row_array();
        if(count($query) > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function details($id){
		$this->db->where('id', $id);
		return $this->db->get($this->table)->row_array();
	}

	public function updateWarehouse($id){
		$warehouse = trim($this->input->post('warehouse',TRUE));

		$warehouse_details = $this->details($id);
        if($warehouse_details['warehouse'] == $warehouse){
            return TRUE;
        }else{
            if($this->_name_exist($warehouse)){
                return  FALSE;

            }else{

                $this->db->where('id',$id);
                $this->db->set('warehouse',strtoupper($warehouse));
                $this->db->update($this->table);
                return TRUE;
            }
        }

	}

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table);

		$this->db->where('warehouse_id', $id);
		$this->db->delete('plant_maintenance');
		
		return TRUE;
		
	}

//check user
	public function _getWarehouseContent($search){
		$this->db->like('warehouse',$search);
        $this->db->order_by('warehouse','asc');
        return $this->db->get('warehouse_maintenance')->result_array(); 

	}
	

}