<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once __DIR__ . '/shared.php';

class Dump extends C_admincms {

	 
	 
	public function __construct()
	{
		#parent::__construct();
	}

	
	public function DUMP_user_data_in_table_CONF( $__email, $__prefix_title, $__name, $__middlename, $__last_name, $IMI_ID, $_registration_site,  $THIS )
	{	
		$user_id = 0;
		
		$TMP_email						= $THIS->imiconf_queries->fetch_records_imiconf("users", " AND email = '". $__email ."' ","id,email");
		
		if ($TMP_email -> num_rows() > 0) {
			$user_id		= $TMP_email->row()->id;
				
			$updateData		= array("id"						=> $user_id,
									"prefix_title"				=> $__prefix_title, #$row_data[1],
									"name"						=> $__name,
									"middle_name"				=> $__middlename,
									"last_name"					=> $__last_name,
									"imi_id"					=> $IMI_ID
								);
			$THIS->queries->SaveDeleteTables_imiconf($updateData, 'e', "tb_users", 'id');
		} else {
			$password			= random_string('alnum', 16);
			$tmp_sd				= array(
										"email"						=> $__email,
										"prefix_title"				=> $__prefix_title,
										"name"						=> $__name,
										"middle_name"				=> $__middlename,
										"last_name"					=> $__last_name,
										"password"					=> $THIS->encrption->encrypt($password),
										"registration_site"			=> $_registration_site == "" || $_registration_site == null ? 'IMIConferenceWebPortal_CSV' : $_registration_site,
										"is_active"					=> 1,
										"date_added"				=> date("Y-m-d"),
										"imi_id"					=> $IMI_ID
									);
			$THIS->imiconf_queries->SaveDeleteTables_imiconf($tmp_sd, 's', "tb_users", 'id');
			$user_id					= $THIS->db_imiconf->insert_id();
		}
		return $user_id;
	}

    function DUMP_user_memberships($user_id, $row_data1, $ROW_not_a_member_ID, $THIS)
    {
		
        if ($row_data1[memberCsvColumnIndexFromColumnName('Membership Type 2')] != "") {
            if ($ROW_not_a_member_ID == 0) {
                $ROW_not_a_member_ID = NULL;
            }


            $expiry_date_components = explode("-", $row_data1[memberCsvColumnIndexFromColumnName('Membership Expiry Date')]);
            $member_expiry_date_for_db = NULL;
            if (count($expiry_date_components) === 3) {
                $member_expiry_date_for_db = date("Y-m-d", strtotime($expiry_date_components[1] . '-' . $expiry_date_components[0] . '-' . $expiry_date_components[2]));
            } else {
                $parsed_time = strtotime($row_data1[memberCsvColumnIndexFromColumnName('Membership Expiry Date')]);
                if ($parsed_time !== false) {
                    if ($row_data1[memberCsvColumnIndexFromColumnName('Membership Expiry Date')] === '9/9/1999') {
                        $member_expiry_date_for_db = '9999-12-31';
                    } else {
                        $member_expiry_date_for_db = date("Y-m-d", $parsed_time);
                    }
                } else {
					//var_dump('LINE #'.__LINE__,$row_data1[memberCsvColumnIndexFromColumnName('Membership Expiry Date')], array_reverse(get_defined_vars()));
                }
            }
            if ($member_expiry_date_for_db === date('Y-m-d')) {
				//var_dump('LINE #'.__LINE__,array_reverse(get_defined_vars()));
            }
            unset($parsed_time, $expiry_date_components);

            $skip_membership_user_entry = false;
            /** @var CI_DB_mysqli_result $current_max_expiry_query */
            $current_max_expiry_query = $THIS->db_imiconf->query(<<<EOQ
select ifnull(member_expiry, computeExpiryDate(membership_package_per, date_purchased)) AS expiry_date, um.*  from tb_user_memberships um where um.user_id = ? order by expiry_date desc limit 1
EOQ
                ,
                array(
                    $user_id,
                )
            );
            if ($current_max_expiry_query->num_rows > 0) {
                if ($current_max_expiry_query->num_rows === 1) {
                    $current_max_expiry_row = $current_max_expiry_query->row_array();
                    //$current_expiry_timestamp = strtotime($current_max_expiry_row['expiry_date']);
                    //$new_expiry_timestamp = strtotime($member_expiry_date_for_db);
                    //if ($current_expiry_timestamp === false || $new_expiry_timestamp === false) {
						$date_from_db = new DateTime($member_expiry_date_for_db);
						//$date_from_db = new DateTime('9999/9/9 00:00:00');
						$date_from_csv = new DateTime($current_max_expiry_row['expiry_date']);
						//$date_from_csv = new DateTime('1999/9/9 00:00:00');
						/* echo '<br/>=====<br/>';
						echo '<pre>';var_dump($current_expiry_timestamp, $new_expiry_timestamp, $current_max_expiry_row['expiry_date'], $member_expiry_date_for_db, array_reverse(get_defined_vars()));
						die;
					} */
                    //if ($current_expiry_timestamp >= $new_expiry_timestamp) {
					if ($date_from_db->diff($date_from_csv)->invert) {
						$skip_membership_user_entry = true;
                    } else {
						$skip_membership_user_entry = false;
                    }
                } else {
					//var_dump('LINE #'.__LINE__,$current_max_expiry_query->result_array(), array_reverse(get_defined_vars()));
                }
            }

            if (!$skip_membership_user_entry) {
                $THIS->imiconf_queries->SaveDeleteTables_imiconf(
                    array(
                        'ispaid' => 1,
                        'is_paid_membership_approved' => 1,
                        'id' => $user_id,
                    ),
                    'e',
                    "tb_users",
                    'id'
                );

                $data_for_db = array("user_id" => $user_id,
                    "member_since" => $row_data1[memberCsvColumnIndexFromColumnName('Member since')],
                    "member_expiry" => $member_expiry_date_for_db,
                    "membership_package_id" => $ROW_not_a_member_ID,
                    "registration_site" => "IMIConferenceWebPortal_CSV",
                );

                $THIS->imiconf_queries->SaveDeleteTables_imiconf($data_for_db, 'd', "tb_user_memberships", 'user_id|member_since|member_expiry|membership_package_id|registration_site');

                $THIS->imiconf_queries->SaveDeleteTables_imiconf($data_for_db,
                    's',
                    "tb_user_memberships",
                    'id'
                );
            }
        }
    }
	
	
	public function DUMP_documents_data_in_table_CONF( $user_id, $IMI_ID, $TMP_csv_documents_WITH_IMI, $THIS )
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
					
					$THIS->imiconf_queries->SaveDeleteTables_imiconf($tmp_cred, 's', "tb_users_documents", 'id');
				}
			}
		}	
	}
	
	public function DUMP_income_data_in_table_CONF( $user_id, $IMI_ID, $TMP_csv_income_WITH_IMI, $THIS )
	{
		
		
		if ( count ($TMP_csv_income_WITH_IMI) > 0 )
		{
			if (array_key_exists($IMI_ID, $TMP_csv_income_WITH_IMI) )
			{
				
				foreach ($TMP_csv_income_WITH_IMI[$IMI_ID] as $row_key4 => $row_data4 )
				{
					$_4_IMI_ID										= $row_data4[0];
					$_4_NAME										= $row_data4[1];
					$_4_AMOUNT										= (float)$row_data4[2];
					$_4_DATE										= $row_data4[3];
					$_4_PURPOSE										= $row_data4[4];
					$_4_METHOD_OF_PAYMENT							= $row_data4[5];
					$_4_RECEIPT_NUMBER								= $row_data4[6];
					
					
					$THIS->db->query("	DELETE FROM tb_donation_payments 
											WHERE user_id = '". $user_id ."' 
											AND payment_gross = '". $_4_AMOUNT ."' 
											AND payment_status = 'Completed'
											AND payment_mode = '". $_4_METHOD_OF_PAYMENT ."' 
											AND reference_number = '". $_4_RECEIPT_NUMBER ."'
											AND table_name = '". trim( "IMIConferenceWebPortal_CSV" ) ."'
											" );

											
					$tmp_cred					= array("user_id"						=> $user_id,
														//"payment_gross"					=> $_4_AMOUNT,
														"payment_status"				=> "Completed",
														//"paypal_post"					=> json_encode( $row_data4 ),
														"payment_mode"					=> $_4_METHOD_OF_PAYMENT,
														//"reference_number"				=> $_4_RECEIPT_NUMBER,
														"date_added"					=> date("Y-m-d", strtotime($_4_DATE) ),
														"table_name"					=> trim( "IMIConferenceWebPortal_CSV" ),
														 );
					
					$THIS->queries->SaveDeleteTables($tmp_cred, 's', "tb_donation_payments", 'id');
					$payment_id = $THIS->db->insert_id();
					$tmp_cred					= array("payment_id"						=> $payment_id,
														"payment_gross"					=> $_4_AMOUNT,
														//"payment_status"				=> "Completed",
														"paypal_post"					=> json_encode( $row_data4 ),
														//"payment_mode"					=> $_4_METHOD_OF_PAYMENT,
														"reference_number"				=> $_4_RECEIPT_NUMBER,
														//"date_added"					=> date("Y-m-d", strtotime($_4_DATE) ),
														//"table_name"					=> trim( "IMIConferenceWebPortal_CSV" ),
														 );
					
					$THIS->queries->SaveDeleteTables($tmp_cred, 's', "tb_donation_payments", 'id');
				}
			}
		}	
	}
	
	public function DUMP_user_profile_in_table_CONF( $user_id, $row_data1, $THIS )
	{
		
		if ( "update_user_profile" and $user_id)
		{
			#RAO:09-06-2017 (Add Details In User Profile Table)
			//$delete_user_profile['userid']									= $user_id;	
			//$THIS->imiconf_queries->SaveDeleteTables_imiconf($delete_user_profile, 'd', "tb_users_profile", 'userid') ;
			
			$user_profile_Data	= array(
									"userid"							=> $user_id,
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
									
									
									"occupation"						=> $row_data1['24'], 
									"specialties"						=> $row_data1['24'],
									"prefered_mode_address"				=> $row_data1['20'],
									"preffered_mode_of_contact"			=> $row_data1['16'],
									"preffered_mode_of_email"			=> $row_data1['20'],
									
									//"other_member_can_see_profile"		=> $row_data1['18'],																
									
									
									"web_address"						=> $row_data1['21'],
									"current_imi_title"					=> $row_data1['22'],
									"institute_school"					=> $row_data1['23'],
									"record_last_update_on"				=> $row_data1['37'],
									"business_individual"				=> $row_data1['41'],
									"comments"							=> $row_data1['42'],
									"prefered_name"						=> $row_data1['43'],
									"gender"							=> $row_data1['44'],
									"previous_title_with_imi"			=> $row_data1['45'],
									"is_muslim"							=> $row_data1['40'] == 'M' ? 1 : 0,
									"date_added"						=> date("Y-m-d"),
								);
			
			$q = $THIS->db_imiconf->query('Select id FROM tb_users_profile where userid = '.$user_id);
			
			if ($q->num_rows() > 0) {
                $user_profile_Data['id'] = $q->row()->id;
                $THIS->imiconf_queries->SaveDeleteTables_imiconf($user_profile_Data, 'e', "tb_users_profile", 'id');
            }else{
				$THIS->imiconf_queries->SaveDeleteTables_imiconf($user_profile_Data, 's', "tb_users_profile", 'id');
			}
		}	
	}
	
	public function DUMP_conference_who_attend( $TMP_conference_ID, $no_of_family_members, $THIS )
	{
		$TOTAL_members_COUNT					= count($no_of_family_members) + 1;
		$TOTAL_members_TEXT						= count($no_of_family_members) + 1 . " Person";
		$ROW_who_attend_ID						= $THIS->db_imiconf->query("SELECT * FROM `tb_conference_who_attend` 
																			WHERE conferenceid = '". $TMP_conference_ID ."' 
																			AND name = '". $TOTAL_members_TEXT ."' 
																			AND no_of_people = '". $TOTAL_members_COUNT ."' ");
																			
																			
																			
		if ( $ROW_who_attend_ID -> num_rows() > 0  )
		{
			$ROW_who_attend_ID					= $ROW_who_attend_ID->row()->id;	
		}
		else
		{
		

			$TMP_r								= array("conferenceid"						=> $TMP_conference_ID,
														"name"								=> $TOTAL_members_TEXT ,
														"no_of_people"						=> $TOTAL_members_COUNT );
			$THIS->imiconf_queries->SaveDeleteTables_imiconf($TMP_r, 's', "tb_conference_who_attend", 'id'); 
			$ROW_who_attend_ID					= $THIS->db_imiconf->insert_id();	
		}	
		
		return $ROW_who_attend_ID;
	}
	
	public function DUMP_conference_price( $TMP_conference_ID, $ROW_who_attend_ID, $THIS  )
	{
		$ROW_conference_price_ID						= $THIS->db_imiconf->query("SELECT * FROM `tb_conference_prices_master` 
																					WHERE conferenceid = '". $TMP_conference_ID ."' 
																					AND whoattendid = '". $ROW_who_attend_ID ."' ");
																			
		if ( $ROW_conference_price_ID -> num_rows() > 0 )
		{
			$ROW_conference_price_ID							= $ROW_conference_price_ID->row()->id;									
		}
		else
		{
			$ROW_conference_regions_ID							= $THIS->db_imiconf->query("SELECT * FROM `tb_conference_regions` 
																							WHERE conferenceid = '". $TMP_conference_ID ."' 
																							AND name = '-' ");
																						
			$saveData											= array("conferenceid"				=> $TMP_conference_ID,
																		"whoattendid"				=> $ROW_who_attend_ID,
																		"regionid"					=> $ROW_conference_regions_ID->row()->id,
																		"paymenttype_key"			=> 'members',
																		"is_optional"				=> FALSE,
																		"is_free"					=> FALSE,
																		"discount_coupon_code"		=> '' );
			$THIS->imiconf_queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_prices_master", 'id');  		
			$ROW_conference_price_ID							= $THIS->db_imiconf->insert_id();
			
			$TMP_arr										= array(1, 2);
			foreach ($TMP_arr as $__value )
			{
				$childData['parentid']						= $ROW_conference_price_ID;
				$childData['typeid']						= $__value;
				$childData['earlybird_price']				= 0;
				$childData['regular_price']					= 0;
				$THIS->imiconf_queries->SaveDeleteTables_imiconf($childData, 's', "tb_conference_prices_details", 'id');  
			}
		}	
		
		return $ROW_conference_price_ID;
	}
	
	/* public function DUMP_conference_registration_master( $user_id, $TMP_conference_ID, $THIS )
	{
		
		$ROW_conference_regions_ID						= $THIS->db_imiconf->query("SELECT * FROM `tb_conference_regions` 
																					WHERE conferenceid = '". $TMP_conference_ID ."' 
																					AND name = '-' ");
																			
																			
																			
		if ( $ROW_conference_regions_ID -> num_rows() > 0  )
		{
			$ROW_conference_regions_ID							= $ROW_conference_regions_ID->row()->id;	
		}
		else
		{
			$saveData											= array("conferenceid"						=> $TMP_conference_ID,
																		"name"								=> "-",
																		
																		"allow_payment"						=> TRUE,
																		"paymentdescription_conference"		=> "",
																		"paymentdescription_abstract"		=> "",
																		
																		
																		"description"						=> "",
																		"onsite_note"						=> "" );
			
			$THIS->imiconf_queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_regions", 'id'); 
			$ROW_conference_regions_ID						= $THIS->db_imiconf->insert_id();
		}
		
							
						
							
		$TMP_session						= array("conferenceid"				=> $TMP_conference_ID,
													"participanttypeid"			=> 2,
													
													"regionid"					=> $ROW_conference_regions_ID,
													
													"userid"					=> $user_id,
													"date_added"				=> date("Y-m-d H:i:s"),
													"registration_site"			=> "IMIConferenceWebPortal_CSV" );
		$THIS->imiconf_queries->SaveDeleteTables_imiconf($TMP_session, 's', "tb_conference_registration_master", 'id'); 
		return $TMP_conferenceregistration_master_ID		= $THIS->db_imiconf->insert_id();	
	} */
	
	function DUMP_conference_registration_screen_one( $TMP_conferenceregistration_master_ID, $row_data1, $no_of_family_members, $THIS )
	{
		$TMP_session						= array("conferenceregistrationid"	=> $TMP_conferenceregistration_master_ID,
													"prefix"					=> $row_data1['1'],
													"education"					=> "",
													"phone"						=> $row_data1['14'],
													"name"						=> $row_data1['2'] . " " . $row_data1['3'],
													"email"						=> $row_data1['18'],
													"no_of_family_members"		=> count($no_of_family_members),
													"travelling_with"			=> "imi_group",
													"date_added"				=> date("Y-m-d H:i:s"));
		$THIS->imiconf_queries->SaveDeleteTables_imiconf($TMP_session, 's', "tb_conference_registration_screen_one", 'id'); 
		return $TMP_conferenceregistration_screen_one_ID		= $THIS->db_imiconf->insert_id();	
	}
	
	
	
	
	
	function DUMP_conference_registration_screen_one_family_details($TMP_conferenceregistration_screen_one_ID,  $no_of_family_members,  $TMP_csv_memberdata_WITH_IMI, $THIS )
	{
		$TMP_conferenceregistration_screen_one_detail_IDS			= array();
		#SCREEN ONE FAMILY DETAILS
		foreach ( $no_of_family_members as $__index		=> $_family_detail )
		{

			$TMP_relationship_record = array();
			
			#$TMP_explode_one_detail					= explode(":", $no_of_family_members[$i]);
			#$TMP_explode_one_detail[0]					= preg_replace('/[0-9]+/', '', $TMP_explode_one_detail[0]);
			
			$_relation									= key ( $_family_detail ) ;
			$_relation_explode							= explode(":", $_relation);
			
			
			$_TMP_family_relation						= preg_replace('/[0-9]+/', '', $_relation_explode[0]);
			$_TMP_family_name							= $_relation_explode[1];
			$_TMP_family_ID								= isset($_relation_explode[2]) ? $_relation_explode[2] : $_relation_explode[1];
			
			
			$_detail									= $_family_detail[ $_relation ];

			
			$ROW_relationship_ID					= $THIS->db_imiconf->query("SELECT id FROM `tb_family_relationships` WHERE LOWER(name) = '". $_TMP_family_relation ."'");
			if ( $ROW_relationship_ID->num_rows() > 0 )
			{
				$ROW_relationship_ID				= $ROW_relationship_ID->row()->id;	
			}
			else
			{
				$TMP_r								= array("name"						=> $_TMP_family_relation);
				$THIS->imiconf_queries->SaveDeleteTables_imiconf($TMP_r, 's', "tb_family_relationships", 'id'); 
				$ROW_relationship_ID				= $THIS->db_imiconf->insert_id();	
			}





			
            if (count($_detail) && $_detail[0] != "") {
				$prefix = $_detail[1] != "" ? str_replace(' ', '', $_detail[1])." ": "";
				$first_name = $_detail[2] != "" ? str_replace(' ', '', $_detail[2]) . " " : "";
				$middle_name = $_detail[3] != "" ? str_replace(' ', '', $_detail[3]) . " " : "";
				$last_name = $_detail[4] != "" ? str_replace(' ', '', $_detail[4]) . " " : "";

				$family_name = $prefix. $first_name. $middle_name.$last_name;

				$TMP_relationship_record["imi_id"]							= $_detail[0];
                $TMP_relationship_record["family_name"]						= $family_name;
                $TMP_relationship_record["family_email"]					= $_detail[18] != "" ? $_detail[18] : 'missing-email-'.$_detail[0].'@example.com';
                $TMP_relationship_record["family_age"]						= (int)$_detail[47];
				$TMP_relationship_record["parentid"] = $TMP_conferenceregistration_screen_one_ID;
				$TMP_relationship_record["family_relationship"] = $ROW_relationship_ID;
			

                $q = $THIS->db_imiconf->query('Select id from tb_conference_registration_screen_one_family_details where imi_id = '. $TMP_relationship_record["imi_id"].' and parentid = '. $TMP_relationship_record["parentid"].' and family_relationship = '. $TMP_relationship_record["family_relationship"].' and family_name = "'. $TMP_relationship_record["family_name"].'" and family_email = "'. $TMP_relationship_record["family_email"].'"');

                if ($q->num_rows() > 0) {
                    $r = $q->result();
                    $TMP_relationship_record['id'] = $r[0]->id;
                    $THIS->imiconf_queries->SaveDeleteTables_imiconf(
                    $TMP_relationship_record,
                    'e',
                    "tb_conference_registration_screen_one_family_details",
                    'id'
                );
                
                    $TMP_conferenceregistration_screen_one_detail_IDS[]				= $r[0]->id;
                } else {
                    $THIS->imiconf_queries->SaveDeleteTables_imiconf(
                    $TMP_relationship_record,
                    's',
                    "tb_conference_registration_screen_one_family_details",
                    'id'
                );
                    $TMP_conferenceregistration_screen_one_detail_IDS[]				= $THIS->db_imiconf->insert_id();
                }
            }
															
		
		}
									

		return $TMP_conferenceregistration_screen_one_detail_IDS;

		#SCREEN ONE FAMILY DETAILS	
	}
	
	
	function DUMP_conference_registration_screen_two( $user_id, $row_data1, $TMP_conference_ID, $TMP_conferenceregistration_master_ID, $TMP_conferenceregistration_screen_one_ID, $THIS )
	{
		$paymenttypeid						= 1; //non member
		$TMP_is_member_array				= $THIS->functions->validate_if_user_is_a_paid_member( $user_id );
		if ( $TMP_is_member_array['is_paid'] )
		{
			$paymenttypeid					= 2; //member
		}
		
		
		
		$TMP_data							= $this->DUMP_conference_price_not_a_member(  $TMP_conference_ID, $row_data1, $THIS );
		$ROW_not_a_member_ID				= $TMP_data['ROW_not_a_member_ID'];
		$be_a_member_fee					= $TMP_data['be_a_member_fee'];

		$TMP_session						= array("conferenceregistrationid"	=> $TMP_conferenceregistration_master_ID,
													"screen_one_id"				=> $TMP_conferenceregistration_screen_one_ID,
													"earlybird_regular"			=> 'regular_price',
													"paymenttypeid"				=> $paymenttypeid,
													"be_a_member"				=> $ROW_not_a_member_ID,
													"be_a_member_fee"			=> $be_a_member_fee,
													"coupon_code"				=> '',
													"speaker_coupon_code"		=> '',
													
													"date_added"				=> date("Y-m-d H:i:s"),
													
													"price_package_fee"			=> '', //$this->input->post("txt_package_fee"),
													"price_payable_now"			=> '', //$this->input->post("txt_payable_now"),
													"price_cash_onsite"			=> '', //$this->input->post("txt_cash_onsite"),
													"price_total_payable"		=> '', //$this->input->post("txt_total_payable"),
													"price_less_absfee"			=> '', //$this->input->post("txt_abs_paid"),
													
													"email_text"				=> '' //$this->input->post("email_text")
													);
		
		$THIS->imiconf_queries->SaveDeleteTables_imiconf	(	$TMP_session, 
																's', 
																"tb_conference_registration_screen_two", 
																'id'
        );

        $TMP_conferenceregistration_screen_two_ID = $THIS->db_imiconf->insert_id();


        return $TMP_conferenceregistration_screen_two_ID;
	}
	
	function DUMP_conference_registration_screen_two_details( $user_id, $ROW_conference_price_ID, $TMP_conferenceregistration_screen_two_ID, $THIS  )
	{
		//TWP DETAIL -> QUERY
		$paymenttypeid						= 1; //non member
		$TMP_is_member_array				= $THIS->functions->validate_if_user_is_a_paid_member( $user_id );
		if ( $TMP_is_member_array['is_paid'] )
		{
			$paymenttypeid					= 2; //member
		}
		
		$ROW_conference_price_details_ID				= $THIS->db_imiconf->query("SELECT * FROM `tb_conference_prices_details` 
																					WHERE parentid = '". $ROW_conference_price_ID ."' 
																					AND typeid = '". $paymenttypeid ."' ");
												
												
												
		$child_details			= array("parentid"					=> $TMP_conferenceregistration_screen_two_ID,
										"price_details_id"			=> $ROW_conference_price_details_ID->row()->id,
										"price_details_value"		=> $ROW_conference_price_details_ID->row()->id."::".$ROW_conference_price_details_ID->row()->regular_price,
										"multply_by_no_of_people"	=> 1);
		
		
		
		$THIS->imiconf_queries->SaveDeleteTables_imiconf($child_details, 's', "tb_conference_registration_screen_two_details", 'id'); 
		$TMP_conferenceregistration_screen_two_details_ID					= $THIS->db_imiconf->insert_id();	
		
		return $TMP_conferenceregistration_screen_two_details_ID;	
	}
	
	function DUMP_conference_registration_screen_three( $TMP_conferenceregistration_master_ID, $TMP_conferenceregistration_screen_one_ID, $TMP_conferenceregistration_screen_two_ID, $parentid, $_screen_one_detail_id, $TMP_conference_title, $row_data1, $_mode, $THIS )
	{
		$_gender							= "";
		if ( $row_data1['44'] != "" )
		{
			$_gender						= substr($row_data1['44'], 0, 1);
		}
		
		
		if ( $row_data1['2'] == NULL )
		{
			print_r( $row_data1  );
			
			die("f 3f 3");	
		}
		
		$TMP_session						= array("conferenceregistrationid"				=> $TMP_conferenceregistration_master_ID,
													"screen_one_id"							=> $TMP_conferenceregistration_screen_one_ID,
													"screen_two_id"							=> $TMP_conferenceregistration_screen_two_ID,
													"gender"								=> $_gender,
													
													"name"									=> $row_data1['2'],
													"middle_name"							=> $row_data1['3'],
													"father_name"							=> $row_data1['4'],
													"surname"								=> '',
													"passport_number"						=> '',
													"passport_type"							=> '',
													"date_of_birth"							=> '0000-00-00',
													"place_of_birth"						=> '',
													"country_of_birth"						=> '',
													"nationality"							=> $row_data1['29'],
													"passport_image"						=> '', //rao:this need to be fetch.
													"photo_image"							=> '', //rao:this need to be fetch.
													"marital_status"						=> '',
													"gender_father_name"					=> '',
													"previous_nationality"					=> '',
													"date_of_issue"							=> '0000-00-00',
													"place_of_issue"						=> '',
													
													"expiry_date"							=> '0000-00-00',
													"occupation"							=> $row_data1['24'],
													"position"								=> '',
													"name_of_institute_company"				=> $row_data1['23'],
													"title_of_activity"						=> $TMP_conference_title,
													"visa_insurance_place"					=> '',
													"duration_of_stay"						=> 0,
													"no_of_previous_travels"				=> 0,
													"date_of_entry_for_conference"			=> '0000-00-00',
													"last_date_of_entry"					=> '0000-00-00',
													"date_of_departure"						=> '0000-00-00',
													"date_added"							=> date("Y-m-d H:i:s"),
													"parentid"								=> $parentid,
													"screen_one_detail_id"					=> $_screen_one_detail_id);
													
		
		


	
		$THIS->imiconf_queries->SaveDeleteTables_imiconf($TMP_session, 's', "tb_conference_registration_screen_three", 'id'); 
		return $THIS->db_imiconf->insert_id();	
	}
	
	function DUMP_conference_payments( $user_id, $TMP_conference_ID, $TMP_conferenceregistration_master_ID, $THIS )
	{
		$saveData			= array("userid"								=> $user_id,
									"conferenceid"							=> $TMP_conference_ID,
									"conference_registration_id"			=> $TMP_conferenceregistration_master_ID,
									"payer_email"							=> '',
									"payment_gross"							=> '',
									"ipn_track_id"							=> '',
									"payer_id"								=> '',
									"payment_status"						=> 'Completed',
									"paypal_post"							=> '',
									"date_added"							=> date("Y-m-d H:i:s"));



		$THIS->imiconf_queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_payments", 'id'); 	
	}
	
	function DUMP_conference_master_update_payment( $user_id, $TMP_conference_ID, $TMP_conferenceregistration_master_ID, $THIS )
	{
		$saveData										= array("id"									=> $TMP_conferenceregistration_master_ID,
																"userid"								=> $user_id,
																"conferenceid"							=> $TMP_conference_ID,																							
																"payment_allow"							=> 0,
																"payment_type"							=> 'cash',																							
																"is_paid "								=> 1); 
			
		
		
		$THIS->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_conference_registration_master", 'id'); 	
	}
	
		
	function DUMP_conference_price_not_a_member( $TMP_conference_ID, $row_data1, $THIS )
	{
		$be_a_member_fee							= FALSE;
		$ROW_not_a_member_ID						= FALSE;
        if ($row_data1[memberCsvColumnIndexFromColumnName('Membership Type 2')] != "")
		{
			$be_a_member_fee						= TRUE;
			
			
			
			$TMP_where								= "AND conferenceid = '". $TMP_conference_ID ."'";
			if ($TMP_conference_ID == NULL )
			{
				$TMP_where							= "AND conferenceid IS NULL";	
			}
			$ROW_not_a_member_ID					= $THIS->db_imiconf->query("SELECT id FROM `tb_conference_prices_not_a_member` 
																				WHERE name = '" . $row_data1[memberCsvColumnIndexFromColumnName('Membership Type 2')] . "' 
																				AND per = '". $row_data1[35] ."' 
																				$TMP_where");
																				
				
			
			
			if ( $ROW_not_a_member_ID -> num_rows() > 0 )
			{
				$ROW_not_a_member_ID				= $ROW_not_a_member_ID->row()->id;	
			}
			else
			{
				$TMP_r								= array("conferenceid"						=> $TMP_conference_ID,
															"per"								=> $row_data1[35],
                    "name" => $row_data1[memberCsvColumnIndexFromColumnName('Membership Type 2')],
															"price"								=> 0 );
				$THIS->imiconf_queries->SaveDeleteTables_imiconf($TMP_r, 's', "tb_conference_prices_not_a_member", 'id'); 
				$ROW_not_a_member_ID				= $THIS->db_imiconf->insert_id();	
			}
		}	
		
		return array(	"ROW_not_a_member_ID"			=> $ROW_not_a_member_ID,
						"be_a_member_fee"				=> $be_a_member_fee);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */