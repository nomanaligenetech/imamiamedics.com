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
		
		$this->data["_heading"]										= 'Manage Donation Campaigns Custom Donors';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
	}
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Campaign Name', "Donor Name", 'Amount', 'Status' );
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("dc_offline_donation", " ORDER BY id desc");
		$data["table_properties"]									= $this->view_table_properties();
		$data['controller']											= $this;

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
	}
	
	public function add( $camp_id = false )
	{
		$data												= $this->data;
		if($camp_id){
			$data['camp_id']								= $camp_id;
		}
		
		$data['_pageview']									= $data["_directory"] . "edit.php";
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
	}
	
	public function save ()
	{
		$data														= $this->data;
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		
		$this->form_validation->set_rules("id", "id", "trim");
		$this->form_validation->set_rules("options", "options", "trim");
		$this->form_validation->set_rules("unique_formid", "unique_formid", "trim");
		
		$this->form_validation->set_rules("camp_id", "Campaign", "trim|required");
		$this->form_validation->set_rules("first_name", "Donor Name", "trim|required");
		$this->form_validation->set_rules("donate_amount", "Amount", "trim|required|numeric|greater_than[0]");
		$this->form_validation->set_rules("other_info", "Other Info", "trim|max_length[350]");
		$this->form_validation->set_rules("home_country", "Country", "trim|required");
		$this->form_validation->set_rules("mode", "Mode of Payment", "trim|required");
		$this->form_validation->set_rules("hide_identity", "Hide Identity", "trim|required");
		$this->form_validation->set_rules("status", "Status", "trim|required");
		$this->form_validation->set_rules("comment_status", "Comment Status", "trim|required");
		$this->form_validation->set_rules("date_added", "Donation Date", "trim|required");
		if($this->input->post('comment_status') == "1"){
			$this->form_validation->set_rules("comment", "Donor Comments", "trim|max_length[350]|required");
		} else {
			$this->form_validation->set_rules("comment", "Donor Comments", "trim|max_length[350]");
		}
		
		if( $this->form_validation->run() == FALSE )
		{
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			$saveData											= array("camp_id"				=> $this->input->post('camp_id'),
																		"first_name"			=> $this->input->post('first_name'),
																		"comment"				=> $this->input->post('comment'),
																		"date_added"			=> date('Y-m-d H:i:s', strtotime($this->input->post('date_added'))),
																		"donate_amount"			=> $this->input->post('donate_amount'),
																		"status"				=> $this->input->post('status'),
																		"hide_identity"			=> $this->input->post('hide_identity'),
																		"home_country"			=> $this->input->post('home_country'),
																		"other_info"			=> $this->input->post('other_info'),
																		"mode"					=> $this->input->post('mode'),
																		"comment_status"		=> $this->input->post('comment_status'),
																	);
			
			
			
			
			if ($this->input->post('options') == "edit")
			{
				$saveData['updated_by']								= $this->functions->_admincms_logged_in_details( "id" );
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_dc_offline_donation", 'id');  
			}
			else
			{
				$saveData['created_by']								= $this->functions->_admincms_logged_in_details( "id" );
				$this->queries->SaveDeleteTables($saveData, 's', "tb_dc_offline_donation", 'id');  		
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
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "camp_id", "comment", "other_info", "first_name", "donate_amount", "options", "unique_formid", "status", "hide_identity", "home_country", "date_added", "mode", "comment_status" );
		
		$filled_inputs				= array( "id", "camp_id", "comment", "other_info", "first_name", "donate_amount", "options", "unique_formid", "status", "hide_identity", "home_country", "date_added", "mode", "comment_status" );
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]		= $db_data[ $filled_inputs[$x] ];
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]		= "";
			}
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("dc_offline_donation", " AND id = '$edit_id' ");
		
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
		
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_dc_offline_donation", 'id') ;
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