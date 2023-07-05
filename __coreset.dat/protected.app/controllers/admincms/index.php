<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends C_admincms {

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
		

		redirect( "admincms/sitecontrol/login" );
		
		$this->_auth_login( false );
		
		$this->data													= $this->default_data();
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		$this->data["_heading"]										= lang_line("heading_dashboard");
		$this->data["_pagetitle"]									= "Dashboard - ";
		$this->data['_pageview']									= $this->data["_directory"] . "dashboard.php";
		
	}
	public function index()
	{
		$data														= $this->data;
		
		
		$this->load->library("Encrption");
		
		
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'callback_validate_admincredentials');
		
		if ($this->form_validation->run() == FALSE)
		{			
			$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			
			$data['_messageBundle']			= $this->_messageBundle( 'success' , 'You are logged in', 'Success!' );
			
			$cookie 						= $this->encrption->encrypt("admin");
			
			setcookie("validate", $cookie, time() + 2592000, "/");
			
			
			
			/*$_details						= array("id"					=> "US0001",
													"first_name"			=> "Muslim",
													"last_name"				=> "Raza",
													"username"				=> "admin",
													"password"				=> "admin",
													"email"					=> "fairsit.m@gmail.com",
													"role"					=> 1,
													"published"				=> 1);
			*/
			
		
			$_details						= $this->queries->fetch_records( "admin", " AND username = '". $this->input->post("username") ."' ", " *, username as name " );
			
			$this->_create_User_Session( $_details->row_array() );
			
			redirect( SHORT_C_ALWAYSCPR_ADMIN_TEMPLATE_DASHBOARD_INDEX );
			
		}
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */