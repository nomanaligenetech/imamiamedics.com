<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Mentorship_Form extends C_frontend {

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
		
		
		#$ci->data													= $ci->default_data();
		
	}
	
	
	
	
	static public function _create_fields_for_form_2( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("cellphone_number", "secondary_email_1", "secondary_email_2", "home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", "office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", "occupation", "specialties", "preffered_mode_of_contact","date_of_birth"/*, "other_member_can_see_profile"*/);
		
		$filled_inputs				= array("cellphone_number", "secondary_email_1", "secondary_email_2", "home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", "office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", "occupation", "specialties", "preffered_mode_of_contact","date_of_birth"/*, "other_member_can_see_profile"*/ );
		
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
	
	static function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "first_name", "last_name", "email" );
		
		
		
		$filled_inputs				= array( "id", "name", "last_name", "email");
		
		//$filled_inputs				= array( "id", "resorts_id", "promo_code_percentage_discount_code", "promo_code_percentage_discount_percent", "promo_code_percentage_discount_datefrom", "promo_code_percentage_discount_expiry", "promo_code_value_add_code", "promo_code_value_add_details", "promo_code_value_add_datefrom", "promo_code_value_add_expiry",  "options" );
		
		
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
	
	
	static public function show( $data = array(), $ci )
	{
		
		PP_Mentorship_Form::_create_fields_for_form(false, $data);
		PP_Mentorship_Form::_create_fields_for_form_2(false, $data);	
		
		$edit_details												= $ci->imiconf_queries->fetch_records_imiconf("users", 
																													" AND id = '". $ci->functions->_user_logged_in_details( "id" ) ."' ");
		
		
		if ( $edit_details -> num_rows() > 0 )
		{
			PP_Mentorship_Form::_create_fields_for_form(true, $data, $edit_details->row_array() );	
			
			$users_profile											= $ci->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = '". $edit_details->row()->id ."' ");
			
			
			
			
			if ( $users_profile -> num_rows() > 0 )
			{
				$users_profile											= $users_profile->row_array();
				$users_profile['occupation']							= "";
			
				$screen_three											= $ci->imiconf_queries->fetch_records_imiconf("conference_registration_screen_three", 
																													  " AND (SELECT userid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid  LIMIT 1) = '". $ci->functions->_user_logged_in_details( "id" ) ."' ",
																													  " occupation ");
				if ( $screen_three -> num_rows() > 0 )
				{
					$users_profile['occupation']						= $screen_three->row()->occupation;
				}
			
			
				PP_Mentorship_Form::_create_fields_for_form_2(true, $data, $users_profile );		
			}
		}
		
		
		
		
		
		// $data['_messageBundle_please_login']						= $ci->_messageBundle( 'danger' , '<p>Please log in so we can get you started. <a href="https://imiportal.imamiamedics.com/memberlogin.html">Click here</a>.</p>');

		$data['_messageBundle_please_login']						= $ci->_messageBundle( 'loginalert' , lang_line("loginalert_incms") );
		$data["_messageBundle_not_a_member"]						= $ci->_messageBundle( 'info' , '<p>You must be a IMI-Member to submit the form</p>');
		
		return $ci->load->view( "frontend/cms/page_plugins/pp_mentorship_form", $data, TRUE );
	}
	
	
	static public function index( &$data = array(), $ci )
	{

		#$ci->load->library('form_validation','','form_validation');
		
		//$ci->load->view( "frontend/cms/page_widgets/pw_contactus_form", array(), TRUE )
		$ci->form_validation->set_rules('first_name', lang_line('text_firstname'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('last_name', lang_line('text_lastname'), 'trim|required|callback_validate_name'); //
		
		$ci->form_validation->set_rules('address', lang_line('label_arbaeen_form_address'), 'trim|required');
		$ci->form_validation->set_rules('address_2', lang_line('text_address2'), 'trim');
		$ci->form_validation->set_rules('state', lang_line('placeholder_arbaeen_form_state'), 'trim|required|callback_validate_name');
		
		$ci->form_validation->set_rules('city', lang_line('placeholder_arbaeen_form_city'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('email', lang_line('text_email'), 'trim|required|valid_email');
		
		$ci->form_validation->set_rules('zip', lang_line('text_zipcode'), 'trim');
		$ci->form_validation->set_rules('employer', lang_line('text_employer'), 'trim|required');
		$ci->form_validation->set_rules('profession', lang_line('text_profession'), 'trim|required');
        $ci->form_validation->set_rules('university', lang_line('text_university'), 'trim');
        $ci->form_validation->set_rules('university_state', lang_line('text_universitystate'), 'trim');
        $ci->form_validation->set_rules('university_city', lang_line('text_universitycity'), 'trim');
        $ci->form_validation->set_rules('degree_type', lang_line('text_degreetype'), 'trim');
        $ci->form_validation->set_rules('major', lang_line('text_major'), 'trim');
        $ci->form_validation->set_rules('graduate_year', lang_line('text_graduateyear'), 'trim');


		$ci->form_validation->set_rules('password', lang_line('placeholder_password'), 'trim');
		$ci->form_validation->set_rules('confirm_password', lang_line('placeholder_cpassword'), 'trim');
		#$ci->form_validation->set_rules("security_code", "Security Code", "trim|required|callback_validate_captchacode");
		
		
		if ($ci->form_validation->run() == FALSE)
		{
			$ci->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			return TRUE;
		}
		else 
		{
			
			
			$insertData					= array("first_name"			=> $ci->input->post("first_name"),
												"last_name"			 	=> $ci->input->post("last_name"),
												"address"				=> $ci->input->post("address"),
												"address_2"				=> $ci->input->post("address_2"),
												"state"					=> $ci->input->post("state"),
												"city"					=> $ci->input->post("city"),
												"email"					=> $ci->input->post("email"),
												"zip"					=> $ci->input->post("zip"),
												"employer"				=> $ci->input->post("employer"),
												"profession"			=> $ci->input->post("profession"),
												"university"			=> $ci->input->post("university"),
												"university_state"		=> $ci->input->post("university_state"),
												"university_city"		=> $ci->input->post("university_city"),
												"degree_type"			=> $ci->input->post("degree_type"),
												"major"					=> $ci->input->post("major"),
												"graduate_year"			=> $ci->input->post("graduate_year"),
												"user_id"				=> $ci->functions->_user_logged_in_details( "id" ),
												"date_added"			=> date("Y-m-d"),
												"type"					=> "imiportal");
													
			
			$ci->queries->SaveDeleteTables($insertData, 's', "tb_mentorship_form", 'id'); 			
			
			
			#to user
			$email_template				= array("email_to"				=> $ci->input->post("email"),
												"email_heading"			=> "Mentorship Form",
												"email_file"			=> "email/frontend/mentorship_form.php",
												"email_subject"			=> "Mentorship Form",
												"default_subject"		=> TRUE,
												"email_bcc"				=> "sakinarizviimi@gmail.com,rida.fatima@genetechsolutions.com",
												"email_post"			=> $_POST );
			
			$is_email_sent				= $ci->_send_email( $email_template );
			#to_user / bcc_admin
				
		
			$data['_messageBundle']		= $ci->_messageBundle( 	'success_big' , 
																"Thank you for submitting <strong>Mentorship Form</strong>. An IMI representative will get in touch with you shortly.", 
																lang_line("heading_operation_success"));
			
			$data['_pageview']									= "global/_blank_page.php";		
			
			return TRUE;
			#$ci->load->view( FRONTEND_TEMPLATE_LEFT_WIDGETS_VIEW, $data );	
			
		}
		
	}
	
	
	
	
	
	
}