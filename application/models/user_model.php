<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends ME_Model{
	
	public $table = 'location';
	public $primary_id = 'location';

//check user
	public function _getUserContent($search){
		// $this->db->like('fullname',$search);
  //       $this->db->order_by('user_id','asc');
  //       $this->db->where('a.role_id = b.role_id');
  //       $this->db->select('a.*, b.*');
  //       return $this->db->get('user a, role b')->result_array();
  		$this->db->like('locationd',$search);
        $this->db->order_by('locationd','asc');
        $this->db->where('a.role_id = b.role_id');
        $this->db->select('a.*, b.role');
        return $this->db->get('location a, role b')->result_array();	 

	} 

	public function getRoles(){
		return $this->db->get('role')->result_array();
	}

	public function updateUserPwd($user_id,$role){
		$this->db->where('location',$user_id);
		$this->db->set('role_id',$role);
		$this->db->update($this->table);

		return TRUE;
	}

}