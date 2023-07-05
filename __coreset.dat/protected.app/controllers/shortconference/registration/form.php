<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form extends C_frontend
{

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

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('payeezy');

		// $this->_auth_login( FALSE );
		$this->validations->is_conference_registration_expired();

		$this->data													= $this->default_data();
		$this->data['_pagetitle']									= lang_line('text_conferenceregistration');
		$this->data['h1']											= lang_line('text_conferenceregistration');

		$this->data['confreg_paymenttype_dropdown']					= DropdownHelper::short_conferenceregistration_paymenttype();
		$this->data['tmp_paymenttype']								= DropdownHelper::short_conferenceregistration_paymenttype(TRUE, TRUE);

		$this->data['tmp_earlybird_regular']						= DropdownHelper::short_conferenceprice_earlybird_regular_dropdown();

		$this->data['numbers_multiplyby']							= NumberHelper::number_array(range("1", "10"));
		$this->data['numbers_multiplyby_onlyone']					= NumberHelper::number_array(range("1", "1"));




		$this->data['breadcrumbs'][1]								= "stepcompleted";
		$this->data['breadcrumbs'][2]								= "active";


		$this->data['_messageBundle2']								= $this->data['_messageBundle2_nofamilyguest']				= $this->data['_messageBundle'];


		$this->data['_messageBundle_youcanalwaysresumelater']		= $this->_messageBundle(
			'warning',
			lang_line("text_youcanalwayspaylater"),
			lang_line("heading_operation_info") . ':'
		);
	}


	public function index($conference_slug)
	{


		$data									= $this->data;
		$data['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '" . $conference_slug . "' ");

		if ($data['conference']->num_rows() <= 0) {
			page_error($data);
			return false;
		}

		$data['registration_beforedate']				= format_date("F d, Y", $data['conference']->row("registration_from"));
		$data['registration_afterdate']					= conference_registrationdates($data['conference']);

		$data['tmp_paymenttype']						= DropdownHelper::short_conferenceregistration_paymenttype(TRUE, TRUE);
		$data['tmp_earlybird_regular']					= DropdownHelper::short_conferenceprice_earlybird_regular_dropdown();

		$tmp_parameter									= array(
			"regionid"			=>  SessionHelper::_get_session("regionid", "conferenceregistration"),
			"conferenceid"		=>  $data['conference']->row("id")
		);
		$data['prices_chart']							= $this->functions->conferencepayment_array($tmp_parameter);

		$this->itemForm($conference_slug, $data['registration_beforedate'] , $data);


	}


	public function itemForm($conference_slug, $registration_beforedate, $data)
	{

		// $this->form_validation->set_rules('no_of_family_members', 'No. of Family Members', 'trim');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->input->post("no_of_family_members") > 0) {
			
			for ($i = 1; $i <= $this->input->post("no_of_family_members"); $i++) {
				$this->form_validation->set_rules('family_name[' . $i . ']', 'Name', 'trim|required');
				$this->form_validation->set_rules('family_email[' . $i . ']', 'Email', 'trim|required|valid_email');
				// $this->form_validation->set_rules('family_relationship[' . $i . ']', 'Relationship', 'trim');
				// $this->form_validation->set_rules('family_age[' . $i . ']', 'Age', 'trim');
			}
		}

		$user_id = $this->functions->_user_logged_in_details("id") > 0 ? $this->functions->_user_logged_in_details("id") : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");

		$data['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '" . $conference_slug . "' ");

		$data['conferenceregistration']			= $this->queries->fetch_records(
			'short_conference_registration_master',
			" AND userid = '" . $user_id . "' 
																				  AND conferenceid = '" . $data['conference']->row("id") . "' "
		);

		// var_dump($this->db->last_query());die;

		$data['conferenceregistration_screenone']		= $this->queries->fetch_records(
			'short_conference_registration_screen_one',
			" AND conferenceregistrationid = '" . $data['conferenceregistration']->row("id") . "' "
		);

		/*Weightage check */
		// $paymenttypeid = SessionHelper::_get_session("participanttypeid", "conferenceregistration");
		$paymenttypeid = 1;

		$TMP_total_weight_have			= 0;

		if ($this->input->post("registration_tickets_child")) {

			foreach ($_POST['registration_tickets_child'] as $tmp_id	=> $tmp_value) {


				$user_id = $this->functions->_user_logged_in_details("id") > 0 ? $this->functions->_user_logged_in_details("id") : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");
				
				$this->queries->fetch_records(
					"short_conference_prices_master",
					" AND parent_id is NULL  AND is_optional = 0 AND id IN (SELECT parentid FROM `tb_short_conference_prices_details` WHERE id = " . $tmp_id . " AND typeid	= '" . $paymenttypeid . "') ",
					" whoattendid "
				);


				$t							= $this->queries->fetch_records("short_conference_who_attend",  " AND id IN (" . $this->db->last_query() . ") ");


				if ($t->num_rows() > 0) {
					$t						= $t->row("no_of_people");
					if (isset($_POST["multiply_by"]) && $_POST["multiply_by"] > 0) {

						if (array_key_exists($tmp_id, $_POST["multiply_by"])) {
							
							$t			= $t * 	$_POST["multiply_by"][$tmp_id];
						}
					}

					$TMP_total_weight_have		+= $t;
				}
				
			}
		}

		// #compare weight (prev. selected) with new one.
		// var_dump($this->input->post("no_of_family_members"));
		// echo '<br>---------------------------<br>';
		// var_dump((int) $TMP_total_weight_have   );

		if ((int)$this->input->post("no_of_family_members") + 1 != (int) $TMP_total_weight_have) {
			
			$this->form_validation->set_rules('hdn_total_no_of_people_weight', '---', 'trim|callback_validate_noofpersonscount');
		}


		if(($this->form_validation->run() == FALSE) ){

			// var_dump(validation_errors());

			if (validation_errors() != '') {
				$data['_messageBundle2']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
				
				// $data['_messageBundle2']			= $this->_messageBundle('danger', lang_line('text_pleasecompleteformwithproperinfo'), 'Error!');
				
			}

			// $this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');

			// if (!$this->input->post("card_payment")) {
			// 	$this->form_validation->set_error_delimiters('<p class="form_error" style="display:none;">', '</p>');
			// }

		}else{
			if(($this->input->post("makepayment"))){ // paypal payment
				
				$insertedId = $this->inserData($registration_beforedate, $data['conference'], $data);
				if($insertedId){

					$data['total_amount'] = $this->input->post("txt_total_payable");
					$data['_pageview']						= "frontend/shortconference/payment-paypal.php";
					$data['user_id'] = $insertedId;
					
					$this->load->view(FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data);
				}
				
				return false;


			} else if (($this->input->post("card_payment"))  ) { // card payment

				// if payment sucess else
				

				/* $saveData											= array("payment_type"=> $_POST['payment_type'],
				"id"=> $data['conferenceregistration']->row("id"));

				$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_registration_master", 'id'); */


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
					$pay = $pay->pay($card_information, $this->input->post("txt_total_payable"), $this->input->post("email"));

					if ( ! is_array($pay) ){
						$data['card_error'] = "Something Went Wrong! Please Try Again.";
					} else {

						if ( isset($pay['error'] ) ){
							$data['card_error'] = $pay['error'];
						} else {
							
							if ( isset($pay['success'] ) ){
							
								$user_id = $this->inserData($registration_beforedate, $data['conference'], $data);
								
								
	
								$this->functions->send_tax_receipt_shortconference($user_id, $this, $conference_slug);	

								$register_id = 0;
								// $userId 										= $this->functions->_user_logged_in_details("id");
								$saveData										= array("userid"								=> $user_id,
																						"conferenceid"							=> $data['conference']->row("id"),
																						"conference_registration_id"			=> $data['conferenceregistration']->row("id"),
																						"payer_email"							=>  $this->input->post("email"),
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

								$data['conferenceregistration']			= $this->queries->fetch_records(
									'short_conference_registration_master',
									" AND userid = '" . $user_id . "' 
																										  AND conferenceid = '" . $data['conference']->row("id") . "' "
								);
								
								$saveData['request_data'] 						= isset($pay['request'] ) ? json_encode($pay['request']) : '';
			
								$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_payments", 'id');

								$editData['payment_type'] = $_POST['payment_type'];
	
								$editData['is_paid'] 						= 1;
								$editData['id'] 							= $data['conferenceregistration']->row('id');
								
								$this->queries->SaveDeleteTables($editData, 'e', "tb_short_conference_registration_master", 'id');
								// var_dump($this->db->last_query());
								$_POST["card_number"]						= substr($_POST["card_number"], -4);
	
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
								
								redirect( site_url("shortconference/". $data['conference'] -> row("slug") ."/registration/form/paymentsuccess") );
							}
							
						}
					}
				}
				
				
			} 
		}

		$data['h1']								= '';
		$data['_pagetitle']						= lang_line('text_conferenceregistration');

		$data['_pageview']						= "frontend/shortconference/form.php";
		// $data['_pageview']						= "global/_blank_page.php";	
		$this->load->view(FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data);
		return false;

		
	}

	public function inserData($registration_beforedate, $conference, $data){
		
		
		if (!$this->functions->_user_logged_in_details("id")) {
			
			$guest_user_data = array(
				"prefix_title"				=> $this->input->post("prefix"),
				"name"						=> $this->input->post("name"),
				"email"						=> $this->input->post("email"),
				"password"					=> 'abc',
				"registration_site"			=> 'IMIWebPortal',
				"is_active"					=> 0,
				"date_added"				=> date("Y-m-d H:i:s")
			);

			$data['guest_user'] = $this->queries->fetch_records('users', "AND email = '" . $this->input->post("email") . "'  ");

			if ($data['guest_user']->num_rows() <= 0) {

				$this->queries->SaveDeleteTables($guest_user_data, 's', "imi_conf_restore2.tb_users", 'id');
				$insertedID							= $this->db->insert_id();
			}

			$data['guest_user'] = $this->queries->fetch_records('users', "AND email = '" . $this->input->post("email") . "'  ");
		}

		$data_user_id = $this->functions->_user_logged_in_details("id") ? $this->functions->_user_logged_in_details("id") : $data['guest_user']->row('id');

		$data_user_email = $this->functions->_user_logged_in_details("email") ? $this->functions->_user_logged_in_details("email") : $data['guest_user']->row('email');

		//from here
		
		$data['conferenceregistration']			= $this->queries->fetch_records(
			'short_conference_registration_master',
			" AND userid = '" . $data_user_id . "' 
													AND conferenceid = '" . $conference->row("id") . "' "
		);
		
	
		$if_Exists =  !($data['conferenceregistration']->num_rows() > 0);
		

		if ( $if_Exists){

			/*=========================== MASTER DATA INSERT =========================== */

			$TMP_session_master		= array(
				"participanttypeid"			=> SessionHelper::_get_session("participanttypeid", "conferenceregistration"),
				"regionid"					=> SessionHelper::_get_session("regionid", "conferenceregistration"),
				"conferenceid"				=> $conference->row("id"),
				"userid"					=> $data_user_id,
				"date_added"				=> date("Y-m-d H:i:s")
			);

			$this->queries->SaveDeleteTables($TMP_session_master, 's', "tb_short_conference_registration_master", 'id');

			/*=========================== SCREEN ONE DATA INSERT =========================== */

			$data['conferenceregistration']			= $this->queries->fetch_records(
				'short_conference_registration_master',
				" AND userid = '" . $data_user_id . "' 
														AND conferenceid = '" . $conference->row("id") . "' "
			);

			$TMP_session						= array(
				"conferenceregistrationid"	=> $data['conferenceregistration']->row('id'),
				"prefix"					=> $this->input->post("prefix"),
				"education"					=> $this->input->post("education"),
				"phone"						=> $this->input->post("phone"),
				"name"						=> $this->input->post("name"),
				"email"						=> $this->input->post("email"),
				"country_of_residence"		=> $this->input->post("country_of_residence"),
				"no_of_family_members"		=> $this->input->post("no_of_family_members"),
				// "travelling_with"			=> $this->input->post("travelling_with"),
				"date_added"				=> date("Y-m-d H:i:s")
			);

		
			$this->queries->SaveDeleteTables($TMP_session, 's', "tb_short_conference_registration_screen_one", 'id');

			$screeon_id = $this->db->insert_id();


			/*=========================== SCREEN ONE FAMILY DETAILS DATA INSERT =========================== */

			$data['conferenceregistration_screenone']		= $this->queries->fetch_records(
				'short_conference_registration_screen_one',
				" AND conferenceregistrationid = '" . $data['conferenceregistration']->row("id") . "' "
			);
			
																									
			if ($this->input->post("family_name")) {
				if (count($_POST["family_name"]) > 0) {


					for ($i = 1; $i <= count($_POST["family_name"]); $i++) {

						$child_details			= array(
							"parentid"					=> $screeon_id,
							"family_name"				=> $_POST['family_name'][$i],
							"family_email"				=> $_POST['family_email'][$i],
							"family_relationship"		=> $_POST['family_relationship'][$i],
							"family_age"				=> $_POST['family_age'][$i]
						);


						$this->queries->SaveDeleteTables($child_details, 's', "tb_short_conference_registration_screen_one_family_details", 'id');

					}
				}
			}

			$data['conferenceregistration_screenone_family_details']	= $this->queries->fetch_records('short_conference_registration_screen_one_family_details', 
																									" AND parentid = '". $data['conferenceregistration_screenone']->row("id") ."' ");
			/*=========================== SCREEN TWO DATA INSERT =========================== */

			$todaydate					    = strtotime(date("Y-m-d"));
			$registration_beforedate_t		= strtotime($registration_beforedate);

			if ($todaydate <= $registration_beforedate_t) {
				$eb_regular     = 'earlybird_price';
			} else if ($todaydate > $registration_beforedate_t) {
				$eb_regular     = 'regular_price';
			}

			// $paymenttypeid = SessionHelper::_get_session("participanttypeid", "conferenceregistration");
			$paymenttypeid = 1;
			$TMP_session_Two					= array(
				"conferenceregistrationid"	=> $data['conferenceregistration']->row("id"),
				"screen_one_id"				=> '',
				"earlybird_regular"			=> $eb_regular,
				"paymenttypeid"				=> $paymenttypeid,
				"be_a_member"				=> '',
				"be_a_member_fee"			=> '',
				"coupon_code"				=> '',
				"speaker_coupon_code"		=> '',
				"date_added"				=> date("Y-m-d H:i:s"),
				"price_package_fee"			=> $this->input->post("txt_package_fee"),
				"price_payable_now"			=> $this->input->post("txt_payable_now"),
				"price_cash_onsite"			=> '',
				"price_total_payable"		=>  $this->input->post("txt_total_payable"),
				"price_less_absfee"			=> intval($this->input->post("txt_abs_paid")),
				"email_text"				=> $this->input->post("email_text")
			);
			
			$this->queries->SaveDeleteTables($TMP_session_Two, 's', "tb_short_conference_registration_screen_two", 'id');
			$TMP_session_Two['id']							= $this->db->insert_id();

			/*=========================== SCREEN TWO FAMILY DETAILS DATA INSERT =========================== */

			$this->queries->SaveDeleteTables(array("parentid" => $TMP_session_Two["id"]), 'd', " tb_short_conference_registration_screen_two_details", 'parentid');

			if (count($_POST["registration_tickets_child"]) > 0) {

				foreach ($_POST["registration_tickets_child"] as $key => $value) {
					$multiply_nop		= $_POST["multiply_by"][$key];
					$addon				= $_POST["is_addon"][$key];

					if ($multiply_nop > 0) {

						$child_details			= array(
							"parentid"					=> $TMP_session_Two["id"],
							"price_details_id"			=> $key,
							"price_details_value"		=> $value,
							"multply_by_no_of_people"	=> $multiply_nop,
							"addon"						=> $addon
						);

						$this->queries->SaveDeleteTables($child_details, 's', "tb_short_conference_registration_screen_two_details", 'id');
					}
				}
			}

			/*=========================== SCREEN THREE DATA INSERT =========================== */

			$data['conferenceregistration_screentwo']		= $this->queries->fetch_records('short_conference_registration_screen_two', 
																						" AND conferenceregistrationid = '". $data['conferenceregistration']->row("id") ."' ");

			$TMP_session_three						= array("conferenceregistrationid"		=> $data['conferenceregistration']->row("id"),
													"screen_one_id"							=> $data['conferenceregistration_screenone']->row("id"),
													"screen_two_id"							=> $data['conferenceregistration_screentwo']->row("id"),
													"gender"								=> $this->input->post("gender"),
													
													"full_name"								=> $this->input->post("name"),
													"email"									=> $this->input->post("email"),
													"phone"									=> $this->input->post("phone"),
													"mailing_address"						=> $this->input->post("mailing_address"),
													
													"speciality_interest"					=> $this->input->post("speciality_interest"),
													"age_level_of_school"					=> '',
													
													"date_added"							=> date("Y-m-d H:i:s"),
													"parentid"								=> 0,
													"screen_one_detail_id"					=> 0 ); //status =1  (in review)
			
			$this->queries->SaveDeleteTables($TMP_session_three, 's', "tb_short_conference_registration_screen_three", 'id'); 

			$__screen_three_id = $this->db->insert_id();

			/*=========================== SCREEN THREE DATA INSERT WITH FAMILY DETAILS OF ONE =========================== */
			
			if(!empty($data['conferenceregistration_screenone_family_details']->result_array())){
				foreach ($data['conferenceregistration_screenone_family_details']->result_array() as $csofd)
				{
					$_validate_if_screen_three_family_exists			= $this->queries->fetch_records('short_conference_registration_screen_three', 
																										" AND parentid  = '". $__screen_three_id ."' 
																										AND screen_one_detail_id = '". $csofd["id"] ."' ");
																										
					if ( $_validate_if_screen_three_family_exists->num_rows() <= 0 )
					{
						$TMP_session_three['parentid']							= $__screen_three_id;
						$TMP_session_three['screen_one_detail_id']				= $csofd["id"];
						$TMP_session_three['full_name']							= $csofd['family_name'];
						$TMP_session_three['email']								= $csofd['family_email'];
						$TMP_session_three['phone']								= "";
						$TMP_session_three['name']								= $csofd['family_name'];
						
						$this->queries->SaveDeleteTables($TMP_session_three, 's', "tb_short_conference_registration_screen_three", 'id'); 
					}																					
				}
			}

			
	
			if (!$this->functions->_user_logged_in_details("id")) {
				$guest_user = [
					'userid' => $data_user_id,
					'status' => 'guest',
				];
				$this->queries->SaveDeleteTables($guest_user, 's', "tb_guest_users", 'id');
			}
			
			$sessions = array(
				'userid' => $data_user_id,
				'email_address' => $data_user_email,
			);

			SessionHelper::_set_session($sessions, "conferenceregistrationguestuser");

		}else{
			
			$this->form_validation->set_rules('already_registered_conference', 'Conference', 'trim|callback_alreadyRegistered');
			if(($this->form_validation->run() == FALSE) ){
				$data['_messageBundle2']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			}
			$data['_pageview']						= "frontend/shortconference/form.php";
			$this->load->view(FRONTEND_TEMPLATE_FULL_CONF_VIEW, $data);
			$insertedID = null;
			return $insertedID;
			
		}
		$insertedID = $this->functions->_user_logged_in_details("id") ? $this->functions->_user_logged_in_details("id") : $insertedID;
		return $insertedID;
	
	}

	public function alreadyRegistered(){
		$this->form_validation->set_message('alreadyRegistered', 'User is already registered for this conference.' );
		return FALSE;
	}

	public function success(  $conference_slug = ''  )
	{
		// var_dump(SessionHelper::_get_session("userid", "conferenceregistrationguestuser"));die;
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
		// var_dump($is_post_get_data['item_number']);die;
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


			$card_number = str_replace(' ','',$this->input->post("card_number"));
			$card_information=array(
				'type'=> $this->ccdetector->detect($card_number),
				'name'=>$this->input->post("card_name"),
				'number'=> $card_number,
				'expiry'=>$this->input->post("card_expiry"),
				'cvv'=>$this->input->post("card_cvv")
			);
			
			// $this->load->library( '../controllers/home' );
			// if($membership_type != 0){
			// 	$abc = $this->home->membership_payment($user_id, $membership_type, $saveData);
			// }

			$saveData										= array("userid"								=> $user_id,
																				"conferenceid"							=> $conference -> row("id"),
																				"conference_registration_id"			=> $data['conferenceregistration']->row("id"),
																				"payer_email"							=>  $is_post_get_data['payer_email'],
																				"payment_gross"							=> $is_post_get_data['mc_gross'],
																				"ipn_track_id"							=> $is_post_get_data['payer_id'],
																				"payer_id"								=> $is_post_get_data['payer_id'],
																				"payment_status"						=> $is_post_get_data['payment_status'],
																				"payment_mode"							=> 'paypal',
																				"paypal_post"							=> isset($is_post_get_data ) ? serialize($is_post_get_data) : '',
																				"date_added"							=> date("Y-m-d H:i:s"),
																				"card_name"								=> $card_information['name'],
																				'card_type'								=> $card_information['type'],
																				'card_expiry'							=> $card_information['expiry'],
																		);
		
			$saveData['request_data'] 						= isset($card_information ) ? json_encode($card_information) : '';
			
			$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_payments", 'id');

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
}
