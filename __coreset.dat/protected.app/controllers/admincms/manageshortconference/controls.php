<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls extends C_admincms {


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
		
		
		$this->data["_heading"]										= 'Short Conference';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./images/station/";
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_child_for_form(false, $this->data, array() );
	}

	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Theme', 'Name', 'Status' );
		
		return $tmp;
	}
	

	public function view()
	{
		$data														= $this->data;
		$data["table_record"]										= $this->queries->fetch_records("short_conference", " ORDER BY id DESC ");
		$data["table_properties"]									= $this->view_table_properties();
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}

	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $data["_directory"] . "edit.php";

		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
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
		
		$this->form_validation->set_rules("venue", "Venue", "trim|required");
		$this->form_validation->set_rules("description", "Description", "trim|required");
		
		$this->form_validation->set_rules("duration_from", "Duration (From)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		$this->form_validation->set_rules("duration_to", "Duration (To)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		$this->form_validation->set_rules("registration_from", "Registration (From)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		$this->form_validation->set_rules("registration_to", "Registration (To)", "trim|required|callback_validate_date_check[dd-mm-yyyy]");
		
		$this->form_validation->set_rules("arrival_at", "Arrival At", "trim|required");
		$this->form_validation->set_rules("departure_from", "Departure From", "trim|required");
		
		
		$this->form_validation->set_rules("countryid", "Country", "trim|required");
		// $this->form_validation->set_rules("sight_seeingid[]", "sight_seeingid", "trim");
		
		$this->form_validation->set_rules("registration_closed", "Registration Closed", "trim");
		$this->form_validation->set_rules("status", "Status", "trim|callback_validate_conference_status");
		
		
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			
			$tmp_ajax_output1									= AjaxMethods::sightseeing_with_country( set_value("countryid"), FALSE );
			if ( $tmp_ajax_output1["_CSS_show_messages"] != "error" )
			{
				$data['ajax_output1']							= $tmp_ajax_output1["_TEXT_show_messages"];
			}
			
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
	
			$saveData											= array("theme"								=> $this->input->post("theme"),
																		"name"								=> $this->input->post("name"),
																		"venue"								=> $this->input->post("venue"),
																		"description"						=> $this->input->post("description"),
																		"slug"								=> $this->queries->make_slugss(	$this->input->post("name"), 
																																			$this->input->post("id"),
																																			'slug',
																																			'short_conference', '',''),
																		
																		"duration_from"						=> date("Y-m-d", strtotime($this->input->post('duration_from'))),
																		"duration_to"						=> date("Y-m-d", strtotime($this->input->post('duration_to'))),
																		"registration_from"					=> date("Y-m-d", strtotime($this->input->post('registration_from'))),
																		"registration_to"					=> date("Y-m-d", strtotime($this->input->post('registration_to'))),
																		
																		
																		"arrival_at"						=> $this->input->post('arrival_at'),
																		"departure_from"					=> $this->input->post('departure_from'),
																		
																		"countryid"							=> $this->input->post('countryid'),
																		"registration_closed"				=> format_bool ( $this->input->post("registration_closed") ),
																		"status"							=> format_bool ( $this->input->post("status") ) );		
			
			
	
			
			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference", 'id');  
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference", 'id');  		
				$saveData['id']										= $this->db->insert_id();
			}
			
			
			if ( $this->input->post("status") == "1" )
			{
				
				$this->db->query("UPDATE tb_short_conference SET status = '0'");
				
				$this->db->query("UPDATE tb_short_conference SET status = '". format_bool ( $this->input->post("status") ) ."' WHERE id = '". $saveData['id'] ."' ");
			}
	
	
			
			
			
			$TMP_child						= array("conferenceid"				=> $saveData['id']);
			$this->queries->SaveDeleteTables($TMP_child, 'd', "tb_short_conference_sight_seeing", 'conferenceid');  
			if ( isset($_POST['sight_seeingid']) )
			{
				foreach ( $_POST['sight_seeingid'] as $key )
				{
					$TMP_child						= array("conferenceid"				=> $saveData['id'],
															"sight_seeingid"			=> $key );
					
					$this->queries->SaveDeleteTables($TMP_child, 's', "tb_short_conference_sight_seeing", 'conferenceid');  
				}
			}
			
			
			
			
			$data['_messageBundle']									=  	$this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "slug", "countryid", "theme", "name", "venue", "description", "arrival_at", "departure_from", "duration_from|default_date", "duration_to|default_date", "registration_from|default_date", "registration_to|default_date", "status", "registration_closed", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "slug", "countryid", "theme", "name", "venue", "description", "arrival_at", "departure_from", "duration_from", "duration_to", "registration_from", "registration_to", "status", "registration_closed", "options", "unique_formid" );
		
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
	
		$empty_inputs				= array("sight_seeingid");
		
		$filled_inputs				= array("sight_seeingid");
				
		
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
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("short_conference", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		
		$child_details												= $this->queries->fetch_records("short_conference_sight_seeing", " AND conferenceid = '$edit_id' ");		
		$this->_create_child_for_form(true, $data, $child_details->result_array() );	
		
		
		
		include_once(APPPATH.'controllers/ajaxmethods.php');
		
		$tmp_ajax_output1									= AjaxMethods::sightseeing_with_country( $edit_details["countryid"], FALSE );
		if ( $tmp_ajax_output1["_CSS_show_messages"] != "error" )
		{
			$data['ajax_output1']							= $tmp_ajax_output1["_TEXT_show_messages"];
		}
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
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
		
		$no_delete = FALSE;
		$no_delete_id = 0;
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			
			$conf_status = $this->db->query("select status from tb_short_conference where id = ".$saveData['id'])->row()->status;
			
			if ( $conf_status ) {
				$no_delete = TRUE;
				$no_delete_id = $saveData['id'];
			} 
			else {
				$this->queries->SaveDeleteTables($saveData, 'd', "tb_short_conference", 'id') ;
			}
		}
		
		if($no_delete) {
			
			$data['_messageBundle']								= $this->_messageBundle('success' , 
																						lang_line("operation_delete_active_conference"), 
																						lang_line("heading_operation_success"), 
																						false,
																						true);
			
		}
		
		else {
		
			$data['_messageBundle']								= $this->_messageBundle('success' , 
																						lang_line("operation_delete_success"), 
																						lang_line("heading_operation_success"), 
																						false,
																						true);
			
		}
		
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */