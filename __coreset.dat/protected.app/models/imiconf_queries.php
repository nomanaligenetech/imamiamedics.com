<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Imiconf_Queries extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	
	public function users( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, (CASE WHEN (is_active = 1) THEN 'Yes' ELSE 'No' END) as is_active_name, (CASE WHEN (is_blocked = 1) THEN 'Yes' ELSE 'No' END) as is_blocked_name ";
		}
		if ($select_where == 2)
		{
			return "tb_users";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function user_memberships( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_user_memberships";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function users_profile( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, (SELECT countries_name FROM tb_countries WHERE id = tb_users_profile.home_country) as  home_country_name, (SELECT countries_name FROM tb_countries WHERE id = tb_users_profile.office_country) as  office_country_name ";
		}
		if ($select_where == 2)
		{
			return "tb_users_profile";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	
	
	public function conference_prices_not_a_member( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, 
						(SELECT name FROM tb_conference WHERE id = tb_conference_prices_not_a_member.conferenceid) as conference_name";
		}
		if ($select_where == 2)
		{
			return " tb_conference_prices_not_a_member ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function conference( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	* ";
		}
		if ($select_where == 2)
		{
			return " tb_conference ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function conference_regions( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, 
						(SELECT name FROM tb_conference WHERE id = tb_conference_regions.conferenceid) as conference_name,
						(CASE WHEN (allow_payment = 1) THEN 'Yes' ELSE 'No' END) as allow_payment_name";
		}
		if ($select_where == 2)
		{
			return " tb_conference_regions ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function conference_registration_master( $select_where = 0, $where = '' )
	{
		
		
		if ($select_where == 0)
		{
			return " *, 
					 (SELECT name FROM tb_conference WHERE id = tb_conference_registration_master.conferenceid) as conference_name,
					 (SELECT CONCAT (name, ' ', last_name) FROM `tb_users`  WHERE id = tb_conference_registration_master.userid) as user_name,
					 
					 (SELECT name FROM  tb_conference_regions WHERE id = tb_conference_registration_master.regionid) as region_name,
					 
					 (SELECT email FROM  tb_users WHERE id = tb_conference_registration_master.userid) as user_email,
					 
					 (SELECT email FROM  tb_conference_registration_screen_one WHERE conferenceregistrationid = tb_conference_registration_master.id ) as email ,
					 (SELECT phone FROM  tb_conference_registration_screen_one WHERE conferenceregistrationid = tb_conference_registration_master.id ) as phone ,	
		
					 (SELECT password FROM  tb_users WHERE id = tb_conference_registration_master.userid) as user_password";
		}
		if ($select_where == 2)
		{
			return "tb_conference_registration_master";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function conference_registration_screen_one( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, (SELECT name FROM `tb_conference_regions` 
						 WHERE id IN (SELECT regionid FROM `tb_conference_registration_master` 
									  WHERE id = tb_conference_registration_screen_one.conferenceregistrationid)
						) as region_name,
			
						
						(SELECT countries_name FROM `tb_countries` WHERE id = (SELECT country_of_birth FROM `tb_conference_registration_screen_three` 
																			   WHERE screen_one_id = tb_conference_registration_screen_one.id AND parentid = 0)) as  country_name_of_birth,
						
						(SELECT photo_image FROM `tb_conference_registration_screen_three` WHERE screen_one_id = tb_conference_registration_screen_one.id AND parentid = 0) as photo_image,
						
						(SELECT place_of_birth FROM tb_conference_registration_screen_three WHERE screen_one_id = tb_conference_registration_screen_one.id AND parentid = 0) as place_of_birth,
						
						(SELECT occupation FROM tb_conference_registration_screen_three WHERE screen_one_id = tb_conference_registration_screen_one.id AND parentid = 0) as occupation,
						
						(SELECT id FROM tb_conference_registration_screen_three WHERE screen_one_id = tb_conference_registration_screen_one.id AND parentid = 0) as three_id,
						
						
						(SELECT email FROM `tb_users` 
						 WHERE id IN (SELECT userid FROM `tb_conference_registration_master` 
									  WHERE id = tb_conference_registration_screen_one.conferenceregistrationid)
						) as user_registration_email ";
		}
		if ($select_where == 2)
		{
			return "tb_conference_registration_screen_one";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function conference_registration_screen_two( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, 
					(SELECT price FROM `tb_conference_prices_not_a_member` WHERE id = tb_conference_registration_screen_two.be_a_member_fee) as be_a_member_fee_price  ";
		}
		if ($select_where == 2)
		{
			return "tb_conference_registration_screen_two";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function conference_registration_screen_three( $select_where = 0, $where = '' )
	{
		$this->db->_protect_identifiers		= false;
		
		if ($select_where == 0)
		{
			return " *, 
					(SELECT name FROM `tb_conference`  WHERE id IN ( (SELECT conferenceid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid))) as conference_name,
			
					(SELECT CONCAT (name, ' ', last_name) FROM `tb_users`  WHERE id IN ( (SELECT userid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid))) as user_name,
					
					(SELECT payment_allow FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid ) as  payment_allow,
					
					(SELECT payment_type FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid ) as  payment_type,
					
					(SELECT userid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid ) as userid,
					
					(SELECT conferenceid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid ) as conferenceid,
					
					(SELECT regionid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid ) as region_id,
					
					(SELECT  travelling_with FROM  tb_conference_registration_screen_one WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) as travelling_with,
					
					(CASE WHEN ((SELECT   coupon_code  FROM  tb_conference_registration_screen_two WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) != '' ) THEN 'Yes' ELSE 'No' END) as is_coupon_code  ,
		
					(SELECT   coupon_code  FROM  tb_conference_registration_screen_two WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid )  as coupon_code  ,
		
					(SELECT CONCAT(name, ' :: $', price) FROM `tb_conference_prices_not_a_member` WHERE id = (SELECT be_a_member_fee  FROM  tb_conference_registration_screen_two WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid )  ) as be_a_member_fee_desc  ,
					
					(SELECT  price_total_payable FROM  tb_conference_registration_screen_two WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) as  price_total_payable ,
					
					(SELECT  price_cash_onsite FROM  tb_conference_registration_screen_two WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) as  price_cash_onsite ,
					
					(SELECT  price_less_absfee FROM  tb_conference_registration_screen_two WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) as  price_less_absfee  ,
					
					(CASE WHEN ((SELECT  price_less_absfee FROM  tb_conference_registration_screen_two WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) > 0 ) THEN 'Yes' ELSE 'No' END) as is_abstract_submitted,
					
					(SELECT is_paid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid ) as is_paid,
					
					(SELECT date_added FROM tb_conference_payments WHERE conference_registration_id = tb_conference_registration_screen_three.conferenceregistrationid AND payment_status = 'Completed' LIMIT 1) as registration_date,
					
					(SELECT  email FROM  tb_conference_registration_screen_one WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) as email ,
					
					(SELECT phone FROM  tb_conference_registration_screen_one WHERE conferenceregistrationid = tb_conference_registration_screen_three.conferenceregistrationid ) as phone ,
					
					
					(CASE WHEN ((SELECT is_paid FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid) = 1 ) THEN 'Yes' ELSE 'No' END) as is_paid_name,
					
					(SELECT family_email FROM `tb_conference_registration_screen_one_family_details` WHERE id = tb_conference_registration_screen_three.screen_one_detail_id) as family_email,
					
					(SELECT name FROM tb_family_relationships WHERE id = (SELECT family_relationship FROM `tb_conference_registration_screen_one_family_details` WHERE id = tb_conference_registration_screen_three.screen_one_detail_id)) as family_relationship ";
		}
		/*(SELECT date_added FROM  tb_conference_registration_master WHERE id = tb_conference_registration_screen_three.conferenceregistrationid ) as registration_date,*/
		if ($select_where == 2)
		{
			return "tb_conference_registration_screen_three";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	
	public function conference_registration_excel( $select_where = 0, $where = '' )
	{
		
		$this->db->_protect_identifiers		= false;
		
		
		if ($select_where == 0)
		{
			return "  *, (SELECT name FROM tb_conference WHERE id = tb_conference_registration_excel.conferenceid) as conference_name,
					(SELECT CONCAT(name, ' ', last_name) FROM tb_users WHERE id = tb_conference_registration_excel.user_id) as submitted_by ";
		}
		if ($select_where == 2)
		{
			return " tb_conference_registration_excel ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function conference_registration_excel_homedetails( $select_where = 0, $where = '' )
	{
		
		$this->db->_protect_identifiers		= false;
		
		
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_conference_registration_excel_homedetails ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function conference_registration_excel_officedetails( $select_where = 0, $where = '' )
	{
		
		$this->db->_protect_identifiers		= false;
		
		
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_conference_registration_excel_officedetails ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function conference_registration_excel_familymembers( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_conference_registration_excel_familymembers ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function conference_registration_excel_documents( $select_where = 0, $where = '' )
	{
		
		$this->db->_protect_identifiers		= false;
		
		
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_conference_registration_excel_documents ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function family_relationships( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_family_relationships ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	

	
	
	public function site_settings_master( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_site_settings_master ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function users_profile_picture( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, (SELECT countries_name FROM tb_countries WHERE id = tb_users_profile.home_country) as  home_country_name ";
		}
		if ($select_where == 2)
		{
			return "tb_users_profile";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function getUsers( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_users ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function countries( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_countries ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function conference_payments( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_conference_payments ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function user_family_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  fd.*,fr.name as family_relationship_name ";
		}
		if ($select_where == 2)
		{
			return "tb_conference_registration_screen_one_family_details fd Join tb_family_relationships fr ON fd.family_relationship = fr.id ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function arbaeenmedicalmission( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " amm.*,uv.membership_details_package_name, a.username as interviewer_username, a.email as interviewer_email ";
		}
		if ($select_where == 2)
		{
			return "tb_arbaeen_medical_mission amm LEFT JOIN users_view uv ON uv.email = amm.email LEFT JOIN `imiportal_2`.tb_admin a ON a.id = amm.interviewer";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function arbaeenmedicalmission_content( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_arbaeen_medical_mission_content";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function arbaeenmedicalmission_content_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_arbaeenmedicalmission_content_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function membership_classification_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_membership_classification_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function arbaeen_medical_mission_stage3($select_where = 0, $where = '')
	{
		if ($select_where == 0) {
			return " * ";
		}
		if ($select_where == 2) {
			return "tb_arbaeen_medical_mission_stage3";
		} else {
			return " 1 = 1 $where ";
		}
	}

}