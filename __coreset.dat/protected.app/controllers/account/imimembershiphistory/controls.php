<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls extends C_frontend {

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
		
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'IMI Membership History';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		
		
		
	}

	public function view()
	{		
		
		$data														= $this->data;
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "view.php";
		
		
		#
		$data['membership_details']									= $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_two", 
																													" AND be_a_member = 1 AND conferenceregistrationid IN ( SELECT id FROM tb_conference_registration_master WHERE userid = '". $this->functions->_user_logged_in_details( "id" ) ."' ) ");	
		
		
		#$this->load->library("Encrption");
		#echo $this->encrption->decrypt("VwAmSaPM/mb2bAtnfuuS0nL1H0alixEfm5Y="); //Woodbridge001
		#die;
		if ( $data['membership_details'] -> num_rows() <= 0 )
		{
			$data['_messageBundle']										= $this->_messageBundle( 'info' , lang_line("text_norecordfound"), ' ');
		}
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */