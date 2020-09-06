<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		if($this->session->has_userdata('logged_admin_session')){
			redirect('Msa-Dashboard','refresh');
		}
	}

	public function index()
	{
		$this->form_validation->set_rules('username','username','trim|required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		$data = array('csrf_name' => $this->security->get_csrf_token_name(),
			        'csrf_hash' => $this->security->get_csrf_hash()
				);
		$data['pageTitle'] = 'Mom Supper|Admin';
		if($this->form_validation->run()==TRUE)
		{
			//echo $password = password_hash($this->input->post('password'),PASSWORD_BCRYPT);
			$username = html_escape($this->input->post('username'));
			$password = $this->input->post('password');
			$remember = $this->input->post('remeber');
			$username = $this->security->xss_clean($username);
			
			$rec = $this->login_model->admin_auth($username,$password,'2');
			if($rec){
				foreach ($rec as $value) {
					/*if($remember=='1'){
						setcookie("name", $username, time() + 86400 * 30);
						setcookie("pass", $username, time() + 86400 * 30);
						setcookie("res", $remember, time() + 86400 * 30);
					}else{
						unset($_COOCKIE[""]);
						unset($_COOCKIE[""]);
						unset($_COOCKIE[""]);
						setcookie("", $username, time() -10);
						setcookie("", $username, time() -100);
						setcookie("", $remember, time() -100);
					}*/
					$sess_arr = array('logged_userid' => $value->id,
						'logged_username' => $value->name,
						'logged_useremail' => $value->email,
						'logged_usermobile' => $value->mobile);
				}
				$this->session->set_userdata('logged_admin_session',$sess_arr);
				redirect('Msa-Dashboard','refresh');
			}else{
				$this->session->set_flashdata('message','<div class="text-danger">Invalid Username And Password</div>');
				$this->load->view('admin/login',$data);
			}
		}else{
			$this->load->view('admin/login',$data);
		}
	}

	/*public function create_newpassword(){
		echo $this->general->getHashedPassword('ph_admin@2020##');
	}*/
}
/*
| Login with User agent
| system info = $_SERVER['HTTP_USER_AGENT'];
|
|
|*/