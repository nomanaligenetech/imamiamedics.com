<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screen_Two extends C_frontend {

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
		
		$this->data['confreg_paymenttype_dropdown']					= DropdownHelper::short_conferenceregistration_paymenttype();
		$this->data['tmp_paymenttype']								= DropdownHelper::short_conferenceregistration_paymenttype(TRUE, TRUE);
		$this->data['tmp_earlybird_regular']						= DropdownHelper::short_conferenceprice_earlybird_regular_dropdown();
		
		$this->data['numbers_multiplyby']							= NumberHelper::number_array( range("1", "10") );
		$this->data['numbers_multiplyby_onlyone']					= NumberHelper::number_array( range("1", "1") );
		
		
		$this->_create_fields_for_form(FALSE, $this->data);
		
		
		$this->data['breadcrumbs'][1]								= "stepcompleted";
		$this->data['breadcrumbs'][2]								= "active";
		
		
		$this->data['_messageBundle2']								= $this->data['_messageBundle2_nofamilyguest']				= $this->data['_messageBundle'];
		
		
		$this->data['_messageBundle_youcanalwaysresumelater']		= $this->_messageBundle('warning' , 
																							lang_line("text_youcanalwayspaylater"), 
																							lang_line("heading_operation_info") . ':' );
		
	}


	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs			= array( "id", "conferenceregistrationid", "screen_one_id", "earlybird_regular", "paymenttypeid", "be_a_member|default_zero", "be_a_member_fee", "coupon_code",
											"speaker_coupon_code",
										 "date_added", "date_modified" );
		
		$filled_inputs			= array( "id", "conferenceregistrationid", "screen_one_id", "earlybird_regular", "paymenttypeid", "be_a_member", "be_a_member_fee", "coupon_code",
											"speaker_coupon_code",
										 "date_added", "date_modified" );
		
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
						
						case "default_zero":	
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
							$tmp_value				= "0";
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
	
	
	
	public function _create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{
		#print_r($db_data);
		$empty_inputs				= array("registration_tickets", "registration_tickets_child", "price_details_id", "multiply_by");
		
		$filled_inputs				= array("registration_tickets", "registration_tickets_child", "price_details_id", "multiply_by");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
				// if (  $empty_inputs[$x]  == "registration_tickets" || array_key_exists("for_registration_tickets", $db_data) )
				// {
					
				// 	if ( array_key_exists("earlybird_regular" , $db_data) )
				// 	{
						
				// 		$_parent_value				= $db_data['earlybird_regular'] . "_" . $db_data['paymenttypeid'];
				// 		$data[ $empty_inputs[$x] ][ $db_data['earlybird_regular'] ][  $db_data['paymenttypeid'] ]	= $_parent_value;
				// 	}
				// }
				
				// else if (  $empty_inputs[$x]  == "registration_tickets_child" || array_key_exists("for_registration_tickets_child", $db_data) )
				// {
					
				// 	for ($m=0; $m < count($db_data); $m++)
				// 	{
				// 		if ( array_key_exists('price_details_id' , $db_data[$m]) )
				// 		{
				// 			$data[ $empty_inputs[$x] ][ $db_data[$m][ 'price_details_id' ] ]	= $db_data[$m][ 'price_details_value' ];
				// 			#$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
							
				// 		}
				// 	}
				// }
				if (  $empty_inputs[$x]  == "multiply_by" || array_key_exists("for_registration_tickets_child", $db_data) )
				{
					
					for ($m=0; $m < count($db_data); $m++)
					{
						if ( array_key_exists('price_details_id' , $db_data[$m]) )
						{
							$data[ $empty_inputs[$x] ][ $db_data[$m][ 'price_details_id' ] ]	= $db_data[$m][ 'multply_by_no_of_people' ];
							#$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
							
						}
					}
				}
				
				else
				{
					for ($m=0; $m < count($db_data); $m++)
					{
						
						if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
						{
							$data[ $empty_inputs[$x] ][ $m ]	= $db_data[$m][ $filled_inputs[$x] ];
							#$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
							
						}
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
				
				
				if ( $empty_inputs[$x] == "not_a_member" )
				{
					foreach ( $data['conference_prices_not_a_member']->result_array() as $notamember)
					{
						$data[ $empty_inputs[$x] ][ $notamember['id'] ]				= '';
					}
				}
				else
				{
					foreach ($data['tmp_earlybird_regular'] as $e_key => $e_value)
					{
					
						foreach ($data['tmp_paymenttype']['members'] as $p_key => $p_value)
						{
							$pricetype_id			= $p_key;
							$eb_regular				= $e_key;
							
							
							
							if ( $empty_inputs[$x] == "registration_tickets" )
							{
								$data[ $empty_inputs[$x] ][ $eb_regular ][ $pricetype_id ]		= '';
							}
							else
							{
								if ( is_array($data['prices_chart']['members'][ $eb_regular ][$pricetype_id]) )
								{
									foreach ($data['prices_chart']['members'][ $eb_regular ][$pricetype_id] as $key => $value)
									{
										$data[ $empty_inputs[$x] ][ $value['id'] ]		= '';
										
										/*$this->form_validation->set_rules(	"registration_tickets[" . $eb_regular . "][" . $pricetype_id . "][" . $value['id'] . "]", 
																			'Registration Tickets', 'trim|required');
										$is_options_selected		= TRUE;*/
									}
								}
							}
							
							
						}
						
						
						foreach ($data['tmp_paymenttype']['others'] as $p_key => $p_value)
						{
							$pricetype_id			= 3;
							$eb_regular				= $e_key;
							
							
							
							if ( $empty_inputs[$x] == "registration_tickets" )
							{
								$data[ $empty_inputs[$x] ][ $eb_regular ][ $pricetype_id ]		= '';
							}
							else
							{
								
								if ( is_array($data['prices_chart']['others'][ $eb_regular ]) )
								{
									
									foreach ($data['prices_chart']['others'][ $eb_regular ] as $key => $value)
									{
										$data[ $empty_inputs[$x] ][ $value['id'] ]		= '';
										
										/*$this->form_validation->set_rules(	"registration_tickets[" . $eb_regular . "][" . $pricetype_id . "][" . $value['id'] . "]", 
																			'Registration Tickets', 'trim|required');
										$is_options_selected		= TRUE;*/
									}
								}
							}
							
							
						}
					}
				}
				
				
			
			
				/*for ($i=0;  $i < $loop_with; $i++)
				{
					
					$data[ $empty_inputs[$x] ][ $i ]				= '';
				}*/
			}
			
			#print_r($data);die;
			return $data;
		
		}
		
		

	}
	
	
	
	public function validation_process_10( $data, &$is_imi, &$is_options_selected, &$paymenttypeid, &$earlybird_regular )
	{
		if ( $this->input->post("registration_tickets") )
		{
			foreach ($data['tmp_earlybird_regular'] as $e_key => $e_value)
			{
				foreach ($data['tmp_paymenttype'][ $data['LOOP_KEY'] ] as $p_key => $p_value)
				{
					$pricetype_id			= $p_key;
					$eb_regular				= $e_key;
					
					
					switch ( $data['LOOP_KEY'] )
					{
						#others
						case "others":
							$_parentchart_loop			= $data['prices_chart'][ $data['LOOP_KEY'] ][ $eb_regular ];
							break;
							
						#members
						default:
							$_parentchart_loop			= $data['prices_chart']['whoattendlist'];
							break;
					}
					
					
					
					if ( array_key_exists($eb_regular, $_POST["registration_tickets"]) )
					{
						if ( array_key_exists($pricetype_id, $_POST["registration_tickets"][ $eb_regular ]) )
						{
							$this->form_validation->set_rules(	"registration_tickets[". $eb_regular ."][". $pricetype_id ."]", 'Registration Tickers', 'trim');
							$earlybird_regular			= $eb_regular;
							$paymenttypeid				= $pricetype_id;
							if ( DropdownHelper::short_conferenceregistration_paymenttype(FALSE, FALSE, $pricetype_id) )
							{
								$is_imi		= TRUE;	
							}
						}
					}
					
					
					
					
					if ( $this->input->post("registration_tickets_child") )
					{
						
						if ( is_array( $_parentchart_loop ) )
						{
							foreach ($_parentchart_loop as $key => $value)
							{
								foreach ($value[ $eb_regular ] as $masterkey => $masterarray )
								{
									
									
									$this->form_validation->set_rules(	"registration_tickets_child[". $masterarray[$pricetype_id]["id"] ."]", 'Registration Tickets', 'trim');
									$this->form_validation->set_rules(	"multiply_by[". $masterarray[$pricetype_id]["id"] ."]", 'Multiply By', 'trim');
									$is_options_selected		= TRUE;
									
									
									if ( array_key_exists("addon", $masterarray) )
									{
										foreach ($masterarray["addon"] as $addonkey => $addonarray )
										{
											
											$this->form_validation->set_rules(	"registration_tickets_child[". $addonarray[$pricetype_id]["id"] ."]", 'Registration Tickets', 'trim');
											$this->form_validation->set_rules(	"multiply_by[". $addonarray[$pricetype_id]["id"] ."]", 'Multiply By', 'trim');
											$is_options_selected		= TRUE;
										
										}
									}
								}
							}
						}
						
					}
					
					
				}
			}
		}	
	}
	
	public function validation_process_8( $data, &$is_imi, &$is_options_selected, &$paymenttypeid, &$earlybird_regular )
	{
		if ( $this->input->post("registration_tickets") )
		{
			foreach ($data['tmp_earlybird_regular'] as $e_key => $e_value)
			{
				foreach ($data['tmp_paymenttype'][ $data['LOOP_KEY'] ] as $p_key => $p_value)
				{
					$pricetype_id			= $p_key;
					$eb_regular				= $e_key;
					
					
					switch ( $data['LOOP_KEY'] )
					{
						#others
						case "others":
							$_parentchart_loop			= $data['prices_chart'][ $data['LOOP_KEY'] ][ $eb_regular ];
							break;
							
						#members
						default:
							$_parentchart_loop			= $data['prices_chart'][ $data['LOOP_KEY'] ][ $eb_regular ][$pricetype_id];
							break;
					}
					
					
					
					if ( array_key_exists($eb_regular, $_POST["registration_tickets"]) )
					{
						if ( array_key_exists($pricetype_id, $_POST["registration_tickets"][ $eb_regular ]) )
						{
							$this->form_validation->set_rules(	"registration_tickets[". $eb_regular ."][". $pricetype_id ."]", 'Registration Tickers', 'trim');
							$earlybird_regular			= $eb_regular;
							$paymenttypeid				= $pricetype_id;
							if ( DropdownHelper::short_conferenceregistration_paymenttype(FALSE, FALSE, $pricetype_id) )
							{
								$is_imi		= TRUE;	
							}
						}
					}
					
					
					
					
					if ( $this->input->post("registration_tickets_child") )
					{
						
						if ( is_array( $_parentchart_loop ) )
						{
							foreach ($_parentchart_loop as $key => $value)
							{
								
								$this->form_validation->set_rules(	"registration_tickets_child[". $value['id'] ."]", 'Registration Ticketsa', 'trim');
								$this->form_validation->set_rules(	"multiply_by[". $value['id'] ."]", 'Multiply By', 'trim');
								$is_options_selected		= TRUE;
							}
						}
						
					}
					
					
				}
			}
		}	
	}
	
	public function index( $conference_slug = '', $goto_payment_page = 0  )
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		#print_r($_POST['registration_tickets_child']);die;
		
		$data									= $this->data;
		$data['h1']								= '';
		$data['_pagetitle']						= lang_line('text_conferenceregistration');
		$data['goto_payment_page']				= $goto_payment_page;
		
		
		
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
		
		// die('outer/*  */');
		
		
		$TMP_is_paid							= total_conferenceregistrations(	$user_id, 
																					$data['conference']->row("id"), 
																					1 
																				);
		
		
																			
		if ( ( $data['conferenceregistration'] -> row("is_paid") ) || ( $TMP_is_paid )  )
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
		
		
		


		#multiplyby with optional prices
		$data['numbers_multiplyby_optional']					= NumberHelper::number_array( range("1", $data['conferenceregistration_screenone']->row()->no_of_family_members + 1) );
		
		
	

		$data['SUB_HEADING']					= 'IMI Conference Registration';
		$data['LOOP_KEY']						= 'members';
		if ( $data['conferenceregistration_screenone']->row("travelling_with") == "independently" )
		{
			$data['SUB_HEADING']				= 'Staying and traveling independently';
			$data['LOOP_KEY']					= 'others';
		}
		
		
	
		
		
	
		$data['conferenceregistration_screentwo']		= $this->queries->fetch_records('short_conference_registration_screen_two', 
																						" AND screen_one_id  = '". $data['conferenceregistration_screenone']->row("id") ."' ");
		// $data['conferenceregistration_screentwo']		= '';
		
		
		#here is discount coupon code functionality	
		$this -> _switchConference( $conference_slug, $data, "speaker_discount_coupon_code_functionality" );
		
		
		
		
		$data['conference_prices_not_a_member']			= $this->queries->fetch_records('short_conference_prices_not_a_member', 
																						" AND conferenceid IS NOT NULL AND membership_classification_id IS NULL ");
		
		
		$data['registration_beforedate']				= format_date("F d, Y", $data['conference']->row("registration_from") );
		$data['registration_afterdate']					= conference_registrationdates( $data['conference'] );
		
		$tmp_parameter									= array("regionid"			=> $data['conferenceregistration']->row("regionid"),
																"conferenceid"		=> $data['conferenceregistration']->row("conferenceid"));
		$data['prices_chart']							= $this->functions->conferencepayment_array( $tmp_parameter );

		// $_parentchart_loop			= $prices_chart[ 'whoattendlist' ]['others'];
		/* echo '<pre>';
		print_r($data);
		echo '</pre>'; */

		$this->_create_child_for_form(FALSE, $data, array());
		
		
		#print_r($data);die;
		
		
		
	
		
		#if already record found (go in EDIT mode)
		if ( !empty($data['conferenceregistration_screentwo']) && $data['conferenceregistration_screentwo']->num_rows() > 0 )
		{
			$this->_create_fields_for_form(TRUE, $data, $data['conferenceregistration_screentwo']->row_array());
			
			$child_details									= $this->queries->fetch_records('short_conference_registration_screen_two', 
																							" AND screen_one_id = '". $data['conferenceregistration_screenone']->row("id") ."' ")
																							->row_array();
																							
																						
			$child_details['for_registration_tickets']		= TRUE;
			$this->_create_child_for_form(TRUE, $data, $child_details);
			
			#print_r($child_details);die;

			
			$child_details									= $this->queries->fetch_records('short_conference_registration_screen_two_details', 
																							" AND parentid = '". $child_details['id'] ."' ")
																							->result_array();
																							
																							
																		#print_r($child_details);die;						
			$this->_create_child_for_form(TRUE, $data, $child_details);
			
			
		}
		
		
		$data['conferenceregistration_screentwo_details']	= $this->queries->fetch_records('short_conference_registration_screen_two_details', 
																						" AND parentid = '". $data['conferenceregistration_screentwo']->row("id") ."' ");

		
		
	
		$is_options_selected			= FALSE;
		$is_imi							= FALSE;
		$earlybird_regular				= '';
		$paymenttypeid					= 0;
		$who_attend_weight				= 0;
		
		
		$this -> _switchConference_validation( $conference_slug, $data,  $is_imi, $is_options_selected, $paymenttypeid, $earlybird_regular );
	
		
		

		/*
		if ( $this->input->post("registration_tickets") )
		{
			foreach ($data['tmp_earlybird_regular'] as $e_key => $e_value)
			{
				foreach ($data['tmp_paymenttype'][ $data['LOOP_KEY'] ] as $p_key => $p_value)
				{
					$pricetype_id			= $p_key;
					$eb_regular				= $e_key;
					
					
					switch ( $data['LOOP_KEY'] )
					{
						#others
						case "others":
							$_parentchart_loop			= $data['prices_chart'][ $data['LOOP_KEY'] ][ $eb_regular ];
							break;
							
						#members
						default:
							$_parentchart_loop			= $data['prices_chart'][ $data['LOOP_KEY'] ][ $eb_regular ][$pricetype_id];
							break;
					}
					
					
					
					if ( array_key_exists($eb_regular, $_POST["registration_tickets"]) )
					{
						if ( array_key_exists($pricetype_id, $_POST["registration_tickets"][ $eb_regular ]) )
						{
							$this->form_validation->set_rules(	"registration_tickets[". $eb_regular ."][". $pricetype_id ."]", 'Registration Tickers', 'trim');
							$earlybird_regular			= $eb_regular;
							$paymenttypeid				= $pricetype_id;
							if ( DropdownHelper::short_conferenceregistration_paymenttype(FALSE, FALSE, $pricetype_id) )
							{
								$is_imi		= TRUE;	
							}
						}
					}
					
					
					
					
					if ( $this->input->post("registration_tickets_child") )
					{
						
						if ( is_array( $_parentchart_loop ) )
						{
							foreach ($_parentchart_loop as $key => $value)
							{
								
								$this->form_validation->set_rules(	"registration_tickets_child[". $value['id'] ."]", 'Registration Ticketsa', 'trim');
								$this->form_validation->set_rules(	"multiply_by[". $value['id'] ."]", 'Multiply By', 'trim');
								$is_options_selected		= TRUE;
							}
						}
						
					}
					
					
				}
			}
		}
		*/

		
		
		
		
		

		#GET TOTAL WEIGHT (Selected By User)
		$TMP_total_weight_have			= 0;
		
	
		if ( $this->input->post("registration_tickets_child") )
		{
			foreach ($_POST['registration_tickets_child'] as $tmp_id	=> $tmp_value)
			{
				$user_id = $this->functions->_user_logged_in_details( "id" ) > 0 ? $this->functions->_user_logged_in_details( "id" ) : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");
				$user_from_db = $this->db_imiconf->query('select * from tb_users where id = ?',array($user_id))->row_array();
				$is_member = $user_from_db['is_paid_membership_approved'];
				if($is_member == 1){
					$paymenttypeid = '2'; 
				}else{
					$paymenttypeid = isset($_POST['be_a_member']) && $_POST['be_a_member'] == 1 ? '2' : '1'; 
				}

				#SELECT whoattendid FROM `tb_short_conference_prices_master` WHERE 
				$this->queries->fetch_records(	"short_conference_prices_master", 
												" AND parent_id is NULL  AND is_optional = 0 AND id IN (SELECT parentid FROM `tb_short_conference_prices_details` WHERE id = ". $tmp_id ." AND typeid	= '". $paymenttypeid ."') ", 
												" whoattendid ");

												
				$t							= $this->queries->fetch_records("short_conference_who_attend",  " AND id IN (". $this->db->last_query() .") ");
				
				
		
				if ( $t -> num_rows() > 0 )
				{
					$t						= $t->row("no_of_people");
				
					if ( isset($_POST["multiply_by"]) && $_POST["multiply_by"] > 0 )
					{
						if ( array_key_exists($tmp_id, $_POST["multiply_by"] ));
						{
							$t			= $t * 	$_POST["multiply_by"][ $tmp_id ];
						}
					}
					
					$TMP_total_weight_have		+= $t;
				}
			}
		}

		#compare weight (prev. selected) with new one.
		if ( $data['conferenceregistration_screenone']->row("no_of_family_members")+1 != $TMP_total_weight_have )
		{
			$this->form_validation->set_rules('hdn_total_no_of_people_weight', '---', 'trim|callback_validate_noofpersonscount');
		}

		
		
		if ( !$is_options_selected )
		{
			$this->form_validation->set_rules('hdn_options_selected', 'Registration & Tickets', 'trim|required');
		}

		
		$this->form_validation->set_rules('be_a_member', 'Be a Member', 'trim|required');
		
	
		
		
		$tmp__condition			= "";
		#if others and coupon code not empty
		if ( $data['LOOP_KEY'] == "others" and $this->input->post("coupon_code") != '')
		{
			$tmp__condition		= "|required|callback_validate_IMIcouponcode";
		}
		
	
		#if IMI option selected.
		if ( $is_imi and !$this->input->post("be_a_member_fee") )
		{
			$tmp__condition		= "|callback_validate_IMIcouponcode";
		}
		
		
		if (strpos($conference_slug, '10th') !== false || strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== false) {
			$tmp__condition		= "";
		}
		

		
	
		$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim' . $tmp__condition);
		$this->form_validation->set_rules('registration_tickets[]', 'Registration Tickets', 'trim|required');
		
		
		
		$this->form_validation->set_rules('speaker_coupon_code', 'Speaker Coupon Code', 'trim|callback_validate_IMIspeakercouponcode');		
		
		
		
		
		
		
		
		
		$this->form_validation->set_rules('be_a_member', 'Not a Member', 'trim');
		$tmp__condition			= "";
		if ( ($is_imi || $data['LOOP_KEY'] == "others") and $this->input->post("be_a_member")  )
		{
			$tmp__condition		= "|required";
		}
		$this->form_validation->set_rules('be_a_member_fee', 'Not a Member <strong>(options)</strong>', 'trim' . $tmp__condition);	
		



		
		$data['_messageBundle2_nofamilyguest']				= $this->_messageBundle( 'danger_big' , '&nbsp;', 'No Family Guest!');
		
		$this -> _switchConference ( $data['conference']->row()->slug, $data );
		
		
		
		$data['country_notes']					= $this->queries->fetch_records('short_conference_residence_country_notes', 
																				  " AND country_id = '".   $data['conferenceregistration_screenone']->row()->country_of_residence ."' 
																					AND conferenceid = '". $data['conference']->row()->id ."'   ");
																					
		
																					
																					
			
		if ($this->form_validation->run() == FALSE)
		{
			if ( validation_errors() != '' )
			{
				$data['_messageBundle2']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			}
			
			
			#print_r(set_value('registration_tickets[]'));
			#print_r($data['registration_tickets']);die;
			
			// var_dump(validation_errors());
			
			// $this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');			
			
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
			// die('after');

		}
		else
		{
			
			

			$coupon_code						= '';
			$be_a_member						= 0;
			$be_a_member_fee					= 0;
			
			if ( $data['LOOP_KEY'] == "others" )
			{
				$coupon_code					= $this->input->post("coupon_code");	
				$be_a_member					= $this->input->post("be_a_member");
				$be_a_member_fee				= $this->input->post("be_a_member_fee");
			}
			else
			{
				if ( $is_imi )
				{
					$coupon_code					= $this->input->post("coupon_code");	
					$be_a_member					= $this->input->post("be_a_member");
					$be_a_member_fee				= $this->input->post("be_a_member_fee");
				}
	
			}
			
			
			
			
			
			
			$TMP_session						= array("conferenceregistrationid"	=> $data['conferenceregistration']->row("id"),
														"screen_one_id"				=> $data['conferenceregistration_screenone']->row("id"),
														"earlybird_regular"			=> $earlybird_regular,
														"paymenttypeid"				=> $paymenttypeid,
														"be_a_member"				=> $be_a_member,
														"be_a_member_fee"			=> $be_a_member_fee,
														"coupon_code"				=> $coupon_code,
														"speaker_coupon_code"		=> $this->input->post("speaker_coupon_code"),
														
														"date_added"				=> date("Y-m-d H:i:s"),
														
														"price_package_fee"			=> $this->input->post("txt_package_fee"),
														"price_payable_now"			=> $this->input->post("txt_payable_now"),
														"price_cash_onsite"			=> $this->input->post("txt_cash_onsite"),
														"price_total_payable"		=> $this->input->post("txt_total_payable"),
														"price_less_absfee"			=> intval($this->input->post("txt_abs_paid")),
														
														"email_text"				=> $this->input->post("email_text")
														);
		
			

			if ( $this->input->post("id") == '' )
			{
				$if_Exists						= $this->queries->fetch_records('short_conference_registration_screen_two', 
																						" AND screen_one_id  = '". $data['conferenceregistration_screenone']->row("id") ."' ");
				if ( $if_Exists->num_rows() > 0){
					redirect( site_url( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/2" ) );
				} else {
					$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_two", 'id'); 
					$TMP_session['id']							= $this->db->insert_id();
				}
			}
			else
			{
				$TMP_session["date_modified"]				= date("Y-m-d H:i:s");
				$TMP_session["id"]							= $this->input->post("id");
				$this->queries->SaveDeleteTables($TMP_session, 'e', "tb_short_conference_registration_screen_two", 'id'); 
			}
			
			
			
		
			
			$this->queries->SaveDeleteTables(array("parentid" => $TMP_session["id"]), 'd', " tb_short_conference_registration_screen_two_details", 'parentid'); 
			
			if ( count($_POST["registration_tickets_child"]) > 0 )
			{

				foreach ($_POST["registration_tickets_child"] as $key => $value)
				{
					$multiply_nop		= $_POST["multiply_by"][ $key ];
					$addon				= $_POST["is_addon"][ $key ];

					if($multiply_nop > 0){

						$child_details			= array("parentid"					=> $TMP_session["id"],
														"price_details_id"			=> $key,
														"price_details_value"		=> $value,
														"multply_by_no_of_people"	=> $multiply_nop,
														"addon"						=> $addon);
						
				
						$this->queries->SaveDeleteTables($child_details, 's', "tb_short_conference_registration_screen_two_details", 'id'); 
					}					
				}
			}
			
			
			
			#UPDATE step 3 (field screen_two ID)
			$TMP_screen_three									= $this->queries->fetch_records('short_conference_registration_screen_three', 
																							" AND conferenceregistrationid = '".  $data['conferenceregistration']->row("id") ."' ");

			if (!empty($TMP_screen_three) &&  $TMP_screen_three->num_rows() > 0 )
			{
				
				$TMP_update_screen_three["screen_two_id"]				= $TMP_session["id"];
				$TMP_update_screen_three["id"]							= $TMP_screen_three->row_array()["id"];
				$this->queries->SaveDeleteTables($TMP_update_screen_three, 'e', "tb_short_conference_registration_screen_three", 'id'); 	
			}
			if ( $goto_payment_page == 1 )
			{
				redirect( site_url ( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/5/payment/" . $data['conferenceregistration']->row("id") ) );	
			}
			else
			{
				if ( strpos($data['conference']->row("slug"), '10th') !== FALSE  && FALSE)
				{
					redirect( site_url( "/" . $data['conference']->row("slug") . "/registration/screen/5" ) );
				}
				else
				{
					redirect( site_url( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/3" ) );
				}
			}
		}
		
		
		
		
	}
	
	
	
	function _switchConference( $conference_slug, &$data,  $case = false  )
	{
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:
				$user_id = $this->functions->_user_logged_in_details( "id" ) > 0 ? $this->functions->_user_logged_in_details( "id" ) : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");
				$user_from_db = $this->db_imiconf->query('select * from tb_users where id = ?',array($user_id))->row_array();
				$data['is_member'] = $user_from_db['is_paid_membership_approved'];
				$this -> _12( $data );
				break;
			
			case strpos($conference_slug, '10th') !== FALSE:
				$this -> _10( $data );
				break;
				
			case strpos($conference_slug, '9th') !== FALSE:
				if ($case == "speaker_discount_coupon_code_functionality" )
				{
					
					$this -> speaker_discount_coupon_code_functionality( $data );
				}
				else
				{
					$this -> _9( $data );
				}
				break;
				
			default:
				if ($case == "speaker_discount_coupon_code_functionality" )
				{
					
				}
				else
				{
					$this -> _8( $data );
				}
				break;
		}
		
	}
	
	function _switchConference_validation( $conference_slug, $data,  &$is_imi, &$is_options_selected, &$paymenttypeid, &$earlybird_regular )
	{
		switch ( $conference_slug )
		{
			case strpos($conference_slug, '10th') !== FALSE:
				$this -> validation_process_10( $data, $is_imi, $is_options_selected, $paymenttypeid, $earlybird_regular );
				break;
				
			
				
			default:
				$this -> validation_process_8( $data, $is_imi, $is_options_selected, $paymenttypeid, $earlybird_regular );
				break;
		}
		
	}
	
	
	function speaker_discount_coupon_code_functionality( &$data )
	{	
		$TMP_speaker_coupon_code 				= $this->functions->get_post_or_data( "speaker_coupon_code", $data['speaker_coupon_code'] );
		
		
		if 
		( 
			$TMP_speaker_coupon_code == SessionHelper::_get_session("IMI_SPEAKER_COUPON_CODE", "site_settings") 
			|| 
			$TMP_speaker_coupon_code == SessionHelper::_get_session("IMI_SPEAKER_BANQUET_COUPON_CODE", "site_settings") 
			|| 
			$TMP_speaker_coupon_code == SessionHelper::_get_session("IMI_SPEAKER_BANQUET_REGISTRATION_COUPON_CODE", "site_settings") 
		)
		{
			
			$is_valid				= $this->db->query("SELECT * FROM `tb_short_conference_prices_details` WHERE 
														
														parentid IN	(	SELECT id FROM `tb_short_conference_prices_master` WHERE parent_id IS NULL 
																		AND conferenceid = '". $data['conference']->row()->id ."' 
																		AND discount_coupon_code = '". $TMP_speaker_coupon_code ."' 
																	)
														");	
														
														
			if ( $is_valid->num_rows() > 0 )
			{
				foreach ($is_valid->result_array() as $tmp_valid)
				{
					
					$data['registration_tickets_child'][$tmp_valid['id']]				= $tmp_valid['id'] . "::" . $tmp_valid['earlybird_price'];

					if ( $this->validations->is_post() )
					{
						
						if ( array_key_exists($tmp_valid['id'], $_POST['registration_tickets_child'] ) )
						{
							
						}
						#$_POST['registration_tickets_child'][$tmp_valid['id']]				= $tmp_valid['id'] . "::" . $tmp_valid['earlybird_price'];
					}
				}
			}
			
			
			
		}
		else
		{
			$is_valid				= $this->db->query("SELECT * FROM `tb_short_conference_prices_details` WHERE 
														
														parentid IN	(	SELECT id FROM `tb_short_conference_prices_master` WHERE conferenceid = '". $data['conference']->row()->id ."' 
																		AND parent_id IS NULL
																		AND discount_coupon_code != '". $TMP_speaker_coupon_code ."' 
																	)
														");		
													
			if ( $is_valid->num_rows() > 0 )
			{
				foreach ($is_valid->result_array() as $tmp_valid)
				{
					unset( $data['registration_tickets_child'][$tmp_valid['id']] );
					if ( $this->validations->is_post() )
					{
						unset( $_POST['registration_tickets_child'][$tmp_valid['id']] );
					}
					
				}
			}
		}	
	}
	
	public function _8( &$data )
	{
		$data['_pageview']						= "frontend/shortconference/screen_two.php";
	}
	
	
	public function _9( &$data )
	{
		$data['_pageview']						= "frontend/shortconference/9/screen_two.php";
	}
	
	public function _10( &$data )
	{
		$TMP_to_date								= $data['conference']->row("registration_from");
		$TMP_to_date								= date("F d, Y ", strtotime( $TMP_to_date ) );
		$data['registration_beforedate']			= "Deadline: ". $TMP_to_date ."";
		
		
		
		$TMP_to_date								= $data['conference']->row("registration_to");
		$TMP_to_date								= date("F d, Y",  strtotime("+1 day", strtotime( $TMP_to_date )));
		$data['registration_afterdate']				= $TMP_to_date . " onwards";
		
		
		$data['_pageview']						= "frontend/shortconference/10/screen_two.php";
	}

	public function _12( &$data )
	{
		$data['_pageview']						= "frontend/shortconference/12/screen_two.php";
	}
	
	
	
	
}