<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plant extends Admin_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('Admin_model');	
		$this->load->model('Plant_model');
	
	}	

	public function index($id){
		
		$id = $_GET['id'];

		$module_id = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if((is_null($id)) || (!is_numeric($id))){
			$this->_pageNotFound();
			return;

		}

		if($result>0){
			
			$this->getPlant_Content($id);
		
		}else{
			$this->_pageNotFound();
			return;
		
		}

	} 

	public function getPlant_Content($id,$msg=''){
		$role_id = $this->session->userdata('role_id');

		$search = $this->input->get('search');
				
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['jquery'] = array('table-sorter/table-sorter.js');
		
		$data['msg'] = $msg;	
		$data['search'] = $search;
		$data['warehouse_name'] = $this->Plant_model->warehouse_name($id);
		$data['plant'] = $this->Plant_model->_getplantContent($id,$search);
		$data['assign_user'] = $this->Plant_model->assign_user($id);	

		$data["content"] = 'plant';
		$this->load->view('backend/template', $data);


	}

	public function add($id,$msg=''){
		
		$module_id = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exist($module_id,$role_id);

		if((is_null($id)) || (!is_numeric($id))){
			$this->_pageNotFound();
			return;

		}

		if($result<=0){
			$this->_pageNotFound();
			return;
		}

		if(!$_POST){
			$this->getAdd_Plant($id);

		}else{
			$this->postAdd_Plant($id);

		}

	}

	public function getAdd_Plant($id){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['warehouse_name'] = $this->Plant_model->warehouse_name($id);
		$data['id'] = $id;
		$data['content'] = 'add';
		$this->load->view('backend/template', $data);
	}

	public function postAdd_Plant($id){

		$validation = array(
			array(
				"field" => "plant",
				"label" => "Plant Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Plant Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Plant Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if ($this->form_validation->run() == FALSE){
			$this->getAdd_Plant($id);
		
		}else{

			$plant_id = $this->Plant_model->addPlant($id);	
			if($plant_id>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Plant Name is successfully added.</b></div>');
				redirect('plant?id='.$id);
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Plant Name already exist.</b></div>');
				redirect('plant/add/'.$id);
			}

		}

	}

	public function edit($id = null,$warehouse_id){
		$module = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exists($module,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}else{

			if(!$_POST){
				$this->getEdit_Plant($id,$warehouse_id);

			}else{
				$this->postEdit_Plant($id,$warehouse_id);

			}
		}	
	}

	public function getEdit_Plant($id,$warehouse_id){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['plant'] = $this->Plant_model->details($id,$warehouse_id);

		$data['warehouse_name'] = $this->Plant_model->warehouse_name($warehouse_id);
		$data['id'] = $warehouse_id;
		$data['content'] = 'edit';
		$this->load->view('backend/template', $data);

	}

	public function postEdit_Plant($id,$warehouse_id){
		
		$validation = array(
			array(
				"field" => "plant",
				"label" => "Plant Name",
				"rules" => "trim|required"
				));

		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('required', ' <b><span>WARNING : </span>Plant Name is required.</b>');
		$this->form_validation->set_message('is_unique', 'Plant Name is already exist.');
		$this->form_validation->set_error_delimiters('<div  class="alert-box warning">', '</div>');
		
		if($this->form_validation->run() == FALSE){
			$this->getEdit_Plant($id,$warehouse_id);
		
		}else{

			if($this->Plant_model->updatePlant($id,$warehouse_id)){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Plant Name is successfully updated.</b></div>');
				redirect('plant?id='.$warehouse_id);
			}else{
				$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Plant Name already exist.</b></div>');
				redirect('plant/edit/'.$id.'/'.$warehouse_id);
			}

		}

	}

	public function delete($id = null,$warehouse_id){
		$module = "7";
		$role_id = $this->session->userdata('role_id');

		$result = $this->Admin_model->check_if_exists($module,$role_id);

		if($result<=0){
			$this->_pageNotFound();
			return;
		}else{
			
			if(!$_POST){
				$this->getDelete_Plant($id,$warehouse_id);

			}else{
				if(!$this->Plant_model->delete($id,$warehouse_id)){
						redirect('plant/delete/'.$id.'/'.$warehouse_id);
				}else{
					$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Plant Name is successfully deleted.</b></div>');
					redirect('plant?id='.$warehouse_id);
				}
			}
		}	

	}

	public function getDelete_Plant($id,$warehouse_id){
		$role_id = $this->session->userdata('role_id');
		
		$data['module'] = $this->Admin_model->ModuleAllow_Access($role_id);
		$data['file_maintenance'] = $this->Admin_model->FileMaintenance_Header($role_id);
		$data['forecasting'] = $this->Admin_model->Forecasting_Header($role_id);

		$data['plant'] = $this->Plant_model->details($id,$warehouse_id);

		$data['warehouse_name'] = $this->Plant_model->warehouse_name($warehouse_id);
		$data['id'] = $warehouse_id;
		$data['content'] = 'delete';
		$this->load->view('backend/template', $data);

	}

	public function get_plant(){
		$plant_id = $this->input->post('plant_id');
		
		print json_encode(array("status"=>"success","data"=>$plant_id));
	}

	public function assigned_user(){
		$data['id'] = $this->input->post('id');
		$data['warehouse_id'] = $this->input->post('warehouse_id');
		$data['user_id'] = $this->input->post('user');
		
		if($data['user_id']==""){
		 	$this->session->set_flashdata('msg','<div class="alert-box error"><span class="alert_title"> error : </span><b>Make sure you choose user first.</b></div>');
			redirect('plant?id='.$data['warehouse_id']);	
		
		}else{
			$result = $this->Plant_model->update_assignuser($data);

			if($result>0){
				$this->session->set_flashdata('msg','<div class="alert-box success"><span class="alert_title"> success : </span><b>Assign user in Plant was successfully updated.</b></div>');
				redirect('plant?id='.$data['warehouse_id']);
			
			}

		}

	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/plant.php */
