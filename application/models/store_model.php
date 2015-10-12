<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends ME_Model{
		
	public $table = 'plant_maintenance';
	public $primary_id = 'id';

// warehouse
	public function plant_name($id){
		$this->db->where('id', $id);
		$this->db->select('plant');
		$row = $this->db->get('plant_maintenance')->row_array();

		return $row['plant'];
	}

	public function _getStoreContent_exist($id){
		$query = sprintf("SELECT location, locationd FROM location WHERE location IN(SELECT location FROM plant_store_maintenance WHERE plant_id = '$id') AND role_id = '2'");

		return $this->db->query($query)->result_array();
	
	}

	public function _getStoreContent_notexist($id){
		$query = sprintf("SELECT location, locationd FROM location WHERE location NOT IN(SELECT location FROM plant_store_maintenance WHERE plant_id = '$id') AND role_id = '2'");

		return $this->db->query($query)->result_array();
	
	}

	public function addaccess($id,$location){
		$this->db->set('plant_id', $id);
		$this->db->set('location', $location);
		$this->db->insert('plant_store_maintenance');

		return TRUE;
	}

	public function removeaccess($id,$location){
		$this->db->where('plant_id', $id);
		$this->db->where('location', $location);
		$this->db->delete('plant_store_maintenance');

		return TRUE;
	}
	

}