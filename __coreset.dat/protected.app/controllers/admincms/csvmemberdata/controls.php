<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once __DIR__ . '/shared.php';

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
		
		
		$this->data["_heading"]										= "CSV Member Data";
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "*";
		$this->data["images_dir_memberdata"]	 					= SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/csv_uploads/memberdata/";
		$this->data["images_dir_eventssummary"]						= SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/csv_uploads/eventssummary/";
		$this->data["images_dir_documents"]							= SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/csv_uploads/documents/";
		$this->data["images_dir_income"]							= SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/csv_uploads/income/";
		
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
		$this->load->library("Encrption");
		

		
		if ( $this->db_imiconf->query("SHOW COLUMNS FROM `tb_conference_registration_excel` LIKE 'prefered_name'")->num_rows() == 0 )
		{
			die("abc");
			$this->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel` ADD `prefered_name` VARCHAR(255) NOT NULL AFTER `comments`, ADD `gender` VARCHAR(20) NOT NULL AFTER `prefered_name`, ADD `previous_title_with_imi` VARCHAR(255) NOT NULL AFTER `gender`;");
		}
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array(lang_line("text_username") );
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		
		redirect( site_url( $data["_directory"] . "controls/add" ) ) ;
		
	}


	/*
	public function DUMP_user_data_in_table_CONF( $__email, $__prefix_title, $__name, $__last_name )
	{
		$TMP_email						= $this->imiconf_queries->fetch_records_imiconf("users", " AND email = '". $__email ."' ");
		if ( $TMP_email -> num_rows() > 0 )
		{						
			$user_id								= $TMP_email->row()->id;
			
			$updateData								= array("id"						=> $user_id,
															"prefix_title"				=> $__prefix_title, #$row_data[1],
															"name"						=> $__name, #$name,
															"last_name"					=> $__last_name #$USER_LAST_NAME,
															);
													
													
			
			$this->queries->SaveDeleteTables_imiconf($updateData, 'e', "tb_users", 'id'); 	
		}
		else
		{						
			$password					= random_string('alnum', 16);
			$tmp_sd						= array("prefix_title"				=> $__prefix_title,
												"name"						=> $__name,
												"last_name"					=> $__last_name,
												"email"						=> $__email,
												"password"					=> $this->encrption->encrypt( $password ),
												"registration_site"			=> "IMIConferenceWebPortal_CSV",
												"is_active"					=> 1,
												"date_added"				=> date("Y-m-d") );
			
			

			$this->imiconf_queries->SaveDeleteTables_imiconf($tmp_sd, 's', "tb_users", 'id');  
			$user_id					= $this->db_imiconf->insert_id();
			
			
			
			
			
			
			#to_user / bcc_admin
			$tmp_sd['password_text']	= $password;
			$_POST["user_details"]		= $tmp_sd;
			$email_template				= array("email_to"				=> $__email,
												"email_heading"			=> "You are registered at IMIPortal",
												"email_file"			=> "email/admincms/csv_user_registered.php",
												"email_subject"			=> "You are registered at IMIPortal",
												"default_subject"		=> TRUE,
												"email_bcc"				=> ( SessionHelper::_get_session("EMAIL_TO", "site_settings") ),
												"email_post"			=> $_POST );
			

			
			if ( !$is_test )
			{
				#$is_email_sent				= $this->_send_email( $email_template );
			}
			#to_user / bcc_admin						
									
		}	
		
		
		return $user_id;
	}
	
	
	public function DUMP_documents_data_in_table_CONF( $user_id, $IMI_ID, $TMP_csv_documents_WITH_IMI )
	{
		if ( count($TMP_csv_documents_WITH_IMI) > 0 )
		{
			if (array_key_exists($IMI_ID, $TMP_csv_documents_WITH_IMI) )
			{
				foreach ($TMP_csv_documents_WITH_IMI[$IMI_ID] as $row_key3 => $row_data3 )
				{
					$_3_IMI_ID										= $row_data3[0];
					$_3_DOCUMENT_URL								= $row_data3[1];
					$_3_UPLOADED_ON									= $row_data3[2];
					$_3_DOCUMENT_TYPE								= $row_data3[3];
					
					
					$tmp_cred					= array("user_id"						=> $user_id,
														"document"						=> trim( $_3_DOCUMENT_URL ),
														"uploaded_on"					=> trim( $_3_UPLOADED_ON ),
														"document_type"					=> trim( $_3_DOCUMENT_TYPE ) );
					
					$this->imiconf_queries->SaveDeleteTables_imiconf($tmp_cred, 's', "tb_conference_registration_excel_documents", 'id');
				}
			}
		}	
	}
	
	public function DUMP_income_data_in_table_CONF( $user_id, $IMI_ID, $TMP_csv_income_WITH_IMI )
	{
		if ( count ($TMP_csv_income_WITH_IMI) > 0 )
		{
			if (array_key_exists($IMI_ID, $TMP_csv_income_WITH_IMI) )
			{
				foreach ($TMP_csv_income_WITH_IMI[$IMI_ID] as $row_key4 => $row_data4 )
				{
					$_4_IMI_ID										= $row_data4[0];
					$_4_NAME										= $row_data4[1];
					$_4_AMOUNT										= $row_data4[2];
					$_4_DATE										= $row_data4[3];
					$_4_PURPOSE										= $row_data4[4];
					$_4_METHOD_OF_PAYMENT							= $row_data4[5];
					$_4_RECEIPT_NUMBER								= $row_data4[6];
					
					$tmp_cred					= array("user_id"						=> $user_id,
														"table_name"					=> trim( "IMIConferenceWebPortal_CSV" ),
														"paypal_post"					=> json_encode( $row_data4 ) );
					
					$this->queries->SaveDeleteTables($tmp_cred, 's', "tb_donation_payments", 'id');
				}
			}
		}	
	}
	
	public function DUMP_user_profile_in_table_CONF( $user_id, $row_data1 )
	{
		
		if ( "update_user_profile" and $user_id)
		{
			#RAO:09-06-2017 (Add Details In User Profile Table)
			$delete_user_profile['userid']									= $user_id;	
			$this->imiconf_queries->SaveDeleteTables_imiconf($delete_user_profile, 'd', "tb_users_profile", 'userid') ;
			
			
	
			$user_profile_Data						= array("userid"							=> $user_id,
															"cellphone_number"					=> $row_data1['14'],
															"secondary_email_1"					=> $row_data1['18'],
															"secondary_email_2"					=> $row_data1['19'],
															
															"home_full_address"					=> $row_data1['25'],
															"home_country"						=> $row_data1['29'],
															"home_state_province"				=> $row_data1['27'],
															"home_city"							=> $row_data1['26'],
															"home_zipcode"						=> $row_data1['28'],
															"home_phone_number"					=> $row_data1['13'],
															
															
															"company_name"						=> $row_data1['11'],
															"title"								=> $row_data1['12'],
															
															"office_full_address"				=> $row_data1['30'],
															"office_country"					=> $row_data1['34'],
															"office_state_province"				=> $row_data1['32'],
															"office_city"						=> $row_data1['31'],
															"office_zip_code"					=> $row_data1['33'],
															"office_phone_number"				=> $row_data1['15'],
															"office_fax_number"					=> $row_data1['17'],
															
															
															"occupation"						=> "", 
															"specialties"						=> $row_data1['24'],
															"prefered_mode_address"				=> $row_data1['20'],
															"preffered_mode_of_contact"			=> $row_data1['16'],
															"preffered_mode_of_email"			=> $row_data1['20'],
															
															//"other_member_can_see_profile"		=> $row_data1['18'],																
															
															
															"web_address"						=> $row_data1['21'],
															"current_imi_title"					=> $row_data1['22'],
															"institute_school"					=> $row_data1['23'],
															"prefered_name"						=> $row_data1['43'],
															"gender"							=> $row_data1['44'],
															"previous_title_with_imi"			=> $row_data1['45'],
															
															"date_added"						=> date("Y-m-d"),
															
															);
														
			$this->imiconf_queries->SaveDeleteTables_imiconf($user_profile_Data, 's', "tb_users_profile", 'id');	
		}	
	}
	*/
	
	public function get_family_details($row_data1,$TMP_csv_memberdata_WITH_IMI){
		
		$TMP_family_members_array = array(
			$row_data1['5'],
			$row_data1['6'],
			$row_data1['7'],
			$row_data1['8'],
			$row_data1['9'],
			$row_data1['10']
		);

		$no_of_family_members = array();
		$MM = 0;

		foreach ($TMP_family_members_array as $familyMemberName) {

			$TMP_explode_one_detail = explode(":", $familyMemberName);
			$TMP_explode_one_detail[0] = preg_replace('/[0-9]+/', '', $TMP_explode_one_detail[0]); #relation name

			if (array_key_exists(2, $TMP_explode_one_detail)) {
				if (array_key_exists((int)$TMP_explode_one_detail[2], $TMP_csv_memberdata_WITH_IMI)) /* and ( $MM % 2 )*/
				{
					$no_of_family_members[] = array($familyMemberName => $TMP_csv_memberdata_WITH_IMI[(int)$TMP_explode_one_detail[2]]);
				} else {
					//echo '<xmp>'.__LINE__.'</xmp>';
					//print_r($TMP_csv_memberdata_WITH_IMI);
					//die;
					//$no_of_family_members[] = array($familyMemberName => array());
				}
			} elseif (array_key_exists(1, $TMP_explode_one_detail)) {
				if (array_key_exists((int)$TMP_explode_one_detail[1], $TMP_csv_memberdata_WITH_IMI)) /* and ( $MM % 2 )*/
				{
					$no_of_family_members[] = array($familyMemberName => $TMP_csv_memberdata_WITH_IMI[(int)$TMP_explode_one_detail[1]]);
				} else {
					//echo '<xmp>' . __LINE__ . '</xmp>';
					//print_r($TMP_csv_memberdata_WITH_IMI);
					//die;
					//$no_of_family_members[] = array($familyMemberName => array());
				}
			}

			$MM++;
		}

		return $no_of_family_members;
	}
	
	public function save ()
	{

		if ( isset($_POST['update_family_only_member']) )
		{
			ob_end_clean();
			include_once(APPPATH . 'controllers/admincms/csvmemberdata/dump.php');
			$__USER_RELATIONS 					= json_decode($_POST['user_relations'],true);
			$__FAMILY_ONLY_MEMBERS 				= json_decode(base64_decode($_POST['IMI_FAMILY_ONLY_MEMBERS']),true);
			$TMP_csv_memberdata_WITH_IMI		= json_decode(base64_decode($_POST['TMP_csv_memberdata_WITH_IMI']),true);
			
			if (!empty($__FAMILY_ONLY_MEMBERS)) {
				
				foreach ($__FAMILY_ONLY_MEMBERS as $key => $__FAMILY_ONLY_MEMBER) {
					$__ID = $__FAMILY_ONLY_MEMBER[0];
					$ids = searchArrayKeyVal('ids', "|" . $__ID . "|", $__USER_RELATIONS);

					foreach ($ids as $imi_id) {
						$user = $this->db_imiconf->query('Select id from tb_users Where imi_id = "'. $imi_id.'"');
						if ( $user->num_rows() > 0 ){
							$user_id = $user->row()->id;
							$this->import_family_members($user_id, $__FAMILY_ONLY_MEMBER, $TMP_csv_memberdata_WITH_IMI);
						}
					}
				}
			}

			echo json_encode(array('status' => 'complete'));
			exit;
		}

		
		if (isset($_POST['file_path']))
		{
			if ( file_exists($_POST['file_path']) ){

				$TMP_csv_documents_WITH_IMI = json_decode($_POST['documents_data']);
				$TMP_csv_income_WITH_IMI = json_decode($_POST['incomes_data']);
				$TMP_csv_memberdata_WITH_IMI = json_decode(base64_decode($_POST['TMP_csv_memberdata_WITH_IMI']), true);

				ob_end_clean();
				$start_time = time();

				$TMP_count_memberdata_index = 0;
				$TMP_csv_memberdata_header = array();
				$TMP_csv_memberdata_data = array();


            #get MEMBER data in array from CSV
				if (($handle = fopen($_POST['file_path'], "r")) !== false) {

                #fgetcsv($handle);
					while (($row = fgetcsv($handle, 1000, ",")) !== false) {
						$row['row_number'] = $TMP_count_memberdata_index;
						if ($TMP_count_memberdata_index == 0) {
							$TMP_csv_memberdata_header = $row;
						} else {
                        //if (!empty($row[18])) {
							$TMP_csv_memberdata_data[] = $row;
                            //$TMP_csv_memberdata_WITH_IMI[ $row[0] ]	= $row;
                        //}
						}


						$TMP_count_memberdata_index++;
					}
					fclose($handle);
				}

				include_once(APPPATH . 'controllers/admincms/csvmemberdata/dump.php');
            
			//$__FAMILY_ONLY_MEMBERS = array();

				$_LINES = array();

			#ADD member data in database
				$j = 0;
				$row_start = 0;
				$row_end = 0;
				if (!empty($TMP_csv_memberdata_data)) {
					foreach ($TMP_csv_memberdata_data as $row_key => $row_data) {
						$_LINES[__LINE__ . '-' . $row_data[0]] = date('H:i:s');
						$j++;
						if ($j === 1) {
							$row_start = $row_data[0];
						}
						$row_end = $row_data[0];



						$user_id = false;
						$IMI_ID = $row_data[0];
						$USER_EMAIL = $row_data[18] != "" ? $row_data[18] : 'missing-email-' . $IMI_ID . '@example.com';
						$row_data[18] = $USER_EMAIL;
						$USER_NAME = $row_data[2];
						$USER_MIDDLE_NAME = $row_data[3];
						$USER_LAST_NAME = $row_data[4];

						$hashed_data = hash('sha256', json_encode($row_data));

						$_LINES[__LINE__ . '-' . $row_data[0]] = date('H:i:s');

						if ($IMI_ID != "" && $this->db->query("SELECT hashed_data FROM tb_csv_upload_each_entry WHERE imi_id = '" . $IMI_ID . "' and hashed_data = '" . $hashed_data . "'")->num_rows() > 0) {
							continue;
						}

						$_LINES[__LINE__ . '-' . $row_data[0]] = date('H:i:s');
					
					//Replace Conutnries name into countires id
						$home_country = $this->db_imiconf->query('Select id from tb_countries where countries_name = "' . $row_data[29] . '" or countries_iso_code_2 = "' . $row_data[29] . '" or countries_iso_code_3 = "' . $row_data[29] . '"');

						if ($home_country->num_rows() > 0) {
							$row_data[29] = $home_country->row()->id;
						}

						$office_country = $this->db_imiconf->query('Select id from tb_countries where countries_name = "' . $row_data[34] . '" or countries_iso_code_2 = "' . $row_data[34] . '" or countries_iso_code_3 = "' . $row_data[34] . '"');

						if ($office_country->num_rows() > 0) {
							$row_data[34] = $office_country->row()->id;
						}

						if ($row_data[29] == "") {
							$row_data[29] = 0;
						}

						if ($row_data[34] == "") {
							$row_data[34] = 0;
						}

						$row_data1 = $row_data;
                    //Replace Conutnries name into countires id
					
					#join first name + middle name
					//$name						 = $USER_NAME;
					/* if ($USER_MIDDLE_NAME != "") {
						$name					.= ' ' . $USER_MIDDLE_NAME;
					} */

						$_LINES[__LINE__ . '-' . $row_data[0]] = date('H:i:s');

						$DUMP_data = new Dump();
						if ($row_data['48'] == 'IMI_ONLY_FAMILY_MEMBER') {
						
						//only family member
						//$__FAMILY_ONLY_MEMBERS[] = $row_data;
						} else {
							$row_data[48] = $row_data[48] == "" ? 'IMIConferenceWebPortal_CSV' : $row_data[48];

						#INSERT / UPDATE			---------> 		U S E R S
							$user_id = $DUMP_data->DUMP_user_data_in_table_CONF($USER_EMAIL, $row_data[1], $USER_NAME, $USER_MIDDLE_NAME, $USER_LAST_NAME, $IMI_ID, $row_data[48], $this);

							if ($user_id > 0) {
						
							#DELETE USER PROFILE -> THEN ADD NEW PROFILE			---------> U S E R     P R O F I L E
								$DUMP_data->DUMP_user_profile_in_table_CONF($user_id, $row_data1, $this);


								if (count($TMP_csv_documents_WITH_IMI) > 0) {
                                #INSERT 		---------> 		D O C U M E N T S
									$DUMP_data->DUMP_documents_data_in_table_CONF($user_id, $IMI_ID, $TMP_csv_documents_WITH_IMI, $this);
								}



								if (count($TMP_csv_income_WITH_IMI) > 0) {
                                #INSERT 		---------> 		I N C O M E
									$DUMP_data->DUMP_income_data_in_table_CONF($user_id, $IMI_ID, $TMP_csv_income_WITH_IMI, $this);
								}

								$this->import_family_members($user_id, $row_data1, $TMP_csv_memberdata_WITH_IMI);

								$TMP_data = $DUMP_data->DUMP_conference_price_not_a_member(null, $row_data1, $this);

								$DUMP_data->DUMP_user_memberships($user_id, $row_data1, $TMP_data['ROW_not_a_member_ID'], $this);
							}
						}

						$_LINES[__LINE__ . '-' . $row_data[0]] = date('H:i:s');

						$tmp_cunu = array(
							"imi_id" => $IMI_ID,
							"email" => $USER_EMAIL,
							"hashed_data" => $hashed_data
						);

						if ($this->db->query("SELECT hashed_data FROM tb_csv_upload_each_entry WHERE imi_id = '" . $IMI_ID . "'")->num_rows() > 0) {
							$_LINES[__LINE__ . '-' . $row_data[0]] = date('H:i:s');

							$this->queries->SaveDeleteTables($tmp_cunu, 'e', "tb_csv_upload_each_entry", 'imi_id');
						} else {
							$this->queries->SaveDeleteTables($tmp_cunu, 's', "tb_csv_upload_each_entry", 'id');
						}

						$_LINES[__LINE__ . '-' . $row_data[0]] = date('H:i:s');
					}
				}

				$_LINES[__LINE__] = date('H:i:s');

				$end_time = time();
				$time_diff = ($end_time - $start_time) / 3600;
				unlink($_POST['file_path']);
				echo json_encode(array('status'=>'complete','row_start'=>$row_start,'row_end'=>$row_end,'lines'=>$_LINES));
			}else{
				echo json_encode(array('status'=>'file not found'));
			}
			
			exit;
        }


		error_reporting(E_ALL);
		$data														= $this->data;
		
		ini_set('MAX_EXECUTION_TIME', -1);

		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		

		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();

		
		

		$_random_string						= random_string('alnum', 6);
		$saveData['id'] 					= $_random_string;

		
		if ( 1==1 )
		{
			if ( !is_dir( $data["images_dir_memberdata"] ) || !is_dir( $data['images_dir_eventssummary'] ) )
			{
				mkdir( SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/csv_uploads/");	
			}
			
			#################################
			###  	csv_memberdata	  	  ###
			#################################
			$other_upload						= array("validate"											=> false,
														"input_field"										=> "file_csv_memberdata",
														"db_field"											=> "csv_memberdata",
														"input_nick"										=> "CSV Member Data",
														"hdn_field"											=> "csv_memberdata",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir_memberdata"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1  );
			
			#################################
			###  	csv_memberdata	  	  ###
			#################################
			
			
			
			
			
			
			
			#################################
			###  	csv_eventssummary 	  ###
			#################################
			$other_upload						= array("validate"											=> false,
														"input_field"										=> "file_csv_eventssummary",
														"db_field"											=> "csv_eventssummary",
														"input_nick"										=> "CSV Events Summary",
														"hdn_field"											=> "csv_eventssummary",
														"tmp_table_field"									=> "upload_2",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir_eventssummary"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_2					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_2  );
			
			#################################
			###  	csv_eventssummary  	  ###
			#################################
			
			
			
			
			
			
			
			#################################
			###  	csv_documents	 	  ###
			#################################
			$other_upload						= array("validate"											=> false,
														"input_field"										=> "file_csv_documents",
														"db_field"											=> "csv_documents",
														"input_nick"										=> "CSV Documents",
														"hdn_field"											=> "csv_documents",
														"tmp_table_field"									=> "upload_3",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir_documents"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_3					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_3  );
			
			#################################
			###  	csv_documents	  	  ###
			#################################
			
			
			
			
			
			
			#################################
			###  	csv_income		 	  ###
			#################################
			$other_upload						= array("validate"											=> false,
														"input_field"										=> "file_csv_income",
														"db_field"											=> "csv_income",
														"input_nick"										=> "CSV Income",
														"hdn_field"											=> "csv_income",
														"tmp_table_field"									=> "upload_4",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir_income"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_4					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_4 );
			
			#################################
			###  	csv_income		  	  ###
			#################################


		}
		
		
		if( $this->form_validation->run() == FALSE )
		{
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			
			//$this->truncate();
			
            /* $is_test = 0;
			if ( $is_test )
			{
				#die("think.. pleae..");
				$this->db->query("TRUNCATE tb_csv_upload_not_updated");
				$this->db->query("TRUNCATE tb_csv_upload");
				
				
				$this->db->query("DELETE FROM tb_sitesectionswidgets WHERE SUBSTRING(registration_site, 1,26) = 'IMIConferenceWebPortal_CSV' ");
				$this->db_imiconf->query("DELETE FROM tb_users WHERE registration_site = 'IMIConferenceWebPortal_CSV'");
				$this->db_imiconf->query("DELETE FROM tb_conference WHERE registration_site = 'IMIConferenceWebPortal_CSV'");
				$this->db_imiconf->query("DELETE FROM tb_conference_registration_excel ");
				$this->db_imiconf->query("DELETE FROM tb_conference_registration_master WHERE registration_site = 'IMIConferenceWebPortal_CSV'");
				$this->db->query("DELETE FROM tb_donation_payments WHERE table_name = 'IMIConferenceWebPortal_CSV' ");
				
				$this->db->query("DELETE FROM tb_csv_upload_each_entry WHERE unique_formid = '". $_POST['unique_formid'] ."' ");
			} */
			
			
			$TMP_full_path_csv_memberdata						= $this->input->post("csv_memberdata");	
			$_POST["csv_memberdata"]							= explode( SERVER_ABSOLUTE_PATH_IMICONF, $this->input->post("csv_memberdata"));
			
			$TMP_full_path_csv_eventssummary					= $this->input->post("csv_eventssummary");	
			$_POST["csv_eventssummary"]							= explode( SERVER_ABSOLUTE_PATH_IMICONF, $this->input->post("csv_eventssummary"));
			
			$TMP_full_path_csv_documents						= $this->input->post("csv_documents");	
			$_POST["csv_documents"]								= explode( SERVER_ABSOLUTE_PATH_IMICONF, $this->input->post("csv_documents"));
			
			$TMP_full_path_csv_income							= $this->input->post("csv_income");	
			$_POST["csv_income"]								= explode( SERVER_ABSOLUTE_PATH_IMICONF, $this->input->post("csv_income"));
			
			
			if ( count($_POST["csv_memberdata"]) > 1 )
			{
				$_POST["csv_memberdata"]						= @$_POST["csv_memberdata"][1];
				$_POST["csv_eventssummary"]						= @$_POST["csv_eventssummary"][1];
				$_POST["csv_documents"]							= @$_POST["csv_documents"][1];
				$_POST["csv_income"]							= @$_POST["csv_income"][1];
			}
			
			$saveData											= array("csv_memberdata"				=> $this->input->post("csv_memberdata"),
			"csv_eventssummary"				=> $this->input->post("csv_eventssummary"),
			"csv_documents"					=> $this->input->post("csv_documents"),
			"csv_income"					=> $this->input->post("csv_income"),
			"date_added"					=> date("Y-m-d") );
			
			$this->queries->SaveDeleteTables($saveData, 's', "tb_csv_upload", 'id');  
			$saveData['id']										= $this->db->insert_id();
			
			
			$TMP_count_eventssummary_index						= 0;
			$TMP_csv_eventssummary_header						= array();
			$TMP_csv_eventssummary_data							= array();
			$TMP_csv_eventssummary_WITH_IMI						= array();
			#ADD CONFERENCES (imiconf database)   &&     EVENTS (imiportal database)
			if (($handle = @fopen($TMP_full_path_csv_eventssummary, "r")) !== FALSE) 
			{
				#fgetcsv($handle);
				while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
				{
					
					$row['row_number']								= $TMP_count_eventssummary_index;
					if ( $TMP_count_eventssummary_index == 0 )
					{
						$TMP_csv_eventssummary_header				= $row;
					}
					else
					{
						$TMP_csv_eventssummary_data[]						= $row;
						
						$TMP_csv_eventssummary_WITH_IMI[ $row[0] ][] 		= $row;
					}
					
					
					$TMP_count_eventssummary_index++;	
					
				}
				fclose($handle);
				
				
				
				
				
				
				#ADD data in tb_users (imiconf database)
				foreach ($TMP_csv_eventssummary_data as $row_key => $row_data )
				{
					$EVENT_TYPE											= $row_data[3];
					$EVENT_NAME											= $row_data[1];
					$IMI_ID												= $row_data[0];
					
					
					
					switch ( $EVENT_TYPE )
					{
						case "INTLCONF":
						$TMP_record				= $this->imiconf_queries->fetch_records_imiconf("conference", ' AND name = "'. $EVENT_NAME .'" ',"id");
						break;
						
						default:
						$TMP_record				=  $this->queries->fetch_records('sitesectionswidgets_details', " AND title = '". $EVENT_NAME ."' ","id");		
							break;
							
						}
						
						
						
						
						
						if ( $TMP_record -> num_rows() <= 0 )
						{					
							
							
							if ( $EVENT_TYPE == "INTLCONF" )
							{
							$EVENT_DATE					= format_date_else_null( "Y-m-d", $row_data[2] );
							
							$tmp_sd						= array("theme"					=> $EVENT_NAME,
							"name"					=> $EVENT_NAME,
							"venue"					=> "",
																"slug"					=> $this->queries->make_slug(	"tb_conference",
																"id",
																"slug",
																"name",
																														$EVENT_NAME,
																														$this->input->post("id"),
																														$this->db_imiconf
																													),
																"description"			=> "",
																"arrival_at"			=> "",
																"departure_from"		=> "",
																"duration_from"			=> NULL,
																"duration_to"			=> NULL,
																"registration_from"		=> $EVENT_DATE,
																"registration_to"		=> $EVENT_DATE,
																"countryid"				=> NULL,
																"registration_site"		=> "IMIConferenceWebPortal_CSV",
																"registration_closed"	=> 0,
																"status"				=> 0);
																
							
																$this->imiconf_queries->SaveDeleteTables_imiconf($tmp_sd, 's', "tb_conference", 'id');  						
																
															}
															else
															{
																$EVENT_DATE					= format_date_else_null( "Y", $row_data[2] );
																
																$tmp_sd						= array("mode"					=> "events",
																"year"					=> $EVENT_DATE,
																"title"					=> $EVENT_NAME,
																"slug"					=> $this->queries->make_slug(	"tb_sitesectionswidgets",
																"id",
																"slug",
																"name",
																$this->input->post("name"),
																$this->input->post("id")
															),
															"start_date"			=> NULL,
															"end_date"				=> NULL,
															"address"				=> "",
															"short_desc"			=> "",
															"full_desc"				=> "",
															"photo_image"			=> "",
															"sort"					=> 0,
															"status"				=> 0,
															"registration_site"		=> "IMIConferenceWebPortal_CSV_" . $EVENT_TYPE,
															"date_added"			=> date("Y-m-d"));
															
															
															$this->queries->SaveDeleteTables($tmp_sd, 's', "tb_sitesectionswidgets", 'id');  
														}
													}					
												}
												
												
												
											}
											
											
											
											
											
											$TMP_count_documents_index									= 0;
											$TMP_csv_documents_header									= array();
											$TMP_csv_documents_data										= array();
											$TMP_csv_documents_WITH_IMI									= array();
											#get documents in array from CSV
											if (($handle = @fopen($TMP_full_path_csv_documents, "r")) !== FALSE) 
											{
												#fgetcsv($handle);
												while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
												{
													
													$row['row_number']				= $TMP_count_documents_index;
													if ( $TMP_count_documents_index == 0 )
													{
														$TMP_csv_documents_header		= $row;
													}
					else
					{
						if ( !empty($row[1]) )
						{
							$TMP_csv_documents_data[]							= $row;
							$TMP_csv_documents_WITH_IMI[ $row[0] ][]			= $row; 
						}
					}
					
					
					$TMP_count_documents_index++;	
					
				}
				fclose($handle);

			}
			
			
			
			
			
			
			
			
			$TMP_count_income_index									= 0;
			$TMP_csv_income_header									= array();
			$TMP_csv_income_data									= array();
			$TMP_csv_income_WITH_IMI								= array();			
			#get income / donations in array from CSV
			if (($handle = @fopen($TMP_full_path_csv_income, "r")) !== FALSE) 
			{
				#fgetcsv($handle);
				while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
				{
					
					$row['row_number']				= $TMP_count_income_index;
					if ( $TMP_count_income_index == 0 )
					{
						$TMP_csv_income_header		= $row;
					}
					else
					{
						if ( !empty($row[1]) )
						{
							$TMP_csv_income_data[]						= $row;
							$TMP_csv_income_WITH_IMI[ $row[0] ][]		= $row;
						}
					}
					
					
					$TMP_count_income_index++;	
					
				}
				fclose($handle);

			}
			
			
			
			
			
			
			
			$TMP_count_memberdata_index									= 0;
			$TMP_csv_memberdata_header									= array();
			$TMP_csv_memberdata_data									= array();
			$TMP_csv_memberdata_WITH_IMI								= array();
			
			
			$inputFile = $TMP_full_path_csv_memberdata;

			#get MEMBER data in array from CSV
            if (($handle = fopen($inputFile, "r")) !== false) {

                #fgetcsv($handle);
                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    $row['row_number']				= $TMP_count_memberdata_index;
                    if ($TMP_count_memberdata_index == 0) {
                        //$TMP_csv_memberdata_header		= $row;
                    } else {
                        //if (!empty($row[18])) {
                            //$TMP_csv_memberdata_data[]				= $row;
                            $TMP_csv_memberdata_WITH_IMI[ $row[0] ]	= $row;
                        //}
                    }
                    
                    
                    $TMP_count_memberdata_index++;
                }
                fclose($handle);
            }

			$outputFile = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/csv_uploads/memberdata/csv_import_";
			
			
			$in = fopen($inputFile, 'r');

			//$splitSize = round(count(file($inputFile))/(12*4), 0, PHP_ROUND_HALF_UP);
			$splitSize = 25;

			$first = fgetcsv($in);

			$__USER_RELATIONS = array();
			$__FAMILY_ONLY_MEMBERS = array();
			
			$rowCount = 0;
			$fileCount = 0;

			$selected_documents_data = array();
			$selected_incomes_data = array();

			while (!feof($in)) {
				if (($rowCount % $splitSize) == 0) {
					if ($rowCount > 0) {
						fclose($out);
					}
					$fileCount++;
					$out = fopen($outputFile . $fileCount . '.csv', 'w');
					fputcsv($out, $first);
				}
				$d = fgetcsv($in);
				if ($d){

					if ( count($TMP_csv_documents_WITH_IMI) > 0 ){
						if ( isset( $TMP_csv_documents_WITH_IMI[$d[0]] ) ){
							$selected_documents_data[$d[0]] = $TMP_csv_documents_WITH_IMI[$d[0]];
						}
					}
					
					if ( count($TMP_csv_income_WITH_IMI) > 0 ){
						if ( isset( $TMP_csv_income_WITH_IMI[$d[0]] ) ){
							$selected_incomes_data[$d[0]] = $TMP_csv_income_WITH_IMI[$d[0]];
						}
					}

					if ($d['48'] != 'IMI_ONLY_FAMILY_MEMBER') {
						//user
						for ($r=5;$r<11;$r++) {
							$relation = explode(':', $d[$r]);
							$relation = isset($relation[1]) ? $relation[1] : $relation[0];
							$val = (int) filter_var($relation, FILTER_SANITIZE_NUMBER_INT);
							if ($val != 0) {
								@$__USER_RELATIONS[$d[0]]['ids'] .= "|".$val."|";
								@$TMP_csv_memberdata_WITH_IMI_MODIFIED[$val] = $TMP_csv_memberdata_WITH_IMI[$val];
							}
						}
					}else{
						$__FAMILY_ONLY_MEMBERS[] = $d;
					}

					fputcsv($out, $d);
				}
				$rowCount++;
			}
			
			fclose($out);

			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['csv_ajax_data'] = array('file_count'=>$fileCount,'output_file'=>$outputFile,'user_relations'=>json_encode($__USER_RELATIONS),'documents_data'=>json_encode($selected_documents_data),'incomes_data'=>json_encode($selected_incomes_data),'TMP_csv_memberdata_WITH_IMI'=>base64_encode(json_encode($TMP_csv_memberdata_WITH_IMI_MODIFIED)),'IMI_FAMILY_ONLY_MEMBERS'=>base64_encode(json_encode($__FAMILY_ONLY_MEMBERS)));
			
			/* $data['_messageBundle']									= $this->_messageBundle( 'success' , 
			lang_line("operation_saved_success"), 
			lang_line("heading_operation_success"),
			false, 
			true); */
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
			//redirect( site_url( $data["_directory"] . "controls/add" ) ) ;
			
		
		}
		
	}
	
	public function import_family_members($user_id,$row_data1, $TMP_csv_memberdata_WITH_IMI)
	{
		$no_of_family_members = $this->get_family_details($row_data1, $TMP_csv_memberdata_WITH_IMI);
		
		$record = $this->imiconf_queries->fetch_records_imiconf('conference_registration_screen_one', ' and conferenceregistrationid in ( select id from tb_conference_registration_master where userid = ' . $user_id . ' and conferenceid is null and participanttypeid is null and regionid is null and registration_site = "IMI_FAMILY_MEMBER" )',"id");
		
		if ($record->num_rows() > 0) {
			$screen_one_id = $record->row()->id;
		} else {
			$crm = $this->imiconf_queries->fetch_records_imiconf('conference_registration_master', ' and conferenceid IS NULL and participanttypeid is null and regionid is null and registration_site = "IMI_FAMILY_MEMBER" and userid = '.$user_id,"id");

			if ($crm->num_rows() > 0) {
				$conferenceregistrationid = $crm->row()->id;
			} else {
				$saveData = array(
					"userid" => $user_id,
					"date_added" => date('Y-m-d H:i:s'),
					"registration_site" => "IMI_FAMILY_MEMBER"
				);
	
				$this->queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_registration_master");
				$conferenceregistrationid = $this->db_imiconf->insert_id();
			}

			$saveData = array(
				"conferenceregistrationid" => $conferenceregistrationid,
				"date_added" => date('Y-m-d H:i:s'),
				"no_of_family_members" => count($no_of_family_members)
			);

			$this->queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_registration_screen_one");
			$screen_one_id = $this->db_imiconf->insert_id();
		}
		
		$DUMP_data = new Dump();
		$DUMP_data->DUMP_conference_registration_screen_one_family_details($screen_one_id, $no_of_family_members, $TMP_csv_memberdata_WITH_IMI, $this);
		/* $saveData = array(
			'parentid' => $screen_one_id,
			"family_relationship" => $_POST['family_relationship_id'],
			"family_name" => $_POST['family_name'],
			"family_email" => $_POST['family_email'],
			"family_age" => $_POST['family_age'],
			"family_birthdate" => $_POST['family_birthdate']
		);

		$this->queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_registration_screen_one_family_details");
		 */
	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "csv_memberdata", "csv_eventssummary", "csv_documents", "csv_income", "identifier", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "csv_memberdata", "csv_eventssummary", "csv_documents", "csv_income", "identifier", "options", "unique_formid" );
		
		//$filled_inputs				= array( "id", "resorts_id", "promo_code_percentage_discount_code", "promo_code_percentage_discount_percent", "promo_code_percentage_discount_datefrom", "promo_code_percentage_discount_expiry", "promo_code_value_add_code", "promo_code_value_add_details", "promo_code_value_add_datefrom", "promo_code_value_add_expiry",  "options" );
		
		
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
	
	
	
	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $data["_directory"] . "edit.php";
		
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
	}
	
	
	public function truncate()
	{
		//die("think.. pleae..");
		$data				= $this->data;

		//$this->db->query("TRUNCATE tb_csv_upload_not_updated");
		//$this->db->query("TRUNCATE tb_csv_upload");
		$this->db->query("TRUNCATE tb_csv_upload_each_entry");


		$this->db->query("DELETE FROM tb_sitesectionswidgets WHERE SUBSTRING(registration_site, 1,26) = 'IMIConferenceWebPortal_CSV' ");
		//$this->db_imiconf->query("DELETE FROM tb_users WHERE registration_site = 'IMIConferenceWebPortal_CSV'");
		//$this->db_imiconf->query("DELETE FROM tb_conference WHERE registration_site = 'IMIConferenceWebPortal_CSV'");
		//$this->db_imiconf->query("DELETE FROM tb_conference_registration_excel ");
		//$this->db_imiconf->query("DELETE FROM tb_conference_registration_master WHERE registration_site = 'IMIConferenceWebPortal_CSV' or registration_site = 'IMI_FAMILY_MEMBER' or registration_site is NULL");
		$this->db->query("DELETE FROM tb_donation_payments WHERE table_name = 'IMIConferenceWebPortal_CSV' ");

		
		$data['_messageBundle']								= $this->_messageBundle('info' , 
																					lang_line("operation_delete_success"), 
																					"Records <strong>truncated</strong> successfully", 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/add")  );
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

		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			#$this->queries->SaveDeleteTables($saveData, 'd', "tb_admin", 'id') ;
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