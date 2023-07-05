<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_Input input
 * @property CI_Output output
 * @property Functions functions
 */
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
		
		
		$this->data["_heading"]										= 'Manage Users';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/profileimages/";
		
		
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_fields_for_form_2(false, $this->data);	
		$this->_create_fields_for_form_3(false, $this->data);
		$this->_create_fields_for_form_4(false, $this->data);
		$this->_create_fields_for_form_5(false, $this->data);
		$this->_create_fields_for_form_6(false, $this->data);
		$this->_create_fields_for_form_9(false, $this->data);
		//$this->_create_child_for_form(false, $this->data);

		$this->_is_paid_membership_expired = <<<EOT
		IF(
			t1.crs2_coupon_id IS NOT NULL,
			NULL,
			IF(
				t1.crs2_bam_id IS not NULL,
				If(
					t1.crs2_bam_cpnam_id is NULL,
					' debug33 ',
					If(
						crs2_bam_expiry_date is NULL,
						' debug35 ',
						If(
							now() > crs2_bam_expiry_date,
							true,
							' debug38 '
						)
					)
				),
				If(
					t1.u_ispaid = 1,
					If(
						t1.um_id is NULL,
						NULL,
						If(
							t1.um_p_id is NULL,
							' debug43 ',
							If(
								um_expiry_date is NULL,
								' debug11 ',
								If(
									now() > um_expiry_date,
									true,
									If(
										t1.is_paid_membership_approved is NULL,
										' debug50 ',
										CASE t1.is_paid_membership_approved
											WHEN 0 THEN NULL
                                            WHEN 1 THEN NULL
                                            WHEN -1 THEN ' debug82 '
										ELSE ' debug110 ' END
									)
								)
							)
						)
					),
					NULL
				)
			)
		) as is_membership_expired
EOT;
		
		$this->_membership_detaials_package_name = <<<EOT
		IF(
			t1.crs2_coupon_id IS NOT NULL,
			' Lifetime ',
			IF(
				t1.crs2_bam_id IS not NULL,
				If(
					t1.crs2_bam_cpnam_id is NULL,
					' debug33 ',
					If(
						crs2_bam_expiry_date is NULL,
						' debug35 ',
						If(
							now() > crs2_bam_expiry_date,
							NULL,
							' debug38 '
						)
					)
				),
				If(
					t1.u_ispaid = 1,
					If(
						t1.um_id is NULL,
						NULL,
						If(
							t1.um_p_id is NULL,
							' debug43 ',
							If(
								um_expiry_date is NULL,
								' debug11 ',
								If(
									now() > um_expiry_date,
									NULL,
									If(
										t1.is_paid_membership_approved is NULL,
										' debug50 ',
										CASE t1.is_paid_membership_approved
											WHEN 0 THEN NULL
                                            WHEN 1 THEN package_name
                                            WHEN -1 THEN ' debug82 '
										ELSE ' debug82 ' END
									)
								)
							)
						)
					),
					NULL
				)
			)
		) AS membership_details_package_name
EOT;

		$this->_membership_details_expiry_date = <<<EOT
		IF(
			t1.crs2_coupon_id IS NOT NULL,
			NULL,
			IF(
				t1.crs2_bam_id IS not NULL,
				If(
					t1.crs2_bam_cpnam_id is NULL,
					' debug33 ',
					If(
						crs2_bam_expiry_date is NULL,
						' debug35 ',
						If(
							now() > crs2_bam_expiry_date,
							NULL,
							' debug38 '
						)
					)
				),
				If(
					t1.u_ispaid = 1,
					If(
						t1.um_id is NULL,
						NULL,
						If(
							t1.um_p_id is NULL,
							' debug43 ',
							If(
								um_expiry_date is NULL,
								' debug11 ',
								If(
									now() > um_expiry_date,
									NULL,
									If(
										t1.is_paid_membership_approved is NULL,
										' debug50 ',
										CASE t1.is_paid_membership_approved
											WHEN 0 THEN NULL
											WHEN 1 THEN
												If(
													um_expiry_date >= '9999-12-31 00:00:00',
													NULL,
													um_expiry_date
												)
											WHEN -1 THEN ' debug55 '
										ELSE ' debug56 ' END
									)
								)
							)
						)
					),
					NULL
				)
			)
		) AS membership_details_expiry_date
EOT;

		$this->_membership_details_expiry_date_csv = <<<EOT
		IF(
			t1.crs2_coupon_id IS NOT NULL,
			NULL,
			IF(
				t1.crs2_bam_id IS not NULL,
				If(
					t1.crs2_bam_cpnam_id is NULL,
					' debug33 ',
					If(
						crs2_bam_expiry_date is NULL,
						' debug35 ',
						If(
							now() > crs2_bam_expiry_date,
							NULL,
							' debug38 '
						)
					)
				),
				If(
					t1.u_ispaid = 1,
					If(
						t1.um_id is NULL,
						NULL,
						If(
							t1.um_p_id is NULL,
							' debug43 ',
							If(
								um_expiry_date is NULL,
								' debug11 ',
								um_expiry_date
							)
						)
					),
					NULL
				)
			)
		) AS membership_details_expiry_date_csv
EOT;

		$this->_validate_if_user_is_a_paid_member = <<<EOT
		IF(
			t1.crs2_coupon_id IS NOT NULL,
			true,
			IF(
				t1.crs2_bam_id IS not NULL,
				IF(
					t1.crs2_bam_cpnam_id is NULL,
					' debug6 ',
					IF(
						crs2_bam_expiry_date is NULL,
						' debug8 ',
						IF(
							now() > crs2_bam_expiry_date,
							false,
							' debug11 '
						)
					)
				),
				IF(
					t1.u_ispaid = 1,
					IF(
						t1.um_id is NULL,
						false,
						IF(
							t1.um_p_id is NULL,
							' debug9 ',
							IF(
								um_expiry_date is NULL,
								' debug11 ',
								IF(
									now() > um_expiry_date,
									false,
									IF(
										t1.is_paid_membership_approved is NULL,
										' debug15 ',
										CASE t1.is_paid_membership_approved
											WHEN 0 THEN false
											WHEN 1 THEN true
                                            WHEN -1 THEN ' debug19 '
										ELSE ' debug20 ' END
									)
								)
							)
						)
					),
					false
				)
			)
		) AS validate_if_user_is_a_paid_member
EOT;

		$this->_is_membership_pending_approval = <<<EOT
		IF(
			t1.crs2_coupon_id IS NOT NULL,
			NULL,
			IF(
				t1.crs2_bam_id IS not NULL,
				IF(
					t1.crs2_bam_cpnam_id is NULL,
					' debug158 ',
					IF(
						crs2_bam_expiry_date is NULL,
						' debug160 ',
						IF(
							now() > crs2_bam_expiry_date,
							NULL,
							' debug38 '
						)
					)
				),
				IF(
					t1.u_ispaid = 1,
					IF(
						t1.um_id is NULL,
						NULL,
						IF(
							t1.um_p_id is NULL,
							' debug43 ',
							IF(
								um_expiry_date is NULL,
								' debug11 ',
								IF(
									now() > um_expiry_date,
									NULL,
									IF(
										t1.is_paid_membership_approved is NULL,
										' debug50 ',
										CASE t1.is_paid_membership_approved
											WHEN 0 THEN true
											WHEN 1 THEN IF(
												um_expiry_date >= '9999-12-31 00:00:00',
												NULL,
												NULL
											)
											WHEN -1 THEN ' debug55 '
										ELSE ' debug56 ' END
									)
								)
							)
						)
					),
					NULL
				)
			)
		) as is_membership_pending_approval
EOT;
		
		$this->_is_membership_rejected = <<<EOT
		If(
			t1.is_paid_membership_approved is NULL,
			' debug50 ',
			CASE t1.is_paid_membership_approved
				WHEN 0 THEN NULL
				WHEN 1 THEN NULL
				WHEN -1 THEN true
			ELSE ' debug56 ' END
		) as is_membership_rejected
EOT;

		$this->_tables_joins = <<<EOT
		LEFT JOIN tb_conference_registration_master crm
			ON u.id = crm.userid and crm.conferenceid is NULL
		LEFT JOIN tb_conference_registration_screen_one crs1
			ON crs1.conferenceregistrationid = crm.id

		LEFT JOIN tb_conference_registration_screen_one_family_details crs1_fd_r1
			ON crs1_fd_r1.id = ( SELECT id from tb_conference_registration_screen_one_family_details where parentid = crs1.id limit 1 offset 0 )
		LEFT JOIN tb_conference_registration_screen_one_family_details crs1_fd_r2
			ON crs1_fd_r2.id = ( SELECT id from tb_conference_registration_screen_one_family_details where parentid = crs1.id limit 1 offset 1 )
		LEFT JOIN tb_conference_registration_screen_one_family_details crs1_fd_r3
			ON crs1_fd_r3.id = ( SELECT id from tb_conference_registration_screen_one_family_details where parentid = crs1.id limit 1 offset 2 )
		LEFT JOIN tb_conference_registration_screen_one_family_details crs1_fd_r4
			ON crs1_fd_r4.id = ( SELECT id from tb_conference_registration_screen_one_family_details where parentid = crs1.id limit 1 offset 3 )
		LEFT JOIN tb_conference_registration_screen_one_family_details crs1_fd_r5
			ON crs1_fd_r5.id = ( SELECT id from tb_conference_registration_screen_one_family_details where parentid = crs1.id limit 1 offset 4 )
		LEFT JOIN tb_conference_registration_screen_one_family_details crs1_fd_r6
			ON crs1_fd_r6.id = ( SELECT id from tb_conference_registration_screen_one_family_details where parentid = crs1.id limit 1 offset 5 )
		
		LEFT JOIN tb_conference_registration_screen_two crs2_coupon
			ON crs2_coupon.conferenceregistrationid = crm.id
				AND
			coupon_code = (SELECT imi_coupon_code FROM tb_site_settings_master)
		LEFT JOIN tb_conference_registration_screen_two crs2_bam
			ON crs2_bam.id = (
				SELECT t1.id FROM tb_conference_registration_screen_two t1
				WHERE t1.conferenceregistrationid = crm.id
					AND be_a_member = 1
				ORDER BY date_added DESC
				LIMIT 1
			)
		LEFT JOIN tb_conference_prices_not_a_member crs2_bam_cpnam
			ON crs2_bam_cpnam.id = crs2_bam.be_a_member_fee
		LEFT JOIN tb_user_memberships um
			ON um.id = (
				SELECT t1.id FROM tb_user_memberships t1
				WHERE t1.user_id = u.id
				ORDER BY IFNULL(
					member_expiry,
					`date_purchased`
				) DESC
				LIMIT 1
			)
		LEFT JOIN tb_conference_prices_not_a_member um_p
			ON um.membership_package_id = um_p.id
		LEFT JOIN tb_users_profile up
			ON up.userid = u.id
		LEFT JOIN tb_countries hc
			ON hc.id = up.home_country
		LEFT JOIN tb_countries oc
			ON oc.id = up.office_country
EOT;

		$this->_select_columns = <<<EOT
		SELECT
			u.id,
			u.prefix_title,
			LOWER(u.email) as email,
			u.name,
			u.middle_name,
			u.last_name,
			u.password,
			u.registration_site as registration_site,
			u.is_active,
			u.is_blocked,
			u.is_paid_membership_approved,
			crs2_bam.id	as crs2_bam_id,
			crs2_bam.be_a_member_fee,
			u.date_added,
			crs2_bam_cpnam.per,
			Computeexpirydate(
				crs2_bam_cpnam.per,
				crs2_bam.date_added
			) as crs2_bam_expiry_date,
			u.ispaid as u_ispaid,
			um.id as um_id,
			um.member_expiry,
			IFNULL(
				member_expiry,
				computeExpiryDate(
					IF(
						membership_package_per IS NULL or membership_package_per = ' ',
						um_p.per,
						membership_package_per
					),
					date_purchased
				)
			) AS um_expiry_date,
			IF(
				membership_package_name IS NULL or membership_package_name = ' ',
				um_p.name,
				membership_package_name
			) as package_name,
			crs2_coupon.id as crs2_coupon_id,
			um_p.id as um_p_id,
			um.member_since as member_since,
			crs2_bam_cpnam.id as crs2_bam_cpnam_id,
			crs2_coupon.coupon_code as crs2_coupon_coupon_code,
			crm.id as crm_id,
			crm.registration_site as crm_registration_site,
			crs1.id as crs1_id,
			(Select LOWER(name) from tb_family_relationships where id = crs1_fd_r1.family_relationship) as relation1,
			crs1_fd_r1.imi_id as relation1_imi_id,
			(Select LOWER(name) from tb_family_relationships where id = crs1_fd_r2.family_relationship) as relation2,
			crs1_fd_r2.imi_id as relation2_imi_id,
			(Select LOWER(name) from tb_family_relationships where id = crs1_fd_r3.family_relationship) as relation3,
			crs1_fd_r3.imi_id as relation3_imi_id,
			(Select LOWER(name) from tb_family_relationships where id = crs1_fd_r4.family_relationship) as relation4,
			crs1_fd_r4.imi_id as relation4_imi_id,
			(Select LOWER(name) from tb_family_relationships where id = crs1_fd_r5.family_relationship) as relation5,
			crs1_fd_r5.imi_id as relation5_imi_id,
			(Select LOWER(name) from tb_family_relationships where id = crs1_fd_r6.family_relationship) as relation6,
			crs1_fd_r6.imi_id as relation6_imi_id,
			up.cellphone_number,
			up.secondary_email_1,
			up.secondary_email_2,
			up.home_full_address,
			up.home_country,
			up.home_state_province,
			up.home_city,
			up.home_zipcode,
			up.home_phone_number,
			up.company_name,
			up.title,
			up.office_full_address,
			up.office_country,
			up.office_state_province,
			up.office_city,
			up.office_zip_code,
			up.office_phone_number,
			up.office_fax_number,
			up.occupation,
			up.specialties,
			up.prefered_mode_address,
			up.preffered_mode_of_contact,
			up.preffered_mode_of_email,
			up.membership,
			up.web_address,
			up.current_imi_title,
			up.institute_school,
			up.prefered_name,
			LOWER(up.gender) as gender,
			up.is_muslim,
			up.previous_title_with_imi,
			u.imi_id as imi_id,
			up.record_last_update_on,
			up.business_individual,
			up.comments,
			hc.countries_name as home_country_name,
			oc.countries_name as office_country_name
		FROM tb_users u
EOT;

		$this->_fullquery = <<<EOT
		CREATE OR REPLACE VIEW users_view AS SELECT * FROM (
			SELECT * FROM (
				SELECT *, $this->_validate_if_user_is_a_paid_member , $this->_membership_details_expiry_date,$this->_membership_details_expiry_date_csv,$this->_membership_detaials_package_name,$this->_is_paid_membership_expired,$this->_is_membership_pending_approval,$this->_is_membership_rejected FROM (
					$this->_select_columns $this->_tables_joins
				) t1
			) t2 order by id, validate_if_user_is_a_paid_member desc, crs2_coupon_id desc, is_membership_expired desc
		) t3 group by t3.id
EOT;

		//$this->db_imiconf->query('DROP TABLE IF EXISTS `generated_imi_ids`');
		$this->db_imiconf->query('CREATE TABLE IF NOT EXISTS generated_imi_ids (imi_id bigint NOT NULL AUTO_INCREMENT, user_id int(11) NULL, family_id int(11) NULL, PRIMARY KEY (imi_id), INDEX (`user_id`,`family_id`))');
		//$this->db_imiconf->query('ALTER TABLE generated_imi_ids ADD INDEX (`user_id`,`family_id`)');
		$this->db_imiconf->query('INSERT INTO generated_imi_ids (user_id,family_id) SELECT id as user_id,null as family_id from tb_users where imi_id IS NULL or imi_id = "0" and imi_id UNION SELECT null as user_id,id as family_id from tb_conference_registration_screen_one_family_details where imi_id IS NULL or imi_id = "0"');
		$this->db_imiconf->query('UPDATE tb_users u,generated_imi_ids gii SET u.imi_id = CONCAT("autogenerated_",gii.imi_id) Where u.id = gii.user_id');
		$this->db_imiconf->query('UPDATE tb_conference_registration_screen_one_family_details crs1_fd,generated_imi_ids gii SET crs1_fd.imi_id = CONCAT("autogenerated_",gii.imi_id) WHERE crs1_fd.id = gii.family_id');
		//$this->db_imiconf->query('DROP TABLE IF EXISTS `generated_imi_ids`');

		// $this->db_imiconf->query($this->_fullquery);

	}


    public function view_table_properties()
    {
        $tmp["tr_heading"] = array('Name', 'Last Name', 'Email', 'Password', 'Registration Site', 'Membership Package', 'Paid Membership Status', 'Member Status', 'Member Blocking Status', 'Date Added');

        return $tmp;
    }

    public function view($is_ajax = 0)
    {
        $data = $this->data;
        if ($is_ajax) {


            $tmp_columns[] = array(
                'db' => 'name',
                "where" => "name", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
                'dt' => 1,
            );

            $tmp_columns[] = array(
                'db' => 'last_name',
                "where" => "last_name", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
                'dt' => 2,
            );

            $tmp_columns[] = array(
                'db' => 'email',
                "where" => "email", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
                'dt' => 3,
            );

            $tmp_columns[] = array(
                'db' => 'password',
                "where" => "password", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
                'formatter' => function ($d, $row, $CI) {

                    return $this->encrption->decrypt($row['password']);
                },
                'dt' => 4,
            );

            $tmp_columns[] = array(
                'db' => 'registration_site',
                "where" => "registration_site", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
                'dt' => 5,
            );
			
			$tmp_columns[] = array(
                'db' => 'package_name',
                "where" => "package_name", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
                'dt' => 6,
            );

            $tmp_columns[] = array(
				'db' => 'is_paid_membership_approved',
				"where" => " (CASE when is_membership_expired IS NOT NULL then 'Membership expired' when is_membership_pending_approval IS NOT NULL then 'Membership pending approval' when is_membership_rejected IS NOT NULL then 'Membership rejected' when validate_if_user_is_a_paid_member = 1 and is_membership_expired IS NULL and is_membership_pending_approval IS NULL and is_membership_rejected IS NULL then 'Membership approved' else 'Unpaid' END ) ",
                // TODO: Confirm (from Muslim?) whether we need the `where` key here.
                'formatter' => function ($d, $row, $CI) {
                    $show_approve_and_reject_options = false;
					$paid_membership_status_text = null;
					if ($this->functions->validate_if_user_is_a_paid_member($row['id'], $is_membership_expired, $is_membership_pending_approval, $is_membership_rejected)) {
						$paid_membership_status_text = 'Membership approved';
					} else {
						if ($is_membership_expired) {
							$paid_membership_status_text = 'Membership expired';
						} else {
							if ($is_membership_pending_approval) {
								$show_approve_and_reject_options = true;
								$paid_membership_status_text = 'Membership pending approval';
							} else {
								if ($is_membership_rejected) {
									$paid_membership_status_text = 'Membership rejected';
								} else {
									$paid_membership_status_text = 'Unpaid';
								}
							}
						}
					}
                    
                    $paid_membership_status_text_and_options_ui = (
                        $paid_membership_status_text .
                        (
                        $show_approve_and_reject_options ?
                            (
                                ' ' .
                                (
                                    '<a href="javascript:" data-action="approve" data-user-id="' .
                                    $row['id'] .
						'" class="paid_membership_status_change_link" data-operationid="manageuserspaidstatus"><input type="button" class="btn btn-success btn-xs" name="paid_membership_status" value="Approve"/></a>' .
                                    ' ' .
                                    '<a href="javascript:" data-action="reject" data-user-id="' .
                                    $row['id'] .
						'" class="paid_membership_status_change_link" data-operationid="manageuserspaidstatus"><input type="button" class="btn btn-danger btn-xs" name="paid_membership_status" value="Reject"/></a>'
                                )
                            ) :
                            ''
                        )
                    );
                    return $paid_membership_status_text_and_options_ui;
                },
                'dt' => 7,
            );
			
            $tmp_columns[] = array(
                'db' => 'is_active',
				#"where" => "is_active", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
				"where" => " (CASE when is_active = 1 then '*Activated' else 'In-Activated' END ) ",
                'formatter' => function ($d, $row, $CI) {
					$btn_class = $row["is_active"] == 0 ? 'success' : 'danger';
                    return (
                        ($row["is_active"] == 0 ? "In-Activated" : "*Activated") .
                        ' ' .
                        (
                            '<a href="javascript:" data-user-id="' .
                            $row['id'] .
						'" class="member_status_toggle_link" data-operationid="manageusersstatus"><input type="button" class="btn btn-'.$btn_class.' btn-xs" name="status" value="' .
                            (
                            $row["is_active"] == 0 ?
                                "*Activated" :
                                "In-Activated"
                            ) .
                            '"/></a>'
                        )
                    );
                },
                'dt' => 8,
			);
			
			$tmp_columns[] = array(
                'db' => 'is_blocked',
				#"where" => "is_blocked", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
				"where" => " (CASE when is_blocked = 1 then '*Block' else 'Un-block' END ) ",
                'formatter' => function ($d, $row, $CI) {
					$btn_class = $row["is_blocked"] == 0 ? 'success' : 'danger';
                    return (
                        ($row["is_blocked"] == 0 ? "Un-block" : "*Block") .
                        ' ' .
                        (
                            '<a href="javascript:" data-user-id="' .
                            $row['id'] .
                        '" class="member_blocking_status_toggle_link" data-operationid="manageusersblockingstatus"><input type="button" class="btn btn-'.$btn_class.' btn-xs" name="status" value="' .
                            (
                            $row["is_blocked"] == 0 ?
                                "*Block" :
                                "Un-block"
                            ) .
                            '"/></a>'
                        )
                    );
                },
                'dt' => 9,
            );

            $tmp_columns[] = array(
                'db' => 'date_added',
                "where" => "date_added", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
                'dt' => 10,
            );


            $columns = SSP::append_columns($tmp_columns, array("id", "id"), array(0,11));
			$primaryKey = 'id';

			$where = '';
			if ( !$this->is_superadmin ){
				
				$allowed_countries = $this->admin_allowed_countries;
				
				if ( $allowed_countries != "" && NULL != $allowed_countries ){
					$where = ' and home_country IN ( '.$allowed_countries.' ) ';
				}else{
					$where = ' and ( home_country is NULL or home_country = 0 )';
				}
			}
			$table = "( SELECT * FROM users_view where 1=1 $where ) t0 where 1=1";

			#(for sort)#' (package_name is NULL),FIELD(is_paid_membership_approved,0,1,-1) ASC,(package_name is NOT NULL),FIELD(is_paid_membership_approved,0,1,-1),ID '
            echo json_encode(SSP::simple($_POST, $table, $primaryKey, $columns, array(), $this->db_imiconf));

        } else {


            $data["table_record"] = $this->imiconf_queries->fetch_records_imiconf("users", " ORDER BY id DESC ");

            $data["table_properties"] = $this->view_table_properties();
            $this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
        }


	}
	
	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $data["_directory"] . "edit.php";

		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
	}
	
	
	/* public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		



	
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		

		$this->form_validation->set_rules("first_name", "First Name", "trim|required");
		$this->form_validation->set_rules("middle_name", "Middle Name", "trim");
		$this->form_validation->set_rules("last_name", "Last Name", "trim|required");
		
		$this->form_validation->set_rules("password", "Password", "trim|required");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("roleid", "Role", "trim|required");
		
		
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			
	
			$saveData											= array("username"					=> $this->input->post("username"),
																		"password"					=> $this->encrption->encrypt ( $this->input->post("password") ),
																		"email"						=> $this->input->post("email"),
																		"profile_image"				=> $this->input->post("profile_image"),
																		"roleid"					=> $this->input->post("roleid")
																		);		
			
			
			

			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_admin", 'id');  
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_admin", 'id');  		
				$saveData['id']										= $this->db->insert_id();
			}
			

		
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	} */

	public function save()
	{
		$data														= $this->data;

        $languages													= $data["languages"];
        
        if (! $this->validations->is_post()) {
            redirect(site_url($data["_directory"] . "controls/view"));
        }
        
    
        #re-unite post values + language array with form_validations
        $this->functions->unite_post_values_form_validation();
	
		$this->form_validation->set_rules('id', 'User Id', 'required');
		$this->form_validation->set_rules('imi_id', 'IMI ID', 'required|callback_check_imi_id_exists['.$this->input->post('id').']');
		$this->form_validation->set_rules('prefix_title', 'Salutation', 'trim');
		$this->form_validation->set_rules('name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		
		$this->form_validation->set_rules('cellphone_number', 'Cellphone Number', 'trim');
		//$this->form_validation->set_rules('secondary_email_1', 'Secondary Email 01', 'trim|valid_email');
		//$this->form_validation->set_rules('secondary_email_2', 'Secondary Email 02', 'trim|valid_email');
		
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
		
		$this->form_validation->set_rules("password", "Password", "trim|xss_clean");
		$this->form_validation->set_rules("membership_date_purchased", "Membership Start Date", "callback_validate_formatted_date");
		$this->form_validation->set_rules("membership_expiry", "Membership End Date", "callback_validate_formatted_date");
					
		if( $this->form_validation->run() == FALSE )
		{
			

			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['tmp_name'] != "") {
            
                #################################
                ###  	upload_image_1  	  ###
                #################################
                $other_upload						= array("validate"											=> true,
                                                            "input_field"										=> "profile_image",
                                                            "db_field"											=> "profile_image",
                                                            "input_nick"										=> "Image",
                                                            "hdn_field"											=> "profile_image",
                                                            "tmp_table_field"									=> "profile_image",
                                                            "is_multiple"										=> false
                                                        );
                    
                $config_image						= array(
                                                            "upload_path"										=> $this->data["images_dir"],
                                                            "allowed_types"										=> $this->data['images_types'],
                                                            "encrypt_name"										=> true
                                                        );
                
                $config_thumb						= array();
                
                    
                $tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);

                if ($tmp_upload_image_1['reason'] != "pass") {
					
					$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
					$data['_messageBundle']								= $this->_messageBundle('danger', $tmp_upload_image_1['msg'], 'Error!');
					$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
                }
			}

			if  (  strpos($_POST['imi_id'],'autogenerated') !== false ){
				$imi_id = (int) filter_var($_POST['imi_id'], FILTER_SANITIZE_NUMBER_INT);

				$q = $this->db_imiconf->query('Select user_id From generated_imi_ids Where user_id = '.$this->input->post("id"));

				$generatedData					= array(
					"user_id"					=> $this->input->post("id"),
					"imi_id"					=> $imi_id
				);
				if ( $q->num_rows() > 0 ){
					$this->queries->SaveDeleteTables_imiconf($generatedData, 'e', "generated_imi_ids", 'user_id');
				}else{
					$this->queries->SaveDeleteTables_imiconf($generatedData, 's', "generated_imi_ids", 'user_id');
				}

			}else{
				$q = $this->imiconf_queries->fetch_records_imiconf('users', ' and id = '.$this->input->post("id"), 'imi_id');
				if ( $q->num_rows() > 0 ){
					if  ( strpos($q->row()->imi_id,'autogenerated') !== false ){
						$delData = array(
							'user_id' => $this->input->post("id")
						);
						$this->queries->SaveDeleteTables_imiconf($delData,'d','generated_imi_ids',"user_id");
					}
				}
			}

			$insertData					= array("id"					=> $this->input->post("id"),
												"imi_id"				=> $this->input->post("imi_id"),
												"prefix_title"			=> $this->input->post("prefix_title"),
												"name"					=> $this->input->post("name"),
												"middle_name"			=> $this->input->post("middle_name"),
												"last_name"				=> $this->input->post("last_name"),
												"registration_site"		=> $this->input->post("registration_site"),
												"is_active"				=> $this->input->post("is_active"),
												"is_blocked"			=> $this->input->post("is_blocked"),
												"ispaid"				=> $this->input->post("ispaid"),
												"password"				=> $this->encrption->encrypt($this->input->post("password"))
											);

			$this->queries->SaveDeleteTables_imiconf($insertData, 'e', "tb_users", 'id');

			$user_profile_Data = array(
				"userid" => $this->input->post("id"),
				"cellphone_number" => $this->input->post("cellphone_number"),
				"secondary_email_1" => $this->input->post("secondary_email_1"),
				"secondary_email_2" => $this->input->post("secondary_email_2"),

				"home_full_address" => $this->input->post("home_full_address"),
				"home_country" => $this->input->post("home_country"),
				"home_state_province" => $this->input->post("home_state_province"),
				"home_city" => $this->input->post("home_city"),
				"home_phone_number" => $this->input->post("home_phone_number"),

				"home_zipcode" => $this->input->post("home_zipcode"),
				"office_zip_code" => $this->input->post("office_zip_code"),

				"office_full_address" => $this->input->post("office_full_address"),
				"office_country" => $this->input->post("office_country"),
				"office_state_province" => $this->input->post("office_state_province"),
				"office_city" => $this->input->post("office_city"),
				"office_phone_number" => $this->input->post("office_phone_number"),


				"occupation" => $this->input->post("occupation"),
				"specialties" => $this->input->post("specialties"),

				"prefered_mode_address" => $this->input->post("prefered_mode_address"),
				"preffered_mode_of_contact" => $this->input->post("preffered_mode_of_contact"),
				"preffered_mode_of_email" => $this->input->post("preffered_mode_of_email"),



				"previous_title_with_imi" => $this->input->post("previous_title_with_imi"),
				"current_imi_title" => $this->input->post("current_imi_title"),
				"institute_school" => $this->input->post("institute_school"),
				"gender" => $this->input->post("gender"),
				"web_address" => $this->input->post("web_address"),

				"date_added" => date("Y-m-d")
			);
			
			if (isset($tmp_upload_image_1['hdn_array']['profile_image'])) {
				$user_profile_Data['profile_image'] = $this->data['images_dir'] . $tmp_upload_image_1['hdn_array']['profile_image'];
			}
			
			
			$user_profile = $this->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = ". $this->input->post("id"));
			if ( $user_profile->num_rows() > 0 ){
				$this->queries->SaveDeleteTables_imiconf($user_profile_Data, 'e', "tb_users_profile", 'userid');
			}else{
				$this->queries->SaveDeleteTables_imiconf($user_profile_Data, 's', "tb_users_profile", 'id');
			}
			
			if ( isset( $_POST['membership_package_id'] ) ){

				if ( $_POST['membership_package_id'] == "" ){
					$user_membership_Data = array(
						"user_id" => $this->input->post("id")
					);
					$this->queries->SaveDeleteTables_imiconf($user_membership_Data, 'd', "tb_user_memberships", 'user_id');
					
					$user_membership_Data = array(
						'id' =>  $this->input->post("id"),
						'is_paid_membership_approved' => 0,
					);
					
					$this->queries->SaveDeleteTables_imiconf($user_membership_Data, 'e', "tb_users", 'id');

				}else{

					$package_name = $this->imiconf_queries->fetch_records_imiconf('conference_prices_not_a_member', ' and id = '.$this->input->post("membership_package_id"));
                
					$user_membership_Data = array(
						"user_id" => $this->input->post("id"),
						"membership_package_id" => $this->input->post("membership_package_id"),
						"membership_package_name" => $package_name->row()->name,
						"membership_package_price" => $package_name->row()->price,
						"membership_package_per" => $package_name->row()->per,
						"manually_approved"	=> 1
					);
					$user_memberships = $this->imiconf_queries->fetch_records_imiconf("user_memberships", " AND user_id = ". $this->input->post("id"));
					if ($user_memberships->num_rows() > 0) {
						$user_membership_Data['id'] = $user_memberships->row()->id;
						if ( isset($_POST['membership_date_purchased']) ){
							$user_membership_Data['id'] = $_POST[ 'membership_id'];
							$user_membership_Data['date_purchased'] = $_POST['membership_date_purchased'];
						}
						if ( isset($_POST['membership_expiry']) ){
							$user_membership_Data[ 'member_expiry'] = $_POST[ 'membership_expiry'];
						}
						$this->queries->SaveDeleteTables_imiconf($user_membership_Data, 'e', "tb_user_memberships", 'id');
					} else {
						$user_membership_Data['date_purchased'] = date('Y-m-d H:i:s');
						if (isset($_POST['membership_date_purchased'])) {
							$user_membership_Data['date_purchased'] = $_POST['membership_date_purchased'];
						}
						if (isset($_POST['membership_expiry'])) {
							$user_membership_Data['member_expiry'] = $_POST['membership_expiry'];
						}
						$this->queries->SaveDeleteTables_imiconf($user_membership_Data, 's', "tb_user_memberships", 'id');
					}
				}
			}

			$data['_messageBundle']									= $this->_messageBundle(
				'success' ,
																							"Your profile settings updated.",
																							lang_line("heading_operation_success"),
																							false,
																							true
			);
			
			redirect($data["_directory"] . "controls/view");
		}		
	}
	
	public function _create_fields_for_form_2( $return_array = false, &$data, $db_data = array() )
	{

		$empty_inputs = array("profile_image", "cellphone_number", "secondary_email_1", "secondary_email_2", "home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", "web_address", "current_imi_title", "institute_school", "gender", "previous_title_with_imi", "office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", "occupation", "specialties", "preffered_mode_of_contact", "prefered_mode_address", "preffered_mode_of_email", "home_zipcode", "office_zip_code"/*, "other_member_can_see_profile"*/ );

		$filled_inputs = array("profile_image", "cellphone_number", "secondary_email_1", "secondary_email_2", "home_full_address", "home_country", "home_state_province", "home_city", "home_phone_number", "web_address", "current_imi_title", "institute_school", "gender", "previous_title_with_imi", "office_full_address", "office_country", "office_state_province", "office_city", "office_phone_number", "occupation", "specialties", "preffered_mode_of_contact", "prefered_mode_address", "preffered_mode_of_email", "home_zipcode", "office_zip_code"/*, "other_member_can_see_profile"*/ );
		
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
	
	public function _create_fields_for_form_3( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "address", "city", "state_province", "postal_code", "country" );
		
		$filled_inputs				= array( "address", "city", "state_province", "postal_code", "country" );
		
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
				
				$data['officedetails'][ $empty_inputs[$x] ]		= $tmp_value;
				
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
				
				$data['officedetails'][ $empty_inputs[$x] ]		= $tmp_value;
			}
			
			return $data;
		
		}
	}
	
	public function _create_fields_for_form_4( $return_array = false, &$data, $db_data = array() )
	{
		
		$empty_inputs				= array("id","family_relationship","family_relationship_name", "family_name", "family_email", "family_age", "family_birthdate");
		
		$filled_inputs				= array("id","family_relationship","family_relationship_name", "family_name", "family_email", "family_age", "family_birthdate");

		
		if ($return_array == true)
		{
			$family = array();
			foreach ( $db_data as $k => $dd ){
			
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
					$empty_inputs[$x]				= $explode_empty_inputs[0];
					$tmp_value						= $db_data[$k][ $filled_inputs[$x] ];
					
					$family[$k][ $empty_inputs[$x] ]		= $tmp_value;
				}
			}

			$data['family'] = $family;
			return $data;
		}
		else
		{
		
			$family = array();
            foreach ($db_data as $k => $dd) {
                for ($x=0;  $x < count($empty_inputs); $x++) {
                    $explode_empty_inputs			= explode("|", $empty_inputs[$x]);
                    $empty_inputs[$x]				= $explode_empty_inputs[0];
                    $tmp_value						= "";
                    
                    $family[$k][ $empty_inputs[$x] ]		= $tmp_value;
                }
            }
            
            $data['family'] = $family;
            return $data;
		}
	}
	
	public function _create_fields_for_form_5( $return_array = false, &$data, $db_data = array() )
	{
		
		$empty_inputs				= array("document", "uploaded_on", "document_type");
		
		$filled_inputs				= array("document", "uploaded_on", "document_type");
		
		if ($return_array == true)
		{
			$document = array();
			foreach ( $db_data as $k => $dd ){
			
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
					$empty_inputs[$x]				= $explode_empty_inputs[0];
					$tmp_value						= $db_data[$k][ $filled_inputs[$x] ];
					
					$document[$k][ $empty_inputs[$x] ]		= $tmp_value;
				}
			}

			$data['document'] = $document;
			return $data;
		}
		else
		{
		
			$document = array();
            foreach ($db_data as $k => $dd) {
                for ($x=0;  $x < count($empty_inputs); $x++) {
                    $explode_empty_inputs			= explode("|", $empty_inputs[$x]);
                    $empty_inputs[$x]				= $explode_empty_inputs[0];
                    $tmp_value						= "";
                    
                    $document[$k][ $empty_inputs[$x] ]		= $tmp_value;
                }
            }
            
            $data['document'] = $document;
            return $data;
		}
	}
	
	public function _create_fields_for_form_6( $return_array = false, &$data, $db_data = array() )
	{
		
		$empty_inputs				= array("paypal_post");
		
		$filled_inputs				= array("paypal_post");
		
		if ($return_array == true)
		{
			$payment = array();
			foreach ( $db_data as $k => $dd ){
			
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
					$empty_inputs[$x]				= $explode_empty_inputs[0];
					$tmp_value						= $db_data[$k][ $filled_inputs[$x] ];
					
					$payment[$k][ $empty_inputs[$x] ]		= $tmp_value;
				}
			}

			$data['payment'] = $payment;
			return $data;
		}
		else
		{
		
			$payment = array();
            foreach ($db_data as $k => $dd) {
                for ($x=0;  $x < count($empty_inputs); $x++) {
                    $explode_empty_inputs			= explode("|", $empty_inputs[$x]);
                    $empty_inputs[$x]				= $explode_empty_inputs[0];
                    $tmp_value						= "";
                    
                    $payment[$k][ $empty_inputs[$x] ]		= $tmp_value;
                }
            }
            
            $data['payment'] = $payment;
            return $data;
		}
	}

	public function _create_fields_for_form_9($return_array = false, &$data, $db_data = array())
	{

		$empty_inputs			= array("name", "email", "amount", "transaction_id", "date");

		$filled_inputs			= array("first_name", "email", "donate_amount", "transaction_id", "date_added");

		if ($return_array == true) {
			$card_payment = array();
			foreach ($db_data as $k => $dd) {

				for ($x = 0; $x < count($empty_inputs); $x++) {
					$explode_empty_inputs			= explode("|", $empty_inputs[$x]);
					$empty_inputs[$x]				= $explode_empty_inputs[0];
					$tmp_value						= $db_data[$k][$filled_inputs[$x]];

					$card_payment[$k][$empty_inputs[$x]]		= $tmp_value;
				}
			}

			$data['card_payment'] = $card_payment;
			return $data;
		} else {

			$card_payment = array();
			foreach ($db_data as $k => $dd) {
				for ($x = 0; $x < count($empty_inputs); $x++) {
					$explode_empty_inputs			= explode("|", $empty_inputs[$x]);
					$empty_inputs[$x]				= $explode_empty_inputs[0];
					$tmp_value						= "";

					$card_payment[$k][$empty_inputs[$x]]		= $tmp_value;
				}
			}

			$data['card_payment'] = $card_payment;
			return $data;
		}
	}

	public function _create_fields_for_form_7($return_array = false, &$data, $db_data = array())
	{

		$empty_inputs = array("id","name");

		$filled_inputs = array("id", "name");

		if ($return_array == true) {
			$family_relationships = array();
			foreach ($db_data as $k => $dd) {

				for ($x = 0; $x < count($empty_inputs); $x++) {
					$explode_empty_inputs = explode("|", $empty_inputs[$x]);
					$empty_inputs[$x] = $explode_empty_inputs[0];
					$tmp_value = $db_data[$k][$filled_inputs[$x]];

					$family_relationships[$k][$empty_inputs[$x]] = $tmp_value;
				}
			}

			$data['family_relationships'] = $family_relationships;
			return $data;
		} else {

			$family_relationships = array();
			foreach ($db_data as $k => $dd) {
				for ($x = 0; $x < count($empty_inputs); $x++) {
					$explode_empty_inputs = explode("|", $empty_inputs[$x]);
					$empty_inputs[$x] = $explode_empty_inputs[0];
					$tmp_value = "";

					$family_relationships[$k][$empty_inputs[$x]] = $tmp_value;
				}
			}

			$data['family_relationships'] = $family_relationships;
			return $data;
		}
	}
	
	public function _create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{		
		$empty_inputs				= array("relationship", "name", "age", "document", "uploaded_on", "document_type", "paypal_post");
		
		$filled_inputs				= array("relationship", "name", "age", "document", "uploaded_on", "document_type", "paypal_post");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				
				for ($m=0; $m < count($db_data); $m++)
				{

					if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					{
						
						$data[ $empty_inputs[$x] ][ $m ]	= $db_data[$m][ $filled_inputs[$x] ];
						#$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
						
					}
				}
				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			#$this->form_validation->run();
		
		
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ][] = '';
			}
			
			return $data;
		
		}

	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "imi_id", "prefix_title", "name", "middle_name", "last_name", "email", "password", "registration_site", "activation_code", "is_active", "is_blocked","ispaid", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "imi_id", "prefix_title", "name", "middle_name", "last_name", "email", "password", "registration_site", "activation_code", "is_active", "is_blocked", "ispaid", "options", "unique_formid" );
		
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
	public function _create_fields_for_form_8( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "membership_id","membership_package_id" , 'membership_date_purchased', 'membership_expiry' );
		
		$filled_inputs				= array( "id","membership_package_id", 'date_purchased', 'member_expiry' );
		
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
	

	
	public function edit( $edit_id )
	{
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												=  $this->imiconf_queries->fetch_records_imiconf("users", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		$edit_details['password']									= $this->encrption->decrypt ( $edit_details['password'] );


		
		$this->_create_fields_for_form(true, $data, $edit_details );

		$user_memberships = $this->imiconf_queries->fetch_records_imiconf("user_memberships", " AND user_id = '$edit_id' ORDER BY id DESC LIMIT 1");
        
        if ($user_memberships->num_rows() > 0) {
			$this->_create_fields_for_form_8(true, $data, $user_memberships->row_array());
        }

		$users_profile = $this->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = '$edit_id' ");
		
		if ($users_profile->num_rows() > 0) {
			$this->_create_fields_for_form_2(true, $data, $users_profile->row_array());
		}
		
		$user_family_details = $this->imiconf_queries->fetch_records_imiconf("user_family_details"," and parentid IN ( Select id From tb_conference_registration_screen_one Where conferenceregistrationid IN ( Select id From tb_conference_registration_master Where conferenceid is NULL and registration_site = 'IMI_FAMILY_MEMBER' and userid = '$edit_id' ) ) ");
		
		if ( $user_family_details->num_rows() > 0 ){
			$this->_create_fields_for_form_4(true, $data, $user_family_details->result_array());
		}
		
		$family_relationships = $this->imiconf_queries->fetch_records_imiconf("family_relationships");
		if ($family_relationships->num_rows() > 0 ){
			$this->_create_fields_for_form_7(true, $data, $family_relationships->result_array());
		}

		/* $user_documents = $this->imiconf_queries->fetch_records_imiconf("conference_registration_excel_documents", " AND user_id = '$edit_id' ");
        
        if ($user_documents->num_rows() > 0) {
            $this->_create_fields_for_form_5(true, $data, $user_documents->result_array());
		} */

		$conference_payments = $this->db_imiconf->query('Select paypal_post from imi_conf_restore2.tb_conference_payments where conference_registration_id IN ( select id from imi_conf_restore2.tb_conference_registration_master where userid = ' . $edit_id . ' ) UNION ALL Select paypal_post from imi_conf_restore2.tb_abstract_submission_form_payments where abstractformid IN ( select id from imi_conf_restore2.tb_abstract_submission_form where userid = ' . $edit_id . ' ) UNION ALL select paypal_post from imiportal_2.tb_paypal_payments Where payment_id IN ( SELECT id from imiportal_2.tb_donation_payments where user_id IN ( ' . $edit_id . ' )) UNION ALL select paypal_post from tb_user_memberships where user_id IN ( ' . $edit_id . ' )');

		if ($conference_payments->num_rows() > 0) {
			$this->_create_fields_for_form_6(true, $data, $conference_payments->result_array());
		}

		$card_donations = $this->db_imiconf->query("select cp.transaction_id,df.first_name,df.email,df.donate_amount,df.date_added from imiportal_2.tb_card_payments cp JOIN imiportal_2.tb_donation_payments dp ON dp.id = cp.payment_id and dp.user_id = " . $edit_id . " LEFT JOIN imiportal_2.tb_donation_form df ON df.id = dp.table_id_value and dp.table_id_name = 'id' and dp.table_name = 'tb_donation_form'");
		if ($card_donations->num_rows() > 0) {
			$this->_create_fields_for_form_9(true, $data, $card_donations->result_array());
		}
		


		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
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
			$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'd', "tb_users", 'id') ;
			//$this->queries->SaveDeleteTables($saveData, 'd', "tb_admin", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}

    public function toggleMemberStatus()
    {
        $user_row = $this->getUserFromPostData();
        $current_user_status = $user_row['is_active'];
        $current_status_to_new_status_map = array(
            0 => 1,
            1 => 0,
        );
        if (!isset($current_status_to_new_status_map[$current_user_status])) {
            show_error('Invalid current user status.');
        }
        $new_user_status = $current_status_to_new_status_map[$current_user_status];
        $new_status_saved = $this->db_imiconf->query(
            'update tb_users set is_active= ? where id = ? limit 1',
            array(
                $new_user_status,
                $user_row['id'],
            )
        );
        if (!$new_status_saved) {
            show_error('New user status couldn\'t be saved.');
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array(
            'success' => true,
        )));
    }

	public function toggleMemberBlockingStatus()
    {
        $user_row = $this->getUserFromPostData();
        $current_user_status = $user_row['is_blocked'];
        $current_status_to_new_status_map = array(
            0 => 1,
            1 => 0,
        );
        if (!isset($current_status_to_new_status_map[$current_user_status])) {
            show_error('Invalid current user blocking status.');
        }
        $new_user_status = $current_status_to_new_status_map[$current_user_status];
        $new_status_saved = $this->db_imiconf->query(
            'update tb_users set is_blocked= ? where id = ? limit 1',
            array(
                $new_user_status,
                $user_row['id'],
            )
        );
        if (!$new_status_saved) {
            show_error('New user blocking status couldn\'t be saved.');
        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array(
            'success' => true,
        )));
    }

    public function changePaidMembershipStatus()
    {
        $action = $this->input->post('action');
        if (
            (!$action) ||
            (!in_array($action, array(
                'approve',
                'reject',
            ))) ||
            false
        ) {
            show_error('Invalid action.');
        }
        $user_row = $this->getUserFromPostData();
        $is_user_a_paid_member = $this->functions->validate_if_user_is_a_paid_member($user_row['id'], $is_membership_expired, $is_membership_pending_approval, $is_membership_rejected);
        if (
            ($is_user_a_paid_member) ||
            ($is_membership_expired) ||
            (!$is_membership_pending_approval) ||
            ($is_membership_rejected) ||
            false
        ) {
            show_error('User not eligible for action.');
        }
        $action_to_db_field_value_map = array(
            'approve' => 1,
            'reject' => -1,
        );
        if (!isset($action_to_db_field_value_map[$action])) {
            show_error('Failed to map action to DB field.');
        }
        $new_db_field_value = $action_to_db_field_value_map[$action];
        $new_paid_membership_status_saved = $this->db_imiconf->query(
            'update tb_users set is_paid_membership_approved= ? where id = ? limit 1',
            array(
                $new_db_field_value,
                $user_row['id'],
            )
        );
        if (!$new_paid_membership_status_saved) {
            show_error('New user paid membership status couldn\'t be saved.');
        }
        $action_to_email_content_map = array(
            'approve' => <<<EOD
Hi {name},

Congratulations, your paid Imamia Medics International membership has been approved.

Thanks,

IMI Team.
EOD
        ,
            'reject' => <<<EOD
Hi {name},

Thank you for your interest in registering for Imamia Medics International. As per IMI policy, admin is not able to approve your membership request. Please contact {rejection_contact_email} for more details.

Thanks,

IMI Team.
EOD
        ,
        );
        if (!isset($action_to_email_content_map[$action])) {
            show_error('Email content not defined for the action?');
        }
        $string_template_engine = new \StringTemplate\Engine;
        $email_content = $string_template_engine->render($action_to_email_content_map[$action], array(
            'name' => self::user_row_to_displayable_name($user_row),
            'rejection_contact_email' => 'imihq@imamiamedics.com',
        ));
        $action_to_email_subject_map = array(
            'approve' => 'IMI membership approved!',
            'reject' => 'IMI membership not approved.',
        );
        if (!isset($action_to_email_subject_map[$action])) {
            show_error('Email subject not defined for the action?');
		}

		$profile_data											= $this->imiconf_queries->fetch_records_imiconf('users_profile', ' AND userid= "' . $user_row['id'] . '"');
		$home_country = $profile_data->row()->home_country;
		if ( NULL != $home_country && $home_country != 0 ){
			$__where = " and ( roleid = 4 or countryid is NULL or countryid LIKE '%".$profile_data->row()->home_country."%' ) ";
		}else{
			$__where = "";
		}
		$admins = $this->queries->fetch_records("admin",$__where,"email");
		$admin_emails = array();
		
		if ( $admins->num_rows() > 0 ){
			foreach ($admins->result() as $key => $value) {
				$admin_emails[] = $value->email;
			}
		}
		
		$localhost = array('127.0.0.1', "::1");
		if (!in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
			$_finance = array('IMIFinance786@gmail.com','RomeenaIMI@Gmail.com');
		} else {
			$_finance = array();
		}
		
		$_BCCUSER_EMAILS = array_merge($_finance, $admin_emails);

		$this->email(array(
            'to' => array(
				$user_row['email']
			),
            'bcc' => $_finance,
            'message' => nl2br($email_content),
            'subject' => $action_to_email_subject_map[$action],
            'from' => 'noreply@imamiamedics.com',
        ));
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array(
            'success' => true,
        )));
    }

    protected function getUserFromPostData()
    {
        $user_id = $this->input->post('userId');
        if (!$user_id) {
            show_error('Invalid user id.');
        }
        /** @var CI_DB_mysqli_result $user_query */
        $user_query = $this->db_imiconf->query(
            'select * from tb_users where id = ?',
            array(
                $user_id,
            )
        );
        if ($user_query->num_rows() != 1) {
            show_error('User not found.');
        }
        $user_row = $user_query->row_array();
        unset($user_query);
        return $user_row;
	}
	
	public function export(){

		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$q = <<<EOT
		SELECT * FROM (
			(
				SELECT
					imi_id as 'IMI ID',
					prefix_title as Title,
					name AS 'First Name',
					middle_name AS 'Middle Name',
					last_name as 'Last Name',
					CONCAT(relation1,':',relation1_imi_id) as Relation1,
					CONCAT(relation2,':',relation2_imi_id) as Relation2,
					CONCAT(relation3,':',relation3_imi_id) as Relation3,
					CONCAT(relation4,':',relation4_imi_id) as Relation4,
					CONCAT(relation5,':',relation5_imi_id) as Relation5,
					CONCAT(relation6,':',relation6_imi_id) as Relation6,
					company_name as Company,
					title as 'Company Title',
					home_phone_number as 'Home Phone',
					cellphone_number as 'Mobile Phone',
					office_phone_number as 'Work Phone',
					preffered_mode_of_contact as 'Primary Phone',
					office_fax_number as 'Fax Number',
					email as Personal,
					secondary_email_2 as 'Email (Work)',
					preffered_mode_of_email as 'Prefered Email',
					web_address as 'Web Address',
					current_imi_title as 'Current IMI Title',
					institute_school as 'Institute/School',
					specialties as 'Specialty/ Qualifications',
					home_full_address as 'Home Address',
					home_city as 'City 1',
					home_state_province as 'State Province 1',
					home_zipcode as 'Postal Code 1',
					( CASE WHEN home_country = 0 THEN '' ELSE home_country END ) as 'Country1',
					office_full_address as 'Office Address',
					office_city as 'City 2',
					office_state_province as 'State Province 2',
					office_zip_code as 'Postal Code 2',
					( CASE WHEN office_country = 0 THEN '' ELSE office_country END ) as 'Country 2',
					membership as Membership,
					package_name as 'Membership Type 2',
					record_last_update_on as 'Record last updated on',
					membership_details_expiry_date_csv as 'Membership Expiry Date',
					member_since as 'Member since',
					( CASE when is_muslim = 1 THEN 'M' WHEN is_muslim = 0 THEN 'NM' END ) as 'Muslim/Non-Muslim',
					business_individual as 'Business/Individual',
					comments as Comments,
					prefered_name as 'Prefered Name',
					gender as 'Gender',
					previous_title_with_imi as 'Previous Title with IMI',
					'No' as 'Is Family Member',
					null as 'Age',
					registration_site
				FROM ( SELECT * FROM users_view ) t0 order by case when imi_id regexp '^[0-9]' then 1 when imi_id regexp '^[a-zA-Z]' then 2 when imi_id = '' or imi_id is null then 3 end, imi_id * 1,CAST(imi_id AS UNSIGNED)
			)
			union all
			(
				SELECT
					imi_id as 'IMI ID',
					null,
					SPLIT_STRING(crs1_fd.family_name,' ',1) as 'First Name',
					SPLIT_STRING(crs1_fd.family_name,' ',2) as 'Middle Name',
					SPLIT_STRING(crs1_fd.family_name,' ',3) as 'Last Name',
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					crs1_fd.family_email as 'Personal',
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					'Yes' as 'Is Family Member',
					family_age as 'Age',
					'IMI_ONLY_FAMILY_MEMBER' as registration_site
				FROM tb_conference_registration_screen_one_family_details crs1_fd group by imi_id order by case when imi_id regexp '^[0-9]' then 1 when imi_id regexp '^[a-zA-Z]' then 2 when imi_id = '' or imi_id is null then 3 end, imi_id * 1,CAST(imi_id AS UNSIGNED)
			)
		) t2 group by `IMI ID` order by case when `IMI ID` regexp '^[0-9]' then 1 when `IMI ID` regexp '^[a-zA-Z]' then 2 when `IMI ID` = '' or `IMI ID` is null then 3 end, `IMI ID` * 1,CAST(`IMI ID` AS UNSIGNED)

EOT;
		$query = $this->db_imiconf->query($q);
		$delimiter = ",";
		$newline = "\r\n";
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline,'"');
		force_download('imi_users_list.csv', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */