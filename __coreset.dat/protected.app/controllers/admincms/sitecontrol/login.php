<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends C_admincms {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
	{	
		parent::__construct();
		
		
		$this->load->helper(array('captcha'));
		
		$this->data													= $this->default_data();
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		$this->data["_pagetitle"]									= "please login - ";
		$this->data['_pageview']									= $this->data["_directory"] . "login.php";
		
	}
	public function index()
	{ 	
		$this->_auth_login( true );
		
		$data														= $this->data;
		
		
		$this->load->library("Encrption");
		
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'callback_validate_admincredentials');
		
		# if login attempts exceeds ADMIN_LOGIN_ATTEMPTS then validate captcha
		if ( $this->session->userdata('login_attempt') >= ADMIN_LOGIN_ATTEMPTS ) {
			$this->form_validation->set_rules('captcha', "Captcha", 'required|callback__check_captcha');
		}
		
		if ($this->form_validation->run() == FALSE)
		{			
			# if login attempts exceeds ADMIN_LOGIN_ATTEMPTS then create a captcha
			if ( $this->session->userdata('login_attempt') >= ADMIN_LOGIN_ATTEMPTS ) { 
				$vals = array(
					'img_path' => './assets/captcha/',
					'img_url' => base_url().'assets/captcha/',
					'img_width' => '200',
					'img_height' => 50,
					'expiration' => 7200
				);

				$data['captcha'] = create_captcha($vals);

				$this->session->set_userdata('captchaWord', $data['captcha']['word']);
			} else {
				$data['captcha'] = '';	
			}
			
			$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_LOGIN_VIEW, $data );
		}
		else
		{
			
			/* clear captcha session variable */
		    $this->session->unset_userdata('captchaWord');
					
			$data['_messageBundle']			= $this->_messageBundle( 'success' , 'You are logged in', 'Success!' );
			
			$cookie 						= $this->encrption->encrypt("admin");
			
			setcookie("validate", $cookie, time() + 2592000, "/");
			
			$_details						= $this->queries->fetch_records( "admin", " AND username = '". $this->input->post("username") ."' ", " *, username as name " )->row_array();
			$_details['logintime']			= strtotime("now");
			
			$_details['role_id']			= $_details['roleid'];
			$_details['role_name']			= $this->queries->fetch_records( "admin_roles", " AND id = '". $_details['roleid'] ."' " )->row("name");
			$_details['belongs_country']			= $_details['belongs_country'];
			
			$this->_create_User_Session( $_details );
			
			# login successfull, reset login attempts value
			$this->session->set_userdata('login_attempt', 0);
			
			redirect( "admincms/dashboard" );
			
		}
		
	}
	
	
	public function logout()
	{
		$unset					= array("admincms_logged_in"				=> FALSE,
										"admincms_logged_details"			=> array());

		$this->session->unset_userdata( $unset );
		
		
	
		$data['_messageBundle']								= $this->_messageBundle('info' , 
																					"<p>" . lang_line("message_please_login_admin") . "</p>", 
																					lang_line("heading_operation_logout_success"), 
																					false,
																					true);
		
		redirect ( "admincms/sitecontrol/login" );
	}
	
	public function _check_captcha()
	{
		if( strtolower($this->input->post('captcha')) != strtolower($this->session->userdata['captchaWord']) )
		{
			$this->form_validation->set_message('_check_captcha', 'Wrong captcha code entered.');
			return false;
		} else {
			return true;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */