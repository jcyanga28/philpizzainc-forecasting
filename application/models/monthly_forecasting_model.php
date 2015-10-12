<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monthly_forecasting_model extends ME_Model{	
	
//---------------------sap------------------------------------------------------------------------
	public function sap_forecast($month_from,$month_end){
		$branch_id = $this->session->userdata('branch_id');

		$date = date('Y-m-d');

		$query = sprintf("SELECT fdate_from, fdate_to, tdate_from, tdate_to, remarks, versions FROM sap_need_monthly_forecast WHERE fdate_from BETWEEN '$month_from' AND '$month_end' AND branch = '$branch_id' GROUP BY fdate_from, fdate_to, tdate_from, tdate_to, remarks, versions Order by fdate_from desc");

		return $this->db->query($query)->result_array();
	}

//---------------------sap------------------------------------------------------------------------
	public function all_sap_forecast($limit=null,$offset=null){

		$branch_id = $this->session->userdata('branch_id');

		$date = date('Y-m-d');

		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->order_by('fdate_from', 'desc');
		$this->db->group_by('fdate_from');
		$this->db->group_by('fdate_to');
		$this->db->group_by('tdate_from');
		$this->db->group_by('tdate_to');
		$this->db->group_by('remarks');
		$this->db->group_by('versions');	
		$this->db->where('branch', $branch_id);
		$this->db->select('fdate_from, fdate_to, tdate_from, tdate_to, remarks, versions');
		return $this->db->get('sap_need_monthly_forecast')->result_array();

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
		$this->db->where('branch', $branch_id);
		$this->db->select('fdate_from, fdate_to, tdate_from, tdate_to, remarks, versions');
		return $this->db->get('sap_need_monthly_forecast')->result_array();

	}

//--------------------remarks----------------------------------------------------------------------
	public function update_remarks(){
		$branch_id = $this->session->userdata('branch_id');

		$remarks = $this->input->post('remarks');
		
		$fdate_from = $this->input->post('fdate_from');
		$tdate_from = $this->input->post('tdate_from');
		$version = $this->input->post('version');
		
		$this->db->where('branch', $branch_id);
		$this->db->where('fdate_from', $fdate_from);
		$this->db->where('tdate_from', $tdate_from);
		$this->db->where('versions', $version);
		$this->db->set('remarks', $remarks);
		$this->db->update('sap_need_monthly_forecast');

		return TRUE;
	}

//--------------------viewing---------------------------------------------------------------------
	
	public function _getgross_vsf1($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['fmonth_from'];
		$month_end = $data['fmonth_end'];

		$this->db->group_by('ffa');
		$this->db->where('fdate_from', $month_start);
		$this->db->where('fdate_to', $month_end);
		$this->db->where('branch', $branch_id);
		$this->db->select('ffa');
		$row = $this->db->get('sap_need_monthly_forecast')->row();

		return $row->ffa;
		
	}

	public function _getgross_vsf2($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['smonth_from'];
		$month_end = $data['smonth_end'];

		$this->db->group_by('sfa');
		$this->db->where('sdate_from', $month_start);
		$this->db->where('sdate_to', $month_end);
		$this->db->where('branch', $branch_id);
		$this->db->select('sfa');
		$row = $this->db->get('sap_need_monthly_forecast')->row();

		return $row->sfa;
		
	}

	public function _getgross_vsf3($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['tmonth_from'];
		$month_end = $data['tmonth_end'];

		$this->db->group_by('tfa');
		$this->db->where('tdate_from', $month_start);
		$this->db->where('tdate_to', $month_end);
		$this->db->where('branch', $branch_id);
		$this->db->select('tfa');
		$row = $this->db->get('sap_need_monthly_forecast')->row();

		return $row->tfa;
		
	}

	public function select_update($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('a_upd');
		$this->db->where('versions', $data['version']);
		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('branch', $branch_id);
		$this->db->select('a_upd');
		return $this->db->get('sap_need_monthly_forecast')->row();

	}

	public function viewing($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('versions', $data['version']);
		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('branch', $branch_id);
		$this->db->select('fg,fadj,ffo,sadj,sfo,tadj,tfo');
		return $this->db->get('sap_need_monthly_forecast')->result_array();

	}

	//------------------select reference for update----------------------------------------------------
	public function _getref1($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date_from');
		$this->db->where('date_from', $data['fmonth_from']);
		$this->db->where('date_to', $data['fmonth_end']);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date_from');
		$row = $this->db->get('first_month_forecast')->row_array();

		if(count($row) > 0){
			return $row['ref_date_from'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref2($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date_to');
		$this->db->where('date_from', $data['fmonth_from']);
		$this->db->where('date_to', $data['fmonth_end']);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date_to');
		$row = $this->db->get('first_month_forecast')->row_array();

		if(count($row) > 0){
			return $row['ref_date_to'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref3($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date_from');
		$this->db->where('date_from', $data['smonth_from']);
		$this->db->where('date_to', $data['smonth_end']);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date_from');
		$row = $this->db->get('second_month_forecast')->row_array();

		if(count($row) > 0){
			return $row['ref_date_from'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref4($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date_to');
		$this->db->where('date_from', $data['smonth_from']);
		$this->db->where('date_to', $data['smonth_end']);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date_to');
		$row = $this->db->get('second_month_forecast')->row_array();

		if(count($row) > 0){
			return $row['ref_date_to'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref5($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date_from');
		$this->db->where('date_from', $data['tmonth_from']);
		$this->db->where('date_to', $data['tmonth_end']);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date_from');
		$row = $this->db->get('third_month_forecast')->row_array();

		if(count($row) > 0){
			return $row['ref_date_from'];
		
		}else{
			return 0;

		}
		
	}

	public function _getref6($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('ref_date_to');
		$this->db->where('date_from', $data['tmonth_from']);
		$this->db->where('date_to', $data['tmonth_end']);
		$this->db->where('ref_date_status', '1');
		$this->db->where('location', $branch_id);
		$this->db->select('ref_date_to');
		$row = $this->db->get('third_month_forecast')->row_array();

		if(count($row) > 0){
			return $row['ref_date_to'];
		
		}else{
			return 0;

		}
		
	}


	public function _getgross1($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['fmonth_from'];
		$month_end = $data['fmonth_end'];

		$ref_month_start = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->group_by('total_gross');
		$this->db->where('date_from', $month_start);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_start);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('first_month_forecast')->row();

		return $row->total_gross;
		
	}

	public function _getgross2($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['smonth_from'];
		$month_end = $data['smonth_end'];

		$ref_month_start = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->group_by('total_gross');
		$this->db->where('date_from', $month_start);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_start);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('second_month_forecast')->row();

		return $row->total_gross;
		
	}

	public function _getgross3($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['tmonth_from'];
		$month_end = $data['tmonth_end'];

		$ref_month_start = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->group_by('total_gross');
		$this->db->where('date_from', $month_start);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_start);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);
		$this->db->select('total_gross');
		$row = $this->db->get('third_month_forecast')->row();

		return $row->total_gross;
		
	}

// //--------------------viewing---------------------------------------------------------------------
// 	public function updating($data){
// 		$branch_id = $this->session->userdata('branch_id');

// 		$this->db->where('dateone', $data['tues_date']);
// 		$this->db->where('dateseven', $data['mon_date']);
// 		$this->db->where('branch', $branch_id);
// 		$this->db->select('fg,adj1,dayone,adj2,daytwo,adj3,daythree,adj4,dayfour,adj5,dayfive,adj6,daysix,adj7,dayseven');
// 		return $this->db->get('sap_need_forecast')->result_array();
		
// 	}

//-----------------------select pending------------------------------------------------------------
	public function selpending(){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('status', '0');
		$this->db->where('branch', $branch_id);
		return $this->db->get('monthly_pending_forecast')->result_array();
	}

	public function savepending($monthstart,$monthend,$ref_monthstart,$ref_monthend,$type){
		$branch_id = $this->session->userdata('branch_id');
		$date = date('Y-m-d');

		if($this->_dataforecastExist($monthstart,$monthend,$ref_monthstart,$ref_monthend)){
			$this->db->where('branch', $branch_id);
			$this->db->where('status', '0');
			$this->db->where('monthstart', $monthstart);
			$this->db->where('monthend', $monthend);
			$this->db->where('ref_monthstart', $ref_monthstart);
			$this->db->where('ref_monthend', $ref_monthend);
			$this->db->delete('monthly_pending_forecast');

			return TRUE;

		}else{

			$this->db->set('monthstart', $monthstart);
			$this->db->set('monthend', $monthend);
			$this->db->set('branch', $branch_id);
			$this->db->set('ref_monthstart', $ref_monthstart);
			$this->db->set('ref_month_end', $ref_monthend);
			$this->db->set('type', $type);
			$this->db->set('status', '0');
			$this->db->set('[update]', $date);
			$this->db->insert('monthly_pending_forecast');

			return $this->db->insert_id();

		}

	}

	public function _dataforecastExist($monthstart,$monthend,$ref_monthstart,$ref_monthend){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('branch', $branch_id);
		$this->db->where('status', '0');
		$this->db->where('monthstart', $monthstart);
		$this->db->where('monthend', $monthend);
		$this->db->where('ref_monthstart', $ref_monthstart);
		$row = $this->db->get('monthly_pending_forecast')->row_array();

		if(count($row)>0){
			return TRUE;
		
		}else{
			return FALSE;

		}

	}


//---------------------Summary Forecast---------------------------------------------------------------

	public function _getgross_sf1($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['ffmonth_from'];
		$month_end = $data['ffmonth_end'];

		$ref_month_start = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->group_by('forecast_amount');
		$this->db->where('date_from', $month_start);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_start);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('first_month_forecast')->row();

		return $row->forecast_amount;
		
	}

	public function _getgross_sf2($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$ref_month_start = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->group_by('forecast_amount');
		$this->db->where('date_from', $month_start);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_start);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('second_month_forecast')->row();

		return $row->forecast_amount;
		
	}

	public function _getgross_sf3($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_start = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_start = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->group_by('forecast_amount');
		$this->db->where('date_from', $month_start);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_start);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);
		$this->db->select('forecast_amount');
		$row = $this->db->get('third_month_forecast')->row();

		return $row->forecast_amount;
		
	}

	public function _selectsf($data,$search){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->select('items.[desc], first_month_forecast.final_order as firstmonth, second_month_forecast.final_order as secondmonth, third_month_forecast.final_order as thirdmonth');
		$this->db->join('first_month_forecast','first_month_forecast.barcode = items.barcode','left');
		$this->db->join('second_month_forecast','second_month_forecast.barcode = items.barcode','left');
		$this->db->join('third_month_forecast','third_month_forecast.barcode = items.barcode','left');
		$this->db->where('first_month_forecast.date_from', $data['ffmonth_from']);
		$this->db->where('first_month_forecast.date_to', $data['ffmonth_end']);
		$this->db->where('first_month_forecast.ref_date_from', $data['ref_month_from']);
		$this->db->where('first_month_forecast.ref_date_to', $data['ref_month_end']);
		$this->db->where('first_month_forecast.location', $branch_id);
		$this->db->where('second_month_forecast.date_from', $data['ssmonth_from']);
		$this->db->where('second_month_forecast.date_to', $data['ssmonth_end']);
		$this->db->where('second_month_forecast.ref_date_from', $data['ref_month_from']);
		$this->db->where('second_month_forecast.ref_date_to', $data['ref_month_end']);
		$this->db->where('second_month_forecast.location', $branch_id);
		$this->db->where('third_month_forecast.date_from', $data['ttmonth_from']);
		$this->db->where('third_month_forecast.date_to', $data['ttmonth_end']);
		$this->db->where('third_month_forecast.ref_date_from', $data['ref_month_from']);
		$this->db->where('third_month_forecast.ref_date_to', $data['ref_month_end']);
		$this->db->where('third_month_forecast.location', $branch_id);
		$this->db->order_by('items.[desc]', 'asc');
		$this->db->like('items.[desc]',$search);
		// $this->db->order_by('items.[desc]','asc');
		return $this->db->get('items')->result_array();
		
	}

	public function _selectsf_u($data,$search){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->select('items.[desc], first_month_forecast.final_order as firstmonth, second_month_forecast.final_order as secondmonth, third_month_forecast.final_order as thirdmonth');
		$this->db->join('first_month_forecast','first_month_forecast.barcode = items.barcode','left');
		$this->db->join('second_month_forecast','second_month_forecast.barcode = items.barcode','left');
		$this->db->join('third_month_forecast','third_month_forecast.barcode = items.barcode','left');
		$this->db->where('first_month_forecast.date_from', $data['ffmonth_from']);
		$this->db->where('first_month_forecast.date_to', $data['ffmonth_end']);
		$this->db->where('first_month_forecast.ref_date_from', $data['ref_month_from']);
		$this->db->where('first_month_forecast.ref_date_to', $data['ref_month_end']);
		$this->db->where('first_month_forecast.location', $branch_id);
		$this->db->where('second_month_forecast.date_from', $data['ssmonth_from']);
		$this->db->where('second_month_forecast.date_to', $data['ssmonth_end']);
		$this->db->where('second_month_forecast.ref_date_from', $data['ref_month_from']);
		$this->db->where('second_month_forecast.ref_date_to', $data['ref_month_end']);
		$this->db->where('second_month_forecast.location', $branch_id);
		$this->db->where('third_month_forecast.date_from', $data['ttmonth_from']);
		$this->db->where('third_month_forecast.date_to', $data['ttmonth_end']);
		$this->db->where('third_month_forecast.ref_date_from', $data['ref_month_from']);
		$this->db->where('third_month_forecast.ref_date_to', $data['ref_month_end']);
		$this->db->where('third_month_forecast.location', $branch_id);
		$this->db->order_by('items.[desc]', 'asc');
		$this->db->like('items.[desc]',$search);
		// $this->db->order_by('items.[desc]','asc');
		return $this->db->get('items')->result_array();
		
	}


//---------------------Product Mixed---------------------------------------------------------------

	public function _selectpm($data,$search){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->select('items.[desc], m_pm1.fgsold');
		$this->db->join('m_pm1','m_pm1.barcode = items.barcode','left');
		$this->db->where('m_pm1.date_from', $data['ffmonth_from']);
		$this->db->where('m_pm1.date_to', $data['ttmonth_end']);
		$this->db->where('m_pm1.ref_date_from', $data['ref_month_from']);
		$this->db->where('m_pm1.ref_date_to', $data['ref_month_end']);
		$this->db->where('m_pm1.location', $branch_id);
		$this->db->order_by('items.[desc]', 'asc');
		$this->db->like('items.[desc]',$search);
		// $this->db->order_by('items.[desc]','asc');
		return $this->db->get('items')->result_array();
		
	}

	public function _selectpm_forprint($data,$search){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->select('items.[desc], items.sapcode, m_pm1.fgsold');
		$this->db->join('m_pm1','m_pm1.barcode = items.barcode','left');
		$this->db->where('m_pm1.date_from', $data['ffmonth_from']);
		$this->db->where('m_pm1.date_to', $data['ttmonth_end']);
		$this->db->where('m_pm1.ref_date_from', $data['ref_month_from']);
		$this->db->where('m_pm1.ref_date_to', $data['ref_month_end']);
		$this->db->where('m_pm1.location', $branch_id);
		$this->db->order_by('items.[desc]', 'asc');
		// $this->db->order_by('items.[desc]','asc');
		return $this->db->get('items')->result_array();
		
	}

////---------------------check if data exist---------------------------------------------------------

	public function fmonth_exist($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_from = $data['f_exist_from'];
		$month_end = $data['f_exist_end'];

		$this->db->where('status', '1');
		$this->db->where('location', $branch_id);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$row = $this->db->get('first_month_forecast')->row_array();

		if(count($row) > 0){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function smonth_exist($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_from = $data['s_exist_from'];
		$month_end = $data['s_exist_end'];

		$this->db->where('status', '1');
		$this->db->where('location', $branch_id);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$row = $this->db->get('second_month_forecast')->row_array();

		if(count($row) > 0){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function tmonth_exist($data){
		$branch_id = $this->session->userdata('branch_id');

		$month_from = $data['t_exist_from'];
		$month_end = $data['t_exist_end'];

		$this->db->where('status', '1');
		$this->db->where('location', $branch_id);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$row = $this->db->get('third_month_forecast')->row_array();

		if(count($row) > 0){
			return TRUE;
		}else{
			return 0;
		}		

	}

// 	public function check_if_enddataExist($end_date){
// 		$branch_id = $this->session->userdata('branch_id');
		
// 		$this->db->where('status', '1');
// 		$this->db->where('date', $end_date);
// 		$this->db->where('location', $branch_id);
// 		$row = $this->db->get('daily_forecasting_dayseven')->row_array();

// 		if(count($row) > 0){
// 			return TRUE;
// 		}else{
// 			return 0;
// 		}		

// 	}
//-------------------------validation---------------------------------------------------------------

	public function _getforecast1_val($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$month_from = $data['rfmonth_from'];
		$month_end = $data['rfmonth_end'];

		$query = sprintf("SELECT TOP 2 items.barcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2 ON salesm2.date between  '$month_from' and  '$month_end' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast2_val($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$month_from = $data['rsmonth_from'];
		$month_end = $data['rsmonth_end'];

		$query = sprintf("SELECT TOP 2 items.barcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2 ON salesm2.date between  '$month_from' and  '$month_end' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function _getforecast3_val($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$month_from = $data['rtmonth_from'];
		$month_end = $data['rtmonth_end'];

		$query = sprintf("SELECT TOP 2 items.barcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2 ON salesm2.date between  '$month_from' and  '$month_end' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

//---------------------total gross and fg sold average----------------------------------------------
	public function _gettotalgross_avg($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ref_month_from'];
		$month_end = $data['ref_month_end'];

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
		 
		 $loc = $row['location'];

		 $query = sprintf("SELECT sum(tprice) as gross FROM salesm1 WHERE branch = '$loc' AND date BETWEEN '$month_from' AND '$month_end'");
		 $rows = $this->db->query($query)->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast_avg($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$month_from = $data['ref_month_from'];
		$month_end = $data['ref_month_end'];

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
						  FROM items FULL OUTER JOIN salesm2 ON salesm2.date between  '$month_from' and  '$month_end' and salesm2.branch between '$current' and '$end' 
					      and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

//---------------------for 1stmonth-----------------------------------------------------------------

	public function _gettotalgross1($data){
		$branch_id = $this->session->userdata('branch_id');
		
		 $month_from = $data['ref_month_from'];
		 $month_end = $data['ref_month_end'];

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
		 
		 $loc = $row['location'];

		 $query = sprintf("SELECT sum(tprice) as gross FROM salesm1 WHERE branch = '$loc' AND date BETWEEN '$month_from' AND '$month_end'");
		 $rows = $this->db->query($query)->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast1($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ref_month_from'];
		$month_end = $data['ref_month_end'];

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
						  FROM items FULL OUTER JOIN salesm2 ON salesm2.date between  '$month_from' and  '$month_end' and salesm2.branch between '$current' and '$end' 
						  and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert1($gross_fmonth,$result_fmonth,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ffmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		if($this->_dataExist($data)){
			return 0;

		}else{

			foreach($result_fmonth as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);	
					$this->db->set('total_gross', $gross_fmonth);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $gross_fmonth);
					$this->db->set('ref_date_from', $ref_month_from);
					$this->db->set('ref_date_to', $ref_month_end);
					$this->db->set('location', $branch_id);
					$this->db->set('date_from', $month_from);
					$this->db->set('date_to', $month_end);
					$this->db->set('status', '0');
					$this->db->insert('first_month_forecast');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ffmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('location', $branch_id);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		
		$row = $this->db->get('first_month_forecast')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function update1($gross_fmonth1,$result_fmonth1,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ffmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];	

		if($this->_dataExist($data)){

			foreach($result_fmonth1 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'];
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('date_from', $month_from);
					$this->db->where('date_to', $month_end);
					$this->db->where('location', $branch_id);
					$this->db->where('ref_date_from', $ref_month_from);
					$this->db->where('ref_date_to', $ref_month_end);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $gross_fmonth1);
					$this->db->set('build_amount', $need / $gross_fmonth1);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('first_month_forecast');		
				}

			}	
			return TRUE;

		}
	}


	public function insert1_pm($result_fmonth,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		if($this->_dataExist_pm($data)){
			return 0;

		}else{

			foreach($result_fmonth as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('[desc]', $row['desc']);
					$this->db->set('location', $branch_id);
					$this->db->set('date_from', $month_from);
					$this->db->set('date_to', $month_end);
					$this->db->set('ref_date_from', $ref_month_from);
					$this->db->set('ref_date_to', $ref_month_end);
					$this->db->insert('m_pm1');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist_pm($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('location', $branch_id);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		
		$row = $this->db->get('m_pm1')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}	

	}

	public function countday1($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ffmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->where('location', $branch_id);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		
		$result = $this->db->get('first_month_forecast')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayOne($limit=null,$offset=null,$data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ffmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);

		return $this->db->get('first_month_forecast')->result_array();

	}

	public function day1fa($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ffmonth_from'];
		$month_end = $data['ffmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$query = sprintf("SELECT forecast_amount FROM first_month_forecast WHERE date_from = '$month_from' and date_to = '$month_end' AND ref_date_from = '$ref_month_from' and ref_date_to = '$ref_month_end' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

//---------------------for 2ndmonth-----------------------------------------------------------------

	public function _gettotalgross2($data){
		$branch_id = $this->session->userdata('branch_id');
		
		 $month_from = $data['ref_month_from'];
		 $month_end = $data['ref_month_end'];

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
		 
		 $loc = $row['location'];

		 $query = sprintf("SELECT sum(tprice) as gross FROM salesm1 WHERE branch = '$branch_id' AND date BETWEEN '$month_from' AND '$month_end'");
		$rows = $this->db->query($query)->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast2($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ref_month_from'];
		$month_end = $data['ref_month_end'];

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
							FROM items FULL OUTER JOIN salesm2 ON salesm2.date between  '$month_from' and  '$month_end' and salesm2.branch between '$current' and '$end' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}


	public function insert2($gross_smonth,$result_smonth,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		if($this->_dataExist2($data)){
			return 0;

		}else{

			foreach($result_smonth as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);	
					$this->db->set('total_gross', $gross_smonth);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $gross_fmonth);
					$this->db->set('ref_date_from', $ref_month_from);
					$this->db->set('ref_date_to', $ref_month_end);
					$this->db->set('location', $branch_id);
					$this->db->set('date_from', $month_from);
					$this->db->set('date_to', $month_end);
					$this->db->set('status', '0');
					$this->db->insert('second_month_forecast');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist2($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('location', $branch_id);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		
		$row = $this->db->get('second_month_forecast')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function update2($gross_smonth1,$result_smonth1,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		if($this->_dataExist2($data)){

			foreach($result_smonth1 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'];
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('date_from', $month_from);
					$this->db->where('date_to', $month_end);
					$this->db->where('location', $branch_id);
					$this->db->where('ref_date_from', $ref_month_from);
					$this->db->where('ref_date_to', $ref_month_end);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $gross_smonth1);
					$this->db->set('build_amount', $need / $gross_smonth1);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('second_month_forecast');		
				}

			}	
			return TRUE;

		}
	}

	public function insert2_pm($result_smonth,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		if($this->_dataExist2_pm($data)){
			return 0;

		}else{

			foreach($result_smonth as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('[desc]', $row['desc']);
					$this->db->set('location', $branch_id);
					$this->db->set('date_from', $month_from);
					$this->db->set('date_to', $month_end);
					$this->db->insert('m_pm2');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist2_pm($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$query = sprintf("SELECT * FROM m_pm2 WHERE location = '$branch_id' AND  date_from = '$month_from' AND date_to = '$month_end'");
		$row = $this->db->query($query)->row_array();	

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}	

	}

	public function countday2($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->where('location', $branch_id);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);

		$result = $this->db->get('second_month_forecast')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayTwo($limit=null,$offset=null,$data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);

		return $this->db->get('second_month_forecast')->result_array();

	}

	public function day2fa($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ssmonth_from'];
		$month_end = $data['ssmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$query = sprintf("SELECT forecast_amount FROM second_month_forecast WHERE date_from = '$month_from' and date_to = '$month_end' AND ref_date_from = '$ref_month_from' and ref_date_to = '$ref_month_end' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

//---------------------for 3rdmonth-----------------------------------------------------------------

	public function _gettotalgross3($data){
		$branch_id = $this->session->userdata('branch_id');
		
		 $month_from = $data['ref_month_from'];
		 $month_end = $data['ref_month_end'];

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
		 
		 $loc = $row['location'];

		 $query = sprintf("SELECT sum(tprice) as gross FROM salesm1 WHERE branch = '$branch_id' AND date BETWEEN '$month_from' AND '$month_end'");
		 $rows = $this->db->query($query)->row_array();

		 $array[] = $rows['gross'];

		}

		$gross = array_sum($array);

		if($gross!=""){
			return $gross;
		
		}else{
			return 0;
		
		}

	
	}

	public function _getforecast3($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ref_month_from'];
		$month_end = $data['ref_month_end'];

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
							FROM items FULL OUTER JOIN salesm2 ON salesm2.date between  '$month_from' and  '$month_end' and salesm2.branch between '$current' and '$end' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert3($gross_tmonth,$result_tmonth,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		if($this->_dataExist3($data)){
			return 0;

		}else{

			foreach($result_tmonth as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);
					// $this->db->set('avgfgsold', $row['need']);	
					$this->db->set('total_gross', $gross_tmonth);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $gross_fmonth);
					$this->db->set('ref_date_from', $ref_month_from);
					$this->db->set('ref_date_to', $ref_month_end);
					$this->db->set('location', $branch_id);
					$this->db->set('date_from', $month_from);
					$this->db->set('date_to', $month_end);
					$this->db->set('status', '0');
					$this->db->insert('third_month_forecast');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist3($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('location', $branch_id);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		
		$row = $this->db->get('third_month_forecast')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function update3($gross_tmonth1,$result_tmonth1,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		if($this->_dataExist3($data)){

			foreach($result_tmonth1 as $row){
				
				if($row['barcode'] != ""){

					$need = $row['need'];
					// $this->db->set('fgsold', $row['qty']);
					$this->db->where('date_from', $month_from);
					$this->db->where('date_to', $month_end);
					$this->db->where('location', $branch_id);
					$this->db->where('ref_date_from', $ref_month_from);
					$this->db->where('ref_date_to', $ref_month_end);
					$this->db->where('barcode', $row['barcode']);
					$this->db->set('avgfgsold', $need);	
					$this->db->set('avg_tg', $gross_tmonth1);
					$this->db->set('build_amount', $need / $gross_tmonth1);
					// $this->db->set('fg', $row['desc']);
					// $this->db->set('size', $row['size']);
					// $this->db->set('build_amount', $row['need'] / $total_gross_dayone);
					// $this->db->set('location', $branch_id);
					// $this->db->set('date', $startdate);
					// $this->db->set('status', '0');
					$this->db->update('third_month_forecast');		
				}

			}	
			return TRUE;

		}
	}

	public function insert3_pm($result_tmonth,$data){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		if($this->_dataExist3_pm($data)){
			return 0;

		}else{

			foreach($result_tmonth as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('[desc]', $row['desc']);
					$this->db->set('location', $branch_id);
					$this->db->set('date_from', $month_from);
					$this->db->set('date_to', $month_end);
					$this->db->insert('m_pm3');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist3_pm($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$query = sprintf("SELECT * FROM m_pm3 WHERE location = '$branch_id' AND  date_from = '$month_from' AND date_to = '$month_end'");
		$row = $this->db->query($query)->row_array();	

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}	

	}

	public function countday3($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->where('location', $branch_id);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		$result = $this->db->get('third_month_forecast')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayThree($limit=null,$offset=null,$data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date_from', $month_from);
		$this->db->where('date_to', $month_end);
		$this->db->where('ref_date_from', $ref_month_from);
		$this->db->where('ref_date_to', $ref_month_end);
		$this->db->where('location', $branch_id);

		return $this->db->get('third_month_forecast')->result_array();

	}

	public function day3fa($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$month_from = $data['ttmonth_from'];
		$month_end = $data['ttmonth_end'];

		$ref_month_from = $data['ref_month_from'];
		$ref_month_end = $data['ref_month_end'];

		$query = sprintf("SELECT forecast_amount FROM third_month_forecast WHERE date_from = '$month_from' and date_to = '$month_end' AND ref_date_from = '$ref_month_from' and ref_date_to = '$ref_month_end' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

//---------------------for friday-----------------------------------------------------------------

	public function _gettotalgross4($fri_date){
		$date = $fri_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date);
		$this->db->where('branch', $branch_id);
		$this->db->select('sum(tprice) as gross');
		$rows = $this->db->get('salesm1')->row_array();

		if($rows['gross']!=""){
			return $rows['gross'];
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast4($fri_date){
		$date = $fri_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert4($total_gross_dayfour,$result_dayfour,$fri_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist4($fri_date)){
			return 0;

		}else{

			foreach($result_dayfour as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('total_gross', $total_gross_dayfour);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					$this->db->set('build_amount', $row['qty'] / $total_gross_dayfour);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $fri_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_dayfour');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist4($fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $fri_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayfour')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday4($fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $fri_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayfour')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayFour($limit=null,$offset=null,$fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $fri_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_dayfour')->result_array();

	}

	public function day4fa($fri_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayfour WHERE date = '$fri_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

//---------------------for saturday-----------------------------------------------------------------

	public function _gettotalgross5($sat_date){
		$date = $sat_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date);
		$this->db->where('branch', $branch_id);
		$this->db->select('sum(tprice) as gross');
		$rows = $this->db->get('salesm1')->row_array();

		if($rows['gross']!=""){
			return $rows['gross'];
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast5($sat_date){
		$date = $sat_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert5($total_gross_dayfive,$result_dayfive,$sat_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist5($sat_date)){
			return 0;

		}else{

			foreach($result_dayfive as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('total_gross', $total_gross_dayfive);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					$this->db->set('build_amount', $row['qty'] / $total_gross_dayfive);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $sat_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_dayfive');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist5($sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $sat_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayfive')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday5($sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $sat_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayfive')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDayFive($limit=null,$offset=null,$sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $sat_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_dayfive')->result_array();

	}	

	public function day5fa($sat_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayfive WHERE date = '$sat_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

//---------------------for sunday-----------------------------------------------------------------

	public function _gettotalgross6($sun_date){
		$date = $sun_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date);
		$this->db->where('branch', $branch_id);
		$this->db->select('sum(tprice) as gross');
		$rows = $this->db->get('salesm1')->row_array();

		if($rows['gross']!=""){
			return $rows['gross'];
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast6($sun_date){
		$date = $sun_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert6($total_gross_daysix,$result_daysix,$sun_date){
		error_reporting(0);

		$branch_id = $this->session->userdata('branch_id');
		
		if($this->_dataExist6($sun_date)){
			return 0;

		}else{

			foreach($result_daysix as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('total_gross', $total_gross_daysix);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					$this->db->set('build_amount', $row['qty'] / $total_gross_daysix);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $sun_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_daysix');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist6($sun_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $sun_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_daysix')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday6($sun_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $sun_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_daysix')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDaySix($limit=null,$offset=null,$sun_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $sun_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_daysix')->result_array();

	}	

	public function day6fa($sun_date){
		$branch_id = $this->session->userdata('branch_id');
			
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_daysix WHERE date = '$sun_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

//---------------------for monday-----------------------------------------------------------------

	public function _gettotalgross7($mon_date){
		$date = $mon_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $date);
		$this->db->where('branch', $branch_id);
		$this->db->select('sum(tprice) as gross');
		$rows = $this->db->get('salesm1')->row_array();

		if($rows['gross']!=""){
			return $rows['gross'];
		
		}else{
			return 0;
		
		}

	}

	public function _getforecast7($mon_date){
		$date = $mon_date . ' ' . '00:00:00.000';
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT items.barcode, items.sapcode, items.[desc], items.size, sum(salesm2.qty) as qty, sum(salesm2.price) as FGsoldPrice, sum(salesm2.amount) as TotalFGsold
							FROM items FULL OUTER JOIN salesm2	ON salesm2.date = '$date' and salesm2.branch = '$branch_id' 
							and items.barcode=salesm2.barcode GROUP BY items.barcode, items.[desc], items.size, items.sapcode order by qty desc");

		return $this->db->query($query)->result_array();

	}

	public function insert7($total_gross_dayseven,$result_dayseven,$mon_date){
		error_reporting(0);
	
		$branch_id = $this->session->userdata('branch_id');
			
		if($this->_dataExist7($mon_date)){
			return 0;

		}else{

			foreach($result_dayseven as $row){
				
				if($row['barcode'] != ""){

					$this->db->set('fgsold', $row['qty']);	
					$this->db->set('total_gross', $total_gross_dayseven);
					$this->db->set('barcode', $row['barcode']);
					$this->db->set('fg', $row['desc']);
					$this->db->set('size', $row['size']);
					$this->db->set('build_amount', $row['qty'] / $total_gross_dayseven);
					$this->db->set('location', $branch_id);
					$this->db->set('date', $mon_date);
					$this->db->set('status', '0');
					$this->db->insert('daily_forecasting_dayseven');		
				}

			}	
			return TRUE;

		}
	}

	function _dataExist7($mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $mon_date);
		$this->db->where('location', $branch_id);
		$row = $this->db->get('daily_forecasting_dayseven')->row_array();

		if(count($row) > 1){
			return TRUE;
		}else{
			return 0;
		}		

	}

	public function countday7($mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date', $mon_date);
		$this->db->where('location', $branch_id);
		$result = $this->db->get('daily_forecasting_dayseven')->result_array();
		
		$count = count($result);

		return $count;
	}

	public function _selectAllDaySeven($limit=null,$offset=null,$mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->limit($limit = $limit, $offset = $offset);
		$this->db->where('date', $mon_date);
		$this->db->where('location', $branch_id);
		return $this->db->get('daily_forecasting_dayseven')->result_array();

	}	

	public function day7fa($mon_date){
		$branch_id = $this->session->userdata('branch_id');
		
		$query = sprintf("SELECT forecast_amount FROM daily_forecasting_dayseven WHERE date = '$mon_date' AND location = '$branch_id' GROUP BY forecast_amount");

		return $this->db->query($query)->row();
	}

//-------------------------------------------------------------------------------------------------------	

//----------------------------Daily Forecasting Dayone Process-------------------------------------------

	public function _updatefa1($data){
		$branch_id = $this->session->userdata('branch_id');
		
		$this->db->where('date_from', $data['date_from']);
		$this->db->where('date_to', $data['date_to']);
		$this->db->where('ref_date_from', $data['ref_date_from']);
		$this->db->where('ref_date_to', $data['ref_date_to']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('first_month_forecast');

		return TRUE;
	}

	public function _processfa1($data){
		 $branch_id = $this->session->userdata('branch_id');
	 	 
	 	 $this->db->where('date_from', $data['date_from']);
		 $this->db->where('date_to', $data['date_to']);
		 $this->db->where('ref_date_from', $data['ref_date_from']);
		 $this->db->where('ref_date_to', $data['ref_date_to']);
		 $this->db->where('location', $branch_id);
		 $result = $this->db->get('first_month_forecast')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date_from', $data['ref_date_from']);
		  $this->db->where('ref_date_to', $data['ref_date_to']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('first_month_forecast');

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
				$row = $this->db->get('first_month_forecast')->row();

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
				$this->db->update('first_month_forecast');

			}		
		
		}

		return TRUE;		
	}

//----------------------------Daily Forecasting Daytwo Process-------------------------------------------

	public function _updatefa2($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date_from', $data['date_from']);
		$this->db->where('date_to', $data['date_to']);
		$this->db->where('ref_date_from', $data['ref_date_from']);
		$this->db->where('ref_date_to', $data['ref_date_to']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('second_month_forecast');

		return TRUE;
	}

	public function _processfa2($data){
		 $branch_id = $this->session->userdata('branch_id');	 		
		 
		 $this->db->where('date_from', $data['date_from']);
		 $this->db->where('date_to', $data['date_to']);
		 $this->db->where('ref_date_from', $data['ref_date_from']);
		$this->db->where('ref_date_to', $data['ref_date_to']);
		 $this->db->where('location', $branch_id);
	 	 $result = $this->db->get('second_month_forecast')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date_from', $data['ref_date_from']);
		  $this->db->where('ref_date_to', $data['ref_date_to']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('second_month_forecast');

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
				$row = $this->db->get('second_month_forecast')->row();

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
				$this->db->update('second_month_forecast');

			}		
		
		}

		return TRUE;		
	}

//----------------------------Daily Forecasting Daythree Process-------------------------------------------

	public function _updatefa3($data){
		$branch_id = $this->session->userdata('branch_id');
	
		$this->db->where('date_from', $data['date_from']);
		$this->db->where('date_to', $data['date_to']);
		$this->db->where('ref_date_from', $data['ref_date_from']);
		$this->db->where('ref_date_to', $data['ref_date_to']);
		$this->db->where('location', $branch_id);
		$this->db->set('forecast_amount', $data['forecasted_amount']);
		$this->db->update('third_month_forecast');

		return TRUE;
	}

	public function _processfa3($data){
		 $branch_id = $this->session->userdata('branch_id');

		 $this->db->where('date_from', $data['date_from']);
		 $this->db->where('date_to', $data['date_to']);
		 $this->db->where('ref_date_from', $data['ref_date_from']);
		$this->db->where('ref_date_to', $data['ref_date_to']);
		 $this->db->where('location', $branch_id);
		 $result = $this->db->get('third_month_forecast')->result_array();

		foreach($result as $row){
		  
		  $this->db->where('id', $row['id']);
		  $this->db->where('ref_date_from', $data['ref_date_from']);
		  $this->db->where('ref_date_to', $data['ref_date_to']);
		  $this->db->set('need', $row['build_amount'] * $data['forecasted_amount']);
		  $this->db->set('final_order', $row['build_amount'] * $data['forecasted_amount']);		
		  $this->db->update('third_month_forecast');

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
				$row = $this->db->get('third_month_forecast')->row();

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
				$this->db->update('third_month_forecast');

			}		
		
		}

		return TRUE;		
	}

//---------------------------------save and generate

	public function selectitems($data){

		$branch_id = $this->session->userdata('branch_id');
		$branch = $this->session->userdata('branch');

		$query = sprintf("SELECT a.barcode, a.[desc], a.sapcode as material, b.sapcode as plant FROM items a LEFT JOIN location b ON location = '$branch_id'");
		$result = $this->db->query($query)->result_array();
		
		if($this->existinsap_monthly($data)){
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
				$this->db->set('fdate_from', $data['fmonth_from']);
				$this->db->set('fdate_to', $data['fmonth_end']);
				$this->db->set('sdate_from', $data['smonth_from']);
				$this->db->set('sdate_to', $data['smonth_end']);
				$this->db->set('tdate_from', $data['tmonth_from']);
				$this->db->set('tdate_to', $data['tmonth_end']);
				$this->db->insert('sap_need_monthly_forecast');
			}
			return TRUE;
		}
	}

	public function existinsap_monthly($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('branch', $branch_id);
		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('fdate_to', $data['fmonth_end']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('tdate_to', $data['tmonth_end']);
		$row = $this->db->get('sap_need_monthly_forecast')->row_array();

		if(count($row) > 1){
			return TRUE;

		}else{
			return 0;

		}

	}

	public function sel_upd($data){
		$branch_id = $this->session->userdata('branch_id');

		for($x=1;$x<=3;$x++){
			if($x == "1"){
				$date_from = $data['fmonth_from'];
				$date_to = $data['fmonth_end'];
				$table = 'first_month_forecast';
			
			}elseif($x == "2"){
				$date_from = $data['smonth_from'];
				$date_to = $data['smonth_end'];
				$table = 'second_month_forecast';

			}elseif($x == "3"){
				$date_from = $data['tmonth_from'];
				$date_to = $data['tmonth_end'];
				$table = 'third_month_forecast';

			}

			$this->db->where('location', $branch_id);
			$this->db->where('date_from', $date_from);
			$this->db->where('date_to', $date_to);
			$this->db->select('barcode,fg,forecast_amount,build_amount,need,adjustment,final_order,date_from,date_to');
			$result = $this->db->get($table)->result_array();	

			foreach($result as $row){
				$this->db->where('barcode', $row['barcode']);
				$this->db->where('fg', $row['fg']);
			
				if($x == "1"){

					$this->db->where('fdate_from', $data['fmonth_from']);
					$this->db->where('fdate_to', $data['fmonth_end']);
					$this->db->set('fba', $row['build_amount']);
					$this->db->set('fneed', $row['need']);
					$this->db->set('fadj', $row['adjustment']);
					$this->db->set('ffo', $row['final_order']);
					$this->db->set('ffa',$row['forecast_amount']);
				
				}elseif($x == "2"){

					$this->db->where('sdate_from', $data['smonth_from']);
					$this->db->where('sdate_to', $data['smonth_end']);
					$this->db->set('sba', $row['build_amount']);
					$this->db->set('sneed', $row['need']);
					$this->db->set('sadj', $row['adjustment']);
					$this->db->set('sfo', $row['final_order']);
					$this->db->set('sfa',$row['forecast_amount']);

				}elseif($x == "3"){

					$this->db->where('tdate_from', $data['tmonth_from']);
					$this->db->where('tdate_to', $data['tmonth_end']);
					$this->db->set('tba', $row['build_amount']);
					$this->db->set('tneed', $row['need']);
					$this->db->set('tadj', $row['adjustment']);
					$this->db->set('tfo', $row['final_order']);
					$this->db->set('tfa',$row['forecast_amount']);

				}


				$this->db->update('sap_need_monthly_forecast');
			
			}

		}

		for($y=1;$y<=3;$y++){
			if($y == "1"){
				$date_from = $data['fmonth_from'];
				$date_to = $data['fmonth_end'];
				$table = 'first_month_forecast';
			
			}elseif($y == "2"){
				$date_from = $data['smonth_from'];
				$date_to = $data['smonth_end'];
				$table = 'second_month_forecast';

			}elseif($y == "3"){
				$date_from = $data['tmonth_from'];
				$date_to = $data['tmonth_end'];
				$table = 'third_month_forecast';

			}

			$this->db->where('date_from', $date_from);
			$this->db->where('date_to', $date_to);
			$this->db->where('location', $branch_id);
			$this->db->set('status', '1');
			$this->db->update($table);

			$this->db->where('ref_date_from', $data['ref_month_from']);
			$this->db->where('ref_date_to', $data['ref_month_end']);
			$this->db->where('location', $branch_id);
			$this->db->set('ref_date_status', '1');
			$this->db->update($table);
		}

		// $dateends = date("Y-m-d", strtotime($startdate . " +6 day"));

		$this->db->where('monthstart',$data['monthstart']);
		$this->db->where('monthend',$data['monthend']); 	
		$this->db->where('branch',$branch_id);
		$this->db->set('status', '1');
		$this->db->update('monthly_pending_forecast');

		return TRUE;
			
	}

	

	public function print_forecasting($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('fdate_to', $data['fmonth_end']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('tdate_to', $data['tmonth_end']);
		$this->db->where('branch', $branch_id);
		$this->db->where('status', '0');
		return $this->db->get('sap_need_monthly_forecast')->result_array();
	}	

	public function updatesap($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->group_by('versions');
		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('fdate_to', $data['fmonth_end']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('tdate_to', $data['tmonth_end']);
		$this->db->where('branch', $branch_id);
		$this->db->select('versions');
		$result = $this->db->get('sap_need_monthly_forecast')->row();

		$result = $result->versions;

		if($result == ""){
			$result = "0";
		}

		$result = $result + 1;

		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('branch', $branch_id);
		$this->db->set('status', '1');
		$this->db->set('versions', $result);
		$this->db->update('sap_need_monthly_forecast');

	}

	//--------------update-----------------------//

	public function update_a_upd($data){

		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('versions', $data['u_version']);
		$this->db->where('branch', $branch_id);
		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->set('a_upd', '1');
		$this->db->update('sap_need_monthly_forecast');

		return TRUE;

	}

	public function selectitems_forupdate($data){

		$branch_id = $this->session->userdata('branch_id');
		$branch = $this->session->userdata('branch');

		$query = sprintf("SELECT a.barcode, a.[desc], a.sapcode as material, b.sapcode as plant FROM items a LEFT JOIN location b ON location = '$branch_id'");
		$result = $this->db->query($query)->result_array();
		
		if($this->existinsap_monthly_update($data)){
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
				$this->db->set('versions', $data['version']);
				$this->db->set('fdate_from', $data['fmonth_from']);
				$this->db->set('fdate_to', $data['fmonth_end']);
				$this->db->set('sdate_from', $data['smonth_from']);
				$this->db->set('sdate_to', $data['smonth_end']);
				$this->db->set('tdate_from', $data['tmonth_from']);
				$this->db->set('tdate_to', $data['tmonth_end']);
				$this->db->insert('sap_need_monthly_forecast');
			}
			return TRUE;
		}
	}

	public function existinsap_monthly_update($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('branch', $branch_id);
		$this->db->where('versions', $data['version']);
		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('fdate_to', $data['fmonth_end']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('tdate_to', $data['tmonth_end']);
		$row = $this->db->get('sap_need_monthly_forecast')->row_array();

		if(count($row) > 1){
			return TRUE;

		}else{
			return 0;

		}

	}

	public function sel_upd_forupdate($data){
		$branch_id = $this->session->userdata('branch_id');

		for($x=1;$x<=3;$x++){
			if($x == "1"){
				$date_from = $data['fmonth_from'];
				$date_to = $data['fmonth_end'];
				$table = 'first_month_forecast';
			
			}elseif($x == "2"){
				$date_from = $data['smonth_from'];
				$date_to = $data['smonth_end'];
				$table = 'second_month_forecast';

			}elseif($x == "3"){
				$date_from = $data['tmonth_from'];
				$date_to = $data['tmonth_end'];
				$table = 'third_month_forecast';

			}

			$this->db->where('location', $branch_id);
			$this->db->where('date_from', $date_from);
			$this->db->where('date_to', $date_to);
			$this->db->select('barcode,fg,forecast_amount,build_amount,need,adjustment,final_order,date_from,date_to');
			$result = $this->db->get($table)->result_array();	

			foreach($result as $row){
				$this->db->where('barcode', $row['barcode']);
				$this->db->where('fg', $row['fg']);
			
				if($x == "1"){

					$this->db->where('fdate_from', $data['fmonth_from']);
					$this->db->where('fdate_to', $data['fmonth_end']);
					$this->db->set('fba', $row['build_amount']);
					$this->db->set('fneed', $row['need']);
					$this->db->set('fadj', $row['adjustment']);
					$this->db->set('ffo', $row['final_order']);
					$this->db->set('ffa',$row['forecast_amount']);
				
				}elseif($x == "2"){

					$this->db->where('sdate_from', $data['smonth_from']);
					$this->db->where('sdate_to', $data['smonth_end']);
					$this->db->set('sba', $row['build_amount']);
					$this->db->set('sneed', $row['need']);
					$this->db->set('sadj', $row['adjustment']);
					$this->db->set('sfo', $row['final_order']);
					$this->db->set('sfa',$row['forecast_amount']);

				}elseif($x == "3"){

					$this->db->where('tdate_from', $data['tmonth_from']);
					$this->db->where('tdate_to', $data['tmonth_end']);
					$this->db->set('tba', $row['build_amount']);
					$this->db->set('tneed', $row['need']);
					$this->db->set('tadj', $row['adjustment']);
					$this->db->set('tfo', $row['final_order']);
					$this->db->set('tfa',$row['forecast_amount']);

				}


				$this->db->update('sap_need_monthly_forecast');
			
			}

		}

		for($y=1;$y<=3;$y++){
			if($y == "1"){
				$date_from = $data['fmonth_from'];
				$date_to = $data['fmonth_end'];
				$table = 'first_month_forecast';
			
			}elseif($y == "2"){
				$date_from = $data['smonth_from'];
				$date_to = $data['smonth_end'];
				$table = 'second_month_forecast';

			}elseif($y == "3"){
				$date_from = $data['tmonth_from'];
				$date_to = $data['tmonth_end'];
				$table = 'third_month_forecast';

			}

			$this->db->where('date_from', $date_from);
			$this->db->where('date_to', $date_to);
			$this->db->where('location', $branch_id);
			$this->db->set('status', '1');
			$this->db->update($table);
		}

		// $dateends = date("Y-m-d", strtotime($startdate . " +6 day"));

		$this->db->where('monthstart',$data['monthstart']);
		$this->db->where('monthend',$data['monthend']); 	
		$this->db->where('branch',$branch_id);
		$this->db->set('status', '1');
		$this->db->update('monthly_pending_forecast');

		return TRUE;
			
	}

	

	public function print_forecasting_update($data){
		$branch_id = $this->session->userdata('branch_id');

		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('fdate_to', $data['fmonth_end']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('tdate_to', $data['tmonth_end']);
		$this->db->where('branch', $branch_id);
		$this->db->where('status', '0');
		return $this->db->get('sap_need_monthly_forecast')->result_array();
	}	

	public function updatesap_forecast($data){
		$branch_id = $this->session->userdata('branch_id');

		// $this->db->group_by('versions');
		// $this->db->where('fdate_from', $data['fmonth_from']);
		// $this->db->where('fdate_to', $data['fmonth_end']);
		// $this->db->where('tdate_from', $data['tmonth_from']);
		// $this->db->where('tdate_to', $data['tmonth_end']);
		// $this->db->where('branch', $branch_id);
		// $this->db->select('versions');
		// $result = $this->db->get('sap_need_monthly_forecast')->row();

		// $result = $result->versions;

		// if($result == ""){
		// 	$result = "0";
		// }

		// $result = $result + 1;

		$this->db->where('fdate_from', $data['fmonth_from']);
		$this->db->where('tdate_from', $data['tmonth_from']);
		$this->db->where('branch', $branch_id);
		$this->db->set('status', '1');
		$this->db->update('sap_need_monthly_forecast');

	}

}