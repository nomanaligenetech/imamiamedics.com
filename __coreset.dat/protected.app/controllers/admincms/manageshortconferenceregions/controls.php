<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		
		
		$this->data["_heading"]										= 'Manage Conference Regions';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./images/station/";
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Conference', 'Name', 'Sort', 'Allow Payment');
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("short_conference_regions", " ORDER BY id DESC ");
		$data["table_properties"]									= $this->view_table_properties();


		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function index ()
	{
		
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
		



		
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		
		
		
		$this->form_validation->set_rules("conferenceid", "Conference", "trim|required");
		$this->form_validation->set_rules("name", "Name", "trim|required");
		
		
		$this->form_validation->set_rules("show_rates_in_currency", "Show Rates In Currency", "trim");
		
		$this->form_validation->set_rules("allow_payment", "Allow Payment", "trim");
		
		$this->form_validation->set_rules("step5_note1", "Step 5 Note", "trim");
		$this->form_validation->set_rules("paymentdescription_conference", "Payment Description (Conference)", "trim");
		$this->form_validation->set_rules("paymentdescription_abstract", "Payment Description (Abstract)", "trim");
		
		
		$this->form_validation->set_rules("description", "Description", "trim|required");
		$this->form_validation->set_rules("onsite_note", "Onsite Note", "trim|required");
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
	
			$saveData											= array("conferenceid"						=> $this->input->post("conferenceid"),
																		"name"								=> $this->input->post("name"),
																		
																		"show_rates_in_currency"			=> $this->input->post("show_rates_in_currency"),
																		"allow_payment"						=> $this->input->post("allow_payment"),
																		"step5_note1"						=> $this->input->post("step5_note1"),
																		"paymentdescription_conference"		=> $this->input->post("paymentdescription_conference"),
																		"paymentdescription_abstract"		=> $this->input->post("paymentdescription_abstract"),
																		
																		
																		"description"						=> $this->input->post("description"),
																		"onsite_note"						=> $this->input->post("onsite_note") );		
			

			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_regions", 'id');  
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_regions", 'id');  		
				$saveData['id']										= $this->db->insert_id();
			}
			
			

			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	}
	
	
	public function ajax_update_sorting( $id )
	{
		
		foreach ($id	as $key	=> $result)
		{
			$saveData['sort']										= $result;	
			$saveData['id']											= $key;	
			
			$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_regions", 'id') ;
		}
		
		$data['_messageBundle']									= $this->_messageBundle( 'success' , "Sort Updated", 'Success!', FALSE, TRUE);
		
		redirect ( site_url( $this->data["_directory"] . "controls/view" ) );
	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "conferenceid", "name", "allow_payment", "show_rates_in_currency", "step5_note1", "paymentdescription_conference", "paymentdescription_abstract", "description", "onsite_note", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "conferenceid", "name", "allow_payment", "show_rates_in_currency", "step5_note1", "paymentdescription_conference", "paymentdescription_abstract", "description", "onsite_note", "options", "unique_formid" );
		
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
	

	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("short_conference_regions", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		
		if ( $_POST['options'] == "ajax_update_sorting" )
		{
			$is_post		= TRUE;
		}
		else if ( isset($_POST['checkbox_options']) )
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
					
				case "ajax_update_sorting":
					$this->ajax_update_sorting( $_POST['sorting'] );
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
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_short_conference_regions", 'id') ;
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