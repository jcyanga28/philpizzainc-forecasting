<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_Forecasting extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');
		$this->load->model('Daily_forecasting_model');
		
	}	

	public function index(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			$this->getDailyForecast_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}
	} 

	public function getDailyForecast_Content(){
		$role_id = $this->session->userdata('role_id');
        
        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

        $data['css'] = array('redmond/jquery-ui-1.8.22.custom.css');
    	$data['jquery'] = array('datepicker/jquery-ui.js');

        $date_from = date('m-d-Y');
        $date_to = date('m-d-Y');

		$data['date_from'] = $date_from;	
		$data['date_to'] = $date_to;
		
		$data['count'] = count($this->Daily_forecasting_model->count_all_sap_forecast());
		// $data['result'] = $this->Daily_forecasting_model->all_sap_forecast();

		$offset = (int)$this->input->get('per_page');
		$config["per_page"] = 10;

		$data["result"] = $this->Daily_forecasting_model->all_sap_forecast($config['per_page'],$offset);

		$this->load->library('pagination');
		$config['base_url'] = base_url('daily_forecasting?date_from='.$date_from.'&date_to='.$date_to);
		$config['total_rows'] = count($this->Daily_forecasting_model->count_all_sap_forecast());
		$config['page_query_string'] = TRUE;

		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();

		$data["content"] = 'daily_forecasting';
		$this->load->view('backend/template', $data);

	}

	public function display(){
		$start = $this->input->get('daterange_start');
		$end = $this->input->get('daterange_end');

		if((!isset($start)) || (!isset($end))){
			$this->_pageNotFound();
			return;

		}else{
			$role_id = $this->session->userdata('role_id');
        
	        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
	        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
	        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

	        $data['css'] = array('redmond/jquery-ui-1.8.22.custom.css');
	    	$data['jquery'] = array('datepicker/jquery-ui.js');

			$data['date_from'] = $start;	
			$data['date_to'] = $end;
			
			$data['count'] = count($this->Daily_forecasting_model->sap_forecast($start,$end));
			$data['result'] = $this->Daily_forecasting_model->sap_forecast($start,$end);	
			$data["content"] = 'display';
			$this->load->view('backend/template', $data);

		}

	}

	public function viewing(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result <= 0){
			$this->_pageNotFound();
			return;
		}else{
			$role_id = $this->session->userdata('role_id');
        
	        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
	        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
	        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

	        $startdate = $this->input->get('start');
			$end = $this->input->get('end');
			
			$data['version'] = $this->input->get('version');

			$data['tues_date'] = $startdate;
			$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
			$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
			$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
			$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
			$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
			$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

			$data['gross1'] = $this->Daily_forecasting_model->_getgross_vsf1($data['tues_date'],$data);
			$data['gross2'] = $this->Daily_forecasting_model->_getgross_vsf2($data['wed_date'],$data);
			$data['gross3'] = $this->Daily_forecasting_model->_getgross_vsf3($data['thurs_date'],$data);
			$data['gross4'] = $this->Daily_forecasting_model->_getgross_vsf4($data['fri_date'],$data);
			$data['gross5'] = $this->Daily_forecasting_model->_getgross_vsf5($data['sat_date'],$data);
			$data['gross6'] = $this->Daily_forecasting_model->_getgross_vsf6($data['sun_date'],$data);
			$data['gross7'] = $this->Daily_forecasting_model->_getgross_vsf7($data['mon_date'],$data);

			$row = $this->Daily_forecasting_model->select_update($data);
			$row = $row->a_upd;

			if($row==""){
				$row = "0";
			} 

			$data['date_today'] = date('Y-m-d');
			
			$data['update_stats'] = $row;
			$data['result'] = $this->Daily_forecasting_model->viewing($data);
			$data["content"] = 'viewing';
			$this->load->view('backend/template', $data);

		}

	}

	public function save_remarks(){
		$daterange_start = $_GET['daterange_start'];
		$daterange_end = $_GET['daterange_end'];

		$validation = array(
			array(
				"field" => "remarks",
				"label" => "remarks",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Remarks is required.</b>');
		// $this->form_validation->set_message('is_unique', 'Role Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Remarks is required.</b></div>');
			redirect('daily_forecasting');
		
		}else{

			$result = $this->Daily_forecasting_model->update_remarks();	
			
			if($result>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Remarks was successfully updated.</b></div>');
				redirect('daily_forecasting');
			
			}
		}

	}

	public function save_remarks1(){
		$daterange_start = $_GET['daterange_start'];
		$daterange_end = $_GET['daterange_end'];

		$validation = array(
			array(
				"field" => "remarks",
				"label" => "remarks",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Remarks is required.</b>');
		// $this->form_validation->set_message('is_unique', 'Role Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Remarks is required.</b></div>');
			redirect('daily_forecasting/display?daterange_start=' . $daterange_start . '&daterange_end=' . $daterange_end);
		
		}else{

			$result = $this->Daily_forecasting_model->update_remarks();	
			
			if($result>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Remarks was successfully updated.</b></div>');
				redirect('daily_forecasting/display?daterange_start=' . $daterange_start . '&daterange_end=' . $daterange_end);
			
			}
		}

	}

	public function tuesday_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$data['start'] = $_GET['start'];
    	$data['end'] = $_GET['end'];

    	$version = $_GET['version'];

    	// $startdate = $_GET['end'];

			if($result <= 0 || (!isset($data['start']))  || (!isset($data['end']))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($data['start']);
				$day = date("l", $date_start);

				$startdate = $data['start'];
				
				$ref_date =  $this->Daily_forecasting_model->_getref1($startdate);
				
				// $end_date = date("Y-m-d", strtotime($startdates . " -1 day"));
	
			//--tuesday--//
    			$total_gross_dayone = $this->Daily_forecasting_model->_getgross1($startdate,$ref_date);
    			$result_dayone= $this->Daily_forecasting_model->_getforecast1($startdate);

			  	$data["firstdate_display"] = $startdate;
			  	$data["firstday_display"] = $day;
			  	$data["forecasted_amount"] = $this->Daily_forecasting_model->day1fa($startdate,$ref_date);
			  	$data["gross"] = $total_gross_dayone;

			  	$offset = (int)$this->input->get('per_page');
				$config["per_page"] = 100;

				$data["tuesday"] = $this->Daily_forecasting_model->_selectAllDayOne($config['per_page'],$offset,$startdate,$ref_date);

				$this->load->library('pagination');
				$config['base_url'] = base_url('daily_forecasting/tuesday_forecast?start='.$data['start'].'&end='.$data['end'].'&version='.$version);
				$config['total_rows'] = $this->Daily_forecasting_model->countday1($startdate,$ref_date);
				$config['page_query_string'] = TRUE;

				$config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] ="</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";

				$this->pagination->initialize($config);
			 	$data["links"] = $this->pagination->create_links();

			$data["content"] = 'tuesday_forecast';
			$this->load->view('backend/template', $data);
	
	}

	public function wednesday_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$data['start'] = $_GET['start'];
    	$data['end'] = $_GET['end'];

    	$version = $_GET['version'];

    	// $startdate = $_GET['end'];

			if($result <= 0 || (!isset($data['start']))  || (!isset($data['end']))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($data['start']);
				$day = date("l", $date_start);

				$startdate = $data['start'];

				$wed_date = date("Y-m-d", strtotime($startdate . " +1 day"));

				$ref_date =  $this->Daily_forecasting_model->_getref2($wed_date);

			//--wednesday--//
		  		$total_gross_daytwo = $this->Daily_forecasting_model->_getgross2($wed_date,$ref_date);
				$result_daytwo = $this->Daily_forecasting_model->_getforecast2($wed_date);

				$data["seconddate_display"] = $wed_date;
				$seconddate = strtotime($wed_date);
				$day2 = date("l", $seconddate);
				$data["secondday_display"] = $day2;
				$data["forecasted_amount2"] = $this->Daily_forecasting_model->day2fa($wed_date,$ref_date);
				$data["gross"] = $total_gross_daytwo;

			  	$offset = (int)$this->input->get('per_page');
				$config["per_page"] = 100;

				$data["wednesday"] = $this->Daily_forecasting_model->_selectAllDayTwo($config['per_page'],$offset,$wed_date,$ref_date);	

				$this->load->library('pagination');
				$config['base_url'] = base_url('daily_forecasting/wednesday_forecast?start='.$data['start'].'&end='.$data['end'].'&version='.$version);
				$config['total_rows'] = $this->Daily_forecasting_model->countday2($wed_date,$ref_date);
				$config['page_query_string'] = TRUE;

				$config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] ="</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";

				$this->pagination->initialize($config);
			 	$data["links"] = $this->pagination->create_links();

			$data["content"] = 'wednesday_forecast';
			$this->load->view('backend/template', $data);		
				
	}

	public function thursday_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$data['start'] = $_GET['start'];
    	$data['end'] = $_GET['end'];

    	$version = $_GET['version'];

    	// $startdate = $_GET['end'];

			if($result <= 0 || (!isset($data['start']))  || (!isset($data['end']))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($data['start']);
				$day = date("l", $date_start);

				$startdate = $data['start'];
				$thurs_date = date("Y-m-d", strtotime($startdate . " +2 day"));

				$ref_date =  $this->Daily_forecasting_model->_getref3($thurs_date);

				//--thursday--//
			  		$total_gross_daythree = $this->Daily_forecasting_model->_getgross3($thurs_date,$ref_date);
	    			$result_daythree = $this->Daily_forecasting_model->_getforecast3($thurs_date);

					$data["thirddate_display"] = $thurs_date;
					$thirddate = strtotime($thurs_date);
					$day3 = date("l", $thirddate);
					$data["thirdday_display"] = $day3;
					$data["forecasted_amount3"] = $this->Daily_forecasting_model->day3fa($thurs_date,$ref_date);
					$data["gross"] = $total_gross_daythree;

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["thursday"] = $this->Daily_forecasting_model->_selectAllDayThree($config['per_page'],$offset,$thurs_date,$ref_date);

					$this->load->library('pagination');
					$config['base_url'] = base_url('daily_forecasting/thursday_forecast?start='.$data['start'].'&end='.$data['end'].'&version='.$version);
					$config['total_rows'] = $this->Daily_forecasting_model->countday3($thurs_date,$ref_date);
  					$config['page_query_string'] = TRUE;

  					$config['full_tag_open'] = "<ul class='pagination'>";
					$config['full_tag_close'] ="</ul>";
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
					$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
					$config['next_tag_open'] = "<li>";
					$config['next_tagl_close'] = "</li>";
					$config['prev_tag_open'] = "<li>";
					$config['prev_tagl_close'] = "</li>";
					$config['first_tag_open'] = "<li>";
					$config['first_tagl_close'] = "</li>";
					$config['last_tag_open'] = "<li>";
					$config['last_tagl_close'] = "</li>";

 					$this->pagination->initialize($config);
 				 	$data["links"] = $this->pagination->create_links();

				$data["content"] = 'thursday_forecast';
				$this->load->view('backend/template', $data);		
				
	}

	public function friday_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$data['start'] = $_GET['start'];
    	$data['end'] = $_GET['end'];

    	$version = $_GET['version'];

    	// $startdate = $_GET['end'];

			if($result <= 0 || (!isset($data['start']))  || (!isset($data['end']))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($data['start']);
				$day = date("l", $date_start);

				$startdate = $data['start'];
				$fri_date = date("Y-m-d", strtotime($startdate . " +3 day"));
				
				$ref_date =  $this->Daily_forecasting_model->_getref4($fri_date);

				//--friday--//
			  		$total_gross_dayfour = $this->Daily_forecasting_model->_getgross4($fri_date,$ref_date);
	    			$result_dayfour = $this->Daily_forecasting_model->_getforecast4($fri_date);

					$data["fourthdate_display"] = $fri_date;
					$fourthdate = strtotime($fri_date);
					$day4 = date("l", $fourthdate);
					$data["fourthday_display"] = $day4;
					$data["forecasted_amount4"] = $this->Daily_forecasting_model->day4fa($fri_date,$ref_date);
					$data["gross"] = $total_gross_dayfour;

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["friday"] = $this->Daily_forecasting_model->_selectAllDayFour($config['per_page'],$offset,$fri_date,$ref_date);

					$this->load->library('pagination');
					$config['base_url'] = base_url('daily_forecasting/friday_forecast?start='.$data['start'].'&end='.$data['end'].'&version='.$version);
					$config['total_rows'] = $this->Daily_forecasting_model->countday4($fri_date,$ref_date);
  					$config['page_query_string'] = TRUE;

  					$config['full_tag_open'] = "<ul class='pagination'>";
					$config['full_tag_close'] ="</ul>";
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
					$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
					$config['next_tag_open'] = "<li>";
					$config['next_tagl_close'] = "</li>";
					$config['prev_tag_open'] = "<li>";
					$config['prev_tagl_close'] = "</li>";
					$config['first_tag_open'] = "<li>";
					$config['first_tagl_close'] = "</li>";
					$config['last_tag_open'] = "<li>";
					$config['last_tagl_close'] = "</li>";

 					$this->pagination->initialize($config);
 				 	$data["links"] = $this->pagination->create_links();

				$data["content"] = 'friday_forecast';
				$this->load->view('backend/template', $data);
					
				
	}

	public function saturday_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$data['start'] = $_GET['start'];
    	$data['end'] = $_GET['end'];

    	$version = $_GET['version'];

    	// $startdate = $_GET['end'];

			if($result <= 0 || (!isset($data['start']))  || (!isset($data['end']))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($data['start']);
				$day = date("l", $date_start);

				$startdate = $data['start'];
				$sat_date = date("Y-m-d", strtotime($startdate . " +4 day"));
				
				$ref_date =  $this->Daily_forecasting_model->_getref5($sat_date);

				//--saturday--//
			  		$total_gross_dayfive = $this->Daily_forecasting_model->_getgross5($sat_date,$ref_date);
    				$result_dayfive = $this->Daily_forecasting_model->_getforecast5($sat_date);

					$data["fifthdate_display"] = $sat_date;
					$fifthdate = strtotime($sat_date);
					$day5 = date("l", $fifthdate);
					$data["fifthday_display"] = $day5;
					$data["forecasted_amount5"] = $this->Daily_forecasting_model->day5fa($sat_date,$ref_date);
					$data["gross"] = $total_gross_dayfive;

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["saturday"] = $this->Daily_forecasting_model->_selectAllDayFive($config['per_page'],$offset,$sat_date,$ref_date);

					$this->load->library('pagination');
					$config['base_url'] = base_url('daily_forecasting/saturday_forecast?start='.$data['start'].'&end='.$data['end'].'&version='.$version);
					$config['total_rows'] = $this->Daily_forecasting_model->countday5($sat_date,$ref_date);
  					$config['page_query_string'] = TRUE;

  					$config['full_tag_open'] = "<ul class='pagination'>";
					$config['full_tag_close'] ="</ul>";
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
					$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
					$config['next_tag_open'] = "<li>";
					$config['next_tagl_close'] = "</li>";
					$config['prev_tag_open'] = "<li>";
					$config['prev_tagl_close'] = "</li>";
					$config['first_tag_open'] = "<li>";
					$config['first_tagl_close'] = "</li>";
					$config['last_tag_open'] = "<li>";
					$config['last_tagl_close'] = "</li>";

 					$this->pagination->initialize($config);
 				 	$data["links"] = $this->pagination->create_links();

				$data["content"] = 'saturday_forecast';
				$this->load->view('backend/template', $data);
				
	}

	public function sunday_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$data['start'] = $_GET['start'];
    	$data['end'] = $_GET['end'];

    	$version = $_GET['version'];

    	// $startdate = $_GET['end'];

			if($result <= 0 || (!isset($data['start']))  || (!isset($data['end']))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($data['start']);
				$day = date("l", $date_start);

				$startdate = $data['start'];
				$sun_date = date("Y-m-d", strtotime($startdate . " +5 day"));
				
				$ref_date =  $this->Daily_forecasting_model->_getref6($sun_date);

				//--sunday--//
			  		$total_gross_daysix = $this->Daily_forecasting_model->_getgross6($sun_date,$ref_date);
	    			$result_daysix = $this->Daily_forecasting_model->_getforecast6($sun_date);

					$data["sixthdate_display"] = $sun_date;
					$sixthdate = strtotime($sun_date);
					$day6 = date("l", $sixthdate);
					$data["sixthday_display"] = $day6;
					$data["forecasted_amount6"] = $this->Daily_forecasting_model->day6fa($sun_date,$ref_date);
					$data["gross"] = $total_gross_daysix;

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["sunday"] = $this->Daily_forecasting_model->_selectAllDaySix($config['per_page'],$offset,$sun_date,$ref_date);

					$this->load->library('pagination');
					$config['base_url'] = base_url('daily_forecasting/sunday_forecast?start='.$data['start'].'&end='.$data['end'].'&version='.$version);
					$config['total_rows'] = $this->Daily_forecasting_model->countday6($sun_date,$ref_date);
  					$config['page_query_string'] = TRUE;

  					$config['full_tag_open'] = "<ul class='pagination'>";
					$config['full_tag_close'] ="</ul>";
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
					$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
					$config['next_tag_open'] = "<li>";
					$config['next_tagl_close'] = "</li>";
					$config['prev_tag_open'] = "<li>";
					$config['prev_tagl_close'] = "</li>";
					$config['first_tag_open'] = "<li>";
					$config['first_tagl_close'] = "</li>";
					$config['last_tag_open'] = "<li>";
					$config['last_tagl_close'] = "</li>";

 					$this->pagination->initialize($config);
 				 	$data["links"] = $this->pagination->create_links();

				$data["content"] = 'sunday_forecast';
				$this->load->view('backend/template', $data);
				
	}

	public function monday_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$data['start'] = $_GET['start'];
    	$data['end'] = $_GET['end'];

    	$version = $_GET['version'];

    	// $startdate = $_GET['end'];

			if($result <= 0 || (!isset($data['start']))  || (!isset($data['end']))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($data['start']);
				$day = date("l", $date_start);

				$startdate = $data['start'];
				$mon_date = date("Y-m-d", strtotime($startdate . " +6 day"));
				
				$ref_date =  $this->Daily_forecasting_model->_getref7($mon_date);

				//--monday--//
			  		$total_gross_dayseven = $this->Daily_forecasting_model->_getgross7($mon_date,$ref_date);
	    			$result_dayseven = $this->Daily_forecasting_model->_getforecast7($mon_date);

					$data["seventhdate_display"] = $mon_date;
					$seventhdate = strtotime($mon_date);
					$day7 = date("l", $seventhdate);
					$data["seventhday_display"] = $day7;
					$data["forecasted_amount7"] = $this->Daily_forecasting_model->day7fa($mon_date,$ref_date);
					$data["gross"] = $total_gross_dayseven;

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["monday"] = $this->Daily_forecasting_model->_selectAllDaySeven($config['per_page'],$offset,$mon_date,$ref_date);

					$this->load->library('pagination');
					$config['base_url'] = base_url('daily_forecasting/monday_forecast?start='.$data['start'].'&end='.$data['end'].'&version='.$version);
					$config['total_rows'] = $this->Daily_forecasting_model->countday7($mon_date,$ref_date);
  					$config['page_query_string'] = TRUE;

  					$config['full_tag_open'] = "<ul class='pagination'>";
					$config['full_tag_close'] ="</ul>";
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
					$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
					$config['next_tag_open'] = "<li>";
					$config['next_tagl_close'] = "</li>";
					$config['prev_tag_open'] = "<li>";
					$config['prev_tagl_close'] = "</li>";
					$config['first_tag_open'] = "<li>";
					$config['first_tagl_close'] = "</li>";
					$config['last_tag_open'] = "<li>";
					$config['last_tagl_close'] = "</li>";

 					$this->pagination->initialize($config);
 				 	$data["links"] = $this->pagination->create_links();

				$data["content"] = 'monday_forecast';
				$this->load->view('backend/template', $data);
				
	}

	public function summary_forecasted(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('start');
		$datef_end = $this->input->get('end');

		$version = $this->input->get('version');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($version))){
				$this->_pageNotFound();
				return;
			}
	
				$data['datefs'] = $this->input->get('start');
				$data['datefe'] = $this->input->get('end');
				// $data['ref_sdate'] = $this->input->get('ref_startdate');
				// $data['ref_edate'] = $this->input->get('ref_end_date');	

				$wed_date = date("Y-m-d", strtotime($datef_start . " +1 day"));
				$thurs_date = date("Y-m-d", strtotime($wed_date . " +1 day"));
				$fri_date = date("Y-m-d", strtotime($thurs_date . " +1 day"));
				$sat_date = date("Y-m-d", strtotime($fri_date . " +1 day"));
				$sun_date = date("Y-m-d", strtotime($sat_date . " +1 day"));
				$mon_date = date("Y-m-d", strtotime($sun_date . " +1 day"));

				$data['tues_date'] =  $this->Daily_forecasting_model->_getref1($datef_start);
				$data['wed_date'] =  $this->Daily_forecasting_model->_getref2($wed_date);
				$data['thurs_date'] =  $this->Daily_forecasting_model->_getref3($thurs_date);
				$data['fri_date'] =  $this->Daily_forecasting_model->_getref4($fri_date);
				$data['sat_date'] =  $this->Daily_forecasting_model->_getref5($sat_date);
				$data['sun_date'] =  $this->Daily_forecasting_model->_getref6($sun_date);
				$data['mon_date'] =  $this->Daily_forecasting_model->_getref7($mon_date);

					$data['f_tues_date'] = $data['datefs'];
					$data['f_wed_date'] = date("Y-m-d", strtotime($data['f_tues_date'] . " +1 day"));
					$data['f_thurs_date'] = date("Y-m-d", strtotime($data['f_wed_date'] . " +1 day"));
					$data['f_fri_date'] = date("Y-m-d", strtotime($data['f_thurs_date'] . " +1 day"));
					$data['f_sat_date'] = date("Y-m-d", strtotime($data['f_fri_date'] . " +1 day"));
					$data['f_sun_date'] = date("Y-m-d", strtotime($data['f_sat_date'] . " +1 day"));
					$data['f_mon_date'] = date("Y-m-d", strtotime($data['f_sun_date'] . " +1 day"));

				  $data['gross1'] = $this->Daily_forecasting_model->_getgross_sf1($data['f_tues_date'],$data['tues_date']);
				  $data['gross2'] = $this->Daily_forecasting_model->_getgross_sf2($data['f_wed_date'],$data['wed_date']);
				  $data['gross3'] = $this->Daily_forecasting_model->_getgross_sf3($data['f_thurs_date'],$data['thurs_date']);
				  $data['gross4'] = $this->Daily_forecasting_model->_getgross_sf4($data['f_fri_date'],$data['fri_date']);
				  $data['gross5'] = $this->Daily_forecasting_model->_getgross_sf5($data['f_sat_date'],$data['sat_date']);
				  $data['gross6'] = $this->Daily_forecasting_model->_getgross_sf6($data['f_sun_date'],$data['sun_date']);
				  $data['gross7'] = $this->Daily_forecasting_model->_getgross_sf7($data['f_mon_date'],$data['mon_date']);

				  $search = $this->input->get('search');
				  $data['search'] = $search;

				  $data['pm'] = $this->Daily_forecasting_model->_selectsf_u($data,$search);

				$data["content"] = 'summary_forecasted';
				$this->load->view('backend/template_pm', $data);
		
	}

	public function save_pending(){
		$startdate = $this->input->get('startdate');
		$enddate = $this->input->get('end_date');
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_enddate = $this->input->get('ref_end_date');
		$type = $this->input->get('type');
		
		$pending_id = $this->Daily_forecasting_model->savepending($startdate,$enddate,$ref_startdate,$ref_enddate,$type);

		if($pending_id > 0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b> Record was successfully saved.</b></div>');
			redirect('daily_forecasting/add');
		}

	}	

	public function add($msg=''){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result <= 0){
			$this->_pageNotFound();
			return;
		}
        
        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

        $data['css'] = array('redmond/jquery-ui-1.8.22.custom.css');
    	$data['jquery'] = array('datepicker/jquery-ui.js');

        $date_from = date('m-d-Y');
        $date_to = date('m-d-Y');
        
        $data['date_from'] = $date_from;	
		$data['date_to'] = $date_to;

		$data['result'] = $this->Daily_forecasting_model->selpending();

		$data['msg'] = $msg;		
		$data["content"] = 'daily_forecasting_range';
		$this->load->view('backend/template', $data);

	}

	public function tuesday($msg=''){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$starts = $this->input->get('startdate');
    	$ends = $this->input->get('end_date');

    	$data['datef_start'] = $starts;
    	$data['datef_end'] = $ends;

    	$type = $this->input->get('type');

    	if($starts=="" || $ends=="" || $type==""){
    		$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Choose date in Weekly Forecast first.</b></div>');
			redirect('daily_forecasting/add');
    	
    	}

    	if((!isset($type))){
			$this->_pageNotFound();
			return;
		}

    	if($type=="wf"){

    		$startdate = $this->input->get('startdate');
			$end_date = $this->input->get('end_date');

			if($result <= 0 || (!isset($startdate)) || (!isset($end_date))){
				$this->_pageNotFound();
				return;
			}

				$startdates = $startdate;

				$date_start = strtotime($startdates);
				$day = date("l", $date_start);

				$startdate = date("Y-m-d", strtotime($startdates . " -7 day"));
				$end_date = date("Y-m-d", strtotime($startdates . " -1 day"));

				// $data['wed_date'] = date("Y-m-d", strtotime($startdate . " +1 day"));
				// $data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
				// $data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
				// $data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
				// $data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
				// $data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));
				
				$result_r = $this->Daily_forecasting_model->_getavg_reference($startdate,$end_date);
				
				$results_r = "";

				foreach($result_r as $row){
					 if($row['qty']==""){
					 	$resulta_r = "0";
					 
					 }else{
					 	$resulta_r = $row['qty'];
					 
					 }

					 $results_r = $resulta_r;
				}

				$result_r = $results_r;
	
				// $result2 = $this->Daily_forecasting_model->_getforecast2_val($data['wed_date']);
				
				// $results2 = "";

				// foreach($result2 as $row){
				// 	 if($row['qty']==""){
				// 	 	$resulta2 = "0";
					 
				// 	 }else{
				// 	 	$resulta2 = $row['qty'];
					 
				// 	 }

				// 	 $results2 = $resulta2;
				// }

				// $result2 = $results2;

				// $result3 = $this->Daily_forecasting_model->_getforecast3_val($data['thurs_date']);
				
				// $results3 = "";

				// foreach($result3 as $row){
				// 	 if($row['qty']==""){
				// 	 	$resulta3 = "0";
					 
				// 	 }else{
				// 	 	$resulta3 = $row['qty'];
					 
				// 	 }
					 
				// 	 $results3 = $resulta3;
				// }

				// $result3 = $results3;

				// $result4 = $this->Daily_forecasting_model->_getforecast4_val($data['fri_date']);
				
				// $results4 = "";

				// foreach($result4 as $row){
				// 	 if($row['qty']==""){
				// 	 	$resulta4 = "0";
					 
				// 	 }else{
				// 	 	$resulta4 = $row['qty'];
					 
				// 	 }

				// 	 $results4 = $resulta4;
				// }

				// $result4 = $results4;

				// $result5 = $this->Daily_forecasting_model->_getforecast5_val($data['sat_date']);
				
				// $results5 = "";

				// foreach($result5 as $row){
				// 	 if($row['qty']==""){
				// 	 	$resulta5 = "0";
					 
				// 	 }else{
				// 	 	$resulta5 = $row['qty'];
					 
				// 	 }

				// 	 $results5 = $resulta5;
				// }

				// $result5 = $results5;	

				// $result6 = $this->Daily_forecasting_model->_getforecast6_val($data['sun_date']);
				
				// $results6 = "";

				// foreach($result6 as $row){
				// 	 if($row['qty']==""){
				// 	 	$resulta6 = "0";
					 
				// 	 }else{
				// 	 	$resulta6 = $row['qty'];
					 
				// 	 }

				// 	 $results6 = $resulta6;
				// }

				// $result6= $results6;

				// $result7 = $this->Daily_forecasting_model->_getforecast7_val($data['mon_date']);
				
				// $results7 = "";

				// foreach($result7 as $row){
				// 	 if($row['qty']==""){
				// 	 	$resulta7 = "0";
					 
				// 	 }else{
				// 	 	$resulta7 = $row['qty'];
					 
				// 	 }

				// 	 $results7 = $resulta7;
				// }

				// $result7 = $results7;
			
			$s_date = $this->input->get('startdate');
			$e_date = $this->input->get('end_date');
			
			$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($s_date);
			$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($e_date);

			if($result_r=="0"){
				
				$date_from = date('m-d-Y');
		        $date_to = date('m-d-Y');
		        
		        $data['date_from'] = $date_from;	
				$data['date_to'] = $date_to;

				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Your Reference Week was empty, choose other week.</b></div>');
				redirect('daily_forecasting/add');
			}

			$s_day = strtotime($s_date);
			$dayf = date("l", $s_day);

			if($dayf != "Tuesday"){
					$date_from = date('m-d-Y');
		        	$date_to = date('m-d-Y');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('m-d-Y');
		        	$date_to = date('m-d-Y');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');
						
						$ref_s = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
						$ref_e = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));

					//--tuesday--//
		    			
						$total_gross_dayone = $this->Daily_forecasting_model->_gettotalgross1($ref_s);
						$result_dayone= $this->Daily_forecasting_model->_getforecast1($ref_s);
						$this->Daily_forecasting_model->insert1($total_gross_dayone,$result_dayone,$data['datefs'],$ref_s);

		    			$total_gross_dayone1 = $total_gross_dayone = $this->Daily_forecasting_model->_getavg_totalgross($ref_s,$ref_e);
		    			$result_dayone1 = $this->Daily_forecasting_model->_getavg_forecast1($ref_s,$ref_e);

						$this->Daily_forecasting_model->update1($total_gross_dayone1,$result_dayone1,$data['datefs'],$ref_s);

					  	$data["firstdate_display_s"] = $ref_s;
					  	$data["firstdate_display_e"] = $ref_e;
					  	$data["f_firstdate_display"] = $data['datefs'];
					  	$data["firstday_display"] = $dayf;
					  	$data["gross"] = $total_gross_dayone;
					  	$data["forecasted_amount"] = $this->Daily_forecasting_model->day1fa($data['datefs'],$ref_s);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["tuesday"] = $this->Daily_forecasting_model->_selectAllDayOne($config['per_page'],$offset,$data['datefs'],$ref_s);

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/tuesday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday1($data['datefs'],$ref_s);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

     				$data["msg"] = $msg;	
					$data["content"] = 'tuesday';
					$this->load->view('backend/template', $data);
			}

    	}elseif($type=="wrf"){

    		     $startdate = $this->input->get('startdate');
			     $end_date = $this->input->get('end_date');

			     $ref_startdate = $this->input->get('ref_startdate');
			     $ref_end_date = $this->input->get('ref_end_date');

				if($result <= 0 || (!isset($startdate)) || (!isset($end_date)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
				
				}

				if($ref_startdate > $startdate){
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Make sure your weekly reference was not ahead in your weekly forecast.</b></div>');
				redirect('daily_forecasting/add');					
				
				}
				
				$startdates = $startdate;

				$date_start = strtotime($startdates);
				$day = date("l", $date_start);

				// $data['wed_date'] = date("Y-m-d", strtotime($ref_startdate . " +1 day"));
				// $data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
				// $data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
				// $data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
				// $data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
				// $data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));
				
				$result_r = $this->Daily_forecasting_model->_getavg_reference($ref_startdate,$ref_end_date);
				
				$results_r = "";

				foreach($result_r as $row){
					 if($row['qty']==""){
					 	$resulta_r = "0";
					 
					 }else{
					 	$resulta_r = $row['qty'];
					 
					 }

					 $results_r = $resulta_r;
				}

				$result_r = $results_r;
			
			if($result_r=="0"){
				
				$date_from = date('m-d-Y');
		        $date_to = date('m-d-Y');
		        
		        $data['date_from'] = $date_from;	
				$data['date_to'] = $date_to;

				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Your Reference Week was empty, choose other week.</b></div>');
				redirect('daily_forecasting/add');
			}

				$s_date = $this->input->get('startdate');
			    $e_date = $this->input->get('end_date');

				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($s_date);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($e_date);

				$dates = strtotime($s_date);
				$days = date("l", $dates);

				if($days != "Tuesday"){
					$date_from = date('m-d-Y');
		        	$date_to = date('m-d-Y');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
				
				}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('m-d-Y');
		        	$date_to = date('m-d-Y');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

				 }else{

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');
						
					//--tuesday--//
		    			
		    			$total_gross_dayone = $this->Daily_forecasting_model->_gettotalgross1($data['ref_sdate']);
		    			$result_dayone= $this->Daily_forecasting_model->_getforecast1($data['ref_sdate']);
		    			$this->Daily_forecasting_model->insert1($total_gross_dayone,$result_dayone,$data['datefs'],$data['ref_sdate']);

		    			$total_gross_dayone1 = $this->Daily_forecasting_model->_getavg_totalgross($data['ref_sdate'],$data['ref_edate']);
		    			$result_dayone1 = $this->Daily_forecasting_model->_getavg_forecast1($data['ref_sdate'],$data['ref_edate']);

						$this->Daily_forecasting_model->update1($total_gross_dayone1,$result_dayone1,$data['datefs'],$data['ref_sdate']);

					  	$data["firstdate_display"] = $data['ref_sdate'];
					  	// $data["firstdate_display_e"] = $data['ref_edate'];
					  	$data["f_firstdate_display"] = $data['datefs'];
					  	$data["firstday_display"] = $days;
					  	$data["gross"] = $total_gross_dayone;
					  	$data["forecasted_amount"] = $this->Daily_forecasting_model->day1fa($data['datefs'],$data['ref_sdate']);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["tuesday"] = $this->Daily_forecasting_model->_selectAllDayOne($config['per_page'],$offset,$data['datefs'],$data['ref_sdate']);

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/tuesday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday1($data['datefs'],$data['ref_sdate']);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

     				$data["msg"] = $msg;	
					$data["content"] = 'tuesday';
					$this->load->view('backend/template', $data);	
    			
    			}
    		
    		}		
				
	}

	public function wednesday(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$startdates = $datef_start;

				$date_start = strtotime($startdates);
				$day = date("l", $date_start);
				
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');		
						
						if($type=="wf"){
						  $ref_s = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
						  $ref_e = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));
						  $wed_date = date("Y-m-d", strtotime($data['datefs'] . " -6 day"));

						}else{
						 
						  $wed_date = date("Y-m-d", strtotime($data['ref_sdate'] . " +1 day"));
						  $ref_s = $data['ref_sdate'];
						  $ref_e = $data['ref_edate'];	

						}
						 
						$date_wed = date("Y-m-d", strtotime($data['datefs'] . " +1 day"));


					//--wednesday--//
				  		$total_gross_daytwo = $this->Daily_forecasting_model->_gettotalgross2($wed_date);
	    				$result_daytwo = $this->Daily_forecasting_model->_getforecast2($wed_date);
	    				$this->Daily_forecasting_model->insert2($total_gross_daytwo,$result_daytwo,$date_wed,$wed_date);
						
						$total_gross_daytwo2 = $this->Daily_forecasting_model->_getavg_totalgross($ref_s,$ref_e);
		    			$result_daytwo2 = $this->Daily_forecasting_model->_getavg_forecast1($ref_s,$ref_e);
						
						$this->Daily_forecasting_model->update2($total_gross_daytwo2,$result_daytwo2,$date_wed,$wed_date);


						// $data["seconddate_display"] = $r;

						$data["seconddate_display"] = $wed_date;
						
						$data["f_seconddate_display"] = $date_wed;
						$seconddate = strtotime($date_wed);
						$day2 = date("l", $seconddate);
						$data["secondday_display"] = $day2;
						$data["gross"] = $total_gross_daytwo;
						$data["forecasted_amount2"] = $this->Daily_forecasting_model->day2fa($date_wed,$wed_date);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["wednesday"] = $this->Daily_forecasting_model->_selectAllDayTwo($config['per_page'],$offset,$date_wed,$wed_date);	

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/wednesday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday2($date_wed,$wed_date);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

					$data["content"] = 'wednesday';
					$this->load->view('backend/template', $data);
			}		
				
	}

	public function thursday(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($datef_start);
				$day = date("l", $date_start);
					
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{	

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');			

						if($type=="wf"){
						  $thurs_date = date("Y-m-d", strtotime($data['datefs'] . " -5 day"));
						  $ref_s = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
						  $ref_e = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));
						  	
						}else{
						  $thurs_date = date("Y-m-d", strtotime($data['ref_sdate'] . " +2 day"));
						  $ref_s = $data['ref_sdate'];
						  $ref_e = $data['ref_edate'];	

						}
						 
						$date_thurs = date("Y-m-d", strtotime($data['datefs'] . " +2 day"));
						 			
					//--thursday--//
				  		
				  		$total_gross_daythree = $this->Daily_forecasting_model->_gettotalgross3($thurs_date);
		    		    $result_daythree = $this->Daily_forecasting_model->_getforecast3($thurs_date);
						$this->Daily_forecasting_model->insert3($total_gross_daythree,$result_daythree,$date_thurs,$thurs_date);
						

						$total_gross_daythree3 = $this->Daily_forecasting_model->_getavg_totalgross($ref_s,$ref_e);
		    			$result_daythree3 = $this->Daily_forecasting_model->_getavg_forecast1($ref_s,$ref_e);
						$this->Daily_forecasting_model->update3($total_gross_daythree3,$result_daythree3,$date_thurs,$thurs_date);


						$data["thirddate_display"] = $thurs_date;
					  	// $data["thirddate_display_e"] = $ref_e;
						$data["f_thirddate_display"] = $date_thurs;
						$thirddate = strtotime($date_thurs);
						$day3 = date("l", $thirddate);
						$data["thirdday_display"] = $day3;
						$data["gross"] = $total_gross_daythree;
						$data["forecasted_amount3"] = $this->Daily_forecasting_model->day3fa($date_thurs,$thurs_date);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["thursday"] = $this->Daily_forecasting_model->_selectAllDayThree($config['per_page'],$offset,$date_thurs,$thurs_date);

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/thursday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday3($date_thurs,$thurs_date);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

					$data["content"] = 'thursday';
					$this->load->view('backend/template', $data);
			}		
				
	}

	public function friday(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($datef_start);
				$day = date("l", $date_start);
					
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{	

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');		

						if($type=="wf"){
						  $ref_s = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
						  $ref_e = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));
						  $fri_date = date("Y-m-d", strtotime($data['datefs'] . " -4 day"));

						}else{
						  
						  $fri_date = date("Y-m-d", strtotime($data['ref_sdate'] . " +3 day"));
						  $ref_s = $data['ref_sdate'];
						  $ref_e = $data['ref_edate'];	

						}
						 
						$date_fri = date("Y-m-d", strtotime($data['datefs'] . " +3 day"));
 			
					//--thursday--//
				  		
				  		$total_gross_dayfour = $this->Daily_forecasting_model->_gettotalgross4($fri_date);
		    			$result_dayfour = $this->Daily_forecasting_model->_getforecast4($fri_date);
		    			$this->Daily_forecasting_model->insert4($total_gross_dayfour,$result_dayfour,$date_fri,$fri_date);

						$total_gross_dayfour4 = $this->Daily_forecasting_model->_getavg_totalgross($ref_s,$ref_e);
		    			$result_dayfour4 = $this->Daily_forecasting_model->_getavg_forecast1($ref_s,$ref_e);
		    			$this->Daily_forecasting_model->update4($total_gross_dayfour4,$result_dayfour4,$date_fri,$fri_date);
			
						$data["fourthdate_display"] = $fri_date;
					  	
					  	// $data["fourthdate_display_e"] = $ref_e;
						$data["f_fourthdate_display"] = $date_fri;
						$fourthdate = strtotime($date_fri);
						$day4 = date("l", $fourthdate);
						$data["fourthday_display"] = $day4;
						$data["gross"] = $total_gross_dayfour;
						$data["forecasted_amount4"] = $this->Daily_forecasting_model->day4fa($date_fri,$fri_date);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["friday"] = $this->Daily_forecasting_model->_selectAllDayFour($config['per_page'],$offset,$date_fri,$fri_date);

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/friday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday4($date_fri,$fri_date);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

					$data["content"] = 'friday';
					$this->load->view('backend/template', $data);
			}		
				
	}

	public function saturday(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($datef_start);
				$day = date("l", $date_start);
					
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{	

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');			

						if($type=="wf"){
						  $ref_s = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
						  $ref_e = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));
						  $sat_date = date("Y-m-d", strtotime($data['datefs'] . " -3 day"));

						}else{
						  $sat_date = date("Y-m-d", strtotime($data['ref_sdate'] . " +4 day"));
						  $ref_s = $data['ref_sdate'];
						  $ref_e = $data['ref_edate'];	

						}

						 
						$date_sat = date("Y-m-d", strtotime($data['datefs'] . " +4 day"));

					//--saturday--//
				  		$total_gross_dayfive = $this->Daily_forecasting_model->_gettotalgross5($sat_date);
	    				$result_dayfive = $this->Daily_forecasting_model->_getforecast5($sat_date);
						$this->Daily_forecasting_model->insert5($total_gross_dayfive,$result_dayfive,$date_sat,$sat_date);
						
						$total_gross_dayfive5 = $this->Daily_forecasting_model->_getavg_totalgross($ref_s,$ref_e);
		    			$result_dayfive5 = $this->Daily_forecasting_model->_getavg_forecast1($ref_s,$ref_e);
						$this->Daily_forecasting_model->update5($total_gross_dayfive5,$result_dayfive5,$date_sat,$sat_date);

						$data["fifthdate_display"] = $sat_date;
					  	// $data["fifthdate_display_e"] = $ref_e;
						$data["f_fifthdate_display"] = $date_sat;
						$fifthdate = strtotime($date_sat);
						$day5 = date("l", $fifthdate);
						$data["fifthday_display"] = $day5;
						$data["gross"] = $total_gross_dayfive;
						$data["forecasted_amount5"] = $this->Daily_forecasting_model->day5fa($date_sat,$sat_date);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["saturday"] = $this->Daily_forecasting_model->_selectAllDayFive($config['per_page'],$offset,$date_sat,$sat_date);

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/saturday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday5($date_sat,$sat_date);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

					$data["content"] = 'saturday';
					$this->load->view('backend/template', $data);
			}		
				
	}

	public function sunday(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($datef_start);
				$day = date("l", $date_start);
					
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{	

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');				

						if($type=="wf"){
						  $ref_s = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
						  $ref_e = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));
						  $sun_date = date("Y-m-d", strtotime($data['datefs'] . " -2 day"));
						  	
						}else{
						  $sun_date = date("Y-m-d", strtotime($data['ref_sdate'] . " +5 day"));
						  $ref_s = $data['ref_sdate'];
						  $ref_e = $data['ref_edate'];	

						}
						 
						$date_sun = date("Y-m-d", strtotime($data['datefs'] . " +5 day"));

					//--sunday--//
				  		$total_gross_daysix = $this->Daily_forecasting_model->_gettotalgross6($sun_date);
		    			$result_daysix = $this->Daily_forecasting_model->_getforecast6($sun_date);
						$this->Daily_forecasting_model->insert6($total_gross_daysix,$result_daysix,$date_sun,$sun_date);
						
						$total_gross_daysix6 = $this->Daily_forecasting_model->_getavg_totalgross($ref_s,$ref_e);
		    			$result_daysix6 = $this->Daily_forecasting_model->_getavg_forecast1($ref_s,$ref_e);
						$this->Daily_forecasting_model->update6($total_gross_daysix6,$result_daysix6,$date_sun,$sun_date);

						$data["sixthdate_display"] = $sun_date;
					  	// $data["sixthdate_display_e"] = $ref_e;
						$data["f_sixthdate_display"] = $date_sun;
						$sixthdate = strtotime($date_sun);
						$day6 = date("l", $sixthdate);
						$data["sixthday_display"] = $day6;
						$data["gross"] = $total_gross_daysix;
						$data["forecasted_amount6"] = $this->Daily_forecasting_model->day6fa($date_sun,$sun_date);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["sunday"] = $this->Daily_forecasting_model->_selectAllDaySix($config['per_page'],$offset,$date_sun,$sun_date);

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/sunday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday6($date_sun,$sun_date);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

					$data["content"] = 'sunday';
					$this->load->view('backend/template', $data);
			}		
				
	}

	public function monday(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($datef_start);
				$day = date("l", $date_start);
		
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{	

						$data['datefs'] = $this->input->get('startdate');
						$data['datefe'] = $this->input->get('end_date');
						$data['ref_sdate'] = $this->input->get('ref_startdate');
						$data['ref_edate'] = $this->input->get('ref_end_date');				

						if($type=="wf"){
						  $ref_s = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
						  $ref_e = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));
						  $mon_date = date("Y-m-d", strtotime($data['datefs'] . " -1 day"));

						}else{
						  $mon_date = date("Y-m-d", strtotime($data['ref_sdate'] . " +6 day"));
						  $ref_s = $data['ref_sdate'];
						  $ref_e = $data['ref_edate'];	

						}
						 
						$date_mon = date("Y-m-d", strtotime($data['datefs'] . " +6 day"));		

					//--monday--//
				  		$total_gross_dayseven = $this->Daily_forecasting_model->_gettotalgross7($mon_date);
		    			$result_dayseven = $this->Daily_forecasting_model->_getforecast7($mon_date);
		    			$this->Daily_forecasting_model->insert7($total_gross_dayseven,$result_dayseven,$date_mon,$mon_date);
						
						$total_gross_dayseven7 = $this->Daily_forecasting_model->_getavg_totalgross($ref_s,$ref_e);
		    			$result_dayseven7 = $this->Daily_forecasting_model->_getavg_forecast1($ref_s,$ref_e);
						$this->Daily_forecasting_model->update7($total_gross_dayseven7,$result_dayseven7,$date_mon,$mon_date);

						$data["seventhdate_display"] = $mon_date;
					  	// $data["seventhdate_display_e"] = $ref_e;
						$data["f_seventhdate_display"] = $date_mon;
						$seventhdate = strtotime($date_mon);
						$day7 = date("l", $seventhdate);
						$data["seventhday_display"] = $day7;
						$data["gross"] = $total_gross_dayseven;
						$data["forecasted_amount7"] = $this->Daily_forecasting_model->day7fa($date_mon,$mon_date);

					  	$offset = (int)$this->input->get('per_page');
						$config["per_page"] = 100;

						$data["monday"] = $this->Daily_forecasting_model->_selectAllDaySeven($config['per_page'],$offset,$date_mon,$mon_date);

						$this->load->library('pagination');
						$config['base_url'] = base_url('daily_forecasting/monday?startdate='.$data['datefs'].'&end_date='.$data['datefe'].'&ref_startdate='.$data['ref_sdate'].'&ref_end_date='.$data['ref_edate'].'&type='.$type);
						$config['total_rows'] = $this->Daily_forecasting_model->countday7($date_mon,$mon_date);
      					$config['page_query_string'] = TRUE;

      					$config['full_tag_open'] = "<ul class='pagination'>";
						$config['full_tag_close'] ="</ul>";
						$config['num_tag_open'] = '<li>';
						$config['num_tag_close'] = '</li>';
						$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
						$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
						$config['next_tag_open'] = "<li>";
						$config['next_tagl_close'] = "</li>";
						$config['prev_tag_open'] = "<li>";
						$config['prev_tagl_close'] = "</li>";
						$config['first_tag_open'] = "<li>";
						$config['first_tagl_close'] = "</li>";
						$config['last_tag_open'] = "<li>";
						$config['last_tagl_close'] = "</li>";

     					$this->pagination->initialize($config);
     				 	$data["links"] = $this->pagination->create_links();

					$data["content"] = 'monday';
					$this->load->view('backend/template', $data);
			}		
				
	}

	public function summary_forecast(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($datef_start);
				$day = date("l", $date_start);
					
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{	
				$data['datefs'] = $this->input->get('startdate');
				$data['datefe'] = $this->input->get('end_date');
				$data['ref_sdate'] = $this->input->get('ref_startdate');
				$data['ref_edate'] = $this->input->get('ref_end_date');	

					$data['f_tues_date'] = $data['datefs'];
					$data['f_wed_date'] = date("Y-m-d", strtotime($data['f_tues_date'] . " +1 day"));
					$data['f_thurs_date'] = date("Y-m-d", strtotime($data['f_wed_date'] . " +1 day"));
					$data['f_fri_date'] = date("Y-m-d", strtotime($data['f_thurs_date'] . " +1 day"));
					$data['f_sat_date'] = date("Y-m-d", strtotime($data['f_fri_date'] . " +1 day"));
					$data['f_sun_date'] = date("Y-m-d", strtotime($data['f_sat_date'] . " +1 day"));
					$data['f_mon_date'] = date("Y-m-d", strtotime($data['f_sun_date'] . " +1 day"));

				if($type == "wf"){
					$data['tues_date'] = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
					$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
					$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
					$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
					$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
					$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
					$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

				}else{
					$data['tues_date'] = $data['ref_sdate'];
					$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
					$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
					$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
					$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
					$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
					$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

				}	

				  $data['gross1'] = $this->Daily_forecasting_model->_getgross_sf1($data['f_tues_date'],$data['tues_date']);
				  $data['gross2'] = $this->Daily_forecasting_model->_getgross_sf2($data['f_wed_date'],$data['wed_date']);
				  $data['gross3'] = $this->Daily_forecasting_model->_getgross_sf3($data['f_thurs_date'],$data['thurs_date']);
				  $data['gross4'] = $this->Daily_forecasting_model->_getgross_sf4($data['f_fri_date'],$data['fri_date']);
				  $data['gross5'] = $this->Daily_forecasting_model->_getgross_sf5($data['f_sat_date'],$data['sat_date']);
				  $data['gross6'] = $this->Daily_forecasting_model->_getgross_sf6($data['f_sun_date'],$data['sun_date']);
				  $data['gross7'] = $this->Daily_forecasting_model->_getgross_sf7($data['f_mon_date'],$data['mon_date']);

				  $search = $this->input->get('search');
				  $data['search'] = $search;
				  $data['pm'] = $this->Daily_forecasting_model->_selectsf($data,$search);

				$data["content"] = 'summary_forecast';
				$this->load->view('backend/template_pm', $data);

			}
		
	}

	public function product_mixed(){
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

			if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
				$this->_pageNotFound();
				return;
			}

				$date_start = strtotime($datef_start);
				$day = date("l", $date_start);
					
				$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($datef_start);
				$enddate_exist = $this->Daily_forecasting_model->check_if_enddataExist($datef_end);

			if($day != "Tuesday"){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$msg = '<div class="alert-box error"><span class="alert_title"> error : </span><b> Make sure your choose start-date was Tuesday. </b></div>';
				
					$data['msg'] = $msg;		
					$data["content"] = 'daily_forecasting_range';
					$this->load->view('backend/template', $data);
			
			}elseif($startdate_exist > 0 && $enddate_exist > 0){
					$date_from = date('Y-m-d');
		        	$date_to = date('Y-m-d');
		        
		        	$data['date_from'] = $date_from;	
					$data['date_to'] = $date_to;

					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
					redirect('daily_forecasting/add');

			}else{	
				$data['datefs'] = $this->input->get('startdate');
				$data['datefe'] = $this->input->get('end_date');
				$data['ref_sdate'] = $this->input->get('ref_startdate');
				$data['ref_edate'] = $this->input->get('ref_end_date');	

				if($type=="wf"){

					$data['tues_date'] = date("Y-m-d", strtotime($data['datefs'] . " -7 day"));
					$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
					$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
					$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
					$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
					$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
					$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

				}else{

					$data['tues_date'] = $data['ref_sdate'];
					$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
					$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
					$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
					$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
					$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
					$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

				}
					$data['f_tues_date'] = $data['datefs'];
					$data['f_wed_date'] = date("Y-m-d", strtotime($data['f_tues_date'] . " +1 day"));
					$data['f_thurs_date'] = date("Y-m-d", strtotime($data['f_wed_date'] . " +1 day"));
					$data['f_fri_date'] = date("Y-m-d", strtotime($data['f_thurs_date'] . " +1 day"));
					$data['f_sat_date'] = date("Y-m-d", strtotime($data['f_fri_date'] . " +1 day"));
					$data['f_sun_date'] = date("Y-m-d", strtotime($data['f_sat_date'] . " +1 day"));
					$data['f_mon_date'] = date("Y-m-d", strtotime($data['f_sun_date'] . " +1 day"));

					$data['gross1'] = $this->Daily_forecasting_model->_gettotalgross1($data['tues_date']);
					$result_dayone = $this->Daily_forecasting_model->_getforecast1($data['tues_date']);
					$this->Daily_forecasting_model->insert1_pm($result_dayone,$data['f_tues_date'],$data['tues_date']);

					$data['gross2'] = $this->Daily_forecasting_model->_gettotalgross2($data['wed_date']);
					$result_daytwo = $this->Daily_forecasting_model->_getforecast2($data['wed_date']);
					$this->Daily_forecasting_model->insert2_pm($result_daytwo,$data['f_wed_date'],$data['wed_date']);

					$data['gross3'] = $this->Daily_forecasting_model->_gettotalgross3($data['thurs_date']);
					$result_daythree = $this->Daily_forecasting_model->_getforecast3($data['thurs_date']);
					$this->Daily_forecasting_model->insert3_pm($result_daythree,$data['f_thurs_date'],$data['thurs_date']);

					$data['gross4'] = $this->Daily_forecasting_model->_gettotalgross4($data['fri_date']);
					$result_dayfour = $this->Daily_forecasting_model->_getforecast4($data['fri_date']);
					$this->Daily_forecasting_model->insert4_pm($result_dayfour,$data['f_fri_date'],$data['fri_date']);

					$data['gross5'] = $this->Daily_forecasting_model->_gettotalgross5($data['sat_date']);
					$result_dayfive = $this->Daily_forecasting_model->_getforecast5($data['sat_date']);
					$this->Daily_forecasting_model->insert5_pm($result_dayfive,$data['f_sat_date'],$data['sat_date']);

					$data['gross6'] = $this->Daily_forecasting_model->_gettotalgross6($data['sun_date']);
					$result_daysix = $this->Daily_forecasting_model->_getforecast6($data['sun_date']);
					$this->Daily_forecasting_model->insert6_pm($result_daysix,$data['f_sun_date'],$data['sun_date']);

					$data['gross7'] = $this->Daily_forecasting_model->_gettotalgross7($data['mon_date']);
					$result_dayseven = $this->Daily_forecasting_model->_getforecast7($data['mon_date']);
					$this->Daily_forecasting_model->insert7_pm($result_dayseven,$data['f_mon_date'],$data['mon_date']);

					$search = $this->input->get('search');
				  	$data['search'] = $search;

					$data['pm'] = $this->Daily_forecasting_model->_selectpm($data,$search);

				$data["content"] = 'product_mixed';
				$this->load->view('backend/template', $data);

			}
		
	}

	public function print_product_mixed(){

		$branch = $this->session->userdata('branch');
		
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$datef_start = $this->input->get('startdate');
		$datef_end = $this->input->get('end_date');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

		if($result <= 0 || (!isset($datef_start)) || (!isset($datef_end)) || (!isset($ref_startdate)) || (!isset($ref_end_date))){
			$this->_pageNotFound();
			return;
		}
		
			if($type=="wf"){

				$data['tues_date'] = date("Y-m-d", strtotime($datef_start . " -7 day"));
				$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
				$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
				$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
				$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
				$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
				$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

			}else{

				$data['tues_date'] = $ref_startdate;
				$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
				$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
				$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
				$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
				$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
				$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

			}
				$data['f_tues_date'] = $datef_start;
				$data['f_wed_date'] = date("Y-m-d", strtotime($data['f_tues_date'] . " +1 day"));
				$data['f_thurs_date'] = date("Y-m-d", strtotime($data['f_wed_date'] . " +1 day"));
				$data['f_fri_date'] = date("Y-m-d", strtotime($data['f_thurs_date'] . " +1 day"));
				$data['f_sat_date'] = date("Y-m-d", strtotime($data['f_fri_date'] . " +1 day"));
				$data['f_sun_date'] = date("Y-m-d", strtotime($data['f_sat_date'] . " +1 day"));
				$data['f_mon_date'] = date("Y-m-d", strtotime($data['f_sun_date'] . " +1 day"));	

			$gross1 = round($this->Daily_forecasting_model->_gettotalgross1($data['tues_date']),0);
			$gross2 = round($this->Daily_forecasting_model->_gettotalgross1($data['wed_date']),0);
			$gross3 = round($this->Daily_forecasting_model->_gettotalgross1($data['thurs_date']),0);
			$gross4 = round($this->Daily_forecasting_model->_gettotalgross1($data['fri_date']),0);
			$gross5 = round($this->Daily_forecasting_model->_gettotalgross1($data['sat_date']),0);
			$gross6 = round($this->Daily_forecasting_model->_gettotalgross1($data['sun_date']),0);
			$gross7 = round($this->Daily_forecasting_model->_gettotalgross1($data['mon_date']),0);

			$data["gross1"] = $gross1;
			$data["gross2"] = $gross2;
			$data["gross3"] = $gross3;
			$data["gross4"] = $gross4;
			$data["gross5"] = $gross5;
			$data["gross6"] = $gross6;
			$data["gross7"] = $gross7;

		$split = explode("-", $data['tues_date']);
		$date1 = $split[1] . '/' . $split[2] . '/' . $split[0];
		$data['date1'] = $date1;

		$split1 = explode("-", $data['wed_date']);
		$date2 = $split1[1] . '/' . $split1[2] . '/' . $split1[0];
		$data['date2'] = $date2;

		$split2 = explode("-", $data['thurs_date']);
		$date3 = $split2[1] . '/' . $split2[2] . '/' . $split2[0];
		$data['date3'] = $date3;

		$split3 = explode("-", $data['fri_date']);
		$date4 = $split3[1] . '/' . $split3[2] . '/' . $split3[0];
		$data['date4'] = $date4;

		$split4 = explode("-", $data['sat_date']);
		$date5 = $split4[1] . '/' . $split4[2] . '/' . $split4[0];
		$data['date5'] = $date5;

		$split5 = explode("-", $data['sun_date']);
		$date6 = $split5[1] . '/' . $split5[2] . '/' . $split5[0];
		$data['date6'] = $date6;

		$split6 = explode("-", $data['mon_date']);
		$date7 = $split6[1] . '/' . $split6[2] . '/' . $split6[0];
		$data['date7'] = $date7;

		$results = $this->Daily_forecasting_model->_selectpm_forprint($data);

	    // $this->load->helper('download');

	
	    if(count($results)>0){
		
		// $myFile = "./excel_files/product_mix/Product_Mix(Reference).xls";
  //       $this->load->library('parser');
 
  //       //load required data from database
  //       // $userDetails = $this->model_details->getUserDetails();
  //       $data['pm'] = $results;
 
  //       //pass retrieved data into template and return as a string
  //       $stringData = $this->parser->parse('excel_template/details_csv', $data, true);
 
  //       //open excel and write string into excel
  //       $fh = fopen($myFile, 'w') or die("can't open file");
  //       fwrite($fh, $stringData);
 
  //       fclose($fh);
  //       //download excel file
  //       // $this->downloadExcel();

  //       $myFile = "./excel_files/product_mix/Product_Mix(Reference).xls";
  //       header("Content-Length: " . filesize($myFile));
  //       header('Content-Type: application/vnd.ms-excel');
  //       header('Content-Disposition: attachment; filename=Product_Mix(Reference).xls');
 
  //       readfile($myFile);

	    	//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', '');
		$this->excel->getActiveSheet()->setCellValue('B1', '');
		$this->excel->getActiveSheet()->setCellValue('C1', $date1);
		$this->excel->getActiveSheet()->setCellValue('D1', $date2);
		$this->excel->getActiveSheet()->setCellValue('E1', $date3);
		$this->excel->getActiveSheet()->setCellValue('F1', $date4);
		$this->excel->getActiveSheet()->setCellValue('G1', $date5);
		$this->excel->getActiveSheet()->setCellValue('H1', $date6);
		$this->excel->getActiveSheet()->setCellValue('I1', $date7);

		$this->excel->getActiveSheet()->setCellValue('A2', '');
		$this->excel->getActiveSheet()->setCellValue('B2', '');
		$this->excel->getActiveSheet()->setCellValue('C2', $gross1);
		$this->excel->getActiveSheet()->setCellValue('D2', $gross2);
		$this->excel->getActiveSheet()->setCellValue('E2', $gross3);
		$this->excel->getActiveSheet()->setCellValue('F2', $gross4);
		$this->excel->getActiveSheet()->setCellValue('G2', $gross5);
		$this->excel->getActiveSheet()->setCellValue('H2', $gross6);
		$this->excel->getActiveSheet()->setCellValue('I2', $gross7);

		$this->excel->getActiveSheet()->setCellValue('A3', 'MATERIAL');
		$this->excel->getActiveSheet()->setCellValue('B3', 'MENU ITEMS');
		$this->excel->getActiveSheet()->setCellValue('C3', '');
		$this->excel->getActiveSheet()->setCellValue('D3', '');
		$this->excel->getActiveSheet()->setCellValue('E3', '');
		$this->excel->getActiveSheet()->setCellValue('F3', '');
		$this->excel->getActiveSheet()->setCellValue('G3', '');
		$this->excel->getActiveSheet()->setCellValue('H3', '');
		$this->excel->getActiveSheet()->setCellValue('I3', '');

		$ctr = '4';
		foreach($results as $row){
			
			$split1 = str_split($row['dayone']);
			$split2 = str_split($row['daytwo']);
			$split3 = str_split($row['daythree']);
			$split4 = str_split($row['dayfour']);
			$split5 = str_split($row['dayfive']);	
			$split6 = str_split($row['daysix']);
			$split7 = str_split($row['dayseven']);
			
			if($split1[0]=="-"){
				$row['dayone']="0";
			}else{
				round($row['dayone'],0);
			}

			if($split1[0]==""){
				$row['dayone']="0";
			}else{
				round($row['dayone'],0);
			}

			if($split2[0]=="-"){
				$row['daytwo']="0";
			}else{
				round($row['daytwo'],0);
			}

			if($split2[0]==""){
				$row['daytwo']="0";
			}else{
				round($row['daytwo'],0);
			}

			if($split3[0]=="-"){
				$row['daythree']="0";
			}else{
				round($row['daythree'],0);
			}

			if($split3[0]==""){
				$row['daythree']="0";
			}else{
				round($row['daythree'],0);
			}

			if($split4[0]=="-"){
				$row['dayfour']="0";
			}else{
				round($row['dayfour'],0);
			}

			if($split4[0]==""){
				$row['dayfour']="0";
			}else{
				round($row['dayfour'],0);
			}

			if($split5[0]=="-"){
				$row['dayfive']="0";
			}else{
				round($row['dayfive'],0);
			}

			if($split5[0]==""){
				$row['dayfive']="0";
			}else{
				round($row['dayfive'],0);
			}

			if($split6[0]=="-"){
				$row['daysix']="0";
			}else{
				round($row['daysix'],0);
			}

			if($split6[0]==""){
				$row['daysix']="0";
			}else{
				round($row['daysix'],0);
			}

			if($split7[0]=="-"){
				$row['dayseven']="0";
			}else{
				round($row['dayseven'],0);
			}

			if($split7[0]==""){
				$row['dayseven']="0";
			}else{
				round($row['dayseven'],0);
			}

			$this->excel->getActiveSheet()->setCellValue('A'.$ctr, $row['sapcode']);
			$this->excel->getActiveSheet()->setCellValue('B'.$ctr, $row['desc']);
			$this->excel->getActiveSheet()->setCellValue('C'.$ctr, $row['dayone']);
			$this->excel->getActiveSheet()->setCellValue('D'.$ctr, $row['daytwo']);
			$this->excel->getActiveSheet()->setCellValue('E'.$ctr, $row['daythree']);
			$this->excel->getActiveSheet()->setCellValue('F'.$ctr, $row['dayfour']);
			$this->excel->getActiveSheet()->setCellValue('G'.$ctr, $row['dayfive']);
			$this->excel->getActiveSheet()->setCellValue('H'.$ctr, $row['daysix']);
			$this->excel->getActiveSheet()->setCellValue('I'.$ctr, $row['dayseven']);

			$ctr++;

		}

		// //merge cell A1 until D1
		// // $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$filename=$branch.'_'.$date1.'_TO_'.$date7.'(Reference).xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

	
			}else{
				echo '
				<script>
					alert("Invalid! No record for reference.");
					javascript:history.back()
				</script>
				';
			}

	}

//------------------------------for dayone

	public function update1(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayone_date');
		$ref_date = $this->input->post('dayone_ref_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;
			$data["ref_date"] = $ref_date;

			$this->Daily_forecasting_model->_updatefa1($data);		
			$update_result = $this->Daily_forecasting_model->_processfa1($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo1(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');
		
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo1($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/tuesday?startdate=' . $startdate . '&end_date=' . $end_date . '&ref_startdate=' . $ref_startdate . '&ref_end_date=' . $ref_end_date . '&type=' . $type);	
					
		}

	}

	public function u_update1(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayone_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;

			$this->Daily_forecasting_model->_updatefa1($data);		
			$update_result = $this->Daily_forecasting_model->_processfa1($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo1(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo1($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/tuesday_forecast?start=' . $startdate . '&end=' . $end_date . '&version=' . $version);
		}

	}

//-------------------------------for daytwo

	public function update2(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('daytwo_date');
		$ref_date = $this->input->post('daytwo_ref_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;
			$data["ref_date"] = $ref_date;

			$this->Daily_forecasting_model->_updatefa2($data);		
			$update_result = $this->Daily_forecasting_model->_processfa2($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo2(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');
		
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');
		
		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo2($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/wednesday?startdate=' . $startdate . '&end_date=' . $end_date . '&ref_startdate=' . $ref_startdate . '&ref_end_date=' . $ref_end_date . '&type=' . $type);	
		
		}

	}

	public function u_update2(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('daytwo_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;

			$this->Daily_forecasting_model->_updatefa2($data);		
			$update_result = $this->Daily_forecasting_model->_processfa2($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo2(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo2($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/wednesday_forecast?start=' . $startdate . '&end=' . $end_date . '&version=' . $version);
		}

	}		

//-------------------------------for daythree

	public function update3(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('daythree_date');
		$ref_date = $this->input->post('daythree_ref_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;
			$data["ref_date"] = $ref_date;

			$this->Daily_forecasting_model->_updatefa3($data);		
			$update_result = $this->Daily_forecasting_model->_processfa3($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo3(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');
		
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo3($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/thursday?startdate=' . $startdate . '&end_date=' . $end_date . '&ref_startdate=' . $ref_startdate . '&ref_end_date=' . $ref_end_date . '&type=' . $type);	
		
		}

	}

	public function u_update3(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('daythree_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;

			$this->Daily_forecasting_model->_updatefa3($data);		
			$update_result = $this->Daily_forecasting_model->_processfa3($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo3(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo3($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/thursday_forecast?start=' . $startdate . '&end=' . $end_date . '&version=' . $version);
		}

	}

//-------------------------------for dayfour

	public function update4(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayfour_date');
		$ref_date = $this->input->post('dayfour_ref_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;
			$data["ref_date"] = $ref_date;

			$this->Daily_forecasting_model->_updatefa4($data);		
			$update_result = $this->Daily_forecasting_model->_processfa4($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo4(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');
		
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo4($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/friday?startdate=' . $startdate . '&end_date=' . $end_date . '&ref_startdate=' . $ref_startdate . '&ref_end_date=' . $ref_end_date . '&type=' . $type);	
		
		}

	}

	public function u_update4(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayfour_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;

			$this->Daily_forecasting_model->_updatefa4($data);		
			$update_result = $this->Daily_forecasting_model->_processfa4($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo4(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo4($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/friday_forecast?start=' . $startdate . '&end=' . $end_date . '&version=' . $version);
		}

	}

//-------------------------------for dayfive

	public function update5(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayfive_date');
		$ref_date = $this->input->post('dayfive_ref_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;
			$data["ref_date"] = $ref_date;

			$this->Daily_forecasting_model->_updatefa5($data);		
			$update_result = $this->Daily_forecasting_model->_processfa5($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo5(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');
		
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo5($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/saturday?startdate=' . $startdate . '&end_date=' . $end_date . '&ref_startdate=' . $ref_startdate . '&ref_end_date=' . $ref_end_date . '&type=' . $type);	
		
		}

	}

	public function u_update5(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayfive_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;

			$this->Daily_forecasting_model->_updatefa5($data);		
			$update_result = $this->Daily_forecasting_model->_processfa5($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo5(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo5($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/saturday_forecast?start=' . $startdate . '&end=' . $end_date . '&version=' . $version);
		}

	}

//-------------------------------for daysix

	public function update6(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('daysix_date');
		$ref_date = $this->input->post('daysix_ref_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;
			$data["ref_date"] = $ref_date;

			$this->Daily_forecasting_model->_updatefa6($data);		
			$update_result = $this->Daily_forecasting_model->_processfa6($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo6(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');
		
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo6($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/sunday?startdate=' . $startdate . '&end_date=' . $end_date . '&ref_startdate=' . $ref_startdate . '&ref_end_date=' . $ref_end_date . '&type=' . $type);	
		
		}

	}

	public function u_update6(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('daysix_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;

			$this->Daily_forecasting_model->_updatefa6($data);		
			$update_result = $this->Daily_forecasting_model->_processfa6($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo6(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo6($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/sunday_forecast?start=' . $startdate . '&end=' . $end_date . '&version=' . $version);
		}

	}

//-------------------------------for dayseven

	public function update7(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayseven_date');
		$ref_date = $this->input->post('dayseven_ref_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;
			$data["ref_date"] = $ref_date;

			$this->Daily_forecasting_model->_updatefa7($data);		
			$update_result = $this->Daily_forecasting_model->_processfa7($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo7(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');
		
		$ref_startdate = $this->input->get('ref_startdate');
		$ref_end_date = $this->input->get('ref_end_date');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo7($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/monday?startdate=' . $startdate . '&end_date=' . $end_date . '&ref_startdate=' . $ref_startdate . '&ref_end_date=' . $ref_end_date . '&type=' . $type);	
		
		}

	}

	public function u_update7(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date = $this->input->post('dayseven_date');

		if($forecasted_amount != "" || $date != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date"] = $date;

			$this->Daily_forecasting_model->_updatefa7($data);		
			$update_result = $this->Daily_forecasting_model->_processfa7($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo7(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Daily_forecasting_model->_processfo7($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('daily_forecasting/monday_forecast?start=' . $startdate . '&end=' . $end_date . '&version=' . $version);
		}

	}

	public function save_forecast(){
		
		$module_id = "8";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$startdate = $this->input->get('startdate');

		$ref_startdate = $this->input->get('ref_startdate');
		$ref_enddate = $this->input->get('ref_end_date');
		$type = $this->input->get('type');

    	$startdate_exist = $this->Daily_forecasting_model->check_if_startdataExist($startdate);

		if($startdate_exist > 0){
			$date_from = date('Y-m-d');
        	$date_to = date('Y-m-d');
        
        	$data['date_from'] = $date_from;	
			$data['date_to'] = $date_to;

			$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected date-range was already exist.</b></div>');
			redirect('daily_forecasting');

		}else{

			$branch = $this->session->userdata('branch');
			
			$startdate = $this->input->get('startdate');

			$data['tues_date'] = $startdate;
			$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
			$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
			$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
			$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
			$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
			$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));


			if($type=="wf"){

				$data['ref_tues_date'] = date("Y-m-d", strtotime($startdate . " -7 day"));
				$data['ref_wed_date'] = date("Y-m-d", strtotime($data['ref_tues_date'] . " +1 day"));
				$data['ref_thurs_date'] = date("Y-m-d", strtotime($data['ref_wed_date'] . " +1 day"));
				$data['ref_fri_date'] = date("Y-m-d", strtotime($data['ref_thurs_date'] . " +1 day"));
				$data['ref_sat_date'] = date("Y-m-d", strtotime($data['ref_fri_date'] . " +1 day"));
				$data['ref_sun_date'] = date("Y-m-d", strtotime($data['ref_sat_date'] . " +1 day"));
				$data['ref_mon_date'] = date("Y-m-d", strtotime($data['ref_sun_date'] . " +1 day"));

			}else{

				$data['ref_tues_date'] = $ref_startdate;
				$data['ref_wed_date'] = date("Y-m-d", strtotime($data['ref_tues_date'] . " +1 day"));
				$data['ref_thurs_date'] = date("Y-m-d", strtotime($data['ref_wed_date'] . " +1 day"));
				$data['ref_fri_date'] = date("Y-m-d", strtotime($data['ref_thurs_date'] . " +1 day"));
				$data['ref_sat_date'] = date("Y-m-d", strtotime($data['ref_fri_date'] . " +1 day"));
				$data['ref_sun_date'] = date("Y-m-d", strtotime($data['ref_sat_date'] . " +1 day"));
				$data['ref_mon_date'] = date("Y-m-d", strtotime($data['ref_sun_date'] . " +1 day"));

			}


			$this->Daily_forecasting_model->selectitems($data);

			$this->Daily_forecasting_model->sel_upd($data,$startdate);		

			$this->print_forecast($data);
		
		}
	}

	public function print_forecast($data){

		$branch = $this->session->userdata('branch');

		$split = explode("-", $data['tues_date']);
		$date1 = $split[1] . '/' . $split[2] . '/' . $split[0];
		$data["date1"] = $date1;

		$split1 = explode("-", $data['wed_date']);
		$date2 = $split1[1] . '/' . $split1[2] . '/' . $split1[0];
		$data["date2"] = $date2;

		$split2 = explode("-", $data['thurs_date']);
		$date3 = $split2[1] . '/' . $split2[2] . '/' . $split2[0];
		$data["date3"] = $date3;

		$split3 = explode("-", $data['fri_date']);
		$date4 = $split3[1] . '/' . $split3[2] . '/' . $split3[0];
		$data["date4"] = $date4;

		$split4 = explode("-", $data['sat_date']);
		$date5 = $split4[1] . '/' . $split4[2] . '/' . $split4[0];
		$data["date5"] = $date5;

		$split5 = explode("-", $data['sun_date']);
		$date6 = $split5[1] . '/' . $split5[2] . '/' . $split5[0];
		$data["date6"] = $date6;

		$split6 = explode("-", $data['mon_date']);
		$date7 = $split6[1] . '/' . $split6[2] . '/' . $split6[0];
		$data["date7"] = $date7;

		$results = $this->Daily_forecasting_model->print_forecasting($data);

	    // $this->load->helper('download');

	   
	    if(count($results)>0){
		// error_reporting(0);

			//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text

		$this->excel->getActiveSheet()->setCellValue('A1', 'MATERIAL');
		$this->excel->getActiveSheet()->setCellValue('B1', 'PLANT');
		$this->excel->getActiveSheet()->setCellValue('C1', 'VERSION');
		$this->excel->getActiveSheet()->setCellValue('D1', 'BU');
		$this->excel->getActiveSheet()->setCellValue('E1', $date1);
		$this->excel->getActiveSheet()->setCellValue('F1', $date2);
		$this->excel->getActiveSheet()->setCellValue('G1', $date3);
		$this->excel->getActiveSheet()->setCellValue('H1', $date4);
		$this->excel->getActiveSheet()->setCellValue('I1', $date5);
		$this->excel->getActiveSheet()->setCellValue('J1', $date6);
		$this->excel->getActiveSheet()->setCellValue('K1', $date7);

		$ctr = '2';
		foreach($results as $row){
			
			$split1 = str_split($row['dayone']);
			$split2 = str_split($row['daytwo']);
			$split3 = str_split($row['daythree']);
			$split4 = str_split($row['dayfour']);
			$split5 = str_split($row['dayfive']);	
			$split6 = str_split($row['daysix']);
			$split7 = str_split($row['dayseven']);
			
			if($split1[0]=="-"){
				$row['dayone']="0";
			}else{
				ceil($row['dayone']);
			}

			if($split1[0]==""){
				$row['dayone']="0";
			}else{
				ceil($row['dayone']);
			}

			if($split2[0]=="-"){
				$row['daytwo']="0";
			}else{
				ceil($row['daytwo']);
			}

			if($split2[0]==""){
				$row['daytwo']="0";
			}else{
				ceil($row['daytwo']);
			}

			if($split3[0]=="-"){
				$row['daythree']="0";
			}else{
				ceil($row['daythree']);
			}

			if($split3[0]==""){
				$row['daythree']="0";
			}else{
				ceil($row['daythree']);
			}

			if($split4[0]=="-"){
				$row['dayfour']="0";
			}else{
				ceil($row['dayfour']);
			}

			if($split4[0]==""){
				$row['dayfour']="0";
			}else{
				ceil($row['dayfour']);
			}

			if($split5[0]=="-"){
				$row['dayfive']="0";
			}else{
				ceil($row['dayfive']);
			}

			if($split5[0]==""){
				$row['dayfive']="0";
			}else{
				ceil($row['dayfive']);
			}

			if($split6[0]=="-"){
				$row['daysix']="0";
			}else{
				ceil($row['daysix']);
			}

			if($split6[0]==""){
				$row['daysix']="0";
			}else{
				ceil($row['daysix']);
			}

			if($split7[0]=="-"){
				$row['dayseven']="0";
			}else{
				ceil($row['dayseven']);
			}

			if($split7[0]==""){
				$row['dayseven']="0";
			}else{
				ceil($row['dayseven']);
			}

			$this->excel->getActiveSheet()->setCellValue('A'.$ctr, $row['material']);
			$this->excel->getActiveSheet()->setCellValue('B'.$ctr, $row['plant']);
			$this->excel->getActiveSheet()->setCellValue('C'.$ctr, '00');
			$this->excel->getActiveSheet()->setCellValue('D'.$ctr, $row['BU']);
			$this->excel->getActiveSheet()->setCellValue('E'.$ctr, ceil($row['dayone']));
			$this->excel->getActiveSheet()->setCellValue('F'.$ctr, ceil($row['daytwo']));
			$this->excel->getActiveSheet()->setCellValue('G'.$ctr, ceil($row['daythree']));
			$this->excel->getActiveSheet()->setCellValue('H'.$ctr, ceil($row['dayfour']));
			$this->excel->getActiveSheet()->setCellValue('I'.$ctr, ceil($row['dayfive']));
			$this->excel->getActiveSheet()->setCellValue('J'.$ctr, ceil($row['daysix']));
			$this->excel->getActiveSheet()->setCellValue('K'.$ctr, ceil($row['dayseven']));

			$ctr++;

		}

		// //merge cell A1 until D1
		// // $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->Daily_forecasting_model->updatesap($data); 			

		$filename=$branch.'_'.$date1.'_TO_'.$date7.'(Daily_Forecasting).xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');


			}else{
				echo '
				<script>
					alert("Invalid! No record forecasted.");
					javascript:history.back()
				</script>
				';
			}

	}

	public function save_update_forecast(){
		
		$branch = $this->session->userdata('branch');
		
		$startdate = $this->input->get('start');

		$data['u_version'] = $this->input->get('version');

		$data['version'] = $this->input->get('version') + 1;

		$data['tues_date'] = $startdate;
		$data['wed_date'] = date("Y-m-d", strtotime($data['tues_date'] . " +1 day"));
		$data['thurs_date'] = date("Y-m-d", strtotime($data['wed_date'] . " +1 day"));
		$data['fri_date'] = date("Y-m-d", strtotime($data['thurs_date'] . " +1 day"));
		$data['sat_date'] = date("Y-m-d", strtotime($data['fri_date'] . " +1 day"));
		$data['sun_date'] = date("Y-m-d", strtotime($data['sat_date'] . " +1 day"));
		$data['mon_date'] = date("Y-m-d", strtotime($data['sun_date'] . " +1 day"));

		$this->Daily_forecasting_model->update_a_upd($data);

		$this->Daily_forecasting_model->selectitems_forupdate($data);

		$this->Daily_forecasting_model->sel_upd_forupdate($data,$startdate);		

		$this->print_update_forecast($data);
	}

	public function print_update_forecast($data){

		$branch = $this->session->userdata('branch');

		$split = explode("-", $data['tues_date']);
		$date1 = $split[1] . '/' . $split[2] . '/' . $split[0];
		
		$split1 = explode("-", $data['wed_date']);
		$date2 = $split1[1] . '/' . $split1[2] . '/' . $split1[0];
		
		$split2 = explode("-", $data['thurs_date']);
		$date3 = $split2[1] . '/' . $split2[2] . '/' . $split2[0];
		
		$split3 = explode("-", $data['fri_date']);
		$date4 = $split3[1] . '/' . $split3[2] . '/' . $split3[0];
		
		$split4 = explode("-", $data['sat_date']);
		$date5 = $split4[1] . '/' . $split4[2] . '/' . $split4[0];
		
		$split5 = explode("-", $data['sun_date']);
		$date6 = $split5[1] . '/' . $split5[2] . '/' . $split5[0];
		
		$split6 = explode("-", $data['mon_date']);
		$date7 = $split6[1] . '/' . $split6[2] . '/' . $split6[0];
		
		$results = $this->Daily_forecasting_model->print_forecasting_update($data);

	    // $this->load->helper('download');

	   
	    if(count($results)>0){
		
			//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text

		$this->excel->getActiveSheet()->setCellValue('A1', 'MATERIAL');
		$this->excel->getActiveSheet()->setCellValue('B1', 'PLANT');
		$this->excel->getActiveSheet()->setCellValue('C1', 'VERSION');
		$this->excel->getActiveSheet()->setCellValue('D1', 'BU');
		$this->excel->getActiveSheet()->setCellValue('E1', $date1);
		$this->excel->getActiveSheet()->setCellValue('F1', $date2);
		$this->excel->getActiveSheet()->setCellValue('G1', $date3);
		$this->excel->getActiveSheet()->setCellValue('H1', $date4);
		$this->excel->getActiveSheet()->setCellValue('I1', $date5);
		$this->excel->getActiveSheet()->setCellValue('J1', $date6);
		$this->excel->getActiveSheet()->setCellValue('K1', $date7);

		$ctr = '2';
		foreach($results as $row){
			
			$split1 = str_split($row['dayone']);
			$split2 = str_split($row['daytwo']);
			$split3 = str_split($row['daythree']);
			$split4 = str_split($row['dayfour']);
			$split5 = str_split($row['dayfive']);	
			$split6 = str_split($row['daysix']);
			$split7 = str_split($row['dayseven']);
			
			if($split1[0]=="-"){
				$row['dayone']="0";
			}else{
				ceil($row['dayone']);
			}

			if($split1[0]==""){
				$row['dayone']="0";
			}else{
				ceil($row['dayone']);
			}

			if($split2[0]=="-"){
				$row['daytwo']="0";
			}else{
				ceil($row['daytwo']);
			}

			if($split2[0]==""){
				$row['daytwo']="0";
			}else{
				ceil($row['daytwo']);
			}

			if($split3[0]=="-"){
				$row['daythree']="0";
			}else{
				ceil($row['daythree']);
			}

			if($split3[0]==""){
				$row['daythree']="0";
			}else{
				ceil($row['daythree']);
			}

			if($split4[0]=="-"){
				$row['dayfour']="0";
			}else{
				ceil($row['dayfour']);
			}

			if($split4[0]==""){
				$row['dayfour']="0";
			}else{
				ceil($row['dayfour']);
			}

			if($split5[0]=="-"){
				$row['dayfive']="0";
			}else{
				ceil($row['dayfive']);
			}

			if($split5[0]==""){
				$row['dayfive']="0";
			}else{
				ceil($row['dayfive']);
			}

			if($split6[0]=="-"){
				$row['daysix']="0";
			}else{
				ceil($row['daysix']);
			}

			if($split6[0]==""){
				$row['daysix']="0";
			}else{
				ceil($row['daysix']);
			}

			if($split7[0]=="-"){
				$row['dayseven']="0";
			}else{
				ceil($row['dayseven']);
			}

			if($split7[0]==""){
				$row['dayseven']="0";
			}else{
				ceil($row['dayseven']);
			}

			$this->excel->getActiveSheet()->setCellValue('A'.$ctr, $row['material']);
			$this->excel->getActiveSheet()->setCellValue('B'.$ctr, $row['plant']);
			$this->excel->getActiveSheet()->setCellValue('C'.$ctr, '00');
			$this->excel->getActiveSheet()->setCellValue('D'.$ctr, $row['BU']);
			$this->excel->getActiveSheet()->setCellValue('E'.$ctr, ceil($row['dayone']));
			$this->excel->getActiveSheet()->setCellValue('F'.$ctr, ceil($row['daytwo']));
			$this->excel->getActiveSheet()->setCellValue('G'.$ctr, ceil($row['daythree']));
			$this->excel->getActiveSheet()->setCellValue('H'.$ctr, ceil($row['dayfour']));
			$this->excel->getActiveSheet()->setCellValue('I'.$ctr, ceil($row['dayfive']));
			$this->excel->getActiveSheet()->setCellValue('J'.$ctr, ceil($row['daysix']));
			$this->excel->getActiveSheet()->setCellValue('K'.$ctr, ceil($row['dayseven']));

			$ctr++;

		}

		// //merge cell A1 until D1
		// // $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->Daily_forecasting_model->updatesap_forecast($data);			

		$filename=$branch.'_'.$date1.'_TO_'.$date7.'(Updated_Daily_Forecasting).xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

			}else{
				echo '
				<script>
					alert("Invalid! No record forecasted.");
					javascript:history.back()
				</script>
				';
			}

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/daily_forecasting.php */
