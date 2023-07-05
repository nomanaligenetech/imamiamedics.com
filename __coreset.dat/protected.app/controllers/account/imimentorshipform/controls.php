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
		
		error_reporting(E_ALL);
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'IMI Mentorship Form';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
		$this->load->library("Encrption");
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array(lang_line("text_username") );
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		redirect ( site_url( $data["_directory"] . "controls/edit")  );
		
	}
	
	
	
	
	
	public function index ()
	{
		
	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "first_name", "last_name", "address", "address_2", "state", "city", "email", "zip", "employer", "profession", "university", "university_state", "university_city", "degree_type", "major", "graduate_year", "user_id", "date_added", "type", "options", "unique_formid" );
		
		
		
		$filled_inputs				= array( "id", "first_name", "last_name", "address", "address_2", "state", "city", "email", "zip", "employer", "profession", "university", "university_state", "university_city", "degree_type", "major", "graduate_year", "user_id", "date_added", "type", "options", "unique_formid" );
		
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
	
	public function edit()
	{		
		$data														= $this->data;
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "edit.php";
		
		$edit_details 												= $this->queries->fetch_records("mentorship_form", " AND user_id = '".$this->functions->_user_logged_in_details( "id" )."' ORDER BY `id` DESC");
		
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		#standard validation
		$this->functions->unite_post_values_form_validation();
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('address_2', 'Address 2', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('city', 'city', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required');
		$this->form_validation->set_rules('employer', 'Employer', 'trim|required');
		$this->form_validation->set_rules('profession', 'Profession', 'trim|required');
		$this->form_validation->set_rules('university', 'University', 'trim|required');
		$this->form_validation->set_rules('university_state', 'University State', 'trim|required');
		$this->form_validation->set_rules('university_city', 'University City', 'trim|required');
		$this->form_validation->set_rules('degree_type', 'Degree Type', 'trim|required');
		$this->form_validation->set_rules('major', 'Major', 'trim|required');
		$this->form_validation->set_rules('graduate_year', 'Graduate Year', 'trim|required');
		
		if( $this->form_validation->run() == FALSE )
		{
			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		}
		else
		{
			
			$insertData					= array("user_id"				=> $this->functions->_user_logged_in_details( "id" ),
												"first_name"			=> $this->input->post("first_name"),
												"last_name"				=> $this->input->post("last_name"),
												"address"				=> $this->input->post("address"),
												"address_2"				=> $this->input->post("address_2"),
												"state"					=> $this->input->post("state"),
												"city"					=> $this->input->post("city"),
												"email"					=> $this->input->post("email"),
												"zip"					=> $this->input->post("zip"),
												"employer"				=> $this->input->post("employer"),
												"profession"			=> $this->input->post("profession"),
												"university"			=> $this->input->post("university"),
												"university_state"		=> $this->input->post("university_state"),
												"university_city"		=> $this->input->post("university_city"),
												"degree_type"			=> $this->input->post("degree_type"),
												"major"					=> $this->input->post("major"),
												"graduate_year"			=> $this->input->post("graduate_year"));


            $this->queries->SaveDeleteTables(
                $insertData,
                'e',
                "tb_mentorship_form",
                'user_id'
            );

            #to user
            $email_template				= array("email_to"				=> $this->input->post("email"),
                "email_heading"			=> "Mentorship Form",
                "email_file"			=> "email/frontend/mentorship_form.php",
                "email_subject"			=> "Mentorship Form",
                "default_subject"		=> TRUE,
                "email_bcc"				=> "sakinarizviimi@gmail.com,rida.fatima@genetechsolutions.com",
                "email_post"			=> $_POST );

            $is_email_sent				= $this->_send_email( $email_template );
            #to_user / bcc_admin

            $data['_messageBundle'] = $this->_messageBundle(
                'success',
                "Your mentorship form updated.",
                lang_line("heading_operation_success"),
                false,
                true
            );
				
			redirect ( site_url( $data["_directory"] . "controls/edit" ) );
			
		}		
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */