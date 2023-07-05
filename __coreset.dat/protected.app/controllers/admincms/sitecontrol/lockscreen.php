<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lockscreen extends C_admincms {

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
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		$this->data["_pagetitle"]									= "Your AdminCMS is safe - ";
		$this->data['_pageview']									= $this->data["_directory"] . "lockscreen.php";
		
	}
	public function index()
	{
		
		$this->_auth_login( false );

		$data														= $this->data;
		
		
		$this->load->view( ADMINCMS_TEMPLATE_LOCKSCREEN_VIEW, $data );
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */