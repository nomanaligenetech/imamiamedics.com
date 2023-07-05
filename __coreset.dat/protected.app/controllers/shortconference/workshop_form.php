<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workshop_Form extends C_frontend {

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

		
		$this->data													= $this->default_data();
		
		$this->data['_pagetitle']									= lang_line('text_workshopform');
		$this->data['h1']											= '';
		
		$this->_create_fields_for_form(FALSE, $this->data, array());
		
	}
	
	
	public function success(  $conference_slug = ''  )
	{
		$data									= $this->data;
		$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																'for submitting Workshop Form. Out team will cordinate with you in 2-4 hours.', 
																'Thank you');
		
	

		$data['_pageview']			= "global/_blank_page.php";
		$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
	}
	
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "userid", "conferenceid", "title", "email", "instructors_with_qualification", "coinstructors_with_qualification", "main_objective_of_workshop", "duration_of_proposed_workshop", "proposed_dates_for_workshop", "max_participants_for_workshop", "qualification_of_participants", "special_requirements_for_workshop", "special_services_for_workshop", "other_requirements_comments", "date_added", "status" );
		
		$filled_inputs				= array( "id", "userid", "conferenceid", "title", "email", "instructors_with_qualification", "coinstructors_with_qualification", "main_objective_of_workshop", "duration_of_proposed_workshop", "proposed_dates_for_workshop", "max_participants_for_workshop", "qualification_of_participants", "special_requirements_for_workshop", "special_services_for_workshop", "other_requirements_comments", "date_added", "status" );
		
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

	
	
	
	
	public function index( $conference_slug = '', $type = '', $edit_id = 0 )
	{ 
		
		$data								= $this->data;
		
		
		$data['conference']						= $this->queries->fetch_records('conference', " AND slug = '". $conference_slug ."' ");
		
		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		
		if ( !$this->validations->is_numeric($edit_id) )
		{
			$edit_id						= 0;
		}
		
		
		
		
		

		
		$message_class						= '';
		$conference_registration			= $this->queries->fetch_records('conference_registration', 
																			" AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																			  AND conferenceid = '". $data['conference']->row("id") ."' 
																			  AND parentid = '0'  LIMIT 1 ");
		
		
		
		
		$data['h1']								= lang_line('text_workshopform');
		$data['conference_registration']		= $conference_registration;
		
		
		
		
		$is_validate							= TRUE;
		
		if ( $edit_id > 0 )
		{
			$wrk_form								= $this->queries->fetch_records("workshops_form", 
																					" AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																					  AND conferenceid = '". $data['conference']->row("id") ."'
																					  AND id = '". $edit_id ."' ");
			
			
			#FAKE ID - hack attempt
			if ( $wrk_form -> num_rows() <= 0 )
			{
				page_error( $data );
				return false;
			}
			
		
		}
		
		
		$data['_pageview']						= "frontend/workshop_form.php";
		
		if ( $is_validate )
		{
			#$this->functions->unite_post_values_form_validation();
		
		
			$is_required				= '|required';
			
	
			$this->form_validation->set_rules('id', 'id', 'trim');
			
			$this->form_validation->set_rules('title', 'Title of Workshop', 'trim' . $is_required);
			
			$this->form_validation->set_rules('email', 'Email Address', 'trim' . $is_required . '|valid_email');
			
			$this->form_validation->set_rules('instructors_with_qualification', 'Workshop Instructor/s with Qualifications', 'trim' . $is_required);
			
			$this->form_validation->set_rules('coinstructors_with_qualification', 'Workshop  Co-instructor/s with Qualification', 'trim' . $is_required);
			
			$this->form_validation->set_rules('main_objective_of_workshop', 'Main Objective of Workshop', 'trim' . $is_required);
			
			$this->form_validation->set_rules('duration_of_proposed_workshop', 'Duration of Proposed Workshop', 'trim' . $is_required);
			
			$this->form_validation->set_rules('proposed_dates_for_workshop', 'Your Proposed Dates for the Workshop', 'trim' . $is_required);
					
			$this->form_validation->set_rules('max_participants_for_workshop', 'Number of Maximum Participants who can Attend Workshop', 'trim' . $is_required . '|is_natural');
			
			$this->form_validation->set_rules('qualification_of_participants', 'Qualification of Participants / Target Audience', 'trim' . $is_required);
			
			$this->form_validation->set_rules('special_requirements_for_workshop', 'Special Requirements for the Workshop', 'trim' . $is_required);
			
			$this->form_validation->set_rules('special_services_for_workshop', 'Special Services Required for the Workshop', 'trim' . $is_required);
			
			$this->form_validation->set_rules('other_requirements_comments', 'Any Other Requirements / Comments', 'trim' . $is_required);
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
				
				#$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
				$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
			}
			else
			{
				
				$saveData										= array("userid"						=> $this->functions->_user_logged_in_details( "id" ) ? $this->functions->_user_logged_in_details( "id" ) : 0,
																		
																		"conferenceid"					=> $data['conference']->row("id"),
																		"title"							=> $this->input->post("title"),
																		"email"							=> $this->input->post("email"),
																		"instructors_with_qualification"				=> $this->input->post("instructors_with_qualification"),
																		"coinstructors_with_qualification"					=> $this->input->post("coinstructors_with_qualification"),
																		"main_objective_of_workshop"						=> $this->input->post("main_objective_of_workshop"),
																		"duration_of_proposed_workshop"							=> $this->input->post("duration_of_proposed_workshop"),
																		"proposed_dates_for_workshop"							=> $this->input->post("proposed_dates_for_workshop"),
																		"max_participants_for_workshop"					=> $this->input->post("max_participants_for_workshop"),
																		"qualification_of_participants"						=> $this->input->post("qualification_of_participants"),
																		"special_requirements_for_workshop"						=> $this->input->post("special_requirements_for_workshop"),
																		"special_services_for_workshop"					=> $this->input->post("special_services_for_workshop"),
																		"other_requirements_comments"						=> $this->input->post("other_requirements_comments"),
																		"date_added"					=> date("Y-m-d H:i:s"),

																		'status'						=> '1'  //status =1  (in review)
																		);
				
				
				
				if ($this->input->post('id') != "")
				{
					$saveData['id']									= $this->input->post('id');
					$this->queries->SaveDeleteTables($saveData, 'e', "tb_workshops_form", 'id'); 
				}
				else
				{
					
					$this->queries->SaveDeleteTables($saveData, 's', "tb_workshops_form", 'id'); 
					$saveData['id']									= $this->db->insert_id();
				}
			
				
				
				$email_post = $_POST;
				
				
				
				#to site admin
				$email_template				= array("email_to"				=> SessionHelper::_get_session("EMAIL_SECRETARIAT_TO", "site_settings"),
												    "email_bcc"				=> SessionHelper::_get_session("EMAIL_SECRETARIAT_BCC", "site_settings"),
													"email_heading"			=> lang_line('text_workshopform'),
													"email_file"			=> "email/frontend/workshop_form.php",
													"email_subject"			=> lang_line('text_workshopformsubject'),
													"default_subject"		=> TRUE,
													"email_post"			=> $email_post );
				
				$is_email_sent				= $this->_send_email( $email_template );
				#to_site_admin / bcc_admin
				
				
				
				
				
				
				
				#to user
				$email_template				= array("email_to"				=> array ( $this->input->post( "email" ) ),
													"email_heading"			=> lang_line('text_workshopform'),
													"email_file"			=> "email/frontend/workshop_form_thank_you.php",
													"email_subject"			=> lang_line('text_workshopformsubject'),
													"default_subject"		=> TRUE,
													"email_post"			=> $email_post );
				
				$is_email_sent				= $this->_send_email( $email_template );
				#to user
	
	
	
				redirect( "conference/" . $conference_slug . "/workshop_form/success"  );
				
			}
		}
		else
		{
			
			$data['formdata'] = $_POST;
			
			#$this->form_validation->run();
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
		}
		
		
		
		
	}
	
}