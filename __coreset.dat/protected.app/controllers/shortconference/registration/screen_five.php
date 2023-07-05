<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screen_Five extends C_frontend {

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
		$this->load->library('payeezy');
		$this->validations->is_conference_registration_expired();
		
		
		$this->data													= $this->default_data();		
		
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');	
		
		$this->data['after_duration_date']							= NumberHelper::number_array( range("0", "3") );
		
		
		
		
		$this->data['breadcrumbs'][1]								= "stepcompleted";
		$this->data['breadcrumbs'][2]								= "stepcompleted";
		$this->data['breadcrumbs'][3]								= "stepcompleted";
		$this->data['breadcrumbs'][4]								= "stepcompleted";
		$this->data['breadcrumbs'][5]								= "active";
		
		
		$this->data['_SHOW_INPUTS']									= TRUE;
		
		$this->_create_fields_for_form(FALSE, $this->data);
		#$this->_create_child_for_form(FALSE, $this->data, array());
		
		
		#upload files extensions
		$this->data['_messageBundle2']								= $this->_messageBundle('success' , 
																							"", 
																							lang_line("heading_operation_success") );
		
		$this->data['_messageBundle2_nofamilyguest']				= $this->_messageBundle( 'danger_big' , '&nbsp;', 'No Family Guest!');
		
		
		
		$this->data['_messageBundle_youcanalwaysresumelater']		= $this->_messageBundle('warning' , 
																							lang_line("text_youcanalwayspaylater"), 
																							lang_line("heading_operation_info") . ':' );
		
	}
	



	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs			= array( "id", "conferenceregistrationid", "prefix", "education", "phone", "name", "email", "no_of_family_members", "travelling_with", "date_added", "date_modified" );
		
		$filled_inputs			= array( "id", "conferenceregistrationid", "prefix", "education", "phone", "name", "email", "no_of_family_members", "travelling_with", "date_added", "date_modified" );
		
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
	
	
	
	public function _create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{
		#print_r($db_data);
		
		
		$empty_inputs				= array("travelitinerary_name_of_passenger", "travelitinerary_arrivaldaydate|default_date");
		
		$filled_inputs				= array("travelitinerary_name_of_passenger", "travelitinerary_arrivaldaydate");
				
				
				
		$empty_inputs				= array("travelitinerary_name_of_passenger", "travelitinerary_age", "travelitinerary_airline", "travelitinerary_flightnumber", "travelitinerary_arrivaldaydate|default_date", "travelitinerary_localarrivaltime", "departure_name_of_passenger", "departure_airline", "departure_flightnumber", "departure_departuredaydate|default_date", "departure_localdeparturetime", "travelitinerary_localarrivaltime");
		
		$filled_inputs				= array("travelitinerary_name_of_passenger", "travelitinerary_age", "travelitinerary_airline", "travelitinerary_flightnumber", "travelitinerary_arrivaldaydate", "travelitinerary_localarrivaltime", "departure_name_of_passenger", "departure_airline", "departure_flightnumber", "departure_departuredaydate", "departure_localdeparturetime", "travelitinerary_localarrivaltime");
		
		
		
		
		
		
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				
				for ($m=0;  $m < $data['parent_child_records']->num_rows(); $m++)
				{
					if ( array_key_exists($m , $db_data) )
					{
						
						$FIND_FIELD						= explode( "|", $empty_inputs[$x] );
						$___field_name					= $FIND_FIELD[0];
							
							
						if ( array_key_exists($___field_name , $db_data[$m]) )
						{
							$tmp_value						=  $db_data[$m][ $filled_inputs[$x] ];
							if ( count($FIND_FIELD) > 1 )
							{
								switch ( $FIND_FIELD[1] )
								{
									case "default_date":
										$d					= strtotime( $db_data[$m][ $filled_inputs[$x] ]);
										if ( $d > 0 )
										{
											$tmp_value			= date("d-m-Y",  $d);
										}
										else
										{
											$tmp_value			= "";
										}
										break;
										
									case "default":	
										break;
								}
							}
							
							
							$data[ $___field_name ][ $m ]	= $tmp_value;
							
						}
					}
					else
					{
						$data[ $empty_inputs[$x] ][ $m ]	= '';
					}
				}
				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			#$this->form_validation->run();

			return $data;
		}
		else
		{
			
			$PC_r				= $data['parent_child_records']->result_array();
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				if ( $this->input->post("no_of_family_members")  )
				{
					$loop_with			= $this->input->post("no_of_family_members") ;	
				}
				else
				{
					$loop_with			= 0;	
				}
				
				
				
				for ($i=0;  $i < $data['parent_child_records']->num_rows(); $i++)
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
				
				
				
					if ( ( $empty_inputs[$x]  == "travelitinerary_name_of_passenger") || (  $empty_inputs[$x]  == "departure_name_of_passenger" ) )
					{
						$data[ $empty_inputs[$x] ][ $i ]				= $PC_r[ $i ]["name"];
					}
					else if ( $empty_inputs[$x]  == "travelitinerary_age" )
					{
						$data[ $empty_inputs[$x] ][ $i ]				= calculate_age ( $PC_r[ $i ]["date_of_birth"] );
					}
					else
					{
						$data[ $empty_inputs[$x] ][ $i ]				= $tmp_value;
					}
				}
			}
			
			return $data;
		
		}

	}
	

	
	public function _create_child_for_form_2( $return_array = false, &$data, $db_data = array() )
	{
		#print_r($db_data);
		$empty_inputs				= array("accommodationplanner_hotelnameaddress");
		
		$filled_inputs				= array("accommodationplanner_hotelnameaddress");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				$m	= 0;
				foreach ($data['conference_accommodation_planner']->result_array() as $ap)
				{

					if ( $empty_inputs[$x] == "accommodationplanner_hotelnameaddress")
					{
						$data[ $empty_inputs[$x] ][  $ap['id'] ]	= $db_data[$m][ 'hotelnameaddress' ];
						
						$m++;
					}
				}
				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			#$this->form_validation->run();

		
			return $data;
		}
		else
		{
			
			#$PC_r				= $data['conference_accommodation_planner']->result_array();
			for ($x=0;  $x < count($empty_inputs); $x++)
			{				
				
				foreach ($data['conference_accommodation_planner']->result_array() as $ap)
				{
					$data[ $empty_inputs[$x] ][ $ap['id'] ]				= '';
				}
			}
			
			return $data;
		
		}

	}
	
	public function _create_child_for_form_3( $return_array = false, &$data, $db_data = array() )
	{
		#print_r($db_data);
		$empty_inputs				= array("localcharteredflights_details");
		
		$filled_inputs				= array("localcharteredflights_details");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				
				$m	= 0;
				foreach ($data['conference_local_chartered_flights']->result_array() as $ap)
				{

					if ( $empty_inputs[$x] == "localcharteredflights_details")
					{
						
						
						$data[ $empty_inputs[$x] ][  $ap['id'] ]	= $db_data[$m][ 'details' ];
						
						$m++;
					}
				}
				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			#$this->form_validation->run();
		
			return $data;
		}
		else
		{
			
			#$PC_r				= $data['conference_accommodation_planner']->result_array();
			for ($x=0;  $x < count($empty_inputs); $x++)
			{				
				
				foreach ($data['conference_local_chartered_flights']->result_array() as $ap)
				{
					$data[ $empty_inputs[$x] ][ $ap['id'] ]				= '';
				}
			}
			
			return $data;
		
		}

	}
	
	public function _create_child_for_form_4( $return_array = false, &$data, $db_data = array() )
	{
		#print_r($db_data);
		$empty_inputs				= array("afterduration_city", "afterduration_datesday", "afterduration_hotelnameaddress", "afterduration_frienddetails");
		
		$filled_inputs				= array("afterduration_city", "afterduration_datesday", "afterduration_hotelnameaddress", "afterduration_frienddetails");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				foreach ($data['after_duration_date'] as $m => $value )
				{

					if ( $empty_inputs[$x] == "afterduration_city")
					{
						$data[ $empty_inputs[$x] ][  $m ]	= $db_data[$m][ 'city' ];
					}
					else if ( $empty_inputs[$x] == "afterduration_datesday")
					{
						
						$d					= strtotime( $db_data[$m][ 'datesday' ] );
						if ( $d > 0 )
						{
							$tmp_value			= date("d-m-Y",  $d);
						}
						else
						{
							$tmp_value			= "";
						}
										
										
						$data[ $empty_inputs[$x] ][  $m ]	= $tmp_value;
					}
					else if ( $empty_inputs[$x] == "afterduration_hotelnameaddress")
					{
						$data[ $empty_inputs[$x] ][  $m ]	= $db_data[$m][ 'hotelnameaddress' ];
					}
					else if ( $empty_inputs[$x] == "afterduration_frienddetails")
					{
						$data[ $empty_inputs[$x] ][  $m ]	= $db_data[$m][ 'frienddetails' ];
					}
					
				}
				
				

				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			#$this->form_validation->run();
		
		
			return $data;
		}
		else
		{
			
			#$PC_r				= $data['conference_accommodation_planner']->result_array();
			for ($x=0;  $x < count($empty_inputs); $x++)
			{				
				
				
				foreach ($data['after_duration_date'] as $i => $value )
				{
					$data[ $empty_inputs[$x] ][ $i ]				= '';
				}
			}
			
			return $data;
		
		}

	}

	
	
	public function filled_values_by_database( &$data )
	{
	
	
		
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
		
		
		
		
		
		
		
		
		#fetch screen_two query details
		$data['conferenceregistration_screentwo']		= $this->queries->fetch_records('short_conference_registration_screen_two', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
		
		if ( $data['conferenceregistration_screentwo'] -> num_rows() <= 0 )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration/screen/2" );
		}
		
		$data['conferenceregistration_screentwo_details']	= $this->queries->fetch_records('short_conference_registration_screen_two_details', 
																						" AND parentid = '". $data['conferenceregistration_screentwo']->row("id") ."' ");
		#fetch screen_two query details
		
		
		
		
		
		
		#fetch screen_three query details
		$data['conferenceregistration_screenthree']		= $this->queries->fetch_records('short_conference_registration_screen_three', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."'
																						  AND parentid = '0'
																						");
		// var_dump( $data['conferenceregistration_screenthree']);die;
		// var_dump( $this->db->last_query());die;
		if ( $data['conferenceregistration_screenthree'] -> num_rows() <= 0  )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration/screen/3" );
		}
		
		
		
		
		
		
		#fetch both screen 3 / 4 records to display participant UID for 10th conf.
		$data['conferenceregistration_screenthree_screenfour_ALL_PARTICIPANTS']		= $this->queries->fetch_records('short_conference_registration_screen_three', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
		
		
		
		
		
		
		$parent_id										= $data['conferenceregistration_screenthree']->row("id");
		#fetch screen_three query details
		
		
		
		#fetch screen_four query details
		$this->queries->fetch_records('short_conference_registration_screen_one_family_details', " AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ", "id");
		$_lastquery_screen_one_detail_id				= $this->db->last_query();
		
		
		$data['family_records']							= $this->queries->fetch_records('short_conference_registration_screen_three', 
																						" AND parentid  = '". $parent_id ."' 
																						  AND screen_one_detail_id IN (". $_lastquery_screen_one_detail_id .")
																						");
		
		
		$data['parent_child_records']					= $this->queries->fetch_records('short_conference_registration_screen_three', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."'
																						  AND (parentid = '0' || screen_one_detail_id IN (". $_lastquery_screen_one_detail_id .") )
																						");

	}
	
	
	
	function _switchConference( $conference_slug, &$data, $case = false )
	{
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:
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
		
		$data['_pageview']								= "frontend/shortconference/screen_five.php";
	}
	
	
	public function _9( &$data )
	{
		
		$data['_pageview']								= "frontend/shortconference/9/screen_five.php";
	}
	
	public function _10( &$data )
	{
		
		$data['_pageview']								= "frontend/shortconference/10/screen_five.php";
	}
	
	public function _12( &$data )
	{
		
		$data['_pageview']								= "frontend/shortconference/12/screen_five.php";
	}
	
	public function index( $conference_slug = '' )
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$data									= $this->data;
		$data['h1']								= '';
		$data['_pagetitle']						= lang_line('text_conferenceregistration');
		$data['payment_type'] 					= $_POST['payment_type'] ? $_POST['payment_type'] : 'card';
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
		
		// $data['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
		// " AND userid = '". $this->functions->_user_logged_in_details( "id" ) . "' 
		// AND conferenceid = '". $data['conference'] -> row("id") ."' ");
		
		$data['conference_regions']				= $this->queries->fetch_records('short_conference_regions', " AND id = '". $data['conferenceregistration']->row("regionid") . "' ");

		if ( $data['conferenceregistration'] -> num_rows() <= 0 )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration" );
		}
		
				
		$TMP_is_paid							= total_conferenceregistrations(	$user_id, 
																					$data['conference']->row("id"), 
																					1 
																				);
		
		if ( ( $data['conferenceregistration'] -> row("is_paid") ) || ( $TMP_is_paid ) )
		{
			redirect( site_url( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/1" ) );
			
			$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																	lang_line('text_registrationcomplete_desc'), 
																	lang_line('text_registrationcomplete'));
			
			$data['_pageview']			= "global/_blank_page.php";		
			
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
			return false;
		}
		

		
		
		$this->filled_values_by_database( $data );

		// if ( $data['conferenceregistration_screenone'] -> row("no_of_family_members") > 0  )
		// {
			
		// 	if ( $data['family_records']->num_rows()   !=   $data['conferenceregistration_screenone'] -> row("no_of_family_members") )
		// 	{
		// 		$data['_messageBundle2']					= $this->_messageBundle('danger' , 
		// 																			"Please enter information for all family guests accompanying with you",
		// 																			lang_line("heading_operation_error"), 
		// 																			false,
		// 																			true);
																					
		// 		redirect( site_url( "shortconference/". $data['conference'] -> row("slug") ."/registration/screen/4" ) );
		// 	}
		// }
		
		
		
		
		
		
		// $data['important_content']				= $this->mixed_queries->fetch_records('conference_content_with_menu', 
		// 																			  " AND m.slug = 'conference-registration-screen-five-important-section' 
		// 																			  	AND m.conferenceid = '". $data['conference']->row()->id ."'   ");
		
		
		
		
			
			
		// $is_required							= FALSE;
		// if( strpos($conference_slug, '10th') !== FALSE || strpos($conference_slug, 'imi-north-american-conference') !== FALSE )
		// {
			
		// }
		// else
		// {
		// 	if ( $data['conferenceregistration_screenone'] -> row("travelling_with") != "imi_group" )
		// 	{
		// 		$is_required						= '|required';
		// 	}
		// }

		// for ($i=0;  $i < $data['parent_child_records']->num_rows(); $i++)
		// {			
		// 	$this->form_validation->set_rules('travelitinerary_name_of_passenger['. $i .']', '<strong>Travel and Itinerary Planner:</strong> Name of Passenger', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('travelitinerary_age['. $i .']', '<strong>Travel and Itinerary Planner:</strong> Age', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('travelitinerary_airline['. $i .']', '<strong>Travel and Itinerary Planner:</strong> Airline', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('travelitinerary_flightnumber['. $i .']', '<strong>Travel and Itinerary Planner:</strong> Flight Number', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('travelitinerary_arrivaldaydate['. $i .']', '<strong>Travel and Itinerary Planner:</strong> Arrival Day / Date', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('travelitinerary_localarrivaltime['. $i .']', '<strong>Travel and Itinerary Planner:</strong> Local Arrival Time', 'trim' . $is_required);
			
			
			
			
		// 	$this->form_validation->set_rules('departure_name_of_passenger['. $i .']', '<strong>Departure:</strong> Name of Passenger', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('departure_airline['. $i .']', '<strong>Departure:</strong> Airline', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('departure_flightnumber['. $i .']', '<strong>Departure:</strong> Flight Number', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('departure_departuredaydate['. $i .']', '<strong>Departure:</strong> Departure Date / Date', 'trim' . $is_required);
		// 	$this->form_validation->set_rules('departure_localdeparturetime['. $i .']', '<strong>Departure:</strong> Departure Arrival Time', 'trim' . $is_required);
			
		// }

	
		$this -> _switchConference( $conference_slug, $data );
		#$data['_pageview']						= "frontend/conference/screen_five.php";
		
		
		
		
		// $data['country_notes']					= $this->queries->fetch_records(	'conference_residence_country_notes', 
		// 																		  	" 	AND country_id = '".   $data['conferenceregistration_screenone']->row()->country_of_residence ."' 
		// 																				AND conferenceid = '". $data['conference']->row()->id ."'   ");
		$screen2								= $this->queries->fetch_records('short_conference_registration_screen_two', 
		" AND  conferenceregistrationid  = '". $data['conferenceregistration']->row("id") ."' LIMIT 1 ");

		$screen3								= $this->queries->fetch_records('short_conference_registration_screen_three', 
					" AND  conferenceregistrationid  = '". $data['conferenceregistration']->row("id") ."' LIMIT 1 ");
																	
		$data['total_amount']					= $screen2->row("price_total_payable"); #total_payment( $conference_registration );
																										
		// var_dump($this->form_validation->run() == FALSE );die;
		// if ($this->form_validation->run() == FALSE)
		// {

		
		// 	if ( validation_errors() != '' )
		// 	{
		// 		$data['_messageBundle2']			= $this->_messageBundle( 'danger' , lang_line('text_pleasecompleteformwithproperinfo'), 'Error!');
		// 	}
			
		// 	$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');			
		// 	$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
		// }
		// else
		// {
			
			
			
			
			$conferenceregistration				= $data['conferenceregistration'];
			$TMP_delete							= array("conferenceregistrationid" => $conferenceregistration->row("id"));
			if ( isset($_POST['card_payment']) )
			{
				
				$saveData											= array("payment_type"=> $_POST['payment_type'],
				"id"=> $data['conferenceregistration']->row("id"));
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_registration_master", 'id');
				if($_POST['payment_type'] == 'card'){
					$this->form_validation->set_rules('card_name', 'Card Holder Name', 'trim|required');
					$this->form_validation->set_rules('card_number', 'Card Number', 'trim|required');
					$this->form_validation->set_rules('card_expiry', 'Card Expiry', 'trim|required');
					$this->form_validation->set_rules('card_cvv', 'Card CVV Code', 'trim|required');
					
					if ($this->form_validation->run() == FALSE)
					{
						$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
					}
					else 
					{
						$card_number = str_replace(' ','',$this->input->post("card_number"));
						$card_information=array(
							'type'=> $this->ccdetector->detect($card_number),
							'name'=>$this->input->post("card_name"),
							'number'=> $card_number,
							'expiry'=>$this->input->post("card_expiry"),
							'cvv'=>$this->input->post("card_cvv")
						);
						// Pay via Payeezy

						$pay = new Payeezy();
						$pay = $pay->pay($card_information, $data['total_amount'], $screen3->row("email"));
						if ( ! is_array($pay) ){
							$data['card_error'] = "Something Went Wrong! Please Try Again.";
						} else {

							if ( isset($pay['success'] ) ){
								$editData['is_paid'] 						= 1;
								$editData['id'] 							= $data['conferenceregistration']->row('id');
								
								$this->queries->SaveDeleteTables($editData, 'e', "tb_short_conference_registration_master", 'id');
							}
							$register_id = 0;
							// $userId 										= $this->functions->_user_logged_in_details("id");
							$saveData										= array("userid"								=> $user_id,
																					"conferenceid"							=> $data['conference']->row("id"),
																					"conference_registration_id"			=> $data['conferenceregistration']->row("id"),
																					"payer_email"							=> $screen3->row("email"),
																					"payment_gross"							=> isset($pay['response']->DollarAmount ) ? $pay['response']->DollarAmount : 0,
																					"ipn_track_id"							=> isset($pay['response']->Authorization_Num ) ? $pay['response']->Authorization_Num : '',
																					"payer_id"								=> isset($pay['response']->Transaction_Tag ) ? $pay['response']->Transaction_Tag : '',
																					"payment_status"						=> isset($pay['success'] ) ? 'Completed' : 'Failed',
																					"payment_mode"							=> 'payeezy',
																					"paypal_post"							=> isset($pay['response'] ) ? serialize($pay['response']) : '',
																					"date_added"							=> date("Y-m-d H:i:s"),
																					"card_name"								=> $card_information['name'],
																					'card_type'								=> isset($pay['response']->CardType ) ? $pay['response']->CardType : $card_information['type'],
																					'card_expiry'							=> $card_information['expiry'],
																			);
							if(isset($pay['response']->CTR)){
								unset($pay['response']->CTR);
							}
							if(isset($pay['request']['Card_Number'])){
								unset($pay['request']['Card_Number']);
							}
							$saveData['request_data'] 						= isset($pay['request'] ) ? json_encode($pay['request']) : '';
		
							$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_payments", 'id');

							if ( isset($pay['error'] ) ){
								$data['card_error'] = $pay['error'];
							} else {
								$membership_type				= $screen2->row("be_a_member_fee");
								$this->load->library( '../controllers/home' );
								if($membership_type != 0){
									$abc = $this->home->membership_payment($user_id, $membership_type, $saveData);
								}
								$_POST["card_number"]						= substr($_POST["card_number"], -4);

								$this->functions->send_tax_receipt_shortconference($user_id, $this, $conference_slug);	
	
								// #test email
								$_POST["card_number"]		= substr($_POST["card_number"], -4);
								$message 					= 'test _ payment ' . serialize( $_POST ) ;
								$email_template				= array("email_to"				=> 'rida.fatima@genetechsolutions.com',
																	"email_heading"			=> 'TEST',
																	"email_file"			=> "email/global/_blank_page.php",
																	"email_subject"			=> 'TESTT',
																	"email_post"			=> array("content"		=> $message) );
	
								// $is_email_sent				= $this->_send_email( $email_template );
								// #test email
							}	
							
							redirect( site_url("shortconference/". $data['conference'] -> row("slug") ."/registration/paymentsuccess") );
						}
					}
				} 
				// switch ( TRUE )
				// {
				// 	//commented for conference 12
				// 	// case !SessionHelper::_get_session("PAYMENT_TOGGLE_CR", "site_settings"):
				// 	// 	$message_class				= 'danger_big';
				// 	// 	$message_heading			= "Payment Form Unavailable";
				// 	// 	$message_text				= 'Please contact administrator';
				// 	// 	break;
						
					
				// 	case $screen3->num_rows() <= 0:
				// 		$message_class				= 'danger_big';
				// 		$message_heading			= "Registration Incomplete";
				// 		$message_text				= 'Please complete all steps for conference registration';
				// 		break;
					
					
	
					
				// 	case isset($pay['success']):

				// 		$login_button 	=  "<p>Your registration has been completed, Would you like to become an <a href=".site_url('register')." style='text-decoration:none; color:#1a87c1;' > IMI Member</a></p>" ;
				// 		$redirect_if_guest_user 						= !$this->session->userdata('user_logged_in') ? $login_button : ''; 
						
				// 		$message_class				= 'success_big';
				// 		$message_heading			= "Thank You";
				// 		$message_text				= '<div class="error_style" >
				// 		<div class="" style="margin:0px !important;margin-top:10px !important;">'.$redirect_if_guest_user.'               
				// 						</div>
				// 					</div>';
				// 		break;
					
				// 	#if payment is not done - and not paid by cash
				// 	case !$data['conferenceregistration'] -> row( "is_paid" ) and
				// 		 $data['conferenceregistration'] -> row( "payment_type" ) != "cash":
						
						
						
				// 		if ( trim( $data['conferenceregistration_screentwo'] -> row("email_text") ) == "" )
				// 		{
				// 			$this->_messageBundle( 'danger' , "There was an error processing problem. Please click on 'Save & Proceed' button again to continue", 'Alert!', FALSE, TRUE);
				// 			redirect( site_url("shortconference/". $data['conference'] -> row("slug") ."/registration/screen/2") );
				// 		}		
						
				// 		#if payment mode is PAYPAL /  Cash
				// 		else
				// 		{
				// 			#if coupon code is SUPER global
				// 			if ( $screen2->row("coupon_code") == SessionHelper::_get_session("IMI_SUPER_COUPON_CODE", "site_settings") )
				// 			{
				// 				$data['total_amount']	= 1;
				// 			}
				// 			$data['is_paid']			= FALSE;
				// 			$data['payment_type']		= $data['conferenceregistration']->row("payment_type");
				// 			$message_class				= 'warning_big';
				// 			if($data['conferenceregistration'] -> row( "payment_type" ) == "card"){
				// 				$message_heading			= "Pay Via Credit Card";
				// 				$message_text				= 'Total amount to be charged: <strong>' . format_price( $data['total_amount'], array("prefix" => $this->functions->getCurrencySymbol($data['conference_regions']->row()->show_rates_in_currency)) ) . '</strong><br /><br />';
								
				// 			} else {
				// 				$message_heading			= "Please Wait..";
				// 				$message_text				= 'Total amount to be charged: <strong>' . format_price( $data['total_amount'], array("prefix" => $this->functions->getCurrencySymbol($data['conference_regions']->row()->show_rates_in_currency)) ) . '</strong><br /><br /> 
				// 											   You are being redirect to Payment Page';
				// 			}
							
				// 		}
				// 		break;
						
					
						
				// 	default:
				// 		$message_class				= 'success_big';
				// 		$message_heading			= "Registration Complete";
				// 		$message_text				= 'You are already registered with this Conference.';
				// 		break;
						
						
						
					
				// }
				
			}


			// $data['_messageBundle2']				= $this->_messageBundle( $message_class, $message_text, $message_heading);
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
		// }
	
			
		}
		
		
	
	
}