<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('logged_admin_session')){
			redirect('Msa-Login','refresh');
		}
	}

	public function index()
	{
		$data = array();
		$data['total_mom'] = $this->model->record_count('tbl_moms');
		$data['active_mom'] = $this->model->record_count('tbl_moms', array('status' => 'Active'));
		$data['inactive_mom'] = $this->model->record_count('tbl_moms', array('status' => 'Inactive'));
		$data['pageTitle'] = 'MS | Admin'; 
		$data['view'] = 'dashboard';
		$this->template->adminBase($data);
	}
}
