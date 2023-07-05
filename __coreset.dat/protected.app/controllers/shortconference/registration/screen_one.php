<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screen_One extends C_frontend {

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
		
		$Login_Or_Create_Account_Message				= array("class"			=> "info",
																"msg"			=> "To register conference, please login or <a href='". site_url('register') ."'>create</a> an account",
																"title"			=> "");
																
																
																
		
		
		// $this->_auth_login( FALSE, TRUE, $Login_Or_Create_Account_Message );
		
		// $this->validations->is_conference_registration_expired();
		
		
		
		$this->data													= $this->default_data();
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');	
		
		$this->data['confreg_paymenttype_dropdown']					= DropdownHelper::short_conferenceregistration_paymenttype();
		
		
		$this->_create_fields_for_form(FALSE, $this->data);
		$this->_create_child_for_form(FALSE, $this->data, array());
		
		$this->data["name"]											= $this->functions->_user_logged_in_details( "name" );
		$this->data["email"]										= $this->functions->_user_logged_in_details( "email" );		
		$user_details	= $this->queries->fetch_records("users_profile", " AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."'");
		if ( !empty($user_details) && $user_details->num_rows() > 0 )
		{
			$this->data["phone"]									= $user_details	->row('cellphone_number') ;
		}
	
		
		$this->data['breadcrumbs'][1]								= "active";
		
		
		
		
		
		$this->data['_messageBundle2']								= $this->data['_messageBundle'];
		$this->data['_messageBundle_youcanalwaysresumelater']		= $this->_messageBundle('warning' , 
																							lang_line("text_youcanalwayspaylater"), 
																							lang_line("heading_operation_info") . ':' );
		
		
		
		
		
	}


	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs			= array( "id", "conferenceregistrationid", "country_of_residence", "prefix", "education", "phone", "name", "email", "no_of_family_members", "travelling_with", "date_added", "date_modified" );
		
		$filled_inputs			= array( "id", "conferenceregistrationid", "country_of_residence", "prefix", "education", "phone", "name", "email", "no_of_family_members", "travelling_with", "date_added", "date_modified" );
		
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
		$empty_inputs				= array("family_id", "family_name", "family_email", "family_relationship", "family_age");
		
		$filled_inputs				= array("family_id", "family_name", "family_email", "family_relationship", "family_age");
				
				
				
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
					if ( $empty_inputs[$x] == "family_id" )
					{
						$data[ $empty_inputs[$x] ][ $m ]	= $db_data[$m][ 'id' ];
					}
					else
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
				if ( $this->input->post("no_of_family_members")  )
				{
					$loop_with			= $this->input->post("no_of_family_members") ;	
				}
				else
				{
					$loop_with			= 0;	
				}
				for ($i=0;  $i < $loop_with; $i++)
				{
					
					$data[ $empty_inputs[$x] ][ $i ]				= '';
				}
			}
			
			return $data;
		
		}

	}
	
	public function delete( $data )
	{
		
			
		foreach ( $_POST["delete"] as $key => $value )
		{
			if ($key <= 0 )
			{
				die("error while deleteing - contact administrator");	
			}
			
			$this->queries->SaveDeleteTables(array("id" => $key), 'd', "tb_short_conference_registration_screen_one_family_details", 'id'); 	
			
			$this->queries->SaveDeleteTables(array("screen_one_detail_id" => $key), 'd', "tb_short_conference_registration_screen_three", 'screen_one_detail_id'); 	
			
			
			
		}
		
		
		$child_details		= $this->queries->fetch_records('short_conference_registration_screen_one_family_details', 
															" AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ");
		
		
		
		
		$_update_num_of_members		= array("no_of_family_members" 	=> $child_details->num_rows(),
											"id"					=> $data['conferenceregistration_screenone']->row("id"));
		$this->queries->SaveDeleteTables($_update_num_of_members, 'e', "tb_short_conference_registration_screen_one", 'id'); 		
	}
	
	
	
	public function _8( &$data )
	{
		$data['_pageview']						= "frontend/shortconference/screen_one.php";	
	}
	
	
	public function _9( &$data )
	{
		$data['_pageview']						= "frontend/shortconference/9/screen_one.php";
	}
	
	public function _10( &$data )
	{
		$data['_pageview']						= "frontend/shortconference/10/screen_one.php";
	}

	public function _12( &$data )
	{
		$data['_pageview']						= "frontend/shortconference/12/screen_one.php";
	}
	
	public function index( $conference_slug = '')
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		


		$data									= $this->data;
		$data['h1']								= '';
		$data['_pagetitle']						= lang_line('text_conferenceregistration');

		$data['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");

		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		// die('jdvh');		
		#redirect( "shortconference/". $data['conference']->row("slug") ."/registration" );
		$data['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
																				" AND userid = '". $this->functions->_user_logged_in_details( "id" ) . "' 
AND conferenceid = '". $data['conference'] -> row("id") ."' ");
		if	($this->functions->_user_logged_in_details( "id" ) > 0){
			if ( !$this->validations->is_session("conferenceregistration") && $data['conferenceregistration']->num_rows() <= 0 )
			{
				redirect( site_url( "shortconference/". $data['conference']->row("slug") ."/registration" ) );
			}
			else if (  $this->validations->is_session("conferenceregistration")  && $data['conferenceregistration']->num_rows() <= 0  )
			{
				$TMP_regionid						= SessionHelper::_get_session("regionid", "conferenceregistration");
				if ( !SessionHelper::_get_session("regionid", "conferenceregistration") )
				{
					$TMP_regionid					= NULL;
				}
				if($this->functions->_user_logged_in_details( "id" )){

					$TMP_session						= array("participanttypeid"			=> SessionHelper::_get_session("participanttypeid", "conferenceregistration"),
																"regionid"					=> SessionHelper::_get_session("regionid", "conferenceregistration"),
																"conferenceid"				=> $data['conference']->row("id"),
																"userid"					=> $this->functions->_user_logged_in_details( "id" ),
																"date_added"				=> date("Y-m-d H:i:s") );
					
					$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_master", 'id'); 
				}
				

				
				
				#again fetch the same query (after inserting)
				$data['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
																					" AND userid = '". $this->functions->_user_logged_in_details( "id" ) . "' 
																						AND conferenceid = '". $data['conference'] -> row("id") ."' ");
			}
		}	
		
		
		
		
		$TMP_is_paid							= total_conferenceregistrations(	$this->functions->_user_logged_in_details( "id" ), 
																					$data['conference']->row("id"), 
																					1 
																				);
																				
		
		if ( ( $data['conferenceregistration'] -> row("is_paid") ) || ( $TMP_is_paid )  )
		{
			$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																	lang_line('text_registrationcomplete_desc'), 
																	lang_line('text_registrationcomplete'));
			
			$data['_pageview']			= "global/_blank_page.php";
			
			
			
			$this->load->view( FRONTEND_TEMPLATE_LEFT_RIGHT_WIDGETS_VIEW, $data );
			return false;
		}
		
		
		
		
		
		$data['conferenceregistration_screenone']		= $this->queries->fetch_records('short_conference_registration_screen_one', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
		
		#if already record found (go in EDIT mode)
		if ( $data['conferenceregistration_screenone']->num_rows() > 0)
		{
			
			$this->_create_fields_for_form(TRUE, $data, $data['conferenceregistration_screenone']->row_array());
			
			
			
			$child_details		= $this->queries->fetch_records('short_conference_registration_screen_one_family_details', 
																" AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ");
			$this->_create_child_for_form(TRUE, $data, $child_details->result_array());
		}
		else
		{
			 
			if ( is_short_conference_registered_for_local(FALSE, SessionHelper::_get_session("regionid", "conferenceregistration") ) )
			{
				$data['travelling_with']			= 'imi_group';
			}
			
			
			/*
			if (  $this->validations->is_session("conferenceregistration")  )
			{
				switch ( SessionHelper::_get_session("participanttypeid", "conferenceregistration") )
				{
					case 1:	//local
						$data['travelling_with']			= 'independently';
						break;
						
					default: //internationally
						$data['travelling_with']			= 'imi_group';
						break;	
				}
			}
			*/
			
		}
		
		
		
		
		
		if ( $this->input->post("delete") )
		{
			if ( count($_POST["delete"]) > 0 )
			{
				
				
				
				$this->delete( $data );
				
				
				
				#delete screen_2 details
				$this->queries->SaveDeleteTables(array("conferenceregistrationid" => $data['conferenceregistration']->row("id")), 
													'd', 
													"tb_short_conference_registration_screen_two", 'conferenceregistrationid'); 
													
													
				
				#$this->_messageBundle( 'success' , "Record Deleted", 'Success!', FALSE, TRUE);
				$this->_messageBundle( 'success' , "You have deleted guest information record. Please re-select your package to Continue.", 'Information!', FALSE, TRUE);
				
				redirect( site_url( "shortconference/". $data['conference']	->row("slug") ."/registration/screen/2" ) );
			}
		}
		
		
		
	
	
	
	
		
		
		
		
		
		
		// $this->form_validation->set_rules('prefix', 'Prefix', 'trim|required');
		// $this->form_validation->set_rules('education', 'Suffix', 'trim|required');
		
		$this->form_validation->set_rules('no_of_family_members', 'No. of Family Members', 'trim');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		// $this->form_validation->set_rules('country_of_residence', 'Country of Residence', 'trim|required');
		
		
		if ( $this->input->post("no_of_family_members") > 0 )
		{
			for($i=0; $i < $this->input->post("no_of_family_members"); $i++)
			{
				$this->form_validation->set_rules('family_name[' . $i . ']', 'Name', 'trim|required');		
				$this->form_validation->set_rules('family_email[' . $i . ']', 'Email', 'trim|required|valid_email');
				$this->form_validation->set_rules('family_relationship[' . $i . ']', 'Relationship', 'trim|required');
				$this->form_validation->set_rules('family_age[' . $i . ']', 'Age', 'trim|required');	
			}
			
		}
		
		// $this->form_validation->set_rules('travelling_with', 'Traveling with', 'trim|required');

	
		
		
		
		$this -> _switchConference( $data['conference']->row()->slug, $data );
		
		
		if ( ($this->form_validation->run() == FALSE) || (!$this->input->post("submitform") ))
		{
			
			// var_dump(validation_errors());die;
			if ( validation_errors() != '' )
			{
				$data['_messageBundle2']			= $this->_messageBundle( 'danger' , lang_line('text_pleasecompleteformwithproperinfo'), 'Error!');
			}
			
			
			
			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
				
			if ( !$this->input->post("submitform") )
			{
				$this->form_validation->set_error_delimiters('<p class="form_error" style="display:none;">', '</p>');
			}
			
				
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
		}
		else
		{
			#"date_added"				=> date("Y-m-d H:i:s") 
			
			
			$TMP_session						= array("conferenceregistrationid"	=> $data['conferenceregistration']->row("id"),
														"prefix"					=> $this->input->post("prefix"),
														"education"					=> $this->input->post("education"),
														"phone"						=> $this->input->post("phone"),
														"name"						=> $this->input->post("name"),
														"email"						=> $this->input->post("email"),
														"country_of_residence"		=> $this->input->post("country_of_residence"),
														"no_of_family_members"		=> $this->input->post("no_of_family_members"),
														// "travelling_with"			=> $this->input->post("travelling_with"),
														"date_added"				=> date("Y-m-d H:i:s"));
			
			
		
			if ( $this->input->post("id") == '' )
			{
				$if_Exists						= $this->queries->fetch_records('short_conference_registration_screen_one', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
				if ( $if_Exists->num_rows() > 0){
					redirect( site_url( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/1" ) );
				} else {
					if(!$this->functions->_user_logged_in_details( "id" )){

						$guest_user_data = array(
						"prefix_title"				=> $this->input->post("prefix"),
						"name"						=> $this->input->post("name"),
						"email"						=> $this->input->post("email"),
						"password"					=> 'abc',
						"registration_site"			=> 'IMIWebPortal',
						"is_active"					=> 0,
						"date_added"				=> date("Y-m-d H:i:s"));

						$data['guest_user'] = $this->queries->fetch_records('users', "AND email = '". $this->input->post("email") ."'  ");
				
						if($data['guest_user']->num_rows() <= 0	){
							
							$this->queries->SaveDeleteTables($guest_user_data, 's', "imi_conf_restore2.tb_users", 'id'); 
							
						}
						$data['guest_user'] = $this->queries->fetch_records('users', "AND email = '". $this->input->post("email") ."'  ");
												
	 
						$TMP_session_master						= array(
							"participanttypeid"			=> SessionHelper::_get_session("participanttypeid", "conferenceregistration"),
							"regionid"					=> SessionHelper::_get_session("regionid", "conferenceregistration"),
							"conferenceid"				=> $data['conference']->row("id"),
							"userid"					=> $data['guest_user']->row('id'),
							"date_added"				=> date("Y-m-d H:i:s") 
						);

						$this->queries->SaveDeleteTables($TMP_session_master, 's', "tb_short_conference_registration_master", 'id');
						
						$data['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
																	" AND userid = '".$data['guest_user']->row('id') . "' 
																	AND conferenceid = '". $data['conference'] -> row("id") ."' ");
						$TMP_session['conferenceregistrationid'] = $data['conferenceregistration']->row('id');
						$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_one", 'id');
						$TMP_session['id']							= $this->db->insert_id();
						$guest_user = [
							'userid' => $data['guest_user']->row('id'),
							'status' => 'guest',
						];
						$this->queries->SaveDeleteTables($guest_user, 's', "tb_guest_users", 'id');

						// var_dump($this->db->last_query());die;
						// $data['conferenceregistration_screenone']		= $this->queries->fetch_records('short_conference_registration_screen_one', 
						// " AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
						$sessions = array(
							'userid' => $data['guest_user']->row('id'),
							'email_address' => $data['guest_user']->row('email'),
						);

						SessionHelper::_set_session( $sessions, "conferenceregistrationguestuser" );

				
						
					}else{

						$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_one", 'id'); 
						$TMP_session['id']							= $this->db->insert_id();
					}
				}
			}
			else
			{
				$TMP_session["date_modified"]				= date("Y-m-d H:i:s");
				$TMP_session["id"]							= $this->input->post("id");
				$this->queries->SaveDeleteTables($TMP_session, 'e', "tb_short_conference_registration_screen_one", 'id'); 
			}
			
			
			
			if ( $data['conferenceregistration_screenone']->num_rows() > 0 )
			{
				if ( $data['conferenceregistration_screenone']->row("travelling_with") != $this->input->post("travelling_with") )
				{
					$this->queries->SaveDeleteTables(array("conferenceregistrationid" => $data['conferenceregistration']->row("id")), 
													'd', 
													"tb_short_conference_registration_screen_two", 'conferenceregistrationid'); 
				}
			}
			
			
			
			
			
			//$this->queries->SaveDeleteTables(array("parentid" => $TMP_session["id"]), 'd', "tb_short_conference_registration_screen_one_family_details", 'parentid'); 
			if ( $this->input->post("family_name") )
			{
				if ( count($_POST["family_name"]) > 0 )
				{
					for ( $i=0; $i < count( $_POST["family_name"] ); $i++ )
					{
						$child_details			= array("parentid"					=> $TMP_session["id"],
														"family_name"				=> $_POST['family_name'][$i],
														"family_email"				=> $_POST['family_email'][$i],
														"family_relationship"		=> $_POST['family_relationship'][$i],
														"family_age"				=> $_POST['family_age'][$i] );
						
						
						if ( $_POST['family_id'][ $i ] == '' )
						{
							$this->queries->SaveDeleteTables($child_details, 's', "tb_short_conference_registration_screen_one_family_details", 'id'); 
						}
						else
						{
							$child_details["id"]			= $_POST['family_id'][ $i ];
							$this->queries->SaveDeleteTables($child_details, 'e', "tb_short_conference_registration_screen_one_family_details", 'id'); 
						}
					}
				}
			}
			
			
			
			$current_no_of_family_members				= $this->queries->fetch_records('short_conference_registration_screen_one', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");	
			
			if ( $current_no_of_family_members -> num_rows() > 0 )
			{
				if ( $data['conferenceregistration_screenone']->row()->no_of_family_members != $current_no_of_family_members->row()->no_of_family_members )
				{
					#delete screen_2 details
					$this->queries->SaveDeleteTables(array("conferenceregistrationid" => $data['conferenceregistration']->row("id")), 
														'd', 
														"tb_short_conference_registration_screen_two", 'conferenceregistrationid'); 	
														
														
					//$this->_messageBundle( 'success' , "Your Number of Family Members is changed. Please re-select your package to Continue.", 'Information!', FALSE, TRUE);
				}
			}
			
			
			

			
			redirect( site_url( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/2" ) );
		}
		
	
	}
	
	
	
	
	function _switchConference( $conference_slug, &$data )
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
	
}