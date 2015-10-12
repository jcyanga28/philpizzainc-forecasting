<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_forecast_model extends ME_Model{	

//-----------------get plant name-----------------------------------------------------------------
	public function get_plantname($branch_id){
		$this->db->where('[user]', $branch_id);
		$this->db->select('plant');
		$row = $this->db->get('plant_maintenance')->row_array();

		return $row['plant'];

	}	

//---------------------sap------------------------------------------------------------------------
	public function sap_forecast($month_from,$month_end){
		$branch_id = $this->session->userdata('branch_id');

		$date = date('Y-m-d');
		// AND branch = '$branch_id'
		$query = sprintf("SELECT fdate_from, fdate_to, tdate_from, tdate_to, remarks, versions FROM sap_need_monthly_forecast WHERE fdate_from BETWEEN '$month_from' AND '$month_end' GROUP BY fdate_from, fdate_to, tdate_from, tdate_to, remarks, versions Order by fdate_from desc");

		return $this->db->query($query)->result_array();
	}

//---------------------sap------------------------------------------------------------------------
	public function all_sap_forecast(){

		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('[user]', $branch_id);
		$this->db->select('id,plant');
		$row = $this->db->get('plant_maintenance')->row_array();

		$id = $row['id'];

		$query = sprintf("SELECT a.branch, a.fdate_from, a.fdate_to, a.tdate_from, a.tdate_to FROM sap_need_monthly_forecast a, plant_store_maintenance b  WHERE a.branch = b.location AND b.plant_id = '$id' GROUP BY branch, fdate_from, fdate_to, tdate_from, tdate_to");

		return $this->db->query($query)->result_array();

	}

	public function count_all_sap_forecast(){

		$branch_id = $this->session->userdata('branch_id');

		$date = date('Y-m-d');

		$this->db->order_by('fdate_from', 'desc');
		$this->db->group_by('fdate_from');
		$this->db->group_by('fdate_to');
		$this->db->group_by('tdate_from');
		$this->db->group_by('tdate_to');
		$this->db->group_by('remarks');
		$this->db->group_by('versions');	
		// $this->db->where('branch', $branch_id);
		$this->db->select('fdate_from, fdate_to, tdate_from, tdate_to, remarks, versions');
		return $this->db->get('sap_need_monthly_forecast')->result_array();

	}


}