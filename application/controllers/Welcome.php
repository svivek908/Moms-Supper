<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
        parent::__construct();
		//$this->load->model('user');
		//$this->load->helper('user_email');
		
		// Load facebook library
		$this->load->library('facebook');
		
		//check whether user ID is available in cookie or session
		$this->load->helper('cookie');
		$rememberUserId = get_cookie('rememberUserId');
		if(!empty($rememberUserId)){
			$this->session->set_userdata('isUserLoggedIn',TRUE);
			$this->session->set_userdata('userId',$rememberUserId);
			$this->userId = $rememberUserId;
		}elseif($this->session->userdata('isUserLoggedIn')){
            $this->userId = $this->session->userdata('userId');
        }else{
            $this->userId = '';
        }
    }
	public function index()
	{
		/*$data['fbLoginURL'] = $this->facebook->login_url();
		$data['gpLoginURL'] = $this->gClient->createAuthUrl();
		$data['twLoginURL'] = $this->twitter->redirect(1);	
		$this->load->view('welcome_message',$data);*/
		$this->login();
	}

	public function login(){
		//redirect logged in user to dashboard
		/*if($this->userId){
            redirect('Moms_dashboard');
        }*/
		$this->load->model('login_model');

		// Include the google api php libraries
		include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		$this->load->config('social');
		// Google Project API Credentials
		$clientId = $this->config->item('google_client_id');
        $clientSecret = $this->config->item('google_client_secret');
        $redirectUrl = base_url().$this->config->item('google_redirect_url');
		
		// Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if(isset($_GET['code']) && !isset($_GET['state'])) {
            $gClient->authenticate($_GET['code']);
            $this->session->set_userdata('google_access_token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }
		$gp_access_token = $this->session->userdata('google_access_token');
        if (!empty($gp_access_token)) {
            $gClient->setAccessToken($gp_access_token);
        }
		
        $data = array();
		
		//get messages from the session
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
		
		// Check if user is logged in
		if($this->facebook->is_authenticated()){
			// Get user facebook profile details
			$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
			if(!empty($userProfile) && !empty($userProfile['id'])){
				// Preparing data for database insertion
				$first_name = !empty($userProfile['first_name'])?$userProfile['first_name']:'';
				$last_name = !empty($userProfile['last_name'])?$userProfile['last_name']:'';

				$fullname = $first_name .' '. $last_name;

				$userData['oauth_provider'] = 'facebook';
				$userData['oauth_uid'] = !empty($userProfile['id'])?$userProfile['id']:'';
				$userData['full_name'] = $fullname;
				$userData['email'] = !empty($userProfile['email'])?$userProfile['email']:'';
				$userData['gender'] = !empty($userProfile['gender'])?$userProfile['gender']:'';
				$userData['link'] = 'https://www.facebook.com/'.$userData['oauth_uid'];
				$userData['profile_img'] = !empty($userProfile['picture']['data']['url'])?$userProfile['picture']['data']['url']:'';
				// Insert or update user data
				$userData = $this->login_model->checkUser($userData,'tbl_moms');
				
				//set variables in session
				$this->session->set_userdata('isMomsLoggedIn',TRUE);
				$this->session->set_userdata('userId',$userData['id']);
				$this->session->set_userdata('loginType','social');
				
				//redirect to dashboard
				redirect('Dashboard/');
			}else{
				// Get login URL
            	$data['fbLoginURL'] =  $this->facebook->login_url();
				$data['gpLoginURL'] = $gClient->createAuthUrl();
			}
		}elseif($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
			
			if(!empty($userProfile) && !empty($userProfile['id'])){
				// Preparing data for database insertion
				$userData['oauth_provider'] = 'google';
				$userData['oauth_uid'] = !empty($userProfile['id'])?$userProfile['id']:'';
				$userData['first_name'] = !empty($userProfile['given_name'])?$userProfile['given_name']:'';
				$userData['last_name'] = !empty($userProfile['family_name'])?$userProfile['family_name']:'';
				$userData['email'] = !empty($userProfile['email'])?$userProfile['email']:'';
				$userData['gender'] = !empty($userProfile['gender'])?$userProfile['gender']:'';
				$userData['link'] = !empty($userProfile['link'])?$userProfile['link']:'';
				$userData['picture'] = !empty($userProfile['picture'])?$userProfile['picture']:'';
				// Insert or update user data
				$userData = $this->user->checkUser($userData);
				//set variables in session
				$this->session->set_userdata('isUserLoggedIn',TRUE);
				$this->session->set_userdata('userId',$userData['id']);
				$this->session->set_userdata('loginType','social');
				
				//redirect to dashboard
				redirect('dashboard/');
			}else{
				// Get login URL
				$data['fbLoginURL'] =  $this->facebook->login_url();
				$data['gpLoginURL'] = $gClient->createAuthUrl();
				$data['twLoginURL'] = $this->twitter->redirect(1);
			}
        }elseif($this->input->post('loginSubmit')){
			//form field validation rules
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
			
			//validate submitted form data
            if ($this->form_validation->run() == true) {
				//check whether user exists in the database
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'email'=>$this->input->post('email'),
                    'password' => md5($this->input->post('password')),
                    'status' => '1',
                    'is_deleted' => '0'
                );
                $checkLogin = $this->user->getRows($con);
				if($checkLogin && $checkLogin['activated'] == '0'){
					$data['error_msg'] = 'Your account activation is pending, please check your email to verify and activate your account.';
				}elseif($checkLogin){
					//if remember me is checked
					if ($this->input->post('rememberMe') == 1) {
						$remeberCookie = array(
							'name' => 'rememberUserId',
							'value' => $checkLogin['id'],
							'expire' => time() + 86400,
						);
						$this->input->set_cookie($remeberCookie);
					}
					
					//set variables in session
                    $this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('userId',$checkLogin['id']);
					
					//redirect to dashboard
                    redirect('Dashboard/');
                }else{
                    $data['error_msg'] = 'Wrong email or password, please try again.';
                }
            }
        }else{
			// Get login URL
            $data['fbLoginURL'] = $this->facebook->login_url();
			$data['gpLoginURL'] = $gClient->createAuthUrl();
        }
		
        //load the login swf_viewport(xmin, xmax, ymin, ymax)
        $this->load->view('welcome_message',$data);
    }

    public function sumit(){
    	echo"hi";
    }
}
