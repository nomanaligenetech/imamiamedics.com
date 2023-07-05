<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends C_frontend {

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
		
		
		$this->data													= $this->default_data();
		
		$this->data['_pagetitle']									= lang_line("text_logoutsuccessfull");
	}
	
	public function index()
	{ 
		$data					= $this->data;		
		
		$unset					= array("user_logged_in"				=> FALSE,
										"user_logged_details"			=> array());

		$this->session->unset_userdata( $unset );
		
		
	
		$data['_messageBundle']								= $this->_messageBundle('info' , 
																					"<p>" . lang_line("message_please_login_admin") . "</p>", 
																					lang_line("heading_operation_logout_success"), 
																					false,
																					true);
		
		redirect ( site_url("memberlogin") );
		
		
	}
	
}