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
		
		
		$this->data["_heading"]										= 'Conference Registration';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/conference_registration/";
		
		
		$this->data['visitor_types']								= $this->queries->fetch_records('visitor_types', " ORDER BY sort DESC ");
		$this->data['conference_topics']							= $this->queries->fetch_records('conference_topics', " ORDER BY sort DESC ");
		
		
		
		
		include_once(APPPATH.'controllers/admincms/manageconferenceregistration/controls_include.php');
		
		
		
		#pre-filled values for input fields
		Controls_Include::_create_fields_for_form(false, $this->data);	
		
		
		
		
		
		
		
		$TMP_where			= "AND (SELECT userid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid) = '". $this->functions->_user_logged_in_details( "id" ) ."'";
		
		
		
		$this->data['table_record'] 								= Controls_Include::fetch_records_for_view(array(), $TMP_where);
		if ( count($this->data['table_record'])  <= 0 )
		{
			redirect( "account/managemyaccount/controls/view" );
		}
	}
	

	public function view()
	{
		$data														= $this->data;
		
		
		$data["table_properties"]									= Controls_Include::view_table_properties();


		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}

	public function display_values( &$data, $edit_id, $edit_details )
	{
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";

		Controls_Include::_create_fields_for_form(true, $data, $edit_details );	
		
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("conference_registration_screen_three", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		
		$this->display_values( $data, $edit_id, $edit_details );
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		if ( isset($_POST['checkbox_options']) )
		{
		
			if (count($_POST['checkbox_options']) > 0 )
			{
				$is_post		= TRUE;
			}
				
		}
		
		
		if ($is_post)
		{
			switch ($_POST['options'])
			{
				
				case "delete":
					$this->delete( $_POST['checkbox_options'] );
					break;
					
				default:
					$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
					redirect(  site_url( $data["_directory"] . "controls/view" ) );
					break;
				
			}
		}
		else
		{
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
			redirect( site_url( $data["_directory"] . "controls/view" ) );
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */