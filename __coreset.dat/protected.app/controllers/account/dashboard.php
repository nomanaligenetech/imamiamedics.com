<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends C_frontend {

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
		
		
		#don't goto dashboard.. (instead redirect to Manage Abstract Submission Forms
		#redirect( "account/manageabstractsubmissionforms/controls/view" );
		
		$this->data								= $this->default_data();
		
		$TMP_dir								= "frontend/" . $this->router->directory;
		$this->data["_directory"]				= $TMP_dir ;
		$this->data["_pagepath"]				= $TMP_dir . $this->router->class;
		
		$this->data["_heading"]					= '';lang_line("heading_dashboard");
		$this->data["_pagetitle"]				= "Dashboard - ";
		$this->data['_pageview']				= $this->data["_directory"] . "dashboard.php";
		
	}
	
	
	
	
	public function index()
	{
		$data									= $this->data;
		
		$data['menu_detail']					= $this->queries->fetch_records('cmsmenu', " AND slug = 'my-dashboard' AND status = '1'");
		
		
		if ( $data['menu_detail'] -> num_rows() <= 0 )
		{
			//show_404();
		}
		
		
		#$data['menu_active']					= $data['menu_detail']->row("name");
		#$data['_pagetitle']						= $data['menu_detail']->row("name");
		#$data['h1']								= $data['menu_detail']->row("name");
		#$data['content_detail']					= $this->queries->fetch_records('cmscontent', " AND menuid = '". $data['menu_detail']->row("id") ."' ");
		
		#$data['_messageBundle']				= $this->_messageBundle( 'warning' , 'welcome, <strong>' . ucfirst( $this->functions->_user_logged_in_details( "name" ) ) . '</strong> ' );
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */