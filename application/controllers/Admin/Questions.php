<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('logged_admin_session')){
			redirect('Admin_login');
		}
	}

	public function index()
	{
		$data = array();
		$option = array(
			'table' => 'questions',
			'select' => array('id','question','option_1','option_2','option_3','option_4','right_answer',
				'mark','status','create_at','update_at'),
			'where' => array('status' => 'Active'),
			'order' => array('create_at' => 'desc')
		);
		$questions = $this->model->get_records($option);
		
		$paging_opt = array(
			'url' => 'Questions/',
			'per_page' => 4,
			'uri_segment' => 2,
			'rowscount' => count($questions)
		);
		$page = ($this->uri->segment(2))? $this->uri->segment(2) : 0;
		$option['limit'] = 4;
		$option['offset'] = $page;
		$data['questions'] = $this->model->get_records($option);
		$data['link'] = cipagination($paging_opt);
		$data['pageTitle'] = 'Pitreshwar Hanuman mandir|Admin'; 
		$data['view'] = 'question/list';
		$this->template->adminBase($data);
	}

	public function add_question()
	{
		$this->form_validation->set_rules('question','Question','trim|required');
		$this->form_validation->set_rules('option_1','option 1','trim|required');
		$this->form_validation->set_rules('option_2','option 2','trim|required');
		$this->form_validation->set_rules('right_answer','Please select right answer','trim|required');
		//$this->form_validation->set_rules('mark','Mark','trim|required');
		if($this->form_validation->run() == true){
			$right_answer = $this->input->post('right_answer');
			$data = array(
				'question' => $this->input->post('question'),
				'option_1' =>  $this->input->post('option_1'),
				'option_2' =>  $this->input->post('option_2'),
				'option_3' =>  $this->input->post('option_3'),
				'option_4' =>  $this->input->post('option_4'),
				//'right_answer' =>  $this->input->post('right_answer'),
				'right_answer' =>  $this->input->post($right_answer),
				'mark' =>  '1',//$this->input->post('mark'),
				'status' => 'Active',
				'create_at' => date('Y-m-d H:i:s'),
				'update_at' => date('Y-m-d H:i:s')
			);
			$qid = $this->model->add('questions',$data);
			if($qid){
				$this->session->set_flashdata('success_msg','Question added successfully');
				redirect('Questions');
			}
		}else{
			$data = array(
				'token_name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			$data['pageTitle'] = 'Pitreshwar Hanuman mandir|Admin'; 
			$data['view'] = 'question/add';
			$this->template->adminBase($data);
		}
	}

	public function edit_question($id)
	{
		$this->form_validation->set_rules('question','Question','trim|required');
		$this->form_validation->set_rules('option_1','option 1','trim|required');
		$this->form_validation->set_rules('option_2','option 2','trim|required');
		$this->form_validation->set_rules('right_answer','Right answer','trim|required');
		//$this->form_validation->set_rules('mark','Mark','trim|required');
		if($this->form_validation->run() == true){
			$right_answer = $this->input->post('right_answer');
			$data = array(
				'question' => $this->input->post('question'),
				'option_1' =>  $this->input->post('option_1'),
				'option_2' =>  $this->input->post('option_2'),
				'option_3' =>  $this->input->post('option_3'),
				'option_4' =>  $this->input->post('option_4'),
				//'right_answer' =>  $this->input->post('right_answer'),
				'right_answer' =>  $this->input->post($right_answer),
				//'mark' =>  $this->input->post('mark'),
				'status' => 'Active',
				'create_at' => date('Y-m-d H:i:s'),
				'update_at' => date('Y-m-d H:i:s')
			);
			$qid = $this->model->update('questions',$data,array('id' => $id));
			if($qid){
				$this->session->set_flashdata('success_msg','Question updated successfully');
				redirect('Questions');
			}
		}else{
			$data = array(
				'token_name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);
			$option = array(
				'table' => 'questions',
				'select' => array('id','question','option_1','option_2','option_3','option_4','right_answer',
					'mark','status','create_at','update_at'),
				'where' => array('id' => $id,'status' => 'Active'),
				'single' => true
			);
			$data['questions'] = $this->model->get_records($option);
			$data['pageTitle'] = 'Pitreshwar Hanuman mandir|Admin'; 
			$data['view'] = 'question/edit';
			$this->template->adminBase($data);
		}
	}

	public function delete_question($id)
	{
		$data = array('status' => 'Inactive');
		$where = array('id' => $id);
		$qid = $this->model->update('questions',$data,$where);
		if($qid){
			$this->session->set_flashdata('success_msg','Question deleted successfully');
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong try after sometime');
		}
		redirect('Questions');
	}
}
