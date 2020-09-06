<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moms_dashboard extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()
	{
		echo "Welcome";
		//$this->load->view('welcome_message');
	}

	
}
