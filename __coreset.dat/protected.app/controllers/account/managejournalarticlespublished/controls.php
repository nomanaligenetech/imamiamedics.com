<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls extends C_Frontend {

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
		
		$this->_auth_login( false );
		
		
		
		
		$this->data													= $this->default_data();
		$this->load->library( "../controllers/admincms/managejournalarticles/controls_include.php", array("load" => FALSE) );
	
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		$this->data['fake_admincms_path']							= "admincms/{$this->uri->segments[2]}/";
		
		$this->data["_heading"]										= 'Manage Journal Articles (Published)';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
	}
	
	
	public function view( $is_ajax = 0 )
	{
		$data									= $this->data;
		
		$data["table_record"]					= $this->queries->fetch_records("journalarticle", 
																				" 	AND is_published = 1 
																					AND created_by_user = '{$this->functions->_user_logged_in_details('id')}' ORDER BY date_added DESC");		
		$data["table_properties"]				= $this->controls_include->view_table_properties();
		
		$data['_pageview']						= "admincms/managejournalarticles/view.php";
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */