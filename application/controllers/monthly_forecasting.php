<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monthly_forecasting extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');
		$this->load->model('Monthly_forecasting_model');
		
	}	

	public function index(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			$this->getMonthlyForecast_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}
	} 

	public function getMonthlyForecast_Content(){
		$role_id = $this->session->userdata('role_id');
        
        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

        $data['css'] = array('redmond/jquery-ui-2.8.22.custom.css');
    	$data['jquery'] = array('datepicker/jquery-ui-1.js');

        $date_now = date('m-Y');

        $split1 = explode("-", $date_now);

        $monthName = date("F", mktime(0, 0, 0, $split1[0], 10));
		
		$data['month_from'] = $monthName . '-' . $split1[1];	
		$data['month_to'] = $monthName . '-' . $split1[1];
		
		// $date = "1998-01";
		// $newdate = strtotime ( '+3 month' , strtotime ( $date ) ) ;
		// $newdate = date ( 'Y-m-j' , $newdate );

		// echo $newdate;
		$data['count'] = count($this->Monthly_forecasting_model->count_all_sap_forecast());
		// $data['result'] = $this->Monthly_forecasting_model->all_sap_forecast();

		$offset = (int)$this->input->get('per_page');
		$config["per_page"] = 10;

		$data["result"] = $this->Monthly_forecasting_model->all_sap_forecast($config['per_page'],$offset);

		$this->load->library('pagination');
		$config['base_url'] = base_url('monthly_forecasting?month_from='.$data['month_from'].'&month_to='.$data['month_to']);
		$config['total_rows'] = count($this->Monthly_forecasting_model->count_all_sap_forecast());
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


		$data["content"] = 'monthly_forecasting';
		$this->load->view('backend/template', $data);

	}

	public function add($msg=''){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result <= 0){
			$this->_pageNotFound();
			return;
		}
        
        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

        $data['css'] = array('redmond/jquery-ui-2.8.22.custom.css');
    	$data['jquery'] = array('datepicker/jquery-ui-1.js');

        $date_now = date('m-Y');

        $split1 = explode("-", $date_now);

        $monthName = date("F", mktime(0, 0, 0, $split1[0], 10));
		
		$data['month_from'] = $monthName . '-' . $split1[1];	
		$data['month_to'] = $monthName . '-' . $split1[1];

		$data['result'] = $this->Monthly_forecasting_model->selpending();

		$data['msg'] = $msg;		
		$data["content"] = 'monthly_forecasting_range';
		$this->load->view('backend/template', $data);

	}

	public function save_pending(){
		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');
		$ref_monthend = $this->input->get('ref_month_end');
		
		$type = $this->input->get('type');

		if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
		}else{
			$type = "mrf";

		}

		$pending_id = $this->Monthly_forecasting_model->savepending($monthstart,$monthend,$ref_monthstart,$ref_monthend,$type);

		if($pending_id > 0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b> Record was successfully saved.</b></div>');
			redirect('monthly_forecasting/add');
		}

	}

	public function display(){
		$start = $this->input->get('start_month');
		$end = $this->input->get('end_month');

		if((!isset($start)) || (!isset($end))){
			$this->_pageNotFound();
			return;

		}else{
			$startm = $start;
			$endm = $end;

			$start = strtotime($start);	
			$month_start = date('Y-m', $start);	
			$result = explode("-", $month_start);
			$month_from = $result[0] . '-' . $result[1] . '-' . '01';

			$end = strtotime($end);
			$month_end = date('Y-m', $end);	
			$result2 = explode("-", $month_end);
			$month_end = $result2[0] . '-' . $result2[1] . '-' . '01';

			$role_id = $this->session->userdata('role_id');
        
	        $data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
	        $data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
	        $data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

	        $data['css'] = array('redmond/jquery-ui-2.8.22.custom.css');
    		$data['jquery'] = array('datepicker/jquery-ui-1.js');

			$date_now = date('m-Y');

	        $split1 = explode("-", $date_now);

	        $monthName = date("F", mktime(0, 0, 0, $split1[0], 10));
			
			$data['month_from'] = $monthName . '-' . $split1[1];	
			$data['month_to'] = $monthName . '-' . $split1[1];
			
			$data['start_month'] = $startm;
			$data['end_month'] = $endm;

			$data['count'] = count($this->Monthly_forecasting_model->sap_forecast($month_from,$month_end));
			$data['result'] = $this->Monthly_forecasting_model->sap_forecast($month_from,$month_end);

			$data["content"] = 'display';
			$this->load->view('backend/template', $data);

		}

	}

	public function viewing(){
		$module_id = "9";
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

	        $start_month = $this->input->get('start_month');
			$end_month = $this->input->get('end_month');
			
			$data['version'] = $this->input->get('version');

			//--1st---//	
				$result = explode("-", $start_month);

				$total = cal_days_in_month(CAL_GREGORIAN, $result[1], $result[0]);
				
				$fmonth_from = $result[0] . '-' . $result[1] . '-' . '01';
				$fmonth_end = $result[0] . '-' . $result[1] . '-' . $total; 

				$fmonths_from = $result[1] . '/' . '01' . '/' . $result[0];
				$fmonths_end = $result[1] . '/' . $total . '/' . $result[0]; 

				$data["fmonth_from"] = $fmonth_from;
				$data["fmonth_end"] = $fmonth_end;

				$data["fmonths_from"] = $fmonths_from;
				$data["fmonths_end"] = $fmonths_end;
				
			//--2nd--//	
				$secondmonth = strtotime ( '+1 month' , strtotime($start_month));
				// $firstmonth = date ( 'm' ,$firstmonth);
				$secondmonth = date ( 'Y-m' ,$secondmonth);

				$result2 = explode("-", $secondmonth);

				$total2 = cal_days_in_month(CAL_GREGORIAN, $result2[1], $result2[0]);
				
				$smonth_from = $result2[0] . '-' . $result2[1] . '-' . '01';
				$smonth_end = $result2[0] . '-' . $result2[1] . '-' . $total2; 

				$smonths_from = $result2[1] . '/' . '01' . '/' . $result2[0];
				$smonths_end = $result2[1] . '/' . $total2 . '/' . $result2[0]; 

				$data["smonth_from"] = $smonth_from;
				$data["smonth_end"] = $smonth_end;

				$data["smonths_from"] = $smonths_from;
				$data["smonths_end"] = $smonths_end;

			//--3rd--//	
				$result3 = explode("-", $end_month);

				$total3 = cal_days_in_month(CAL_GREGORIAN, $result3[1], $result3[0]);
				
				$tmonth_from = $result3[0] . '-' . $result3[1] . '-' . '01';
				$tmonth_end = $result3[0] . '-' . $result3[1] . '-' . $total3; 

				$tmonths_from = $result3[1] . '/' . '01' . '/' . $result3[0];
				$tmonths_end = $result3[1] . '/' . $total3 . '/' . $result3[0]; 

				$data["tmonth_from"] = $tmonth_from;
				$data["tmonth_end"] = $tmonth_end;

				$data["tmonths_from"] = $tmonths_from;
				$data["tmonths_end"] = $tmonths_end; 
				
				// $data['gross1'] = $this->Daily_forecasting_model->_getgross_vsf1($data['tues_date'],$data);
				// $data['gross2'] = $this->Daily_forecasting_model->_getgross_vsf2($data['wed_date'],$data);
				// $data['gross3'] = $this->Daily_forecasting_model->_getgross_vsf3($data['thurs_date'],$data);

				$data['gross1'] = $this->Monthly_forecasting_model->_getgross_vsf1($data);
				$data['gross2'] = $this->Monthly_forecasting_model->_getgross_vsf2($data);
				$data['gross3'] = $this->Monthly_forecasting_model->_getgross_vsf3($data);
			
				$row = $this->Monthly_forecasting_model->select_update($data);
				$row = $row->a_upd;

				if($row==""){
					$row = "0";
				}
			
			$data['date_today'] = date('Y-m-d');
			$data['date_endm'] = $tmonth_from;			
			$data['update_stats'] = $row;
			$data['result'] = $this->Monthly_forecasting_model->viewing($data);
			
			$data["content"] = 'viewing';
			$this->load->view('backend/template', $data);

		}

	}

	public function save_remarks(){
		// $daterange_start = $_GET['daterange_start'];
		// $daterange_end = $_GET['daterange_end'];

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
			redirect('monthly_forecasting');
		
		}else{

			$result = $this->Monthly_forecasting_model->update_remarks();	
			
			if($result>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Remarks was successfully updated.</b></div>');
				redirect('monthly_forecasting');
			
			}
		}

	}

	public function save_remarks1(){
		$startm = $_GET['start_month'];
		$endm = $_GET['end_month'];

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
			redirect('monthly_forecasting/display?start_month=' . $startm . '&end_month=' . $endm);
		
		}else{

			$result = $this->Monthly_forecasting_model->update_remarks();	
			
			if($result>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Remarks is successfully updated.</b></div>');
				redirect('monthly_forecasting/display?start_month=' . $startm . '&end_month=' . $endm);
			
			}
		}

	}

	public function summary_forecasted(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $this->input->get('start_month');
		$monthend = $this->input->get('end_month');

		$version = $this->input->get('version');

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
				$this->_pageNotFound();
				return;
			}

			if($monthstart == "" || $monthend == ""){
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid month-range selected.</b></div>');
				redirect('monthly_forecasting/add');

			}

					//fmonth//	
					$firstmonthf = strtotime($monthstart);
					// $firstmonth = date ( 'm' ,$firstmonth);
					$firstmonthf = date ( 'Y-m' ,$firstmonthf);

					$result1f = explode("-", $firstmonthf);

					$total1f = cal_days_in_month(CAL_GREGORIAN, $result1f[1], $result1f[0]);
					
					$data['f_exist_from'] = $result1f[0] . '-' . $result1f[1] . '-' . '01';
					$data['f_exist_end'] = $result1f[0] . '-' . $result1f[1] . '-' . $total1f;

					$data['month1'] = date('F', mktime(0, 0, 0, $result1f[1], 10)) . '-' . $result1f[0];

				//smonth//	
					$secondmonthf = strtotime ( '+1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$secondmonthf = date ( 'Y-m' ,$secondmonthf);

					$result2f = explode("-", $secondmonthf);

					$total2f = cal_days_in_month(CAL_GREGORIAN, $result2f[1], $result2f[0]);
					
					$data['s_exist_from'] = $result2f[0] . '-' . $result2f[1] . '-' . '01';
					$data['s_exist_end'] = $result2f[0] . '-' . $result2f[1] . '-' . $total2f;

					$data['month2'] = date('F', mktime(0, 0, 0, $result2f[1], 10)) . '-' . $result2f[0];

				//tmonth//	
					$thirdmonthf = strtotime ( '+2 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$thirdmonthf = date ( 'Y-m' ,$thirdmonthf);

					$result3f = explode("-", $thirdmonthf);

					$total3f = cal_days_in_month(CAL_GREGORIAN, $result3f[1], $result3f[0]);
					
					$data['t_exist_from'] = $result3f[0] . '-' . $result3f[1] . '-' . '01';
					$data['t_exist_end'] = $result3f[0] . '-' . $result3f[1] . '-' . $total3f;

					$data['month3'] = date('F', mktime(0, 0, 0, $result3f[1], 10)) . '-' . $result3f[0];

				//------------------------//
								
					$data["ffmonth_from"] = $data['f_exist_from'];
					$data["ffmonth_end"] = $data['f_exist_end'];

					$data["ssmonth_from"] = $data['s_exist_from'];
					$data["ssmonth_end"] = $data['s_exist_end'];

					$data["ttmonth_from"] = $data['t_exist_from'];
					$data["ttmonth_end"] = $data['t_exist_end'];

					$data["fmonth_from"] = $data['f_exist_from'];
					$data["fmonth_end"] = $data['f_exist_end'];

					$data['ref_month_from'] =  $this->Monthly_forecasting_model->_getref1($data);
					$data['ref_month_end'] =  $this->Monthly_forecasting_model->_getref2($data);

					$data['gross1'] = $this->Monthly_forecasting_model->_getgross_sf1($data);

					$data['gross2'] = $this->Monthly_forecasting_model->_getgross_sf2($data);

					$data['gross3'] = $this->Monthly_forecasting_model->_getgross_sf3($data);

					$search = $this->input->get('search');
				  	$data['search'] = $search;

					$data['sf'] = $this->Monthly_forecasting_model->_selectsf_u($data,$search);

				$data["content"] = 'summary_forecasted';
				$this->load->view('backend/template_pm', $data);

	}

	public function first_month_forecast(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $_GET['start_month'];
		$monthend = $_GET['end_month'];;

		$version = $_GET['version'];

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
				$this->_pageNotFound();
				return;
			}

			if($monthstart == "" || $monthend == ""){
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid month-range selected.</b></div>');
				redirect('monthly_forecasting/add');

			}
				
				$result = explode("-", $monthstart);

				$total = cal_days_in_month(CAL_GREGORIAN, $result[1], $result[0]);
				
				$fmonth_from = $result[0] . '-' . $result[1] . '-' . '01';
				$fmonth_end = $result[0] . '-' . $result[1] . '-' . $total; 

				$fmonths_from = $result[1] . '-' . '01' . '-' . $result[0];
				$fmonths_end = $result[1] . '-' . $total . '-' . $result[0]; 

				$f1months = date('F', mktime(0, 0, 0, $result[1], 10)) . '-' . $result[0];

				$data["fmonth_from"] = $fmonth_from;
				$data["fmonth_end"] = $fmonth_end;

				$data["ffmonth_from"] = $fmonth_from;
				$data["ffmonth_end"] = $fmonth_end;
				
				$data['ref_month_from'] =  $this->Monthly_forecasting_model->_getref1($data);
				$data['ref_month_end'] =  $this->Monthly_forecasting_model->_getref2($data);

				//--1stmonth--//
	    			$gross_fmonth = $this->Monthly_forecasting_model->_getgross1($data);
	    			$result_fmonth = $this->Monthly_forecasting_model->_getforecast1($data);

				  	$data["firsmonth_display"] = $f1months;
				  	$data["forecasted_amount"] = $this->Monthly_forecasting_model->day1fa($data);
				  	$data["gross"] = $gross_fmonth;
				  	
				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["fm"] = $this->Monthly_forecasting_model->_selectAllDayOne($config['per_page'],$offset,$data);

					$this->load->library('pagination');
					$config['base_url'] = base_url('Monthly_forecasting/first_month_forecast?start_month='.$monthstart.'&end_month='.$monthend.'&version='.$version);
					$config['total_rows'] = $this->Monthly_forecasting_model->countday1($data);
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

				$data["content"] = 'first_month_forecast';
				$this->load->view('backend/template', $data);
				
	}

	public function second_month_forecast(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $_GET['start_month'];
		$monthend = $_GET['end_month'];;

		$version = $_GET['version'];

		// $data["monthstart"] = $monthstart;
		// $data["monthend"] = $monthend;

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
				$this->_pageNotFound();
				return;
			}

				$second_month = strtotime ( '+1 month' , strtotime($monthstart));
				// $firstmonth = date ( 'm' ,$firstmonth);
				$secondmonth = date ( 'Y-m' ,$second_month);

				$result = explode("-", $secondmonth);

				$total = cal_days_in_month(CAL_GREGORIAN, $result[1], $result[0]);
				
				$smonth_from = $result[0] . '-' . $result[1] . '-' . '01';
				$smonth_end = $result[0] . '-' . $result[1] . '-' . $total; 

				$smonths_from = $result[1] . '-' . '01' . '-' . $result[0];
				$smonths_end = $result[1] . '-' . $total . '-' . $result[0]; 

				$s1months = date('F', mktime(0, 0, 0, $result[1], 10)) . '-' . $result[0];

				$data["smonth_from"] = $smonth_from;
				$data["smonth_end"] = $smonth_end;

				$data["ssmonth_from"] = $smonth_from;
				$data["ssmonth_end"] = $smonth_end;
				
				$data['ref_month_from'] =  $this->Monthly_forecasting_model->_getref3($data);
				$data['ref_month_end'] =  $this->Monthly_forecasting_model->_getref4($data);

				//--2ndmonth--//
	    			$gross_smonth = $this->Monthly_forecasting_model->_getgross2($data);
	    			$result_smonth = $this->Monthly_forecasting_model->_getforecast2($data);

				  	$data["secondmonth_display"] = $s1months;
				  	$data["forecasted_amount"] = $this->Monthly_forecasting_model->day2fa($data);
				  	$data["gross"] = $gross_smonth;

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["sm"] = $this->Monthly_forecasting_model->_selectAllDayTwo($config['per_page'],$offset,$data);

					$this->load->library('pagination');
					$config['base_url'] = base_url('Monthly_forecasting/second_month_forecast?start_month='.$monthstart.'&end_month='.$monthend.'&version='.$version);
					$config['total_rows'] = $this->Monthly_forecasting_model->countday2($data);
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

				$data["content"] = 'second_month_forecast';
				$this->load->view('backend/template', $data);
				
	}

	public function third_month_forecast(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $_GET['start_month'];
		$monthend = $_GET['end_month'];;

		$version = $_GET['version'];

		// $data["monthstart"] = $monthstart;
		// $data["monthend"] = $monthend;

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
				$this->_pageNotFound();
				return;
			}

				$third_month = strtotime ( '+2 month' , strtotime($monthstart));
				// $firstmonth = date ( 'm' ,$firstmonth);
				$thirdmonth = date ( 'Y-m' ,$third_month);

				$result = explode("-", $thirdmonth);

				$total = cal_days_in_month(CAL_GREGORIAN, $result[1], $result[0]);
				
				$tmonth_from = $result[0] . '-' . $result[1] . '-' . '01';
				$tmonth_end = $result[0] . '-' . $result[1] . '-' . $total; 

				$tmonths_from = $result[1] . '-' . '01' . '-' . $result[0];
				$tmonths_end = $result[1] . '-' . $total . '-' . $result[0]; 

				$t1months = date('F', mktime(0, 0, 0, $result[1], 10)) . '-' . $result[0];

				$data["tmonth_from"] = $tmonth_from;
				$data["tmonth_end"] = $tmonth_end;

				$data["ttmonth_from"] = $tmonth_from;
				$data["ttmonth_end"] = $tmonth_end;

				$data['ref_month_from'] =  $this->Monthly_forecasting_model->_getref5($data);
				$data['ref_month_end'] =  $this->Monthly_forecasting_model->_getref6($data);

				//--3rdmonth--//
	    			$gross_tmonth = $this->Monthly_forecasting_model->_getgross3($data);
	    			$result_tmonth = $this->Monthly_forecasting_model->_getforecast3($data);
					
				  	$data["thirdmonth_display"] = $t1months;
				  	$data["forecasted_amount"] = $this->Monthly_forecasting_model->day3fa($data);
				  	$data["gross"] = $gross_tmonth;

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["tm"] = $this->Monthly_forecasting_model->_selectAllDayThree($config['per_page'],$offset,$data);

					$this->load->library('pagination');
					$config['base_url'] = base_url('Monthly_forecasting/third_month_forecast?start_month='.$monthstart.'&end_month='.$monthend.'&version='.$version);
					$config['total_rows'] = $this->Monthly_forecasting_model->countday3($data);
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

				$data["content"] = 'third_month_forecast';
				$this->load->view('backend/template', $data);
	}


	public function product_mixed(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');
		
		if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
		}else{
			$type = "mrf";

		}
		// $ref_month_end = $this->input->get('ref_month_end');

		// $type = $this->input->get('type');

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend)) || (!isset($ref_monthstart))){
				$this->_pageNotFound();
				return;
			}

			if($monthstart == "" || $monthend == ""){
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid month-range selected.</b></div>');
				redirect('monthly_forecasting/add');

			}
						
					// if($type=="mf"){

					// 	//fmonth//	
					// 	$firstmonthr = strtotime ( '-3 month' , strtotime($monthstart));
					// 	// $firstmonth = date ( 'm' ,$firstmonth);
					// 	$firstmonthr = date ( 'Y-m' ,$firstmonthr);

					// 	$result1r = explode("-", $firstmonthr);

					// 	$total1r = cal_days_in_month(CAL_GREGORIAN, $result1r[1], $result1r[0]);
						
					// 	$data['fmonth_from'] = $result1r[0] . '-' . $result1r[1] . '-' . '01';
					// 	$data['fmonth_end'] = $result1r[0] . '-' . $result1r[1] . '-' . $total1r;

					// 	$data['fmonths_from'] = $result1r[1] . '/' . '01' . '/' . $result1r[0];
					// 	$data['fmonths_end'] = $result1r[1] . '/' . $total1r . '/' . $result1r[0]; 

					// //smonth//	
					// 	$secondmonthr = strtotime ( '-2 month' , strtotime($monthstart));
					// 	// $firstmonth = date ( 'm' ,$firstmonth);
					// 	$secondmonthr = date ( 'Y-m' ,$secondmonthr);

					// 	$result2r = explode("-", $secondmonthr);

					// 	$total2r = cal_days_in_month(CAL_GREGORIAN, $result2r[1], $result2r[0]);
						
					// 	$data['smonth_from'] = $result2r[0] . '-' . $result2r[1] . '-' . '01';
					// 	$data['smonth_end'] = $result2r[0] . '-' . $result2r[1] . '-' . $total2r; 

					// 	$data['smonths_from'] = $result2r[1] . '/' . '01' . '/' . $result2r[0];
					// 	$data['smonths_end'] = $result2r[1] . '/' . $total2r . '/' . $result2r[0];

					// //tmonth//	
					// 	$thirdmonthr = strtotime ( '-1 month' , strtotime($monthstart));
					// 	// $firstmonth = date ( 'm' ,$firstmonth);
					// 	$thirdmonthr = date ( 'Y-m' ,$thirdmonthr);

					// 	$result3r = explode("-", $thirdmonthr);

					// 	$total3r = cal_days_in_month(CAL_GREGORIAN, $result3r[1], $result3r[0]);
						
					// 	$data['tmonth_from'] = $result3r[0] . '-' . $result3r[1] . '-' . '01';
					// 	$data['tmonth_end'] = $result3r[0] . '-' . $result3r[1] . '-' . $total3r;

					// 	$data['tmonths_from'] = $result3r[1] . '/' . '01' . '/' . $result3r[0];
					// 	$data['tmonths_end'] = $result3r[1] . '/' . $total3r . '/' . $result3r[0];

					// }else{

					// 	//fmonth//	
					// 	$firstmonthr = strtotime($ref_monthstart);
					// 	// $firstmonth = date ( 'm' ,$firstmonth);
					// 	$firstmonthr = date ( 'Y-m' ,$firstmonthr);

					// 	$result1r = explode("-", $firstmonthr);

					// 	$total1r = cal_days_in_month(CAL_GREGORIAN, $result1r[1], $result1r[0]);
						
					// 	$data['fmonth_from'] = $result1r[0] . '-' . $result1r[1] . '-' . '01';
					// 	$data['fmonth_end'] = $result1r[0] . '-' . $result1r[1] . '-' . $total1r;

					// 	$data['fmonths_from'] = $result1r[1] . '/' . '01' . '/' . $result1r[0];
					// 	$data['fmonths_end'] = $result1r[1] . '/' . $total1r . '/' . $result1r[0]; 

					// //smonth//	
					// 	$secondmonthr = strtotime ( '+1 month' , strtotime($ref_monthstart));
					// 	// $firstmonth = date ( 'm' ,$firstmonth);
					// 	$secondmonthr = date ( 'Y-m' ,$secondmonthr);

					// 	$result2r = explode("-", $secondmonthr);

					// 	$total2r = cal_days_in_month(CAL_GREGORIAN, $result2r[1], $result2r[0]);
						
					// 	$data['smonth_from'] = $result2r[0] . '-' . $result2r[1] . '-' . '01';
					// 	$data['smonth_end'] = $result2r[0] . '-' . $result2r[1] . '-' . $total2r; 

					// 	$data['smonths_from'] = $result2r[1] . '/' . '01' . '/' . $result2r[0];
					// 	$data['smonths_end'] = $result2r[1] . '/' . $total2r . '/' . $result2r[0];

					// //tmonth//	
					// 	$thirdmonthr = strtotime ( '+2 month' , strtotime($ref_monthstart));
					// 	// $firstmonth = date ( 'm' ,$firstmonth);
					// 	$thirdmonthr = date ( 'Y-m' ,$thirdmonthr);

					// 	$result3r = explode("-", $thirdmonthr);

					// 	$total3r = cal_days_in_month(CAL_GREGORIAN, $result3r[1], $result3r[0]);
						
					// 	$data['tmonth_from'] = $result3r[0] . '-' . $result3r[1] . '-' . '01';
					// 	$data['tmonth_end'] = $result3r[0] . '-' . $result3r[1] . '-' . $total3r;

					// 	$data['tmonths_from'] = $result3r[1] . '/' . '01' . '/' . $result3r[0];
					// 	$data['tmonths_end'] = $result3r[1] . '/' . $total3r . '/' . $result3r[0];

					// }

				if($type=="mf"){

					$r1second_month = strtotime ( '-1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$r1secondmonth = date ( 'Y-m' ,$r1second_month);

					$resultr1 = explode("-", $r1secondmonth);

					$totalr1 = cal_days_in_month(CAL_GREGORIAN, $resultr1[1], $resultr1[0]);
					
					$r1smonth_from = $resultr1[0] . '-' . $resultr1[1] . '-' . '01';
					$r1smonth_end = $resultr1[0] . '-' . $resultr1[1] . '-' . $totalr1; 

					$data["ref_month_from"] = $r1smonth_from;
					$data["ref_month_end"] = $r1smonth_end;

					// $smonths_from = $resultr1[1] . '/' . '01' . '/' . $resultr1[0];
					// $smonths_end = $resultr1[1] . '/' . $totalr1 . '/' . $resultr1[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr1[1], 10)) . '-' . $resultr1[0];
					
					$data['smonths_r'] = $smonths_r;

				}else{

					// $r2second_month = strtotime ( '+1 month' , strtotime($ref_monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);

					$lastmonth_ref = strtotime($ref_monthstart);

					$r2secondmonth = date( 'Y-m' , $lastmonth_ref);

					$resultr2 = explode("-", $r2secondmonth);

					$totalr2 = cal_days_in_month(CAL_GREGORIAN, $resultr2[1], $resultr2[0]);
					
					$r2smonth_from = $resultr2[0] . '-' . $resultr2[1] . '-' . '01';
					$r2smonth_end = $resultr2[0] . '-' . $resultr2[1] . '-' . $totalr2; 

					$data["ref_month_from"] = $r2smonth_from;
					$data["ref_month_end"] = $r2smonth_end;

					// $smonths_from = $resultr2[1] . '/' . '01' . '/' . $resultr2[0];
					// $smonths_end = $resultr2[1] . '/' . $totalr2 . '/' . $resultr2[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr2[1], 10)) . '-' . $resultr2[0];

					$data['smonths_r'] = $smonths_r;

				}


				//-------first-----//
					// $fthird_month = strtotime ( '+2 month' , strtotime($data['monthfs']));
				
					$firstmonth = strtotime( $monthstart);

					$f_firstmonth = date ( 'Y-m' ,$firstmonth);

					$resultf1 = explode("-", $f_firstmonth);

					$totalf = cal_days_in_month(CAL_GREGORIAN, $resultf1[1], $resultf1[0]);

					// $tmonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $tmonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

				 	$f_month1 = date('F', mktime(0, 0, 0, $resultf1[1], 10)) . '-' . $resultf1[0];

				 //--------second----///	
				 	$secondmonth = strtotime('+1 month' , strtotime($monthstart));
				
					$f_secondmonth = date ( 'Y-m' ,$secondmonth);

					$resultf2 = explode("-", $f_secondmonth);

					$totalf2 = cal_days_in_month(CAL_GREGORIAN, $resultf2[1], $resultf2[0]);

					// $tmonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $tmonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

					$data['ssmonth_from'] = $resultf2[0] . '-' . $resultf2[1] . '-' . '01';
					$data['ssmonth_end'] = $resultf2[0] . '-' . $resultf2[1] . '-' . $totalf2;

				 	$f_month2 = date('F', mktime(0, 0, 0, $resultf2[1], 10)) . '-' . $resultf2[0];

				  //--------third----///	
				 	$thirdmonth = strtotime('+2 month' , strtotime($monthstart));
				
					$f_thirdmonth = date ( 'Y-m' ,$thirdmonth);

					$resultf3 = explode("-", $f_thirdmonth);

					$totalf3 = cal_days_in_month(CAL_GREGORIAN, $resultf3[1], $resultf3[0]);

					// $tmonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $tmonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

					$data['ttmonth_from'] = $resultf3[0] . '-' . $resultf3[1] . '-' . '01';
					$data['ttmonth_end'] = $resultf3[0] . '-' . $resultf3[1] . '-' . $totalf3;

				 	$f_month3 = date('F', mktime(0, 0, 0, $resultf3[1], 10)) . '-' . $resultf3[0];	

				 	$data['ffmonth_from'] = $resultf1[0] . '-' . $resultf1[1] . '-' . '01';
					$data['ttmonth_end'] = $resultf3[0] . '-' . $resultf3[1] . '-' . '01';

				// //--1stmonth--//	
	   //  			// $gross_tmonth = $this->Monthly_forecasting_model->_gettotalgross3($data);
	   //  			// $result_tmonth = $this->Monthly_forecasting_model->_getforecast3($data);

					$data['gross1'] = $this->Monthly_forecasting_model->_gettotalgross_avg($data);
	    			$result_fmonth = $this->Monthly_forecasting_model->_getforecast_avg($data);
					$this->Monthly_forecasting_model->insert1_pm($result_fmonth,$data);

					// $data['gross2'] = $this->Monthly_forecasting_model->_gettotalgross_avg($data);
	    // 			$result_smonth = $this->Monthly_forecasting_model->_getforecast_avg($data);
					// $this->Monthly_forecasting_model->insert2_pm($result_smonth,$data);

					// $data['gross3'] = $this->Monthly_forecasting_model->_gettotalgross_avg($data);
	    // 			$result_tmonth = $this->Monthly_forecasting_model->_getforecast_avg($data);
					// $this->Monthly_forecasting_model->insert3_pm($result_tmonth,$data);

					$search = $this->input->get('search');
				  	$data['search'] = $search;
				 	$data['pm'] = $this->Monthly_forecasting_model->_selectpm($data,$search);

				 $data["content"] = 'product_mixed';
				 $this->load->view('backend/template', $data);
		
	}

	public function print_product_mixed(){

		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');

		if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
		}else{
			$type = "mrf";

		}
				if($type=="mf"){

					$r1second_month = strtotime ( '-1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$r1secondmonth = date ( 'Y-m' ,$r1second_month);

					$resultr1 = explode("-", $r1secondmonth);

					$totalr1 = cal_days_in_month(CAL_GREGORIAN, $resultr1[1], $resultr1[0]);
					
					$r1smonth_from = $resultr1[0] . '-' . $resultr1[1] . '-' . '01';
					$r1smonth_end = $resultr1[0] . '-' . $resultr1[1] . '-' . $totalr1; 

					$data["ref_month_from"] = $r1smonth_from;
					$data["ref_month_end"] = $r1smonth_end;

					// $smonths_from = $resultr1[1] . '/' . '01' . '/' . $resultr1[0];
					// $smonths_end = $resultr1[1] . '/' . $totalr1 . '/' . $resultr1[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr1[1], 10)) . '-' . $resultr1[0];
					
					$data['smonths_r'] = $smonths_r;

				}else{

					// $r2second_month = strtotime ( '+1 month' , strtotime($ref_monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);

					$lastmonth_ref = strtotime($ref_monthstart);

					$r2secondmonth = date( 'Y-m' , $lastmonth_ref);

					$resultr2 = explode("-", $r2secondmonth);

					$totalr2 = cal_days_in_month(CAL_GREGORIAN, $resultr2[1], $resultr2[0]);
					
					$r2smonth_from = $resultr2[0] . '-' . $resultr2[1] . '-' . '01';
					$r2smonth_end = $resultr2[0] . '-' . $resultr2[1] . '-' . $totalr2; 

					$data["ref_month_from"] = $r2smonth_from;
					$data["ref_month_end"] = $r2smonth_end;

					// $smonths_from = $resultr2[1] . '/' . '01' . '/' . $resultr2[0];
					// $smonths_end = $resultr2[1] . '/' . $totalr2 . '/' . $resultr2[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr2[1], 10)) . '-' . $resultr2[0];

					$data['smonths_r'] = $smonths_r;

				}

				$gross = round($this->Monthly_forecasting_model->_gettotalgross_avg($data),0);

		//-------first-----//
					// $fthird_month = strtotime ( '+2 month' , strtotime($data['monthfs']));
				
					$firstmonth = strtotime( $monthstart);

					$f_firstmonth = date ( 'Y-m' ,$firstmonth);

					$resultf1 = explode("-", $f_firstmonth);

					$totalf = cal_days_in_month(CAL_GREGORIAN, $resultf1[1], $resultf1[0]);

					// $tmonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $tmonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

				 	$f_month1 = date('F', mktime(0, 0, 0, $resultf1[1], 10)) . '-' . $resultf1[0];

				 //--------second----///	
				 	$secondmonth = strtotime('+1 month' , strtotime($monthstart));
				
					$f_secondmonth = date ( 'Y-m' ,$secondmonth);

					$resultf2 = explode("-", $f_secondmonth);

					$totalf2 = cal_days_in_month(CAL_GREGORIAN, $resultf2[1], $resultf2[0]);

					// $tmonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $tmonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

					$data['ssmonth_from'] = $resultf2[0] . '-' . $resultf2[1] . '-' . '01';
					$data['ssmonth_end'] = $resultf2[0] . '-' . $resultf2[1] . '-' . $totalf2;

				 	$f_month2 = date('F', mktime(0, 0, 0, $resultf2[1], 10)) . '-' . $resultf2[0];

				  //--------third----///	
				 	$thirdmonth = strtotime('+2 month' , strtotime($monthstart));
				
					$f_thirdmonth = date ( 'Y-m' ,$thirdmonth);

					$resultf3 = explode("-", $f_thirdmonth);

					$totalf3 = cal_days_in_month(CAL_GREGORIAN, $resultf3[1], $resultf3[0]);

					// $tmonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $tmonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

					$data['ttmonth_from'] = $resultf3[0] . '-' . $resultf3[1] . '-' . '01';
					$data['ttmonth_end'] = $resultf3[0] . '-' . $resultf3[1] . '-' . $totalf3;

				 	$f_month3 = date('F', mktime(0, 0, 0, $resultf3[1], 10)) . '-' . $resultf3[0];	

				 	$data['ffmonth_from'] = $resultf1[0] . '-' . $resultf1[1] . '-' . '01';
					$data['ttmonth_end'] = $resultf3[0] . '-' . $resultf3[1] . '-' . '01';

		
		$results = $this->Monthly_forecasting_model->_selectpm_forprint($data);

	    // $this->load->helper('download');

	   
	    if(count($results)>0){
		
			//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', '');
		$this->excel->getActiveSheet()->setCellValue('B1', '');
		$this->excel->getActiveSheet()->setCellValue('C1', $smonths_r);
		
		$this->excel->getActiveSheet()->setCellValue('A2', '');
		$this->excel->getActiveSheet()->setCellValue('B2', '');
		$this->excel->getActiveSheet()->setCellValue('C2', $gross);

		$this->excel->getActiveSheet()->setCellValue('A3', 'MATERIAL');
		$this->excel->getActiveSheet()->setCellValue('B3', 'MENU ITEMS');
		$this->excel->getActiveSheet()->setCellValue('C3', '');

		$ctr = '4';
		foreach($results as $row){
			
			$split1 = str_split($row['fgsold']);
					
			if($split1[0]=="-"){
				$row['fgsold']="0";
			}else{
				(round($row['fgsold'],0));
			}

			if($split1[0]==""){
				$row['fgsold']="0";
			}else{
				(round($row['fgsold'],0));
			}

			$this->excel->getActiveSheet()->setCellValue('A'.$ctr, $row['sapcode']);
			$this->excel->getActiveSheet()->setCellValue('B'.$ctr, $row['desc']);
			$this->excel->getActiveSheet()->setCellValue('C'.$ctr, $row['fgsold']);

			$ctr++;

		}

		// //merge cell A1 until D1
		// // $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$branch = $this->session->userdata('branch');

		$filename=$branch.'_'.$smonths_r.'(Reference).xls'; //save our workbook as this file name
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

	public function first_month(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$starts = $this->input->get('monthstart');
		$ends = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');

		if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
		}else{
			$type = "mrf";

		}
		

		if($starts=="" || $ends==""){
    		$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Choose month in Monthly Forecast first.</b></div>');
			redirect('monthly_forecasting/add');
    	
    	}

    	if($type=="mf"){

			$monthstart = $this->input->get('monthstart');
			$monthend = $this->input->get('monthend');

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
				$this->_pageNotFound();
				return;
			}
			
			//lastmonth//	
				$lastmonth = strtotime ( '-1 month' , strtotime($monthstart));
				// $firstmonth = date ( 'm' ,$firstmonth);
				$lastmonth = date ( 'Y-m' ,$lastmonth);

				$result3r = explode("-", $lastmonth);

				$total3r = cal_days_in_month(CAL_GREGORIAN, $result3r[1], $result3r[0]);
				
				$data['rtmonth_from'] = $result3r[0] . '-' . $result3r[1] . '-' . '01';
				$data['rtmonth_end'] = $result3r[0] . '-' . $result3r[1] . '-' . $total3r; 

				$result_3r = $this->Monthly_forecasting_model->_getforecast3_val($data);
				
				$results3 = "";

				foreach($result_3r as $row){
					 if($row['qty']==""){
					 	$resulta3 = "0";
					 
					 }else{
					 	$resulta3 = $row['qty'];
					 
					 }

					 $results3 = $resulta3;
				}

				$r_result3 = $results3;

				if($r_result3=="0"){

				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Your Reference month was empty, choose other month.</b></div>');
				redirect('monthly_forecasting/add');
				
				}
				
				// $data['fmonth_from'] = $data['rfmonth_from'];
				// $data['fmonth_end'] = $data['rfmonth_end'];	
				
				//f_fmonth//	
				$f_exist = strtotime($this->input->get('monthstart'));
				// $firstmonth = date ( 'm' ,$firstmonth);
				$f_exist = date( 'Y-m' ,$f_exist);

				$result_f_exist = explode("-", $f_exist);

				$total_f_exist = cal_days_in_month(CAL_GREGORIAN, $result_f_exist[1], $result_f_exist[0]);
				
				$data['f_exist_from'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . '01';
				$data['f_exist_end'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . $total_f_exist;

				$fmonth_exist = $this->Monthly_forecasting_model->fmonth_exist($data);
					
				if($fmonth_exist > 0){
					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected Month-range was already exist.</b></div>');
					redirect('monthly_forecasting/add');

				}else{

				$data['monthfs'] = $this->input->get('monthstart');
				$data['monthfe'] = $this->input->get('monthend');
				
				// $data['ref_smonth'] = $this->input->get('ref_monthstart');
				// $data['ref_emonth'] = $this->input->get('ref_month_end');

				// $r1month_from = $result1r[1] . '/' . '01' . '/' . $result1r[0];
				// $r1month_end = $result1r[1] . '/' . $total1r . '/' . $result1r[0]; 

				$lastmonth_ref = strtotime ( '-1 month' , strtotime($monthstart));
				// $firstmonth = date ( 'm' ,$firstmonth);
				$lastmonth_ref = date ( 'Y-m' ,$lastmonth_ref);

				$ref_resultavg = explode("-", $lastmonth_ref);

				$totals = cal_days_in_month(CAL_GREGORIAN, $ref_resultavg[1], $ref_resultavg[0]);
				
				$data['ref_month_from'] = $ref_resultavg[0] . '-' . $ref_resultavg[1] . '-' . '01';
				$data['ref_month_end'] = $ref_resultavg[0] . '-' . $ref_resultavg[1] . '-' . $totals;
				$data['ref_end_month'] = $ref_resultavg[0] . '-' . $ref_resultavg[1] . '-' . $totals;

				$r1months = date('F', mktime(0, 0, 0, $ref_resultavg[1], 10)) . '-' . $ref_resultavg[0];

					//f_fmonth//	
					$firstmonthf = strtotime($this->input->get('monthstart'));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$firstmonthf = date( 'Y-m' ,$firstmonthf);

					$result1f = explode("-", $firstmonthf);

					$total1f = cal_days_in_month(CAL_GREGORIAN, $result1f[1], $result1f[0]);
					
					$data['ffmonth_from'] = $result1f[0] . '-' . $result1f[1] . '-' . '01';
					$data['ffmonth_end'] = $result1f[0] . '-' . $result1f[1] . '-' . $total1f;

				// $f1month_from = $result1f[1] . '/' . '01' . '/' . $result1f[0];
				// $f1month_end = $result1f[1] . '/' . $total1f . '/' . $result1f[0]; 

				$f1months = date('F', mktime(0, 0, 0, $result1f[1], 10)) . '-' . $result1f[0];

				//--1stmonth--//
	    			$gross_fmonth = $this->Monthly_forecasting_model->_gettotalgross1($data);
	    			$result_fmonth = $this->Monthly_forecasting_model->_getforecast1($data);
	    			$this->Monthly_forecasting_model->insert1($gross_fmonth,$result_fmonth,$data);

					$gross_fmonth1 = $this->Monthly_forecasting_model->_gettotalgross_avg($data);
	    			$result_fmonth1 = $this->Monthly_forecasting_model->_getforecast_avg($data);
	    			
					$this->Monthly_forecasting_model->update1($gross_fmonth1,$result_fmonth1,$data);
	    			

				  	$data["ref_firstmonth_display"] = $r1months;
				  	$data["forecast_firstmonth_display"] = $f1months;
				  	$data["gross"] = $gross_fmonth;

				  	$data["forecasted_amount"] = $this->Monthly_forecasting_model->day1fa($data);

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["fm"] = $this->Monthly_forecasting_model->_selectAllDayOne($config['per_page'],$offset,$data);

					$this->load->library('pagination');
					$config['base_url'] = base_url('Monthly_forecasting/first_month?monthstart='.$data['monthfs'].'&monthend='.$data['monthfe'].'&ref_monthstart='.$data['ref_smonth'].'&ref_month_end='.$data['ref_emonth'].'&type='.$type);
					$config['total_rows'] = $this->Monthly_forecasting_model->countday1($data);
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

				$data["content"] = 'first_month';
				$this->load->view('backend/template', $data);
				
			}

		}elseif($type=="mrf"){

			$monthstart = $this->input->get('monthstart');
			$monthend = $this->input->get('monthend');

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
				$this->_pageNotFound();
				return;
			}
				
				$ref_monthstart = $this->input->get('ref_monthstart');

				//fmonth//	
				$firstmonthr = strtotime($ref_monthstart);
				// $firstmonth = date ( 'm' ,$firstmonth);
				$firstmonthr = date ( 'Y-m' ,$firstmonthr);

				$result1r = explode("-", $firstmonthr);

				$total1r = cal_days_in_month(CAL_GREGORIAN, $result1r[1], $result1r[0]);
				
				$data['rtmonth_from'] = $result1r[0] . '-' . $result1r[1] . '-' . '01';
				$data['rtmonth_end'] = $result1r[0] . '-' . $result1r[1] . '-' . $total1r;
 

				$result_1r = $this->Monthly_forecasting_model->_getforecast3_val($data);
				
				$results1 = "";

				foreach($result_1r as $row){
					 if($row['qty']==""){
					 	$resulta1 = "0";
					 
					 }else{
					 	$resulta1 = $row['qty'];
					 
					 }

					 $results1 = $resulta1;
				}

				$r_result1 = $results1;

				if($r_result1=="0"){

				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Your Reference month was empty, choose other month.</b></div>');
				redirect('monthly_forecasting/add');
				
				}
				
				// $data['fmonth_from'] = $data['rfmonth_from'];
				// $data['fmonth_end'] = $data['rfmonth_end'];	
				
				//f_fmonth//	
				$f_exist = strtotime($this->input->get('monthstart'));
				// $firstmonth = date ( 'm' ,$firstmonth);
				$f_exist = date( 'Y-m' ,$f_exist);

				$result_f_exist = explode("-", $f_exist);

				$total_f_exist = cal_days_in_month(CAL_GREGORIAN, $result_f_exist[1], $result_f_exist[0]);
				
				$data['f_exist_from'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . '01';
				$data['f_exist_end'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . $total_f_exist;

				$fmonth_exist = $this->Monthly_forecasting_model->fmonth_exist($data);
					
				if($fmonth_exist > 0){
					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected Month-range was already exist.</b></div>');
					redirect('monthly_forecasting/add');

				}else{

				$data['monthfs'] = $this->input->get('monthstart');
				$data['monthfe'] = $this->input->get('monthend');
				$data['ref_smonth'] = $this->input->get('ref_monthstart');
				
				// $r1month_from = $result1r[1] . '/' . '01' . '/' . $result1r[0];
				// $r1month_end = $result1r[1] . '/' . $total1r . '/' . $result1r[0]; 

				$lastmonth_ref = strtotime($data['ref_smonth']);
				$lastmonth_ref = date( 'Y-m' , $lastmonth_ref);

				$ref_resultavg = explode("-", $lastmonth_ref);

				$totals = cal_days_in_month(CAL_GREGORIAN, $ref_resultavg[1], $ref_resultavg[0]);
				
				$data['ref_month_from'] = $ref_resultavg[0] . '-' . $ref_resultavg[1] . '-' . '01';
				$data['ref_month_end'] = $ref_resultavg[0] . '-' . $ref_resultavg[1] . '-' . $totals;
				$data['ref_end_month'] = $ref_resultavg[0] . '-' . $ref_resultavg[1] . '-' . $totals;
				
				$r1months = date('F', mktime(0, 0, 0, $ref_resultavg[1], 10)) . '-' . $ref_resultavg[0];

					//f_fmonth//	
					$firstmonthf = strtotime($this->input->get('monthstart'));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$firstmonthf = date( 'Y-m' ,$firstmonthf);

					$result1f = explode("-", $firstmonthf);

					$total1f = cal_days_in_month(CAL_GREGORIAN, $result1f[1], $result1f[0]);
					
					$data['ffmonth_from'] = $result1f[0] . '-' . $result1f[1] . '-' . '01';
					$data['ffmonth_end'] = $result1f[0] . '-' . $result1f[1] . '-' . $total1f;

				// $f1month_from = $result1f[1] . '/' . '01' . '/' . $result1f[0];
				// $f1month_end = $result1f[1] . '/' . $total1f . '/' . $result1f[0]; 

				$f1months = date('F', mktime(0, 0, 0, $result1f[1], 10)) . '-' . $result1f[0];

				//--1stmonth--//
	    			$gross_fmonth = $this->Monthly_forecasting_model->_gettotalgross1($data);
	    			$result_fmonth = $this->Monthly_forecasting_model->_getforecast1($data);
	    			$this->Monthly_forecasting_model->insert1($gross_fmonth,$result_fmonth,$data);

	    			$gross_fmonth1 = $this->Monthly_forecasting_model->_gettotalgross_avg($data);
	    			$result_fmonth1 = $this->Monthly_forecasting_model->_getforecast_avg($data);

					$this->Monthly_forecasting_model->update1($gross_fmonth1,$result_fmonth1,$data);

				  	$data["ref_firstmonth_display"] = $r1months;
				  	$data["forecast_firstmonth_display"] = $f1months;
				  	$data["gross"] = $gross_fmonth;

				  	$data["forecasted_amount"] = $this->Monthly_forecasting_model->day1fa($data);

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["fm"] = $this->Monthly_forecasting_model->_selectAllDayOne($config['per_page'],$offset,$data);

					$this->load->library('pagination');
					$config['base_url'] = base_url('Monthly_forecasting/first_month?monthstart='.$data['monthfs'].'&monthend='.$data['monthfe'].'&ref_monthstart='.$data['ref_smonth'].'&ref_month_end='.$data['ref_emonth'].'&type='.$type);
					$config['total_rows'] = $this->Monthly_forecasting_model->countday1($data);
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

				$data["content"] = 'first_month';
				$this->load->view('backend/template', $data);
				
			}

		}
				
				
	}

	public function second_month(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');

		if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
		}else{
			$type = "mrf";

		}

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend)) || (!isset($ref_monthstart))){
				$this->_pageNotFound();
				return;
			}

				if($type=="mf"){

					$r1second_month = strtotime ( '-1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$r1secondmonth = date ( 'Y-m' ,$r1second_month);

					$resultr1 = explode("-", $r1secondmonth);

					$totalr1 = cal_days_in_month(CAL_GREGORIAN, $resultr1[1], $resultr1[0]);
					
					$r1smonth_from = $resultr1[0] . '-' . $resultr1[1] . '-' . '01';
					$r1smonth_end = $resultr1[0] . '-' . $resultr1[1] . '-' . $totalr1; 

					$data["ref_month_from"] = $r1smonth_from;
					$data["ref_month_end"] = $r1smonth_end;
					$data["ref_end_month"] = $r1smonth_end;

					// $smonths_from = $resultr1[1] . '/' . '01' . '/' . $resultr1[0];
					// $smonths_end = $resultr1[1] . '/' . $totalr1 . '/' . $resultr1[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr1[1], 10)) . '-' . $resultr1[0];
				
				}else{

					// $r2second_month = strtotime ( '+1 month' , strtotime($ref_monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);

					$lastmonth_ref = strtotime($ref_monthstart);

					$r2secondmonth = date( 'Y-m' , $lastmonth_ref);

					$resultr2 = explode("-", $r2secondmonth);

					$totalr2 = cal_days_in_month(CAL_GREGORIAN, $resultr2[1], $resultr2[0]);
					
					$r2smonth_from = $resultr2[0] . '-' . $resultr2[1] . '-' . '01';
					$r2smonth_end = $resultr2[0] . '-' . $resultr2[1] . '-' . $totalr2; 

					$data["ref_month_from"] = $r2smonth_from;
					$data["ref_month_end"] = $r2smonth_end;
					$data["ref_end_month"] = $r2smonth_end;

					// $smonths_from = $resultr2[1] . '/' . '01' . '/' . $resultr2[0];
					// $smonths_end = $resultr2[1] . '/' . $totalr2 . '/' . $resultr2[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr2[1], 10)) . '-' . $resultr2[0];

				}
				

				//s_fmonth//	
				$f_exist = strtotime ( '+1 month' , strtotime($monthstart));

				$f_exist = date( 'Y-m' ,$f_exist);

				$result_f_exist = explode("-", $f_exist);

				$total_f_exist = cal_days_in_month(CAL_GREGORIAN, $result_f_exist[1], $result_f_exist[0]);
				
				$data['s_exist_from'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . '01';
				$data['s_exist_end'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . $total_f_exist;

				$smonth_exist = $this->Monthly_forecasting_model->smonth_exist($data);

				if($smonth_exist > 0){
					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected Month-range was already exist.</b></div>');
					redirect('monthly_forecasting/add');

				}else{
					
					$data['monthfs'] = $this->input->get('monthstart');
					$data['monthfe'] = $this->input->get('monthend');
					$data['ref_smonth'] = $this->input->get('ref_monthstart');

					$fsecond_month = strtotime ( '+1 month' , strtotime($data['monthfs']));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$fsecondmonth = date ( 'Y-m' ,$fsecond_month);

					$resultf1 = explode("-", $fsecondmonth);

					$totalf = cal_days_in_month(CAL_GREGORIAN, $resultf1[1], $resultf1[0]);

					// $smonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $smonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

					$smonths_f = date('F', mktime(0, 0, 0, $resultf1[1], 10)) . '-' . $resultf1[0];

					$data['ssmonth_from'] = $resultf1[0] . '-' . $resultf1[1] . '-' . '01';
					$data['ssmonth_end'] = $resultf1[0] . '-' . $resultf1[1] . '-' . $totalf; 

				//--1stmonth--//
	    			$gross_smonth = $this->Monthly_forecasting_model->_gettotalgross2($data);
	    			$result_smonth = $this->Monthly_forecasting_model->_getforecast2($data);
					$this->Monthly_forecasting_model->insert2($gross_smonth,$result_smonth,$data);

	    			$gross_smonth1 = $this->Monthly_forecasting_model->_gettotalgross_avg($data);
	    			$result_smonth1 = $this->Monthly_forecasting_model->_getforecast_avg($data);
					$this->Monthly_forecasting_model->update2($gross_smonth1,$result_smonth1,$data);

					$data["ref_secondmonth_display"] = $smonths_r;
				  	$data["forecast_secondmonth_display"] = $smonths_f;
				  	$data["gross"] = $gross_smonth;

				  	$data["forecasted_amount"] = $this->Monthly_forecasting_model->day2fa($data);

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["sm"] = $this->Monthly_forecasting_model->_selectAllDayTwo($config['per_page'],$offset,$data);

					$this->load->library('pagination');
					$config['base_url'] = base_url('Monthly_forecasting/second_month?monthstart='.$data['monthfs'].'&monthend='.$data['monthfe'].'&ref_monthstart='.$data['ref_smonth'].'&ref_month_end='.$data['ref_emonth'].'&type='.$type);
					$config['total_rows'] = $this->Monthly_forecasting_model->countday2($data);
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

				$data["content"] = 'second_month';
				$this->load->view('backend/template', $data);
				
			}		
				
	}

	public function third_month(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');

		if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
		}else{
			$type = "mrf";

		}

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend)) || (!isset($ref_monthstart))){
				$this->_pageNotFound();
				return;
			}

				if($type=="mf"){

					$r1second_month = strtotime ( '-1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$r1secondmonth = date ( 'Y-m' ,$r1second_month);

					$resultr1 = explode("-", $r1secondmonth);

					$totalr1 = cal_days_in_month(CAL_GREGORIAN, $resultr1[1], $resultr1[0]);
					
					$r1smonth_from = $resultr1[0] . '-' . $resultr1[1] . '-' . '01';
					$r1smonth_end = $resultr1[0] . '-' . $resultr1[1] . '-' . $totalr1; 

					$data["ref_month_from"] = $r1smonth_from;
					$data["ref_month_end"] = $r1smonth_end;
					$data["ref_end_month"] = $r1smonth_end;
					// $smonths_from = $resultr1[1] . '/' . '01' . '/' . $resultr1[0];
					// $smonths_end = $resultr1[1] . '/' . $totalr1 . '/' . $resultr1[0]; 

					$tmonths_r = date('F', mktime(0, 0, 0, $resultr1[1], 10)) . '-' . $resultr1[0];
				
				}else{

					// $r2second_month = strtotime ( '+1 month' , strtotime($ref_monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$lastmonth_ref = strtotime($ref_monthstart);
					
					$r2secondmonth = date( 'Y-m' , $lastmonth_ref);	

					$resultr2 = explode("-", $r2secondmonth);

					$totalr2 = cal_days_in_month(CAL_GREGORIAN, $resultr2[1], $resultr2[0]);
					
					$r2smonth_from = $resultr2[0] . '-' . $resultr2[1] . '-' . '01';
					$r2smonth_end = $resultr2[0] . '-' . $resultr2[1] . '-' . $totalr2; 

					$data["ref_month_from"] = $r2smonth_from;
					$data["ref_month_end"] = $r2smonth_end;
					$data["ref_end_month"] = $r2smonth_end;
					// $smonths_from = $resultr2[1] . '/' . '01' . '/' . $resultr2[0];
					// $smonths_end = $resultr2[1] . '/' . $totalr2 . '/' . $resultr2[0]; 

					$tmonths_r = date('F', mktime(0, 0, 0, $resultr2[1], 10)) . '-' . $resultr2[0];

				}
				
				//t_fmonth//	
				$f_exist = strtotime ( '+2 month' , strtotime($monthstart));

				$f_exist = date( 'Y-m' ,$f_exist);

				$result_f_exist = explode("-", $f_exist);

				$total_f_exist = cal_days_in_month(CAL_GREGORIAN, $result_f_exist[1], $result_f_exist[0]);
				
				$data['t_exist_from'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . '01';
				$data['t_exist_end'] = $result_f_exist[0] . '-' . $result_f_exist[1] . '-' . $total_f_exist;

				$tmonth_exist = $this->Monthly_forecasting_model->tmonth_exist($data);
					
				if($tmonth_exist > 0){
					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected Month-range was already exist.</b></div>');
					redirect('monthly_forecasting/add');

				}else{

					$data['monthfs'] = $this->input->get('monthstart');
					$data['monthfe'] = $this->input->get('monthend');
					$data['ref_smonth'] = $this->input->get('ref_monthstart');
					
					$fthird_month = strtotime ( '+2 month' , strtotime($data['monthfs']));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$fthirdmonth = date ( 'Y-m' ,$fthird_month);

					$resultf1 = explode("-", $fthirdmonth);

					$totalf = cal_days_in_month(CAL_GREGORIAN, $resultf1[1], $resultf1[0]);

					// $tmonth_from_f = $resultf1[1] . '/' . '01' . '/' . $resultf1[0];
					// $tmonth_end_f = $resultf1[1] . '/' . $totalf . '/' . $resultf1[0]; 

					$data['ttmonth_from'] = $resultf1[1] . '-' . '01' . '-' . $resultf1[0];
					$data['ttmonth_end'] = $resultf1[1] . '-' . $totalf . '-' . $resultf1[0];

					$tmonths_f = date('F', mktime(0, 0, 0, $resultf1[1], 10)) . '-' . $resultf1[0];

				//--1stmonth--//	
	    			$gross_tmonth = $this->Monthly_forecasting_model->_gettotalgross3($data);
	    			$result_tmonth = $this->Monthly_forecasting_model->_getforecast3($data);
	    			$this->Monthly_forecasting_model->insert3($gross_tmonth,$result_tmonth,$data);

	    			$gross_tmonth1 = $this->Monthly_forecasting_model->_gettotalgross_avg($data);
	    			$result_tmonth1 = $this->Monthly_forecasting_model->_getforecast_avg($data);
					$this->Monthly_forecasting_model->update3($gross_tmonth1,$result_tmonth1,$data);

				  	$data["ref_thirdmonth_display"] = $tmonths_r;
				  	$data["forecast_thirdmonth_display"] = $tmonths_f;
				  	$data["gross"] = $gross_tmonth;

				  	$data["forecasted_amount"] = $this->Monthly_forecasting_model->day3fa($data);

				  	$offset = (int)$this->input->get('per_page');
					$config["per_page"] = 100;

					$data["tm"] = $this->Monthly_forecasting_model->_selectAllDayThree($config['per_page'],$offset,$data);

					$this->load->library('pagination');
					$config['base_url'] = base_url('Monthly_forecasting/third_month?monthstart='.$data['monthfs'].'&monthend='.$data['monthfe'].'&ref_monthstart='.$data['ref_smonth'].'&ref_month_end='.$data['ref_emonth'].'&type='.$type);
					$config['total_rows'] = $this->Monthly_forecasting_model->countday3($data);
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

				$data["content"] = 'third_month';
				$this->load->view('backend/template', $data);
				
			}		
				
	}

	public function summary_forecast(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');
		$ref_month_end = $this->input->get('ref_month_end');

		$type = $this->input->get('type');

		if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
		}else{
			$type = "mrf";

		}

			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend)) || (!isset($ref_monthstart)) || (!isset($ref_month_end))){
				$this->_pageNotFound();
				return;
			}

				if($type=="mf"){

					$r1second_month = strtotime ( '-1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$r1secondmonth = date ( 'Y-m' ,$r1second_month);

					$resultr1 = explode("-", $r1secondmonth);

					$totalr1 = cal_days_in_month(CAL_GREGORIAN, $resultr1[1], $resultr1[0]);
					
					$r1smonth_from = $resultr1[0] . '-' . $resultr1[1] . '-' . '01';
					$r1smonth_end = $resultr1[0] . '-' . $resultr1[1] . '-' . $totalr1; 

					$data["ref_month_from"] = $r1smonth_from;
					$data["ref_month_end"] = $r1smonth_end;
					$data["ref_end_month"] = $r1smonth_end;
					// $smonths_from = $resultr1[1] . '/' . '01' . '/' . $resultr1[0];
					// $smonths_end = $resultr1[1] . '/' . $totalr1 . '/' . $resultr1[0]; 

					$tmonths_r = date('F', mktime(0, 0, 0, $resultr1[1], 10)) . '-' . $resultr1[0];
				
				}else{

					// $r2second_month = strtotime ( '+1 month' , strtotime($ref_monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$lastmonth_ref = strtotime($ref_monthstart);
					
					$r2secondmonth = date( 'Y-m' , $lastmonth_ref);	

					$resultr2 = explode("-", $r2secondmonth);

					$totalr2 = cal_days_in_month(CAL_GREGORIAN, $resultr2[1], $resultr2[0]);
					
					$r2smonth_from = $resultr2[0] . '-' . $resultr2[1] . '-' . '01';
					$r2smonth_end = $resultr2[0] . '-' . $resultr2[1] . '-' . $totalr2; 

					$data["ref_month_from"] = $r2smonth_from;
					$data["ref_month_end"] = $r2smonth_end;
					$data["ref_end_month"] = $r2smonth_end;
					// $smonths_from = $resultr2[1] . '/' . '01' . '/' . $resultr2[0];
					// $smonths_end = $resultr2[1] . '/' . $totalr2 . '/' . $resultr2[0]; 

					$tmonths_r = date('F', mktime(0, 0, 0, $resultr2[1], 10)) . '-' . $resultr2[0];

				}

			if($monthstart == "" || $monthend == ""){
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid month-range selected.</b></div>');
				redirect('monthly_forecasting/add');

			}

					//fmonth//	
					$firstmonthf = strtotime($monthstart);
					// $firstmonth = date ( 'm' ,$firstmonth);
					$firstmonthf = date ( 'Y-m' ,$firstmonthf);

					$result1f = explode("-", $firstmonthf);

					$total1f = cal_days_in_month(CAL_GREGORIAN, $result1f[1], $result1f[0]);
					
					$data['f_exist_from'] = $result1f[0] . '-' . $result1f[1] . '-' . '01';
					$data['f_exist_end'] = $result1f[0] . '-' . $result1f[1] . '-' . $total1f;

					$data['month1'] = date('F', mktime(0, 0, 0, $result1f[1], 10)) . '-' . $result1f[0];

				//smonth//	
					$secondmonthf = strtotime ( '+1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$secondmonthf = date ( 'Y-m' ,$secondmonthf);

					$result2f = explode("-", $secondmonthf);

					$total2f = cal_days_in_month(CAL_GREGORIAN, $result2f[1], $result2f[0]);
					
					$data['s_exist_from'] = $result2f[0] . '-' . $result2f[1] . '-' . '01';
					$data['s_exist_end'] = $result2f[0] . '-' . $result2f[1] . '-' . $total2f;

					$data['month2'] = date('F', mktime(0, 0, 0, $result2f[1], 10)) . '-' . $result2f[0];
				//tmonth//	
					$thirdmonthf = strtotime ( '+2 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$thirdmonthf = date ( 'Y-m' ,$thirdmonthf);

					$result3f = explode("-", $thirdmonthf);

					$total3f = cal_days_in_month(CAL_GREGORIAN, $result3f[1], $result3f[0]);
					
					$data['t_exist_from'] = $result3f[0] . '-' . $result3f[1] . '-' . '01';
					$data['t_exist_end'] = $result3f[0] . '-' . $result3f[1] . '-' . $total3f;

					$data['month3'] = date('F', mktime(0, 0, 0, $result3f[1], 10)) . '-' . $result3f[0];

				$fmonth_exist = $this->Monthly_forecasting_model->fmonth_exist($data);
				$smonth_exist = $this->Monthly_forecasting_model->smonth_exist($data);
				$tmonth_exist = $this->Monthly_forecasting_model->tmonth_exist($data);	
					
				if($fmonth_exist > 0 || $smonth_exist > 0 || $tmonth_exist > 0){
					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected Month-range was already exist.</b></div>');
					redirect('monthly_forecasting/add');

				}else{	
				
					$data["ffmonth_from"] = $data['f_exist_from'];
					$data["ffmonth_end"] = $data['f_exist_end'];

					$data["ssmonth_from"] = $data['s_exist_from'];
					$data["ssmonth_end"] = $data['s_exist_end'];

					$data["ttmonth_from"] = $data['t_exist_from'];
					$data["ttmonth_end"] = $data['t_exist_end'];


					$data['gross1'] = $this->Monthly_forecasting_model->_getgross_sf1($data);

					$data['gross2'] = $this->Monthly_forecasting_model->_getgross_sf2($data);

					$data['gross3'] = $this->Monthly_forecasting_model->_getgross_sf3($data);

					$search = $this->input->get('search');
				  	$data['search'] = $search;
					$data['sf'] = $this->Monthly_forecasting_model->_selectsf($data,$search);

				$data["content"] = 'summary_forecast';
				$this->load->view('backend/template_pm', $data);

			}
		
	}


//------------------------------for 1stmonth

	public function update1(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$ref_date_from = $this->input->post('ref_date_from');
		$ref_date_to = $this->input->post('ref_date_to');

		if($forecasted_amount != "" || $date_from != "" || $date_to != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date_from"] = $date_from;
			$data["date_to"] = $date_to;
			$data["ref_date_from"] = $ref_date_from;
			$data["ref_date_to"] = $ref_date_to;

			$this->Monthly_forecasting_model->_updatefa1($data);		
			$update_result = $this->Monthly_forecasting_model->_processfa1($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo1(){
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');
		$ref_month_end = $this->input->get('ref_month_end');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Monthly_forecasting_model->_processfo1($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('monthly_forecasting/first_month?monthstart=' . $monthstart . '&monthend=' . $monthend . '&ref_monthstart=' . $ref_monthstart . '&ref_month_end=' . $ref_month_end . '&type=' . $type);
		}

	}

	public function u_update1(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		if($forecasted_amount != "" || $date_from != "" || $date_to != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date_from"] = $date_from;
			$data["date_to"] = $date_to;

			$this->Monthly_forecasting_model->_updatefa1($data);		
			$update_result = $this->Monthly_forecasting_model->_processfa1($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo1(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Monthly_forecasting_model->_processfo1($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('monthly_forecasting/first_month_forecast?start_month=' . $monthstart . '&end_month=' . $monthend . '&version=' . $version);
		}

	}

//------------------------------for 2ndmonth

	public function update2(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$ref_date_from = $this->input->post('ref_date_from');
		$ref_date_to = $this->input->post('ref_date_to');

		if($forecasted_amount != "" || $date_from != "" || $date_to != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date_from"] = $date_from;
			$data["date_to"] = $date_to;
			$data["ref_date_from"] = $ref_date_from;
			$data["ref_date_to"] = $ref_date_to;

			$this->Monthly_forecasting_model->_updatefa2($data);		
			$update_result = $this->Monthly_forecasting_model->_processfa2($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo2(){
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');
		$ref_month_end = $this->input->get('ref_month_end');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Monthly_forecasting_model->_processfo2($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('monthly_forecasting/second_month?monthstart=' . $monthstart . '&monthend=' . $monthend . '&ref_monthstart=' . $ref_monthstart . '&ref_month_end=' . $ref_month_end . '&type=' . $type);
		
		}

	}

	public function u_update2(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		if($forecasted_amount != "" || $date_from != "" || $date_to != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date_from"] = $date_from;
			$data["date_to"] = $date_to;

			$this->Monthly_forecasting_model->_updatefa2($data);		
			$update_result = $this->Monthly_forecasting_model->_processfa2($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo2(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Monthly_forecasting_model->_processfo2($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('monthly_forecasting/second_month_forecast?start_month=' . $monthstart . '&end_month=' . $monthend . '&version=' . $version);
		}

	}

//------------------------------for 3rdmonth

	public function update3(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$ref_date_from = $this->input->post('ref_date_from');
		$ref_date_to = $this->input->post('ref_date_to');

		if($forecasted_amount != "" || $date_from != "" || $date_to != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date_from"] = $date_from;
			$data["date_to"] = $date_to;
			$data["ref_date_from"] = $ref_date_from;
			$data["ref_date_to"] = $ref_date_to;

			$this->Monthly_forecasting_model->_updatefa3($data);		
			$update_result = $this->Monthly_forecasting_model->_processfa3($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function adjfo3(){
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');
		$ref_month_end = $this->input->get('ref_month_end');

		$type = $this->input->get('type');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Monthly_forecasting_model->_processfo3($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('monthly_forecasting/third_month?monthstart=' . $monthstart . '&monthend=' . $monthend . '&ref_monthstart=' . $ref_monthstart . '&ref_month_end=' . $ref_month_end . '&type=' . $type);
		
		}

	}

	public function u_update3(){
		$forecasted_amount = $this->input->post('forecasted_amount');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		if($forecasted_amount != "" || $date_from != "" || $date_to != ""){
			$data["forecasted_amount"] = $forecasted_amount;
			$data["date_from"] = $date_from;
			$data["date_to"] = $date_to;

			$this->Monthly_forecasting_model->_updatefa3($data);		
			$update_result = $this->Monthly_forecasting_model->_processfa3($data);

			if($update_result>0){
		  	print json_encode(array("status"=>"success","data"=>$forecasted_amount)); 
			}

		}

	}

	public function u_adjfo3(){
		$startdate = $this->input->get('startdate');
		$end_date = $this->input->get('end_date');

		$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$version = $this->input->get('version');

		$adjustment = $this->input->post('adjustments');

		$count = count($adjustment);

		$data['adjustment'] = $adjustment;
		$data['count'] = $count;

		$res1 = $this->Monthly_forecasting_model->_processfo3($data);		

		if($res1>0){
			$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Adjustment was successfully saved.</b></div>');
			redirect('monthly_forecasting/third_month_forecast?start_month=' . $monthstart . '&end_month=' . $monthend . '&version=' . $version);
		}

	}	

	public function save_forecast(){
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$ref_monthstart = $this->input->get('ref_monthstart');
		$ref_monthend = $this->input->get('ref_monthend');

		$data['monthstart'] = $monthstart;
		$data['monthend'] = $monthend;
			
			if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
				$this->_pageNotFound();
				return;
			}

			if($monthstart == "" || $monthend == ""){
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid month-range selected.</b></div>');
				redirect('monthly_forecasting/add');

			}

			if($ref_monthstart == "" || $ref_monthstart == "--/--"){
			$type = "mf";
		
			}else{
				$type = "mrf";

			}
				if($type=="mf"){

					$r1second_month = strtotime ( '-1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$r1secondmonth = date ( 'Y-m' ,$r1second_month);

					$resultr1 = explode("-", $r1secondmonth);

					$totalr1 = cal_days_in_month(CAL_GREGORIAN, $resultr1[1], $resultr1[0]);
					
					$r1smonth_from = $resultr1[0] . '-' . $resultr1[1] . '-' . '01';
					$r1smonth_end = $resultr1[0] . '-' . $resultr1[1] . '-' . $totalr1; 

					$data["ref_month_from"] = $r1smonth_from;
					$data["ref_month_end"] = $r1smonth_end;

					// $smonths_from = $resultr1[1] . '/' . '01' . '/' . $resultr1[0];
					// $smonths_end = $resultr1[1] . '/' . $totalr1 . '/' . $resultr1[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr1[1], 10)) . '-' . $resultr1[0];
					
					$data['smonths_r'] = $smonths_r;

				}else{

					// $r2second_month = strtotime ( '+1 month' , strtotime($ref_monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);

					$lastmonth_ref = strtotime($ref_monthstart);

					$r2secondmonth = date( 'Y-m' , $lastmonth_ref);

					$resultr2 = explode("-", $r2secondmonth);

					$totalr2 = cal_days_in_month(CAL_GREGORIAN, $resultr2[1], $resultr2[0]);
					
					$r2smonth_from = $resultr2[0] . '-' . $resultr2[1] . '-' . '01';
					$r2smonth_end = $resultr2[0] . '-' . $resultr2[1] . '-' . $totalr2; 

					$data["ref_month_from"] = $r2smonth_from;
					$data["ref_month_end"] = $r2smonth_end;

					// $smonths_from = $resultr2[1] . '/' . '01' . '/' . $resultr2[0];
					// $smonths_end = $resultr2[1] . '/' . $totalr2 . '/' . $resultr2[0]; 

					$smonths_r = date('F', mktime(0, 0, 0, $resultr2[1], 10)) . '-' . $resultr2[0];

					$data['smonths_r'] = $smonths_r;

				}
				
			//fmonth//	
					$firstmonthf = strtotime($monthstart);
					// $firstmonth = date ( 'm' ,$firstmonth);
					$firstmonthf = date ( 'Y-m' ,$firstmonthf);

					$result1f = explode("-", $firstmonthf);

					$total1f = cal_days_in_month(CAL_GREGORIAN, $result1f[1], $result1f[0]);
					
					$data['f_exist_from'] = $result1f[0] . '-' . $result1f[1] . '-' . '01';
					$data['f_exist_end'] = $result1f[0] . '-' . $result1f[1] . '-' . $total1f;

				//smonth//	
					$secondmonthf = strtotime ( '+1 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$secondmonthf = date ( 'Y-m' ,$secondmonthf);

					$result2f = explode("-", $secondmonthf);

					$total2f = cal_days_in_month(CAL_GREGORIAN, $result2f[1], $result2f[0]);
					
					$data['s_exist_from'] = $result2f[0] . '-' . $result2f[1] . '-' . '01';
					$data['s_exist_end'] = $result2f[0] . '-' . $result2f[1] . '-' . $total2f;

				//tmonth//	
					$thirdmonthf = strtotime ( '+2 month' , strtotime($monthstart));
					// $firstmonth = date ( 'm' ,$firstmonth);
					$thirdmonthf = date ( 'Y-m' ,$thirdmonthf);

					$result3f = explode("-", $thirdmonthf);

					$total3f = cal_days_in_month(CAL_GREGORIAN, $result3f[1], $result3f[0]);
					
					$data['t_exist_from'] = $result3f[0] . '-' . $result3f[1] . '-' . '01';
					$data['t_exist_end'] = $result3f[0] . '-' . $result3f[1] . '-' . $total3f;

				$fmonth_exist = $this->Monthly_forecasting_model->fmonth_exist($data);
				$smonth_exist = $this->Monthly_forecasting_model->smonth_exist($data);
				$tmonth_exist = $this->Monthly_forecasting_model->tmonth_exist($data);	
					
				if($fmonth_exist > 0 || $smonth_exist > 0 || $tmonth_exist > 0){
					$this->session->set_flashdata('msg','<div class="alert-box warning"><span class="alert_title"> warning : </span><b>Your selected Month-range was already exist.</b></div>');
					redirect('monthly_forecasting/add');

				}else{

				$data["fmonth_from"] = $data['f_exist_from'];
				$data["fmonth_end"] = $data['f_exist_end'];

				$data["smonth_from"] = $data['s_exist_from'];
				$data["smonth_end"] = $data['s_exist_end'];

				$data["tmonth_from"] = $data['t_exist_from'];
				$data["tmonth_end"] = $data['t_exist_end'];	

				$this->Monthly_forecasting_model->selectitems($data);

				$this->Monthly_forecasting_model->sel_upd($data);		

				$this->print_forecast($data);
		
				}
	}

	public function print_forecast($data){

		$split = explode("-", $data['fmonth_from']);
		$split[1] . '/' . $split[2] . '/' . $split[0];
		
		// $split_1 = explode("-", $data['fmonth_end']);
		// $fmonth_e = $split_1[1] . '/' . $split_1[2] . '/' . $split_1[0];

		$month1 = date('F', mktime(0, 0, 0, $split[1], 10)) . '-' . $split[0];

		$split1 = explode("-", $data['smonth_from']);
		$split1[1] . '/' . $split1[2] . '/' . $split1[0];
		
		// $split1_1 = explode("-", $data['smonth_end']);
		// $smonth_e = $split1_1[1] . '/' . $split1_1[2] . '/' . $split1_1[0];

		$month2 = date('F', mktime(0, 0, 0, $split1[1], 10)) . '-' . $split1[0];
		
		$split2 = explode("-", $data['tmonth_from']);
		$split2[1] . '/' . $split2[2] . '/' . $split2[0];
		
		// $split2_1 = explode("-", $data['tmonth_end']);
		// $tmonth_e = $split2_1[1] . '/' . $split2_1[2] . '/' . $split2_1[0];

		$month3 = date('F', mktime(0, 0, 0, $split2[1], 10)) . '-' . $split2[0];
		
		$results = $this->Monthly_forecasting_model->print_forecasting($data);

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
		$this->excel->getActiveSheet()->setCellValue('E1', $month1);
		$this->excel->getActiveSheet()->setCellValue('F1', $month2);
		$this->excel->getActiveSheet()->setCellValue('G1', $month3);

		$ctr = '2';
		foreach($results as $row){
			
			$split1 = str_split($row['ffo']);
			$split2 = str_split($row['sfo']);
			$split3 = str_split($row['tfo']);
			
			if($split1[0]=="-"){
				$row['ffo']="0";
			}else{
				(ceil($row['ffo']));
			}

			if($split1[0]==""){
				$row['ffo']="0";
			}else{
				(ceil($row['ffo']));
			}

			if($split2[0]=="-"){
				$row['sfo']="0";
			}else{
				(ceil($row['sfo']));
			}

			if($split2[0]==""){
				$row['sfo']="0";
			}else{
				(ceil($row['sfo']));
			}

			if($split3[0]=="-"){
				$row['tfo']="0";
			}else{
				(ceil($row['tfo']));
			}

			if($split3[0]==""){
				$row['tfo']="0";
			}else{
				(ceil($row['tfo']));
			}

			$this->excel->getActiveSheet()->setCellValue('A'.$ctr, $row['material']);
			$this->excel->getActiveSheet()->setCellValue('B'.$ctr, $row['plant']);
			$this->excel->getActiveSheet()->setCellValue('C'.$ctr, '00');
			$this->excel->getActiveSheet()->setCellValue('D'.$ctr, $row['BU']);
			$this->excel->getActiveSheet()->setCellValue('E'.$ctr, ceil($row['ffo']));
			$this->excel->getActiveSheet()->setCellValue('F'.$ctr, ceil($row['sfo']));
			$this->excel->getActiveSheet()->setCellValue('G'.$ctr, ceil($row['tfo']));

			$ctr++;

		}

		// //merge cell A1 until D1
		// // $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->Monthly_forecasting_model->updatesap($data); 			

		$branch = $this->session->userdata('branch');

		$filename=$branch.'_'.$month1.'_TO_'.$month3.'(Monthly_Forecasting).xls'; //save our workbook as this file name
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
		$module_id = "9";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
    	$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
    	$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

    	$monthstart = $this->input->get('monthstart');
		$monthend = $this->input->get('monthend');

		$data['u_version'] = $this->input->get('version');

		$data['version'] = $this->input->get('version') + 1;

		$data['monthstart'] = $monthstart;
		$data['monthend'] = $monthend;
			
		if($result <= 0 || (!isset($monthstart)) || (!isset($monthend))){
			$this->_pageNotFound();
			return;
		}

		if($monthstart == "" || $monthend == ""){
			$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Invalid month-range selected.</b></div>');
			redirect('monthly_forecasting/add');

		}
			
		//fmonth//	
			$firstmonthf = strtotime($monthstart);
			// $firstmonth = date ( 'm' ,$firstmonth);
			$firstmonthf = date ( 'Y-m' ,$firstmonthf);

			$result1f = explode("-", $firstmonthf);

			$total1f = cal_days_in_month(CAL_GREGORIAN, $result1f[1], $result1f[0]);
			
			$data['f_exist_from'] = $result1f[0] . '-' . $result1f[1] . '-' . '01';
			$data['f_exist_end'] = $result1f[0] . '-' . $result1f[1] . '-' . $total1f;

		//smonth//	
			$secondmonthf = strtotime ( '+1 month' , strtotime($monthstart));
			// $firstmonth = date ( 'm' ,$firstmonth);
			$secondmonthf = date ( 'Y-m' ,$secondmonthf);

			$result2f = explode("-", $secondmonthf);

			$total2f = cal_days_in_month(CAL_GREGORIAN, $result2f[1], $result2f[0]);
			
			$data['s_exist_from'] = $result2f[0] . '-' . $result2f[1] . '-' . '01';
			$data['s_exist_end'] = $result2f[0] . '-' . $result2f[1] . '-' . $total2f;

		//tmonth//	
			$thirdmonthf = strtotime ( '+2 month' , strtotime($monthstart));
			// $firstmonth = date ( 'm' ,$firstmonth);
			$thirdmonthf = date ( 'Y-m' ,$thirdmonthf);

			$result3f = explode("-", $thirdmonthf);

			$total3f = cal_days_in_month(CAL_GREGORIAN, $result3f[1], $result3f[0]);
			
			$data['t_exist_from'] = $result3f[0] . '-' . $result3f[1] . '-' . '01';
			$data['t_exist_end'] = $result3f[0] . '-' . $result3f[1] . '-' . $total3f;


		$data["fmonth_from"] = $data['f_exist_from'];
		$data["fmonth_end"] = $data['f_exist_end'];

		$data["smonth_from"] = $data['s_exist_from'];
		$data["smonth_end"] = $data['s_exist_end'];

		$data["tmonth_from"] = $data['t_exist_from'];
		$data["tmonth_end"] = $data['t_exist_end'];	

		$this->Monthly_forecasting_model->update_a_upd($data);

		$this->Monthly_forecasting_model->selectitems_forupdate($data);
		// $this->Monthly_forecasting_model->selectitems($data);

		$this->Monthly_forecasting_model->sel_upd_forupdate($data);		

		$this->print_update_forecast($data);
			
	}

	public function print_update_forecast($data){

		$split = explode("-", $data['fmonth_from']);
		$split[1] . '/' . $split[2] . '/' . $split[0];
		
		// $split_1 = explode("-", $data['fmonth_end']);
		// $fmonth_e = $split_1[1] . '/' . $split_1[2] . '/' . $split_1[0];

		$month1 = date('F', mktime(0, 0, 0, $split[1], 10)) . '-' . $split[0];

		$split1 = explode("-", $data['smonth_from']);
		$split1[1] . '/' . $split1[2] . '/' . $split1[0];
		
		// $split1_1 = explode("-", $data['smonth_end']);
		// $smonth_e = $split1_1[1] . '/' . $split1_1[2] . '/' . $split1_1[0];

		$month2 = date('F', mktime(0, 0, 0, $split1[1], 10)) . '-' . $split1[0];
		
		$split2 = explode("-", $data['tmonth_from']);
		$split2[1] . '/' . $split2[2] . '/' . $split2[0];
		
		// $split2_1 = explode("-", $data['tmonth_end']);
		// $tmonth_e = $split2_1[1] . '/' . $split2_1[2] . '/' . $split2_1[0];

		$month3 = date('F', mktime(0, 0, 0, $split2[1], 10)) . '-' . $split2[0];
		
		$results = $this->Monthly_forecasting_model->print_forecasting_update($data);

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
		$this->excel->getActiveSheet()->setCellValue('E1', $month1);
		$this->excel->getActiveSheet()->setCellValue('F1', $month2);
		$this->excel->getActiveSheet()->setCellValue('G1', $month3);

		$ctr = '2';
		foreach($results as $row){
			
			$split1 = str_split($row['ffo']);
			$split2 = str_split($row['sfo']);
			$split3 = str_split($row['tfo']);
			
			if($split1[0]=="-"){
				$row['ffo']="0";
			}else{
				(ceil($row['ffo']));
			}

			if($split1[0]==""){
				$row['ffo']="0";
			}else{
				(ceil($row['ffo']));
			}

			if($split2[0]=="-"){
				$row['sfo']="0";
			}else{
				(ceil($row['sfo']));
			}

			if($split2[0]==""){
				$row['sfo']="0";
			}else{
				(ceil($row['sfo']));
			}

			if($split3[0]=="-"){
				$row['tfo']="0";
			}else{
				(ceil($row['tfo']));
			}

			if($split3[0]==""){
				$row['tfo']="0";
			}else{
				(ceil($row['tfo']));
			}

			$this->excel->getActiveSheet()->setCellValue('A'.$ctr, $row['material']);
			$this->excel->getActiveSheet()->setCellValue('B'.$ctr, $row['plant']);
			$this->excel->getActiveSheet()->setCellValue('C'.$ctr, '00');
			$this->excel->getActiveSheet()->setCellValue('D'.$ctr, $row['BU']);
			$this->excel->getActiveSheet()->setCellValue('E'.$ctr, ceil($row['ffo']));
			$this->excel->getActiveSheet()->setCellValue('F'.$ctr, ceil($row['sfo']));
			$this->excel->getActiveSheet()->setCellValue('G'.$ctr, ceil($row['tfo']));

			$ctr++;

		}

		// //merge cell A1 until D1
		// // $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->Monthly_forecasting_model->updatesap_forecast($data); 			

		$branch = $this->session->userdata('branch');

		$filename=$branch.'_'.$month1.'_TO_'.$month3.'(Updated_Monthly_Forecasting).xls'; //save our workbook as this file name
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
/* Location: ./application/controllers/monthly_forecasting.php */
