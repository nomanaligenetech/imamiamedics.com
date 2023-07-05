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
		
		
		
		
		#if user not have any AbstractForms - redirect to Manage My Account
		if ( $this->left_queries['TOTAL_abstractforms'] <= 0 )
		{
			redirect( 'account/managemyaccount/controls/view' );	
		}
		
		
		
		$this->data													= $this->default_data();
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'Abstract Forms';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./images/station/";
		
		
		$this->data['visitor_types']								= $this->queries->fetch_records('visitor_types', " ORDER BY sort DESC ");
		$this->data['conference_topics']							= $this->queries->fetch_records('conference_topics', " ORDER BY sort DESC ");
		
		
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_child_for_form(false, $this->data, array() );
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array	(	lang_line('text_name'), 
																				lang_line('text_acceptednotaccepted'), 
																				lang_line('text_payment'),
																				lang_line('text_submissionmode')
																			);
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("abstract_submission_form", 
																									" AND conferenceid = '". SessionHelper::_get_session("id", "conference") ."' 
																									  AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																									  ORDER BY id DESC ");
		
		$data["table_properties"]									= $this->view_table_properties();


		$data['_messageBundle2']									= $this->_messageBundle( 'danger' , '<p>' . lang_line("text_norecordfound") . '</p>', 'Error!');
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
	
	public function index ()
	{
		
	}
	
	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";

		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );	
	}
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		



		include_once(APPPATH.'controllers/ajaxmethods.php');
		
		
		#standard validation
		#$this->form_validation->set_rules("id", "id", "trim");
		#$this->form_validation->set_rules("options", "options", "trim");
		#$this->form_validation->set_rules("unique_formid", "unique_formid", "trim");
		
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		
		
		
		$this->form_validation->set_rules("theme", "Theme", "trim|required");
		$this->form_validation->set_rules("name", "Name", "trim|required");
		$this->form_validation->set_rules("duration_from", "Duration (From)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		$this->form_validation->set_rules("duration_to", "Duration (To)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		$this->form_validation->set_rules("registration_from", "Registration (From)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		$this->form_validation->set_rules("registration_to", "Registration (To)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		$this->form_validation->set_rules("countryid", "Country", "trim|required");
		$this->form_validation->set_rules("sight_seeingid[]", "sight_seeingid", "trim");
		
		$this->form_validation->set_rules("status", "Status", "trim");
		
		
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			
			$tmp_ajax_output1									= AjaxMethods::sightseeing_with_country( set_value("countryid"), FALSE );
			if ( $tmp_ajax_output1["_CSS_show_messages"] != "error" )
			{
				$data['ajax_output1']							= $tmp_ajax_output1["_TEXT_show_messages"];
			}
			
			
			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		}
		else
		{
	
			$saveData											= array("theme"								=> $this->input->post("theme"),
																		"name"								=> $this->input->post("name"),
																		"slug"								=> $this->queries->make_slug(	$this->input->post("name"), 
																																			$this->input->post("id"),
																																			'slug',
																																			'conference'),
																		
																		"duration_from"						=> date("Y-m-d", strtotime($this->input->post('duration_from'))),
																		"duration_to"						=> date("Y-m-d", strtotime($this->input->post('duration_to'))),
																		"registration_from"					=> date("Y-m-d", strtotime($this->input->post('registration_from'))),
																		"registration_to"					=> date("Y-m-d", strtotime($this->input->post('registration_to'))),
																		"countryid"							=> $this->input->post('countryid'),
																		"status"							=> format_bool ( $this->input->post("status") ) );		
			
			
	

			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_conference", 'id');  
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_conference", 'id');  		
				$saveData['id']										= $this->db->insert_id();
			}
			
			
			if ( $this->input->post("status") == "1" )
			{
				
				$this->db->query("UPDATE tb_conference SET status = '0'");
				
				$this->db->query("UPDATE tb_conference SET status = '". format_bool ( $this->input->post("status") ) ."' WHERE id = '". $saveData['id'] ."' ");
			}
	
	
			
			
			
			$TMP_child						= array("conferenceid"				=> $saveData['id']);
			$this->queries->SaveDeleteTables($TMP_child, 'd', "tb_conference_sight_seeing", 'conferenceid');  
			foreach ( $_POST['sight_seeingid'] as $key )
			{
				$TMP_child						= array("conferenceid"				=> $saveData['id'],
														"sight_seeingid"			=> $key );
				
				$this->queries->SaveDeleteTables($TMP_child, 's', "tb_conference_sight_seeing", 'conferenceid');  
			}
			 
			
			
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "userid", "conferenceid", "title", "presenter_speaker", "affiliation", "address", "email", "phone", "introduction", "methods", "results", "conclusion", "keywords", "acknowledgements", "academic_level", "nationality", "passport_number", "regionid", "another_presentation", "accompanied_by_family", "date_added|default_date", "another_presentation_name", "accompanied_by_family_name", "status", "status_name", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "userid", "conferenceid", "title", "presenter_speaker", "affiliation", "address", "email", "phone", "introduction", "methods", "results", "conclusion", "keywords", "acknowledgements", "academic_level", "nationality", "passport_number", "regionid", "another_presentation", "accompanied_by_family", "date_added", "another_presentation_name", "accompanied_by_family_name", "status", "status_name", "options", "unique_formid" );
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				

				$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]				= $explode_empty_inputs[0];
				$tmp_value						= $db_data[ $filled_inputs[$x] ];
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "default_date":	
							$tmp_value			= date("d-m-Y", strtotime( $db_data[ $filled_inputs[$x] ] ) );
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
				
				
				
				
			}
			
		
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				$explode_empty_inputs				= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]					= $explode_empty_inputs[0];
				$tmp_value							= "";
				
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "default_date":	
							$tmp_value				= "00-00-0000";
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
			}
			
			return $data;
		
		}
	}
	
	
	public function _create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("conferencetopics_id", "visitortypes_id", "author", "affiliations");
		
		$filled_inputs				= array("conferencetopics_id", "visitortypes_id", "author", "affiliations");
				
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				for ($m=0; $m < count($db_data); $m++)
				{
					
					if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					{
						
						$data[ $empty_inputs[$x] ][]		= $db_data[$m][ $filled_inputs[$x] ];
						$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
					}
				}
				
				$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			
			$this->form_validation->run();
		
		
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]				= array();
			}
			
			return $data;
		
		}
	}
	
	public function _create_array_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array( "sight_seeingid" );
		$filled_inputs				= array( "sight_seeingid" );
		$languages					= $data["languages"];

		
		
		if ($return_array == true and count($db_data) > 0 )
		{
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			
			#loop with the parent object... for e.g. Types of Promo Codes
			foreach ($loop_object as $main)
			{
				
				$language_id				= $main["id"];
				
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					#second - if value found it will overwrite above array.
					foreach ( $db_data as $loop )
					{
						if ( $loop["conferenceid"] == $language_id )
						{
							$detail_array[ $main["id"] ] [ $empty_inputs[$x] ]			= $loop[ $filled_inputs[$x] ];	
						}
						
					}
				}
			}			
			
			ksort( $detail_array );
		
			$data["_detail_array"]	= $detail_array;
			
			
			return $data;
		}
		else
		{
			
			

			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			$data["_detail_array"]	= $detail_array;
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("abstract_submission_form", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		
		$child_details												= $this->queries->fetch_records("abstract_submission_form_conference_topics", " AND parentid = '$edit_id' ");		
		$this->_create_child_for_form(true, $data, $child_details->result_array() );	
		
		$child_details												= $this->queries->fetch_records("abstract_submission_form_visitor_types", " AND parentid = '$edit_id' ");		
		$this->_create_child_for_form(true, $data, $child_details->result_array() );	
		
		
		$child_details												= $this->queries->fetch_records("abstract_submission_form_others", " AND parentid = '$edit_id' ");		
		$this->_create_child_for_form(true, $data, $child_details->result_array() );	
		
		
		
	
		
		
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
	
	public function delete( $id )
	{
		$data												= $this->data;
		
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_conference", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */