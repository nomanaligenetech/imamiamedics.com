<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Emergency_Roster_Form extends C_frontend {

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
	
	
	
	
	public static function _create_fields_for_form_2( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("occupation", "citizenship", "date_of_birth|default_date", "passport_number", "date_of_issue|default_date", "place_of_issue", "expiry_date|default_date");
		
		
		
		$filled_inputs				= array("occupation", "nationality", "date_of_birth", "passport_number", "date_of_issue", "place_of_issue", "expiry_date");
		
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
	
	public static function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "name", "email" );
		
		
		
		$filled_inputs				= array( "id", "name", "email");
		
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

	public static function _create_fields_for_form_3( $return_array = false, &$data, $db_data = array() )
	{

		$empty_inputs = array("profile_image", "cellphone_number", "secondary_email_1", "secondary_email_2", "home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", "web_address", "current_imi_title", "institute_school", "gender", "previous_title_with_imi", "office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", "occupation", "specialities", "preffered_mode_of_contact", "prefered_mode_address", "preffered_mode_of_email"/*, "other_member_can_see_profile"*/ );

		$filled_inputs = array("profile_image", "cellphone_number", "secondary_email_1", "secondary_email_2", "home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", "web_address", "current_imi_title", "institute_school", "gender", "previous_title_with_imi", "office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", "occupation", "specialities", "preffered_mode_of_contact", "prefered_mode_address", "preffered_mode_of_email"/*, "other_member_can_see_profile"*/ );
		
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
		
		PP_Emergency_Roster_Form::extend_data( $data );
		
		PP_Emergency_Roster_Form::_create_fields_for_form(false, $data);
		PP_Emergency_Roster_Form::_create_fields_for_form_2(false, $data);	
		PP_Emergency_Roster_Form::_create_fields_for_form_3(false, $data);	
		
		$edit_details												= $ci->imiconf_queries->fetch_records_imiconf("users", 
																													" AND id = '". $ci->functions->_user_logged_in_details( "id" ) ."' ");
		
		
		if ( $edit_details -> num_rows() > 0 )
		{
			PP_Emergency_Roster_Form::_create_fields_for_form(true, $data, $edit_details->row_array() );	
			
			$users_profile											= $ci->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = '". $edit_details->row()->id ."' ");
			PP_Emergency_Roster_Form::_create_fields_for_form_3(true, $data, $users_profile->row_array() );	
			
			
			$screen_three											= $ci->imiconf_queries->fetch_records_imiconf("conference_registration_screen_three", 
																												  " AND (SELECT userid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid  LIMIT 1) = '". $ci->functions->_user_logged_in_details( "id" ) ."' AND screen_one_detail_id = 0 and parentid = 0 ",
																												  " occupation, nationality, date_of_birth, passport_number, date_of_issue, place_of_issue, expiry_date ");
			
			if ( $screen_three -> num_rows() > 0 )
			{
				PP_Emergency_Roster_Form::_create_fields_for_form_2(true, $data, $screen_three->row_array() );	
			}
		}
		
		
		
		
		
		
		// $data['_messageBundle_please_login']						= $ci->_messageBundle( 'danger' , '<p>Please log in so we can get you started. <a href="https://imiportal.imamiamedics.com/memberlogin.html">Click here</a>.</p>');
		$data['_messageBundle_please_login']						= $ci->_messageBundle( 'loginalert' , lang_line("loginalert_incms") );
		$data["_messageBundle_not_a_member"]						= $ci->_messageBundle( 'info' , lang_line("text_imi_member"));
		
		return $ci->load->view( "frontend/cms/page_plugins/pp_emergency_roster_forms", $data, TRUE );
	}
	
	
	static public function extend_data( &$data )
	{
		#upload files extensions
		$data["pp_emergency_roster_form_images_types"]						= "gif|jpg|png";
		$data["pp_emergency_roster_form_dir"]	 							= "./assets/files/emergency_roster/";	
		$data["pp_emergency_roster_form_document_types"]					= "doc|docx|pdf";
	}
	
	
	
	static public function index( &$data = array(), $ci )
	{
		
		
		PP_Emergency_Roster_Form::extend_data( $data );

		#$ci->load->library('form_validation','','form_validation');
		
		//$ci->load->view( "frontend/cms/page_widgets/pw_contactus_form", array(), TRUE )
		
		$ci->form_validation->set_rules('name', lang_line('text_name'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('address', lang_line('label_arbaeen_form_address'), 'trim|required'); //
		
		$ci->form_validation->set_rules('preffered_mode_of_contact', lang_line('text_modeofcontact'), 'trim|required'); 
		switch ( $ci->input->post("preffered_mode_of_contact") ){
			case "Home":
			$ci->form_validation->set_rules('home_phone_number', lang_line('text_homephoneno'), 'trim|required');		
			break;
			case "Work":
			$ci->form_validation->set_rules('office_phone_number', lang_line('text_office_phone'), 'trim|required');		
			break;
			case "Mobile":	
			$ci->form_validation->set_rules('cellphone_number', lang_line('text_cellphoneno'), 'trim|required');		
			break;
			default:
			break;
		}
		
		$ci->form_validation->set_rules('email', lang_line('text_email'), 'trim|required|valid_email');
		
		$ci->form_validation->set_rules('occupation', lang_line('label_arbaeen_form_occupation'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('specialities', lang_line('text_specialities'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('citizenship', lang_line('text_citizenship'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('date_of_birth', lang_line('label_arbaeen_form_DOB'), 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$ci->form_validation->set_rules('passport_number', lang_line('text_passportno'), 'trim|required|callback_validate_alpha_numeric_dash');
		$ci->form_validation->set_rules('date_of_issue', lang_line('text_dateofissue'), 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$ci->form_validation->set_rules('place_of_issue', lang_line('text_placeofissue'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('date_of_expiration', lang_line('text_dateofexpiry'), 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		
		$ci->form_validation->set_rules('marital_status', lang_line('text_maritalstatus'), 'trim|required');
		$ci->form_validation->set_rules('tshirt_size', lang_line('text_tshirtsize'), 'trim|required');
		
		$ci->form_validation->set_rules('question_why_to_go_on_emer_relief_mission', lang_line('text_whytogoonemergency'), 'trim|required');
		$ci->form_validation->set_rules('question_time_to_take_off_short_notice', lang_line('text_timetotakeoff'), 'trim|required');
		$ci->form_validation->set_rules('question_foreign_language_skills', lang_line('text_foreignlanguageskill'), 'trim|required');
		$ci->form_validation->set_rules('question_any_other_skills', lang_line('text_anyotherskill'), 'trim|required');
		$ci->form_validation->set_rules('question_attended_emer_relief_before', lang_line('text_attendemergencybefore'), 'trim|required');
		$ci->form_validation->set_rules('question_any_difficulty_in_foreign_country', lang_line('text_anydifficultyinforeign'), 'trim|required');
		
		$ci->form_validation->set_rules('medical_physical_status', lang_line('text_medicalphysicalstatus'), 'trim|required'); 
		if ( ($ci->input->post("medical_physical_status") ) )
		{
			$ci->form_validation->set_rules('medical_physical_reason', lang_line('text_medicalphysicalreason'), 'trim|required');		
		}	
		
		$ci->form_validation->set_rules('list_any_medications', lang_line('text_listanymedication'), 'trim|required');
		$ci->form_validation->set_rules('list_any_allergies', lang_line('text_listanyallergies'), 'trim|required');
		$ci->form_validation->set_rules('primary_emer_contact_name', lang_line('text_name'), 'trim|required');
		$ci->form_validation->set_rules('primary_emer_contact_relationship', lang_line('text_relationship'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('primary_emer_contact_address', lang_line('label_arbaeen_form_address'), 'trim|required');
		$ci->form_validation->set_rules('primary_emer_contact_telephone',  lang_line('text_telephone'), 'trim|required');
		$ci->form_validation->set_rules('primary_emer_contact_email', lang_line('text_email'), 'trim|required|valid_email');
		
		
		$ci->form_validation->set_rules('secondary_emer_contact_name', lang_line('text_name'), 'trim|required');
		$ci->form_validation->set_rules('secondary_emer_contact_relationship', lang_line('text_relationship'), 'trim|required|callback_validate_name');
		$ci->form_validation->set_rules('secondary_emer_contact_address', lang_line('label_arbaeen_form_address'), 'trim|required');
		$ci->form_validation->set_rules('secondary_emer_contact_telephone', lang_line('text_telephone'), 'trim|required');
		$ci->form_validation->set_rules('secondary_emer_contact_email', lang_line('text_email'), 'trim|required|valid_email');
		
		$ci->form_validation->set_rules('short_biography',  lang_line('text_shortbiography'), 'trim|required');

		$age = calculateAge($ci->input->post('date_of_birth'));
		$ci->form_validation->set_rules('signature', lang_line('text_signature'), 'trim|required|callback_validate_imgdata');
		if ( $age < 18 ){
			$ci->form_validation->set_rules('parent_signature', lang_line('text_parentsignature'), 'trim|required|callback_validate_imgdata');
		}

		if ( 1==1 )
		{
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_resume",
														"db_field"											=> "resume",
														"input_nick"										=> "Resume",
														"hdn_field"											=> "resume",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["pp_emergency_roster_form_dir"],
														"allowed_types"										=> $data['pp_emergency_roster_form_document_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $ci->upload_image($config_image, $config_thumb, $other_upload);
		
			
			#insert in tmp table	
			$ci->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
		}
		
		
		
		if ( 1==1 )
		{
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_passport",
														"db_field"											=> "passport",
														"input_nick"										=> "Passport",
														"hdn_field"											=> "passport",
														"tmp_table_field"									=> "upload_2",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["pp_emergency_roster_form_dir"],
														"allowed_types"										=> $data['pp_emergency_roster_form_images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_2					= $ci->upload_image($config_image, $config_thumb, $other_upload);
		
			
			#insert in tmp table	
			$ci->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_2  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################	
		}
		
		
		
		if ( 1==1 )
		{
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_photo_image",
														"db_field"											=> "photo_image",
														"input_nick"										=> "Photo Image",
														"hdn_field"											=> "photo_image",
														"tmp_table_field"									=> "upload_3",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["pp_emergency_roster_form_dir"],
														"allowed_types"										=> $data['pp_emergency_roster_form_images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_3					= $ci->upload_image($config_image, $config_thumb, $other_upload);
		
			
			#insert in tmp table	
			$ci->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_3  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
		}
		
		
		#$ci->form_validation->set_rules('digital_signature', 'Signature', 'trim|required');
		#$ci->form_validation->set_rules("security_code", "Security Code", "trim|required|callback_validate_captchacode");
		
		if ($ci->form_validation->run() == FALSE)
		{
			$ci->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			return TRUE;
		}
		else 
		{

			switch ($ci->input->post("preffered_mode_of_contact")) {
				case "Home":
				$contact_number = $ci->input->post('home_phone_number');
				break;
				case "Work":
				$contact_number = $ci->input->post('office_phone_number');
				break;
				case "Mobile":
				$contact_number = $ci->input->post('cellphone_number');
				break;
				default:
				break;
			}


			if ( isset($_POST['signature']) )
			{

				$img_data = $_POST['signature'];
				$img_data = substr($img_data, strpos($img_data, ',') + 1);
				$img_data = base64_decode($img_data);
				$file_name = 'signature'.time().rand(1,99).'.png';
				$upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/emergency_roster/";
				$uploaded = file_put_contents($upload_dir.$file_name,$img_data);
				if (is_dir($upload_dir) && is_writable($upload_dir)) {
					if ($uploaded) {
						$_POST['signature'] = $file_name;
					}
				}
			}

			if ( isset($_POST['parent_signature']) )
			{

				$img_data = $_POST['parent_signature'];
				$img_data = substr($img_data, strpos($img_data, ',') + 1);
				$img_data = base64_decode($img_data);
				$file_name = 'parent_signature'.time().rand(1,99).'.png';
				$upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/emergency_roster/";
				$uploaded = file_put_contents($upload_dir.$file_name,$img_data);
				if (is_dir($upload_dir) && is_writable($upload_dir)) {
					if ($uploaded) {
						$_POST['parent_signature'] = $file_name;
					}
				}
			}

			$insertData					= array("name"											=> $ci->input->post("name"),
												"address"			 							=> $ci->input->post("address"),
												"preffered_mode_of_contact"						=> $ci->input->post("preffered_mode_of_contact"),	
												"contact_number"								=> $contact_number,
												"email"											=> $ci->input->post("email"),
												"occupation"									=> $ci->input->post("occupation"),
												"specialities"									=> $ci->input->post("specialities"),
												"citizenship"									=> $ci->input->post("citizenship"),
												"date_of_birth"									=> date("Y-m-d", strtotime($ci->input->post("date_of_birth")) ),
												"passport_number"								=> $ci->input->post("passport_number"),
												"date_of_issue"									=> date("Y-m-d", strtotime($ci->input->post("date_of_issue")) ),
												"place_of_issue"								=> $ci->input->post("place_of_issue"),
												"date_of_expiration"							=> date("Y-m-d", strtotime($ci->input->post("date_of_expiration")) ),
												"marital_status"								=> $ci->input->post("marital_status"),
												"tshirt_size"									=> $ci->input->post("tshirt_size"),
												"question_why_to_go_on_emer_relief_mission"		=> $ci->input->post("question_why_to_go_on_emer_relief_mission"),												
												"question_why_to_go_on_emer_relief_mission"		=> $ci->input->post("question_why_to_go_on_emer_relief_mission"),
												"question_time_to_take_off_short_notice"		=> $ci->input->post("question_time_to_take_off_short_notice"),
												"question_foreign_language_skills"				=> $ci->input->post("question_foreign_language_skills"),
												"question_any_other_skills"						=> $ci->input->post("question_any_other_skills"),
												"question_attended_emer_relief_before"			=> $ci->input->post("question_attended_emer_relief_before"),
												"question_any_difficulty_in_foreign_country"	=> $ci->input->post("question_any_difficulty_in_foreign_country"),
												"medical_physical_status"						=> format_bool( $ci->input->post("medical_physical_status") ),
												"medical_physical_reason"						=> $ci->input->post("medical_physical_reason"),
												"list_any_medications"							=> $ci->input->post("list_any_medications"),
												"list_any_allergies"							=> $ci->input->post("list_any_allergies"),
												"primary_emer_contact_name"						=> $ci->input->post("primary_emer_contact_name"),
												"primary_emer_contact_relationship"				=> $ci->input->post("primary_emer_contact_relationship"),
												"primary_emer_contact_address"					=> $ci->input->post("primary_emer_contact_address"),
												"primary_emer_contact_telephone"				=> $ci->input->post("primary_emer_contact_telephone"),
												"primary_emer_contact_email"					=> $ci->input->post("primary_emer_contact_email"),
												"secondary_emer_contact_name"					=> $ci->input->post("secondary_emer_contact_name"),
												"secondary_emer_contact_relationship"			=> $ci->input->post("secondary_emer_contact_relationship"),
												"secondary_emer_contact_address"				=> $ci->input->post("secondary_emer_contact_address"),												
												"secondary_emer_contact_telephone"				=> $ci->input->post("secondary_emer_contact_telephone"),
												"secondary_emer_contact_email"					=> $ci->input->post("secondary_emer_contact_email"),
												"short_biography"								=> $ci->input->post("short_biography"),
												"signature"										=> $ci->input->post("signature"),
												"parent_signature"								=> $ci->input->post("parent_signature"),
												"user_id"										=> $ci->functions->_user_logged_in_details( "id" ),
												
												"resume"										=> $ci->input->post("resume"),
												"passport"										=> $ci->input->post("passport"),
												"photo_image"									=> $ci->input->post("photo_image"),
												
												
												"date_added"									=> date("Y-m-d"),
												"type"											=> "imiportal");
													
			
			$ci->queries->SaveDeleteTables($insertData, 's', "tb_emergency_roster_form", 'id'); 			
			$record = $ci->queries->fetch_records("emergency_roster_form", " AND erf.id = ".$ci->db->insert_id());
			
		
			#to user
			$email_template				= array(
												"email_to"				=> $ci->input->post("email"),
												"email_heading"			=> "Emergency Roster Form",
												"email_file"			=> "email/frontend/emergency_roster_form.php",
												"email_subject"			=> "Emergency Roster Form",
												"default_subject"		=> TRUE,
												"email_bcc"				=> ( SessionHelper::_get_session("EMAIL_TO", "site_settings") ),
												"email_post"			=> $record->row_array()
											);
			
			$is_email_sent				= $ci->_send_email( $email_template );
			#to_user / bcc_admin
				
		
		
			$data['_messageBundle']		= $ci->_messageBundle( 	'success_big' , 
																"Thank you for submitting <strong>Emergency Roster Form</strong>. An IMI representative will get in touch with you shortly.", 
																lang_line("heading_operation_success"));
			
			$data['_pageview']									= "global/_blank_page.php";		
			
			return TRUE;
			#$ci->load->view( FRONTEND_TEMPLATE_LEFT_WIDGETS_VIEW, $data );	
			
		}
		
	}
	
}