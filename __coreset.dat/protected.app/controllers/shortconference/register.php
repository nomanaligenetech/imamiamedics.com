<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends C_frontend {

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
		
		$this->_auth_login( FALSE );
		
		
		$this->data													= $this->default_data();
		
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/conference_registration/";
		
		
	}
	
	
	public function success(  $conference_slug = ''  )
	{
		$data									= $this->data;
		$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																'Your payment is done for conference registration', 
																'Thank you');
		
	
		$data['h1']					= '';
		$data['_pageview']			= "global/_blank_page.php";
		$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
	}
	
	
	
	public function payment( $conference_slug = '', $register_id = '' )
	{ 
	
		$data								= $this->data;
		$data['_pagetitle']					= lang_line('text_conferencepayment');
		$data['h1']							= '';
		$data['register_id']				= $register_id;
		$data['is_paid']					= TRUE;
		
		
		$data['conference']					= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");

		if ( $data['conference'] -> num_rows() <= 0 )
		{
			
			page_error( $data );
			return false;
		}
		
		
		
		
		$conference_registration			= $this->queries->fetch_records('short_conference_registration', 
																			" AND id = '". $register_id ."' AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																			  AND conferenceid = '". $data['conference']->row("id") ."' AND parentid = '0'  LIMIT 1 ");
		
		
		
		
		
		
		if ( $conference_registration -> num_rows() > 0 )
		{
			
			$data['total_amount']					= total_payment( $conference_registration );
			
			
			$TMP_total_family_registrations			= $conference_registration->row("no_of_family_members_accompanied");
				
			$TMP_family_registered_no				= $this->queries->fetch_records('conference_registration', 
																						" AND parentid = '". $register_id ."' ")->num_rows();
				
			
			
			
			switch ( TRUE )
			{
				//commented for conference 12
				// case !SessionHelper::_get_session("PAYMENT_TOGGLE_CR", "site_settings"):
				// 	$message_class				= 'danger_big';
				// 	$message_heading			= "Payment Form Unavailable";
				// 	$message_text				= 'Please contact administrator';
				// 	break;
					
					
					
				case $conference_registration->row("accompanied_by_family") == '1' and  $TMP_family_registered_no < $TMP_total_family_registrations:
					$message_class				= 'danger_big';
					$message_heading			= "Registration Incomplete";
					$message_text				= 'Your family registration form is incomplete.  
													<a href="'. site_url( 'conference/' . $data['conference']->row("slug")  . '/register/'. $conference_registration->row("id") ) .'">click here</a> 
													to redirect on <strong>Family Registration</strong> page';
					break;
					
					
					
				case !$conference_registration -> row( "is_paid" ):
					$message_class				= 'warning_big';
					$message_heading			= "Please Wait..";
					$message_text				= 'Total amount to be charged: <strong>' . format_price( $data['total_amount'] ) . '</strong><br /><br /> 
													You are being redirect to Payment Page';
					$data['is_paid']			= FALSE;
					break;
					
					
					
				default:
					$message_class				= 'success_big';
					$message_heading			= "Payment done";
					$message_text				= 'You already paid for this Registration.';
					break;
					
					
					
				
			}

			
			$data['_messageBundle2']				= $this->_messageBundle( $message_class, $message_text, $message_heading);
			
			
			
			
			$data['_pageview']						= "frontend/conference/payment.php";
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
		}
		else
		{
			page_error( $data );
			return false;
		}
		
		
		
	}
	
	
	public function payment_new( $conference_slug = '', $register_id = '' )
	{ 
	
		$data								= $this->data;
		$data['_pagetitle']					= lang_line('text_conferencepayment');
		$data['h1']							= '';
		$data['register_id']				= $register_id;
		$data['is_paid']					= TRUE;
		
		
		$data['conference']					= $this->queries->fetch_records('conference', " AND slug = '". $conference_slug ."' ");

		if ( $data['conference'] -> num_rows() <= 0 )
		{
			
			page_error( $data );
			return false;
		}
		
		
		
		
		$conference_registration			= $this->queries->fetch_records('conference_registration_master', 
																			" AND id = '". $register_id ."' AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																			  AND conferenceid = '". $data['conference']->row("id") ."'  LIMIT 1 ");
		
		
		
		
		
		
		if ( $conference_registration -> num_rows() > 0 )
		{
			$amt	= $this->queries->fetch_records('conference_registration_screen_two', " AND  conferenceregistrationid  = '". $conference_registration->row("id") ."' LIMIT 1 ");
			
			
			$data['total_amount']					= $amt->row("price_total_payable");#total_payment( $conference_registration );
			
			
			
			$message_class				= 'warning_big';
			$message_heading			= "Please Wait..";
			$message_text				= 'Total amount to be charged: <strong>' . format_price( $data['total_amount'] ) . '</strong><br /><br /> 
											You are being redirect to Payment Page';
			$data['is_paid']			= FALSE;

			
			$data['_messageBundle2']				= $this->_messageBundle( $message_class, $message_text, $message_heading);
			
			
			
			
			$data['_pageview']						= "frontend/conference/payment.php";
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
		}
		else
		{
			page_error( $data );
			return false;
		}
		
		
		
	}
	

	
	public function index( $conference_slug = '', $register_id = 0 )
	{ 

	
		$data									= $this->data;
		
		
		
		$data['conference']					= $this->queries->fetch_records('conference', " AND slug = '". $conference_slug ."' ");
		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		
		
		$TMP_sent_email								= FALSE;
		$data['family_registered_no']				= 0;
		$TMP_total_family_registrations				= 0;
		$conference_registration					= $this->queries->fetch_records('conference_registration', 
																			" AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																			  AND conferenceid = '". $data['conference']->row("id") ."' AND parentid = '0'  LIMIT 1 ");
		
		
		
		
				
		if ( $conference_registration->num_rows() > 0 )
		{
			#avoid hack - illegal use of url
			if ( $conference_registration->row("id") != $register_id  and $register_id != 0)
			{
				page_error( $data );
				return false;	
			}
		}
		
		#if user type unknown id in url - than redirect it to proper url
		else if ( $conference_registration->num_rows() <= 0 and $register_id != 0 )
		{
			redirect( "conference/" . $data['conference']->row("slug") . "/register" );
		}
				
		
		
		if ( $conference_registration -> num_rows() > 0 )
		{
			#register_id = PARENTID (first registration form id)
			if ( $register_id == 0 )
			{
				$register_id							= $conference_registration->row("id");
			}
	
		
			$TMP_total_family_registrations				= $conference_registration->row("no_of_family_members_accompanied");
				
			$TMP_family_registered_no					= $this->queries->fetch_records('conference_registration', 
																						" AND parentid = '". $register_id ."' ")->num_rows();
				
			if ( $conference_registration->row("accompanied_by_family") == '1'	and  $TMP_family_registered_no < $TMP_total_family_registrations   )
			{
				
				
				$data['family_registered_no']			= $TMP_family_registered_no +1;
					
				
				
				if ( $data['family_registered_no'] == $TMP_total_family_registrations)
				{
					$TMP_sent_email						= TRUE;	
				}
			}
			else
			{
				
				
				switch ( TRUE )
				{
					case  !$conference_registration->row("is_paid") :
						$message_class				= 'danger_big';
						$message_heading			= "Payment Required";
						$message_text				= 'Your registration is complete without payment. 
														Please <a href="'. site_url( 'conference/' . $data['conference']->row("slug")  . '/register/payment/'. $conference_registration->row("id") ) .'">click here</a> 
														to redirect on <strong>Payment Page</strong>';
						break;
						

						
						
					default:
						$message_class				= 'success_big';
						$message_heading			= "Registration Complete";
						$message_text				= 'Your registration is complete with <strong>payment</strong> for this conference';
						break;
					
				}
	
				
				$data['_messageBundle']					= $this->_messageBundle( $message_class, $message_text, $message_heading);
				$data['h1']								= '';
				$data['_pageview']						= "global/_blank_page.php";		
				$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );	
				return false;	
			}
	
		}
		
		
		
		
		
		
		
		
		$data['total_family_registrations']		= $TMP_total_family_registrations;
		$data['conference_registration']		= $conference_registration;
			
			
		$data['register_id']					= $register_id;
		#$data['visitor_types']					= $this->queries->fetch_records('visitor_types', " ORDER BY sort DESC ");
		#$data['conference_topics']				= $this->queries->fetch_records('conference_topics', " ORDER BY sort DESC ");
		
		
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
		}
		else
		{
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
		
		
		
		$data['_pageview']						= "frontend/conference/register.php";
		
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			
			#$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
		}
		else
		{
			
			
			$saveData										= array("userid"								=> $this->functions->_user_logged_in_details( "id" ),
																	"conferenceid"							=> $data['conference']->row("id"),
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
																	"accompanied_by_family"					=> $this->input->post("accompanied_by_family"),
																	"no_of_family_members_accompanied"		=> $this->input->post("no_of_family_members_accompanied"),
																	"will_attend_conference"				=> $this->input->post("will_attend_conference"),
																	
																	"email"									=> $this->input->post("email"),
																	"mobile"								=> $this->input->post("mobile"),
																	"mailing_address"						=> $this->input->post("mailing_address"),
																	
																	
																	"parentid"								=> $register_id,
																	

																	
																	"date_added"							=> date("Y-m-d H:i:s"),
																	'status'								=> '0',
																	'is_paid'								=> '0' ); //status =1  (in review)
			
			
		
			$this->queries->SaveDeleteTables($saveData, 's', "tb_conference_registration", 'id'); 
			$saveData['id']									= $this->db->insert_id();
			
			
			
			
			
			
			
			if ( ( $TMP_sent_email ) || ( $this->input->post("accompanied_by_family") == 0 and $register_id == 0 ) )
			{
			
				#to_admin
				$_POST['conference_details']	= $data['conference'];
				$email_template					= array("email_heading"			=> lang_line("text_conferenceregistration"),
														"email_file"			=> "email/frontend/conference_registration_admin.php",
														"email_subject"			=> lang_line("text_conferenceregistration"),
														"default_subject"		=> TRUE,
														"email_post"			=> $_POST );
					
				$is_email_sent					= $this->_send_email( $email_template );
				#to_admin
				
				
				
				
				#to_admin
				$_POST['conference_details']	= $data['conference'];
				$email_template					= array("email_to"				=> $this->input->post("email"),
														"email_heading"			=> lang_line("text_conferenceregistration"),
														"email_file"			=> "email/frontend/conference_registration_user.php",
														"email_subject"			=> lang_line("text_conferenceregistration"),
														"default_subject"		=> TRUE,
														"email_post"			=> $_POST );
				
				$is_email_sent					= $this->_send_email( $email_template );
				#to_admin
				
			}
			
			
			
			
			if ($register_id == 0 )
			{
				$register_id			= $saveData['id'];
			}

			
			redirect( "conference/" . $conference_slug . "/register/" . $register_id );
			
			#redirect( "conference/" . $conference_slug . "/register/payment/" . $saveData['id'] );
			
			
		}
		
		
		
		
	}
	
}