<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("controls_include.php");
class Controls extends Controls_Include {

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
	 
	public function __construct( $global_parameters = array() )
	{
		parent::__construct();
		
		$IS_auth_login				= TRUE;
		if ( count( $global_parameters ) > 0 )
		{
			if ( array_key_exists("required_login", $global_parameters ) )
			{
				if ( ! $global_parameters['required_login'] )
				{
					$IS_auth_login		= FALSE;
				}
			}
		}
		
		
		if ( $IS_auth_login )
		{
			$this->_auth_login( false );
		}
		
		$this->data													= $this->default_data();
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'Manage Short Conference Registration Finance';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";

		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/conference_registration/";
		$this->data['_messageBundle2']								= $this->data['_messageBundle'];
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	

	}
	


	
	
	
	public function view()
	{
		$data														= $this->data;
		
		#$data["table_record"]										= $this->queries->fetch_records("conferenceregistration");
		$this->load->library("Encrption");
		$data['table_record'] 										= $this->fetch_records_for_view( array(), false, SessionHelper::_get_session("slug", "conference") );		
		
		
		$data["table_properties"]									= $this -> view_table_properties(  SessionHelper::_get_session("slug", "conference") );
		
		//$data["table_properties"]									= $this->view_table_properties();
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function index ()
	{
		
	}
	
	
	public function all_about_SCREEN_5( $screen_three_id = 0, &$data, $EXTRA_data = array() )
	{
		$edit_details												= $this->queries->fetch_records("short_conference_registration_screen_three", " AND id = '$screen_three_id' ");
		
		$this->display_values( $data, $screen_three_id, $edit_details, $EXTRA_data );
		
		
		
		$data['h2']							= '';
		$data['_pageview']					= $data["_directory"] . "include_view_screen_5.php";	
	}
	
	
	
	
	public function include_view_screen_5(  $screen_three_id = 0, $EXTRA_data  = array() )
	{
	
		$data														= $this->data;
		
			
		$this->all_about_SCREEN_5( $screen_three_id, $data, $EXTRA_data);
		
		$abc = $this->load->view( $data['_pageview'], $data, TRUE);
		
		
		
	
		return $abc;

	}
	
	
	public function display_screen_5( $screen_three_id = 0 )
	{
		$data														= $this->data;
		
		
		
		$data['conference_regions']									= FALSE;
		$edit_details												= $this->queries->fetch_records("short_conference_registration_screen_three", " AND id = '$screen_three_id' ");
		if ( $edit_details -> num_rows() > 0 )
		{
			$conferenceregistration									= $this->queries->fetch_records('short_conference_registration_master', 
																									" AND id = '". $edit_details ->row( 'conferenceregistrationid' ) ."' ");
		
			$data['conference_regions']								= $this->queries->fetch_records('short_conference_regions', " AND id = '". $conferenceregistration->row("regionid") . "' ");		
		}
		
		
	
		$this->all_about_SCREEN_5( $screen_three_id, $data);	
		

		$this->load->view( POPUP_ADMINCMS_TEMPLATE_VIEW, $data );
	}
	
	
	
	
	
	public function __save ($conference_slug = '')
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		
		
		
		
		
		#standard validation
		#$this->form_validation->set_rules("id", "id", "trim");
		#$this->form_validation->set_rules("options", "options", "trim");
		#$this->form_validation->set_rules("unique_formid", "unique_formid", "trim");
		
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		$data['conference']					= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");
		
		
		$tmp_validate_DB				= $this->queries->fetch_records("short_conference_registration", " AND conferenceid = '". $this->input->post("conferenceid") ."' ");
		$tmp_validate_VALUES			= $this->find_duplicate_values($tmp_validate_DB, $this->input->post("id"));
		
		$this->form_validation->set_rules('userid', 'User', 'trim|required');
		$this->form_validation->set_rules('conferenceid', 'Conference', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('father_name', 'Fathers Name', 'trim|required');
		$this->form_validation->set_rules('surname', 'SurName', 'trim|required');
		$this->form_validation->set_rules('passport_number', 'Passport Number', 'trim|required');
		$this->form_validation->set_rules('passport_type', 'Passport Type', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('place_of_birth', 'Place of Birth', 'trim|required');
		$this->form_validation->set_rules('country_of_birth', 'Country of Birth', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		
		

		if ( 1==1  and isset( $_POST['name'] ) )
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
														"encrypt_name"										=> TRUE);
		
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
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_2					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_2  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
			
			$this->form_validation->run();
			
		}
		
		
		$this->form_validation->set_rules('passport_image', 'Passport Image', 'trim|required');
		$this->form_validation->set_rules('photo_image', 'Photo Image', 'trim|required');
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
		$this->form_validation->set_rules('last_date_of_entry', 'The Last Date of Entry to '. $data['conference']->row("country_name") .' [date you left '. $data['conference']->row("country_name") .' last time]', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		$this->form_validation->set_rules('date_of_departure', 'Date of Departure from '.  $data['conference']->row("country_name")  .' after conference', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
		
		
		
		
		
		
		
		if ( $data['total_family_registrations'] > 0 )
		{
			$this->form_validation->set_rules('will_attend_conference', 'Will attend conference', 'trim|required');
		} else {
			
			$this->form_validation->set_rules('accompanied_by_family', 'Are you accompanied by family members', 'trim|required');
		
			if ( $this->input->post("accompanied_by_family") == "1" )
			{
				$this->form_validation->set_rules('no_of_family_members_accompanied', 'Number of family members Accompanying you', 'trim|required|numeric|greater_than[0]');
			}
			else
			{
				$this->form_validation->set_rules('no_of_family_members_accompanied', 'Number of family members Accompanying you', 'trim');	
			}
			
		}
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('mailing_address', 'Mailing Address', 'trim|required');
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
	
			$saveData										= array(
																	"userid"								=> $this->input->post("userid"),
																	"conferenceid"							=> $this->input->post("conferenceid"),
																	"gender"								=> $this->input->post("gender"),
																	"name"									=> $this->input->post("name"),
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
																	"accompanied_by_family"					=> format_bool($this->input->post("accompanied_by_family")),
																	"no_of_family_members_accompanied"		=> $this->input->post("no_of_family_members_accompanied"),
																	"will_attend_conference"				=> format_bool($this->input->post("will_attend_conference")),
																	
																	"email"									=> $this->input->post("email"),
																	"mobile"								=> $this->input->post("mobile"),
																	"mailing_address"						=> $this->input->post("mailing_address"),
																	
																	
																	"parentid"								=> $this->input->post("parentid"),
																	

																	
																	"date_added"							=> date("Y-m-d H:i:s", strtotime($this->input->post("date_added"))),
																	'status'								=> format_bool($this->input->post("status")),
																	'is_paid'								=> format_bool($this->input->post("is_paid")) ); //status =1  (in review)
			
			
		
			
			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_registration", 'id');  
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_registration", 'id'); 
				$saveData['id']									= $this->db->insert_id();	
			}
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	}

	
	public function display_values( &$data, $edit_id, $edit_details, $EXTRA_data = array() )
	{
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		

		
		$data['_SHOW_INPUTS']							= FALSE;
		
		
		
		
		
		
		#merge two array (over-write)
		$data											= merge_multi_arrays( array($data, $EXTRA_data) );
		
		
		
		
		$data['conferenceregistration']					= $this->queries->fetch_records('short_conference_registration_master', 
																						" AND id = '". $edit_details['conferenceregistrationid'] ."' ");
		
		$data['conference']								= $this->queries->fetch_records('short_conference', " AND id = '". $data['conferenceregistration']->row("conferenceid") ."' ");
		
		
		$data['after_duration_date']					= NumberHelper::number_array( range("0", "3") );
		
		
		
		/* $data['important_content']						= $this->mixed_queries->fetch_records('conference_content_with_menu', 
																			" 	AND m.slug = 'conference-registration-screen-five-important-section' 
																				AND m.conferenceid = '". $data['conferenceregistration']->row("conferenceid") ."'"); */
		
		
		include_once(APPPATH.'controllers/shortconference/registration/screen_five.php');		
		
		Screen_Five::filled_values_by_database( $data );

		
		
		
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("short_conference_registration_screen_three", 
																									" AND id = '$edit_id' ");
																																							
		
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		$this->display_values( $data, $edit_id, $edit_details );
		
		
		
		
		#Set fetch_records_for_view in a new variable so we can use it in view_registration_prices
		$_get_screen_three_record_cleaned							= $this->fetch_records_for_view( array($edit_id) );
		$data["fetch_records_for_view_ROW"]							= array();
		if ( count($_get_screen_three_record_cleaned) > 0 )
		{
			$data["fetch_records_for_view_ROW"]						= $_get_screen_three_record_cleaned[0];
		}
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	/*************	Hadi 12-3-2015	***************/
	public function update($edit_id)
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		$data["show_update_page"] 									= true;
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("short_conference_registration_screen_three", " AND id = '$edit_id' ");
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		$this->display_values( $data, $edit_id, $edit_details );
		//If page submitted
		if($this->input->post()){
			$this->functions->unite_post_values_form_validation();
			$this->form_validation->set_rules('userid', 'User', 'trim|required');
			$this->form_validation->set_rules('conferenceid', 'Conference', 'trim|required');
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('father_name', 'Fathers Name', 'trim|required');
			$this->form_validation->set_rules('surname', 'Surname', 'trim|required');
			$this->form_validation->set_rules('passport_number', 'Passport Number', 'trim|required');
			$this->form_validation->set_rules('passport_type', 'Passport Type', 'trim|required');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
			$this->form_validation->set_rules('place_of_birth', 'Place of Birth', 'trim|required');
			$this->form_validation->set_rules('country_of_birth', 'Country of Birth', 'trim|required');
			$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
			
			$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
			$this->form_validation->set_rules('gender_father_name', 'Gender Father Name', 'trim|required');
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
			$this->form_validation->set_rules('last_date_of_entry', 'The Last Date of Entry to '. $data['conference']->row("country_name") .' [date you left '. $data['conference']->row("country_name") .' last time]', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
			$this->form_validation->set_rules('date_of_departure', 'Date of Departure from '.  $data['conference']->row("country_name")  .' after conference', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
			
			/***************Image Uploads******************/
			//If file exists
			$tmp_upload_images = array();
			if(isset($_FILES["file_passport_image"]) && $_FILES["file_passport_image"]["name"]!=""){
				$other_upload = array(	"validate" => TRUE,
										"input_field" => "file_passport_image",
										"db_field" => "passport_image",
										"input_nick" => "Passport Image",
										"hdn_field" => "passport_image",
										"tmp_table_field" => "upload_1",
										"is_multiple" => FALSE);
				$config_image = array(	"upload_path" => $data["images_dir"],
										"allowed_types" => $data['images_types'],
										"encrypt_name" => TRUE);
				$tmp_upload_img = $this->upload_image($config_image, array(), $other_upload);
				if(is_array($tmp_upload_img) && isset($tmp_upload_img["error"]) && $tmp_upload_img["error"]==1){
					$tmp_upload_images["passport_image"] = $data["images_dir"].$tmp_upload_img["hdn_array"]["passport_image"];
				}
			}
			if(isset($_FILES["file_photo_image"]) && $_FILES["file_photo_image"]["name"]!=""){
				$other_upload = array(	"validate" => TRUE,
										"input_field" => "file_photo_image",
										"db_field" => "photo_image",
										"input_nick" => "Photo Image",
										"hdn_field" => "photo_image",
										"tmp_table_field" => "upload_2",
										"is_multiple" => FALSE);
				$config_image = array(	"upload_path" => $data["images_dir"],
										"allowed_types" => $data['images_types'],
										"encrypt_name" => TRUE);
				$tmp_upload_img	= $this->upload_image($config_image, array(), $other_upload);
				if(is_array($tmp_upload_img) && isset($tmp_upload_img["error"]) && $tmp_upload_img["error"]==1){
					$tmp_upload_images["photo_image"] = $data["images_dir"].$tmp_upload_img["hdn_array"]["photo_image"];
				}
			}
			if(!empty($tmp_upload_images)){
				$this->db->where("id",$edit_id)
						->update("tb_short_conference_registration_screen_three",$tmp_upload_images);
			}
			/**********************************************/
			
			
			if($this->form_validation->run()){
				
				
				$save_data = array(
							"gender" => $this->input->post("gender"),
							"name" => $this->input->post("name"),
							"middle_name" => $this->input->post("middle_name"),
							"father_name" => $this->input->post("father_name"),
							"surname" => $this->input->post("surname"),
							"passport_number" => $this->input->post("passport_number"),
							"passport_type" => $this->input->post("passport_type"),
							"date_of_birth" => date("Y-m-d", strtotime($this->input->post("date_of_birth"))),
							"place_of_birth" => $this->input->post("place_of_birth"),
							"country_of_birth" => $this->input->post("country_of_birth"),
							"nationality" => $this->input->post("nationality"),
							"marital_status" => $this->input->post("marital_status"),
							"gender_father_name" => $this->input->post("gender_father_name"),
							"previous_nationality" => $this->input->post("previous_nationality"),
							"date_of_issue" => date("Y-m-d", strtotime($this->input->post("date_of_issue"))),
							"place_of_issue" => $this->input->post("place_of_issue"),
							"expiry_date" => date("Y-m-d", strtotime($this->input->post("expiry_date"))),
							"occupation" => $this->input->post("occupation"),
							"position" => $this->input->post("position"),
							"name_of_institute_company" => $this->input->post("name_of_institute_company"),
							"title_of_activity" => $this->input->post("title_of_activity"),
							"visa_insurance_place" => $this->input->post("visa_insurance_place"),
							"duration_of_stay" => $this->input->post("duration_of_stay"),
							"no_of_previous_travels" => $this->input->post("no_of_previous_travels"),
							"date_of_entry_for_conference" => date("Y-m-d", strtotime($this->input->post("date_of_entry_for_conference"))),
							"last_date_of_entry" => date("Y-m-d", strtotime($this->input->post("last_date_of_entry"))),
							"date_of_departure" => date("Y-m-d", strtotime($this->input->post("date_of_departure"))),
							"date_modified" => date("Y-m-d h:i:s")
							);
				$this->db->where("id",$edit_id)
					->update("tb_short_conference_registration_screen_three",$save_data);
				
				$data['_messageBundle']	= $this->_messageBundle('success' ,
																lang_line("operation_saved_success"),
																lang_line("heading_operation_success"),
																false, true);
				redirect( $data["_directory"] . "controls/view" );
			}else{
				$data['_messageBundle'] = $this->_messageBundle( 'danger' ,
																 validation_errors(),
																 'Error!');
			}
		}
		
		
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
	}
	/**********************************************/
	
	//public function save
	
	public function options()
	{
		
		$data					= $this->data;
		$is_post				= FALSE;
		
		
		if ( $this->input->post("TMP_change_payment_status_for_this_id") ) 
		{
			$is_post			= TRUE;
		}
		else if ( isset($_POST['checkbox_options']) )
		{
		
			if (count($_POST['checkbox_options']) > 0 )
			{
				$is_post		= TRUE;
			}
				
		}
		
		$ids = [];
		foreach($this->fetch_records_for_view_12() as $key => $value){
			$ids[] .= $value['id'];
		}
		if ($is_post)
		{
			switch ($_POST['options'])
			{
				
				case "delete":
					$this->delete( $_POST['checkbox_options'] );
					break;
					
				
				case "ajax_download_csv":
					$this->download_csv( $ids, SessionHelper::_get_session("slug", "conference") );
					break;
					
				
				case "ajax_change_payment_status":
					$this->change_payment_status_for_this_id( $this->input->post("TMP_change_payment_status_for_this_id") );
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

	public function receipt( $userid, $is_bulk = false ){

		$receipt_pdf 	= "receipts/global-shortconference.php";
		
		$data					= $this->data;

		$_POST['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '". SessionHelper::_get_session("slug", "conference") ."' ");
		
		$_POST['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
		" AND userid = '". $userid . "' 
		  AND conferenceid = '". $_POST['conference'] -> row("id") ."' ");
		  		
		$_POST['conferenceregistration_screenone']		= $this->queries->fetch_records('short_conference_registration_screen_one', " AND conferenceregistrationid = '". $_POST['conferenceregistration']->row("id") ."' ");

		$_POST['conferenceregistration_screenone_family_details']	= $this->queries->fetch_records('short_conference_registration_screen_one_family_details'," AND parentid = '". $_POST['conferenceregistration_screenone']->row("id") ."' ");
		
		$_POST['conferenceregistration_screentwo']		= $this->queries->fetch_records('short_conference_registration_screen_two', " AND conferenceregistrationid = '". $_POST['conferenceregistration']->row("id") ."' ");

		$_POST['conferenceregistration_screentwo_details']	= $this->queries->fetch_records('short_conference_registration_screen_two_details', " AND parentid = '". $_POST['conferenceregistration_screentwo']->row("id") ."' ");
		
		$_POST['donation_details']['name'] = isset($_POST['conferenceregistration_screenone']->row()->name) ? $_POST['conferenceregistration_screenone']->row()->name : '';

		if( $_POST['conferenceregistration_screenone']->num_rows() > 0 )
		{
			$this->load->library('pdf');

			$pdfData = array(
				"pdf_post"		=> $_POST,
				"name"			=> $_POST['conferenceregistration_screenone']->row()->name,
				"email"			=> $_POST['conferenceregistration_screenone']->row()->email,
				"project"		=> $_POST['conferenceregistration']->row()->conference_name,
				"amount"		=> $_POST['conferenceregistration_screentwo']->row()->price_total_payable,
				"date" 			=> $_POST['conferenceregistration']->row()->date_added,
				"serial_num" 	=> 'SC' . $_POST['conferenceregistration']->row()->tax_receipt_num
			);
			
			$file_name = 'registration-receipt-' . $userid . '.pdf';

			$html_code = "";
			$html_code .= '<link rel="preconnect" href="https://fonts.googleapis.com">';
			
			$html_code .= $this->load->view( $receipt_pdf, $pdfData, TRUE );
			$pdf = new Pdf();
			$pdf->load_html($html_code);
			$pdf->render();

			if($is_bulk){
				
				$output = $pdf->output();

				//temp directory path of live and local
				$localhost = array('127.0.0.1', "::1");
				if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
					$path = $_SERVER['DOCUMENT_ROOT'].'/imamiamedicscom/assets/temp-tax-files/';
				} else {
					$path = $_SERVER['DOCUMENT_ROOT'].'/assets/temp-tax-files/';
				}
				file_put_contents($path.$file_name, $output);
			}else{

				$pdf->stream($file_name);
			}
		}
		
		if(!$is_bulk){
			redirect( site_url( $data["_directory"] . "controls/view" ) );
		}
	}
	
	public function change_payment_status_for_this_id( $id )
	{
		$data												= $this->data;
		
		
		if ( $id )
		{
			$saveData['id']									= $id;	
			$saveData['is_paid']							= 1;
			
			$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_registration_master", 'id') ;
			
			
			
			
			
			if ( "FINAL EMAIL TO CUSTOMERS" )
			{
				$conference_master								= $this->queries->fetch_records( "short_conference_registration_master", " AND id = '". $id ."' ");
				$data['conference']								= $this->queries->fetch_records( 'short_conference', " AND id = '". $conference_master->row()->conferenceid ."' ");
				$user_details									= $this->queries->fetch_records( "users", " AND id = '". $conference_master->row()->userid ."' ");
				$conference_regions								= $this->queries->fetch_records( "short_conference_regions", " AND id = '". $conference_master->row("regionid") ."' ");
				
				
				
				$edit_details												= $this->queries->fetch_records("short_conference_registration_screen_three", 
																											" AND conferenceregistrationid = '$id' AND parentid = 0 ");
																																									
				$data["edit_id"]											= $edit_details->row()->id;
				
				if ( $edit_details -> num_rows() <= 0 )
				{
					show_404();
				}
				
				$this->display_values( $data, $edit_id, $edit_details );
				
				
				
				
				$TMP_data['_directory']			= 'admincms/manageshortconferenceregistrationfinance/';	
				/* $TMP_data['important_content']	= $this->mixed_queries->fetch_records('conference_content_with_menu', 
																						 " AND m.slug = 'conference-registration-screen-five-important-section' AND m.conferenceid = '". $data['conference']->row()->id ."'"); */
				$TMP_data['conference_regions']	= $conference_regions;
				$screen_5_view					= $this->include_view_screen_5( $data["edit_id"], $TMP_data );
				$screen_5_view					= str_replace(
															  sprintf( lang_line("text_screen5_planningtostay"), date("jS F", strtotime($data['conference']->row("duration_to")) )),  
															  sprintf( lang_line("text_screen5_planningtostay_2"), date("jS F", strtotime($data['conference']->row("duration_to")) )),  
															  $screen_5_view
															  );
				
				
				
			
				
				
				
				$_POST["TEXT_p"]				= 'Dear ' . $user_details->row("name") . ' ' . $user_details->row("last_name") . ',
												   <br /> <br />Thank you for registering for '. $data['conference']->row("name") .' to be held in '. $data['conference']->row("country_name") .' from ' . date("F d, Y", strtotime( $data['conference']->row("duration_from") ) ) . ' to '. date("F d, Y", strtotime( $data['conference']->row("duration_to") ) ) .'. Please show a copy of this email to facilitate your check-in for conference registration.
												   <br /> <br />
												   Below is the summary for your registration including hotel information as well as some important notices that you should bear in mind.';
		
	
		
				$email_template					= array("email_to"										=> $user_details->row("email"),
														"email_bcc"										=> SessionHelper::_get_session("EMAIL_TO", "site_settings"),
														"email_heading"									=> lang_line("text_conferencepayment"),
														"email_file"									=> "email/frontend/conference_payment.php",
														"email_subject"									=> lang_line("text_conferencepayment"),
														"default_subject"								=> TRUE,
														"email_post"									=> $_POST,
														
														"_messageBundle2_nofamilyguest"					=> $this->_messageBundle( 'danger_big' , '&nbsp;', 'No Family Guest!'),
														
														"screen_5_view"									=> $screen_5_view,
														
														
														);
				
				
				$email_template					= array_merge($email_template, $data);
				
				$is_email_sent					= $this->_send_email( $email_template );
				
				
			}
		}
		
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );	
	}
	
	
	public function download_csv( $id, $conference_slug = FALSE )
	{
		switch ( $conference_slug )
		{

			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima-') !== FALSE:
				$this -> download_csv_12($id);
				break;
			
			case strpos($conference_slug, '10th') !== FALSE:
				$this -> download_csv_10($id);
				break;
				
			case strpos($conference_slug, '9th') !== FALSE:
				$this -> download_csv_9($id);
				break;
				
			default:
				$this -> download_csv_8($id);
				break;
		}
		
	}
	
	public function download_csv_8( $id )
	{
		$data												= $this->data;
		
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='. strtotime("now") .'.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		
		$TMP_heading					= array( 'Name',
												 'Registered For',  
												 'Relation',
												 'Email',
												 'Phone',
												 'Registration Date', 
												 'Region', 
												 'Conference Package', 
												 'Price',
												 'Paid Online',
												 'Cash on Site', 
												 'Abstract', 
												 'Coupon', 
												 'Member Package',
												 'Payment Type',
												 'Payment Status');
		
		fputcsv($output, $TMP_heading);
		
		
		
		

		/*$tmp["tr_heading"]											= array( 'Registered By', 'Registered For', 'Name', 'Registration Date', 'Region', 'Package', 'Total Paid', 'Cash on Site', 'Abstract', 'Coupon', 'Member Package');*/
		/*foreach ($three_records->result_array() as $t)
		{
			$_show_Array[]				= $t['']
		}*/
		
		#fputcsv($output, array("a", "4", "4dd"));
		
		
		$three_records					= $this->queries->fetch_records("short_conference_registration_screen_three", 
																		" AND id in(". implode(",", $id) .") ORDER BY FIELD(id, ". implode(",", $id) .") "); 
		$three_records					= conferenceregistrations_cleanfilter( $three_records->result_array(), TRUE );
		#print_r( $three_records );
		#die;
		#$this->fetch_records_for_view( $id );
		$_show_Array					= array();
		foreach ($three_records as $row) 
		{
			$TMP_name					= $row["name"];
			$TMP_spaces					= "           ";
			
			if ( $row["parentid"] == 0)
			{
				$TMP_name				.= ' ('. $this->queries->fetch_records("short_conference_registration_screen_three", 
																 " AND parentid = '". $row["id"] ."' AND screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid)) ")->num_rows() . ')';
				$TMP_spaces				= "";
				
				
				
				
			}
						
			
			
			
						
			$abc						= array( $TMP_spaces	 . $TMP_name,
												 DropdownHelper::short_conferenceregistration_guestfamilyguest( $row['parentid'] ),
												 
												 $row['family_relationship'],
												 
												 $row['VIEW_email'],
												 $row['VIEW_phone'],
												 
												 $row['VIEW_date_added'],
												 $row['VIEW_region_name'],
												 $row['VIEW_package_name'],
												 
												 $row['VIEW_total_price'],
												 $row['VIEW_total_paid'],
												 $row['VIEW_cash_on_site'],
												 
												 $row['VIEW_is_abstract_submitted'],
												 $row['VIEW_coupon_code'],
												 $row['VIEW_be_a_member_fee_desc'],
												 $row['VIEW_payment_type'],
												 $row['VIEW_is_paid_name']);
			fputcsv($output, $abc);
		}
		
		
		
		// fetch the data
		/*mysql_connect('localhost', 'username', 'password');
		mysql_select_db('database');
		$rows = mysql_query('SELECT field1,field2,field3 FROM table');
		
		// loop over the rows, outputting them
		while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);*/






		/*#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_conference_registration", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		*/
	}
	
	public function download_csv_9( $id )
	{ 
		$data												= $this->data;
		
		
		header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='. strtotime("now") .'.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		
		$TMP_heading					= array( 
												 'Full Name', 
												 'Registered As', 
												 'Registered For',
												 'Relation',
												 'Registration Date',
												 'Email',  
												 'Phone',
												 'Price',
												 'Coupon', 
												 'Member Package',
												 'Payment Type',
												 'Payment Status',
												 'Registration Details');
		
		fputcsv($output, $TMP_heading);
		
		
		
		

		/*$tmp["tr_heading"]											= array( 'Registered By', 'Registered For', 'Name', 'Registration Date', 'Region', 'Package', 'Total Paid', 'Cash on Site', 'Abstract', 'Coupon', 'Member Package');*/
		/*foreach ($three_records->result_array() as $t)
		{
			$_show_Array[]				= $t['']
		}*/
		
		#fputcsv($output, array("a", "4", "4dd"));
		
		
		$three_records					= $this->queries->fetch_records("short_conference_registration_screen_three", 
																		" AND id in(". implode(",", $id) .") ORDER BY FIELD(id, ". implode(",", $id) .") "); 
		$three_records					= conferenceregistrations_cleanfilter( $three_records->result_array(), TRUE );
		//print_r( $three_records );
		//die;
		#$this->fetch_records_for_view( $id );
		$_show_Array					= array();
		
		foreach ($three_records as $row) 
		{
			$TMP_name					= $row["full_name"];
			$TMP_spaces					= "           ";
			
			if ( $row["parentid"] == 0)
			{
				$TMP_name				.= ' ('. $this->queries->fetch_records("short_conference_registration_screen_three", 
																 " AND parentid = '". $row["id"] ."' AND screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid)) ")->num_rows() . ')';
				$TMP_spaces				= "";
				
				
				
				
			}
			
			
			
			
			
			
			
			
			
			
			
			$registration_details = '';
				
			// Registration details
			if ($row["parentid"] == 0) 
			{ 
				
				$TMP_imi_or_nonimi = DropdownHelper::conferenceregistration_paymenttype();
				
				$screen_two_details = $this->queries->fetch_records("short_conference_registration_screen_two_details", " AND parentid = '". $row["screen_two_id"] ."' ");
				
				$registration_details .= "Payment Type: ";
				
				$registration_details .= "\n----------\n";
				
				$registration_details .= $row['earlybird_regular'] == 'earlybird_price' ? 'Earlybird' : 'Regular';
				$registration_details .= " - ";
				$registration_details .= $TMP_imi_or_nonimi[$row["paymenttypeid"]];
				
				$registration_details .= "\n----------\n\n";
				
				$registration_details .= "Registrations: ";

				$registration_details .= "\n----------\n";
				
				$screen_two_details_arr = $screen_two_details->result_array();
				$numrows = count($screen_two_details_arr);	
				$counter = 0;
				foreach($screen_two_details_arr as $trow) 
				{
					$price = $this->db->query("
						SELECT 
						pd.earlybird_price as earlybird_price,
						pd.regular_price as regular_price,
						wh.name as price_name,
						wh.no_of_people as no_of_people
						FROM tb_short_conference_prices_details pd 
						LEFT JOIN tb_short_conference_prices_master pm ON pd.parentid = pm.id
						LEFT JOIN tb_short_conference_who_attend wh ON pm.whoattendid = wh.id
						WHERE pd.id = '". $trow["price_details_id"] ."'
					")->row();
					
					if ($row["earlybird_regular"] == 'earlybird_price') 
					{
						$registration_details .= $price->price_name." --- " . $price->no_of_people." x ".$price->earlybird_price . "\n";
					} 
					else 
					{
						$registration_details .= $price->price_name." --- " . $price->no_of_people." x ".$price->regular_price . "\n";
					}
					
					if(++$counter === $numrows)
					{
						$registration_details .= "----------\n\n";
					}
					
				} 
				
				if ($row["coupon_code"] || $row["speaker_coupon_code"]) 
				{

					$registration_details .= "Coupons: ";
					$registration_details .= "\n----------\n";
					
					if ($row["coupon_code"]) 
					{
						$registration_details .= "IMI Coupon Code --- " . $row["coupon_code"] . "\n";
					}
						
					if ($row["speaker_coupon_code"]) 
					{
						$registration_details .= "Speaker Discount Coupon Code --- " . $row["speaker_coupon_code"] . "\n";
					}
					
					$registration_details .= "----------";
					
				}
				
			} 
			else 
			{ 
				
				$registration_details .= '--'; 
				
			} 
				
			
			
			
			
			
			
			
			
			
			$abc						= array( $TMP_spaces	 . $TMP_name,
												 DropdownHelper::short_conferenceregistration_guestfamilyguest( $row['parentid'] ),
												 $row["user_name"],
												 
												 $row['family_relationship'],
												 
												 $row['VIEW_date_added'],
												 
												 $row['VIEW_email_screen_3'],
												 $row['VIEW_phone_screen_3'],
												 
												 $row['VIEW_total_price'],

												 $row['VIEW_coupon_code'],
												 $row['VIEW_be_a_member_fee_desc'],
												 $row['VIEW_payment_type'],
												 $row['VIEW_is_paid_name'],
												 $registration_details);
			fputcsv($output, $abc);
		}
		
		
		
		// fetch the data
		/*mysql_connect('localhost', 'username', 'password');
		mysql_select_db('database');
		$rows = mysql_query('SELECT field1,field2,field3 FROM table');
		
		// loop over the rows, outputting them
		while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);*/






		/*#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_conference_registration", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		*/
	}
	
	public function download_csv_10( $id )
	{ 
		$data												= $this->data;
		
		
		header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='. strtotime("now") .'.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		
		$TMP_heading					= array( 
												 'Full Name',
												 'UID', 
												 'Registered As', 
												 'Registered For',
												 'Relation',
												 'Registration Date',
												 'Email',  
												 'Phone',
												 'Price',
												 'Payment Type',
												 'Payment Status',
												 
												 'Participant Type',
												 'Registration Type',
												 'Travelling With',
												 
												 'Registration Details');
		
		fputcsv($output, $TMP_heading);



		$three_records					= $this->queries->fetch_records("short_conference_registration_screen_three", 
																		" AND id in(". implode(",", $id) .") ORDER BY FIELD(id, ". implode(",", $id) .") "); 

		$three_records					= conferenceregistrations_cleanfilter( $three_records->result_array(), TRUE );
		
		#print_r($three_records);die;
		#$this->fetch_records_for_view( $id );
		$_show_Array					= array();
		
		foreach ($three_records as $row) 
		{
			
			$TMP_name					= $row["full_name"];
			$TMP_spaces					= "           ";

			if ( $row["parentid"] == 0)
			{
				$TMP_name				.= ' ('. $this->queries->fetch_records("short_conference_registration_screen_three", 
																 " AND parentid = '". $row["id"] ."' AND screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid)) ")->num_rows() . ')';
				$TMP_spaces				= "";

			}

			
			
			$registration_details = '';
				
			// Registration details
			if ($row["parentid"] == 0) 
			{ 
				
				$TMP_imi_or_nonimi 				= DropdownHelper::conferenceregistration_paymenttype();
				$TMP_EB_RG		   				= DropdownHelper::conferenceprice_earlybird_regular_dropdown(TRUE, FALSE );
				$screen_two_details 			= $this->queries->fetch_records("short_conference_registration_screen_two_details", " AND parentid = '". $row["screen_two_id"] ."' ");
				
				/*
				$registration_details 			.= "Participant Type:   " . $row['VIEW_region_name'];
				$registration_details 			.= "\nRegistration Type:   " .$TMP_EB_RG[ $row["earlybird_regular"] ];
				$registration_details 			.= "\nTravelling With:   " .$row["VIEW_package_name"] ;
				$registration_details 			.= "\nTotal Price:   " . $row['VIEW_total_price'];
				$registration_details 			.= "\n\n*******************\n";*/
				
				$registration_details 			.= "Package Details:";
				$registration_details 			.= "\n*******************\n";
			
			
				
				$screen_two_details_arr 		= $screen_two_details->result_array();
				$numrows 						= count($screen_two_details_arr);	
				$counter 						= 0;
				
				
				foreach($screen_two_details_arr as $trow) 
				{
					$conference_prices_details 		= $this->queries->fetch_records("short_conference_prices_details", " AND id = '". $trow["price_details_id"] ."' ");
                    if ($conference_prices_details->num_rows() > 0) 
					{
						$explode_price_details_value		= explode("::", $trow["price_details_value"]);
						
                    }
					
					
					$_text_as_addon							= '';
					if ( $conference_prices_details->row()->prices_parent_id > 0 )
					{
						$_text_as_addon						= ' - (Add-on)';
					}

					
					$registration_details .= "\n" . $conference_prices_details->row()->whoattend_nam . $_text_as_addon . "\n--------------------\n";
					$registration_details .= $conference_prices_details->row()->prices_title . "           " . $trow["multply_by_no_of_people"] . " x " . format_price( $explode_price_details_value[1], array("prefix" => $this->functions->getCurrencySymbol($row['region_show_rates_in_currency'] )) );
					$registration_details .= "\n\n";
					if ( $conference_prices_details->row()->prices_description != "" )
					{
						$registration_details .= str_replace("&bull;", "- ", htmlentities( $conference_prices_details->row()->prices_description ) );
						$registration_details .= "\n\n";
					}
					
					if(++$counter === $numrows)
					{
						#$registration_details .= "\n----------\n";
					}
					
				} 
				
			} 
			else 
			{ 
				$registration_details .= '--'; 
			} 
				


			
			
			$abc						= 		array( $TMP_spaces	 . $TMP_name,

												generate_participant_UID($row["id"]),
												
												 DropdownHelper::short_conferenceregistration_guestfamilyguest( $row['parentid'] ), 

												 $row["user_name"],
												 
												 $row['family_relationship'],
												 
												 $row['VIEW_conference_master_date_added'],
												 
												 $row['VIEW_email_screen_3'],
												 $row['VIEW_phone_screen_3'],
												 $row['VIEW_total_price'],

												 $row['VIEW_payment_type'],
												 $row['VIEW_is_paid_name'],
												 
												 $row['VIEW_region_name'],
												 $TMP_EB_RG[ $row["earlybird_regular"] ],
												 $row["VIEW_package_name"],
												 
												 $registration_details);
												 
												
			fputcsv($output, $abc);
		}
		
	}

	public function download_csv_12( $id )
	{ 
		$data												= $this->data;
		
		
		header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='. strtotime("now") .'.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		
		$TMP_heading					= array( 
												 'Full Name',
												//  'UID'	, 
												/*  'Registered As', 
												 'Registered For',
												 'Relation', */
												 'Payment Date',
												 'Email',  
												 'Phone',
												 'Price',
												 'Payment Type',
												//  'Payment Status',
												 
												//  'Participant Type',
												//  'Registration Type',
												//  'Travelling With',
												 
												 'Registration Details',
												 'Receipt Number');
		
		fputcsv($output, $TMP_heading);


		$three_records					= $this->queries->fetch_records("short_conference_registration_screen_three", 
																		" AND id in(". implode(",", $id) .") ORDER BY FIELD(id, ". implode(",", $id) .") "); 

		$three_records					= conferenceregistrations_cleanfilter( $three_records->result_array(), TRUE );
		
		#print_r($three_records);die;
		#$this->fetch_records_for_view( $id );
		$_show_Array					= array();
		
		foreach ($three_records as $row) 
		{
			
			$TMP_name					= $row["full_name"];
			$TMP_spaces					= "           ";

			if ( $row["parentid"] == 0)
			{
				$TMP_name				.= ' ('. $this->queries->fetch_records("short_conference_registration_screen_three", 
																 " AND parentid = '". $row["id"] ."' AND screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid)) ")->num_rows() . ')';
				$TMP_spaces				= "";

			}

			$registration_details = '';
				
			// Registration details
			if ($row["parentid"] == 0) 
			{ 
				
				$TMP_imi_or_nonimi 				= DropdownHelper::short_conferenceregistration_paymenttype();
				$TMP_EB_RG		   				= DropdownHelper::short_conferenceprice_earlybird_regular_dropdown(TRUE, FALSE );
				$screen_two_details 			= $this->queries->fetch_records("short_conference_registration_screen_two_details", " AND parentid = '". $row["screen_two_id"] ."' ");
				/*
				$registration_details 			.= "Participant Type:   " . $row['VIEW_region_name'];
				$registration_details 			.= "\nRegistration Type:   " .$TMP_EB_RG[ $row["earlybird_regular"] ];
				$registration_details 			.= "\nTravelling With:   " .$row["VIEW_package_name"] ;
				$registration_details 			.= "\nTotal Price:   " . $row['VIEW_total_price'];
				$registration_details 			.= "\n\n*******************\n";*/
				
				$registration_details 			.= "Package Details:";
				$registration_details 			.= "\n*******************\n";
			
			
				
				$screen_two_details_arr 		= $screen_two_details->result_array();
				$numrows 						= count($screen_two_details_arr);	
				$counter 						= 0;
				
				
				foreach($screen_two_details_arr as $trow) 
				{
					$conference_prices_details 		= $this->queries->fetch_records("short_conference_prices_details", " AND id = '". $trow["price_details_id"] ."' ");
                    if ($conference_prices_details->num_rows() > 0) 
					{
						$explode_price_details_value		= explode("::", $trow["price_details_value"]);
						
                    }
					
					
					$_text_as_addon							= '';
					if ( $conference_prices_details->row()->prices_parent_id > 0 )
					{
						$_text_as_addon						= ' - (Add-on)';
					}

					
					$registration_details .= "\n" . $conference_prices_details->row()->whoattend_nam . $_text_as_addon . "\n--------------------\n";
					$registration_details .= $conference_prices_details->row()->prices_title . "           " . $trow["multply_by_no_of_people"] . " x " . format_price( $explode_price_details_value[1], array("prefix" => $this->functions->getCurrencySymbol($row['region_show_rates_in_currency'] )) );
					$registration_details .= "\n\n";
					if ( $conference_prices_details->row()->prices_description != "" )
					{
						$registration_details .= str_replace("&bull;", "- ", htmlentities( $conference_prices_details->row()->prices_description ) );
						$registration_details .= "\n\n";
					}
					
					if(++$counter === $numrows)
					{
						#$registration_details .= "\n----------\n";
					}
					
				} 
				
			} 
			else 
			{ 
				$registration_details .= '--'; 
			} 

			$user_type = $this->db->query("SELECT * FROM tb_guest_users WHERE userid = '". $row['userid'] ."' ");
			$user = $user_type->num_rows() > 0 ? 'Guest User' : 'Logged In User';
			$date = empty($row['registration_date']) ? $row['date_added'] : $row['registration_date'];

			$conference						= $this->queries->fetch_records('short_conference', " AND slug = '". SessionHelper::_get_session("slug", "conference") ."' ");
		
			$conferenceregistration			= $this->queries->fetch_records('short_conference_registration_master', 
			" AND userid = '". $row['userid'] . "' 
			AND conferenceid = '". $conference -> row("id") ."' ");

			$receipt_number = 'SC'.$conferenceregistration->row()->tax_receipt_num;
			
			$abc						= 		array( $TMP_spaces	 . $TMP_name,

												/* generate_participant_UID($row["id"]), */
												/*  $user
												 ,  */

												 /* $row["user_name"],
												 
												 $row['family_relationship'], */
												 $date,

												 
												//  $row['VIEW_conference_master_date_added'],
												 
												 $row['VIEW_email_screen_3'],
												 $row['VIEW_phone_screen_3'],
												//  $row['VIEW_total_price'],
												isset($row['VIEW_total_paid']) && !empty($row['VIEW_total_paid']) ? '$'.$row['VIEW_total_paid'] : '',

												 $row['VIEW_payment_type'],
												//  $row['VIEW_is_paid_name'],
												 
												//  $row['VIEW_region_name'],
												//  $TMP_EB_RG[ $row["earlybird_regular"] ],
												//  $row["VIEW_package_name"],
												 
												 $registration_details,
												 $receipt_number);
												 
												
			fputcsv($output, $abc);
		}
		
	}
	
	public function __delete( $id )
	{
		$data												= $this->data;
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_short_conference_registration", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}

	public function bulk_short_conference_receipt_zip(){
		$data											= $this->data;

		$from_date 	= isset($_POST["bulk_receipt_from_date"])  && !empty($_POST["bulk_receipt_from_date"]) ? $_POST["bulk_receipt_from_date"] : '';
		$to_date  	= isset($_POST["bulk_receipt_to_date"])  && !empty($_POST["bulk_receipt_to_date"]) ? $_POST["bulk_receipt_to_date"] : '';
		
		if(isset($from_date) && isset($to_date)){
			$this->load->helper('file');
			$this->load->helper('directory');

			if(strtotime($from_date) == strtotime($to_date)){
				$where = "WHERE CAST(tb_short_conference_registration_master.date_added as Date) = '$from_date'";
			}else{
				$where = "WHERE tb_short_conference_registration_master.date_added BETWEEN '$from_date' AND '$to_date'";
			}

			$query = $this->db->query("SELECT tb_short_conference_registration_master.userid FROM tb_short_conference_registration_master RIGHT JOIN tb_payment_receipts On tb_payment_receipts.table_name = 'tb_short_conference_registration_master' AND tb_payment_receipts.table_id_value = tb_short_conference_registration_master.userid $where");


			//temp directory path of live and local
			$localhost = array('127.0.0.1', "::1");
			if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
				$path = $_SERVER['DOCUMENT_ROOT'].'/imamiamedicscom/assets/temp-tax-files/';
			} else {
				$path = $_SERVER['DOCUMENT_ROOT'].'/assets/temp-tax-files/';
			}

			// Delete all files before downloading
			$files = directory_map($path);
			foreach($files as $file)
			{ 
				if(is_file($path.$file)){
					unlink($path.$file);
				}
			}
			// For downloading a zip file
			if($query->num_rows() > 0){
				$result = $query->result();
				
				$this->load->library('zip');
				if(isset($result) && !empty($result)){
					
					foreach ($result as $key => $value) {
						$this->receipt($value->userid,  true);
					}
					
					$this->zip->read_dir($path, FALSE);
					
					foreach ($result as $key => $value) {
						
						$file_name = 'registration-receipt-' . $value->userid . '.pdf';
						$this->zip->archive($path.$file_name);	
					}
			
					$this->zip->download('bulk-receipt.zip');
				}else{
					$data['_messageBundle'] = $this->_messageBundle( 'danger' , "No Receipts Found", 'Error!', true);
				}
			}
			redirect( site_url( $this->data["_directory"] . "controls/view" ) );
		}
	}
}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */