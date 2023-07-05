<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screen_Three extends C_frontend {

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
		
		// $this->_auth_login( FALSE );
		$this->validations->is_conference_registration_expired();
		
		
		$this->data													= $this->default_data();
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');	
		
			
		
		$this->_create_fields_for_form(FALSE, $this->data);
		
		
		$this->data['breadcrumbs'][1]								= "stepcompleted";
		$this->data['breadcrumbs'][2]								= "stepcompleted";
		$this->data['breadcrumbs'][3]								= "active";
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/conference_registration/";
		
		
		


		$this->data['_messageBundle_youcanalwaysresumelater']		= $this->_messageBundle('warning' , 
																							lang_line("text_youcanalwayspaylater"), 
																							lang_line("heading_operation_info") . ':' );
		
		$this->data['_messageBundle2']								= $this->data['_messageBundle'];
		$this->_create_fields_for_form(FALSE, $this->data);
		
		
	}


	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "conferenceregistrationid", "screen_one_id", "screen_two_id", "gender", "name", "middle_name", "father_name", "surname", "passport_number", "passport_type", "date_of_birth|default_date", "place_of_birth", "country_of_birth", "nationality", "passport_image", "photo_image", "marital_status", "gender_father_name", "previous_nationality", "place_of_issue", "date_of_issue|default_date", "expiry_date|default_date", "occupation", "position", "name_of_institute_company", "title_of_activity|default_titleofactivity", "visa_insurance_place", "duration_of_stay|default_15", "no_of_previous_travels|default_zero", "date_of_entry_for_conference|default_date", "last_date_of_entry|default_date", "date_of_departure|default_date", 
											
											"full_name", "email", "phone", "mailing_address", "type_of_professional", "speciality_interest", "age_level_of_school",
											"date_added", "date_modified" );
		
		
		$filled_inputs				= array( "id", "conferenceregistrationid", "screen_one_id", "screen_two_id", "gender", "name", "middle_name", "father_name", "surname", "passport_number", "passport_type", "date_of_birth", "place_of_birth", "country_of_birth", "nationality", "passport_image", "photo_image", "marital_status", "gender_father_name", "previous_nationality", "place_of_issue", "date_of_issue", "expiry_date", "occupation", "position", "name_of_institute_company", "title_of_activity", "visa_insurance_place", "duration_of_stay", "no_of_previous_travels", "date_of_entry_for_conference", "last_date_of_entry", "date_of_departure", 
											
											"full_name", "email", "phone", "mailing_address", "type_of_professional", "speciality_interest", "age_level_of_school",
											"date_added", "date_modified" );
		
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
							$d					= strtotime( $db_data[ $filled_inputs[$x] ] );
							if ( $d > 0 )
							{
								$tmp_value			= date("d-m-Y",  $d);
							}
							else
							{
								$tmp_value			= "";
							}
							break;
										
						
							
						case "default_zero":	
							$tmp_value			= $db_data[ $filled_inputs[$x] ];
							break;
							
						case "default_15":	
							$tmp_value			= $db_data[ $filled_inputs[$x] ];
							break;
							
						case "default_titleofactivity":	
							$tmp_value			= $db_data[ $filled_inputs[$x] ];
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
							
						case "default_zero":	
							$tmp_value				= 0;
							break;
							
						case "default_15":	
							$tmp_value				= 15;
							break;
							
						case "default_titleofactivity":	
							$tmp_value				= SessionHelper::_get_session('name', 'conference'); #DEFAULT_CONF_TITLE;
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
	
	
	public function validate_fields( $data )
	{
		switch ( $data['conference']->row()->slug )
		{
			case strpos($data['conference']->row()->slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:
				$this -> validate_fields_12( $data );
				break;
			
			case strpos($data['conference']->row()->slug, '10th') !== FALSE:
				$this -> validate_fields_10( $data );
				break;
				
			case strpos($data['conference']->row()->slug, '9th') !== FALSE:
				$this -> validate_fields_9( $data );
				break;
				
			default:
				$this -> validate_fields_8( $data );
				break;
		}	
	}

	public function validate_fields_12( $data )
	{
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('mailing_address', 'Mailing Address', 'trim|required');
		#$this->form_validation->set_rules('type_of_professional', 'Type of Professional', 'trim|required');
		// $this->form_validation->set_rules('speciality_interest', 'Speciality / Area of Interest', 'trim');
		// $this->form_validation->set_rules('age_level_of_school', 'Level of School', 'trim');
	}
	
	public function validate_fields_8( $data )
	{
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim');
		$this->form_validation->set_rules('father_name', 'Fathers Name', 'trim|required');
		$this->form_validation->set_rules('surname', 'SurName', 'trim|required');
		$this->form_validation->set_rules('passport_number', 'Passport Number', 'trim|required');
		$this->form_validation->set_rules('passport_type', 'Passport Type', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('place_of_birth', 'Place of Birth', 'trim|required');
		$this->form_validation->set_rules('country_of_birth', 'Country of Birth', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		
		

		if ( 1==1  and isset($_POST['name']))
		{

			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_passport_image",
														"db_field"											=> "passport_image",
														"input_nick"										=> "Passport Image",
														"hdn_field"											=> "passport_image",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE,
														"max_size"											=> 1024);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
			
			
			
			
			
			
			
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_photo_image",
														"db_field"											=> "photo_image",
														"input_nick"										=> "Photo Image",
														"hdn_field"											=> "photo_image",
														"tmp_table_field"									=> "upload_2",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE,
														"max_size"											=> 1024);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_2					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_2  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
			
			#$this->form_validation->run();
			
		}
		
		
		$this->form_validation->set_rules('passport_image', 'Passport Image', 'trim');
		$this->form_validation->set_rules('photo_image', 'Photo Image', 'trim');
		$this->form_validation->set_rules('marital_status', 'Martial Status', 'trim|required');
		$this->form_validation->set_rules('gender_father_name', 'Gender(s) Father Name', 'trim');
		$this->form_validation->set_rules('previous_nationality', 'Previous Nationality', 'trim|required');
		$this->form_validation->set_rules('date_of_issue', 'Date of Issue', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('place_of_issue', 'Place of Issue', 'trim|required');
		$this->form_validation->set_rules('expiry_date', 'Expiry Date', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('occupation', 'Occupation', 'trim|required');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		$this->form_validation->set_rules('name_of_institute_company', 'Name of Institute/Company', 'trim|required');
		$this->form_validation->set_rules('title_of_activity', 'Title of Activity', 'trim|required');
		$this->form_validation->set_rules('visa_insurance_place', 'Visa Issuance place', 'trim|required');
		$this->form_validation->set_rules('duration_of_stay', 'Duration of Stay in ' . $data['conference']->row("country_name"), 'trim|required|numeric');
		$this->form_validation->set_rules('no_of_previous_travels', 'Number of Previous Travels to '. $data['conference']->row("country_name"), 'trim|required|numeric');
		$this->form_validation->set_rules('date_of_entry_for_conference', 'Date of entry For Conference', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		
		
		if ( $this->input->post("last_date_of_entry") != '')
		{
			$this->form_validation->set_rules('last_date_of_entry', 'The Last Date of Entry to '. $data['conference']->row("country_name") .' [date you left '. $data['conference']->row("country_name") .' last time]', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		}
		else
		{
			$this->form_validation->set_rules('last_date_of_entry', 'last_date_of_entry', 'trim');
		}
		
		
		$this->form_validation->set_rules('date_of_departure', 'Date of Departure from '.  $data['conference']->row("country_name")  .' after conference', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');	
	}
	
	
	public function validate_fields_9( $data )
	{
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('mailing_address', 'Mailing Address', 'trim|required');
		#$this->form_validation->set_rules('type_of_professional', 'Type of Professional', 'trim|required');
		$this->form_validation->set_rules('speciality_interest', 'Speciality / Area of Interest', 'trim');
		$this->form_validation->set_rules('age_level_of_school', 'Level of School', 'trim');
	}

	
	public function validate_fields_10( $data )
	{
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim');
		$this->form_validation->set_rules('father_name', 'Fathers Name', 'trim|required');
		$this->form_validation->set_rules('surname', 'SurName', 'trim|required');
		$this->form_validation->set_rules('passport_number', 'Passport Number', 'trim|required');
		$this->form_validation->set_rules('passport_type', 'Passport Type', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('place_of_birth', 'Place of Birth', 'trim|required');
		$this->form_validation->set_rules('country_of_birth', 'Country of Birth', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		
		

		if ( 1==1  and isset($_POST['name']))
		{

			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_passport_image",
														"db_field"											=> "passport_image",
														"input_nick"										=> "Passport Image",
														"hdn_field"											=> "passport_image",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE,
														"max_size"											=> 1024);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
			
			
			
			
			
			
			
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_photo_image",
														"db_field"											=> "photo_image",
														"input_nick"										=> "Photo Image",
														"hdn_field"											=> "photo_image",
														"tmp_table_field"									=> "upload_2",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE,
														"max_size"											=> 1024);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_2					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_2  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
			
			#$this->form_validation->run();
			
		}
		
		
		$this->form_validation->set_rules('passport_image', 'Passport Image', 'trim');
		$this->form_validation->set_rules('photo_image', 'Photo Image', 'trim');
		$this->form_validation->set_rules('marital_status', 'Martial Status', 'trim|required');
		$this->form_validation->set_rules('gender_father_name', 'Gender(s) Father Name', 'trim');
		$this->form_validation->set_rules('previous_nationality', 'Previous Nationality', 'trim|required');
		$this->form_validation->set_rules('date_of_issue', 'Date of Issue', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('place_of_issue', 'Place of Issue', 'trim|required');
		$this->form_validation->set_rules('expiry_date', 'Expiry Date', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('occupation', 'Occupation', 'trim|required');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		$this->form_validation->set_rules('name_of_institute_company', 'Name of Institute/Company', 'trim|required');
		$this->form_validation->set_rules('title_of_activity', 'Title of Activity', 'trim|required');
		$this->form_validation->set_rules('visa_insurance_place', 'Visa Issuance place', 'trim|required');
		$this->form_validation->set_rules('duration_of_stay', 'Duration of Stay in ' . $data['conference']->row("country_name"), 'trim|required|numeric');
		$this->form_validation->set_rules('no_of_previous_travels', 'Number of Previous Travels to '. $data['conference']->row("country_name"), 'trim|required|numeric');
		$this->form_validation->set_rules('date_of_entry_for_conference', 'Date of entry For Conference', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		
		
		if ( $this->input->post("last_date_of_entry") != '')
		{
			$this->form_validation->set_rules('last_date_of_entry', 'The Last Date of Entry to '. $data['conference']->row("country_name") .' [date you left '. $data['conference']->row("country_name") .' last time]', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		}
		else
		{
			$this->form_validation->set_rules('last_date_of_entry', 'last_date_of_entry', 'trim');
		}
		
		
		$this->form_validation->set_rules('date_of_departure', 'Date of Departure from '.  $data['conference']->row("country_name")  .' after conference', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');	
	}
	
	
	public function index( $conference_slug = '' )
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		$data									= $this->data;
		$data['h1']								= '';
		$data['_pagetitle']						= lang_line('text_conferenceregistration');
		
		$data['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");
		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		
		
		$user_id = $this->functions->_user_logged_in_details( "id" ) > 0 ? $this->functions->_user_logged_in_details( "id" ) : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");

		$data['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
																				" AND userid = '". $user_id . "' 
																				  AND conferenceid = '". $data['conference'] -> row("id") ."' ");
		
		if ( $data['conferenceregistration'] -> num_rows() <= 0 )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration" );
		}

		
		
		
		
		
		
		$TMP_is_paid							= total_conferenceregistrations(	$user_id, 
																					$data['conference']->row("id"), 
																					1 
																				);
	
		if ( ( $data['conferenceregistration'] -> row("is_paid") ) || ( $TMP_is_paid ) )
		{
			
			redirect( site_url( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/1" ) );
			
			$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																	lang_line('text_registrationcomplete_desc'), 
																	lang_line('text_registrationcomplete'));
			
			$data['_pageview']			= "global/_blank_page.php";		
			
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
			return false;
		}
		
		
		
		
		
		
		#fetch screen_one query details
		$data['conferenceregistration_screenone']		= $this->queries->fetch_records('short_conference_registration_screen_one', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
		
		if ( $data['conferenceregistration_screenone'] -> num_rows() <= 0 )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration/screen/1" );
		}
		$data['conferenceregistration_screenone_family_details']	= $this->queries->fetch_records('short_conference_registration_screen_one_family_details', 
																									" AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ");
		#fetch screen_one query details
		

		
		
		
		
		
		
		#fetch screen_two query details

		$data['conferenceregistration_screentwo']		= $this->queries->fetch_records('short_conference_registration_screen_two', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
		
		if ( $data['conferenceregistration_screentwo'] -> num_rows() <= 0 )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration/screen/2" );
		}

		$data['conferenceregistration_screentwo_details']	= $this->queries->fetch_records('short_conference_registration_screen_two_details', 
																						" AND parentid = '". $data['conferenceregistration_screentwo']->row("id") ."' ");
		#fetch screen_two query details
		
		
		
		
		
		#if already record found (go in EDIT mode)
		
		$data['conferenceregistration_screenthree']		= $this->queries->fetch_records('short_conference_registration_screen_three', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."'
																						  AND parentid = '0'
																						");
																						// die('dsgfdsgf');
		// var_dump($this->db->last_query());die;
		// var_dump($data['conferenceregistration_screenthree']->num_rows() );die;
		if (  !empty($data['conferenceregistration_screenthree']) && $data['conferenceregistration_screenthree']->num_rows() > 0 )
		{
			$this->_create_fields_for_form(TRUE, $data, $data['conferenceregistration_screenthree']->row_array());	
		}
		else
		{			
			$data['full_name']					= $data['conferenceregistration_screenone']->row()->name;
			$data['email']						= $data['conferenceregistration_screenone']->row()->email;
			$data['phone']						= $data['conferenceregistration_screenone']->row()->phone;
		}
		
		$this -> _switchConference( $conference_slug, $data );

		
		
		$data['country_notes']					= $this->queries->fetch_records('short_conference_residence_country_notes', 
																				  " AND country_id = '".   $data['conferenceregistration_screenone']->row()->country_of_residence ."' 
																					AND conferenceid = '". $data['conference']->row()->id ."'   ");
		
		if ($this->form_validation->run() == FALSE)
		{
			
			if ( validation_errors() != '' )
			{
				$data['_messageBundle2']				= $this->_messageBundle( 'danger' , lang_line('text_pleasecompleteformwithproperinfo'), 'Error!');
			}
			
			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');			
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
		}
		else
		{
				
			$data['parentid']							= 0;
			$data['screen_one_detail_id']				= 0;
			$this->save_update( $data );
			
			
			
			redirect( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/4" );			
		}
		
		
		
		
	}
	
	
	
	function _switchConference( $conference_slug, &$data )
	{
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:
				$this -> _12( $data );
				break;
			
			case strpos($conference_slug, '10th') !== FALSE:
				$this -> _10( $data );
				break;
				
			case strpos($conference_slug, '9th') !== FALSE:
				$this -> _9( $data );
				break;
				
			default:
				$this -> _8( $data );
				break;
		}
		
	}
	
	
	public function _8( &$data )
	{
		$this->validate_fields( $data );
		
		$data['_pageview']								= "frontend/shortconference/screen_three.php";
	}
	
	
	public function _9( &$data )
	{
		$this->validate_fields( $data );
		
		$data['_pageview']								= "frontend/shortconference/9/screen_three.php";
	}

	public function _12( &$data )
	{
		if ( $this->functions->validate_if_require_visa( $data['conferenceregistration'] ) <= 0 )
		{						
			if ( $data['conferenceregistration_screenthree']->num_rows() <= 0 )
			{
				$tmp_data_save_for_screen_3_for_10th_conf['parentid']							= 0;
				$tmp_data_save_for_screen_3_for_10th_conf['screen_one_detail_id']				= 0;
				$tmp_data_save_for_screen_3_for_10th_conf['full_name']							= $data['conferenceregistration_screenone']->row()->name;
				$tmp_data_save_for_screen_3_for_10th_conf['email']								= $data['conferenceregistration_screenone']->row()->email;
				$tmp_data_save_for_screen_3_for_10th_conf['phone']								= $data['conferenceregistration_screenone']->row()->phone;
				$tmp_data_save_for_screen_3_for_10th_conf['name']								= $data['conferenceregistration_screenone']->row()->name;
				$this->save_update( $data, $tmp_data_save_for_screen_3_for_10th_conf );
				$__screen_three_id					= $this->db->insert_id();
			}
			else
			{
				$__screen_three_id					= $data['conferenceregistration_screenthree']->row()->id;
			}
			foreach ($data['conferenceregistration_screenone_family_details']->result_array() as $csofd)
			{
				$_validate_if_screen_three_family_exists			= $this->queries->fetch_records('short_conference_registration_screen_three', 
																									" AND parentid  = '". $__screen_three_id ."' 
																					  				AND screen_one_detail_id = '". $csofd["id"] ."' ");
				if ( $_validate_if_screen_three_family_exists->num_rows() <= 0 )
				{
					$tmp_data_save_for_screen_3_for_10th_conf['parentid']							= $__screen_three_id;
					$tmp_data_save_for_screen_3_for_10th_conf['screen_one_detail_id']				= $csofd["id"];
					$tmp_data_save_for_screen_3_for_10th_conf['full_name']							= $csofd['family_name'];
					$tmp_data_save_for_screen_3_for_10th_conf['email']								= $csofd['family_email'];
					$tmp_data_save_for_screen_3_for_10th_conf['phone']								= "";
					$tmp_data_save_for_screen_3_for_10th_conf['name']								= $csofd['family_name'];
					$this->save_update( $data, $tmp_data_save_for_screen_3_for_10th_conf );	
				}																					
			}
			redirect( site_url("shortconference/". $data['conference']->row("slug") ."/registration/screen/5") );	
		}
		$this->validate_fields( $data );
		
		$data['_pageview']								= "frontend/shortconference/12/screen_three.php";
	}
	
	public function _10( &$data )
	{
			
		if ( $this->functions->validate_if_require_visa( $data['conferenceregistration'] ) <= 0 )
		{
			
			
			if ( $data['conferenceregistration_screenthree']->num_rows() <= 0 )
			{
				//only for 10th Conf..
				$tmp_data_save_for_screen_3_for_10th_conf['parentid']							= 0;
				$tmp_data_save_for_screen_3_for_10th_conf['screen_one_detail_id']				= 0;
				$tmp_data_save_for_screen_3_for_10th_conf['full_name']							= $data['conferenceregistration_screenone']->row()->name;
				$tmp_data_save_for_screen_3_for_10th_conf['email']								= $data['conferenceregistration_screenone']->row()->email;
				$tmp_data_save_for_screen_3_for_10th_conf['phone']								= $data['conferenceregistration_screenone']->row()->phone;
				$tmp_data_save_for_screen_3_for_10th_conf['name']								= $data['conferenceregistration_screenone']->row()->name;
				$this->save_update( $data, $tmp_data_save_for_screen_3_for_10th_conf );
				$__screen_three_id					= $this->db->insert_id();
			}
			else
			{
				$__screen_three_id					= $data['conferenceregistration_screenthree']->row()->id;
			}
			
			foreach ($data['conferenceregistration_screenone_family_details']->result_array() as $csofd)
			{
				$_validate_if_screen_three_family_exists			= $this->queries->fetch_records('short_conference_registration_screen_three', 
																									" AND parentid  = '". $__screen_three_id ."' 
																					  				AND screen_one_detail_id = '". $csofd["id"] ."' ");
				if ( $_validate_if_screen_three_family_exists->num_rows() <= 0 )
				{
					$tmp_data_save_for_screen_3_for_10th_conf['parentid']							= $__screen_three_id;
					$tmp_data_save_for_screen_3_for_10th_conf['screen_one_detail_id']				= $csofd["id"];
					$tmp_data_save_for_screen_3_for_10th_conf['full_name']							= $csofd['family_name'];
					$tmp_data_save_for_screen_3_for_10th_conf['email']								= $csofd['family_email'];
					$tmp_data_save_for_screen_3_for_10th_conf['phone']								= "";
					$tmp_data_save_for_screen_3_for_10th_conf['name']								= $csofd['family_name'];
					$this->save_update( $data, $tmp_data_save_for_screen_3_for_10th_conf );	
				}
																									
			}			
			
			redirect( site_url("shortconference/". $data['conference']->row("slug") ."/registration/screen/5") );	
		}
		
		$this->validate_fields( $data );
		
		$data['_pageview']								= "frontend/shortconference/10/screen_three.php";
	}
	
	
	
	function save_update( $data, $save_tmp_data = array() )
	{
		switch (  $data['conference']->row()->slug )
		{
			case strpos( $data['conference']->row()->slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:
				$this -> save_update_12( $data, $save_tmp_data );
				break;
			
			case strpos( $data['conference']->row()->slug, '10th') !== FALSE:
				$this -> save_update_10( $data, $save_tmp_data );
				break;
				
			case strpos( $data['conference']->row()->slug, '9th') !== FALSE:
				$this -> save_update_9( $data );
				break;
				
			default:
				$this -> save_update_8( $data );
				break;
		}
	}

	function save_update_12( $data, $enter_simple_info )
	{
		$_age_level_of_school				= $this->input->post("age_level_of_school");
		if ( $_age_level_of_school == "" )
		{
			$_age_level_of_school			= NULL;	
		}

		if ( count($enter_simple_info) > 0 )
		{
			$TMP_session						= array("conferenceregistrationid"				=> $data['conferenceregistration']->row("id"),
														"screen_one_id"							=> $data['conferenceregistration_screenone']->row("id"),
														"screen_two_id"							=> $data['conferenceregistration_screentwo']->row("id"),
														
														"name"									=> $enter_simple_info["name"],
														"full_name"								=> $enter_simple_info["full_name"],
														"email"									=> $enter_simple_info["email"],
														"phone"									=> $enter_simple_info["phone"],
														
														"date_added"							=> date("Y-m-d H:i:s"),
														"parentid"								=> $enter_simple_info['parentid'],
														"screen_one_detail_id"					=> $enter_simple_info['screen_one_detail_id']); //status =1  (in review)
		}
		else
		{
			$TMP_session						= array("conferenceregistrationid"				=> $data['conferenceregistration']->row("id"),
													"screen_one_id"							=> $data['conferenceregistration_screenone']->row("id"),
													"screen_two_id"							=> $data['conferenceregistration_screentwo']->row("id"),
													"gender"								=> $this->input->post("gender"),
													
													"full_name"								=> $this->input->post("full_name"),
													"email"									=> $this->input->post("email"),
													"phone"									=> $this->input->post("phone"),
													"mailing_address"						=> $this->input->post("mailing_address"),
													
													"speciality_interest"					=> $this->input->post("speciality_interest"),
													"age_level_of_school"					=> $_age_level_of_school,
													
													"date_added"							=> date("Y-m-d H:i:s"),
													"parentid"								=> $data['parentid'],
													"screen_one_detail_id"					=> $data['screen_one_detail_id']); //status =1  (in review)
		}

		if ( $this->input->post("id") == '' )
		{
			$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_three", 'id'); 
			// var_dump($this->db->last_query());die;
			$TMP_session['id']							= $this->db->insert_id();

		}
		else
		{
			$TMP_session["date_modified"]				= date("Y-m-d H:i:s");
			$TMP_session["id"]							= $this->input->post("id");
			$this->queries->SaveDeleteTables($TMP_session, 'e', "tb_short_conference_registration_screen_three", 'id'); 
		}
		
		
		
	}
	
	function save_update_8( $data )
	{
		$TMP_session						= array("conferenceregistrationid"				=> $data['conferenceregistration']->row("id"),
													"screen_one_id"							=> $data['conferenceregistration_screenone']->row("id"),
													"screen_two_id"							=> $data['conferenceregistration_screentwo']->row("id"),
													"gender"								=> $this->input->post("gender"),
													"name"									=> $this->input->post("name"),
													"middle_name"							=> $this->input->post("middle_name"),
													"father_name"							=> $this->input->post("father_name"),
													"surname"								=> $this->input->post("surname"),
													"passport_number"						=> $this->input->post("passport_number"),
													"passport_type"							=> $this->input->post("passport_type"),
													"date_of_birth"							=> date("Y-m-d", strtotime( $this->input->post("date_of_birth") ) ),
													"place_of_birth"						=> $this->input->post("place_of_birth"),
													"country_of_birth"						=> $this->input->post("country_of_birth"),
													"nationality"							=> $this->input->post("nationality"),
													"passport_image"						=> $this->input->post("passport_image"),
													"photo_image"							=> $this->input->post("photo_image"),
													"marital_status"						=> $this->input->post("marital_status"),
													"gender_father_name"					=> $this->input->post("gender_father_name"),
													"previous_nationality"					=> $this->input->post("previous_nationality"),
													"date_of_issue"							=> date("Y-m-d", strtotime( $this->input->post("date_of_issue") ) ),
													"place_of_issue"						=> $this->input->post("place_of_issue"),
													
													"expiry_date"							=> date("Y-m-d", strtotime( $this->input->post("expiry_date") ) ),
													"occupation"							=> $this->input->post("occupation"),
													"position"								=> $this->input->post("position"),
													"name_of_institute_company"				=> $this->input->post("name_of_institute_company"),
													"title_of_activity"						=> $this->input->post("title_of_activity"),
													"visa_insurance_place"					=> $this->input->post("visa_insurance_place"),
													"duration_of_stay"						=> $this->input->post("duration_of_stay"),
													"no_of_previous_travels"				=> $this->input->post("no_of_previous_travels"),
													"date_of_entry_for_conference"			=> date("Y-m-d", strtotime( $this->input->post("date_of_entry_for_conference") ) ),
													"last_date_of_entry"					=> date("Y-m-d", strtotime( $this->input->post("last_date_of_entry") ) ),
													"date_of_departure"						=> date("Y-m-d", strtotime( $this->input->post("date_of_departure") ) ),
													"date_added"							=> date("Y-m-d H:i:s"),
													"parentid"								=> $data['parentid'],
													"screen_one_detail_id"					=> $data['screen_one_detail_id']); //status =1  (in review)


		

		if ( $this->input->post("id") == '' )
		{
			$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_three", 'id'); 
			$TMP_session['id']							= $this->db->insert_id();
		}
		else
		{
			$TMP_session["date_modified"]				= date("Y-m-d H:i:s");
			$TMP_session["id"]							= $this->input->post("id");
			$this->queries->SaveDeleteTables($TMP_session, 'e', "tb_short_conference_registration_screen_three", 'id'); 
		}
		
		
		
	}
	
	
	function save_update_9( $data )
	{
		$_age_level_of_school				= $this->input->post("age_level_of_school");
		if ( $_age_level_of_school == "" )
		{
			$_age_level_of_school			= NULL;	
		}
		
		
		$TMP_session						= array("conferenceregistrationid"				=> $data['conferenceregistration']->row("id"),
													"screen_one_id"							=> $data['conferenceregistration_screenone']->row("id"),
													"screen_two_id"							=> $data['conferenceregistration_screentwo']->row("id"),
													"gender"								=> $this->input->post("gender"),
													
													"full_name"								=> $this->input->post("full_name"),
													"email"									=> $this->input->post("email"),
													"phone"									=> $this->input->post("phone"),
													"mailing_address"						=> $this->input->post("mailing_address"),
													
													"speciality_interest"					=> $this->input->post("speciality_interest"),
													"age_level_of_school"					=> $_age_level_of_school,
													
													"date_added"							=> date("Y-m-d H:i:s"),
													"parentid"								=> $data['parentid'],
													"screen_one_detail_id"					=> $data['screen_one_detail_id']); //status =1  (in review)


		

		if ( $this->input->post("id") == '' )
		{
			$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_three", 'id'); 
			$TMP_session['id']							= $this->db->insert_id();
		}
		else
		{
			$TMP_session["date_modified"]				= date("Y-m-d H:i:s");
			$TMP_session["id"]							= $this->input->post("id");
			$this->queries->SaveDeleteTables($TMP_session, 'e', "tb_short_conference_registration_screen_three", 'id'); 
		}
		
		
		
	}
	
	
	
	function save_update_10( $data, $enter_simple_info = array() )
	{
		if ( count($enter_simple_info) > 0 )
		{
			$TMP_session						= array("conferenceregistrationid"				=> $data['conferenceregistration']->row("id"),
														"screen_one_id"							=> $data['conferenceregistration_screenone']->row("id"),
														"screen_two_id"							=> $data['conferenceregistration_screentwo']->row("id"),
														
														"name"									=> $enter_simple_info["name"],
														"full_name"								=> $enter_simple_info["full_name"],
														"email"									=> $enter_simple_info["email"],
														"phone"									=> $enter_simple_info["phone"],
														
														"date_added"							=> date("Y-m-d H:i:s"),
														"parentid"								=> $enter_simple_info['parentid'],
														"screen_one_detail_id"					=> $enter_simple_info['screen_one_detail_id']); //status =1  (in review)
		}
		else
		{
			$TMP_session						= array("conferenceregistrationid"				=> $data['conferenceregistration']->row("id"),
														"screen_one_id"							=> $data['conferenceregistration_screenone']->row("id"),
														"screen_two_id"							=> $data['conferenceregistration_screentwo']->row("id"),
														"gender"								=> $this->input->post("gender"),
														"name"									=> $this->input->post("name"),
														"full_name"								=> $this->input->post("name") . ' ' . $this->input->post("middle_name") . ' ' . $this->input->post("father_name"),
														"middle_name"							=> $this->input->post("middle_name"),
														"father_name"							=> $this->input->post("father_name"),
														"surname"								=> $this->input->post("surname"),
														"passport_number"						=> $this->input->post("passport_number"),
														"passport_type"							=> $this->input->post("passport_type"),
														"date_of_birth"							=> date("Y-m-d", strtotime( $this->input->post("date_of_birth") ) ),
														"place_of_birth"						=> $this->input->post("place_of_birth"),
														"country_of_birth"						=> $this->input->post("country_of_birth"),
														"nationality"							=> $this->input->post("nationality"),
														"passport_image"						=> $this->input->post("passport_image"),
														"photo_image"							=> $this->input->post("photo_image"),
														"marital_status"						=> $this->input->post("marital_status"),
														"gender_father_name"					=> $this->input->post("gender_father_name"),
														"previous_nationality"					=> $this->input->post("previous_nationality"),
														"date_of_issue"							=> date("Y-m-d", strtotime( $this->input->post("date_of_issue") ) ),
														"place_of_issue"						=> $this->input->post("place_of_issue"),
														
														"expiry_date"							=> date("Y-m-d", strtotime( $this->input->post("expiry_date") ) ),
														"occupation"							=> $this->input->post("occupation"),
														"position"								=> $this->input->post("position"),
														"name_of_institute_company"				=> $this->input->post("name_of_institute_company"),
														"title_of_activity"						=> $this->input->post("title_of_activity"),
														"visa_insurance_place"					=> $this->input->post("visa_insurance_place"),
														"duration_of_stay"						=> $this->input->post("duration_of_stay"),
														"no_of_previous_travels"				=> $this->input->post("no_of_previous_travels"),
														"date_of_entry_for_conference"			=> date("Y-m-d", strtotime( $this->input->post("date_of_entry_for_conference") ) ),
														"last_date_of_entry"					=> date("Y-m-d", strtotime( $this->input->post("last_date_of_entry") ) ),
														"date_of_departure"						=> date("Y-m-d", strtotime( $this->input->post("date_of_departure") ) ),
														"date_added"							=> date("Y-m-d H:i:s"),
														"parentid"								=> $data['parentid'],
														"screen_one_detail_id"					=> $data['screen_one_detail_id']); //status =1  (in review)
		}


		

		if ( $this->input->post("id") == '' )
		{
			$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_three", 'id'); 
			$TMP_session['id']							= $this->db->insert_id();
		}
		else
		{
			$TMP_session["date_modified"]				= date("Y-m-d H:i:s");
			$TMP_session["id"]							= $this->input->post("id");
			$this->queries->SaveDeleteTables($TMP_session, 'e', "tb_short_conference_registration_screen_three", 'id'); 
		}
		
		
		
	}
}