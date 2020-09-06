<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MS_Controller extends CI_Controller {

	protected $userid;
	protected $username;
	protected $usememail;
	protected $usermobile;
	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('quiz_user_ph')){
			redirect(base_url());
		}
		$this->userid = $this->session->userdata['quiz_user_ph']['id'];
		$this->username = $this->session->userdata['quiz_user_ph']['name'];
		$this->usememail = $this->session->userdata['quiz_user_ph']['email'];
		$this->usermobile = $this->session->userdata['quiz_user_ph']['mobile'];
	}
	
	/*public function js($name)
    { 
        $this->output->set_content_type('application/javascript');
        $this->load->view('front/js/'.$name.'_js');
    }*/
}
?>