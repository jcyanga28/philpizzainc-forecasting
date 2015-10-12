<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends ME_Model{
	
	public $table = 'items';
	public $primary_id = 'barcode';

//check user
	public function _getItemContent($search){

		// $this->db->cache_on();
		$this->db->where('a.size = b.size');
		$this->db->like('[desc]',$search);
		$this->db->order_by('a.barcode','asc');
		return $this->db->get('items a, size b')->result_array(); 

	} 


}