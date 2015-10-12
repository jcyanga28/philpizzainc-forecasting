<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password_model extends ME_Model{
	
	public $table = 'user';
	public $primary_id = 'user_id';

//check user
	public function _getPasswordContent(){
		
		$user_id = $this->session->userdata('user_id');

		$this->db->where('user_id',$user_id);
        $this->db->select('password');
        $row = $this->db->get($this->table)->row(); 

        return $row->password;
	}

	public function _updatePassword($new_pwd){

		$user_id = $this->session->userdata('user_id');

		$this->db->where('user_id',$user_id);
        $this->db->set('password',md5($new_pwd));
        $row = $this->db->update($this->table); 

        return TRUE;
	} 


}