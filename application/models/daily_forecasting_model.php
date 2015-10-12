<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_forecasting_model extends ME_Model{	
	
//--Day 1--//
//---------------------sap------------------------------------------------------------------------
	public function sap_forecast($start,$end){
		$branch_id = $this->session->userdata('branch_id');

		$date = date('Y-m-d');

		$query = sprintf("SELECT dateone, dateseven, remarks, versions FROM sap_need_forecast WHERE dateone BETWEEN '$start' AND '$end' AND branch = '$branch_id' GROUP BY dateone, dateseven, remarks, versions Order by dateone desc");

		return $this->db->query($query)->result_array();
	}

//---------------------sap------------------------------------------------------------------------
	public function all_sap_forecast($limit=null,$offset=null){

		$branch_id = $this->session->userdata('branch_id');

		$date = date('Y-m-d');

		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->order_by('dateone', 'desc');
		$this->db->group_by('dateone');
		$this->db->group_by('dateseven');
		$this->db->group_by('remarks');
		$this->db->group_by('versions');	
		$this->db->where('branch', $branch_id);
		$this->db->select('dateone, dateseven, remarks, versions');
		return $this->db->get('sap_need_forecast')->result_array();

	}

	public function count_all_sap_forecast(){

		$branch_id = $this->session->userdata('branch_id');

		$date = date('Y-m-d');

		$this->db->order_by('dateone', 'desc');
		$this->db->group_by('dateone');
		$this->db->group_by('dateseven');
		$this->db->group_by('remarks');
		$this->db->group_by('versions');	
		$this->db->where('branch', $branch_id);
		$this->db->select('dateone, dateseven, remarks, versions');
		return $this->db->get('sap_need_forecast')->result_array();

	}	

//--------------------remarks----------------------------------------------------------------------
	public function update_remarks(){
		$branch_id = $this->session->userdata('branch_id');

		$remarks = $this->input->post('remarks');
		
		$dateone = $this->input->post('dateone');
		$dateseven = $this->input->post('dateseven');
		$version = $this->input->post('version');
		
		$this->db->where('branch', $branch_id);
		$this->db->where('dateone', $dateone);
		$this->db->where('dateseven', $dateseven);
		$this->db->where('versions', $version);
		$this->db->set('remarks', $remarks);
		$this->db->update('sap_need_forecast');

		return TRUE;
	}	

//--------------------viewing---------------------------------------------------------------------
	public function select_update($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('a_upd');
		$this->db->where('versions', $data['version']);
		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->select('a_upd');
		return $this->db->get('sap_need_forecast')->row();

	}

	public function viewing($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('versions', $data['version']);
		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->select('fg,adj1,dayone,adj2,daytwo,adj3,daythree,adj4,dayfour,adj5,dayfive,adj6,daysix,adj7,dayseven');
		return $this->db->get('sap_need_forecast')->result_array();

	}

	public function _getgross_vsf1($tues_date,$data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('fa1');
		$this->db->where('versions', $data['version']);
		$this->db->where('dateone', $tues_date);
		$this->db->where('branch', $branch_id);
		$this->db->select('fa1');
		$row = $this->db->get('sap_need_forecast')->row();

		return $row->fa1;

	}

	public function _getgross_vsf2($wed_date,$data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('fa2');
		$this->db->where('versions', $data['version']);
		$this->db->where('datetwo', $wed_date);
		$this->db->where('branch', $branch_id);
		$this->db->select('fa2');
		$row = $this->db->get('sap_need_forecast')->row();

		return $row->fa2;
		
	}

	public function _getgross_vsf3($thurs_date,$data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('fa3');
		$this->db->where('versions', $data['version']);
		$this->db->where('datethree', $thurs_date);
		$this->db->where('branch', $branch_id);
		$this->db->select('fa3');
		$row = $this->db->get('sap_need_forecast')->row();

		return $row->fa3;
		
	}

	public function _getgross_vsf4($fri_date,$data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('fa4');
		$this->db->where('versions', $data['version']);
		$this->db->where('datefour', $fri_date);
		$this->db->where('branch', $branch_id);
		$this->db->select('fa4');
		$row = $this->db->get('sap_need_forecast')->row();

		return $row->fa4;
		
	}

	public function _getgross_vsf5($sat_date,$data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('fa5');
		$this->db->where('versions', $data['version']);
		$this->db->where('datefive', $sat_date);
		$this->db->where('branch', $branch_id);
		$this->db->select('fa5');
		$row = $this->db->get('sap_need_forecast')->row();

		return $row->fa5;
		
	}

	public function _getgross_vsf6($sun_date,$data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('fa6');
		$this->db->where('versions', $data['version']);
		$this->db->where('datesix', $sun_date);
		$this->db->where('branch', $branch_id);
		$this->db->select('fa6');
		$row = $this->db->get('sap_need_forecast')->row();

		return $row->fa6;
		
	}

	public function _getgross_vsf7($mon_date,$data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('fa7');
		$this->db->where('versions', $data['version']);
		$this->db->where('dateseven', $mon_date);
		$this->db->where('branch', $branch_id);
		$this->db->select('fa7');
		$row = $this->db->get('sap_need_forecast')->row();

		return $row->fa7;
		
	}

	public function _getgross1($tues_date,$ref_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('total_gross');
		$this->db->where('date', $tues_date);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('daily_forecasting_dayone')->row();

		return $row->total_gross;

	}

	public function _getgross2($wed_date,$ref_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('total_gross');
		$this->db->where('date', $wed_date);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('daily_forecasting_daytwo')->row();

		return $row->total_gross;
		
	}

	public function _getgross3($thurs_date,$ref_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('total_gross');
		$this->db->where('date', $thurs_date);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('daily_forecasting_daythree')->row();

		return $row->total_gross;
		
	}

	public function _getgross4($fri_date,$ref_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('total_gross');
		$this->db->where('date', $fri_date);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('daily_forecasting_dayfour')->row();

		return $row->total_gross;
		
	}

	public function _getgross5($sat_date,$ref_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('total_gross');
		$this->db->where('date', $sat_date);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('daily_forecasting_dayfive')->row();

		return $row->total_gross;
		
	}

	public function _getgross6($sun_date,$ref_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('total_gross');
		$this->db->where('date', $sun_date);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('daily_forecasting_daysix')->row();

		return $row->total_gross;
		
	}

	public function _getgross7($mon_date,$ref_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('total_gross');
		$this->db->where('date', $mon_date);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('daily_forecasting_dayseven')->row();

		return $row->total_gross;
		
	}

//--------------------viewing---------------------------------------------------------------------
	public function updating($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->select('fg,adj1,dayone,adj2,daytwo,adj3,daythree,adj4,dayfour,adj5,dayfive,adj6,daysix,adj7,dayseven');
		return $this->db->get('sap_need_forecast')->result_array();
		
	}

//------------------select reference for update----------------------------------------------------
	public function _getref1($startdate){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date');
		$this->db->where('date', $startdate);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date');
		$row = $this->db->get('daily_forecasting_dayone')->row_array();

		if(count($row) > 0){
			return $row['ref_date'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref2($wed_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date');
		$this->db->where('date', $wed_date);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date');
		$row = $this->db->get('daily_forecasting_daytwo')->row_array();

		if(count($row) > 0){
			return $row['ref_date'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref3($thurs_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date');
		$this->db->where('date', $thurs_date);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date');
		$row = $this->db->get('daily_forecasting_daythree')->row_array();

		if(count($row) > 0){
			return $row['ref_date'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref4($fri_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date');
		$this->db->where('date', $fri_date);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date');
		$row = $this->db->get('daily_forecasting_dayfour')->row_array();

		if(count($row) > 0){
			return $row['ref_date'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref5($sat_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date');
		$this->db->where('date', $sat_date);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date');
		$row = $this->db->get('daily_forecasting_dayfive')->row_array();

		if(count($row) > 0){
			return $row['ref_date'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref6($sun_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date');
		$this->db->where('date', $sun_date);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date');
		$row = $this->db->get('daily_forecasting_daysix')->row_array();

		if(count($row) > 0){
			return $row['ref_date'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref7($mon_date){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date');
		$this->db->where('date', $mon_date);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date');
		$row = $this->db->get('daily_forecasting_dayseven')->row_array();

		if(count($row) > 0){
			return $row['ref_date'];
		
		}else{
			return 0;

		}
		
	}



//-----------------------select pending------------------------------------------------------------
	public function selpending(){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('status', '0');
		$this->db->where('branch', $branch_id);
		return $this->db->get('pending_forecast')->result_array();
	}

	public function savepending($startdate,$enddate,$ref_startdate,$ref_enddate,$type){
		$branch_id = $this->session->userdata('branch_id');
		$date = date('Y-m-d');

		if($this->_dataforecastExist($startdate,$enddate,$ref_startdate,$ref_enddate,$type)){
			$this->db->where('branch', $branch_id);
			$this->db->where('status', '0');
			$this->db->where('datestart', $startdate);
			$this->db->where('dateend', $enddate);
			$this->db->where('ref_datestart', $ref_startdate);
			$this->db->where('ref_dateend', $ref_enddate);
			$this->db->delete('pending_forecast')->row_array();

			return TRUE;

		}else{

			$this->db->set('datestart', $startdate);
			$this->db->set('dateend', $enddate);
			$this->db->set('ref_datestart', $ref_startdate);
			$this->db->set('ref_dateend', $ref_enddate);
			$this->db->set('branch', $branch_id);
			$this->db->set('status', '0');
			$this->db->set('type', $type);
			$this->db->set('[update]', $date);
			$this->db->insert('pending_forecast');

			return $this->db->insert_id();

		}

	}

	public function _dataforecastExist($startdate,$enddate,$ref_startdate,$ref_enddate,$type){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('branch', $branch_id);
		$this->db->where('status', '0');
		$this->db->where('datestart', $startdate);
		$this->db->where('dateend', $enddate);
		$this->db->where('ref_datestart', $ref_startdate);
		$this->db->where('ref_dateend', $ref_enddate);
		$row = $this->db->get('pending_forecast')->row_array();

		if(count($row)>0){
			return TRUE;
		
		}else{
			return FALSE;

		}

	}

//----------------------summary forecast----------------------------------------------------------
	
	
	public function _getgross_sf1($tues_date,$tues_dates){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('forecast_amount');
		$this->db->where('date', $tues_date);
		$this->db->where('ref_date', $tues_dates);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('daily_forecasting_dayone')->row_array();

		if(count($row) > 0){
			return $row['forecast_amount'];
		
		}else{
			return 0;

		}

	}

	public function _getgross_sf2($wed_date,$wed_dates){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('forecast_amount');
		$this->db->where('date', $wed_date);
		$this->db->where('ref_date', $wed_dates);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('daily_forecasting_daytwo')->row_array();

		if(count($row) > 0){
			return $row['forecast_amount'];
		
		}else{
			return 0;

		}
		
	}

	public function _getgross_sf3($thurs_date,$thurs_dates){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('forecast_amount');
		$this->db->where('date', $thurs_date);
		$this->db->where('ref_date', $thurs_dates);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('daily_forecasting_daythree')->row_array();

		if(count($row) > 0){
			return $row['forecast_amount'];
		
		}else{
			return 0;

		}
		
	}

	public function _getgross_sf4($fri_date,$fri_dates){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('forecast_amount');
		$this->db->where('date', $fri_date);
		$this->db->where('ref_date', $fri_dates);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('daily_forecasting_dayfour')->row_array();

		if(count($row) > 0){
			return $row['forecast_amount'];
		
		}else{
			return 0;

		}
		
	}

	public function _getgross_sf5($sat_date,$sat_dates){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('forecast_amount');
		$this->db->where('date', $sat_date);
		$this->db->where('ref_date', $sat_dates);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('daily_forecasting_dayfive')->row_array();

		if(count($row) > 0){
			return $row['forecast_amount'];
		
		}else{
			return 0;

		}
		
	}

	public function _getgross_sf6($sun_date,$sun_dates){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('forecast_amount');
		$this->db->where('date', $sun_date);
		$this->db->where('ref_date', $sun_dates);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('daily_forecasting_daysix')->row_array();

		if(count($row) > 0){
			return $row['forecast_amount'];
		
		}else{
			return 0;

		}
		
	}

	public function _getgross_sf7($mon_date,$mon_dates){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('forecast_amount');
		$this->db->where('date', $mon_date);
		$this->db->where('ref_date', $mon_dates);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('daily_forecasting_dayseven')->row_array();

		if(count($row) > 0){
			return $row['forecast_amount'];
		
		}else{
			return 0;

		}
		
	}


	public function _selectsf($data,$search){
		$branch_id = $this->session->userdata('branch_id');

		// $this->db->order_by('daily_forecasting_dayone.fgsold', 'asc');
		$this->db->select('items.[desc], daily_forecasting_dayone.final_order as one, daily_forecasting_daytwo.final_order as two, daily_forecasting_daythree.final_order as three, 
						daily_forecasting_dayfour.final_order as four, daily_forecasting_dayfive.final_order as five, daily_forecasting_daysix.final_order as six, 
						daily_forecasting_dayseven.final_order as seven');
		$this->db->join('daily_forecasting_dayone','daily_forecasting_dayone.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_daytwo','daily_forecasting_daytwo.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_daythree','daily_forecasting_daythree.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_dayfour','daily_forecasting_dayfour.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_dayfive','daily_forecasting_dayfive.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_daysix','daily_forecasting_daysix.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_dayseven','daily_forecasting_dayseven.barcode = items.barcode','left');
		$this->db->where('daily_forecasting_dayone.date', $data['f_tues_date']);
		$this->db->where('daily_forecasting_dayone.ref_date', $data['tues_date']);
		$this->db->where('daily_forecasting_dayone.location', $branch_id);
		$this->db->where('daily_forecasting_daytwo.date', $data['f_wed_date']);
		$this->db->where('daily_forecasting_daytwo.ref_date', $data['wed_date']);
		$this->db->where('daily_forecasting_daytwo.location', $branch_id);
		$this->db->where('daily_forecasting_daythree.date', $data['f_thurs_date']);
		$this->db->where('daily_forecasting_daythree.ref_date', $data['thurs_date']);
		$this->db->where('daily_forecasting_daythree.location', $branch_id);
		$this->db->where('daily_forecasting_dayfour.date', $data['f_fri_date']);
		$this->db->where('daily_forecasting_dayfour.ref_date', $data['fri_date']);
		$this->db->where('daily_forecasting_dayfour.location', $branch_id);
		$this->db->where('daily_forecasting_dayfive.date', $data['f_sat_date']);
		$this->db->where('daily_forecasting_dayfive.ref_date', $data['sat_date']);
		$this->db->where('daily_forecasting_dayfive.location', $branch_id);
		$this->db->where('daily_forecasting_daysix.date', $data['f_sun_date']);
		$this->db->where('daily_forecasting_daysix.ref_date', $data['sun_date']);
		$this->db->where('daily_forecasting_daysix.location', $branch_id);
		$this->db->where('daily_forecasting_dayseven.date', $data['f_mon_date']);
		$this->db->where('daily_forecasting_dayseven.ref_date', $data['mon_date']);
		$this->db->where('daily_forecasting_dayseven.location', $branch_id);
		$this->db->order_by('items.[desc]','asc');
		$this->db->like('items.[desc]',$search);
		return $this->db->get('items')->result_array();
		
	}

	public function _selectsf_u($data,$search){
		$branch_id = $this->session->userdata('branch_id');

		// $this->db->order_by('daily_forecasting_dayone.fgsold', 'asc');
		$this->db->select('items.[desc], daily_forecasting_dayone.final_order as one, daily_forecasting_daytwo.final_order as two, daily_forecasting_daythree.final_order as three, 
						daily_forecasting_dayfour.final_order as four, daily_forecasting_dayfive.final_order as five, daily_forecasting_daysix.final_order as six, 
						daily_forecasting_dayseven.final_order as seven');
		$this->db->join('daily_forecasting_dayone','daily_forecasting_dayone.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_daytwo','daily_forecasting_daytwo.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_daythree','daily_forecasting_daythree.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_dayfour','daily_forecasting_dayfour.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_dayfive','daily_forecasting_dayfive.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_daysix','daily_forecasting_daysix.barcode = items.barcode','left');
		$this->db->join('daily_forecasting_dayseven','daily_forecasting_dayseven.barcode = items.barcode','left');
		$this->db->where('daily_forecasting_dayone.date', $data['f_tues_date']);
		$this->db->where('daily_forecasting_dayone.ref_date', $data['tues_date']);
		$this->db->where('daily_forecasting_dayone.location', $branch_id);
		$this->db->where('daily_forecasting_daytwo.date', $data['f_wed_date']);
		$this->db->where('daily_forecasting_daytwo.ref_date', $data['wed_date']);
		$this->db->where('daily_forecasting_daytwo.location', $branch_id);
		$this->db->where('daily_forecasting_daythree.date', $data['f_thurs_date']);
		$this->db->where('daily_forecasting_daythree.ref_date', $data['thurs_date']);
		$this->db->where('daily_forecasting_daythree.location', $branch_id);
		$this->db->where('daily_forecasting_dayfour.date', $data['f_fri_date']);
		$this->db->where('daily_forecasting_dayfour.ref_date', $data['fri_date']);
		$this->db->where('daily_forecasting_dayfour.location', $branch_id);
		$this->db->where('daily_forecasting_dayfive.date', $data['f_sat_date']);
		$this->db->where('daily_forecasting_dayfive.ref_date', $data['sat_date']);
		$this->db->where('daily_forecasting_dayfive.location', $branch_id);
		$this->db->where('daily_forecasting_daysix.date', $data['f_sun_date']);
		$this->db->where('daily_forecasting_daysix.ref_date', $data['sun_date']);
		$this->db->where('daily_forecasting_daysix.location', $branch_id);
		$this->db->where('daily_forecasting_dayseven.date', $data['f_mon_date']);
		$this->db->where('daily_forecasting_dayseven.ref_date', $data['mon_date']);
		$this->db->where('daily_forecasting_dayseven.location', $branch_id);
		$this->db->order_by('items.[desc]','asc');
		$this->db->like('items.[desc]',$search);
		return $this->db->get('items')->result_array();
		
	}


//---------------------Product Mixed---------------------------------------------------------------

	public function _selectpm($data,$search){
		$branch_id = $this->session->userdata('branch_id');

		// $this->db->order_by('daily_forecasting_dayone.fgsold', 'asc');
		$this->db->select('items.[desc], pm1.fgsold as one, pm2.fgsold as two, pm3.fgsold as three, 
						pm4.fgsold as four, pm5.fgsold as five, pm6.fgsold as six, 
						pm7.fgsold as seven');
		$this->db->join('pm1','pm1.barcode = items.barcode','left');
		$this->db->join('pm2','pm2.barcode = items.barcode','left');
		$this->db->join('pm3','pm3.barcode = items.barcode','left');
		$this->db->join('pm4','pm4.barcode = items.barcode','left');
		$this->db->join('pm5','pm5.barcode = items.barcode','left');
		$this->db->join('pm6','pm6.barcode = items.barcode','left');
		$this->db->join('pm7','pm7.barcode = items.barcode','left');
		$this->db->where('pm1.date', $data['f_tues_date']);
		$this->db->where('pm1.ref_date', $data['tues_date']);
		$this->db->where('pm1.location', $branch_id);
		$this->db->where('pm2.date', $data['f_wed_date']);
		$this->db->where('pm2.ref_date', $data['wed_date']);
		$this->db->where('pm2.location', $branch_id);
		$this->db->where('pm3.date', $data['f_thurs_date']);
		$this->db->where('pm3.ref_date', $data['thurs_date']);
		$this->db->where('pm3.location', $branch_id);
		$this->db->where('pm4.date', $data['f_fri_date']);
		$this->db->where('pm4.ref_date', $data['fri_date']);
		$this->db->where('pm4.location', $branch_id);
		$this->db->where('pm5.date', $data['f_sat_date']);
		$this->db->where('pm5.ref_date', $data['sat_date']);
		$this->db->where('pm5.location', $branch_id);
		$this->db->where('pm6.date', $data['f_sun_date']);
		$this->db->where('pm6.ref_date', $data['sun_date']);
		$this->db->where('pm6.location', $branch_id);
		$this->db->where('pm7.date', $data['f_mon_date']);
		$this->db->where('pm7.ref_date', $data['mon_date']);
		$this->db->where('pm7.location', $branch_id);
		$this->db->order_by('items.[desc]', 'asc');
		$this->db->like('items.[desc]',$search);
		// $this->db->order_by('items.[desc]','asc');
		return $this->db->get('items')->result_array();
		
	}

	public function _selectpm_forprint($data){
		$branch_id = $this->session->userdata('branch_id');

		// $this->db->order_by('daily_forecasting_dayone.fgsold', 'asc');
		$this->db->select('items.[desc], items.sapcode, pm1.fgsold as dayone, pm2.fgsold as daytwo, pm3.fgsold as daythree, 
						pm4.fgsold as dayfour, pm5.fgsold as dayfive, pm6.fgsold as daysix, 
						pm7.fgsold as dayseven');
		$this->db->join('pm1','pm1.barcode = items.barcode','left');
		$this->db->join('pm2','pm2.barcode = items.barcode','left');
		$this->db->join('pm3','pm3.barcode = items.barcode','left');
		$this->db->join('pm4','pm4.barcode = items.barcode','left');
		$this->db->join('pm5','pm5.barcode = items.barcode','left');
		$this->db->join('pm6','pm6.barcode = items.barcode','left');
		$this->db->join('pm7','pm7.barcode = items.barcode','left');
		$this->db->where('pm1.date', $data['f_tues_date']);
		$this->db->where('pm1.ref_date', $data['tues_date']);
		$this->db->where('pm1.location', $branch_id);
		$this->db->where('pm2.date', $data['f_wed_date']);
		$this->db->where('pm2.ref_date', $data['wed_date']);
		$this->db->where('pm2.location', $branch_id);
		$this->db->where('pm3.date', $data['f_thurs_date']);
		$this->db->where('pm3.ref_date', $data['thurs_date']);
		$this->db->where('pm3.location', $branch_id);
		$this->db->where('pm4.date', $data['f_fri_date']);
		$this->db->where('pm4.ref_date', $data['fri_date']);
		$this->db->where('pm4.location', $branch_id);
		$this->db->where('pm5.date', $data['f_sat_date']);
		$this->db->where('pm5.ref_date', $data['sat_date']);
		$this->db->where('pm5.location', $branch_id);
		$this->db->where('pm6.date', $data['f_sun_date']);
		$this->db->where('pm6.ref_date', $data['sun_date']);
		$this->db->where('pm6.location', $branch_id);
		$this->db->where('pm7.date', $data['f_mon_date']);
		$this->db->where('pm7.ref_date', $data['mon_date']);
		$this->db->where('pm7.location', $branch_id);
		$this->db->order_by('items.[desc]', 'asc');
		// $this->db->order_by('items.[desc]','asc');
		return $this->db->get('items')->result_array();
		
	}
//---------------------check if data exist---------------------------------------------------------

	public function check_if_startdataExist($startdate){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('status', '1');
		$this->db->where('date', $startdate);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayone')->row_array();

		if(count($row) > 0){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function check_if_enddataExist($end_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('status', '1');
		$this->db->where('date', $end_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayseven')->row_array();

		if(count($row) > 0){
			return TRUE;
		}else{
			return 0;
		}		

	}

//---------------------validation------------------------------------------------------------------

	public function _getforecast1_val($startdate){
		$date = $startdate . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
	
		$query = sprintf("SELECT TOP 2 items.barcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast2_val($wed_date){
		$date = $wed_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT TOP 2 items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast3_val($thurs_date){
		$date = $thurs_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT TOP 2 items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast4_val($fri_date){
		$date = $fri_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT TOP 2 items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast5_val($sat_date){
		$date = $sat_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT TOP 2 items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast6_val($sun_date){
		$date = $sun_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT TOP 2 items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast7_val($mon_date){
		$date = $mon_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT TOP 2 items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}


//---------------------get total average gross and fgsold-----------------------------------------------------
	public function _getavg_totalgross($ref_s,$ref_e){
		$ref_sdate = $ref_s . ' ' . '00:00:00.000';
		$ref_edate = $ref_e . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');


		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach($results as $row) {
		 
		 $location = $row['location'];

		 $query = sprintf("SELECT sum(tprice) as gross FROM salesm1 WHERE date BETWEEN '$ref_sdate' AND '$ref_edate' AND branch = '$location'");

		 $rows = $this->db->query($query)->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			$resulted = $gross / 7;
			
			return $resulted;

		}else{
			return 0;
		
		}
	}

	public function _getavg_forecast1($ref_s,$ref_e){
		$ref_sdate = $ref_s . ' ' . '00:00:00.000';
		$ref_edate = $ref_e . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.qty) as need, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date  BETWEEN '$ref_sdate' and '$ref_edate' and salesm2.branch BETWEEN '$current' and '$end'
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

//--for result--//

	public function _getavg_reference($ref_s,$ref_e){
		$ref_sdate = $ref_s . ' ' . '00:00:00.000';
		$ref_edate = $ref_e . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
	
		$query = sprintf("SELECT TOP 2 items.barcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date  BETWEEN '$ref_sdate' and '$ref_edate' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();
	}

//---------------------for tuesday-----------------------------------------------------------------

	public function _gettotalgross1($startdate){
		$date = $startdate . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $this->db->where('date', $date);
		 $this->db->where('branch', $row['location']);
		 $this->db->select('sum(tprice) as gross');
		 $rows = $this->db->get('salesm1')->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast1($startdate){
		$date = $startdate . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
		FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch BETWEEN '$current' and '$end' 
		and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert1($total_gross_dayone,$result_dayone,$startdate,$ref_s){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist($startdate,$ref_s)){
			return 0;

		}else{

			foreach($result_dayone as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);	
					$this->db->set('total_gross', $total_gross_dayone);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					$this->db->set('ref_date', $ref_s);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $startdate);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_dayone');		
				}

			}	
			return TRUE;

		}
	}

	public function update1($total_gross_dayone1,$result_dayone1,$startdate,$ref_s){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist($startdate,$ref_s)){

			foreach($result_dayone1 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'] / 7;
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('status', '0');
					$this->db->where('date', $startdate);
					$this->db->where('ref_date', $ref_s);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $total_gross_dayone1);
					$this->db->set('build_amount', $need / $total_gross_dayone1);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('daily_forecasting_dayone');		
				}

			}	
			return TRUE;

		}
	}

	public function insert1_pm($result_dayone,$startdate,$date1){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist_pm($startdate,$date1)){
			return 0;

		}else{

			foreach($result_dayone as $row){
					
				if($row['barcode'] != ""){	

					$this->db->set('date', $startdate);
					$this->db->set('location', $branch_id);
					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('[desc]', $row['desc']);
					$this->db->set('barcode', $row['barcode']);	
					$this->db->set('ref_date', $date1);
					$this->db->insert('pm1');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist_pm($startdate,$date1){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $date1);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('pm1')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	function _dataExist($startdate,$ref_s){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('ref_date', $ref_s);
		$this->db->where('date', $startdate);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayone')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday1($startdate,$ref_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayone')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayOne($limit=null,$offset=null,$startdate,$ref_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('ref_date', $ref_date);
		$this->db->where('date', $startdate);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_dayone')->result_array();

	}

	public function day1fa($startdate,$ref_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayone WHERE date = '$startdate' AND ref_date = '$ref_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

	// public function u_insert1($total_gross_dayone,$result_dayone,$startdate){
	// 	error_reporting(0);

	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	if($this->u_dataExist($startdate)){
	// 		return 0;

	// 	}else{

	// 		foreach($result_dayone as $row){
				
	// 			if($row['barcode'] != ""){

	// 				$this->db->set('fgsold', $row['qty']);	
	// 				$this->db->set('total_gross', $total_gross_dayone);
	// 				$this->db->set('barcode', $row['barcode']);
	// 				$this->db->set('fg', $row['desc']);
	// 				$this->db->set('size', $row['size']);
	// 				$this->db->set('build_amount', $row['qty'] / $total_gross_dayone);
	// 				$this->db->set('location', $branch_id);
	// 				$this->db->set('date', $startdate);
	// 				$this->db->set('status', '0');
	// 				$this->db->insert('daily_forecasting_dayone');		
	// 			}

	// 		}	
	// 		return TRUE;

	// 	}
	// }

	// function u_dataExist($startdate){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $startdate);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$row = $this->db->get('daily_forecasting_dayone')->row_array();

	// 	if(count($row) > 1){
	// 		return TRUE;
	// 	}else{
	// 		return 0;
	// 	}		

	// }

	// public function u_countday1($startdate){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $startdate);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_dayone')->result_array();
		
	// 	$count = count($result);

	// 	return $count;
	// }

	// public function u_selectAllDayOne($limit=null,$offset=null,$startdate){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->limit($limit = $limit, $offset = $offset);
	// 	$this->db->where('date', $startdate);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	return $this->db->get('daily_forecasting_dayone')->result_array();

	// }

	// public function u_day1fa($startdate){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayone WHERE date = '$startdate' AND location = '$branch_id' and status = '0' GROUP BY forecast_amount");

	// 	return $this->db->query($query)->row();
	// }

//---------------------for wednesday-----------------------------------------------------------------

	public function _gettotalgross2($wed_date){
		$date = $wed_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $this->db->where('date', $date);
		 $this->db->where('branch', $row['location']);
		 $this->db->select('sum(tprice) as gross');
		 $rows = $this->db->get('salesm1')->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast2($wed_date){
		$date = $wed_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
						FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch BETWEEN '$current' and '$end'
						and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert2($total_gross_daytwo,$result_daytwo,$date_wed,$wed_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist2($date_wed,$wed_date)){
			return 0;

		}else{

			foreach($result_daytwo as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);		
					$this->db->set('total_gross', $total_gross_daytwo);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_daytwo);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $date_wed);
					$this->db->set('ref_date', $wed_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_daytwo');		
				}

			}	
			return TRUE;

		}
	}

	public function update2($total_gross_daytwo2,$result_daytwo2,$date_wed,$wed_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist2($date_wed,$wed_date)){

			foreach($result_daytwo2 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'] / 7;
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('status', '0');
					$this->db->where('date', $date_wed);
					$this->db->where('barcode', $row['barcode']);
					$this->db->where('ref_date', $wed_date);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $total_gross_daytwo2);
					$this->db->set('build_amount', $need / $total_gross_daytwo2);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('daily_forecasting_daytwo');		
				}

			}	
			return TRUE;

		}
	}

	public function insert2_pm($result_daytwo,$wed_date,$date2){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist2_pm($wed_date,$date2)){
			return 0;

		}else{

			foreach($result_daytwo as $row){
				
				if($row['barcode'] != ""){	

					$this->db->set('date', $wed_date);
					$this->db->set('location', $branch_id);
					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('[desc]', $row['desc']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('ref_date', $date2);
					$this->db->insert('pm2');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist2_pm($startdate,$date2){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $date2);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('pm2')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	function _dataExist2($date_wed,$wed_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_wed);
		$this->db->where('ref_date',$wed_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_daytwo')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday2($date_wed,$wed_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_wed);
		$this->db->where('ref_date', $wed_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_daytwo')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayTwo($limit=null,$offset=null,$date_wed,$wed_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('ref_date', $wed_date);
		$this->db->where('date', $date_wed);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_daytwo')->result_array();

	}

	public function day2fa($date_wed,$wed_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_daytwo WHERE date = '$date_wed' AND ref_date = '$wed_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

	// public function u_insert2($total_gross_daytwo,$result_daytwo,$wed_date){
	// 	error_reporting(0);

	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	if($this->u_dataExist2($wed_date)){
	// 		return 0;

	// 	}else{

	// 		foreach($result_daytwo as $row){
				
	// 			if($row['barcode'] != ""){

	// 				$this->db->set('fgsold', $row['qty']);	
	// 				$this->db->set('total_gross', $total_gross_daytwo);
	// 				$this->db->set('barcode', $row['barcode']);
	// 				$this->db->set('fg', $row['desc']);
	// 				$this->db->set('size', $row['size']);
	// 				$this->db->set('build_amount', $row['qty'] / $total_gross_daytwo);
	// 				$this->db->set('location', $branch_id);
	// 				$this->db->set('date', $wed_date);
	// 				$this->db->set('status', '0');
	// 				$this->db->insert('daily_forecasting_daytwo');		
	// 			}

	// 		}	
	// 		return TRUE;

	// 	}
	// }

	// function u_dataExist2($wed_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $wed_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$row = $this->db->get('daily_forecasting_daytwo')->row_array();

	// 	if(count($row) > 1){
	// 		return TRUE;
	// 	}else{
	// 		return 0;
	// 	}		

	// }

	// public function u_countday2($wed_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $wed_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_daytwo')->result_array();
		
	// 	$count = count($result);

	// 	return $count;
	// }

	// public function u_selectAllDayTwo($limit=null,$offset=null,$wed_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->limit($limit = $limit, $offset = $offset);
	// 	$this->db->where('date', $wed_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	return $this->db->get('daily_forecasting_daytwo')->result_array();

	// }

	// public function u_day2fa($wed_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$query = sprintf("SELECT forecast_amount FROM daily_forecasting_daytwo WHERE date = '$wed_date' AND location = '$branch_id' and status = '0' GROUP BY forecast_amount");

	// 	return $this->db->query($query)->row();
	// }

//---------------------for thurssday-----------------------------------------------------------------

	public function _gettotalgross3($thurs_date){
		$date = $thurs_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $this->db->where('date', $date);
		 $this->db->where('branch', $row['location']);
		 $this->db->select('sum(tprice) as gross');
		 $rows = $this->db->get('salesm1')->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast3($thurs_date){
		$date = $thurs_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
						FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch BETWEEN '$current' and '$end' 
						and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert3($total_gross_daythree,$result_daythree,$date_thurs,$thurs_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist3($date_thurs,$thurs_date)){
			return 0;

		}else{

			foreach($result_daythree as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);		
					$this->db->set('total_gross', $total_gross_daythree);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_daythree);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $date_thurs);
					$this->db->set('ref_date', $thurs_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_daythree');		
				}

			}	
			return TRUE;

		}
	}

	public function update3($total_gross_daythree3,$result_daythree3,$date_thurs,$thurs_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist3($date_thurs,$thurs_date)){

			foreach($result_daythree3 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'] / 7;
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('status', '0');
					$this->db->where('date', $date_thurs);
					$this->db->where('ref_date', $thurs_date);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $total_gross_daythree3);
					$this->db->set('build_amount', $need / $total_gross_daythree3);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('daily_forecasting_daythree');		
				}

			}	
			return TRUE;

		}
	}

	public function insert3_pm($result_daythree,$thurs_date,$date3){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist3_pm($thurs_date,$date3)){
			return 0;

		}else{

			foreach($result_daythree as $row){
				
				if($row['barcode'] != ""){	

					$this->db->set('date', $thurs_date);
					$this->db->set('location', $branch_id);
					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('[desc]', $row['desc']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('ref_date', $date3);
					$this->db->insert('pm3');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist3_pm($startdate,$date3){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $date3);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('pm3')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	function _dataExist3($date_thurs,$thurs_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('ref_date', $thurs_date);
		$this->db->where('date', $date_thurs);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_daythree')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday3($date_thurs,$thurs_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('ref_date', $thurs_date);	
		$this->db->where('date', $date_thurs);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_daythree')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayThree($limit=null,$offset=null,$date_thurs,$thurs_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('ref_date', $thurs_date);
		$this->db->where('date', $date_thurs);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_daythree')->result_array();

	}

	public function day3fa($date_thurs,$thurs_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_daythree WHERE date = '$date_thurs' AND ref_date = '$thurs_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

	// public function u_insert3($total_gross_daythree,$result_daythree,$thurs_date){
	// 	error_reporting(0);

	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	if($this->u_dataExist3($thurs_date)){
	// 		return 0;

	// 	}else{

	// 		foreach($result_daythree as $row){
				
	// 			if($row['barcode'] != ""){

	// 				$this->db->set('fgsold', $row['qty']);	
	// 				$this->db->set('total_gross', $total_gross_daythree);
	// 				$this->db->set('barcode', $row['barcode']);
	// 				$this->db->set('fg', $row['desc']);
	// 				$this->db->set('size', $row['size']);
	// 				$this->db->set('build_amount', $row['qty'] / $total_gross_daythree);
	// 				$this->db->set('location', $branch_id);
	// 				$this->db->set('date', $thurs_date);
	// 				$this->db->set('status', '0');
	// 				$this->db->insert('daily_forecasting_daythree');		
	// 			}

	// 		}	
	// 		return TRUE;

	// 	}
	// }

	// function u_dataExist3($thurs_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $thurs_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$row = $this->db->get('daily_forecasting_daythree')->row_array();

	// 	if(count($row) > 1){
	// 		return TRUE;
	// 	}else{
	// 		return 0;
	// 	}		

	// }

	// public function u_countday3($thurs_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $thurs_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_daythree')->result_array();
		
	// 	$count = count($result);

	// 	return $count;
	// }

	// public function u_selectAllDayThree($limit=null,$offset=null,$thurs_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->limit($limit = $limit, $offset = $offset);
	// 	$this->db->where('date', $thurs_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	return $this->db->get('daily_forecasting_daythree')->result_array();

	// }

	// public function u_day3fa($thurs_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$query = sprintf("SELECT forecast_amount FROM daily_forecasting_daythree WHERE date = '$thurs_date' AND location = '$branch_id' and status = '0' GROUP BY forecast_amount");

	// 	return $this->db->query($query)->row();
	// }

//---------------------for friday-----------------------------------------------------------------

	public function _gettotalgross4($fri_date){
		$date = $fri_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $this->db->where('date', $date);
		 $this->db->where('branch', $row['location']);
		 $this->db->select('sum(tprice) as gross');
		 $rows = $this->db->get('salesm1')->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast4($fri_date){
		$date = $fri_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
						FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch BETWEEN '$current' and '$end' 
						and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert4($total_gross_dayfour,$result_dayfour,$date_fri,$fri_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist4($date_fri,$fri_date)){
			return 0;

		}else{

			foreach($result_dayfour as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);		
					$this->db->set('total_gross', $total_gross_dayfour);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayfour);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $date_fri);
					$this->db->set('ref_date', $fri_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_dayfour');		
				}

			}	
			return TRUE;

		}
	}

	public function update4($total_gross_dayfour4,$result_dayfour4,$date_fri,$fri_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist4($date_fri,$fri_date)){

			foreach($result_dayfour4 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'] / 7;
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('status', '0');
					$this->db->where('date', $date_fri);
					$this->db->where('ref_date', $fri_date);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $total_gross_dayfour4);
					$this->db->set('build_amount', $need / $total_gross_dayfour4);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('daily_forecasting_dayfour');		
				}

			}	
			return TRUE;

		}
	}

	public function insert4_pm($result_dayfour,$fri_date,$date4){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist4_pm($fri_date,$date4)){
			return 0;

		}else{

			foreach($result_dayfour as $row){
				
				if($row['barcode'] != ""){	

					$this->db->set('date', $fri_date);
					$this->db->set('location', $branch_id);
					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('[desc]', $row['desc']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('ref_date', $date4);
					$this->db->insert('pm4');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist4_pm($startdate,$date4){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $date4);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('pm4')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	function _dataExist4($date_fri,$fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_fri);
		$this->db->where('ref_date', $fri_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayfour')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday4($date_fri,$fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_fri);
		$this->db->where('ref_date', $fri_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayfour')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayFour($limit=null,$offset=null,$date_fri,$fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $date_fri);
		$this->db->where('ref_date', $fri_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_dayfour')->result_array();

	}

	public function day4fa($date_fri,$fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayfour WHERE date = '$date_fri' AND ref_date = '$fri_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

	// public function u_insert4($total_gross_dayfour,$result_dayfour,$fri_date){
	// 	error_reporting(0);

	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	if($this->u_dataExist4($fri_date)){
	// 		return 0;

	// 	}else{

	// 		foreach($result_dayfour as $row){
				
	// 			if($row['barcode'] != ""){

	// 				$this->db->set('fgsold', $row['qty']);	
	// 				$this->db->set('total_gross', $total_gross_dayfour);
	// 				$this->db->set('barcode', $row['barcode']);
	// 				$this->db->set('fg', $row['desc']);
	// 				$this->db->set('size', $row['size']);
	// 				$this->db->set('build_amount', $row['qty'] / $total_gross_dayfour);
	// 				$this->db->set('location', $branch_id);
	// 				$this->db->set('date', $fri_date);
	// 				$this->db->set('status', '0');
	// 				$this->db->insert('daily_forecasting_dayfour');		
	// 			}

	// 		}	
	// 		return TRUE;

	// 	}
	// }

	// function u_dataExist4($fri_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $fri_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$row = $this->db->get('daily_forecasting_dayfour')->row_array();

	// 	if(count($row) > 1){
	// 		return TRUE;
	// 	}else{
	// 		return 0;
	// 	}		

	// }

	// public function u_countday4($fri_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $fri_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_dayfour')->result_array();
		
	// 	$count = count($result);

	// 	return $count;
	// }

	// public function u_selectAllDayFour($limit=null,$offset=null,$fri_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->limit($limit = $limit, $offset = $offset);
	// 	$this->db->where('date', $fri_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	return $this->db->get('daily_forecasting_dayfour')->result_array();

	// }

	// public function u_day4fa($fri_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayfour WHERE date = '$fri_date' AND location = '$branch_id' and status = '0' GROUP BY forecast_amount");

	// 	return $this->db->query($query)->row();
	// }

//---------------------for saturday-----------------------------------------------------------------

	public function _gettotalgross5($sat_date){
		$date = $sat_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $this->db->where('date', $date);
		 $this->db->where('branch', $row['location']);
		 $this->db->select('sum(tprice) as gross');
		 $rows = $this->db->get('salesm1')->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast5($sat_date){
		$date = $sat_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
						FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch BETWEEN '$current' and '$end' 
						and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert5($total_gross_dayfive,$result_dayfive,$date_sat,$sat_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist5($date_sat,$sat_date)){
			return 0;

		}else{

			foreach($result_dayfive as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);		
					$this->db->set('total_gross', $total_gross_dayfive);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayfive);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $date_sat);
					$this->db->set('ref_date', $sat_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_dayfive');		
				}

			}	
			return TRUE;

		}
	}

	public function update5($total_gross_dayfive5,$result_dayfive5,$date_sat,$sat_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist5($date_sat,$sat_date)){

			foreach($result_dayfive5 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'] / 7;
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('status', '0');
					$this->db->where('date', $date_sat);
					$this->db->where('ref_date', $sat_date);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $total_gross_dayfive5);
					$this->db->set('build_amount', $need / $total_gross_dayfive5);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('daily_forecasting_dayfive');		
				}

			}	
			return TRUE;

		}
	}

	public function insert5_pm($result_dayfive,$sat_date,$date5){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist5_pm($sat_date,$date5)){
			return 0;

		}else{

			foreach($result_dayfive as $row){
				
				if($row['barcode'] != ""){	

					$this->db->set('date', $sat_date);
					$this->db->set('location', $branch_id);
					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('[desc]', $row['desc']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('ref_date', $date5);
					$this->db->insert('pm5');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist5_pm($startdate,$date5){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $date5);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('pm5')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	function _dataExist5($date_sat,$sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_sat);
		$this->db->where('ref_date', $sat_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayfive')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday5($date_sat,$sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_sat);
		$this->db->where('ref_date', $sat_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayfive')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayFive($limit=null,$offset=null,$date_sat,$sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $date_sat);
		$this->db->where('ref_date', $sat_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_dayfive')->result_array();

	}	

	public function day5fa($date_sat,$sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayfive WHERE date = '$date_sat' AND ref_date = '$sat_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

	// public function u_insert5($total_gross_dayfive,$result_dayfive,$sat_date){
	// 	error_reporting(0);

	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	if($this->u_dataExist5($sat_date)){
	// 		return 0;

	// 	}else{

	// 		foreach($result_dayfive as $row){
				
	// 			if($row['barcode'] != ""){

	// 				$this->db->set('fgsold', $row['qty']);	
	// 				$this->db->set('total_gross', $total_gross_dayfive);
	// 				$this->db->set('barcode', $row['barcode']);
	// 				$this->db->set('fg', $row['desc']);
	// 				$this->db->set('size', $row['size']);
	// 				$this->db->set('build_amount', $row['qty'] / $total_gross_dayfive);
	// 				$this->db->set('location', $branch_id);
	// 				$this->db->set('date', $sat_date);
	// 				$this->db->set('status', '0');
	// 				$this->db->insert('daily_forecasting_dayfive');		
	// 			}

	// 		}	
	// 		return TRUE;

	// 	}
	// }

	// function u_dataExist5($sat_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $sat_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$row = $this->db->get('daily_forecasting_dayfive')->row_array();

	// 	if(count($row) > 1){
	// 		return TRUE;
	// 	}else{
	// 		return 0;
	// 	}		

	// }

	// public function u_countday5($sat_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $sat_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_dayfive')->result_array();
		
	// 	$count = count($result);

	// 	return $count;
	// }

	// public function u_selectAllDayFive($limit=null,$offset=null,$sat_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->limit($limit = $limit, $offset = $offset);
	// 	$this->db->where('date', $sat_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	return $this->db->get('daily_forecasting_dayfive')->result_array();

	// }	

	// public function u_day5fa($sat_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayfive WHERE date = '$sat_date' AND location = '$branch_id' and status = '0' GROUP BY forecast_amount");

	// 	return $this->db->query($query)->row();
	// }

//---------------------for sunday-----------------------------------------------------------------

	public function _gettotalgross6($sun_date){
		$date = $sun_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $this->db->where('date', $date);
		 $this->db->where('branch', $row['location']);
		 $this->db->select('sum(tprice) as gross');
		 $rows = $this->db->get('salesm1')->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast6($sun_date){
		$date = $sun_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
						FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch BETWEEN '$current' and '$end' 
						and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert6($total_gross_daysix,$result_daysix,$date_sun,$sun_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist6($date_sun,$sun_date)){
			return 0;

		}else{

			foreach($result_daysix as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);		
					$this->db->set('total_gross', $total_gross_daysix);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_daysix);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $date_sun);
					$this->db->set('ref_date', $sun_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_daysix');		
				}

			}	
			return TRUE;

		}
	}

	public function update6($total_gross_daysix6,$result_daysix6,$date_sun,$sun_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist6($date_sun,$sun_date)){

			foreach($result_daysix6 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'] / 7;
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('status', '0');
					$this->db->where('date', $date_sun);
					$this->db->where('ref_date', $sun_date);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $total_gross_daysix6);
					$this->db->set('build_amount', $need / $total_gross_daysix6);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('daily_forecasting_daysix');		
				}

			}	
			return TRUE;

		}
	}

	public function insert6_pm($result_daysix,$sun_date,$date6){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist6_pm($sun_date,$date6)){
			return 0;

		}else{

			foreach($result_daysix as $row){
				
				if($row['barcode'] != ""){	

					$this->db->set('date', $sun_date);
					$this->db->set('location', $branch_id);
					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('[desc]', $row['desc']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('ref_date', $date6);
					$this->db->insert('pm6');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist6_pm($startdate,$date6){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $date6);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('pm6')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	function _dataExist6($date_sun,$sun_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_sun);
		$this->db->where('ref_date', $sun_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_daysix')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday6($date_sun,$sun_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_sun);
		$this->db->where('ref_date', $sun_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_daysix')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDaySix($limit=null,$offset=null,$date_sun,$sun_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $date_sun);
		$this->db->where('ref_date', $sun_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_daysix')->result_array();

	}	

	public function day6fa($date_sun,$sun_date){
		$branch_id = $this->session->userdata('branch_id');
			
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_daysix WHERE date = '$date_sun' AND ref_date = '$sun_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

	// public function u_insert6($total_gross_daysix,$result_daysix,$sun_date){
	// 	error_reporting(0);

	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	if($this->u_dataExist6($sun_date)){
	// 		return 0;

	// 	}else{

	// 		foreach($result_daysix as $row){
				
	// 			if($row['barcode'] != ""){

	// 				$this->db->set('fgsold', $row['qty']);	
	// 				$this->db->set('total_gross', $total_gross_daysix);
	// 				$this->db->set('barcode', $row['barcode']);
	// 				$this->db->set('fg', $row['desc']);
	// 				$this->db->set('size', $row['size']);
	// 				$this->db->set('build_amount', $row['qty'] / $total_gross_daysix);
	// 				$this->db->set('location', $branch_id);
	// 				$this->db->set('date', $sun_date);
	// 				$this->db->set('status', '0');
	// 				$this->db->insert('daily_forecasting_daysix');		
	// 			}

	// 		}	
	// 		return TRUE;

	// 	}
	// }

	// function u_dataExist6($sun_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $sun_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$row = $this->db->get('daily_forecasting_daysix')->row_array();

	// 	if(count($row) > 1){
	// 		return TRUE;
	// 	}else{
	// 		return 0;
	// 	}		

	// }

	// public function u_countday6($sun_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $sun_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_daysix')->result_array();
		
	// 	$count = count($result);

	// 	return $count;
	// }

	// public function u_selectAllDaySix($limit=null,$offset=null,$sun_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->limit($limit = $limit, $offset = $offset);
	// 	$this->db->where('date', $sun_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	return $this->db->get('daily_forecasting_daysix')->result_array();

	// }	

	// public function u_day6fa($sun_date){
	// 	$branch_id = $this->session->userdata('branch_id');
			
	// 	$query = sprintf("SELECT forecast_amount FROM daily_forecasting_daysix WHERE date = '$sun_date' AND location = '$branch_id' and status = '0' GROUP BY forecast_amount");

	// 	return $this->db->query($query)->row();
	// }

//---------------------for monday-----------------------------------------------------------------

	public function _gettotalgross7($mon_date){
		$date = $mon_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $this->db->where('date', $date);
		 $this->db->where('branch', $row['location']);
		 $this->db->select('sum(tprice) as gross');
		 $rows = $this->db->get('salesm1')->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast7($mon_date){
		$date = $mon_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('location', $branch_id);
		$this->db->select('locationd');
		$result = $this->db->get('location')->row();

		$locationd = $result->locationd;

		$explodes_arr = explode(' ', $locationd);
		
		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3] . ' ' . $explodes_arr[4] . ' ' . $explodes_arr[5];

		}else{
			$locations = $explodes_arr[0] . ' ' . $explodes_arr[1];

		}
		

		$this->db->like('locationd', $locations);
		$this->db->select('location,locationd');
		$results = $this->db->get('location')->result_array();

		 $array = array();

		foreach ($results as $row) {
		 
		 $location = $row['location'];

		 $array[] = $location;

		}

		$current = current($array);
		$end = end($array);
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
						FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch BETWEEN '$current' and '$end' 
						and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert7($total_gross_dayseven,$result_dayseven,$date_mon,$mon_date){
		error_reporting(0);
	
		$branch_id = $this->session->userdata('branch_id');
			
		if($this->_dataExist7($date_mon,$mon_date)){
			return 0;

		}else{

			foreach($result_dayseven as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);		
					$this->db->set('total_gross', $total_gross_dayseven);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayseven);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $date_mon);
					$this->db->set('ref_date', $mon_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_dayseven');		
				}

			}	
			return TRUE;

		}
	}

	public function update7($total_gross_dayseven7,$result_dayseven7,$date_mon,$mon_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
	
		if($this->_dataExist7($date_mon,$mon_date)){

			foreach($result_dayseven7 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'] / 7;
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('status', '0');
					$this->db->where('date', $date_mon);
					$this->db->where('ref_date', $mon_date);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $total_gross_dayseven7);
					$this->db->set('build_amount', $need / $total_gross_dayseven7);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('daily_forecasting_dayseven');		
				}

			}	
			return TRUE;

		}
	}

	public function insert7_pm($result_dayseven,$mon_date,$date7){
		error_reporting(0);
	
		$branch_id = $this->session->userdata('branch_id');
			
		if($this->_dataExist7_pm($mon_date,$date7)){
			return 0;

		}else{

			foreach($result_dayseven as $row){
				
				if($row['barcode'] != ""){	

					$this->db->set('date', $mon_date);
					$this->db->set('location', $branch_id);
					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('[desc]', $row['desc']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('ref_date', $date7);
					$this->db->insert('pm7');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist7_pm($startdate,$date7){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $startdate);
		$this->db->where('ref_date', $date7);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('pm7')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	function _dataExist7($date_mon,$mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_mon);
		$this->db->where('ref_date',$mon_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayseven')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday7($date_mon,$mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date_mon);
		$this->db->where('ref_date', $mon_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayseven')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDaySeven($limit=null,$offset=null,$date_mon,$mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $date_mon);
		$this->db->where('ref_date', $mon_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_dayseven')->result_array();

	}	

	public function day7fa($date_mon,$mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayseven WHERE date = '$date_mon' AND ref_date = '$mon_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

	// public function u_insert7($total_gross_dayseven,$result_dayseven,$mon_date){
	// 	error_reporting(0);
	
	// 	$branch_id = $this->session->userdata('branch_id');
			
	// 	if($this->u_dataExist7($mon_date)){
	// 		return 0;

	// 	}else{

	// 		foreach($result_dayseven as $row){
				
	// 			if($row['barcode'] != ""){

	// 				$this->db->set('fgsold', $row['qty']);	
	// 				$this->db->set('total_gross', $total_gross_dayseven);
	// 				$this->db->set('barcode', $row['barcode']);
	// 				$this->db->set('fg', $row['desc']);
	// 				$this->db->set('size', $row['size']);
	// 				$this->db->set('build_amount', $row['qty'] / $total_gross_dayseven);
	// 				$this->db->set('location', $branch_id);
	// 				$this->db->set('date', $mon_date);
	// 				$this->db->set('status', '0');
	// 				$this->db->insert('daily_forecasting_dayseven');		
	// 			}

	// 		}	
	// 		return TRUE;

	// 	}
	// }

	// function u_dataExist7($mon_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $mon_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$row = $this->db->get('daily_forecasting_dayseven')->row_array();

	// 	if(count($row) > 1){
	// 		return TRUE;
	// 	}else{
	// 		return 0;
	// 	}		

	// }

	// public function u_countday7($mon_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->where('date', $mon_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_dayseven')->result_array();
		
	// 	$count = count($result);

	// 	return $count;
	// }

	// public function u_selectAllDaySeven($limit=null,$offset=null,$mon_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$this->db->limit($limit = $limit, $offset = $offset);
	// 	$this->db->where('date', $mon_date);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	return $this->db->get('daily_forecasting_dayseven')->result_array();

	// }	

	// public function u_day7fa($mon_date){
	// 	$branch_id = $this->session->userdata('branch_id');
		
	// 	$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayseven WHERE date = '$mon_date' AND location = '$branch_id' and status = '0' GROUP BY forecast_amount");

	// 	return $this->db->query($query)->row();
	// }

//-------------------------------------------------------------------------------------------------------	

//----------------------------Daily Forecasting Dayone Process-------------------------------------------

	public function _updatefa1($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('daily_forecasting_dayone');

		return TRUE;
	}

	public function _processfa1($data){
		 $branch_id = $this->session->userdata('branch_id');
	 	 
	 	 $this->db->where('date', $data['date']);
	 	 $this->db->where('ref_date', $data['ref_date']);
		 $this->db->where('location', $branch_id);
		 $result = $this->db->get('daily_forecasting_dayone')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date', $data['ref_date']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('daily_forecasting_dayone');

		}

		return TRUE;
	} 	

	public function _processfo1($data){
		error_reporting(0);

		$adjustment = $data['adjustment'];
		$count = $data['count'];

		foreach($adjustment as $row){

			$split = explode("/", $row);
			
			if($split[1]!=""){

				$this->db->where('id', $split[0]);
				$this->db->select('need');
				$row = $this->db->get('daily_forecasting_dayone')->row();

				$need = $row->need;

				$negative = "-";

				$splits = str_split($split[1]);

				if($splits[0]){
					$result = $need + $split[1];

				}else{
					$result = $need - $split[1];

				}

				$this->db->where('id', $split[0]);
				$this->db->set('adjustment', $split[1]);
				$this->db->set('final_order', $result);
				$this->db->update('daily_forecasting_dayone');

			}		
		
		}

		return TRUE;		
	}

	// public function u_updatefa1($data){
	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$this->db->set('forecast_amount', $data['forecasted_amount']);
	// 	$this->db->update('daily_forecasting_dayone');

	// 	return TRUE;
	// }

	// public function u_processfa1($data){
	// 	 $branch_id = $this->session->userdata('branch_id');
	 	 
	//  	 $this->db->where('date', $data['date']);
	// 	 $this->db->where('location', $branch_id);
	// 	 $this->db->where('status', '0');
	// 	 $result = $this->db->get('daily_forecasting_dayone')->result_array();

	// 	foreach($result as $row){
		  
	// 	  $this->db->where('id', $row['id']);
	// 	  $this->db->where('status', '0');
	// 	  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
	// 	  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
	// 	  $this->db->update('daily_forecasting_dayone');

	// 	}

	// 	return TRUE;
	// }

	// public function u_processfo1($data){
	// 	error_reporting(0);

	// 	$adjustment = $data['adjustment'];
	// 	$count = $data['count'];

	// 	foreach($adjustment as $row){

	// 		$split = explode("/", $row);
			
	// 		if($split[1]!=""){

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->select('need');
	// 			$row = $this->db->get('daily_forecasting_dayone')->row();

	// 			$need = $row->need;

	// 			$negative = "-";

	// 			$splits = str_split($split[1]);

	// 			if($splits[0]){
	// 				$result = $need + $split[1];

	// 			}else{
	// 				$result = $need - $split[1];

	// 			}

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->set('adjustment', $split[1]);
	// 			$this->db->set('final_order', $result);
	// 			$this->db->update('daily_forecasting_dayone');

	// 		}		
		
	// 	}

	// 	return TRUE;		
	// }

//----------------------------Daily Forecasting Daytwo Process-------------------------------------------

	public function _updatefa2($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('daily_forecasting_daytwo');

		return TRUE;
	}

	public function _processfa2($data){
		 $branch_id = $this->session->userdata('branch_id');	 		
		 
		 $this->db->where('date', $data['date']);
		 $this->db->where('ref_date', $data['ref_date']);
		 $this->db->where('location', $branch_id);
	 	 $result = $this->db->get('daily_forecasting_daytwo')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date', $data['ref_date']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('daily_forecasting_daytwo');

		}

		return TRUE;

	}	

	public function _processfo2($data){
		error_reporting(0);

		$adjustment = $data['adjustment'];
		$count = $data['count'];

		foreach($adjustment as $row){

			$split = explode("/", $row);
			
			if($split[1]!=""){

				$this->db->where('id', $split[0]);
				$this->db->select('need');
				$row = $this->db->get('daily_forecasting_daytwo')->row();

				$need = $row->need;

				$negative = "-";

				$splits = str_split($split[1]);

				if($splits[0]){
					$result = $need + $split[1];

				}else{
					$result = $need - $split[1];

				}

				$this->db->where('id', $split[0]);
				$this->db->set('adjustment', $split[1]);
				$this->db->set('final_order', $result);
				$this->db->update('daily_forecasting_daytwo');

			}		
		
		}

		return TRUE;		
	}

	// public function u_updatefa2($data){
	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$this->db->set('forecast_amount', $data['forecasted_amount']);
	// 	$this->db->update('daily_forecasting_daytwo');

	// 	return TRUE;
	// }

	// public function u_processfa2($data){
	// 	 $branch_id = $this->session->userdata('branch_id');	 		
		 
	// 	 $this->db->where('date', $data['date']);
	// 	 $this->db->where('location', $branch_id);
	// 	 $this->db->where('status', '0');
	//  	 $result = $this->db->get('daily_forecasting_daytwo')->result_array();

	// 	foreach($result as $row){
		  
	// 	  $this->db->where('id', $row['id']);
	// 	  $this->db->where('status', '0');
	// 	  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
	// 	  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
	// 	  $this->db->update('daily_forecasting_daytwo');

	// 	}

	// 	return TRUE;

	// }

	// public function u_processfo2($data){
	// 	error_reporting(0);

	// 	$adjustment = $data['adjustment'];
	// 	$count = $data['count'];

	// 	foreach($adjustment as $row){

	// 		$split = explode("/", $row);
			
	// 		if($split[1]!=""){

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->select('need');
	// 			$row = $this->db->get('daily_forecasting_daytwo')->row();

	// 			$need = $row->need;

	// 			$negative = "-";

	// 			$splits = str_split($split[1]);

	// 			if($splits[0]){
	// 				$result = $need + $split[1];

	// 			}else{
	// 				$result = $need - $split[1];

	// 			}

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->set('adjustment', $split[1]);
	// 			$this->db->set('final_order', $result);
	// 			$this->db->update('daily_forecasting_daytwo');

	// 		}		
		
	// 	}

	// 	return TRUE;		
	// }

//----------------------------Daily Forecasting Daythree Process-------------------------------------------

	public function _updatefa3($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('daily_forecasting_daythree');

		return TRUE;
	}

	public function _processfa3($data){
		 $branch_id = $this->session->userdata('branch_id');

		 $this->db->where('date', $data['date']);
		 $this->db->where('ref_date', $data['ref_date']);
		 $this->db->where('location', $branch_id);
		 $result = $this->db->get('daily_forecasting_daythree')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date', $data['ref_date']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('daily_forecasting_daythree');

		}

		return TRUE;
	}	

	public function _processfo3($data){
		error_reporting(0);

		$adjustment = $data['adjustment'];
		$count = $data['count'];

		foreach($adjustment as $row){

			$split = explode("/", $row);
			
			if($split[1]!=""){

				$this->db->where('id', $split[0]);
				$this->db->select('need');
				$row = $this->db->get('daily_forecasting_daythree')->row();

				$need = $row->need;

				$negative = "-";

				$splits = str_split($split[1]);

				if($splits[0]){
					$result = $need + $split[1];

				}else{
					$result = $need - $split[1];

				}

				$this->db->where('id', $split[0]);
				$this->db->set('adjustment', $split[1]);
				$this->db->set('final_order', $result);
				$this->db->update('daily_forecasting_daythree');

			}		
		
		}

		return TRUE;		
	}

	// public function u_updatefa3($data){
	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$this->db->set('forecast_amount', $data['forecasted_amount']);
	// 	$this->db->update('daily_forecasting_daythree');

	// 	return TRUE;
	// }

	// public function u_processfa3($data){
	// 	 $branch_id = $this->session->userdata('branch_id');

	// 	 $this->db->where('date', $data['date']);
	// 	 $this->db->where('location', $branch_id);
	// 	 $this->db->where('status', '0');
	// 	 $result = $this->db->get('daily_forecasting_daythree')->result_array();

	// 	foreach($result as $row){
		  
	// 	  $this->db->where('id', $row['id']);
	// 	  $this->db->where('status', '0');
	// 	  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
	// 	  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
	// 	  $this->db->update('daily_forecasting_daythree');

	// 	}

	// 	return TRUE;
	// }

	// public function u_processfo3($data){
	// 	error_reporting(0);

	// 	$adjustment = $data['adjustment'];
	// 	$count = $data['count'];

	// 	foreach($adjustment as $row){

	// 		$split = explode("/", $row);
			
	// 		if($split[1]!=""){

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->select('need');
	// 			$row = $this->db->get('daily_forecasting_daythree')->row();

	// 			$need = $row->need;

	// 			$negative = "-";

	// 			$splits = str_split($split[1]);

	// 			if($splits[0]){
	// 				$result = $need + $split[1];

	// 			}else{
	// 				$result = $need - $split[1];

	// 			}

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->set('adjustment', $split[1]);
	// 			$this->db->set('final_order', $result);
	// 			$this->db->update('daily_forecasting_daythree');

	// 		}		
		
	// 	}

	// 	return TRUE;		
	// }

//----------------------------Daily Forecasting Dayfour Process-------------------------------------------

	public function _updatefa4($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('daily_forecasting_dayfour');

		return TRUE;
	}	

	public function _processfa4($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayfour')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date', $data['ref_date']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('daily_forecasting_dayfour');

		}

		return TRUE;
	}	

	public function _processfo4($data){
		error_reporting(0);

		$adjustment = $data['adjustment'];
		$count = $data['count'];

		foreach($adjustment as $row){

			$split = explode("/", $row);
			
			if($split[1]!=""){

				$this->db->where('id', $split[0]);
				$this->db->select('need');
				$row = $this->db->get('daily_forecasting_dayfour')->row();

				$need = $row->need;

				$negative = "-";

				$splits = str_split($split[1]);

				if($splits[0]){
					$result = $need + $split[1];

				}else{
					$result = $need - $split[1];

				}

				$this->db->where('id', $split[0]);
				$this->db->set('adjustment', $split[1]);
				$this->db->set('final_order', $result);
				$this->db->update('daily_forecasting_dayfour');

			}		
		
		}

		return TRUE;		
	}

	// public function u_updatefa4($data){
	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$this->db->set('forecast_amount', $data['forecasted_amount']);
	// 	$this->db->update('daily_forecasting_dayfour');

	// 	return TRUE;
	// }	

	// public function u_processfa4($data){
	// 	$branch_id = $this->session->userdata('branch_id');

	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_dayfour')->result_array();

	// 	foreach($result as $row){
		  
	// 	  $this->db->where('id', $row['id']);
	// 	  $this->db->where('status', '0');
	// 	  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
	// 	  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
	// 	  $this->db->update('daily_forecasting_dayfour');

	// 	}

	// 	return TRUE;
	// }	

	// public function u_processfo4($data){
	// 	error_reporting(0);

	// 	$adjustment = $data['adjustment'];
	// 	$count = $data['count'];

	// 	foreach($adjustment as $row){

	// 		$split = explode("/", $row);
			
	// 		if($split[1]!=""){

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->select('need');
	// 			$row = $this->db->get('daily_forecasting_dayfour')->row();

	// 			$need = $row->need;

	// 			$negative = "-";

	// 			$splits = str_split($split[1]);

	// 			if($splits[0]){
	// 				$result = $need + $split[1];

	// 			}else{
	// 				$result = $need - $split[1];

	// 			}

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->set('adjustment', $split[1]);
	// 			$this->db->set('final_order', $result);
	// 			$this->db->update('daily_forecasting_dayfour');

	// 		}		
		
	// 	}

	// 	return TRUE;		
	// }

//----------------------------Daily Forecasting Dayfive Process-------------------------------------------

	public function _updatefa5($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('daily_forecasting_dayfive');

		return TRUE;
	}

	public function _processfa5($data){
		$branch_id = $this->session->userdata('branch_id');		
		$this->db->where('date', $data['date']);
		$this->db->where('location', $branch_id);
		$this->db->where('ref_date', $data['ref_date']);
		$result = $this->db->get('daily_forecasting_dayfive')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date', $data['ref_date']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('daily_forecasting_dayfive');

		}

		return TRUE;

	}	

	public function _processfo5($data){
		error_reporting(0);

		$adjustment = $data['adjustment'];
		$count = $data['count'];

		foreach($adjustment as $row){

			$split = explode("/", $row);
			
			if($split[1]!=""){

				$this->db->where('id', $split[0]);
				$this->db->select('need');
				$row = $this->db->get('daily_forecasting_dayfive')->row();

				$need = $row->need;

				$negative = "-";

				$splits = str_split($split[1]);

				if($splits[0]){
					$result = $need + $split[1];

				}else{
					$result = $need - $split[1];

				}

				$this->db->where('id', $split[0]);
				$this->db->set('adjustment', $split[1]);
				$this->db->set('final_order', $result);
				$this->db->update('daily_forecasting_dayfive');

			}		
		
		}

		return TRUE;		
	}

	// public function u_updatefa5($data){
	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$this->db->set('forecast_amount', $data['forecasted_amount']);
	// 	$this->db->update('daily_forecasting_dayfive');

	// 	return TRUE;
	// }

	// public function u_processfa5($data){
	// 	$branch_id = $this->session->userdata('branch_id');		
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_dayfive')->result_array();

	// 	foreach($result as $row){
		  
	// 	  $this->db->where('id', $row['id']);
	// 	  $this->db->where('status', '0');
	// 	  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
	// 	  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
	// 	  $this->db->update('daily_forecasting_dayfive');

	// 	}

	// 	return TRUE;

	// }	

	// public function u_processfo5($data){
	// 	error_reporting(0);

	// 	$adjustment = $data['adjustment'];
	// 	$count = $data['count'];

	// 	foreach($adjustment as $row){

	// 		$split = explode("/", $row);
			
	// 		if($split[1]!=""){

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->select('need');
	// 			$row = $this->db->get('daily_forecasting_dayfive')->row();

	// 			$need = $row->need;

	// 			$negative = "-";

	// 			$splits = str_split($split[1]);

	// 			if($splits[0]){
	// 				$result = $need + $split[1];

	// 			}else{
	// 				$result = $need - $split[1];

	// 			}

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->set('adjustment', $split[1]);
	// 			$this->db->set('final_order', $result);
	// 			$this->db->update('daily_forecasting_dayfive');

	// 		}		
		
	// 	}

	// 	return TRUE;		
	// }

//----------------------------Daily Forecasting Daysix Process-------------------------------------------

	public function _updatefa6($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('daily_forecasting_daysix');

		return TRUE;
	}	

	public function _processfa6($data){
		$branch_id = $this->session->userdata('branch_id');	
		
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_daysix')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date', $data['ref_date']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('daily_forecasting_daysix');

		}
		return TRUE;
	}	

	public function _processfo6($data){
		error_reporting(0);

		$adjustment = $data['adjustment'];
		$count = $data['count'];

		foreach($adjustment as $row){

			$split = explode("/", $row);
			
			if($split[1]!=""){

				$this->db->where('id', $split[0]);
				$this->db->select('need');
				$row = $this->db->get('daily_forecasting_daysix')->row();

				$need = $row->need;

				$negative = "-";

				$splits = str_split($split[1]);

				if($splits[0]){
					$result = $need + $split[1];

				}else{
					$result = $need - $split[1];

				}

				$this->db->where('id', $split[0]);
				$this->db->set('adjustment', $split[1]);
				$this->db->set('final_order', $result);
				$this->db->update('daily_forecasting_daysix');

			}		
		
		}

		return TRUE;		
	}

	// public function u_updatefa6($data){
	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$this->db->set('forecast_amount', $data['forecasted_amount']);
	// 	$this->db->update('daily_forecasting_daysix');

	// 	return TRUE;
	// }	

	// public function u_processfa6($data){
	// 	$branch_id = $this->session->userdata('branch_id');	
		
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_daysix')->result_array();

	// 	foreach($result as $row){
		  
	// 	  $this->db->where('id', $row['id']);
	// 	  $this->db->where('status', '0');
	// 	  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
	// 	  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
	// 	  $this->db->update('daily_forecasting_daysix');

	// 	}
	// 	return TRUE;
	// }	

	// public function u_processfo6($data){
	// 	error_reporting(0);

	// 	$adjustment = $data['adjustment'];
	// 	$count = $data['count'];

	// 	foreach($adjustment as $row){

	// 		$split = explode("/", $row);
			
	// 		if($split[1]!=""){

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->select('need');
	// 			$row = $this->db->get('daily_forecasting_daysix')->row();

	// 			$need = $row->need;

	// 			$negative = "-";

	// 			$splits = str_split($split[1]);

	// 			if($splits[0]){
	// 				$result = $need + $split[1];

	// 			}else{
	// 				$result = $need - $split[1];

	// 			}

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->set('adjustment', $split[1]);
	// 			$this->db->set('final_order', $result);
	// 			$this->db->update('daily_forecasting_daysix');

	// 		}		
		
	// 	}

	// 	return TRUE;		
	// }

//----------------------------Daily Forecasting Dayseven Process-------------------------------------------

	public function _updatefa7($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('daily_forecasting_dayseven');

		return TRUE;
	}
	
	public function _processfa7($data){
		$branch_id = $this->session->userdata('branch_id');	

		$this->db->where('date', $data['date']);
		$this->db->where('ref_date', $data['ref_date']);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayseven')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date', $data['ref_date']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('daily_forecasting_dayseven');

		}
		return TRUE;
	}	

	public function _processfo7($data){
		error_reporting(0);

		$adjustment = $data['adjustment'];
		$count = $data['count'];

		foreach($adjustment as $row){

			$split = explode("/", $row);
			
			if($split[1]!=""){

				$this->db->where('id', $split[0]);
				$this->db->select('need');
				$row = $this->db->get('daily_forecasting_dayseven')->row();

				$need = $row->need;

				$negative = "-";

				$splits = str_split($split[1]);

				if($splits[0]){
					$result = $need + $split[1];

				}else{
					$result = $need - $split[1];

				}
			
				$this->db->where('id', $split[0]);
				$this->db->set('adjustment', $split[1]);
				$this->db->set('final_order', $result);
				$this->db->update('daily_forecasting_dayseven');

			}		
		
		}

		return TRUE;		
	}

	// public function u_updatefa7($data){
	// 	$branch_id = $this->session->userdata('branch_id');
	
	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$this->db->set('forecast_amount', $data['forecasted_amount']);
	// 	$this->db->update('daily_forecasting_dayseven');

	// 	return TRUE;
	// }
	
	// public function u_processfa7($data){
	// 	$branch_id = $this->session->userdata('branch_id');	

	// 	$this->db->where('date', $data['date']);
	// 	$this->db->where('location', $branch_id);
	// 	$this->db->where('status', '0');
	// 	$result = $this->db->get('daily_forecasting_dayseven')->result_array();

	// 	foreach($result as $row){
		  
	// 	  $this->db->where('id', $row['id']);
	// 	  $this->db->where('status', '0');
	// 	  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
	// 	  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
	// 	  $this->db->update('daily_forecasting_dayseven');

	// 	}
	// 	return TRUE;
	// }	

	// public function u_processfo7($data){
	// 	error_reporting(0);

	// 	$adjustment = $data['adjustment'];
	// 	$count = $data['count'];

	// 	foreach($adjustment as $row){

	// 		$split = explode("/", $row);
			
	// 		if($split[1]!=""){

	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->select('need');
	// 			$row = $this->db->get('daily_forecasting_dayseven')->row();

	// 			$need = $row->need;

	// 			$negative = "-";

	// 			$splits = str_split($split[1]);

	// 			if($splits[0]){
	// 				$result = $need + $split[1];

	// 			}else{
	// 				$result = $need - $split[1];

	// 			}
			
	// 			$this->db->where('id', $split[0]);
	// 			$this->db->where('status', '0');
	// 			$this->db->set('adjustment', $split[1]);
	// 			$this->db->set('final_order', $result);
	// 			$this->db->update('daily_forecasting_dayseven');

	// 		}		
		
	// 	}

	// 	return TRUE;		
	// }

//---------------------------------save and generate

	public function selectitems($data){

		$branch_id = $this->session->userdata('branch_id');
		$branch = $this->session->userdata('branch');
 
		$query = sprintf("SELECT a.barcode, a.[desc], a.sapcode as material, b.sapcode as plant FROM items a LEFT JOIN location b ON location = '$branch_id'");
		$result = $this->db->query($query)->result_array();
		
		if($this->existinsap($data)){
			return 0;

		}else{
			foreach($result as $row){
				$this->db->set('material', $row['material']);
				$this->db->set('barcode', $row['barcode']);
				$this->db->set('fg', $row['desc']);
				$this->db->set('branch', $branch_id);
				$this->db->set('plant', $row['plant']);
				$this->db->set('version', '00');
				$this->db->set('BU', 'PC');
				$this->db->set('status', '0');
				$this->db->set('a_upd', '0');
				$this->db->set('versions', '0');
				$this->db->set('dateone', $data['tues_date']);
				$this->db->set('datetwo', $data['wed_date']);
				$this->db->set('datethree', $data['thurs_date']);
				$this->db->set('datefour', $data['fri_date']);
				$this->db->set('datefive', $data['sat_date']);
				$this->db->set('datesix', $data['sun_date']);
				$this->db->set('dateseven', $data['mon_date']);
				$this->db->insert('sap_need_forecast');
			}
			return TRUE;
		}
	}

	public function existinsap($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('branch', $branch_id);
		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$row = $this->db->get('sap_need_forecast')->row_array();

		if(count($row) > 1){
			return TRUE;

		}else{
			return 0;

		}

	}

	public function sel_upd($data,$startdate){
		$branch_id = $this->session->userdata('branch_id');

		for($x=1;$x<=7;$x++){
			if($x == "1"){
				$date = $data['tues_date'];
				$table = 'daily_forecasting_dayone';
			
			}elseif($x == "2"){
				$date = $data['wed_date'];
				$table = 'daily_forecasting_daytwo';

			}elseif($x == "3"){
				$date = $data['thurs_date'];
				$table = 'daily_forecasting_daythree';

			}elseif($x == "4"){
				$date = $data['fri_date'];
				$table = 'daily_forecasting_dayfour';

			}elseif($x == "5"){
				$date = $data['sat_date'];
				$table = 'daily_forecasting_dayfive';

			}elseif($x == "6"){
				$date = $data['sun_date'];
				$table = 'daily_forecasting_daysix';

			}elseif($x == "7"){
				$date = $data['mon_date'];
				$table = 'daily_forecasting_dayseven';

			}

			$this->db->where('location', $branch_id);
			$this->db->where('date', $date);
			$this->db->select('barcode,fg,forecast_amount,build_amount,need,adjustment,final_order,date');
			$result = $this->db->get($table)->result_array();	

			foreach($result as $row){
				$this->db->where('barcode', $row['barcode']);
				$this->db->where('fg', $row['fg']);
			
				if($x == "1"){

					$this->db->where('dateone', $data['tues_date']);
					$this->db->set('ba1', $row['build_amount']);
					$this->db->set('need1', $row['need']);
					$this->db->set('adj1', $row['adjustment']);
					$this->db->set('fa1', $row['forecast_amount']);
					$this->db->set('dayone', $row['final_order']);
				
				}elseif($x == "2"){

					$this->db->where('datetwo', $data['wed_date']);
					$this->db->set('ba2', $row['build_amount']);
					$this->db->set('need2', $row['need']);
					$this->db->set('adj2', $row['adjustment']);
					$this->db->set('fa2', $row['forecast_amount']);
					$this->db->set('daytwo', $row['final_order']);

				}elseif($x == "3"){

					$this->db->where('datethree', $data['thurs_date']);
					$this->db->set('ba3', $row['build_amount']);
					$this->db->set('need3', $row['need']);
					$this->db->set('adj3', $row['adjustment']);
					$this->db->set('fa3', $row['forecast_amount']);
					$this->db->set('daythree', $row['final_order']);

				}elseif($x == "4"){

					$this->db->where('datefour', $data['fri_date']);
					$this->db->set('ba4', $row['build_amount']);
					$this->db->set('need4', $row['need']);
					$this->db->set('adj4', $row['adjustment']);
					$this->db->set('fa4', $row['forecast_amount']);
					$this->db->set('dayfour', $row['final_order']);

				}elseif($x == "5"){

					$this->db->where('datefive', $data['sat_date']);
					$this->db->set('ba5', $row['build_amount']);
					$this->db->set('need5', $row['need']);
					$this->db->set('adj5', $row['adjustment']);
					$this->db->set('fa5', $row['forecast_amount']);
					$this->db->set('dayfive', $row['final_order']);

				}elseif($x == "6"){

					$this->db->where('datesix', $data['sun_date']);
					$this->db->set('ba6', $row['build_amount']);
					$this->db->set('need6', $row['need']);
					$this->db->set('adj6', $row['adjustment']);
					$this->db->set('fa6', $row['forecast_amount']);
					$this->db->set('daysix', $row['final_order']);

				}elseif($x == "7"){

					$this->db->where('dateseven', $data['mon_date']);
					$this->db->set('ba7', $row['build_amount']);
					$this->db->set('need7', $row['need']);
					$this->db->set('adj7', $row['adjustment']);
					$this->db->set('fa7', $row['forecast_amount']);
					$this->db->set('dayseven', $row['final_order']);

				}


				$this->db->update('sap_need_forecast');
			
			}

		}

		for($y=1;$y<=7;$y++){
			if($y == "1"){
				$date = $data['tues_date'];
				$ref_date = $data['ref_tues_date'];
				$table = 'daily_forecasting_dayone';
			
			}elseif($y == "2"){
				$date = $data['wed_date'];
				$ref_date = $data['ref_wed_date'];
				$table = 'daily_forecasting_daytwo';

			}elseif($y == "3"){
				$date = $data['thurs_date'];
				$ref_date = $data['ref_thurs_date'];
				$table = 'daily_forecasting_daythree';

			}elseif($y == "4"){
				$date = $data['fri_date'];
				$ref_date = $data['ref_fri_date'];
				$table = 'daily_forecasting_dayfour';

			}elseif($y == "5"){
				$date = $data['sat_date'];
				$ref_date = $data['ref_sat_date'];
				$table = 'daily_forecasting_dayfive';

			}elseif($y == "6"){
				$date = $data['sun_date'];
				$ref_date = $data['ref_sun_date'];
				$table = 'daily_forecasting_daysix';

			}elseif($y == "7"){
				$date = $data['mon_date'];
				$ref_date = $data['ref_mon_date'];
				$table = 'daily_forecasting_dayseven';

			}

			$this->db->where('date', $date);
			$this->db->where('location', $branch_id);
			$this->db->set('status', '1');
			$this->db->update($table);

			$this->db->where('date', $date);
			$this->db->where('ref_date', $ref_date);
			$this->db->where('location', $branch_id);
			$this->db->set('ref_date_status', '1');
			$this->db->update($table);

		}

		$dateends = date("Y-m-d", strtotime($startdate . " +6 day"));

		$this->db->where('datestart',$startdate);
		$this->db->where('dateend',$dateends); 	
		$this->db->where('branch',$branch_id);
		$this->db->set('status', '1');
		$this->db->update('pending_forecast');

		return TRUE;
			
	}

	

	public function print_forecasting($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->where('status', '0');
		return $this->db->get('sap_need_forecast')->result_array();
	}	

	public function updatesap($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('versions');
		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->select('versions');
		$result = $this->db->get('sap_need_forecast')->row();

		$result = $result->versions;

		if($result == ""){
			$result = "0";
		}

		$result = $result + 1;

		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->set('status', '1');
		$this->db->set('versions', $result);
		$this->db->update('sap_need_forecast');

	}


//--------------update-----------------------//

	public function update_a_upd($data){

		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('versions', $data['u_version']);
		$this->db->where('branch', $branch_id);
		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->set('a_upd', '1');
		$this->db->update('sap_need_forecast');

		return TRUE;

	}

	public function selectitems_forupdate($data){

		$branch_id = $this->session->userdata('branch_id');
		$branch = $this->session->userdata('branch');
		
		$query = sprintf("SELECT a.barcode, a.[desc], a.sapcode as material, b.sapcode as plant FROM items a LEFT JOIN location b ON location = '$branch_id'");
		$result = $this->db->query($query)->result_array();
		
		if($this->existinsap_forupdate($data)){
			return 0;

		}else{
			foreach($result as $row){
				$this->db->set('material', $row['material']);
				$this->db->set('barcode', $row['barcode']);
				$this->db->set('fg', $row['desc']);
				$this->db->set('branch', $branch_id);
				$this->db->set('plant', $row['plant']);
				$this->db->set('version', '00');
				$this->db->set('BU', 'PC');
				$this->db->set('status', '0');
				$this->db->set('a_upd', '0');
				$this->db->set('dateone', $data['tues_date']);
				$this->db->set('datetwo', $data['wed_date']);
				$this->db->set('datethree', $data['thurs_date']);
				$this->db->set('datefour', $data['fri_date']);
				$this->db->set('datefive', $data['sat_date']);
				$this->db->set('datesix', $data['sun_date']);
				$this->db->set('dateseven', $data['mon_date']);
				$this->db->set('versions', $data['version']);
				$this->db->insert('sap_need_forecast');
			}
			return TRUE;
		}
	}

	public function existinsap_forupdate($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('versions', $data['version']);
		$this->db->where('branch', $branch_id);
		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$row = $this->db->get('sap_need_forecast')->row_array();

		if(count($row) > 1){
			return TRUE;

		}else{
			return 0;

		}

	}

	public function sel_upd_forupdate($data,$startdate){
		$branch_id = $this->session->userdata('branch_id');

		for($x=1;$x<=7;$x++){
			if($x == "1"){
				$date = $data['tues_date'];
				$table = 'daily_forecasting_dayone';
			
			}elseif($x == "2"){
				$date = $data['wed_date'];
				$table = 'daily_forecasting_daytwo';

			}elseif($x == "3"){
				$date = $data['thurs_date'];
				$table = 'daily_forecasting_daythree';

			}elseif($x == "4"){
				$date = $data['fri_date'];
				$table = 'daily_forecasting_dayfour';

			}elseif($x == "5"){
				$date = $data['sat_date'];
				$table = 'daily_forecasting_dayfive';

			}elseif($x == "6"){
				$date = $data['sun_date'];
				$table = 'daily_forecasting_daysix';

			}elseif($x == "7"){
				$date = $data['mon_date'];
				$table = 'daily_forecasting_dayseven';

			}

			$this->db->where('location', $branch_id);
			$this->db->where('date', $date);
			$this->db->select('barcode,fg,build_amount,need,adjustment,final_order,date');
			$result = $this->db->get($table)->result_array();	

			foreach($result as $row){
				$this->db->where('barcode', $row['barcode']);
				$this->db->where('fg', $row['fg']);
				$this->db->where('versions', $data['version']);

				if($x == "1"){

					$this->db->where('dateone', $data['tues_date']);
					$this->db->set('ba1', $row['build_amount']);
					$this->db->set('need1', $row['need']);
					$this->db->set('adj1', $row['adjustment']);
					$this->db->set('dayone', $row['final_order']);
				
				}elseif($x == "2"){

					$this->db->where('datetwo', $data['wed_date']);
					$this->db->set('ba2', $row['build_amount']);
					$this->db->set('need2', $row['need']);
					$this->db->set('adj2', $row['adjustment']);
					$this->db->set('daytwo', $row['final_order']);

				}elseif($x == "3"){

					$this->db->where('datethree', $data['thurs_date']);
					$this->db->set('ba3', $row['build_amount']);
					$this->db->set('need3', $row['need']);
					$this->db->set('adj3', $row['adjustment']);
					$this->db->set('daythree', $row['final_order']);

				}elseif($x == "4"){

					$this->db->where('datefour', $data['fri_date']);
					$this->db->set('ba4', $row['build_amount']);
					$this->db->set('need4', $row['need']);
					$this->db->set('adj4', $row['adjustment']);
					$this->db->set('dayfour', $row['final_order']);

				}elseif($x == "5"){

					$this->db->where('datefive', $data['sat_date']);
					$this->db->set('ba5', $row['build_amount']);
					$this->db->set('need5', $row['need']);
					$this->db->set('adj5', $row['adjustment']);
					$this->db->set('dayfive', $row['final_order']);

				}elseif($x == "6"){

					$this->db->where('datesix', $data['sun_date']);
					$this->db->set('ba6', $row['build_amount']);
					$this->db->set('need6', $row['need']);
					$this->db->set('adj6', $row['adjustment']);
					$this->db->set('daysix', $row['final_order']);

				}elseif($x == "7"){

					$this->db->where('dateseven', $data['mon_date']);
					$this->db->set('ba7', $row['build_amount']);
					$this->db->set('need7', $row['need']);
					$this->db->set('adj7', $row['adjustment']);
					$this->db->set('dayseven', $row['final_order']);

				}


				$this->db->update('sap_need_forecast');
			
			}

		}

		for($y=1;$y<=7;$y++){
			if($y == "1"){
				$date = $data['tues_date'];
				$table = 'daily_forecasting_dayone';
			
			}elseif($y == "2"){
				$date = $data['wed_date'];
				$table = 'daily_forecasting_daytwo';

			}elseif($y == "3"){
				$date = $data['thurs_date'];
				$table = 'daily_forecasting_daythree';

			}elseif($y == "4"){
				$date = $data['fri_date'];
				$table = 'daily_forecasting_dayfour';

			}elseif($y == "5"){
				$date = $data['sat_date'];
				$table = 'daily_forecasting_dayfive';

			}elseif($y == "6"){
				$date = $data['sun_date'];
				$table = 'daily_forecasting_daysix';

			}elseif($y == "7"){
				$date = $data['mon_date'];
				$table = 'daily_forecasting_dayseven';

			}

			$this->db->where('date', $date);
			$this->db->where('location', $branch_id);
			$this->db->set('status', '1');
			$this->db->update($table);
		}

		$dateends = date("Y-m-d", strtotime($startdate . " +6 day"));

		$this->db->where('datestart',$startdate);
		$this->db->where('dateend',$dateends); 	
		$this->db->where('branch',$branch_id);
		$this->db->set('status', '1');
		$this->db->update('pending_forecast');

		return TRUE;
			
	}

	public function print_forecasting_update($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->where('status', '0');
		return $this->db->get('sap_need_forecast')->result_array();
	}	

	public function updatesap_forecast($data){
		$branch_id = $this->session->userdata('branch_id');

		// $this->db->group_by('versions');
		// $this->db->where('versions', $data['version']);
		// $this->db->where('dateone', $data['tues_date']);
		// $this->db->where('dateseven', $data['mon_date']);
		// $this->db->where('branch', $branch_id);
		// $this->db->select('versions');
		// $result = $this->db->get('sap_need_forecast')->row();

		// $result = $result->versions;

		// if($result == ""){
		// 	$result = "0";
		// }

		// $result = $result + 1;

		$this->db->where('dateone', $data['tues_date']);
		$this->db->where('dateseven', $data['mon_date']);
		$this->db->where('branch', $branch_id);
		$this->db->set('status', '1');
		$this->db->update('sap_need_forecast');

	}




}