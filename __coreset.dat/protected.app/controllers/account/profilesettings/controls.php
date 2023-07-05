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
		
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= lang_line('text_updateyourprofile');
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		$this->data["images_dir"]	 								= "./assets/frontend/images/";
		$this->data["images_types"]	 								= "gif|png|jpg";
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
		$this->_create_fields_for_form_2(false, $this->data);	
		
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
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
	
	
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		
		
		

		#standard validation
		$this->functions->unite_post_values_form_validation();
		
		
		
		$this->form_validation->set_rules('first_name', lang_line('text_firstname'), 'trim|required');
		$this->form_validation->set_rules('last_name', lang_line('text_lastname'), 'trim|required');
		
		
		$this->form_validation->set_rules('cellphone_number', lang_line('text_cellphoneno'), 'trim|required');
		$this->form_validation->set_rules('secondary_email_1', lang_line('text_secondaryemail1'), 'trim|email');
		$this->form_validation->set_rules('secondary_email_2', lang_line('text_secondaryemail2'), 'trim|email');
		$this->form_validation->set_rules('home_full_address', lang_line('text_homefulladdress'), 'trim');
		$this->form_validation->set_rules('home_country', lang_line('text_homecountry'), 'trim');
		$this->form_validation->set_rules('home_state_province', lang_line('text_homestateprovince'), 'trim');
		$this->form_validation->set_rules('home_city', lang_line('text_homecity'), 'trim');
		$this->form_validation->set_rules('home_phone_number', lang_line('text_homephoneno'), 'trim');
		$this->form_validation->set_rules('office_full_address', lang_line('text_officefulladdress'), 'trim');
		$this->form_validation->set_rules('office_country', lang_line('text_officecountry'), 'trim');
		$this->form_validation->set_rules('office_state_province', lang_line('text_officestateprovince'), 'trim');
		$this->form_validation->set_rules('office_city', lang_line('text_officecity'), 'trim');
		$this->form_validation->set_rules('office_phone_number', lang_line('text_office_phone'), 'trim');
		
		$this->form_validation->set_rules('home_zipcode', lang_line('text_homezippostalcode'), 'trim');
		$this->form_validation->set_rules('office_zip_code', lang_line('text_officezippostalcode'), 'trim');

		$this->form_validation->set_rules('occupation', lang_line('label_arbaeen_form_occupation'), 'trim');
		$this->form_validation->set_rules('specialties', lang_line('label_arbaeen_form_speciality'), 'trim');
		
		
		$this->form_validation->set_rules('prefered_mode_address', lang_line('text_prefferedaddress'), 'trim');
		$this->form_validation->set_rules('preffered_mode_of_contact', lang_line('text_prefferedphone'), 'trim');
		$this->form_validation->set_rules('preffered_mode_of_email', lang_line('text_prefferedemail'), 'trim');
		
		if ( $this->input->post("existing_password") != "" )
		{
			$this->form_validation->set_rules('existing_password', lang_line('text_existingpassword'), 'trim|callback_validate_confirm_password');
			$this->form_validation->set_rules('new_password', lang_line('text_newpassword'), 'trim|required|xss_clean');		
		}
		else if ( $this->input->post("new_password") != "" and $this->input->post("existing_password") == "" )
		{
			$this->form_validation->set_rules('existing_password', lang_line('text_existingpassword'), 'trim|required|callback_validate_confirm_password');
			$this->form_validation->set_rules('new_password', lang_line('text_newpassword'), 'trim|required|xss_clean');
		}
		
		
		
		
		
		/*
		$tmp_validate_DB				= $this->imiconf_queries->fetch_records_imiconf("users", " AND email = '". $this->input->post("email") ."' ");
		$tmp_validate_VALUES			= $this->find_duplicate_values($tmp_validate_DB, $this->input->post("id"));
		$this->form_validation->set_rules('email', 'Email', "trim|required|valid_email|callback_validate_duplicate[". $tmp_validate_VALUES ."]"); //
		
		
		
		$this->form_validation->set_rules("txt_password", "Password", "trim|required|callback_validate_user_confirm_password[imiconf]|xss_clean");
        $this->form_validation->set_rules("txt_newpassword", "New password", "trim|required|min_length[8]|xss_clean");
        $this->form_validation->set_rules("txt_cnewpassword", "Confirm password", "trim|required|matches[txt_newpassword]|xss_clean");
		*/

					
		if( $this->form_validation->run() == FALSE )
		{
			

			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		}
		else
		{
		
			$insertData					= array("id"					=> $this->functions->_user_logged_in_details( "id" ),
												"prefix_title"			=> $this->input->post("prefix_title"),
												"name"					=> $this->input->post("name"),
												"last_name"				=> $this->input->post("last_name"),
												#"email"					=> $this->input->post("email"),
												"password"				=> $this->encrption->encrypt( $this->input->post("txt_newpassword") ));
											
											
													
			
			
			$this->queries->SaveDeleteTables_imiconf($insertData, 'e', "tb_users", 'id'); 
			
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("text_credentialsupdated"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( site_url("logout") ) ;	

		
		}
		
	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "prefix_title", "first_name", "middle_name",  "last_name", "primary_email", "options", "unique_formid" );
		
		
		
		$filled_inputs				= array( "id", "prefix_title", "name", "middle_name", "last_name", "email", "options", "unique_formid" );
		
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
	
	public function _create_fields_for_form_2( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("profile_image","cellphone_number", "secondary_email_1", "secondary_email_2", 
											
											"home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", 
											
											"web_address", "current_imi_title", "institute_school", "gender", "previous_title_with_imi",
											
											"office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", 
											
											"occupation", "specialties", "preffered_mode_of_contact", "prefered_mode_address", "preffered_mode_of_email", "home_zipcode",  "office_zip_code"/*, "other_member_can_see_profile"*/);
		
		
		
		$filled_inputs				= array("profile_image","cellphone_number", "secondary_email_1", "secondary_email_2", 
											
											"home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", 
											
											"web_address", "current_imi_title", "institute_school", "gender", "previous_title_with_imi",
											
											"office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", 
											
											"occupation", "specialties", "preffered_mode_of_contact", "prefered_mode_address", "preffered_mode_of_email", "home_zipcode",  "office_zip_code"/*, "other_member_can_see_profile"*/ );
		
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
	
	
	
	public function _create_array_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array( "bh_name", "bh_descr", "bh_announce" );
		$filled_inputs				= array( "bh_name", "bh_descr", "bh_announce" );
		$languages					= $data["languages"];

		
		
		if ($return_array == true and count($db_data) > 0 )
		{
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			
			#loop with the parent object... for e.g. Types of Promo Codes
			foreach ($loop_object as $main)
			{
				
				$language_id				= $main["id"];
				
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					#second - if value found it will overwrite above array.
					foreach ( $db_data as $loop )
					{
						if ( $loop["languageid"] == $language_id )
						{
							$detail_array[ $main["id"] ] [ $empty_inputs[$x] ]			= $loop[ $filled_inputs[$x] ];	
						}
						
					}
				}
			}			
			
			ksort( $detail_array );
		
			$data["_detail_array"]	= $detail_array;
			
			
			return $data;
		}
		else
		{
			
			

			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			$data["_detail_array"]	= $detail_array;
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{		
		
		$data														= $this->data;
		
		
		if ( !$this->_auth_user_id($edit_id) )
		{ 
			redirect ( site_url( $data["_directory"] . "controls/edit/" . $this->functions->_user_logged_in_details( "id" ) ) );
		}
		
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->imiconf_queries->fetch_records_imiconf("users", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		
		
		
		$data['_messageBundle']										= $this->_messageBundle( 'info' , "You will be logout if you enter new password.", 'Please note: ');

		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		$users_profile												= $this->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = '$edit_id' ");
		if ( $users_profile -> num_rows() > 0 )
		{
			$this->_create_fields_for_form_2(true, $data, $users_profile->row_array() );		
		}
		
		
		
		
		
		#standard validation
		$this->functions->unite_post_values_form_validation();
		
	
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		
		
		$this->form_validation->set_rules('cellphone_number', 'Cellphone Number', 'trim');
		$this->form_validation->set_rules('secondary_email_1', 'Secondary Email 01', 'trim|valid_email');
		$this->form_validation->set_rules('secondary_email_2', 'Secondary Email 02', 'trim|valid_email');
		
		
		$this->form_validation->set_rules('previous_title_with_imi', 'Previous Title With IMI', 'trim');
		$this->form_validation->set_rules('current_imi_title', 'Current IMI Title', 'trim');
		$this->form_validation->set_rules('institute_school', 'Institute School', 'trim');
		$this->form_validation->set_rules('gender', 'Gender', 'trim');
		$this->form_validation->set_rules('web_address', 'Web Address', 'trim');
		
		
		
		
		$this->form_validation->set_rules('home_full_address', 'Home Full Address', 'trim');
		$this->form_validation->set_rules('home_country', 'Home Country', 'trim');
		$this->form_validation->set_rules('home_state_province', 'Home State Province', 'trim');
		$this->form_validation->set_rules('home_city', 'Home City', 'trim');
		$this->form_validation->set_rules('home_phone_number', 'Home Phone Number', 'trim');
		$this->form_validation->set_rules('office_full_address', 'Office Full Address', 'trim');
		$this->form_validation->set_rules('office_country', 'Office Country', 'trim');
		$this->form_validation->set_rules('office_state_province', 'Office State Province', 'trim');
		$this->form_validation->set_rules('office_city', 'Office City', 'trim');
		$this->form_validation->set_rules('office_phone_number', 'Office Phone Number', 'trim');
		
		$this->form_validation->set_rules('home_zipcode', 'Home Zip/Postal Code', 'trim');
		$this->form_validation->set_rules('office_zip_code', 'Office Zip/Postal Code', 'trim');

		$this->form_validation->set_rules('occupation', 'Occupation', 'trim');
		$this->form_validation->set_rules('specialties', 'Specialties', 'trim');
		
		
		
		$this->form_validation->set_rules('preffered_mode_of_contact', 'Preffered Mode of Contact', 'trim|required');
		
		
		if 	( ($this->input->post("existing_password") != "" and $this->input->post("new_password") == "" ) || ($this->input->post("existing_password") == "" and $this->input->post("new_password") != "" ) )
		{
			$this->form_validation->set_rules("existing_password", "Existing Password", "trim|required|xss_clean");
			$this->form_validation->set_rules("new_password", "New Password", "trim|required|xss_clean");
		}
		else if ( $this->input->post("existing_password") == "" and $this->input->post("new_password") == "" )
		{
			
		}
		else
		{
			$this->form_validation->set_rules("existing_password", "Existing Password", "trim|required|callback_validate_user_confirm_password[imiconf,Existing Password not matched]");
			$this->form_validation->set_rules("new_password", "New password", "trim|required|min_length[8]|alpha_numeric|password_check[1,1,1]|xss_clean");
		}
		

					
		if( $this->form_validation->run() == FALSE )
		{
			

			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		}
		else
		{
            // if (isset($_FILES['profile_image']) && $_FILES['profile_image']['tmp_name'] != "") {
            
            //     #################################
            //     ###  	upload_image_1  	  ###
            //     #################################
            //     $other_upload						= array("validate"											=> true,
            //                                                 "input_field"										=> "profile_image",
            //                                                 "db_field"											=> "profile_image",
            //                                                 "input_nick"										=> "Image",
            //                                                 "hdn_field"											=> "profile_image",
            //                                                 "tmp_table_field"									=> "profile_image",
            //                                                 "is_multiple"										=> false
            //                                             );
                    
            //     $config_image						= array(
            //                                                 "upload_path"										=> $this->data["images_dir"],
            //                                                 "allowed_types"										=> $this->data['images_types'],
            //                                                 "max_size"											=> '5096', //5MB
            //                                                 "encrypt_name"										=> true
            //                                             );
                
            //     $config_thumb						= array();
                
                    
            //     $tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);

            //     if ($tmp_upload_image_1['reason'] != "pass") {
            //         $data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
            //         $data['_messageBundle']								= $this->_messageBundle('danger', $tmp_upload_image_1['msg'], 'Error!');
			// 		$this->load->view(FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data);
			// 		return;
            //     }
			// }
			
			$user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id = " . $this->functions->_user_logged_in_details("id"));
			
            $insertData					= array("id"					=> $this->functions->_user_logged_in_details("id"),
                                                "prefix_title"			=> $this->input->post("prefix_title"),
                                                "name"					=> $this->input->post("first_name"),
                                                "middle_name"			=> $this->input->post("middle_name"),
                                                "last_name"				=> $this->input->post("last_name"));
                                            
                                            
                                                    
            
            if ($this->input->post("new_password") != "") {
                $insertData["password"]				= $this->encrption->encrypt($this->input->post("new_password"));
            }
            
            $this->queries->SaveDeleteTables_imiconf($insertData, 'e', "tb_users", 'id');

            $other_member_can_see_profile = $users_profile->result();
            $other_member_can_see_profile = $other_member_can_see_profile[0]->other_member_can_see_profile;
            
			$user_profile_Data			= array("userid"							=> $this->functions->_user_logged_in_details("id"),
                                                "cellphone_number"					=> $this->input->post("cellphone_number"),
                                                "secondary_email_1"					=> $this->input->post("secondary_email_1"),
                                                "secondary_email_2"					=> $this->input->post("secondary_email_2"),
                                                
                                                "home_full_address"					=> $this->input->post("home_full_address"),
                                                "home_country"						=> $this->input->post("home_country"),
                                                "home_state_province"				=> $this->input->post("home_state_province"),
                                                "home_city"							=> $this->input->post("home_city"),
                                                "home_phone_number"					=> $this->input->post("home_phone_number"),
                                                
                                                
                                                
                                                
                                                "office_full_address"				=> $this->input->post("office_full_address"),
                                                "office_country"					=> $this->input->post("office_country"),
                                                "office_state_province"				=> $this->input->post("office_state_province"),
                                                "office_city"						=> $this->input->post("office_city"),
                                                "office_phone_number"				=> $this->input->post("office_phone_number"),
                                                
                                                "home_zipcode"						=> $this->input->post("home_zipcode"),
												"office_zip_code"					=> $this->input->post("office_zip_code"),

                                                "occupation"						=> $this->input->post("occupation"),
                                                "specialties"						=> $this->input->post("specialties"),
                                                
                                                "prefered_mode_address"				=> $this->input->post("prefered_mode_address"),
                                                "preffered_mode_of_contact"			=> $this->input->post("preffered_mode_of_contact"),
                                                "preffered_mode_of_email"			=> $this->input->post("preffered_mode_of_email"),
                                                
                                                
                                                
                                                "previous_title_with_imi"			=> $this->input->post("previous_title_with_imi"),
                                                "current_imi_title"					=> $this->input->post("current_imi_title"),
                                                "institute_school"					=> $this->input->post("institute_school"),
                                                "gender"							=> $this->input->post("gender"),
                                                "web_address"						=> $this->input->post("web_address"),
                                                
                                                
                                                
                                                "other_member_can_see_profile"		=> $other_member_can_see_profile,
                                                "date_added"						=> date("Y-m-d"));

			// if (isset($tmp_upload_image_1['hdn_array']['profile_image'])) {
			//     $user_profile_Data['profile_image'] =  $this->data['images_dir'].$tmp_upload_image_1['hdn_array']['profile_image'];
			// }

			$user_profile = $this->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = " . $this->functions->_user_logged_in_details("id"));
			
			if ($user_profile->num_rows() > 0) {
				$result = $user_profile->result()[0];
				$user_result = $user->result()[0];
				$user_profile_Data_Previuos			= array(
					"userid"							=> $this->functions->_user_logged_in_details("id"),
					"cellphone_number"					=> $result->cellphone_number,
					"secondary_email_1"					=> $result->secondary_email_1,
					"secondary_email_2"					=> $result->secondary_email_2,

					"home_full_address"					=> $result->home_full_address,
					"home_country"						=> $result->home_country,
					"home_state_province"				=> $result->home_state_province,
					"home_city"							=> $result->home_city,
					"home_phone_number"					=> $result->home_phone_number,




					"office_full_address"				=> $result->office_full_address,
					"office_country"					=> $result->office_country,
					"office_state_province"				=> $result->office_state_province,
					"office_city"						=> $result->office_city,
					"office_phone_number"				=> $result->office_phone_number,

					"home_zipcode"						=> $result->home_zipcode,
					"office_zip_code"					=> $result->office_zip_code,
					
					"occupation"						=> $result->occupation,
					"specialties"						=> $result->specialties,

					"prefered_mode_address"				=> $result->prefered_mode_address,
					"preffered_mode_of_contact"			=> $result->preffered_mode_of_contact,
					"preffered_mode_of_email"			=> $result->preffered_mode_of_email,



					"previous_title_with_imi"			=> $result->previous_title_with_imi,
					"current_imi_title"					=> $result->current_imi_title,
					"institute_school"					=> $result->institute_school,
					"gender"							=> $result->gender,
					"web_address"						=> $result->web_address,



					"other_member_can_see_profile"		=> $other_member_can_see_profile,
					"date_added"						=> date("Y-m-d"),
					"prefix_title"						=> $user_result->prefix_title,
					"name"								=> $user_result->name,
					"middle_name"						=> $user_result->middle_name,
					"last_name"							=> $user_result->last_name,
					"password"							=> $this->encrption->decrypt($user_result->password)
				);

				$this->queries->SaveDeleteTables_imiconf($user_profile_Data, 'e', "tb_users_profile", 'userid');

				$user_profile_Data['prefix_title'] = $this->input->post ("prefix_title");
				$user_profile_Data['name'] = $this->input->post ("first_name");
				$user_profile_Data['middle_name'] = $this->input->post ("middle_name");
				$user_profile_Data['last_name'] = $this->input->post ("last_name");
				$user_profile_Data['password'] = $this->input->post("new_password");

				$differences = array_keys(array_diff($user_profile_Data, $user_profile_Data_Previuos));

				$user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id = " . $this->functions->_user_logged_in_details("id"));

				/**MAIL TO ADMIN */
				$heading = 'Profile Updated by User';

				$email_template = array(
					"email_heading" => $heading,
					"email_file" => "email/frontend/profile_update.php",
					"email_subject" => $heading,
					"default_subject" => true,
					"email_cc" => "romeenaIMI@gmail.com,sakinarizviimi@gmail.com,rida.fatima@genetechsolutions.com",
					"email_post" => array('user' => $user->result()[0],'differences' => $differences, 'data' => $user_profile_Data, 'data_old' => $user_profile_Data_Previuos)
				);

				$is_email_sent = $this->_send_email($email_template);

				/**MAIL TO ADMIN */

			} else {
				$this->queries->SaveDeleteTables_imiconf($user_profile_Data, 's', "tb_users_profile", 'id');
			}
            
            if ($this->input->post("new_password") != "") {
                $data['_messageBundle']									= $this->_messageBundle(
                    'success',
                                                                                                lang_line("text_credentialsupdated"),
                                                                                                lang_line("heading_operation_success"),
                                                                                                false,
                                                                                                true
                );
                
                redirect(site_url("logout")) ;
            } else {
                $data['_messageBundle']									= $this->_messageBundle(
                    'success',
                                                                                                "Your profile settings updated.",
                                                                                                lang_line("heading_operation_success"),
                                                                                                false,
                                                                                                true
                );
                
                redirect(site_url($data["_directory"] . "controls/edit/" . $this->functions->_user_logged_in_details("id")));
            }
        }
	}
	
	
	
	public function search( $is_ajax = 0 )
	{
		$data														= $this->data;
		
		if ( $is_ajax )
		{
			$TMP_where												= FALSE;
			if ( $this->input->post("search_name") != "" )
			{
				$TMP_where			.= " AND name like '%". $this->input->post("search_name") ."%' ";
			}
			if ( $this->input->post("search_occupation") != "" )
			{
				$TMP_where			.= " AND (SELECT occupation FROM tb_conference_registration_screen_three where conferenceregistrationid = tb_conference_registration_screen_one.conferenceregistrationid AND parentid = 0 AND  screen_one_detail_id  = 0 ) = '". $this->input->post("search_occupation") ."' ";
			}
			if ( $this->input->post("search_location") != "" )
			{
				$TMP_where			.= " AND (SELECT regionid FROM tb_conference_registration_master WHERE id = tb_conference_registration_screen_one.conferenceregistrationid) = '". $this->input->post("search_location") ."'";
			}
			if ( $this->input->post("search_name") != "" )
			{
				$TMP_where			.= " AND name like '%". $this->input->post("search_name") ."%' ";
			}
			
			
			
			$tmp_columns[]			= array('db'        	=> 'id',
											"where"			=> "id > 0 AND name", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
											'dt'			=> 0 ,
										    'formatter' 	=>  function( $d, $row, $CI ) 
											 					{
																	$finded_users		= $CI->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", 
																																	  " AND id = '". $row['id'] ."' ");	
																	return $CI->load->view("frontend/account/browseimimembers/search.php", array("fu" => $finded_users->row_array()), TRUE);
																}
											);


			$columns						= SSP::append_columns( $tmp_columns, array(), array(0,1) );
			$primaryKey 					= 'id';
			$table 							= ' tb_conference_registration_screen_one WHERE 1=1  AND conferenceregistrationid IN ( SELECT conferenceregistrationid FROM `tb_conference_registration_screen_two` WHERE ( be_a_member = 1 || coupon_code = "IMIMEMBER2015%" )  ) ' . $TMP_where; 
			
		
			echo json_encode( SSP::simple( $_POST, $table, $primaryKey, $columns, array(), $this->db_imiconf ) );
		}
		
	}
	
	public function browse()
	{		
		
		$data														= $this->data;
		
			
		#occupations dropdown
		$occupations_list											= $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_three", 
																													" AND parentid = 0 AND  screen_one_detail_id  = 0 " , 
																													" DISTINCT(occupation) occupation ");
		
		$tmp_olist[]												= array("id"				=> "",
																			"occupation"		=> "-Select-");
		foreach ( $occupations_list->result_array() as $ll )
		{
			$tmp_olist[]											= array("id"				=> $ll['occupation'],
																			"occupation"		=> $ll['occupation']);
		}
		
		array_multisort($tmp_olist, SORT_ASC);		
		$data['occupations_dropdown']								= $tmp_olist;
		#occupations dropdown
		
		
		
		
		
		
		#location dropdown
		$locations_list												= $this->imiconf_queries->fetch_records_imiconf("conference_regions", 
																													"" , " id, name");
		$tmp_llist													= $locations_list->result_array();
		$tmp_llist[]												= array("id"			=> "",
																			"name"			=> "-Select-");
		
		array_multisort($tmp_llist, SORT_ASC);
		$data['locations_dropdown']									= $tmp_llist;
		#location dropdown
		
	
		
	
	
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "browse.php";
		
		
		
		$TMP_where													= FALSE;
		$data['finded_users']										= FALSE;
		if ( $this->validations->is_post() )
		{
			$this->functions->unite_post_values_form_validation();
			$this->form_validation->run();
			
			if ( $this->input->post("name") != "" )
			{
				$TMP_where											.= " AND name like '%". $this->input->post("name") ."%' ";
			}
			
			
			$data['finded_users']									= $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", $TMP_where);		
			
		}
		
		
		
		
		
		
		/*$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "browse";
		$edit_details['unique_formid']								= "";
		
		
		$this->_create_fields_for_form(true, $data, $edit_details );	*/
		#$this->_create_array_fields_for_form(true, $data, $data['languages'], $child_data->result_array() );	
		
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
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
		#remove images
		foreach ($id	as $key	=> $result)
		{
			$row											= $this->queries->fetch_records("beaches_and_hotels", " AND id = '$result' ")->row();
			$this->remove_file($row->bh_image2);
			$this->remove_file($row->bh_image);
			$this->remove_file($row->bh_map);
		}
		
		
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['station_id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_beaches_and_hotels_detail", 'station_id') ;
		}
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_beaches_and_hotels", 'id') ;
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