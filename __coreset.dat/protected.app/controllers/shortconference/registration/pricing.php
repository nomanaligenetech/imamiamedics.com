<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pricing extends C_frontend {

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
		
		#$this->_auth_login( FALSE );
		
		
		#SessionHelper::_set_session( $TMP_session, "conferenceregistration" );
		
		$this->data													= $this->default_data();
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');	
		
		$this->data['confreg_paymenttype_dropdown']					= DropdownHelper::short_conferenceregistration_paymenttype();
	}

	public function _12( &$data )
	{
		if ( !$this->validations->is_session("conferenceregistration") )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration" );
		}
		
		$data['conference_regions']						= $this->queries->fetch_records( 'short_conference_regions', 
																				 " AND id = '".SessionHelper::_get_session("regionid", "conferenceregistration")."'",
																				 "description, onsite_note");

		$data['registration_beforedate']		= format_date("F d, Y", $data['conference']->row("registration_from") );
		
		
		$tmp_parameter							= array(
		"regionid"			=> SessionHelper::_get_session("regionid", "conferenceregistration"),
														"conferenceid"		=> SessionHelper::_get_session("conferenceid", "conferenceregistration"));
		
		
		$data['prices_chart']					= $this->functions->conferencepayment_array( $tmp_parameter );

		// var_dump($data['prices_chart']); die;
		
		$regionQuery							= "";
		if(SessionHelper::_get_session("regionid", "conferenceregistration") != 0){
			$regionQuery						= " OR type = '".SessionHelper::_get_session("regionid", "conferenceregistration")."'"; 
		}
		
		$data['who_attend_list']				= $this->queries->fetch_records("short_conference_who_attend", " AND conferenceid = '". $data['conference']->row("id") ."' AND (type =  '0'".$regionQuery.")");
		
		$this->form_validation->set_rules('participanttypeid', 'Participant', 'trim|required');
		$this->form_validation->set_rules('regionid', 'Region', 'trim|required');
				
		$data['_pageview']						= "frontend/shortconference/12/pricing.php";
	
	}


	public function _9( &$data )
	{
		if ( !$this->validations->is_session("conferenceregistration") )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration" );
		}
		
		
		$data['registration_beforedate']		= format_date("F d, Y", $data['conference']->row("registration_from") );
		
		
		$tmp_parameter							= array("regionid"			=> SessionHelper::_get_session("regionid", "conferenceregistration"),
														"conferenceid"		=> SessionHelper::_get_session("conferenceid", "conferenceregistration"));
		
		
		$data['prices_chart']					= $this->functions->conferencepayment_array( $tmp_parameter );
		
		
		
		
		
		$this->form_validation->set_rules('participanttypeid', 'Participant', 'trim|required');
		$this->form_validation->set_rules('regionid', 'Region', 'trim|required');
		
		
		
		$data['_pageview']						= "frontend/shortconference/9/pricing.php";
	
	}
	
	public function _10( &$data )
	{
		#if ( $data['conferenceregistration'] -> num_rows() <= 0 )
		if ( !$this->validations->is_session("conferenceregistration") )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration" );
		}
		
		
		
		
		#$CONF_session							= SessionHelper::_get_session( 'conference_regions', " AND regionid = '". $data['conferenceregistration']->row("regionid") ."'" );
		/*;$data['conferenceregistration']->row("regionid") .*/
		
		$data['conference_regions']						= $this->queries->fetch_records( 'short_conference_regions', 
																				 " AND id = '". SessionHelper::_get_session("regionid", "conferenceregistration") . "'",
																				 "description, onsite_note");
		
		
		$data['registration_beforedate']		= format_date("F d, Y", $data['conference']->row("registration_from") );
		
		
		$tmp_parameter							= array("regionid"			=> SessionHelper::_get_session("regionid", "conferenceregistration"),
														"conferenceid"		=> SessionHelper::_get_session("conferenceid", "conferenceregistration"));

		$data['prices_chart']					= $this->functions->conferencepayment_array( $tmp_parameter );
		
		
		$regionQuery							= "";
		if(SessionHelper::_get_session("regionid", "conferenceregistration") != 0){
			$regionQuery						= " OR type = '".SessionHelper::_get_session("regionid", "conferenceregistration")."'"; 
		}
		
		$data['who_attend_list']				= $this->queries->fetch_records("short_conference_who_attend", " AND conferenceid = '". $data['conference']->row("id") ."' AND (type =  '0'".$regionQuery.")");
		
		
		
		$this->form_validation->set_rules('participanttypeid', 'Participant', 'trim|required');
		$this->form_validation->set_rules('regionid', 'Region', 'trim|required');
		
		
		
		$data['_pageview']						= "frontend/shortconference/10/pricing.php";
	}
	
	public function _8( &$data )
	{
		/*$data['conferenceregistration']			= $this->queries->fetch_records('conference_registration_master', 
																				" AND userid = '". $this->functions->_user_logged_in_details( "id" ) . "' 
																				  AND conferenceid = '". $data['conference'] -> row("id") ."' ");*/
		#if ( $data['conferenceregistration'] -> num_rows() <= 0 )
		if ( !$this->validations->is_session("conferenceregistration") )
		{
			redirect( "shortconference/". $data['conference']->row("slug") ."/registration" );
		}
		
		
		
		
		#$CONF_session							= SessionHelper::_get_session( 'conference_regions', " AND regionid = '". $data['conferenceregistration']->row("regionid") ."'" );
		/*;$data['conferenceregistration']->row("regionid") .*/
		$data['conference_regions']						= $this->queries->fetch_records( 'short_conference_regions', 
																				 " AND id = '". SessionHelper::_get_session("regionid", "conferenceregistration") . "'",
																				 "description, onsite_note");
		
		
		$data['registration_beforedate']		= format_date("F d, Y", $data['conference']->row("registration_from") );
		
		
		$tmp_parameter							= array("regionid"			=> SessionHelper::_get_session("regionid", "conferenceregistration"),
														"conferenceid"		=> SessionHelper::_get_session("conferenceid", "conferenceregistration"));
		
		$data['prices_chart']					= $this->functions->conferencepayment_array( $tmp_parameter );
		
		
		
		
		
		$this->form_validation->set_rules('participanttypeid', 'Participant', 'trim|required');
		$this->form_validation->set_rules('regionid', 'Region', 'trim|required');
		
		
		
		$data['_pageview']						= "frontend/shortconference/pricing.php";
	}
	


	public function index( $conference_slug = '' )
	{

		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$data									= $this->data;
		$data['h1']								= '';
		$data['_pagetitle']						= lang_line('text_conferenceregistrationpricing');
		
		$data['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");

		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
	
		
		
		$this -> _switchConference ( $conference_slug, $data );
		
		
		// var_dump($this->form_validation->run() == FALSE);die('dghf');

		
		if ($this->form_validation->run() == FALSE)
		{
			$data['_messageBundle2']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data );
		}
		else
		{
			/*$region_description					= $this->queries->fetch_records("conference_regions", " AND id = '". $this->input->post("regionid") ."' ", "description");
			$TMP_session						= array("participanttypeid"			=> $this->input->post("participanttypeid"),
														"regionid"					=> $this->input->post("regionid"),
														"regiondescription"			=> $region_description->row("description") );
			
			SessionHelper::_set_session( $TMP_session, "conferenceregistration" );*/
			
			
			redirect( site_url( "shortconference/". $data['conference']->row("slug") ."/registration/pricing" ) );
		}
		
		
		
		
	}
	
	
	function conference_login( $conference_slug){
		$data['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");

		$currentURL 		=  "shortconference/". $data['conference']->row("slug") ."/registration/pricing";
		$tmp_lasturl		= array("last_url"		=> $currentURL);
		SessionHelper::_set_session($tmp_lasturl);

		redirect(site_url('memberlogin'));
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