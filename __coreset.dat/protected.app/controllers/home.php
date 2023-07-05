<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_Output output
 */
class Home extends C_frontend {

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
		$this->load->helper('text');
		
		#$this->load->library('parser');
		
		
		$this->data													= $this->default_data();
		
		#$this->data['_show_default_title']							= FALSE;
		$this->data['_pagetitle']									= '';# "IMI's 8th International Conference: Research, International Development & Health Advancements";

		$this->data['showThings']['_show_SLIDER']					= TRUE;	
		$this->data['showThings']['_show_CONF_PARTNERS']			= TRUE;
		
		
	}
	
	function testing_parser()
	{
		$this->load->library('testparser');
		
		
		$data														= $this->data;		
		
		
		$data['site_gallery']										= $this->queries->fetch_records('site_gallery', " AND status = '1' ") -> result_array();
		
		
		
		$data['_pageview']											= "frontend/home";		
		
		
		$this->load->view( FRONTEND_TEMPLATE_HOME_VIEW, $data );	
		#$this->testparser->parse('frontend/template/index', $data);
		
		
	}
	
	
	public function test_email()
	{
		/*$a = unserialize('a:10:{s:6:"userid";s:2:"13";s:12:"conferenceid";s:1:"2";s:26:"conference_registration_id";s:2:"14";s:11:"payer_email";s:27:"binyameen12-buyer@gmail.com";s:13:"payment_gross";s:6:"100.00";s:12:"ipn_track_id";s:13:"ac21a7c683032";s:8:"payer_id";s:13:"6NDQPYP4USQN2";s:14:"payment_status";s:9:"Completed";s:11:"paypal_post";s:1486:"a:41:{s:8:"mc_gross";s:6:"100.00";s:22:"protection_eligibility";s:8:"Eligible";s:14:"address_status";s:9:"confirmed";s:8:"payer_id";s:13:"6NDQPYP4USQN2";s:3:"tax";s:4:"0.00";s:14:"address_street";s:21:"123 West Hall, Indoze";s:12:"payment_date";s:25:"00:35:24 Dec 30, 2014 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:12:"windows-1252";s:11:"address_zip";s:5:"85323";s:10:"first_name";s:3:"Bin";s:6:"mc_fee";s:4:"3.20";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:7:"QA TEAM";s:14:"notify_version";s:3:"3.8";s:6:"custom";s:0:"";s:12:"payer_status";s:8:"verified";s:8:"business";s:25:"binyameenseller@gmail.com";s:15:"address_country";s:13:"United States";s:12:"address_city";s:8:"Avondale";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"A9fCCdLpF7Un06UbWlPM2Kfly1-jAkO1qNrk2msyxCUCF9HMs-ldbDIc";s:11:"payer_email";s:27:"binyameen12-buyer@gmail.com";s:6:"txn_id";s:17:"5HX44217C2934743N";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:5:"Buyer";s:13:"address_state";s:2:"AZ";s:14:"receiver_email";s:25:"binyameenseller@gmail.com";s:11:"payment_fee";s:4:"3.20";s:11:"receiver_id";s:13:"ZRPW28PALECH2";s:8:"txn_type";s:10:"web_accept";s:9:"item_name";s:12:"registration";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:2:"13";s:17:"residence_country";s:2:"US";s:8:"test_ipn";s:1:"1";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:6:"100.00";s:8:"shipping";s:4:"0.00";s:12:"ipn_track_id";s:13:"ac21a7c683032";}";s:10:"date_added";s:19:"2014-12-30 09:35:54";} ');
		
		
		$this->queries->SaveDeleteTables($a, 's', "tb_conference_payments", 'id'); 
		
		print_r( $a );die;
		
		$message 					= 'test ' .  print_r( $_POST );*/
		
		$message	= "abc";
	
	
		#to_user
		$email_template				= array("email_to"				=> 'sadiq.hussain@genetechsolutions.com',
											"email_heading"			=> 'TEST',
											"email_file"			=> "email/global/_blank_page.php",
											"email_subject"			=> 'TESTT',
											"email_post"			=> array("content"		=> $message) );
		
		$is_email_sent				= $this->_send_email( $email_template );
	}

    public function _404()
    {
        /*$this->output->set_status_header('404');

        $data = $this->data;

        $data['showThings']['_show_SLIDER'] = FALSE;
        $data['showThings']['_show_CONF_PARTNERS'] = FALSE;


        $data['_pagetitle'] = lang_line("text_404error");


        $data['content'] = "<div align='center' style='margin:50px;'><img src='" . base_url('assets/frontend/images/404.png') . "' /></div>";
        $data['_pageview'] = "global/_blank_page.php";
		$this->load->view(FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW, $data);*/
		show_404();
    }
	
	public function index()
	{ 
		
		$data														= $this->data;		
		
		
		
		$siteIdQuery												= getSiteId();
		
		$data['site_gallery']										= $this->queries->fetch_records('site_gallery', " AND status = '1' ".$siteIdQuery." ORDER BY SORT ");
		
		$data['timelinehistory']									= $this->queries->fetch_records('timelinehistory', " AND status = '1' ".$siteIdQuery." ORDER BY SORT ASC ");
		$data['_js_timeline_history_count']							= $data['timelinehistory'] -> num_rows();
		if ( $data['timelinehistory'] -> num_rows() > 4 )
		{
			$data['_js_timeline_history_count']						= 4;
		}
		$parentID = is_countryCheck(FALSE,FALSE,TRUE) == 'medics' ? 429 : SessionHelper::_get_session("WHATWEDO_MENUID", "site_settings");
		$data['centermenu']											= $this->queries->fetch_records('cmsmenu', 
																									" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_HEADER ."' 
																										AND parentid = '". $parentID ."'
																										AND status = '1'");
		
		$data['wherewework']										= $this->queries->fetch_records('wherewework', " AND status = '1' ");
		$data['wherewework']										= new CustomMySql($data['wherewework'], $this, 'wherewework', ['title','short_desc','full_desc']);
		$data['spotlight']										= $this->queries->fetch_records('spotlight');
		$data['eventslist'] = $this->queries->fetch_records('sitesectionswidgets', " 	AND start_date >= '". date("Y-m-d") ."' 
													AND status = 1 
													AND mode = '". SLUG_EVENTS ."' ORDER BY SORT LIMIT 5 ");
					
		if($data['eventslist']->num_rows() > 0){
			$data['eventslist']											= new CustomMySql($data['eventslist'], $this, 'sitesectionswidgets', ['title', 'short_desc', 'full_desc']);
			$data['eventslist']->row()->content = $data['eventslist']->row()->full_desc;
		}
		
		
		
		$data['_pageview']											= "frontend/home.php";
		
		$this->load->view( FRONTEND_TEMPLATE_HOME_VIEW, $data );
	}
	
	public function conf_payment_email($conference_regions, $data, $post_data, $register_id, $is_paypal = false){

		#*************************** *************************** *************************** 
		#*************************** 	    EMAIL PREPARATION 	 *************************** 
		#*************************** *************************** *************************** 
		
		$user_details					= $this->queries->fetch_records( "conf_users", " AND id = '". $post_data['user_id'] ."' ");
		
		// var_dump($user_details);die;
		$crs_three						= $this->queries->fetch_records('short_conference_registration_screen_three', 
																		" AND conferenceregistrationid = '". $register_id ."' ");
		
			
		
		// $this->load->library( '../controllers/admincms/manageshortconferenceregistration/controls', array("required_login" => FALSE) );
	
		
		// $TMP_data['_directory']			= 'admincms/manageshortconferenceregistration/';	
		// $TMP_data['important_content']	= $this->mixed_queries->fetch_records('short_conference_content_with_menu', 
		// 																		 " AND m.slug = 'conference-registration-screen-five-important-section' AND m.conferenceid = '". $data['conference']->row()->id ."'");
		// $TMP_data['conference_regions']	= $conference_regions;
		
		// $screen_5_view					= $this->controls->include_view_screen_5( $crs_three->row("id"), $TMP_data );
		// $screen_5_view					= str_replace(
		// 											  sprintf( lang_line("text_screen5_planningtostay"), date("jS F", strtotime($data['conference']->row("duration_to")) )),  
		// 											  sprintf( lang_line("text_screen5_planningtostay_2"), date("jS F", strtotime($data['conference']->row("duration_to")) )),  
		// 											  $screen_5_view
		// 											  );
		
		
		
		
		
		
		
		//redeclare session
		if($is_paypal){			
			SessionHelper::site_settings_session();
			SessionHelper::active_conference_session();
		}
		
		
		
		// //muslimraza:18-11-2019
		// $TMP_screen_one							= $this->queries->fetch_records('short_conference_registration_screen_one', 
		// 																		" AND conferenceregistrationid = '". $register_id ."' ");
																						
		// $TMP_country_notes						= $this->queries->fetch_records(	'short_conference_residence_country_notes', 
		// 																		  	" 	AND country_id = '".   $TMP_screen_one->row()->country_of_residence ."' 
		// 																				AND conferenceid = '". $data['conference']->row()->id ."'   ");
																						
		// $_SHOW_CONTENT_WITH_BANK_DETAILS_FOR_LOCAL_OR_INT_BUT_PAYMENT_NOT_ALLOWED			= FALSE;
		// if ( $TMP_data['conference_regions']->num_rows() > 0 )
		// {
		// 	//IF REGION PAYMENT NOT ALLOWED
		// 	if ( !$TMP_data['conference_regions']->row()->allow_payment )
		// 	{
		// 		$_SHOW_CONTENT_WITH_BANK_DETAILS_FOR_LOCAL_OR_INT_BUT_PAYMENT_NOT_ALLOWED	= TRUE;
		// 	}
			
		// 	//OR IF REGION IS LOCAL
		// 	if ( is_conference_registered_for_local(FALSE, $TMP_data['conference_regions']->row()->id) )
		// 	{
		// 		$_SHOW_CONTENT_WITH_BANK_DETAILS_FOR_LOCAL_OR_INT_BUT_PAYMENT_NOT_ALLOWED	= TRUE;
		// 	}
		// }
		
		// if ( $TMP_country_notes->num_rows() > 0 )
		// {
		// 	//IF COUNTRY RESIDENCE NOT ALLOWED PAYMENT
		// 	if ( !$TMP_country_notes->row()->allow_payment_for_this_country )
		// 	{
		// 		$_SHOW_CONTENT_WITH_BANK_DETAILS_FOR_LOCAL_OR_INT_BUT_PAYMENT_NOT_ALLOWED	= TRUE;
		// 	}
		// }

		$email_file_view_php				= "email/frontend/conference_payment.php";
		$email_heading_and_subject			= lang_line("text_conferencepayment");
		// if ( $_SHOW_CONTENT_WITH_BANK_DETAILS_FOR_LOCAL_OR_INT_BUT_PAYMENT_NOT_ALLOWED)
		// {
		// 	$email_file_view_php			= "email/frontend/conference_payment_local.php";	
		// 	$email_heading_and_subject		= "Conference Registration";
		// }
		//muslimraza:18-11-2019														





		/*
		#to_admin				
		$_POST["TEXT_p"]				= $user_details->row("name") . ' ' . $user_details->row("last_name") . '
										  successfully paid for <strong>'. $data['conference']->row("name") . '</strong> Conference.';
		
		
		
		$email_template					= array("email_heading"									=> $email_heading_and_subject,
												"email_file"									=> $email_file_view_php,
												"email_subject"									=> $email_heading_and_subject,
												"default_subject"								=> TRUE,
												"email_post"									=> $_POST,
												
												"_messageBundle2_nofamilyguest"					=> $this->_messageBundle( 'danger_big' , '&nbsp;', 'No Family Guest!'),
												
												"screen_5_view"									=> $screen_5_view,
												#"debug" => TRUE
												
												
												);
		
		$is_email_sent					= $this->_send_email( $email_template );
		#to_admin
		*/
		
		
		
		
		#to_user
		// $post_data['conferenceregistration_screentwo']		= $this->queries->fetch_records('short_conference_registration_screen_two', 
		// " AND conferenceregistrationid = '". $data['conference']->row()->id  ."' ");
		// var_dump($post_data['conferenceregistration_screentwo']);die;
		$post_data["TEXT_p"]				= 'Dear ' . $user_details->row("name") . ' ' . $user_details->row("last_name") . ',
										   <br /> <br />Thank you for registering for '. $data['conference']->row("name") .' to be held in '. $data['conference']->row("country_name") .' from ' . date("F d, Y", strtotime( $data['conference']->row("duration_from") ) ) . ' to '. date("F d, Y", strtotime( $data['conference']->row("duration_to") ) ) .'. Below is the summary for your registration including hotel information as well as some important notices that you should bear in mind
											
										   <br /> <br />

										   Would you like to buy additional add-ons (Banquet Tickets, Zehra Social Networking, Sightseeing or CE Hours?) after your registration? Please email <a href="mailto:imihq@imamiamedics.com">imihq@imamiamedics.com</a>

										   <br /> <br />

										   To buy full tables for the Gala Dinner and Banquet (10 seats for $1000 USD), please email <a href="mailto:imihq@imamiamedics.com">imihq@imamiamedics.com</a>
											
										   <br /> <br />

										   A very limited amount of Banquet Tickets will be available at the door for an increased price.';
		$post_data["show_comment"]			= true;
											  
		$email_template					= array("email_to"										=> $user_details->row("email"),
												"email_bcc"										=> SessionHelper::_get_session("EMAIL_TO", "site_settings"),
												"email_heading"									=> $email_heading_and_subject,
												"email_file"									=> $email_file_view_php,
												"email_subject"									=> $email_heading_and_subject,
												"default_subject"								=> TRUE,
												"email_post"									=> $post_data,
												);
	
		$is_email_sent				= $this->_send_email( $email_template );
		#to_user
		
		
		
		
		
		#test email
		$message 					= 'test _ payment ' . serialize( $post_data ) ;
		$email_template				= array("email_to"				=> 'rida.fatima@genetechsolutions.com',
											"email_heading"			=> 'TEST',
											"email_file"			=> "email/global/_blank_page.php",
											"email_subject"			=> 'TESTT',
											"email_post"			=> array("content"		=> $message) );
		
		// $is_email_sent				= $this->_send_email( $email_template );
		#test email
		
		
	 
		#*************************** *************************** *************************** 
		#*************************** 	    EMAIL PREPARATION 	 *************************** 
		#*************************** *************************** *************************** 
		return true;
	}
	public function payment_notify( $conference_slug = '', $register_id = '', $payment_mode = '' )
	{
		$data													= $this->default_data();
		
		$data['conference']										= $this->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");
		
		
		$conf_id							= 0;
		if ( $data['conference']	 -> num_rows() > 0 )
		{
			$conf_id						= $data['conference']	->row("id");	
		}
		
		
		if ( $register_id == '' )
		{
			$register_id					= 0;
		}
		
		
		if ( $payment_mode == '' )
		{
			$payment_mode					= "paypal";	
		}
		
	
		
		$PAYMENT_status									= 1;
		if ( $payment_mode == 'cash' )
		{
			$PAYMENT_status								= 0;
		}

		if ( is_localhost() and $payment_mode != 'cash' and FALSE )
		{
			$_POST["item_number"]						= 13;
			$_POST["payer_email"]						= "payment@yopmail.com";
			$_POST["payment_gross"]						= 2070;
			$_POST["ipn_track_id"]						= rand(0, 9999);
			$_POST["payer_id"]							= rand(0, 9999);
			$_POST["payment_status"]					= 'Completed';
			
			
			$_POST										= unserialize( 'a:43:{s:8:"mc_gross";s:7:"1995.00";s:22:"protection_eligibility";s:10:"Ineligible";s:14:"address_status";s:9:"confirmed";s:8:"payer_id";s:13:"6NDQPYP4USQN2";s:14:"address_street";s:21:"123 West Hall, Indoze";s:12:"payment_date";s:25:"01:40:47 Nov 06, 2019 PST";s:14:"payment_status";s:7:"Pending";s:7:"charset";s:12:"windows-1252";s:11:"address_zip";s:5:"85323";s:10:"first_name";s:3:"Bin";s:6:"mc_fee";s:5:"58.16";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:7:"QA TEAM";s:14:"notify_version";s:3:"3.9";s:6:"custom";s:0:"";s:12:"payer_status";s:8:"verified";s:8:"business";s:25:"binyameenseller@gmail.com";s:15:"address_country";s:13:"United States";s:12:"address_city";s:8:"Avondale";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"A6UtrHtJxSg.pfXDw-1oFPTHdmnVA2n-Jx8tKhu2GFUaTc69Nj8D-eY.";s:11:"payer_email";s:27:"binyameen12-buyer@gmail.com";s:6:"txn_id";s:17:"44H719236D272372L";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:5:"Buyer";s:13:"address_state";s:2:"AZ";s:14:"receiver_email";s:25:"binyameenseller@gmail.com";s:11:"payment_fee";s:5:"58.16";s:17:"shipping_discount";s:4:"0.00";s:16:"insurance_amount";s:4:"0.00";s:11:"receiver_id";s:13:"ZRPW28PALECH2";s:14:"pending_reason";s:13:"paymentreview";s:8:"txn_type";s:10:"web_accept";s:9:"item_name";s:29:"10th International Conference";s:8:"discount";s:4:"0.00";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:5:"38301";s:17:"residence_country";s:2:"US";s:8:"test_ipn";s:1:"1";s:15:"shipping_method";s:7:"Default";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:7:"1995.00";s:12:"ipn_track_id";s:13:"4fe1866d69b50";}');
			$PAYMENT_status								= 1;
		}
		
		
		
		// $user_details									= $this->queries->fetch_records( "users", " AND id = '". $_POST["item_number"] ."' ");
		
		
		
		
		
		
		$saveData										= array("userid"								=> $_POST["item_number"],
																"conferenceid"							=> $conf_id,
																"conference_registration_id"			=> $register_id,
																"payer_email"							=> $_POST["payer_email"],
																"payment_gross"							=> $_POST["payment_gross"],
																"ipn_track_id"							=> $_POST["ipn_track_id"],
																"payer_id"								=> $_POST["payer_id"],
																"payment_status"						=> $_POST["payment_status"],
																"paypal_post"							=> serialize( $_POST ),
																"date_added"							=> date("Y-m-d H:i:s"));
			
			
		
		$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_payments", 'id'); 
		
		  
		  
		
		
		
		$conference_master								= $this->queries->fetch_records( "short_conference_registration_master", " AND id = '". $register_id ."' ");
		$conference_regions								= $this->queries->fetch_records( "short_conference_regions", " AND id = '". $conference_master->row("regionid") ."' ");
		
		
		$saveData										= array("id"									=> $register_id,
																
																"userid"								=> $_POST["item_number"],
																"conferenceid"							=> $data['conference']->row("id"),
																
																"payment_allow"							=> $conference_regions->row("allow_payment"),
																"payment_type"							=> $payment_mode,
																
																"is_paid "								=> $PAYMENT_status); 
			
		
		$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_registration_master", 'id'); 
		
		
		$TMP_screen_two									= $this->queries->fetch_records('conference_registration_screen_two', 
																				" AND conferenceregistrationid = '". $register_id ."' ");
		$membership_type								= $TMP_screen_two->row("be_a_member_fee");
		if($membership_type != 0){
			$abc = $this->membership_payment($_POST["item_number"], $membership_type, $_POST);
		}

		$_POST["user_id"]								= $_POST["item_number"];
		$xyz = $this->conf_payment_email($conference_regions, $data, $_POST, $register_id, true);
		
		return true;
	}

	public function membership_payment($userid, $membership_id_from_paypal, $paypal){
		$user_from_db = $this->db_imiconf->query('select * from tb_users where id = ?',array($userid))->row_array();
		
        if (!$user_from_db) {
            die("user not exists: ".$userid);
        }

        $chosen_membership = $this->db->query('SELECT * FROM tb_short_conference_prices_not_a_member WHERE id = ?', array($membership_id_from_paypal))->row_array();
        if (!$chosen_membership) {
			die("membership not exists: ".$membership_id_from_paypal);
        }

		$membership_start_date = date('Y-m-d h:i:s');
		$membership_end_date = "9999-12-31 00:00:00";
	
		if ( strtolower($chosen_membership['per']) == "year" || strtolower($chosen_membership['per']) == 'yearly' ){
			$user_memberships = $this->imiconf_queries->fetch_records("user_memberships", " AND user_id = '  $userid' AND member_expiry IS NOT NULL ORDER BY id DESC LIMIT 1");
			if (!empty($user_memberships) && $user_memberships->num_rows() > 0) {

				if ( $user_memberships->row()->member_expiry > strtotime('+6 years') ){
					$membership_start_date = date('Y-m-d h:i:s');
				}else{
					$member_expiry = strtotime($user_memberships->row()->member_expiry);
					$membership_start_date = date('Y-m-d h:i:s', $member_expiry);
				}

				$membership_end_date = date('Y-m-d h:i:s', strtotime("+1 year", strtotime($membership_start_date)));
			}
		}


		$this->db_imiconf->query('insert into tb_user_memberships(user_id, date_purchased, member_expiry , membership_package_name, membership_package_price, membership_package_per, paypal_payer_email, paypal_payment_gross, paypal_ipn_track_id, paypal_payer_id, paypal_payment_status, paypal_post ,membership_short_package_id) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            array(
                $userid,
				$membership_start_date,
				$membership_end_date,
                $chosen_membership['name'],
                $chosen_membership['price'],
                $chosen_membership['per'],
                isset($paypal['payer_email']) ? $paypal['payer_email'] : null,
                isset($paypal['payment_gross']) ? $paypal['payment_gross'] : $_GET['amt'],
                isset($paypal['ipn_track_id']) ? $paypal['ipn_track_id'] : null,
                isset($paypal['payer_id']) ? $paypal['payer_id'] : null,
                isset($paypal['payment_status']) ? $paypal['payment_status'] : $_GET['st'],
                !empty($paypal) ? serialize($paypal) : serialize($_GET),
				$chosen_membership['id']
            )
        );
		// var_dump($this->db_imiconf->last_query());die;
        $saveData['id'] = $userid;
		$saveData['ispaid']=1;

        $this->queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_users", 'id'); 

		# line added because data required for auto-receipt.
		$load_membership = $this->imiconf_queries->fetch_records("user_memberships", " AND user_id = '$userid' ORDER BY id DESC LIMIT 1");
		
		// if (!empty($load_membership->row()->id)) {
		// 	// create tax receipt pdf and send it to user.
		// 	self::send_tax_receipt_members($load_membership->row()->id, $this);
		// }
			// var_dump($user_from_db['is_paid_membership_approved']);die;
        if ($user_from_db['is_paid_membership_approved'] == 0) {
			
			
			$_finance = array( 'IMIFinance786@gmail.com','RomeenaIMI@Gmail.com');
			$email_template					= array("email_to"										=> $_finance,
												"email_bcc"										=> SessionHelper::_get_session("EMAIL_TO", "site_settings"),
												"email_heading"									=> 'New Paid IMI member is now waiting for approval.',
												"email_file"									=> 'email/frontend/paid_member_pending_approval.php',
												"email_subject"									=> 'New Paid IMI member is now waiting for approval.',
												"default_subject"								=> TRUE,
												"email_post"									=> array(
													'user name' => self::user_row_to_displayable_name($user_from_db),
													'email address' => $user_from_db['email'],
													'amount' => $chosen_membership['price'],
													'package' => $chosen_membership['name'],
													'address_name' => $paypal['address_name'],
													'address_street' => $paypal['address_street'],
													'address_city' => $paypal['address_city'],
													'address_state' => $paypal['address_state'],
													'address_country_code' => $paypal['address_country_code'],
													'address_zip' => $paypal['address_zip'],
												)
												);
		
			$is_email_sent				= $this->_send_email( $email_template );
        }

		return true;

	}
}