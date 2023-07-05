<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends C_frontend {

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
		

		$this->data													= $this->default_data();
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');	
		
		$this->data['confreg_paymenttype_dropdown']					= DropdownHelper::short_conferenceregistration_paymenttype();

	}
	
	
	public function success(  $conference_slug = ''  )
	{
		$is_post_get									= FALSE;
		$is_post_get_data								= array();
		$payment_mode									= "paypal";
		if ( count($_POST) > 1 )
		{
			$is_post_get_data 							= $_POST;
			$custom										= $is_post_get_data["custom"];
		} elseif ( count($_GET) > 1 )
		{
			$is_post_get_data 							= $_GET;
			$custom										= $is_post_get_data["cm"];
		}
		if($is_post_get_data['payment_status'] === 'Completed'){
			$is_post_get								= TRUE;
		}
		$data						= $this->data;
		

		
		$conference										= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");
		if ( $conference -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		$user_id = $this->functions->_user_logged_in_details( "id" ) > 0 ? $this->functions->_user_logged_in_details( "id" ) : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");
		
		
		$data['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
		" AND userid = '". $user_id . "' 
		AND conferenceid = '". $conference -> row("id") ."' ");

		$screen2								= $this->queries->fetch_records('short_conference_registration_screen_two', 
		" AND  conferenceregistrationid  = '". $data['conferenceregistration']->row("id") ."' LIMIT 1 ");
		$full_message									= "Upon successful registration, a special link will be sent to your email for booking your hotel nights at IMI's discounted rate at the Atlanta Evergreen Marriott Conference and Resort";
		
		$data['thank_you_note'] 						= "Thank you!";
		
		$login_button 	=  "If You would like become a registered user, please click here. <br> <a href=".site_url('register')." style='text-decoration:none;color: #ffffff;display: inline-block;padding: 5px 14px;background: #0070b0;border-radius: 4px;margin-top:11px;' > 
		IMI Member</a>" ;
		
		$redirect_if_guest_user 						= !$this->session->userdata('user_logged_in') ? $login_button : ''; 
		if ( $data['thank_you_note'] )
		{
			$data['content']							= '<div class="error_style" >
																			<div class="alert alert-success_big short-conference-thanks" style="margin:0px !important;margin-top:10px !important;">
																								<h1 class="short-conference-thanks">'.$data['thank_you_note'].'</h1><p style="   line-height: 1.85;">You have successfully registered for the conference.  Please check your email for the details.<br>'.$redirect_if_guest_user.'</p>               
																							</div>
																						</div>';
		}
		else
		{
			$data['_messageBundle']						= $this->_messageBundle( 	'success_big' , $full_message, 'Thank you');	
		}

		$user_id = $this->functions->_user_logged_in_details( "id" ) > 0 ? $this->functions->_user_logged_in_details( "id" ) : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");

		if($is_post_get){
			$saveData									= array(
																"userid"								=> $user_id,
																"conferenceid"							=> $conference -> row("id"),
																"payment_allow"							=> 1,
																"payment_type"							=> $payment_mode,
																"is_paid "								=> 1);
														
			$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_registration_master", 'userid|conferenceid');
			
			$membership_type = $screen2->row("be_a_member_fee");
			
			$this->load->library( '../controllers/home' );
			if($membership_type != 0){
				$abc = $this->home->membership_payment($user_id, $membership_type, $saveData);
			}

			$this->functions->send_tax_receipt_shortconference($user_id, $this, $conference_slug);

			SessionHelper::_unset_session('userid');
			SessionHelper::_unset_session('email');
		}

		
		$data['h1']					= '';
		$data['_pageview']			= "global/_blank_page.php";
		$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
	}

	public function payeezy_success(  $conference_slug = ''  )
	{

		$data						= $this->data;

		$conference										= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");
		if ( $conference -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}

		$full_message									= "Upon successful registration, a special link will be sent to your email for booking your hotel nights at IMI's discounted rate at the Atlanta Evergreen Marriott Conference and Resort";
		
		$data['thank_you_note'] 						= "Thank you!";
		
		$login_button 	=  "If You would like become a registered user, please click here. <br> <a href=".site_url('register')." style='text-decoration:none;color: #ffffff;display: inline-block;padding: 5px 14px;background: #0070b0;border-radius: 4px;margin-top:11px;' > 
		IMI Member</a>" ;
		
		$redirect_if_guest_user 						= !$this->session->userdata('user_logged_in') ? $login_button : ''; 
		if ( $data['thank_you_note'] )
		{
			$data['content']							= '<div class="error_style" >
																			<div class="alert alert-success_big short-conference-thanks" style="margin:0px !important;margin-top:10px !important;">
																								<h1 class="short-conference-thanks">'.$data['thank_you_note'].'</h1><p style="   line-height: 1.85;">You have successfully registered for the conference.  Please check your email for the details.<br>'.$redirect_if_guest_user.'</p>               
																							</div>
																						</div>';
		}
		else
		{
			$data['_messageBundle']						= $this->_messageBundle( 	'success_big' , $full_message, 'Thank you');	
		}

		SessionHelper::_unset_session('userid');
		SessionHelper::_unset_session('email');
		$data['h1']					= '';
		$data['_pageview']			= "global/_blank_page.php";
		$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
	
	}
	
	
	public function summary(  $conference_slug = ''  )
	{

		$this->_auth_login( FALSE );
		
		$data											= $this->data;
		

		if ( ! $this->left_queries['TOTAL_confregistrations_ispaid'] )
		{
			page_error( $data );
			return false;
		}
		
		

		
		
		$conference										= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");
		if ( $conference -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		
		
		$conferenceregistration							= $this->queries->fetch_records('short_conference_registration_master', 
																						" 	AND userid = '". $this->functions->_user_logged_in_details( "id" ) . "' 
																				  			AND conferenceid = '". $conference -> row("id") ."' ");
		if ( $conferenceregistration -> num_rows() <= 0 )
		{
			redirect( "shortconference/". $conference->row("slug") ."/registration" );
		}




		$conferenceregistration_screenthree				= $this->queries->fetch_records('short_conference_registration_screen_three', 
																						" 	AND conferenceregistrationid = '". $conferenceregistration->row("id") ."'  AND parentid = '0' ");
		
		
		$conference_regions								= $this->queries->fetch_records( "short_conference_regions", " AND id = '". $conferenceregistration->row("regionid") ."' ");
		
		
		
		if ( $conferenceregistration_screenthree -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}




		$this->load->library( '../controllers/admincms/manageshortconferenceregistration/controls', array("required_login" => FALSE) );
	
		
		$TMP_data['_directory']				= 'admincms/manageshortconferenceregistration/';	
		$TMP_data['important_content']		= $this->mixed_queries->fetch_records('conference_content_with_menu', 
																				 " 	AND m.slug = 'conference-registration-screen-five-important-section'
																				 	AND m.conferenceid = '". $conference->row()->id ."' ");
		$TMP_data['conference_regions']		= FALSE;
		$this->controls->include_view_screen_5(  $conferenceregistration_screenthree->row("id"), $TMP_data );
		
		
		
		
			
		$expired_content			= $this->mixed_queries->fetch_records('conference_content_with_menu', " AND m.slug = 'conference-registration-closed' ");
		$TMP_content				= FALSE;
		if ( $expired_content -> num_rows() > 0 )
		{
			$TMP_content			= '<div style="text-align:justify;">' . $expired_content->row("content") . '<div>';	
		}
	
		$data['_messageBundle']		= $this->_messageBundle( 	'danger_big' , 
																$TMP_content, 
																'Conference Registration Closed');
		
		
		
		
	
	
		$data['_messageBundle2']						= $this->_messageBundle( 	'warning' , 
																					"Please review your <strong>Conference Registration Summary</strong>", 
																					'');
		
		$data['SHOW_conferenceregistration_breadcrumbs']	= FALSE;
		$data['SHOW_submit_button_screen_5']				= FALSE;
		$data['h1']											= '';
		$data['_pagetitle']									= '';
		
		#$data['_pageview']									= "frontend/conference/screen_five.php";
		$this -> _switchConference ( $conference_slug, $data, "pageview_summary" );
		
		
		$data["_messageBundle2_nofamilyguest"]				= $this->_messageBundle( 'danger_big' , '&nbsp;', 'No Family Guest!');
		
		
		$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
	}


	public function closed(  $conference_slug = ''  )
	{
		if ( SessionHelper::_get_session("registration_days_remains", "conference") > 0 )
		{
			redirect( site_url('shortconference/'. $conference_slug .'/registration/screen/1') );
		}
		
		$data						= $this->data;
		
		
		
		
		
		$expired_content			= $this->mixed_queries->fetch_records('conference_content_with_menu', " AND m.slug = 'conference-registration-closed' ");
		$TMP_content				= FALSE;
		if ( $expired_content -> num_rows() > 0 )
		{
			$TMP_content			= '<div style="text-align:justify;">' . $expired_content->row("content") . '<div>';	
		}
	
		$data['_messageBundle']		= $this->_messageBundle( 	'danger_big' , 
																$TMP_content, 
																'Conference Registration Closed');
		
		
		
		
	
		$data['h1']					= '';
		$data['_pageview']			= "global/_blank_page.php";
		$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
	}


	public function _10( &$data )
	{
		$data['conference_menudetail']			= $this->queries->fetch_records('conferencemenu', " AND conferenceid = '". $data['conference']->row("id") ."'
																									AND slug = 'conference-registration-first-page' AND status = '1'");
		
		$data['conference_contentdetail']		= $this->db->query("SELECT 1 LIMIT 0");	
		if ( $data['conference_menudetail']->num_rows() > 0 )
		{
			$data['conference_contentdetail']		= $this->queries->fetch_records('conferencecontent', " AND menuid = '". $data['conference_menudetail']->row("id") ."' ");
		}
		
		#print_r($data['conference_contentdetail']->row());die;
		
		$data['content']						= "";
		if ( $data['conference_contentdetail']->num_rows() > 0 )
		{
			$data['content']					= $data['conference_contentdetail']->row("content");	
		}



		#print_r($_POST);
		#die;
		
		
		
		$this->form_validation->set_rules('participanttypeid', 'Participant', 'trim|required');
		$this->form_validation->set_rules('regionid', 'Region', 'trim|required');
		
		
		
		$data['_pageview']						= "frontend/conference/10/registration.php";
		if ($this->form_validation->run() == FALSE)
		{
			$data['_messageBundle2']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_INNER_VIEW, $data );
			
		}
		else
		{
			#to change later
			$region_description					= $this->queries->fetch_records("short_conference_regions", " AND id = '". $this->input->post("regionid") ."' ", "description");
			$TMP_session						= array("participanttypeid"			=> $this->input->post("participanttypeid"),
														"regionid"					=> $this->input->post("regionid"),
														"conferenceid"				=> $data['conference']->row("id"),
														/*"userid"					=> $this->functions->_user_logged_in_details( "id" ),*/
														"date_added"				=> date("Y-m-d H:i:s") );
			
			
			

			SessionHelper::_set_session( $TMP_session, "conferenceregistration" );
			
			
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration/pricing" );
		}
		
	}

	public function _12( &$data )
	{

		$region_description						= $this->queries->fetch_records("short_conference_regions", " AND conferenceid = '". $data['conference']->row()->id ."' LIMIT 1");
		
		$TMP_session							= array("participanttypeid"			=> 2, #international
														"regionid"					=> $region_description->row()->id,
														"conferenceid"				=> $data['conference']->row()->id,
														"userid"					=> $this->functions->_user_logged_in_details( "id" ),
														"date_added"				=> date("Y-m-d H:i:s") );
		SessionHelper::_set_session( $TMP_session, "conferenceregistration" );
		// var_dump($region_description->row()->id);die;
	
		
		redirect( site_url( "shortconference/". $data['conference']->row()->slug ."/registration/pricing" ) );
		
	}
	
	public function _8( &$data )
	{
		$data['conference_menudetail']			= $this->queries->fetch_records('conferencemenu', " AND conferenceid = '". $data['conference']->row("id") ."'
																									AND slug = 'conference-registration-first-page' AND status = '1'");
		
		$data['conference_contentdetail']		= $this->db->query("SELECT 1 LIMIT 0");	
		if ( $data['conference_menudetail']->num_rows() > 0 )
		{
			$data['conference_contentdetail']		= $this->queries->fetch_records('conferencecontent', " AND menuid = '". $data['conference_menudetail']->row("id") ."' ");
		}
		
		#	print_r($data['conference_contentdetail']->row());die;
		
		$data['content']						= "";
		if ( $data['conference_contentdetail']->num_rows() > 0 )
		{
			$data['content']					= $data['conference_contentdetail']->row("content");	
		}



		
		
		
		
		$this->form_validation->set_rules('participanttypeid', 'Participant', 'trim|required');
		$this->form_validation->set_rules('regionid', 'Region', 'trim|required');
		
		
		
		$data['_pageview']						= "frontend/conference/registration.php";
		if ($this->form_validation->run() == FALSE)
		{
			$data['_messageBundle2']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_INNER_VIEW, $data );
		}
		else
		{
			$region_description					= $this->queries->fetch_records("conference_regions", " AND id = '". $this->input->post("regionid") ."' ", "description");
			$TMP_session						= array("participanttypeid"			=> $this->input->post("participanttypeid"),
														"regionid"					=> $this->input->post("regionid"),
														"conferenceid"				=> $data['conference']->row("id"),
														/*"userid"					=> $this->functions->_user_logged_in_details( "id" ),*/
														"date_added"				=> date("Y-m-d H:i:s") );
			
			
			

			SessionHelper::_set_session( $TMP_session, "conferenceregistration" );
			
			
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration/pricing" );
		}
	}
	
	public function _9( &$data )
	{
		$region_description						= $this->queries->fetch_records("conference_regions", " AND conferenceid = '". SessionHelper::_get_session("id", "conference") ."' LIMIT 1");
		
		$TMP_session							= array("participanttypeid"			=> 2, #international
														"regionid"					=> $region_description->row()->id,
														"conferenceid"				=> $data['conference']->row()->id,
														/*"userid"					=> $this->functions->_user_logged_in_details( "id" ),*/
														"date_added"				=> date("Y-m-d H:i:s") );
		
		SessionHelper::_set_session( $TMP_session, "conferenceregistration" );
		
		
	
		
		redirect( site_url( "shortconference/". $data['conference']->row()->slug ."/registration/pricing" ) );
	}
	
	public function index( $conference_slug = '' )
	{
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		$data									= $this->data;
		$data['h1']								= '';
		
					#to change later
		$data['conference']						= $this->queries->fetch_records('short_conference', 
																				" AND slug = '". $conference_slug ."'");
		
		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		


		
		$this -> _switchConference ( $conference_slug, $data );
		
		
		
		
	}
	
	
	
	function _switchConference( $conference_slug, &$data, $case = false  )
	{
	
		switch ( $conference_slug )
		{
			case strpos($conference_slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:			
				if ($case == "pageview_summary" )
				{
					$data['_pageview']									= "frontend/shortconference/12/screen_five.php";
				}
				else
				{
					$this -> _12( $data );
				}
				break;

			case strpos($conference_slug, '10th') !== FALSE:
			
				if ($case == "pageview_summary" )
				{
					$data['_pageview']									= "frontend/shortconference/10/screen_five.php";
				}
				else
				{
					$this -> _10( $data );
				}
				break;
				
			case strpos($conference_slug, '9th') !== FALSE:
				if ($case == "pageview_summary" )
				{
					$data['_pageview']									= "frontend/shortconference/9/screen_five.php";
				}
				else
				{
					$this -> _9( $data );
				}
				break;
				
			default:
				if ($case == "pageview_summary" )
				{
					$data['_pageview']									= "frontend/shortconference/screen_five.php";
				}
				else
				{
					$this -> _8( $data );
				}
				break;
		}
		
	}
	
}