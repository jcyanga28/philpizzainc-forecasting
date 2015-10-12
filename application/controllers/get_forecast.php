<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_forecast extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');
		$this->load->model('Get_forecast_model');
		
	}	

	public function index(){
		$module_id = "10";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if($result>0){
			$this->getForecast_Content();
		
		}else{
			$this->_pageNotFound();
			return;
		
		}
	} 

	public function getForecast_Content(){
		$role_id = $this->session->userdata('role_id');
		$branch_id = $this->session->userdata('branch_id');
        
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
		
		// echo $newdate;
		$data['count'] = count($this->Get_forecast_model->count_all_sap_forecast());
		// // $data['result'] = $this->Monthly_forecasting_model->all_sap_forecast();

		// $offset = (int)$this->input->get('per_page');
		// $config["per_page"] = 10;

		$data["result"] = $this->Get_forecast_model->all_sap_forecast();

		// $config['per_page'],$offset
		// $this->load->library('pagination');
		// $config['base_url'] = base_url('monthly_forecasting?month_from='.$data['month_from'].'&month_to='.$data['month_to']);
		// $config['total_rows'] = count($this->Get_forecast_model->count_all_sap_forecast());
		// $config['page_query_string'] = TRUE;

		// $config['full_tag_open'] = "<ul class='pagination'>";
		// $config['full_tag_close'] ="</ul>";
		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';
		// $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		// $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		// $config['next_tag_open'] = "<li>";
		// $config['next_tagl_close'] = "</li>";
		// $config['prev_tag_open'] = "<li>";
		// $config['prev_tagl_close'] = "</li>";
		// $config['first_tag_open'] = "<li>";
		// $config['first_tagl_close'] = "</li>";
		// $config['last_tag_open'] = "<li>";
		// $config['last_tagl_close'] = "</li>";

		// $this->pagination->initialize($config);
		// $data["links"] = $this->pagination->create_links();

		$data["plant_name"] = $this->Get_forecast_model->get_plantname($branch_id);

		$data["content"] = 'get_forecast';
		$this->load->view('backend/template', $data);

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
/* Location: ./application/controllers/get_forecast.php */
