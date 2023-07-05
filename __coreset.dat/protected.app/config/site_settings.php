<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$CI =& get_instance();

 
if ( 1 !=   1 )
{			
			
	if ( $CI->db->query("SHOW TABLES LIKE 'tb_previous_conference'")->num_rows() == 0 )
	{
		
		
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_previous_conference` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `conferenceid` int(11) NOT NULL,
						  `status` int(11) NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `conferenceid` (`conferenceid`)
						) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
		
		
	}
	


 
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_chapterslocation_master` LIKE 'show_map_with_title'")->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_chapterslocation_master` ADD `show_map_with_title` INT NOT NULL AFTER `countryid`; ");
	}
	
	
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_cmsmenu` LIKE 'show_title'")->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_cmsmenu` ADD `show_title` INT NOT NULL , ADD `show_icon` INT NOT NULL ; ");
		$CI->db->query("ALTER TABLE `tb_cmsmenu` CHANGE `show_icon` `show_icon_with_title` INT NOT NULL; ");
		
	}
	
	

}

if ( TRUE )
{
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_site_settings_master` LIKE 'whatwedo_menuid'")->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_site_settings_master` ADD `whatwedo_menuid` INT NULL ;");
	}	
	
	
	
	

	
	if ( $CI->db_imiconf->query("SHOW TABLES LIKE 'tb_conference_registration_excel'")->num_rows() == 0 )
	{
		$CI->db_imiconf->query("CREATE TABLE IF NOT EXISTS `tb_conference_registration_excel` (
								`id` int(11) NOT NULL,
								  `imi_id` int(11) NOT NULL,
								  `conferenceid` int(11) NOT NULL,
								  `user_id` int(11) NOT NULL,
								  `title` varchar(255) NOT NULL,
								  `first_name` varchar(255) NOT NULL,
								  `middle_name` varchar(255) NOT NULL,
								  `last_name` varchar(255) NOT NULL,
								  `company` varchar(255) NOT NULL,
								  `company_title` varchar(255) NOT NULL,
								  `home_phone` varchar(100) NOT NULL,
								  `mobile_phone` varchar(100) NOT NULL,
								  `work_phone` varchar(100) NOT NULL,
								  `primary_phone` varchar(100) NOT NULL,
								  `fax_number` varchar(100) NOT NULL,
								  `personal_email` varchar(255) NOT NULL,
								  `work_email` varchar(255) NOT NULL,
								  `preferred_email` varchar(255) NOT NULL,
								  `web_address` varchar(255) NOT NULL,
								  `current_imi_title` varchar(255) NOT NULL,
								  `institute_school` varchar(255) NOT NULL,
								  `speciality_qualification` varchar(255) NOT NULL,
								  `membership_type_1` varchar(255) NOT NULL,
								  `membership_type_2` varchar(255) NOT NULL,
								  `record_last_update_on` date NOT NULL,
								  `membership_expiry_date` date NOT NULL,
								  `member_since` varchar(255) NOT NULL,
								  `is_muslim` int(11) NOT NULL,
								  `business_individual` varchar(100) NOT NULL,
								  `comments` int(11) NOT NULL,
								  `date_added` date NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel`  ADD PRIMARY KEY (`id`), ADD KEY `conferenceregistrationid` (`conferenceid`); ");
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
		
		
		$CI->db_imiconf->query("ALTER TABLE tb_conference_registration_master DROP FOREIGN KEY tb_conference_registration_master_ibfk_2; ");	
		$CI->db_imiconf->query("ALTER TABLE tb_conference_registration_master ADD CONSTRAINT tb_conference_registration_master_ibfk_2 FOREIGN KEY (regionid) REFERENCES tb_conference_regions(id) ON DELETE CASCADE ON UPDATE NO ACTION;  ");
		
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel` ADD INDEX(`conferenceid`);");	
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel` ADD INDEX(`user_id`);");
		
		
 
	}
	
	
	if ( $CI->db_imiconf->query("SHOW TABLES LIKE 'tb_conference_registration_excel_homedetails'")->num_rows() == 0 )
	{
		
		$CI->db_imiconf->query("CREATE TABLE IF NOT EXISTS `tb_conference_registration_excel_homedetails` (
								`id` int(11) NOT NULL,
								  `address` text NOT NULL,
								  `city` varchar(255) NOT NULL,
								  `state_province` int(11) NOT NULL,
								  `postal_code` varchar(100) NOT NULL,
								  `country` varchar(100) NOT NULL,
								  `parentid` int(11) NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_homedetails`  ADD PRIMARY KEY (`id`), ADD KEY `parentid` (`parentid`);");
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_homedetails`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_homedetails`  ADD CONSTRAINT `tb_conference_registration_excel_homedetails_ibfk_1` FOREIGN KEY (`parentid`) REFERENCES `tb_conference_registration_excel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;	");
		
	}
	
	
	
	if ( $CI->db_imiconf->query("SHOW TABLES LIKE 'tb_conference_registration_excel_officedetails'") ->num_rows() == 0 )
	{
		$CI->db_imiconf->query("CREATE TABLE IF NOT EXISTS `tb_conference_registration_excel_officedetails` (
								`id` int(11) NOT NULL,
								  `address` text NOT NULL,
								  `city` varchar(255) NOT NULL,
								  `state_province` int(11) NOT NULL,
								  `postal_code` varchar(100) NOT NULL,
								  `country` varchar(100) NOT NULL,
								  `parentid` int(11) NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
		
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_officedetails`   ADD PRIMARY KEY (`id`), ADD KEY `parentid` (`parentid`);");
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_officedetails`   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_officedetails`   ADD CONSTRAINT `tb_conference_registration_excel_officedetails_ibfk_1` FOREIGN KEY (`parentid`) REFERENCES `tb_conference_registration_excel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
		

	}
	
	
	
	
	
	if ( $CI->db_imiconf->query("SHOW TABLES LIKE 'tb_conference_registration_excel_familymembers'") ->num_rows() == 0 )
	{
		$CI->db_imiconf->query("CREATE TABLE IF NOT EXISTS `tb_conference_registration_excel_familymembers` (
								`id` int(11) NOT NULL,
								  `parentid` int(11) NOT NULL,
								  `relationship` varchar(255) NOT NULL,
								  `name` varchar(255) NOT NULL,
								  `age` varchar(255) NOT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=latin1;
								");
		
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_familymembers`   ADD PRIMARY KEY (`id`), ADD KEY `parentid` (`parentid`);");
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_familymembers`   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
		
		$CI->db_imiconf->query("ALTER TABLE `tb_conference_registration_excel_familymembers`   ADD CONSTRAINT `tb_conference_registration_excel_familymembers_ibfk_1` 
							   	FOREIGN KEY (`parentid`) REFERENCES `tb_conference_registration_excel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
		

	}
	

}



if ( TRUE )
{
	if ( $CI->db_imiconf->query("SHOW COLUMNS FROM `tb_users` LIKE 'prefix_title'")->num_rows() == 0 )
	{
		$CI->db_imiconf->query("ALTER TABLE `tb_users` ADD `prefix_title` VARCHAR(100) NOT NULL AFTER `id`; ");
		$CI->db_imiconf->query("ALTER TABLE `tb_users_profile` ADD `web_address` VARCHAR(255) NOT NULL AFTER `date_added`, ADD `current_imi_title` VARCHAR(255) NOT NULL AFTER `web_address`, ADD `institute_school` VARCHAR(255) NOT NULL AFTER `current_imi_title`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_users_profile` ADD `prefered_name` VARCHAR(255) NOT NULL , ADD `gender` VARCHAR(10) NOT NULL , ADD `previous_title_with_imi` VARCHAR(255) NOT NULL ; ");
		$CI->db_imiconf->query("ALTER TABLE `tb_users_profile` ADD `preffered_mode_of_email` VARCHAR(100) NOT NULL AFTER `preffered_mode_of_contact`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_users_profile` ADD `is_muslim` INT NOT NULL ; ");
		
		
	}	
}


if ( TRUE )
{
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_site_settings_master` LIKE 'payeezy_mode'")->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_site_settings_master` ADD `payeezy_mode` INT(11) NOT NULL;");
		$CI->db->query("ALTER TABLE `tb_site_settings_master` ADD `payeezy_url_sandbox` VARCHAR(255) NOT NULL, ADD `payeezy_url_live` VARCHAR(255) NOT NULL;");
		$CI->db->query("ALTER TABLE `tb_site_settings_master` ADD `payeezy_exactid_sandbox` VARCHAR(255) NOT NULL, ADD `payeezy_exactid_live` VARCHAR(255) NOT NULL;");
		$CI->db->query("ALTER TABLE `tb_site_settings_master` ADD `payeezy_password_sandbox` VARCHAR(255) NOT NULL, ADD `payeezy_password_live` VARCHAR(255) NOT NULL;");
		$CI->db->query("ALTER TABLE `tb_site_settings_master` ADD `payeezy_hmacid_sandbox` VARCHAR(255) NOT NULL, ADD `payeezy_hmacid_live` VARCHAR(255) NOT NULL;");
		$CI->db->query("ALTER TABLE `tb_site_settings_master` ADD `payeezy_hmackey_sandbox` VARCHAR(255) NOT NULL, ADD `payeezy_hmackey_live` VARCHAR(255) NOT NULL;");
	
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `cancelled` INT(11) NOT NULL DEFAULT '0', ADD `cancel_date` DATE NULL DEFAULT NULL, ADD `cancel_by` INT(11) NULL DEFAULT NULL;");
		
		$CI->db->query("ALTER TABLE `tb_card_payments` ADD `sequence_no` INT(11) NULL DEFAULT NULL AFTER `transaction_tag`, ADD `trans_recur_id` VARCHAR(255) NULL DEFAULT NULL, ADD `request_data` LONGTEXT NULL DEFAULT NULL, ADD `ctr` LONGTEXT NULL DEFAULT NULL, ADD `is_cron` INT(11) NOT NULL DEFAULT '0', ADD `date_added` DATETIME NULL DEFAULT NULL;");
	
		$CI->db->query("ALTER TABLE `tb_give_honor_someone` ADD `honoree_email` VARCHAR(255) NOT NULL;");

		// Insert Admin Operation of Cancel Recurring in tb_admin_operation
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_give_honor_someone` LIKE 'user_id'")->num_rows() == 0 )
	{
		//altering reference_number default null in paypal_payments table
		$CI->db->query("ALTER TABLE `tb_donation_form` CHANGE `date_added` `date_added` DATETIME NOT NULL;");
		$CI->db->query("ALTER TABLE `tb_give_honor_someone` ADD `date_added` DATETIME NOT NULL, ADD `user_id` int(11) NULL DEFAULT NULL;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'hide_identity'")->num_rows() == 0 ){
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `hide_identity` TINYINT NOT NULL DEFAULT '0';");
		$CI->db->query("ALTER TABLE `tb_donation_projects` ADD `campaign` TINYINT NOT NULL;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'home_zipcode'")->num_rows() == 0 ){
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `home_zipcode` VARCHAR(255) NULL DEFAULT NULL AFTER `home_city`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'tax_receipt_num'")->num_rows() == 0 ){
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `home_address` VARCHAR(255) NULL DEFAULT NULL AFTER `hide_identity`;");
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `tax_receipt_num` INT(11) NULL DEFAULT NULL;");
	}

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_dc_comments'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE `tb_dc_comments` (
			`id` int(11) NOT NULL,
			`df_id` int(11) NOT NULL,
			`comment` text NOT NULL,
			`status` tinyint(4) NOT NULL,
			`added_date` datetime NOT NULL,
			`updated_date` datetime DEFAULT NULL,
			`updated_by` int(11) DEFAULT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		  
		$CI->db->query("ALTER TABLE `tb_dc_comments`
			ADD PRIMARY KEY (`id`),
			ADD KEY `df_id` (`df_id`);");
		  
		$CI->db->query("ALTER TABLE `tb_dc_comments`
			MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");

		$CI->db->query("ALTER TABLE `tb_dc_comments`
			ADD CONSTRAINT `tb_dc_comments_ibkf_1` FOREIGN KEY (`df_id`) REFERENCES `tb_donation_form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
	}

	// if("not" == "run"){

		if ( $CI->db->query("SHOW TABLES LIKE 'tb_df_dp_comments'") ->num_rows() == 0 )
		{
			$CI->db->query("CREATE TABLE `tb_df_dp_comments` (
				`id` int(11) NOT NULL,
				`df_id` int(11) NOT NULL,
				`dp_id` int(11) NOT NULL,
				`comment` text NOT NULL,
				`added_date` datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
			
			$CI->db->query("ALTER TABLE `tb_df_dp_comments`
				ADD PRIMARY KEY (`id`),
				ADD KEY `dp_id` (`dp_id`),
				ADD KEY `df_id` (`df_id`);");
			
			$CI->db->query("ALTER TABLE `tb_df_dp_comments`
				MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");

			$CI->db->query("ALTER TABLE `tb_df_dp_comments`
				ADD CONSTRAINT `tb_df_dp_comments_ibkf_1` FOREIGN KEY (`df_id`) REFERENCES `tb_donation_form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
				ADD CONSTRAINT `tb_df_dp_comments_ibkf_2` FOREIGN KEY (`dp_id`) REFERENCES `tb_donation_projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
		}

	// }	

	//Insert Admin Operation of Campaign Content n Comments in tb_admin_operation
	//INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Donation Campaigns', 'Manage Donation Campaigns', 'managecampaigncontent/controls/view', 'managecampaigncontent', '87', '1'), (NULL, 'Manage Donation Campaigns', 'View', 'managecampaigncontent/controls/view', 'managecampaigncontentview', '269', '0'), (NULL, 'Add', 'Add', 'managecampaigncontent/controls/add', 'managecampaigncontentadd', '269', '0'), (NULL, 'Edit', 'Edit', 'managecampaigncontent/controls/edit', 'managecampaigncontentedit', '269', '0'), (NULL, 'Save', 'Save', 'managecampaigncontent/controls/save', 'managecampaigncontentsave', '269', '0');
	//INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Options', 'Options', 'managecampaigncontent/controls/options', 'managecampaigncontentoptions', '269', '0'), (NULL, 'Delete', 'Delete', 'managecampaigncontent/controls/delete', 'managecampaigncontentdelete', '274', '0');
	//INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Campaigns Comments', 'Manage Campaigns Comments', 'managecampaigncomment/controls/view', 'managecampaigncomment', '87', '1');
	//INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Campaigns Comments', 'View', 'managecampaigncomment/controls/view', 'managecampaigncommentview', '272', '0'), (NULL, 'Options', 'Options', 'managecampaigncomment/controls/options', 'managecampaigncommentoptions', '272', '0'), (NULL, 'Delete', 'Delete', 'managecampaigncomment/controls/delete', 'managecampaigncommentdelete', '274', '0'), (NULL, 'Update Status', 'Update Status', 'managecampaigncomment/controls/status', 'managecampaigncommentstatus', '274', '0');
	if ( $CI->db->query("SHOW TABLES LIKE 'tb_donation_campaigns'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donation_campaigns` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`donation_project_id` INT NOT NULL , 
			`short_desc` VARCHAR(200) NOT NULL , 
			`content` TEXT NOT NULL , 
			`featured_image` VARCHAR(100) NOT NULL , 
			`goal_amount` FLOAT NOT NULL ,
			`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
			`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL , 
			PRIMARY KEY (`id`),
			FOREIGN KEY (donation_project_id) REFERENCES tb_donation_projects(id)
		) ENGINE = InnoDB;");
	}

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_donation_campaigns_gallery'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donation_campaigns_gallery` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`gallery_image` VARCHAR(200) NOT NULL , 
			`desc` VARCHAR(100) NULL ,
			`donation_campaigns_id` INT NOT NULL ,
			`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
			`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL , 
			PRIMARY KEY (`id`),
			FOREIGN KEY (donation_campaigns_id) REFERENCES tb_donation_campaigns(id)
		) ENGINE = InnoDB;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'home_country'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns` ADD `status` TINYINT NOT NULL AFTER `goal_amount`;");
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `home_country` INT NOT NULL AFTER `hide_identity`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns` LIKE 'slug'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns` ADD `slug` TEXT NOT NULL AFTER `donation_project_id`;");
	}

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_donation_campaigns_updates'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donation_campaigns_updates` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`donation_campaigns_id` INT NOT NULL ,
			`description` TEXT,
			`status` tinyint(4) NOT NULL,
			`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
			`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL , 
			PRIMARY KEY (`id`),
			FOREIGN KEY (donation_campaigns_id) REFERENCES tb_donation_campaigns(id)
		) ENGINE = InnoDB;");
	}
	if ( $CI->db->query("SHOW TABLES LIKE 'tb_belongs_country'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_belongs_country` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`country_title` TEXT ,
			`country_id` INT NOT NULL,
			`chapter_id` INT NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE = InnoDB;");

		$CI->db->query("INSERT INTO `tb_belongs_country` (`id`, `country_title`, `country_id`, `chapter_id`) VALUES ('1', 
		'All', '0', '0');");

		$CI->db->query("INSERT INTO `tb_belongs_country` (`id`, `country_title`, `country_id`, `chapter_id`) VALUES ('2', 
		'International', '223', '3');");

		$CI->db->query("INSERT INTO `tb_belongs_country` (`id`, `country_title`, `country_id`, `chapter_id`) VALUES ('3', 
		'Canada', '38', '6');");

	}
	
	//INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Campaigns Updates', 'Manage Campaigns Updates', 'managecampaignupdate/controls/view', 'managecampaignupdate', '87', '1');
	//INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Campaigns Updates', 'View', 'managecampaignupdate/controls/view', 'managecampaignupdateview', '277', '0'), (NULL, 'Add', 'Add', 'managecampaignupdate/controls/add', 'managecampaignupdateadd', '277', '0'), (NULL, 'Edit', 'Edit', 'managecampaignupdate/controls/edit', 'managecampaignupdateedit', '277', '0'), (NULL, 'Save', 'Save', 'managecampaignupdate/controls/save', 'managecampaignupdatesave', '277', '0'), (NULL, 'Options', 'Options', 'managecampaignupdate/controls/options', 'managecampaignupdateoptions', '277', '0'), (NULL, 'Delete', 'Delete', 'managecampaignupdate/controls/delete', 'managecampaignupdatedelete', '282', '0');

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_donatepage_ips'") ->num_rows() == 0 )
	{
		$CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Donate Page Blocked Ip', 'Manage Donate Page Blocked Ip', 'managedonateblockedip/controls/view', 'managedonateblockedip', '87', '1');");
		$CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Donate Page Blocked Ip', 'View', 'managedonateblockedip/controls/view', 'managedonateblockedipview', '265', '0'), (NULL, 'Options', 'Options', 'managedonateblockedip/controls/options', 'managedonateblockedipoptions', '265', '0'), (NULL, 'Unblock', 'Unblock', 'managedonateblockedip/controls/delete', 'managedonateblockedipdelete', '267', '0');");
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donatepage_ips` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`ip_address` VARCHAR(255) NOT NULL , 
			`entrytime` VARCHAR(255) NULL ,
			`is_submit` TINYINT(4) DEFAULT 0 ,
			`is_resolved` TINYINT(4) DEFAULT 0 ,
			PRIMARY KEY (`id`)
		) ENGINE = InnoDB;");


		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donatepage_blocked` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`ip_address` VARCHAR(255) NOT NULL , 
			`block_time` VARCHAR(255) NOT NULL ,
			PRIMARY KEY (`id`)
		) ENGINE = InnoDB;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns_updates` LIKE 'date'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns_updates` ADD `date` DATE NOT NULL AFTER `description`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns` LIKE 'sidebar'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns`  ADD `sidebar` TEXT NULL DEFAULT NULL AFTER `content`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns` LIKE 'gallery_text'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns`  ADD `gallery_text` TEXT NULL DEFAULT NULL AFTER `content`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns_languages` LIKE 'gallery_text'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns_languages`  ADD `gallery_text` TEXT NULL DEFAULT NULL AFTER `content`;");
	}
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_cmsmenu` LIKE 'added_by'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_cmsmenu`  ADD `added_by` int(11) DEFAULT NULL AFTER `date_added`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_site_gallery` LIKE 'added_by'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_site_gallery`  ADD `added_by` int(11) DEFAULT NULL AFTER `caption_h2`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_cmscontent` LIKE 'added_by'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_cmscontent`  ADD `added_by` int(11) DEFAULT NULL AFTER `custom_title`;");
	}
	
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_sitesectionswidgets` LIKE 'added_by'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_sitesectionswidgets`  ADD `added_by` int(11) DEFAULT NULL AFTER `email_text`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_timelinehistory` LIKE 'added_by'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_timelinehistory`  ADD `added_by` int(11) DEFAULT NULL AFTER `slug`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_projects` LIKE 'added_by'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_projects`  ADD `added_by` int(11) DEFAULT NULL AFTER `is_event`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns` LIKE 'added_by'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns`  ADD `added_by` int(11) DEFAULT NULL AFTER `belongsto`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_admin` LIKE 'belongs_country'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_admin`  ADD `belongs_country` LONGTEXT DEFAULT NULL AFTER `roleid`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'belongs_country'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_form`  ADD `belongs_country` LONGTEXT DEFAULT NULL AFTER `is_active`;");

		$CI->db->query("UPDATE tb_donation_form SET belongs_country = 3 WHERE home_country = 38");
		$CI->db->query("UPDATE tb_donation_form SET belongs_country = 2 WHERE home_country != 38");

		
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_give_honor_someone` LIKE 'belongs_country'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_give_honor_someone`  ADD `belongs_country` LONGTEXT DEFAULT NULL AFTER `is_active`;");

		$CI->db->query("UPDATE tb_give_honor_someone SET belongs_country = 3 WHERE home_country = 38");
		$CI->db->query("UPDATE tb_give_honor_someone SET belongs_country = 2 WHERE home_country != 38");

	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_projects` LIKE 'belongsto'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_projects`  ADD `belongsto` INT(11) NOT NULL DEFAULT 0 AFTER `added_by`;");
	}
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_sitesectionswidgets` LIKE 'is_package'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_sitesectionswidgets`  ADD `is_package` int(11) DEFAULT NULL AFTER `added_by`;");
	}
	//Export Paypal/Payeezy Options in Admin Operations
	//INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Export Paypal', 'Export Paypal', 'viewdonation/controls/exportpaypal', 'viewdonationexportpaypal', '96', '0'), (NULL, 'Export Paypeezy', 'Export Paypeezy', 'viewdonation/controls/exportpayeezy', 'viewdonationexportpayeezy', '96', '0');
	// INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Tax Receipt', 'Tax Receipt', 'viewdonation/controls/receipt', 'viewdonationtaxreceipt', '96', '0');
	// INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Tax Receipt', 'Tax Receipt', 'managemembers/controls/receipt', 'managememberstaxreceipt', '358', '0');

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'is_active'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `is_active` TINYINT(4) NOT NULL DEFAULT '1' AFTER `home_country`;");
		$CI->db->query("ALTER TABLE `tb_give_honor_someone` ADD `is_active` TINYINT(4) NOT NULL DEFAULT '1' AFTER `user_id`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'sehm'") ->num_rows() == 0 )	
	{	
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `sehm` VARCHAR(50) NULL AFTER `home_country`;");	
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `marjaa` VARCHAR(100) NULL AFTER `sehm`;");	
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `is_syed` VARCHAR(50) NULL AFTER `marjaa`;");	
	}	
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_projects` LIKE 'type'") ->num_rows() == 0 )	
	{	
		$CI->db->query("ALTER TABLE `tb_donation_projects` ADD `type` VARCHAR(10) NULL AFTER `sort`;");	
		$CI->db->query("ALTER TABLE `tb_donation_projects` ADD `parentid` INT NOT NULL DEFAULT 0 AFTER `type`;");	
	}

	if ( $CI->db_imiconf->query("SHOW COLUMNS FROM `tb_arbaeen_medical_mission` LIKE 'age'")->num_rows() == 0 )
	{
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `age` INT NOT NULL AFTER `birth_date`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns` LIKE 'belongsto'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_cmsmenu` ADD `belongsto` INT NOT NULL DEFAULT 1 AFTER `typeid`;");
		$CI->db->query("ALTER TABLE `tb_cmscontent` ADD `belongsto` INT NOT NULL DEFAULT 1 AFTER `content`;");
		$CI->db->query("ALTER TABLE `tb_site_gallery` ADD `belongsto` INT NOT NULL DEFAULT 1 AFTER `typeid`;");
		$CI->db->query("ALTER TABLE `tb_timelinehistory` ADD `belongsto` INT NOT NULL DEFAULT 1 AFTER `status`;");
		$CI->db->query("ALTER TABLE `tb_sitesectionswidgets` ADD `belongsto` INT NOT NULL DEFAULT 1 AFTER `status`;");
		$CI->db->query("ALTER TABLE `tb_donation_campaigns` ADD `belongsto` INT NOT NULL DEFAULT 1 AFTER `status`;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_ways_to_give` LIKE 'belongsto'") ->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_ways_to_give` ADD `belongsto` INT NOT NULL DEFAULT 1 AFTER `donation_way_to_give_address`;");
	}
	
	if ( $CI->db->query("SHOW TABLES LIKE 'tb_content_languages'") ->num_rows() == 0 )	
	{	
		// $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'Manage Languages', 'Manage Languages', 'managelanguages/controls/view', 'managelanguages', '7', '1');");	
		// $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (NULL, 'View', 'View', 'managelanguages/controls/view', 'managelanguagesview', '290', '0'), (NULL, 'Add', 'Add', 'managelanguages/controls/add', 'managelanguagesadd', '290', '0'), (NULL, 'Edit', 'Edit', 'managelanguages/controls/edit', 'managelanguagesedit', '290', '0'), (NULL, 'Save', 'Save', 'managelanguages/controls/save', 'managelanguagessave', '290', '0'),(NULL, 'Options', 'Options', 'managelanguages/controls/options', 'managelanguagesoptions', '290', '0'),(NULL, 'Delete', 'Delete', 'managelanguages/controls/delete', 'managelanguagesdelete', '296', '0')");	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_content_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`code` VARCHAR(255) NULL ,	
			`direction` VARCHAR(4) DEFAULT 'LTR' ,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
	}	
    if ($CI->db->query("SHOW TABLES LIKE 'tb_cmscontent_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_cmscontent_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`short_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`cmscontent_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
    if ($CI->db->query("SHOW TABLES LIKE 'tb_sitesectionswidgets_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_sitesectionswidgets_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`title` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`short_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`full_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`sitesectionswidgets_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
    if ($CI->db->query("SHOW TABLES LIKE 'tb_cmsmenu_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_cmsmenu_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`name` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`subheading` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`cmsmenu_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
    if ($CI->db->query("SHOW TABLES LIKE 'tb_site_gallery_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_site_gallery_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`caption_h1` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`caption_h2` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`site_gallery_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
	}	
	if ($CI->db->query("SHOW TABLES LIKE 'tb_timelinehistory_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_timelinehistory_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`title` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`short_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`full_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`timelinehistory_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
	if ($CI->db->query("SHOW TABLES LIKE 'tb_spotlight'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_spotlight` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`title` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`short_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`button_link` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`button_type` TINYINT(4) NOT NULL , 	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }
	if ($CI->db->query("SHOW TABLES LIKE 'tb_wherewework_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_wherewework_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`title` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`short_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`full_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`wherewework_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
	if ($CI->db->query("SHOW TABLES LIKE 'tb_chapterslocation_master_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_chapterslocation_master_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`short_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`full_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`chapterslocation_master_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
	if ($CI->db->query("SHOW TABLES LIKE 'tb_chapterpersons_master_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_chapterpersons_master_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`biography` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`chapterpersons_master_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
	if ($CI->db->query("SHOW TABLES LIKE 'tb_donation_projects_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donation_projects_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`donation_projects_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
	if ($CI->db->query("SHOW TABLES LIKE 'tb_donation_campaigns_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donation_campaigns_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`short_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`sidebar` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`donation_campaigns_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
	if ($CI->db->query("SHOW TABLES LIKE 'tb_donation_ways_to_give_languages'") ->num_rows() == 0) {
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donation_ways_to_give_languages` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`column_first_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
			`column_two_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
			`column_three_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
			`donation_ways_to_give_id` INT NOT NULL ,
			`content_languages_id` INT NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE = InnoDB;");
	
		

	}
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_ways_to_give_languages` LIKE 'donation_way_to_give_address'")->num_rows() == 0 ){
		$CI->db->query("ALTER TABLE `tb_donation_ways_to_give_languages` ADD `donation_way_to_give_address` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER id");
	}
	if ($CI->db->query("SHOW TABLES LIKE 'tb_donation_campaigns_updates_languages'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_donation_campaigns_updates_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 	
			`donation_campaigns_updates_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }	
    if ($CI->db_imiconf->query("SHOW TABLES LIKE 'tb_arbaeenmedicalmission_content_languages'") ->num_rows() == 0) {	
        $CI->db_imiconf->query("CREATE TABLE IF NOT EXISTS `tb_arbaeenmedicalmission_content_languages` ( 	
			`id` INT NOT NULL AUTO_INCREMENT , 	
			`content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`stage3_form` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`stage3b_form` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 	
			`arbaeenmedicalmission_content_id` INT NOT NULL ,	
			`content_languages_id` INT NOT NULL,	
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
	}
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_chapterslocation_master_languages` LIKE 'title'")->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_chapterslocation_master_languages` ADD `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER id");
	}
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_campaigns_gallery` LIKE 'type'")->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_campaigns_gallery` ADD `type` VARCHAR(50) NOT NULL AFTER `desc`;");
		$CI->db->query("UPDATE tb_donation_campaigns_gallery SET type='image' WHERE type=''");
	}
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_form` LIKE 'donate_honoree'")->num_rows() == 0 )
	{
		$CI->db->query("ALTER TABLE `tb_donation_form` ADD `donate_honoree` VARCHAR(200) NULL AFTER `donate_amount`;");
	}
	//Insert Admin Operation of Campaign Content n Comments in tb_admin_operation
	/*INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES 
	(NULL, 'Manage Campaigns Custom Donors', 'Manage Campaigns Custom Donors', 'managecampaigncustomdonor/controls/view', 'managecampaigncustomdonor', '87', '1'),
	(NULL, 'Manage Campaigns Custom Donors', 'View', 'managecampaigncustomdonor/controls/view', 'managecampaigncustomdonorview', '290', '0'),
	(NULL, 'Add', 'Add', 'managecampaigncustomdonor/controls/add', 'managecampaigncustomdonoradd', '290', '0'),
	(NULL, 'Edit', 'Edit', 'managecampaigncustomdonor/controls/edit', 'managecampaigncustomdonoredit', '290', '0'),
	(NULL, 'Save', 'Save', 'managecampaigncustomdonor/controls/save', 'managecampaigncustomdonorsave', '290', '0'),
	(NULL, 'Options', 'Options', 'managecampaigncustomdonor/controls/options', 'managecampaigncustomdonoroptions', '290', '0'),
	(NULL, 'Delete', 'Delete', 'managecampaigncustomdonor/controls/delete', 'managecampaigncustomdonordelete', '295', '0');*/

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_dc_offline_donation'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_dc_offline_donation` ( 
			`id` INT NOT NULL AUTO_INCREMENT,
			`camp_id` INT NOT NULL,
			`first_name` VARCHAR(200) NOT NULL,
			`donate_amount` FLOAT NOT NULL,
			`hide_identity` TINYINT NOT NULL DEFAULT '0',
			`home_country` INT NOT NULL,
			`date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`comment` TEXT NULL DEFAULT NULL,
			`comment_status` TINYINT(4) NOT NULL,
			`status` TINYINT(4) NOT NULL,
			`mode` VARCHAR(200) NOT NULL,
			`other_info` TEXT NULL DEFAULT NULL,
			`created_by` int(11) DEFAULT NULL,
			`updated_by` int(11) DEFAULT NULL,
			`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (camp_id) REFERENCES tb_donation_campaigns(id)
		) ENGINE = InnoDB;");
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_donation_projects` LIKE 'show_front'")->num_rows() == 0 ){
		$CI->db->query("ALTER TABLE `tb_donation_projects` ADD `show_front` TINYINT NOT NULL DEFAULT '1';");
		$CI->db->query("ALTER TABLE `tb_donation_projects` ADD `is_event` TINYINT NOT NULL DEFAULT '0';");
	}

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_event_packages'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_event_packages` ( 
			`id` INT NOT NULL AUTO_INCREMENT,
			`event_id` INT NOT NULL,
			`package_title` VARCHAR(200) NOT NULL,
			`available_seats` VARCHAR(200) NOT NULL,
			`amount` FLOAT NOT NULL,
			`status` TINYINT(4) NOT NULL,
			`created_by` int(11) DEFAULT NULL,
			`updated_by` int(11) DEFAULT NULL,
			`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (event_id) REFERENCES tb_sitesectionswidgets(id)
		) ENGINE = InnoDB;");
		$CI->db->query("INSERT INTO `tb_event_packages` (`id`, `event_id`, `package_title`, `available_seats`, `amount`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
			VALUES 
			(NULL, '93', 'General Admission (Student)', '1 Seat', '20', '1', '1', NULL, CURRENT_TIMESTAMP, NULL), 
			(NULL, '93', 'General Admission (Professional)', '1 Seat', '30', '1', '1', NULL, CURRENT_TIMESTAMP, NULL), 
			(NULL, '93', 'Family & Friends Pack', 'Table of 6 seats', '120', '1', '1', NULL, CURRENT_TIMESTAMP, NULL);"
		);
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_event_packages_languages` ( 
			`id` INT NOT NULL AUTO_INCREMENT , 
			`package_title` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
			`available_seats` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
			`event_packages_id` INT NOT NULL ,
			`content_languages_id` INT NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE = InnoDB;");
		// INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES 
		// (NULL, 'Manage Event Packages', 'Manage Event Packages', 'manageeventpackages/controls/view', 'manageeventpackages', '7', '1'), 
		// (NULL, 'Manage Event Packages', 'View', 'manageeventpackages/controls/view', 'manageeventpackagesview', '308', '0'), 
		// (NULL, 'Add', 'Add', 'manageeventpackages/controls/add', 'manageeventpackagesadd', '308', '0'), 
		// (NULL, 'Edit', 'Edit', 'manageeventpackages/controls/edit', 'manageeventpackagesedit', '308', '0'), 
		// (NULL, 'Save', 'Save', 'manageeventpackages/controls/save', 'manageeventpackagessave', '308', '0'),
		// (NULL, 'Options', 'Options', 'manageeventpackages/controls/options', 'manageeventpackagesoptions', '308', '0'),
		// (NULL, 'Delete', 'Delete', 'manageeventpackages/controls/delete', 'manageeventpackagesdelete', '313', '0');
	}

	if ( $CI->db->query("SHOW COLUMNS FROM `tb_sitesectionswidgets` LIKE 'don_proj_id'")->num_rows() == 0 ){
		$CI->db->query("ALTER TABLE `tb_sitesectionswidgets` ADD `don_proj_id` int(11) DEFAULT NULL;");
		$CI->db->query("ALTER TABLE `tb_sitesectionswidgets` ADD `email_text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;"); 
	}

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_event_registrations'") ->num_rows() == 0 )
	{
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_event_registrations` ( 
			`id` INT NOT NULL AUTO_INCREMENT,
			`package_id` INT NOT NULL,
			`event_id` INT NOT NULL,
			`donate_name` VARCHAR(350) NOT NULL,
			`donate_email` VARCHAR(350) NOT NULL,
			`donate_phone` VARCHAR(350) NOT NULL,
			`mailing_addr` VARCHAR(350) NOT NULL,
			`package_amount` FLOAT NOT NULL,
			`donate_amount` FLOAT NOT NULL DEFAULT 0,
			`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			FOREIGN KEY (package_id) REFERENCES tb_event_packages(id)
		) ENGINE = InnoDB;");
	}
	if ($CI->db->query("SHOW TABLES LIKE 'tb_payment_receipts'") ->num_rows() == 0) {	
		$CI->db->query("CREATE TABLE IF NOT EXISTS `tb_payment_receipts` ( 	
			`id` INT NOT NULL AUTO_INCREMENT,
			`receipt_number`  INT NOT NULL,	
			`receipt_prefix` CHAR(5) NOT NULL,
			`table_name` VARCHAR(100) NOT NULL,
			`table_id_name` VARCHAR(100) NOT NULL,
			`table_id_value` VARCHAR(100) NOT NULL,
			PRIMARY KEY (`id`)	
		) ENGINE = InnoDB;");	
    }
	if ( $CI->db->query("SHOW COLUMNS FROM `tb_event_registrations` LIKE 'donation_form_id'")->num_rows() == 0 ){
		$CI->db->query("ALTER TABLE `tb_event_registrations` ADD `donation_form_id` INT NOT NULL AFTER `event_id`;");
		//Insert Admin Operation of Event Registrations in tb_admin_operation
		/*$CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES 
		(NULL, 'View Event Registrations', 'View Event Registrations', 'vieweventregistrations/controls/view', 'vieweventregistrations', '87', '1'),
		(NULL, 'View Event Registrations', 'View Event Registrations', 'vieweventregistrations/controls/view', 'vieweventregistrationsview', '304', '0'),
		(NULL, 'Options', 'Options', 'vieweventregistrations/controls/options', 'vieweventregistrationsoptions', '304', '0'),
		(NULL, 'Delete', 'Delete', 'vieweventregistrations/controls/delete', 'vieweventregistrationsdelete', '306', '0');");*/
	}

	if ( $CI->db_imiconf->query("SHOW COLUMNS FROM `tb_arbaeen_medical_mission` LIKE 'gender'")->num_rows() == 0 )
	{
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `gender` VARCHAR(250) DEFAULT NULL AFTER `last_name`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `how_old` VARCHAR(250) DEFAULT NULL AFTER `country`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `know_bmi` VARCHAR(350) DEFAULT NULL AFTER `how_old`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `bmi` VARCHAR(350) DEFAULT NULL AFTER `know_bmi`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `smoking_hist` VARCHAR(350) DEFAULT NULL AFTER `bmi`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `med_his` VARCHAR(250) DEFAULT NULL AFTER `smoking_hist`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `med_curr` VARCHAR(250) DEFAULT NULL AFTER `med_his`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `med_list` TEXT NULL DEFAULT NULL AFTER `med_curr`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `health_cond` TEXT NULL DEFAULT NULL AFTER `med_list`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `other_health_cond` VARCHAR(350) DEFAULT NULL AFTER `health_cond`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `type_covid19` VARCHAR(350) DEFAULT NULL AFTER `other_health_cond`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `type_diabetes` VARCHAR(250) DEFAULT NULL AFTER `type_covid19`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `type_heart_disease` TEXT DEFAULT NULL AFTER `type_diabetes`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `health_his` TEXT NULL DEFAULT NULL AFTER `type_heart_disease`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `covid_vacc` VARCHAR(350) DEFAULT NULL AFTER `health_his`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `covid_vacc_det` TEXT NULL DEFAULT NULL AFTER `covid_vacc`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `agree_covid19_risk` VARCHAR(250) DEFAULT NULL AFTER `agree_activity_reported_to_imi`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission` ADD `agree_medical_camp` VARCHAR(250) DEFAULT NULL AFTER `agree_covid19_risk`;");		
	}
	if ($CI->db_imiconf->query("SHOW COLUMNS FROM `tb_arbaeen_medical_mission_content` LIKE 'content_fp'") ->num_rows() == 0) {
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeen_medical_mission_content` ADD `content_fp` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL AFTER `content`;");
		$CI->db_imiconf->query("ALTER TABLE `tb_arbaeenmedicalmission_content_languages` ADD `content_fp` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL AFTER `content`;");
    }

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_short_conference'") ->num_rows() == 0 ){
		$CI->db->query("CREATE TABLE `tb_short_conference` (
			`id` int(11) NOT NULL,
			`theme` varchar(255) NOT NULL,
			`name` varchar(255) NOT NULL,
			`venue` text NOT NULL,
			`slug` varchar(255) NOT NULL,
			`description` text NOT NULL,
			`arrival_at` varchar(255) NOT NULL,
			`departure_from` varchar(255) NOT NULL,
			`duration_from` datetime DEFAULT NULL,
			`duration_to` datetime DEFAULT NULL,
			`registration_from` datetime DEFAULT NULL,
			`registration_to` datetime DEFAULT NULL,
			`countryid` int(11) DEFAULT NULL,
			`registration_closed` int(11) NOT NULL,
			`status` int(11) NOT NULL,
			`registration_site` varchar(100) NOT NULL DEFAULT 'No'
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		  
		$CI->db->query("CREATE TABLE `tb_short_conference_prices_details` (
			`id` int(11) NOT NULL,
			`parentid` int(11) NOT NULL,
			`typeid` int(11) NOT NULL,
			`earlybird_price` double NOT NULL,
			`regular_price` double NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("CREATE TABLE `tb_short_conference_prices_master` (
			`id` int(11) NOT NULL,
			`parent_id` int(11) DEFAULT NULL,
			`conferenceid` int(11) NOT NULL,
			`whoattendid` int(11) NOT NULL,
			`regionid` int(11) DEFAULT NULL,
			`paymenttype_key` varchar(10) NOT NULL,
			`is_addon` int(11) NOT NULL,
			`is_validated` int(11) NOT NULL,
			`is_optional` int(11) NOT NULL,
			`is_free` int(11) NOT NULL,
			`discount_coupon_code` varchar(255) NOT NULL,
			`title` varchar(255) NOT NULL,
			`description` text NOT NULL,
			`image_icon` varchar(255) NOT NULL,
			`apply_for_visa` int(11) NOT NULL,
			`currency!` int(11) NOT NULL DEFAULT '1'
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


		$CI->db->query("CREATE TABLE `tb_short_conference_regions` (
			`id` int(11) NOT NULL,
			`conferenceid` int(11) NOT NULL,
			`name` varchar(255) NOT NULL,
			`allow_payment` int(11) NOT NULL,
			`paymentdescription_conference` text NOT NULL,
			`paymentdescription_abstract` text NOT NULL,
			`description` text NOT NULL,
			`onsite_note` text NOT NULL,
			`sort` int(11) DEFAULT '0',
			`show_rates_in_currency` int(11) DEFAULT '1',
			`step5_note1` text NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("CREATE TABLE `tb_short_conference_sight_seeing` (
			`conferenceid` int(11) NOT NULL,
			`sight_seeingid` int(11) NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$CI->db->query("CREATE TABLE `tb_short_conference_who_attend` (
			`id` int(11) NOT NULL,
			`conferenceid` int(11) NOT NULL,
			`name` varchar(255) NOT NULL,
			`description` varchar(255) NOT NULL,
			`image_icon` varchar(255) NOT NULL,
			`no_of_people` int(11) NOT NULL,
			`type` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("CREATE TABLE `tb_sight_seeing` (
			`id` int(11) NOT NULL,
			`countryid` int(11) NOT NULL,
			`caption` varchar(255) NOT NULL,
			`photo_image` varchar(255) NOT NULL,
			`date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`status` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		
		$CI->db->query("ALTER TABLE `tb_short_conference` ADD PRIMARY KEY (`id`);"); 
		
		$CI->db->query("ALTER TABLE `tb_short_conference_prices_details` ADD PRIMARY KEY (`id`), ADD KEY `parentid` (`parentid`);"); 
		
		$CI->db->query("ALTER TABLE `tb_short_conference_prices_master` ADD PRIMARY KEY (`id`), ADD KEY `conferenceid` (`conferenceid`), ADD KEY `is_optional` (`is_optional`)ADD KEY `parent_id` (`parent_id`);"); 
		
		$CI->db->query("ALTER TABLE `tb_short_conference_regions` ADD PRIMARY KEY (`id`), ADD KEY `conferenceid` (`conferenceid`);"); 
		
		$CI->db->query("ALTER TABLE `tb_short_conference_sight_seeing` ADD KEY `tb_short_conference_sight_seeing_ibfk_1` (`conferenceid`), ADD KEY `tb_short_conference_sight_seeing_ibfk_2` (`sight_seeingid`);"); 
		
		$CI->db->query("ALTER TABLE `tb_short_conference_who_attend` ADD PRIMARY KEY (`id`), ADD KEY `tb_short_conference_who_attend_ibfk_1` (`conferenceid`);"); 

		$CI->db->query("ALTER TABLE `tb_sight_seeing` ADD PRIMARY KEY (`id`);"); 

		$CI->db->query("ALTER TABLE `tb_short_conference` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;");
  
		$CI->db->query("ALTER TABLE `tb_short_conference_prices_details` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1806;"); 

		$CI->db->query("ALTER TABLE `tb_short_conference_prices_master`	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=672;");

		$CI->db->query("ALTER TABLE `tb_short_conference_regions` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;"); 

		$CI->db->query("ALTER TABLE `tb_short_conference_who_attend` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4"); 

		$CI->db->query("ALTER TABLE `tb_sight_seeing` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;"); 

		$CI->db->query("ALTER TABLE `tb_short_conference_prices_details` ADD CONSTRAINT `tb_short_conference_prices_details_ibfk_1` FOREIGN KEY (`parentid`) REFERENCES `tb_short_conference_prices_master` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;"); 

		$CI->db->query("ALTER TABLE `tb_short_conference_prices_master` ADD CONSTRAINT `tb_short_conference_prices_master_ibfk_1` FOREIGN KEY (`conferenceid`) REFERENCES `tb_short_conference` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, ADD CONSTRAINT `tb_short_conference_prices_master_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `tb_short_conference_prices_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"); 

		$CI->db->query("ALTER TABLE `tb_short_conference_regions`  ADD CONSTRAINT `tb_short_conference_regions_ibfk_1` FOREIGN KEY (`conferenceid`) REFERENCES `tb_short_conference` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;"); 

		$CI->db->query("ALTER TABLE `tb_short_conference_sight_seeing` ADD CONSTRAINT `tb_short_conference_sight_seeing_ibfk_1` FOREIGN KEY (`conferenceid`) REFERENCES `tb_short_conference` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION, ADD CONSTRAINT `tb_short_conference_sight_seeing_ibfk_2` FOREIGN KEY (`sight_seeingid`) REFERENCES `tb_sight_seeing` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;"); 

		$CI->db->query("ALTER TABLE `tb_short_conference_who_attend` ADD CONSTRAINT `tb_short_conference_who_attend_ibfk_1` FOREIGN KEY (`conferenceid`) REFERENCES `tb_short_conference` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;");

	}
	
	// $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (372, 'Short Conference', 'Short Conference', NULL, 'shortconference', 0, 1),
	// (373, 'Manage Short Conference', 'Manage Short Conference', 'manageshortconference/controls/view', 'manageshortconference', 372, 1),
	// (374, 'Manage Short Conference', 'Manage Short Conference', 'manageshortconference/controls/view', 'manageshortconferenceview', 373, 0),
	// (375, 'Add', 'Add', 'manageshortconference/controls/add', 'manageshortconferenceadd', 373, 0),
	// (376, 'Save', 'Save', 'manageshortconference/controls/save', 'manageshortconferencesave', 373, 0),
	// (377, 'Manage Sightseeing ', 'Manage Sightseeing ', 'managesightseeing/controls/view', 'managesightseeing', 7, 1),
	// (378, 'Add', 'Add', 'managesightseeing/controls/add', 'managesightseeingadd', 377, 0),
	// (379, 'Edit', 'Edit ', 'managesightseeing/controls/edit', 'managesightseeingedit', 377, 0),
	// (380, 'Save', 'Save', 'managesightseeing/controls/save', 'managesightseeingsave', 377, 0),
	// (381, 'Options', 'Options', 'managesightseeing/controls/option', 'managesightseeingoption', 377, 0),
	// (382, 'Edit', 'Edit', 'manageshortconference/controls/edit', 'manageshortconferenceedit', 373, 0),
	// (383, 'Manage Short Conference (Who Attend)', 'Manage Short Conference (Who Attend)', 'manageshortconferencewhoattend/controls/view', 'manageshortconferencewhoattend', 372, 1),
	// (384, 'Manage Short Conference Price', 'Manage Short Conference Price', 'manageshortconferenceprices/controls/view', 'manageshortconferenceprices', 372, 1),
	// (385, 'Manage Short Conference (Who Attend)', 'Manage Short Conference (Who Attend)', 'manageshortconferencewhoattend/controls/view', 'manageshortconferencewhoattendview', 383, 0),
	// (386, 'Add', 'Add', 'manageshortconferencewhoattend/controls/add', 'manageshortconferencewhoattendadd', 383, 0),
	// (387, 'Add', 'Add', 'manageshortconferenceprices/controls/add', 'manageshortconferencepricesadd', 384, 0),
	// (388, 'Edit', 'Edit', 'manageshortconferenceprices/controls/edit', 'manageshortconferencepricesedit', 384, 0),
	// (389, 'Edit', 'Edit', 'manageshortconferencewhoattend/controls/edit', 'manageshortconferencewhoattendedit', 383, 0),
	// (390, 'Manage Conference Regions', 'Manage Conference Regions', 'manageshortconferenceregions/controls/view', 'manageshortconferenceregions', 372, 1),
	// (391, 'Add', 'Add', 'manageshortconferenceregions/controls/add', 'manageshortconferenceregionsadd', 390, 0),
	// (392, 'Edit', 'Edit', 'manageshortconferenceregions/controls/edit', 'manageshortconferenceregionsedit', 390, 0),
	// (393, 'Save', 'Save', 'manageshortconferenceregions/controls/save', 'manageshortconferenceregionssave', 390, 0),
	// (394, 'Save', 'Save', 'manageshortconferencewhoattend/controls/save', 'manageshortconferencewhoattendsave', 383, 0),
	// (395, 'Save', 'Save', 'manageshortconferenceprices/controls/save', 'manageshortconferencepricessave', 384, 0),
	// (396, 'Option', 'Option', 'manageshortconference/controls/options', 'manageshortconferenceoptions', 373, 0),
	// (397, 'Delete', 'Delete', 'manageshortconference/controls/delete', 'manageshortconferencedelete', 396, 0),
	// (398, 'Options', 'Options', 'manageshortconferencewhoattend/controls/options', 'manageshortconferencewhoattendoptons', 383, 0),
	// (399, 'Delete', 'Delete', 'manageshortconferencewhoattend/controls/delete', 'manageshortconferencewhoattenddelete', 398, 0),
	// (400, 'Options', 'Options', 'manageshortconferenceprices/controls/options', 'manageshortconferencepricesoptons', 384, 0),
	// (401, 'Delete', 'Delete', 'manageshortconferenceprices/controls/delete', 'manageshortconferencepricesdelete', 400, 0),
	// (402, 'Options', 'Options', 'manageshortconferenceregions/controls/options', 'manageshortconferenceregionsoptions', 390, 0),
	// (403, 'Delete', 'Delete', 'manageshortconferenceregions/controls/delete', 'manageshortconferenceregionsdelete', 402, 0),
	// (404, 'Delete', 'Delete', 'managesightseeing/controls/delete', 'managesightseeingdelete', 381, 0);");	
	
	if($CI->db->query("SHOW TABLES LIKE 'tb_short_conference_registration_master'") ->num_rows() == 0){
		$CI->db->query("CREATE TABLE `tb_short_conference_registration_master` (
			`id` int(11) NOT NULL,
			`conferenceid` int(11) DEFAULT NULL,
			`participanttypeid` int(11) DEFAULT NULL COMMENT 'conferenceparticipants_dropdown()',
			`regionid` int(11) DEFAULT NULL,
			`userid` int(11) NOT NULL,
			`date_added` datetime NOT NULL,
			`is_paid` int(11) DEFAULT '0',
			`payment_allow` int(11) DEFAULT NULL,
			`payment_type` varchar(20) DEFAULT NULL,
			`registration_site` varchar(100) DEFAULT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("CREATE TABLE `tb_short_conference_registration_screen_one` (
			`id` int(11) NOT NULL,
			`conferenceregistrationid` int(11) NOT NULL,
			`prefix` varchar(100) DEFAULT NULL,
			`education` varchar(100) DEFAULT NULL,
			`phone` varchar(100) DEFAULT NULL,
			`name` varchar(255) DEFAULT NULL,
			`email` varchar(255) DEFAULT NULL,
			`country_of_residence` int(11) DEFAULT NULL,
			`no_of_family_members` int(11) NOT NULL,
			`travelling_with` varchar(100) DEFAULT NULL COMMENT 'imi_group, independently',
			`date_added` datetime NOT NULL,
			`date_modified` datetime DEFAULT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("CREATE TABLE `tb_short_conference_registration_screen_one_family_details` (
			`id` int(11) NOT NULL,
			`parentid` int(11) NOT NULL,
			`family_name` varchar(255) NOT NULL,
			`family_email` varchar(255) NOT NULL,
			`family_relationship` int(11) NOT NULL,
			`family_age` int(11) NOT NULL,
			`family_birthdate` datetime DEFAULT NULL,
			`imi_id` text
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

		$CI->db->query("CREATE TABLE `tb_short_conference_registration_screen_three` (
			`id` int(11) NOT NULL,
			`conferenceregistrationid` int(11) NOT NULL,
			`screen_one_id` int(11) NOT NULL,
			`screen_two_id` int(11) NOT NULL,
			`gender` varchar(10) DEFAULT NULL,
			`name` varchar(255) NOT NULL,
			`middle_name` varchar(255) DEFAULT NULL,
			`father_name` varchar(255) DEFAULT NULL,
			`surname` varchar(255) DEFAULT NULL,
			`passport_number` varchar(255) DEFAULT NULL,
			`passport_type` varchar(255) DEFAULT NULL,
			`date_of_birth` datetime DEFAULT NULL,
			`place_of_birth` varchar(255) DEFAULT NULL,
			`country_of_birth` int(11) DEFAULT NULL,
			`nationality` varchar(255) DEFAULT NULL,
			`passport_image` varchar(255) DEFAULT NULL,
			`photo_image` varchar(255) DEFAULT NULL,
			`marital_status` varchar(10) DEFAULT NULL,
			`gender_father_name` varchar(255) DEFAULT NULL,
			`previous_nationality` varchar(255) DEFAULT NULL,
			`date_of_issue` datetime DEFAULT NULL,
			`place_of_issue` varchar(255) DEFAULT NULL,
			`expiry_date` datetime DEFAULT NULL,
			`occupation` varchar(255) DEFAULT NULL,
			`position` varchar(255) DEFAULT NULL,
			`name_of_institute_company` varchar(255) DEFAULT NULL,
			`title_of_activity` varchar(255) DEFAULT NULL,
			`visa_insurance_place` varchar(255) DEFAULT NULL,
			`duration_of_stay` int(11) DEFAULT NULL,
			`no_of_previous_travels` int(11) DEFAULT NULL,
			`date_of_entry_for_conference` datetime DEFAULT NULL,
			`last_date_of_entry` datetime DEFAULT NULL,
			`date_of_departure` datetime DEFAULT NULL,
			`date_added` datetime DEFAULT NULL,
			`date_modified` datetime DEFAULT NULL,
			`parentid` int(11) DEFAULT NULL,
			`screen_one_detail_id` int(11) NOT NULL,
			`full_name` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL,
			`phone` varchar(255) NOT NULL,
			`mailing_address` varchar(255) DEFAULT NULL,
			`speciality_interest` varchar(255) DEFAULT NULL,
			`age_level_of_school` int(11) DEFAULT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("CREATE TABLE `tb_short_conference_registration_screen_two` (
			`id` int(11) NOT NULL,
			`conferenceregistrationid` int(11) NOT NULL,
			`screen_one_id` int(11) NOT NULL,
			`earlybird_regular` varchar(100) NOT NULL COMMENT 'conferenceprice_earlybird_regular_dropdown()',
			`paymenttypeid` int(11) NOT NULL COMMENT 'conferenceregistration_paymenttype()',
			`be_a_member` int(11) NOT NULL,
			`be_a_member_fee` int(11) NOT NULL COMMENT 'tb_conference_prices_not_a_member',
			`coupon_code` varchar(255) NOT NULL,
			`date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`price_package_fee` double NOT NULL,
			`price_payable_now` double NOT NULL,
			`price_cash_onsite` double NOT NULL,
			`price_total_payable` double NOT NULL,
			`price_less_absfee` double DEFAULT '0',
			`email_text` text NOT NULL,
			`speaker_coupon_code` varchar(255) NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("
		  CREATE TABLE `tb_short_conference_registration_screen_two_details` (
			`id` int(11) NOT NULL,
			`parentid` int(11) NOT NULL,
			`price_details_id` int(11) NOT NULL,
			`price_details_value` varchar(100) NOT NULL,
			`multply_by_no_of_people` int(11) NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		  ");

		$CI->db->query("CREATE TABLE `tb_short_conference_residence_country_notes` (
			`id` int(11) NOT NULL,
			`conferenceid` int(11) DEFAULT NULL,
			`country_id` int(11) DEFAULT NULL,
			`note_1` text NOT NULL,
			`note_2` text NOT NULL,
			`allow_payment_for_this_country` int(11) NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		  ");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_master`
		ADD PRIMARY KEY (`id`),
		ADD KEY `conferenceid` (`conferenceid`),
		ADD KEY `regionid` (`regionid`),
		ADD KEY `userid` (`userid`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_one`
		ADD PRIMARY KEY (`id`),
		ADD KEY `conferenceregistrationid` (`conferenceregistrationid`),
		ADD KEY `country_of_residence` (`country_of_residence`);");
	
		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_one_family_details`
		ADD PRIMARY KEY (`id`),
		ADD KEY `parentid` (`parentid`),
		ADD KEY `family_relationship` (`family_relationship`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_three`
		ADD PRIMARY KEY (`id`),
		ADD KEY `conferenceregistrationid` (`conferenceregistrationid`),
		ADD KEY `screen_one_id` (`screen_one_id`),
		ADD KEY `screen_two_id` (`screen_two_id`),
		ADD KEY `screen_one_detail_id` (`screen_one_detail_id`),
		ADD KEY `age_level_of_school` (`age_level_of_school`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_two`
		ADD PRIMARY KEY (`id`),
		ADD KEY `conferenceregistrationid` (`conferenceregistrationid`,`screen_one_id`),
		ADD KEY `be_a_member_fee` (`be_a_member_fee`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_two_details`
		ADD PRIMARY KEY (`id`),
		ADD KEY `parentid` (`parentid`,`price_details_id`),
		ADD KEY `price_details_id` (`price_details_id`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_residence_country_notes`
		ADD PRIMARY KEY (`id`),
		ADD KEY `conferenceid` (`conferenceid`,`country_id`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_master`
  		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18378;");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_one`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17926;");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_one_family_details`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1488;");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_three`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_two`
  		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_two_details`
  		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;");

		$CI->db->query("ALTER TABLE `tb_short_conference_residence_country_notes`
  		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_master`
		ADD CONSTRAINT `tb_short_conference_registration_master_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `imi_conf_restore2`.`tb_users` (`id`),
		ADD CONSTRAINT `tb_short_conference_registration_master_ibfk_2` FOREIGN KEY (`regionid`) REFERENCES `tb_short_conference_regions` (`id`),
		ADD CONSTRAINT `tb_short_conference_registration_master_ibfk_3` FOREIGN KEY (`conferenceid`) REFERENCES `tb_short_conference` (`id`);");

	}

	if($CI->db->query("SHOW TABLES LIKE 'tb_short_conference_prices_not_a_member'") ->num_rows() == 0){
		$CI->db->query("CREATE TABLE `tb_short_conference_prices_not_a_member` (
			`id` int(11) NOT NULL,
			`conferenceid` int(11) DEFAULT NULL,
			`name` varchar(255) NOT NULL,
			`price` double NOT NULL,
			`per` varchar(20) NOT NULL,
			`sort` int(11) NOT NULL DEFAULT '0',
			`membership_classification_id` int(11) DEFAULT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("CREATE TABLE `tb_short_conference_prices_not_a_member_languages` (
			`id` int(11) NOT NULL,
			`name` varchar(255) CHARACTER SET utf8 NOT NULL,
			`conference_prices_not_a_member_id` int(11) NOT NULL,
			`content_languages_id` int(11) NOT NULL
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$CI->db->query("ALTER TABLE `tb_short_conference_prices_not_a_member`
		ADD PRIMARY KEY (`id`),
		ADD KEY `conferenceid` (`conferenceid`),
		ADD KEY `membership_classification_id` (`membership_classification_id`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_prices_not_a_member_languages`
  		ADD PRIMARY KEY (`id`);");

		$CI->db->query("ALTER TABLE `tb_short_conference_prices_not_a_member`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;");

		$CI->db->query("ALTER TABLE `tb_short_conference_prices_not_a_member_languages`
		MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;");
	}

	if($CI->db->query("SHOW TABLES LIKE 'tb_short_conference_payments'") ->num_rows() == 0){
		$CI->db->query("CREATE TABLE `tb_short_conference_payments` (
			`id` int(11) NOT NULL,
			`userid` int(11) DEFAULT NULL COMMENT 'item_number (from Paypal POST)',
			`conferenceid` int(11) DEFAULT NULL,
			`conference_registration_id` int(11) DEFAULT NULL,
			`payer_email` varchar(255) NOT NULL,
			`payment_gross` double NOT NULL,
			`ipn_track_id` varchar(150) NOT NULL,
			`payer_id` varchar(150) NOT NULL,
			`payment_status` varchar(150) NOT NULL,
			`paypal_post` text NOT NULL,
			`date_added` datetime NOT NULL,
			`special_notes` text,
			`payment_mode` varchar(255) DEFAULT NULL,
			`request_data` longtext,
			`card_name` varchar(255) DEFAULT NULL,
			`card_type` varchar(255) DEFAULT NULL,
			`card_expiry` varchar(255) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); 
	$CI->db->query("ALTER TABLE tb_currencies ADD symbol varchar(255);	");
	}

	if($CI->db->query("SHOW TABLES LIKE 'tb_guest_users'") ->num_rows() == 0){
	
		$CI->db->query("CREATE TABLE `tb_guest_users` (
			`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`userid` int(11) NOT NULL,
			`status` varchar(255) NOT NULL,
			`date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$CI->db->query("ALTER TABLE tb_short_conference_registration_master
		ADD FOREIGN KEY (userid) REFERENCES imi_conf_restore2.tb_users(id);");

		$CI->db->query("ALTER TABLE tb_short_conference_registration_master
		ADD UNIQUE (userid);");

		$CI->db->query("ALTER TABLE tb_guest_users
		ADD FOREIGN KEY (userid) REFERENCES imi_conf_restore2.tb_users(id);");

		$CI->db->query("ALTER TABLE tb_guest_users
		ADD UNIQUE (userid);");

		$CI->db->query("ALTER TABLE tb_short_conference_registration_screen_one
		ADD UNIQUE (email);");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_master` DROP FOREIGN KEY `tb_short_conference_registration_master_ibfk_1`");

		$CI->db->query("CREATE TABLE `tb_guest_users` (
			`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,,
			`userid` int(11) NOT NULL,
			`status` varchar(255) NOT NULL,
			`date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$CI->db->query("ALTER TABLE `tb_short_conference_registration_screen_two_details` ADD `addon` varchar(255); ");
		$CI->db->query("ALTER TABLE tb_short_conference_registration_master ADD tax_receipt_num VARCHAR(255) NOT NULL AFTER registration_site");
	}

	if ( $CI->db->query("SHOW TABLES LIKE 'tb_family_relationships'") ->num_rows() == 0 ){
		$CI->db->query("CREATE TABLE `tb_family_relationships` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		$CI->db->query("INSERT INTO `tb_family_relationships` (`id`, `name`) VALUES
		(1,	'Wife'),
		(2,	'Husband'),
		(4,	'Sister'),
		(3,	'Brother'),
		(5,	'Mother'),
		(6,	'Father'),
		(7,	'Child'),
		(8,	'Niece'),
		(9,	'Nephew')");
	}
	// $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES 
	// 	 (415, 'Bulk Short Conference Receipt Zip', 'Bulk Short Conference Receipt Zip', 'manageshortconferenceregistration/controls/bulk_short_conference_receipt_zip', 'manageshortconferenceregistrationreceiptbulkshortconferencereceiptzip', 405, 0);");

	// $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES 
	// (411, 'View', 'View', 'manageshortconferencenotamember/controls/view', 'manageshortconferencenotamemberview', 405, 0);");
	// $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES (405, 'Manage Conference (Not A Member)', 'Manage Conference (Not A Member)', 'manageshortconferencenotamember/controls/view', 'manageshortconferencenotamember', 372, 1),
	// (406, 'Edit', 'Edit', 'manageshortconferencenotamember/controls/edit', 'manageshortconferencenotamemberedit', 405, 0),
	// (407, 'Save', 'Save', 'manageshortconferencenotamember/controls/save', 'manageshortconferencenotamembersave', 405, 0),
	// (408, 'Add', 'Add', 'manageshortconferencenotamember/controls/add', 'manageshortconferencenotamemberadd', 405, 0),
	// (409, 'Options', 'Options', 'manageshortconferencenotamember/controls/options', 'manageshortconferencenotamemberoptions', 405, 0),
	// (410, 'Delete', 'Delete', 'manageshortconferencenotamember/controls/delete', 'manageshortconferencenotamemberdelete', 409, 0);");
	
	/* $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES
	 (424, 'Manage Short Conference Registration Finance', 'Manage Short Conference Registration Finance', 'manageshortconferenceregistrationfinance/controls/view', 'manageshortconferenceregistrationfinance', 372, 1),
	(425, 'Edit', 'Edit', 'manageshortconferenceregistrationfinance/controls/edit', 'manageshortconferenceregistrationfinanceedit', 424, 0),
	(426, 'Options', 'Options', 'manageshortconferenceregistrationfinance/controls/options', 'manageshortconferenceregistrationfinanceoptions', 424, 0),
	(427, 'Receipt', 'Receipt', 'manageshortconferenceregistrationfinance/controls/receipt', 'manageshortconferenceregistrationfinancereceipt', 424, 0),
	(428, 'Bulk Short Conference Receipt Zip', 'Bulk Short Conference Receipt Zip', 'manageshortconferenceregistrationfinance/controls/bulk_short_conference_receipt_zip', 'manageshortconferenceregistrationfinancereceiptbulkshortconferencereceiptzip', 424, 0)"); */
	
	/* $CI->db->query("ALTER TABLE `tb_short_conference_registration_master`
	DROP FOREIGN KEY `tb_short_conference_registration_master_ibfk_1`"); */
	/* $CI->db->query("INSERT INTO `tb_admin_operations` (`id`, `menu_title`, `operation_title`, `path`, `operationid`, `parent`, `is_menu`) VALUES
	 (429, 'Manage Pending Payments', 'Manage Pending Payments', 'managependingpayments/controls/view', 'managependingpaymentsview', 417, 1)" ) ; */

	//  if ( $CI->db->query("SHOW COLUMNS FROM `tb_payment_receipts` LIKE 'created_at'")->num_rows() == 0 )
	// {
	// 	$CI->db->query("ALTER TABLE `tb_payment_receipts` ADD `created_at` datetime ; ");
	// }
}

// $CI->db_imiconf->query("ALTER TABLE tb_user_memberships
//     ADD membership_short_package_id INTEGER,
//     ADD CONSTRAINT FOREIGN KEY(membership_short_package_id ) REFERENCES imiportal_2.tb_short_conference_prices_not_a_member(id);");
	

	/*$languages_tables_record = $CI->db->query("SELECT TABLE_NAME from information_schema.TABLES where TABLE_SCHEMA = 'imiportal_2' and TABLE_NAME LIKE '%_languages' and TABLE_NAME not in ('tb_languages','tb_content_languages')");
    if ( $languages_tables_record->num_rows() > 0) {
        foreach ($languages_tables_record->result() as $key => $table) {
			$master_table = str_replace('_languages', '', $table->TABLE_NAME);

			$columns = $CI->db->query("SELECT group_concat(COLUMN_NAME) columns FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'imiportal_2' AND TABLE_NAME = '{$table->TABLE_NAME}' ")->row('columns');

			$tmp_cols = explode(',',$columns);
			foreach ($tmp_cols as $c_key => &$col) {
				if($col === "id" || $col === "content_languages_id" || $col === str_replace('tb_','', $master_table) . '_id'){
					unset($tmp_cols[$c_key]);
				}
			}
			
			$languages = $CI->db->query("SELECT * FROM tb_content_languages")->result();

			foreach ($languages as  $lang) {
				$CI->db->query("INSERT INTO {$table->TABLE_NAME} (".implode(',',$tmp_cols).",".str_replace('tb_','', $master_table)."_id, content_languages_id) SELECT ".implode(',',$tmp_cols).", id, {$lang->id} FROM $master_table");
			}
			
		}
		
    }*/

/*
CREATE TABLE IF NOT EXISTS `tb_users_profile` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cellphone_number` varchar(100) NOT NULL,
  `secondary_email_1` varchar(255) NOT NULL,
  `secondary_email_2` varchar(255) NOT NULL,
  `home_full_address` text NOT NULL,
  `home_country` int(11) NOT NULL,
  `home_state_province` varchar(255) NOT NULL,
  `home_city` varchar(255) NOT NULL,
  `home_phone_number` varchar(100) NOT NULL,
  `office_full_address` text NOT NULL,
  `office_country` int(11) NOT NULL,
  `office_state_province` varchar(255) NOT NULL,
  `office_city` varchar(255) NOT NULL,
  `office_phone_number` varchar(100) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `specialties` varchar(255) NOT NULL,
  `preffered_mode_of_contact` varchar(255) NOT NULL,
  //`other_member_can_see_profile` int(11) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_users_profile`
--
ALTER TABLE `tb_users_profile`
 ADD PRIMARY KEY (`id`), ADD KEY `userid` (`userid`,`office_country`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_users_profile`
--
ALTER TABLE `tb_users_profile`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
*/





$config								= array();

SessionHelper::site_settings_session();
SessionHelper::active_conference_session();





$TMP_glob_assets					= array( "*.js", "*.css" );
foreach ( $TMP_glob_assets as $g )
{
	foreach (glob( $g ) as $filename) 
	{
		$TMP_minutes			= $CI->functions->minutes_between_dates( strtotime("now"), fileatime($filename) );
		
		if ( $TMP_minutes > 120 )
		{
			unlink( $filename );
		}
	}
}