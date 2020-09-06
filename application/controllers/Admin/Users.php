<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
			'table' => 'users',
			'select' => array('id','name','email','mobile','create_at','update_at'),
		);
		$users = $this->model->get_records($option);
		
		$paging_opt = array(
			'url' => 'Users/',
			'per_page' => 10,
			'uri_segment' => 2,
			'rowscount' => count($users)
		);
		$page = ($this->uri->segment(2))? $this->uri->segment(2) : 0;
		$option['limit'] = 10;
		$option['offset'] = $page;
		$data['users'] = $this->model->get_records($option);
		$data['link'] = cipagination($paging_opt);
		$data['pageTitle'] = 'Pitreshwar Hanuman mandir|Admin'; 
		$data['view'] = 'users/list';
		$this->template->adminBase($data);
	}

	public function user_quiz($uid)
	{
		$users_info = $this->model->get_row('users', array('id' => $uid));
		if(!empty($users_info)){
			$data = array(
				'name' => $users_info['name'],
				'mobile' => $users_info['mobile'],
			);
			$option = array(
				'table' => 'user_answered',
				'select' => array('id','userId','answer','score','create_at'),
				'where' => array('userId' => $uid)
			);
			$users_quiz = $this->model->get_records($option);
			
			$paging_opt = array(
				'url' => 'Users_allquiz/'.$uid.'/',
				'per_page' => 2,
				'uri_segment' => 3,
				'rowscount' => count($users_quiz)
			);
			$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
			$option['limit'] = 2;
			$option['offset'] = $page;
			$data['user_quiz'] = $this->model->get_records($option);
			$data['link'] = cipagination($paging_opt);
			$data['pageTitle'] = 'Pitreshwar Hanuman mandir|Admin'; 
			$data['view'] = 'users/quizlist';
			$this->template->adminBase($data);
		}else{
			$this->session->set_flashdata('error_msg','Invalid user');
			redirect('Users','refresh');
		}
	}



	/*public function Delete_question($id)
	{
		$data = array('status' => 'Inactive');
		$where = array('id' => $id);
		$qid = $this->model->update('users',$data,$where);
		if($qid){
			$this->session->set_flashdata('success_msg','Question deleted successfully');
		}else{
			$this->session->set_flashdata('error_msg','Something went wrong try after sometime');
		}
		redirect('Questions');
	}*/
}
