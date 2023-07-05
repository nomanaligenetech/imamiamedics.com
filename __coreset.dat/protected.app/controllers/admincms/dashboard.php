<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends C_admincms {

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
		
		if ( admin_role(FALSE, "admin") )
		{
			#redirect( "admincms/manageconferenceregistration/controls/view" );
		}
		
		
		
		//redirect( site_url( 'admincms/managesitesettings/controls/edit' ) );
		
		$this->data								= $this->default_data();
		
		$this->data["_directory"]				= $this->router->directory;
		$this->data["_pagepath"]				= $this->router->directory . $this->router->class;
		
		$this->data["_heading"]					= lang_line("heading_dashboard");
		$this->data["_pagetitle"]				= "Dashboard - ";
		$this->data['_pageview']				= $this->data["_directory"] . "dashboard.php";
		
	}
	public function index()
	{
		$data									= $this->data;
		
		
		/*$data['unique_visitor']					= $this->queries->fetch_records('visitorlog', ' GROUP BY ipaddress', 'ipaddress' );
		$visitor_array							= array();
		foreach ($data['unique_visitor']->result_array() as $visitor)
		{			
			$details							= $this->functions->ip_info('173.252.110.27');
			$country_code						= FALSE;
			
			
			if ( is_array($details) )
			{
				if ( count($details) > 0 )
				{
					if ( array_key_exists("country_code", $details) )
					{
						if ( array_key_exists($details['country_code'], $visitor_array) )
						{
							$visitor_array[$details['country_code']]++;
						}
						else
						{
							$visitor_array[$details['country_code']]		= 1;
						}
					}
				}
			}
			
		}
		
		$data['visitor_array']			= json_encode($visitor_array);		
		*/
		
		
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */