<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls_Include extends C_admincms {

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
	}
	
	
	function _switchConference( $conference_slug, &$data, $case = false  )
	{
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima-') !== FALSE:
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
		
	}
	
	
	public function _9( &$data )
	{
		
	}
	
	public function _10( &$data )
	{
		
	}

	public function _12( &$data )
	{
		
	}
	
	
	
	
	
	
	public function view_table_properties( $conference_slug = FALSE )
	{
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima-') !== FALSE:
				return $this -> view_table_properties_12();
				break;
			
			case strpos($conference_slug, '10th') !== FALSE:
				return $this -> view_table_properties_10();
				break;
				
			case strpos($conference_slug, '9th') !== FALSE:
				return $this -> view_table_properties_9();
				break;
				
			default:
				return $this -> view_table_properties_8();
				break;
		}	
	}
	
	
	public function view_table_properties_8()
	{
		$tmp["tr_heading"]											= array( 'Name',
																			 'Registered As', 
																			 'Registered For',  
																			 'Relation',
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
		
		return $tmp;	
	}
	
	public function view_table_properties_9()
	{
		$tmp["tr_heading"]											= array( 
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
		
		return $tmp;	
	}
	
	
	public function view_table_properties_10()
	{
		$tmp["tr_heading"]											= array( 
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
																			 'Registration Details');
		
		return $tmp;	
	}

	public function view_table_properties_12()
	{
		$tmp["tr_heading"]											= array( 
																			 'Full Name', 
																			//  'Registered As', 
																			 'Registered For',
																			//  'Relation',
																			 'Payment Date',
																			 'Email',  
																			 'Phone',
																			 'Price',
																			 'Payment Type',
																			//  'Payment Status',
																			 'Registration Details',
																			 'Receipt No.',
																			 'Registration Receipt'
																			);
		
		return $tmp;	
	}
	
	
	public function fetch_records_for_view( $id = array(), $where = FALSE, $conference_slug = FALSE )
	{
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima-') !== FALSE:
				return $this -> fetch_records_for_view_12($id, $where);
				break;
			
			case strpos($conference_slug, '10th') !== FALSE:
				return $this -> fetch_records_for_view_10($id, $where);
				break;
				
			case strpos($conference_slug, '9th') !== FALSE:
				return $this -> fetch_records_for_view_9($id, $where);
				break;
				
			default:
				return $this -> fetch_records_for_view_8($id, $where);
				break;
		}
	}
	
	public function fetch_records_for_view_8( $id = array(), $where = FALSE )
	{
		$TMP_conferenceid 				= SessionHelper::_get_session('id', 'conference');
		$TMP_id							= '';
		$TMP_spaces						= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ( count($id) > 0 )
		{
			$TMP_id						= " AND id in (". implode(",", $id) .")";
			$TMP_spaces					= "            ";
		}
	
		#ALL registrations (which are is_paid = 1    OR     is_paid = 0, payment_allow = 0, payment_type = 'cash'
		$obj_parentchild = new ParentChild();
		$obj_parentchild->db_table="tb_short_conference_registration_screen_three";	
		$obj_parentchild->item_identifier_field_name="id";
		$obj_parentchild->parent_identifier_field_name="parentid";
		$obj_parentchild->item_list_field_name="name"; 
		
		/*AND ( screen_one_detail_id = 0 || screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid))  )*/
		$obj_parentchild->extra_condition="  AND 
											 ( 
											 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1
												
												|| 
												
												( 
												 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = 
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0
													
													AND 
													
													(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0 
													
													AND 
													
													(SELECT payment_type  FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 'cash' 
												 ) 
											  )
											 
											 AND 
												
											(SELECT conferenceid FROM tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = {$TMP_conferenceid}
											 
											 $where
											 $TMP_id	";
		$obj_parentchild->order_by_phrase="ORDER BY registration_date DESC";
		$obj_parentchild->level_identifier="$TMP_spaces";
		$obj_parentchild->item_pointer="";
		$root_item_id = 0;
		$extra_select = " *, 
		
		(SELECT name FROM `tb_short_conference`  WHERE id IN ( (SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as conference_name,
		
		(SELECT CONCAT (name, ' ', last_name) FROM imi_conf_restore2.tb_users  WHERE id IN ( (SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as user_name,
		
		(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_allow,
		
		(SELECT payment_type FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_type,
		
		(SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as userid,
					
		(SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conferenceid,
		
		(SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as region_id,
		
		
		
		(SELECT  travelling_with FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as travelling_with,
		
		(CASE WHEN ((SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) != '' ) THEN 'Yes' ELSE 'No' END) as is_coupon_code  ,
		
		(SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  as coupon_code  ,
		
		(SELECT CONCAT(name, ' :: $', price) FROM `tb_short_conference_prices_not_a_member` WHERE id = (SELECT be_a_member_fee  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  ) as be_a_member_fee_desc  ,
		
		(SELECT  price_total_payable FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_total_payable ,
		
		(SELECT  price_cash_onsite FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_cash_onsite ,
		
		(SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_less_absfee  ,
		
		(CASE WHEN ((SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) > 0 ) THEN 'Yes' ELSE 'No' END) as is_abstract_submitted,
		
		(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as is_paid,
		
		(SELECT date_added FROM tb_short_conference_payments WHERE conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid AND payment_status = 'Completed' LIMIT 1) as registration_date,
		
		(SELECT  email FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as email ,
					
		(SELECT phone FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as phone ,			
					
		(CASE WHEN ((SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 ) THEN 'Yes' ELSE 'No' END) as is_paid_name,
		
		(SELECT family_email FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id) as family_email,
		
		(SELECT name FROM tb_family_relationships WHERE id = (SELECT family_relationship FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id)) as family_relationship
		
		";
		
		/*(SELECT date_added FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as registration_date,*/
		
		$a =  $obj_parentchild->getAllChilds($root_item_id, '', true, $extra_select);	

		
		return conferenceregistrations_cleanfilter( $a, TRUE );
	}
	
	public function fetch_records_for_view_9( $id = array(), $where = FALSE )
	{
		$TMP_conferenceid 				= SessionHelper::_get_session('id', 'conference');
		$TMP_id							= '';
		$TMP_spaces						= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ( count($id) > 0 )
		{
			$TMP_id						= " AND id in (". implode(",", $id) .")";
			$TMP_spaces					= "            ";
		}
	
		#ALL registrations (which are is_paid = 1    OR     is_paid = 0, payment_allow = 0, payment_allow = 1, payment_type = 'cash'
		$obj_parentchild = new ParentChild();
		$obj_parentchild->db_table="tb_short_conference_registration_screen_three";	
		$obj_parentchild->item_identifier_field_name="id";
		$obj_parentchild->parent_identifier_field_name="parentid";
		$obj_parentchild->item_list_field_name="full_name"; 
		
		/*AND ( screen_one_detail_id = 0 || screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid))  )*/
		$obj_parentchild->extra_condition="  AND 
											 ( 
											 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1
												
												|| 
												
												( 
												 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = 
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0
													
													AND 
													
													(
													 	(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0 
													 	|| 
														
														(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 
													
													)
													
													AND 
													
													(
														(SELECT payment_type  FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 'cash' 
														AND
														(SELECT payment_type  FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) IS NOT NULL

													)
												 ) 
											  )
											 
											 AND 
												
											(SELECT conferenceid FROM tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = {$TMP_conferenceid}
											 
											 $where
											 $TMP_id	";
		$obj_parentchild->order_by_phrase="ORDER BY registration_date DESC";
		$obj_parentchild->level_identifier="$TMP_spaces";
		$obj_parentchild->item_pointer="";
		$root_item_id = 0;
		$extra_select = " *, 
		
		(SELECT name FROM `tb_short_conference`  WHERE id IN ( (SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as conference_name,
		
		(SELECT CONCAT (name, ' ', last_name) FROM imi_conf_restore2.tb_users  WHERE id IN ( (SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as user_name,
		
		(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_allow,
		
		(SELECT payment_type FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_type,
		
		(SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as userid,
					
		(SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conferenceid,
		
		(SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as region_id,
		
		(SELECT  travelling_with FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as travelling_with,
		
		(CASE WHEN ((SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) != '' ) THEN 'Yes' ELSE 'No' END) as is_coupon_code  ,
		
		(SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  as coupon_code  ,
		
		(SELECT CONCAT(name, ' :: $', price) FROM `tb_short_conference_prices_not_a_member` WHERE id = (SELECT be_a_member_fee  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  ) as be_a_member_fee_desc  ,
		
		(SELECT  price_total_payable FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_total_payable ,
		
		(SELECT  price_cash_onsite FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_cash_onsite ,
		
		(SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_less_absfee  ,
		
		(CASE WHEN ((SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) > 0 ) THEN 'Yes' ELSE 'No' END) as is_abstract_submitted,
		
		(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as is_paid,
		
		(SELECT date_added FROM tb_short_conference_payments WHERE conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid AND payment_status = 'Completed' LIMIT 1) as registration_date,
		
		(SELECT  email FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as email ,
					
		(SELECT phone FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as phone ,
		
		phone as phone_screen_3,
		
		email as email_screen_3,
					
		(CASE WHEN ((SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 ) THEN 'Yes' ELSE 'No' END) as is_paid_name,
		
		(SELECT family_email FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id) as family_email,
		
		(SELECT name FROM tb_family_relationships WHERE id = (SELECT family_relationship FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id)) as family_relationship,
		
		
		(SELECT  earlybird_regular FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as earlybird_regular  ,
		
		(SELECT  be_a_member FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as be_a_member  ,
		
		(SELECT  price_package_fee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_package_fee  ,
		
		(SELECT  speaker_coupon_code FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as speaker_coupon_code ,
		
		(SELECT  paymenttypeid FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as paymenttypeid
		
		
		";
		
		/*(SELECT date_added FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as registration_date,*/
		
		$a =  $obj_parentchild->getAllChilds($root_item_id, '', true, $extra_select);	
		
		return conferenceregistrations_cleanfilter( $a, TRUE );
	}

	public function fetch_records_for_view_12( $id = array(), $where = FALSE )
	{
		$TMP_conferenceid 				= SessionHelper::_get_session('id', 'conference');
		$TMP_id							= '';
		$TMP_spaces						= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ( count($id) > 0 )
		{
			$TMP_id						= " AND id in (". implode(",", $id) .")";
			$TMP_spaces					= "            ";
		}
		#ALL registrations (which are is_paid = 1    OR     is_paid = 0, payment_allow = 0, payment_type = 'cash'
		
		$obj_parentchild = new ParentChild();
		$obj_parentchild->db_table="tb_short_conference_registration_screen_three";	
		$obj_parentchild->item_identifier_field_name="id";
		$obj_parentchild->parent_identifier_field_name="parentid";
		$obj_parentchild->item_list_field_name="full_name"; 
		
		/*AND ( screen_one_detail_id = 0 || screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid))  )*/
		
		#if is_paid = 1
		#if is_paid = 0 and (payment allow = 1 or 0) and with cash
		#if is_paid = 0
		$obj_parentchild->extra_condition="  AND 
											 ( 
											 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1
												
												|| 
												
												( 
												 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = 
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0
													
													AND 
													
													(
													 	(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0 
													 	|| 
														
														(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 
													
													)
													
													AND 
													
													(
														(SELECT payment_type  FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 'cash' 														

													)
												 ) 
												 
											  )
											 
											 AND 
												
											(SELECT conferenceid FROM tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = {$TMP_conferenceid}
											
											 
											 $where
											 $TMP_id	";
		$obj_parentchild->order_by_phrase="ORDER BY three_step_date DESC";

		$obj_parentchild->level_identifier="$TMP_spaces";
		$obj_parentchild->item_pointer="";
		$root_item_id = 0;
		$extra_select = " *, 
		
		(SELECT name FROM `tb_short_conference`  WHERE id IN ( (SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as conference_name,
		
		(SELECT CONCAT (name, ' ', last_name) FROM imi_conf_restore2.tb_users  WHERE id IN ( (SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as user_name,
		
		(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_allow,
		
		(SELECT payment_type FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_type,
		
		(SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as userid,

		(SELECT tax_receipt_num FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as tax_receipt_num,
					
		(SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conferenceid,
		
		(SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as region_id,
		
		(SELECT show_rates_in_currency	 FROM  tb_short_conference_regions WHERE id = (SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid )) as region_show_rates_in_currency,
		
		(SELECT  travelling_with FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as travelling_with,
		
		(CASE WHEN ((SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) != '' ) THEN 'Yes' ELSE 'No' END) as is_coupon_code  ,
		
		(SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  as coupon_code  ,
		
		(SELECT CONCAT(name, ' :: $', price) FROM `tb_short_conference_prices_not_a_member` WHERE id = (SELECT be_a_member_fee  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  ) as be_a_member_fee_desc  ,
		
		(SELECT  price_total_payable FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_total_payable ,
		
		(SELECT  price_cash_onsite FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_cash_onsite ,
		
		(SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_less_absfee  ,
		
		(CASE WHEN ((SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) > 0 ) THEN 'Yes' ELSE 'No' END) as is_abstract_submitted,
		
		(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as is_paid,
		
		(SELECT date_added FROM tb_short_conference_payments WHERE conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid AND payment_status = 'Completed' LIMIT 1) as registration_date,
		
		(SELECT date_added FROM tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as three_step_date,
		
		(SELECT  email FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as email ,
					
		(SELECT phone FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as phone ,
		
		phone as phone_screen_3,
		
		email as email_screen_3,
					
		(CASE WHEN ((SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 ) THEN 'Yes' ELSE 'No' END) as is_paid_name,
		
		(SELECT family_email FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id) as family_email,
		
		(SELECT name FROM tb_family_relationships WHERE id = (SELECT family_relationship FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id)) as family_relationship,
		
		
		(SELECT  earlybird_regular FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as earlybird_regular  ,
		
		(SELECT  be_a_member FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as be_a_member  ,
		
		(SELECT  price_package_fee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_package_fee  ,
		
		(SELECT  speaker_coupon_code FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as speaker_coupon_code ,
		
		(SELECT  paymenttypeid FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as paymenttypeid,
		(SELECT date_added FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conference_master_date_added
		
		";
		/*(SELECT date_added FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as registration_date,*/
		
		$a =  $obj_parentchild->getAllChilds($root_item_id, '', true, $extra_select);	
		return conferenceregistrations_cleanfilter( $a, TRUE );
	}
	
	public function fetch_records_for_view_10( $id = array(), $where = FALSE )
	{
		$TMP_conferenceid 				= SessionHelper::_get_session('id', 'conference');
		$TMP_id							= '';
		$TMP_spaces						= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if ( count($id) > 0 )
		{
			$TMP_id						= " AND id in (". implode(",", $id) .")";
			$TMP_spaces					= "            ";
		}
	
		#ALL registrations (which are is_paid = 1    OR     is_paid = 0, payment_allow = 0, payment_type = 'cash'
		
		
		$obj_parentchild = new ParentChild();
		$obj_parentchild->db_table="tb_short_conference_registration_screen_three";	
		$obj_parentchild->item_identifier_field_name="id";
		$obj_parentchild->parent_identifier_field_name="parentid";
		$obj_parentchild->item_list_field_name="full_name"; 
		
		/*AND ( screen_one_detail_id = 0 || screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid))  )*/
		
		#if is_paid = 1
		#if is_paid = 0 and (payment allow = 1 or 0) and with cash
		#if is_paid = 0
		$obj_parentchild->extra_condition="  AND 
											 ( 
											 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1
												
												|| 
												
												( 
												 	(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = 
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0
													
													AND 
													
													(
													 	(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 0 
													 	|| 
														
														(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 
													
													)
													
													AND 
													
													(
														(SELECT payment_type  FROM  tb_short_conference_registration_master WHERE id =
tb_short_conference_registration_screen_three.conferenceregistrationid) = 'cash' 														

													)
												 ) 
												 
											  )
											 
											 AND 
												
											(SELECT conferenceid FROM tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = {$TMP_conferenceid}
											 
											 $where
											 $TMP_id	";
		$obj_parentchild->order_by_phrase="ORDER BY registration_date DESC";
		$obj_parentchild->level_identifier="$TMP_spaces";
		$obj_parentchild->item_pointer="";
		$root_item_id = 0;
		$extra_select = " *, 
		
		(SELECT name FROM `tb_short_conference`  WHERE id IN ( (SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as conference_name,
		
		(SELECT CONCAT (name, ' ', last_name) FROM imi_conf_restore2.tb_users  WHERE id IN ( (SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as user_name,
		
		(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_allow,
		
		(SELECT payment_type FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_type,
		
		(SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as userid,
					
		(SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conferenceid,
		
		(SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as region_id,
		
		(SELECT show_rates_in_currency	 FROM  tb_short_conference_regions WHERE id = (SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid )) as region_show_rates_in_currency,
		
		(SELECT  travelling_with FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as travelling_with,
		
		(CASE WHEN ((SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) != '' ) THEN 'Yes' ELSE 'No' END) as is_coupon_code  ,
		
		(SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  as coupon_code  ,
		
		(SELECT CONCAT(name, ' :: $', price) FROM `tb_short_conference_prices_not_a_member` WHERE id = (SELECT be_a_member_fee  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  ) as be_a_member_fee_desc  ,
		
		(SELECT  price_total_payable FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_total_payable ,
		
		(SELECT  price_cash_onsite FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_cash_onsite ,
		
		(SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_less_absfee  ,
		
		(CASE WHEN ((SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) > 0 ) THEN 'Yes' ELSE 'No' END) as is_abstract_submitted,
		
		(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as is_paid,
		
		(SELECT date_added FROM tb_short_conference_payments WHERE conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid AND payment_status = 'Completed' LIMIT 1) as registration_date,
		
		(SELECT  email FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as email ,
					
		(SELECT phone FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as phone ,
		
		phone as phone_screen_3,
		
		email as email_screen_3,
					
		(CASE WHEN ((SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 ) THEN 'Yes' ELSE 'No' END) as is_paid_name,
		
		(SELECT family_email FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id) as family_email,
		
		(SELECT name FROM tb_family_relationships WHERE id = (SELECT family_relationship FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id)) as family_relationship,
		
		
		(SELECT  earlybird_regular FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as earlybird_regular  ,
		
		(SELECT  be_a_member FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as be_a_member  ,
		
		(SELECT  price_package_fee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_package_fee  ,
		
		(SELECT  speaker_coupon_code FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as speaker_coupon_code ,
		
		(SELECT  paymenttypeid FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as paymenttypeid,
		(SELECT date_added FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conference_master_date_added
		
		";
		
		/*(SELECT date_added FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as registration_date,*/
		
		$a =  $obj_parentchild->getAllChilds($root_item_id, '', true, $extra_select);	
		return conferenceregistrations_cleanfilter( $a, TRUE );
	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "userid", "conferenceid", "gender", "name", "middle_name", "father_name", "surname", "passport_number", "passport_type", "date_of_birth|default_date", "place_of_birth", "country_of_birth", "nationality", "passport_image", "photo_image", "marital_status", "gender_father_name", "previous_nationality", "place_of_issue", "date_of_issue|default_date", "expiry_date|default_date", "occupation", "position", "name_of_institute_company", "title_of_activity", "visa_insurance_place", "duration_of_stay", "no_of_previous_travels", "date_of_entry_for_conference|default_date", "last_date_of_entry|default_date", "date_of_departure|default_date", "date_added", "registration_date|default_date", "is_paid", "parentid", "options", "unique_formid",
											
											"full_name", "email", "phone", "mailing_address", "speciality_interest", "age_level_of_school" );
		
		$filled_inputs				= array( "id", "userid", "conferenceid", "gender", "name", "middle_name", "father_name", "surname", "passport_number", "passport_type", "date_of_birth", "place_of_birth", "country_of_birth", "nationality", "passport_image", "photo_image", "marital_status", "gender_father_name", "previous_nationality", "place_of_issue", "date_of_issue", "expiry_date", "occupation", "position", "name_of_institute_company", "title_of_activity", "visa_insurance_place", "duration_of_stay", "no_of_previous_travels", "date_of_entry_for_conference", "last_date_of_entry", "date_of_departure", "date_added", "registration_date", "is_paid", "parentid", "options", "unique_formid",
											
											"full_name", "email", "phone", "mailing_address", "speciality_interest", "age_level_of_school" );
		
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
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */