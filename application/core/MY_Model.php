<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model{

	// function __construct(){
	// 	parent::__construct();

	// 	$restaurant_type = $this->input->post('connector');

	// 	if($restaurant_type=="ph"){
	// 	   $this->db = $this->load->database('ph', TRUE);
		
	// 	}
	// 	if($restaurant_type=="dq"){
	// 	   $this->db = $this->load->database('dq', TRUE);
				
	// 	}
	// 	if($restaurant_type=="tb"){
	// 	   $this->db = $this->load->database('tb', TRUE);

	// 	}

	// 	if($restaurant_type=="phb"){
	// 	   $this->db = $this->load->database('b', TRUE);

	// 	}

	// }
	
	public $table = '';
	public $primary_id = 'id';
		
	/**
	 * create record
	 * @param $data array
	 * @return int
	 */
	public function insert($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id($this->table);
	}

	/**
	 * update record
	 * @param int
	 * @param array
	 * @return array
	 */
	public function update($id,$data){
		$this->db->where($this->primary_id,$id);
		$this->db->update($this->table,$data);
		return TRUE;
	}


	/**
	 * fetch by primary id
	 * @param int
	 * @return array
	 */
	public function fetch($id){
		$this->db->where($this->primary_id,$id);
		return $this->db->get($this->table)->row_array();
	}

	/**
	 * create record
	 * @param $data array
	 * @return int
	 */
	public function delete($id){
		$this->db->where($this->primary_id,$id);
		$this->db->delete($this->table);
		return TRUE;
	}

	/**
	 * fetch all records
	 * @param string $field_name field name
	 * @param string $direction direction of sorting
	 * @return array
	 */
	public function get_all($field_name = null,$direction = 'asc'){
		if(!is_null($field_name)){
			$this->db->order_by($field_name,$direction);
		}
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * check if value exist 
	 * @param string
	 * @param string
	 * @return boolean
	 */
	public function value_exist($field_name,$value){
		$this->db->where($field_name,$value);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}


	/**
	 * check if record is related to
	 */
	public function is_related_to($table_name,$field_name,$value){
		$this->db->where($field_name,$value);
		$row = $this->db->get($table_name)->result_array();
		if(count($row)>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */