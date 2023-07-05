<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screen_Four extends C_frontend {

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
		
		
		include_once(APPPATH.'controllers/shortconference/registration/screen_three.php');
		// Screen_Three::_create_fields_for_form(FALSE, $this->data);
		
		
		
		
		
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');	
		
			
		
		
		
		
		$this->data['breadcrumbs'][1]								= "stepcompleted";
		$this->data['breadcrumbs'][2]								= "stepcompleted";
		$this->data['breadcrumbs'][3]								= "stepcompleted";
		$this->data['breadcrumbs'][4]								= "active";
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/conference_registration/";
		
		
		$this->data['_messageBundle2'] = $this->data['_messageBundle2_nofamilyguest'] = $this->data['_messageBundle'];
		
		
		
		$this->data['_messageBundle_youcanalwaysresumelater']		= $this->_messageBundle('warning' , 
																							lang_line("text_youcanalwayspaylater"), 
																							lang_line("heading_operation_info") . ':' );
		
		
	}



	
	public function index( $conference_slug = '', $screen_one_detail_id = 0 )
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
		
		
		
		
		
		
		$user_id = $this->functions->_user_logged_in_details( "id" ) > 0 ? $this->functions->_user_logged_in_details( "id" ) : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");

		$data['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
																				" AND userid = '". $user_id . "' 
																				  AND conferenceid = '". $data['conference'] -> row("id") ."' ");
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
		
		
		
		

		
		#fetch screen_one query details
		$data['conferenceregistration_screenone']		= $this->queries->fetch_records('short_conference_registration_screen_one', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");
		if ( $data['conferenceregistration_screenone'] -> num_rows() <= 0 )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration/screen/1" );
		}
		
		$data['conferenceregistration_screenone_family_details']	= $this->queries->fetch_records('short_conference_registration_screen_one_family_details', 
																									" AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ", "id");
		$TMP_last_query_for_screenone_family_details	= $this->db->last_query();
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
		
		if ( $data['conferenceregistration_screenthree'] -> num_rows() <= 0 )
		{
			// redirect( "shortconference/". $data['conference']->row("slug") ."/registration/screen/3" );
		}
		
		$parent_id										= $data['conferenceregistration_screenthree']->row("id");
		#fetch screen_three query details
		
		

		#DELETE RECORDS
		if ( $this->input->post("delete") )
		{
			if ( count($_POST["delete"]) > 0 )
			{
				
				include_once(APPPATH.'controllers/conference/registration/screen_one.php');
				
				Screen_One::delete( $data );
				
				
				#delete screen_2 details
				$this->queries->SaveDeleteTables(array("conferenceregistrationid" => $data['conferenceregistration']->row("id")), 
													'd', 
													"tb_short_conference_registration_screen_two", 'conferenceregistrationid'); 
				
				
				
				$this->_messageBundle( 'success' , "You have deleted guest information record. Please re-select your package to Continue.", 'Information!', FALSE, TRUE);

				
				redirect( site_url( 'shortconference/'. $data['conference']->row("slug") .'/registration/screen/2' ) );
			}
		}
		
		
		
		
		
		
		
		
		
		
		$no_of_family_members							= $data['conferenceregistration_screenone']->row("no_of_family_members");
		
		
		
		
		
		
		$data['FAMILY_registration_number']				= FALSE;		
		$data['list_family_members']					= $this->queries->fetch_records("short_conference_registration_screen_one_family_details", 
																						" 	AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ");
	
		
		


		if ( $no_of_family_members == 0 )
		{
			
			$data['_messageBundle2_nofamilyguest']		= $this->_messageBundle('info' , "No Family Guest Found", lang_line("heading_operation_info"));
			
		}
		else
		{
			
			if ( $screen_one_detail_id > 0 )
			{
			
				$is_real_id									= $this->queries->fetch_records("short_conference_registration_screen_one_family_details", 
																							" 	AND id = '". $screen_one_detail_id ."' 
																								AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ");

				if ( $is_real_id	 -> num_rows() > 0 )
				{
					
					
					$data['match_record']					= $this->queries->fetch_records('short_conference_registration_screen_three', 
																							" AND parentid  = '". $parent_id ."' 
																							  AND screen_one_detail_id = '". $screen_one_detail_id ."' ");
																							  
			
					if ( $data['match_record']->num_rows() > 0  )
					{
						

						
						
						#$data['FAMILY_registration_number']			= $data['match_record']->row("name");
						$this -> _switchConference( $conference_slug, $data, "get_name" );
						// Screen_Three::_create_fields_for_form(TRUE, $data, $data['match_record']->row_array());
						
						
						
					}
					else
					{
						$prefilled_form_values_form_screen_one			= $this->queries->fetch_records('short_conference_registration_screen_one_family_details', 
																										" 	AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' 
																											AND id = '". $screen_one_detail_id ."' " );
																		
																		
						foreach ( $prefilled_form_values_form_screen_one->result_array() as $pfvfso)
						{
							$data['full_name']					= $pfvfso['family_name'];
							$data['email']						= $pfvfso['family_email'];
						}
						
						
						$data['name']							= $is_real_id->row("family_name");
						$data['FAMILY_registration_number']		= $data['name'];	
					}
				}
				else
				{
					page_error( $data );
					return false;
				}
			}
			else
			{
				if ( $data['list_family_members']->num_rows() > 0 )
				{
					
					foreach ($data['list_family_members']->result_array() as $is_completed )
					{
						$check_record					= $this->queries->fetch_records('short_conference_registration_screen_three', 
																						" AND parentid  = '". $data['conferenceregistration_screenthree']->row()->id ."' 
																						  AND screen_one_detail_id = '". $is_completed['id'] ."' ");
													
						
						if ( $check_record -> num_rows() <= 0 )
						{										  
							redirect( site_url( "shortconference/". $conference_slug ."/registration/screen/4/" . $is_completed['id'] ) );		
						}
					}
					
				}
				
				
			}
			
		}
		
		

		
		#Screen_Three::validate_fields( $data );
		$this -> _switchConference( $conference_slug, $data, "validate" );
	
	
		
		$data['parentid']						= $parent_id;
		$data['screen_one_detail_id']			= $screen_one_detail_id;
		
		$this -> _switchConference( $conference_slug, $data );
		
		
		
		
		
		$data['country_notes']					= $this->queries->fetch_records(	'short_conference_residence_country_notes', 
																				  	" 	AND country_id = '".   $data['conferenceregistration_screenone']->row()->country_of_residence ."' 
																						AND conferenceid = '". $data['conference']->row()->id ."'   ");
																					
																					
			
		#$data['_pageview']						= "frontend/conference/screen_four.php";
		if ($this->form_validation->run() == FALSE)
		{
			
			if ( validation_errors() != '' )
			{
				$data['_messageBundle2']			= $this->_messageBundle( 'danger' , lang_line('text_pleasecompleteformwithproperinfo'), 'Error!');
			}
			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');			
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
		}
		else
		{
			
			
			#Screen_Three::save_update( $data );
			$this -> _switchConference( $conference_slug, $data, "save_update" );
			
			
			if ( $this->input->post("id") != '' )
			{
				$data['_messageBundle2']					= $this->_messageBundle('success' , 
																					"Record Updated", 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
				
				redirect( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/4/" . $screen_one_detail_id );
			}
			else
			{
				redirect( "shortconference/" . $data['conference']->row("slug") . "/registration/screen/4" );
			}
			
			
			
		}
		
		
		
		
	}
	
	
	function _switchConference( $conference_slug, &$data, $case = false )
	{
		
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:
				if ($case == "validate" )
				{
					Screen_Three::validate_fields_12( $data );
				}
				else if ($case == "save_update" )
				{
					Screen_Three::save_update_12( $data );
				}
				else if ($case == "get_name" )
				{
					$data['FAMILY_registration_number']			= $data['match_record']->row("full_name");
				}
				else
				{
					$this -> _12( $data );
				}
				break;

			case strpos($conference_slug, '10th') !== FALSE:
				if ($case == "validate" )
				{
					Screen_Three::validate_fields_10( $data );
				}
				else if ($case == "save_update" )
				{
					Screen_Three::save_update_10( $data );
				}
				else if ($case == "get_name" )
				{
					$data['FAMILY_registration_number']			= $data['match_record']->row("name");
				}
				else
				{
					$this -> _10( $data );
				}
				break;
				
				
				
				
			case strpos($conference_slug, '9th') !== FALSE:
				if ($case == "validate" )
				{
					Screen_Three::validate_fields_9( $data );
				}
				else if ($case == "save_update" )
				{
					Screen_Three::save_update_9( $data );
				}
				else if ($case == "get_name" )
				{
					$data['FAMILY_registration_number']			= $data['match_record']->row("full_name");
				}
				else
				{
					$this -> _9( $data );
				}
				break;
				
				
				
				
			default:
				if ($case == "validate" )
				{
					Screen_Three::validate_fields_8( $data );
				}
				else if ($case == "save_update" )
				{
					Screen_Three::save_update_8( $data );
				}
				else if ($case == "get_name" )
				{
					$data['FAMILY_registration_number']			= $data['match_record']->row("name");
				}
				else
				{
					$this -> _8( $data );
				}
				break;
		}
		
	}
	
	
	public function _8( &$data )
	{
		
		$data['_pageview']								= "frontend/shortconference/screen_four.php";
	}
	
	
	public function _9( &$data )
	{
		
		$data['_pageview']								= "frontend/shortconference/9/screen_four.php";
	}

	public function _12( &$data )
	{
		
		$data['_pageview']								= "frontend/shortconference/12/screen_four.php";
	}
	
	public function _10( &$data )
	{
		#NO NEED TO DISPLAY SCREEN 4 IN 10 CONF.
		redirect( "shortconference/". $data['conference']->row("slug") ."/registration/screen/3" );
		
		$data['_pageview']								= "frontend/shortconference/10/screen_four.php";
	}
	
}