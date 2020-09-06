<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->session->unset_userdata('logged_admin_session');
		$this->session->sess_destroy();
		redirect('Msa-Login','refresh');
	}
}
?>