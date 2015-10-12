<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservice_model extends ME_Model{
	
//posting

//---webservice maintenance---//
	
	//--user--//

	public function webservice_UserMaintenancePost($user){
			// print_r($user);
	  	foreach($user as $row){

	  		$name = strtolower($row->name);

	  		$this->db->where('user_id', $row->id);
	  		$result = $this->db->get('user')->row_array();

	  		if($result){	
				$this->db->where('user_id', $row->id);
				$this->db->set('username', $name);
				$this->db->set('fullname', $name);
				$this->db->set('role_id', $row->type);
				$this->db->set('branch_id', $row->branch);
				$this->db->update('user');
			
			}else{
				$this->db->set('status', 1);
				$this->db->set('role_id', $row->type);
				$this->db->set('fullname', $name);
				$this->db->set('password', md5($name));
				$this->db->set('username', $name);
				$this->db->set('branch_id', $row->branch);
				$this->db->set('user_id', $row->id);
				$this->db->insert('user');
			
			}	

	  	}
	  		return TRUE;

	}

	//--item--//

	public function webservice_ItemMaintenancePost($item){

			$this->db->truncate('item');

		foreach($item as $row){	
			$this->db->set('item_code', $row->itemcode);
			$this->db->set('barcode', $row->barcode);
			$this->db->set('sap_code', $row->sapcode);
			$this->db->set('description', $row->desc);
			$this->db->set('size', $row->size);
			$this->db->set('price', $row->price);
			$this->db->set('branch_id', $row->branch);
			$this->db->insert('item');
	  	}
	  	return TRUE;

	}

	//--location--//
	public function webservice_BranchMaintenancePost($branch){

			$this->db->truncate('branch');

		foreach($branch as $row){	
			$this->db->set('location_code', $row->branch);
			$this->db->set('sap_code', $row->sapcode);
			$this->db->set('description', $row->desc);
			$this->db->insert('branch');
	  	}
	  	return TRUE;
	}


}