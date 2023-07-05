<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Internship_Form extends C_frontend {

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
	
		$empty_inputs				= array("date_of_birth|default_date", "phone", "city", "country");
		
		
		
		$filled_inputs				= array("date_of_birth", "phone", "city", "country");
		
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
		
			
		
		PP_Internship_Form::extend_data( $data );
		
		
		
		$edit_details												= $ci->imiconf_queries->fetch_records_imiconf("users", 
																													" AND id = '". $ci->functions->_user_logged_in_details( "id" ) ."' ");
		
		
		if ( $edit_details -> num_rows() > 0 )
		{
			PP_Internship_Form::_create_fields_for_form(true, $data, $edit_details->row_array() );	
			
			$users_profile											= $ci->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = '". $edit_details->row()->id ."' ");
			
			
			$screen_three											= $ci->imiconf_queries->fetch_records_imiconf("conference_registration_screen_three", 
																												  " AND (SELECT userid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid  LIMIT 1) = '". $ci->functions->_user_logged_in_details( "id" ) ."' AND screen_one_detail_id = 0 and parentid = 0 ",
																												  "date_of_birth, 
																												  place_of_birth as city, 
																												  (SELECT phone FROM  tb_conference_registration_screen_one WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) as phone, country_of_birth as country");
			
			
			
			
			if ( $screen_three -> num_rows() > 0 )
			{
				PP_Internship_Form::_create_fields_for_form_2(true, $data, $screen_three->row_array() );	
			}
		}
		
		
		
		
		
		
		$data['_messageBundle_please_login']						= $ci->_messageBundle( 'loginalert' , lang_line("loginalert_incms") );
		$data["_messageBundle_not_a_member"]						= $ci->_messageBundle( 'info' , '<p>You must be a IMI-Member to submit the form</p>');
		
		return $ci->load->view( "frontend/cms/page_plugins/pp_internship_form", $data, TRUE );
	}
	
	
	static public function extend_data( &$data )
	{
		#upload files extensions
		$data["pp_internship_form_images_types"]								= "gif|jpg|png|doc|pdf";
		$data["pp_internship_form_images_dir"]	 								= "./assets/files/internship_forms/";	
	}
	
	static public function index( &$data = array(), $ci )
	{
		
		PP_Internship_Form::extend_data( $data );
		
		
		#$ci->load->library('form_validation','','form_validation');
		
		//$ci->load->view( "frontend/cms/page_widgets/pw_contactus_form", array(), TRUE )
		$ci->form_validation->set_rules('resume[]', lang_line('text_resume'), 'trim');
		
		$ci->form_validation->set_rules('name', lang_line('text_name'), 'trim|required');
		$ci->form_validation->set_rules('date_of_birth', lang_line('label_arbaeen_form_DOB'), 'trim|required|callback_validate_date_check[dd-mm-yyyy]'); #DB
		$ci->form_validation->set_rules('email', lang_line('text_email'), 'trim|required|valid_email');
		
		
		$ci->form_validation->set_rules('phone', lang_line('text_phonenumber'), 'trim|required');
		$ci->form_validation->set_rules('city', lang_line('placeholder_arbaeen_form_city'), 'trim|required');
		$ci->form_validation->set_rules('state', lang_line('placeholder_arbaeen_form_state'), 'trim|required');
		$ci->form_validation->set_rules('country', lang_line('text_country'), 'trim|required');
		
		$ci->form_validation->set_rules('college_university', lang_line('text_collegeuniversity'), 'trim|required');

		$ci->form_validation->set_rules('qualification', lang_line('text_qualification'), 'trim|required');
		$ci->form_validation->set_rules('specialization', lang_line('text_specialization'), 'trim|required');
		
		
		
		if ( TRUE )
		{
			
			
			#################################
			###  	photo_other_image	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_resume",
														"db_field"											=> "resume",
														"input_nick"										=> "Resume",
														"hdn_field"											=> "resume",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> TRUE);
		
			
			$config_image						= array("upload_path"										=> $data["pp_internship_form_images_dir"],
														"allowed_types"										=> $data['pp_internship_form_images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $ci->upload_image($config_image, $config_thumb, $other_upload);
			
			#insert in tmp table	
			$ci->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1, TRUE  );
	
			#################################
			###  	product_main_image 	  ###
			#################################
		
		}
		
		#$ci->form_validation->set_rules("security_code", "Security Code", "trim|required|callback_validate_captchacode");
		
		
		if ($ci->form_validation->run() == FALSE)
		{
			$ci->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			return TRUE;
		}
		else 
		{
			
			
			$insertData					= array("name"											=> $ci->input->post("name"),
												"date_of_birth"									=> date("Y-m-d", strtotime($ci->input->post("date_of_birth")) ),
												"email"											=> $ci->input->post("email"),
												"phone"											=> $ci->input->post("phone"),
												"city"											=> $ci->input->post("city"),												
												"state"											=> $ci->input->post("state"),
												"country"										=> $ci->input->post("country"),
												
												"college_university"							=> $ci->input->post("college_university"),
												"qualification"									=> $ci->input->post('qualification'),
												"specialization"								=> $ci->input->post('specialization'),
												
												"user_id"										=> $ci->functions->_user_logged_in_details( "id" ),
												"date_added"									=> date("Y-m-d"),
												"type"											=> "imiportal");
			
			$ci->queries->SaveDeleteTables($insertData, 's', "tb_internship_form", 'id'); 			
			
	
	
	
			#multiple photos
			$saveData['id']							= $ci->db->insert_id();
			$ci->queries->SaveDeleteTables(array("parentid"			=> $saveData['id']), 'd', "tb_internship_form_documents", 'parentid');  
			if ( $ci->input->post("resume") )
			{
				foreach ($ci->input->post("resume") as $key => $value )
				{
					if ( $value != "" )
					{
						$childData					= array("parentid"					=> $saveData['id'],
															"resume"					=> $value);
						
						
						
						
						$ci->queries->SaveDeleteTables($childData, 's', "tb_internship_form_documents", 'id'); 
					}
				}
			}
			
			
			
			
			
		
			#to user
			$email_template				= array("email_to"				=> $ci->input->post("email"),
												"email_heading"			=> "Internship Form",
												"email_file"			=> "email/frontend/internship_form.php",
												"email_subject"			=> "Internship Form",
												"default_subject"		=> TRUE,
												"email_bcc"				=> getAdminEmails(),
												"email_post"			=> $_POST );
			
			$is_email_sent				= $ci->_send_email( $email_template );
			#to_user / bcc_admin
				
		
		
			$data['_messageBundle']		= $ci->_messageBundle( 	'success_big' , 
																"Thank you for submitting <strong>Internship Form</strong>. An IMI representative will get in touch with you shortly.", 
																lang_line("heading_operation_success"));
			
			$data['_pageview']									= "global/_blank_page.php";		
			
			return TRUE;
			#$ci->load->view( FRONTEND_TEMPLATE_LEFT_WIDGETS_VIEW, $data );	
			
		}
		
	}
	
	
	
	
	
	
}