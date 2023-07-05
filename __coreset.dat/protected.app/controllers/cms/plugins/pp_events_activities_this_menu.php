<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Events_Activities_This_Menu extends C_frontend {

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
	
	public function __construct(&$data, $ci)
	{
		parent::__construct();	
		// $ci->load->library('custom_log');	
	}
	
	
	
	
	static public function show( $data = array(), $ci, $mode = FALSE, $is_simple = false )
	{
		//$data['slug']					= FALSE;
		

		switch ( $mode )
		{
			case $mode == SLUG_EVENTS_ACTIVITIES:
				$mode									= FALSE;
				break;
				
			default:
				$mode									= " AND mode = '". $mode ."' ";	
				break;				
				
		}
		
		$order = 'ORDER BY start_date DESC, sort DESC' ;
		// $order = $data['content_detail']->row("id") == '47' ? 'ORDER BY start_date DESC, sort ASC' : 'ORDER BY start_date ASC, sort ASC';
		$siteIdQuery								= getSiteId();
		
		$data['sitesectionwidgets']					= $ci->queries->fetch_records("sitesectionswidgets", 
																				  " AND id IN (SELECT parentid  FROM tb_sitesectionswidgets_details WHERE sitesections_id = '". $data['menu_detail']->row("id") ."')
																				  	$mode
																					$siteIdQuery
																				  	$order
																				  ");
		
		
		if ( $is_simple ){
			return $ci->load->view( "frontend/cms/page_plugins/pp_events_activities_this_menu_simple", $data, TRUE );
		}
		return $ci->load->view( "frontend/cms/page_plugins/pp_events_activities_this_menu", $data, TRUE );
	}
	
	
	static public function menus_list( $data = array(), $ci, $is_simple = false )
	{
		
		$ci->queries->fetch_records("sitesectionswidgets_details", 
									" AND parentid IN (SELECT id FROM `tb_sitesectionswidgets` WHERE  mode = '". SLUG_EVENTS ."'  ORDER BY sort ASC)",
									" sitesections_id ");
		
		
		$data['eventslist_menus_all']				= $ci->queries->fetch_records(	"cmsmenu", 
																				  	" AND id IN ( ". $ci->db->last_query() ." ) ");
		
		
		$data['is_list']							= TRUE;
		
		if ( $is_simple ){
			return $ci->load->view( "frontend/cms/page_plugins/pp_events_activities_this_menu_simple", $data, TRUE );
		}
		return $ci->load->view( "frontend/cms/page_plugins/pp_events_activities_this_menu", $data, TRUE );
	}

	static public function show_form( $data = array(), $ci, $mode = FALSE, $is_simple = false )
	{
		if($ci->uri->segments[5]){
			switch ($ci->uri->segments[5]) {
				case 'paymentsuccess':
					PP_Events_Activities_This_Menu::payment_success($data, $ci, $data['sitesectionswidgets']->row('email_text'));
					break;
				case 'paymentnotify':
					PP_Events_Activities_This_Menu::payment_success($data, $ci, $data['sitesectionswidgets']->row('email_text'));
					break;
				case 'paymentcancel':
					PP_Events_Activities_This_Menu::payment_cancel($data, $ci, $data['sitesectionswidgets']->row('email_text'));
					break;
			}
		}

		switch ( $mode )
		{
			case $mode == SLUG_EVENTS_ACTIVITIES:
				$mode									= FALSE;
				break;
				
			default:
				$mode									= " AND mode = '". $mode ."' ";	
				break;				
				
		}
		
		$data['is_package']					= $data['sitesectionswidgets']->result()[0]->is_package;
		
		if($_POST['btn_event_form']){
			$ci->form_validation->set_rules('donation_projects', lang_line('text_donationprojects'), 'trim|required');
			if($data['is_package']){
				$ci->form_validation->set_rules('package_id', lang_line('packages'), 'trim|required');
			}
			$ci->form_validation->set_rules('donate_name', lang_line('text_name'), 'required');
			$ci->form_validation->set_rules('donate_email', lang_line('text_email'), 'trim|required|valid_email');
			$ci->form_validation->set_rules('donate_phone', lang_line('text_phonenumber'), 'trim|required');
			
			if($data['is_package']){
				$ci->form_validation->set_rules('add_amount', lang_line('text_add_donation'), 'is_natural');		
			}else{
				$ci->form_validation->set_rules('add_amount', "Amount", 'is_natural|required');	
			}
			
			// $ci->form_validation->set_rules('mailing_addr', lang_line('label_arbaeen_form_address'), 'required');
			$ci->form_validation->set_rules('donation_mode', lang_line('text_donatemode'), 'trim|required');
			$ci->form_validation->set_rules('home_country', lang_line('text_country'), 'trim|required');
			// $ci->form_validation->set_rules('custom_grecap', lang_line('text_captcha'), 'trim|required|callback_validate_recaptcha');

			$card_information=[];
			if($ci->input->post('paymenttype')=="card"){	
				$ci->form_validation->set_rules('paymenttype', lang_line('text_paymenttype'), 'trim|required');
				$ci->form_validation->set_rules('card_name', lang_line('label_card_holder'), 'trim|required');
				$ci->form_validation->set_rules('card_number', lang_line('label_card_no'), 'trim|required');
				$ci->form_validation->set_rules('card_expiry', lang_line('label_card_expiry'), 'trim|required');
				$ci->form_validation->set_rules('card_cvv', lang_line('label_card_cvv'), 'trim|required');

				$ci->load->library('payeezy');
				$card_number = str_replace(' ','',$ci->input->post("card_number"));
				$card_information=array(
					'type'=> $ci->ccdetector->detect($card_number),
					'name'=>$ci->input->post("card_name"),
					'number'=> $card_number,
					'expiry'=>$ci->input->post("card_expiry"),
					'cvv'=>$ci->input->post("card_cvv")
				);
			}
			
			if ($ci->form_validation->run() == FALSE)
			{
				$ci->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
				//var_dump(validation_errors());die;
			}else{
				
				
				
				//$donate_amount = $ci->input->post("donate_amount");
				$package_id = explode("|", $ci->input->post("package_id"));
				$pkg_amount = $package_id[1];
				$package_id = $package_id[0];
				$total_amount = $ci->input->post("add_amount") + $pkg_amount;
				
				
				
				if ($ci->input->post("paymenttype")=="paypal") {
					
					$data['DONATEFORM']['_process_to_paypal']								= true;
					
				} elseif ($ci->input->post("paymenttype")=="card") {
					//Pay via Payeezy
					$rand_uuid  = $ci->functions->gen_uuid();
					$table_name = 'tb_event_registrations';
					$pay = new Payeezy();
					$recurring = $ci->input->post('donation_mode') == 'recurring' ? true : false;
					//$pay = $pay->pay($card_information, $_POST['donate_amount'],$recurring);
					//$pay = $pay->pay($card_information, $_POST['donate_amount'], $_POST['donate_email'], $recurring);
					
					$pay = $pay->pay($card_information, $total_amount, $_POST['donate_email'], $recurring, $rand_uuid, $table_name);

					if (isset($pay['error'])) {
						/* $logging = new Custom_log;
						$logging->write_log('error',  __FILE__.' '.$pay['error']. " line " .__LINE__.'  '.print_r($pay['request'],true));	 */
		     		}	

					if (! is_array($pay)) {
						$data['card_error'] = "Something Went Wrong! Please Try Again.";
					}
				}
				
				$checkIfaCampg = DropdownHelper::donation_projects_dropdown(false, $ci->input->post("donation_projects"), true);

				//This US country key id for now its being hardcoded
				// $international_id 		= 2;

				//If Canada website then Canada key id else, internation key id.
				// $international_id 		= (is_countryCheck()) ? 3 : 2;
				$international_id 		= is_countryCheck(FALSE,TRUE);
				
				//$data['donate_amount'] = $donate_amount + $pkg_amount;
				$data['donate_amount'] = $total_amount;
				$data['from_first_name'] = $ci->input->post("donate_name");

				$insertData	= array(
					"donation_projects_id"	=> $ci->input->post("donation_projects"),
					"first_name"			=> $ci->input->post("donate_name"),
					"email"				 	=> $ci->input->post("donate_email"),
					"donation_mode"			=> $ci->input->post("donation_mode"),
					"donation_freq"			=> 'M-1',
					"donate_amount"			=> $total_amount,
					"emp_name"				=> $ci->input->post("donation_empnames"),
					"emp_email"				=> $ci->input->post("donate_empemail"),
					"home_country"			=> $ci->input->post("home_country"),
					"user_id"				=> $ci->functions->_user_logged_in_details("id"),
					"date_added"			=> date("Y-m-d H:i:s"),
					"type"					=> "imiportal",
					"belongs_country"		=> $international_id
				);
				if (!is_null($checkIfaCampg) && isset($_POST["hideIdentity"])) {
					$insertData['hide_identity']			= 1;
				}
				
				$ci->queries->SaveDeleteTables($insertData, 's', "tb_donation_form", 'id');
				$data['donation_id']		= $ci->db->insert_id();
				$donationId=$ci->db->insert_id();
				
				$insertData	= array(
					"package_id"			=> $package_id,
					"event_id"				=> $data['sitesectionswidgets']->row('id'),
					"donation_form_id"		=> $donationId,
					"donate_name"			=> $ci->input->post("donate_name"),
					"donate_email"			=> $ci->input->post("donate_email"),
					"donate_phone"			=> $ci->input->post("donate_phone"),
					"mailing_addr"			=> $ci->input->post("mailing_addr"),
					"donate_amount"			=> $ci->input->post("add_amount") ? $ci->input->post("add_amount") : 0,
					"package_amount"		=> $pkg_amount,
					"payeezy_uuid"			=> $rand_uuid
				);
				if($data['is_package']){
					$ci->queries->SaveDeleteTables($insertData, 's', "tb_event_registrations", 'id');
				}

				if ($ci->input->post("paymenttype")=="paypal") {
					// var_dump('yellow');
					$saveData		= array(
						"user_id"		=> $ci->functions->_user_logged_in_details("id"),
						"payer_email"	=> $ci->input->post("donate_email"),
						"payment_status"=> 'Pending',
						"payment_mode"	=> $ci->input->post("paymenttype"),
						"table_name"	=> 'tb_donation_form',
						"table_id_name"	=> 'id',
						"table_id_value"=> $donationId,
						"date_added"	=> date("Y-m-d H:i:s")
					);

					$add_data = $ci->queries->SaveDeleteTables($saveData, 's', "tb_donation_payments", 'id');
					var_dump($donationId);
					var_dump($ci->db->last_query());
					// var_dump($add_data->num_rows());

				}
			  
					if ($ci->input->post("paymenttype")=="card") {
						
						if (is_array($pay)) {
							//$TMP_table	= $this->db->query("SELECT * FROM tb_donation_form WHERE id = '" . $donationId . "' ");
							$TMP_table	= $ci->db->query("SELECT df.* FROM tb_donation_form df WHERE df.id = '". $donationId ."' ");
	
							$editData = array();
							if (isset($pay['success'])) {
								$editData['is_paid'] = 1;
								$editData['id'] = $donationId;
								$ci->queries->SaveDeleteTables($editData, 'e', "tb_donation_form", 'id');
							}
	
							$saveData		= array(
							"user_id"		=> $ci->functions->_user_logged_in_details("id"),
							"payer_email"	=> $ci->input->post("donate_email"),
							"payment_status"=> isset($pay['success']) ? 'Completed' : 'Failed',
							"payment_mode"	=> 'payeezy',
							"table_name"	=> 'tb_donation_form',
							"table_id_name"	=> 'id',
							"table_id_value"=> $donationId,
							"date_added"	=> date("Y-m-d H:i:s")
						);
	
							$ci->queries->SaveDeleteTables($saveData, 's', "tb_donation_payments", 'id');
							$payment_id = $ci->db->insert_id();
						
							$saveData		= array(
							"payment_id"		=> $payment_id,
							"card_name"			=> $card_information['name'],
							'card_type'			=> isset($pay['response']->CardType) ? $pay['response']->CardType : $card_information['type'],
							'card_expiry'		=> $card_information['expiry'],
							'ref_no'			=> isset($pay['response']->Retrieval_Ref_No) ? $pay['response']->Retrieval_Ref_No : '',
							'amount'			=> isset($pay['response']->DollarAmount) ? $pay['response']->DollarAmount : '',
							'currency'			=> isset($pay['response']->Currency) ? $pay['response']->Currency : '',
							'transaction_tag'	=> isset($pay['response']->Transaction_Tag) ? $pay['response']->Transaction_Tag : '',
							'ctr'				=> isset($pay['response']->CTR) ? $pay['response']->CTR : '',
							'transaction_id'	=> isset($pay['response']->Authorization_Num) ? $pay['response']->Authorization_Num : '',
							'sequence_no'		=> isset($pay['response']->SequenceNo) ? $pay['response']->SequenceNo : '',
							"date_added"		=> date("Y-m-d H:i:s"),
						);
	
							if (isset($pay['response']->CTR)) {
								unset($pay['response']->CTR);
							}
							if (isset($pay['request']['Card_Number'])) {
								unset($pay['request']['Card_Number']);
							}
							$saveData['payeezy_post'] 		= isset($pay['response']) ? json_encode($pay['response']) : '';
							$saveData['request_data'] 		= isset($pay['request']) ? json_encode($pay['request']) : '';
							if ($recurring) {
								$saveData['token'] 			= isset($pay['response']->TransarmorToken) ? $pay['response']->TransarmorToken : '';
								$saveData['trans_recur_id'] = isset($pay['response']->StoredCredentials->TransactionId) ? $pay['response']->StoredCredentials->TransactionId : '';
							}
	
	
							$ci->queries->SaveDeleteTables($saveData, 's', "tb_card_payments", 'id');
	
							if (isset($pay['error'])) {
								$data['card_error'] = $pay['error'];
							}else{

							
							#*************************** *************************** ***************************
								#*************************** 	    EMAIL PREPARATION 	 ***************************
								#*************************** *************************** ***************************

								// This below work is for Shan-e-adab event only.								
								$_event_id		= $data['sitesectionswidgets']->row('id');
								$_is_shame_adab	= FALSE;
								if($_event_id == 124){
									$_is_shame_adab	= TRUE;
								}
								if($_is_shame_adab == TRUE){
									$_POST['event_email_name'] 	= $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name;
									$_POST['event_email_date'] 	= date("F j, Y");
									$_POST['event_email_phone'] 	= $ci->input->post("donate_phone");
									$_POST['event_email_amount'] = $pkg_amount;
									
									$TMP_table_package		= $ci->db->query("SELECT dp.* FROM tb_event_packages dp WHERE dp.id = '". $package_id ."' ")->row_array();
									
									$_POST['event_email_seats']		= $TMP_table_package['available_seats'];
									$_POST['event_email_package'] 	= $TMP_table_package['package_title'];
								}


								#to_user
								$_POST["TEXT_p"]				= 'Dear ' . $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name . ',
														<br /> <br />Thank you for donating <br><br>
														Donate Date: ' . date("d-m-Y");
														
								$_POST["donation_details"]		= $TMP_table->row_array();

								if( $_is_shame_adab == TRUE ){
									$_event_file_path	= "email/frontend/event_form_shaneadab.php";
								}
								else{
									$_event_file_path	= "email/frontend/event_form.php";
								}

								$_POST['event_email_text']		= $data['sitesectionswidgets']->row('email_text');
								$email_bcc		= array('Imifinance786@gmail.com','sakinarizviimi@gmail.com','imiwaiting@att.net','taha.fatima@genetechsolutions.com','imihq@imamiamedics.com');
		
								$email_template					= array("email_to"				=> $TMP_table->row()->email,
															"email_heading"				=> "Event Registration",
															"email_file"				=> $_event_file_path,
															"email_subject"				=> "Event Registration",
															"default_subject"			=> true,
															"email_bcc"					=> $email_bcc,
															"email_post"				=> $_POST
															);

								// $is_email_sent				= $ci->_send_email($email_template);
								#to_user
						
								#to send tax receipt
								$ci->functions->send_tax_receipt($donationId , $ci, false, 'events', $_event_id);
						
						
								#test email
								$message 					= '<strong>DONATE FORM:</strong> test _ payment ' . serialize($_POST) ;
								$email_template				= array("email_to"				=> 'ali.nayani@genetechsolutions.com',
															"email_heading"			=> 'DONATION FORM',
															"email_file"			=> "email/global/_blank_page.php",
															"email_subject"			=> '---> DONATION FORM',
															"email_post"			=> array("content"		=> $message) );
						
								// $is_email_sent				= $ci->_send_email( $email_template );
								#test email
						
						
						
								#*************************** *************************** ***************************
								#*************************** THANK YOU PAGE PREPARATION  ***************************
								#*************************** *************************** ***************************
								if($data['is_package']){
									if(site_url() == "https://medicsinternational.org/"){
										$sucess_message = "Thank you for registering. Event details will be emailed to you ahead of the event. For any questions, please feel free to contact <a href='mailto:medicsinternational@gmail.com'>medicsinternational@gmail.com</a>";
									}else{
										
										$sucess_message = "Thank you for registering. Event details will be emailed to you ahead of the event. For any questions, please feel free to contact <a href='mailto:imihq@imamiamedics.com'>imihq@imamiamedics.com</a>";
									}

									if($_is_shame_adab == TRUE){
										$sucess_message = "<img src='" . base_url('assets/frontend/images/sham-adab-event-ty-banner.png') . "' /><br>
										<br>
										Thank you for purchasing tickets to Sham-e-Adab, Meet & Greet New Jersey.  The order/ticket confirmation has been sent to the email you provided.<br>
										<br>
										If you have any questions or have not received this email confirmation, please contact IMI HQ at <a href='mailto:imihq@imamiamedics.com'>imihq@imamiamedics.com</a> or by calling Reza Jawad at 609-481-9267 or Mehvesh Bilgrami at 202-705-3700.";

									}
								}else{
									$sucess_message = "Thank your for your donation.";
								}
								$data['_messageBundle']				= $ci->_messageBundle(
									'success_big',
									/*"Thank you for your donation of $".$TMP_table->row()->donate_amount." for the ".DropdownHelper::donation_projects_dropdown(FALSE, $TMP_table->row()->donation_projects_id, false, false, $content_languages).". A copy
									of your donation submission has been emailed to you at ".$TMP_table->row()->email."
									from <a href='mailto:noreply@imamiamedics.com'>noreply@imamiamedics.com</a> and a tax receipt will be sent via email from
									<a href='IMIFinance786@gmail.com'>IMIFinance786@gmail.com</a> to you as well no later than three to four weeks
									after your donation has been processed. Please do not hesitate to contact
									us at <a href='IMIFinance786@gmail.com'>IMIFinance786@gmail.com</a> should you have any questions or concerns.<br/><br/>Imamia Medics International<br/>EIN: 22330 920 8010 612",
									"You’re what making a difference looks like"*/
									$sucess_message,
									//lang_line('success_page_text', array($TMP_table->row()->donate_amount, DropdownHelper::donation_projects_dropdown(FALSE, $TMP_table->row()->donation_projects_id, false, false, $data['content_languages']), $TMP_table->row()->email)),
									lang_line('success_page_heading')
								);

								if($_is_shame_adab == TRUE){
									$data['_messageBundle']				= $ci->_messageBundle(
																				'success_big_is_package',
																				$sucess_message,
																				""
																			);
								}
	
								$data['_pageview']						= "global/_blank_page.php";
	
								unset($_POST);
								$_POST['is_event_success']				= "yes";
								//return $ci->load->view( "frontend/cms/page_plugins/pp_event_form", $data, TRUE );
								return $ci->load->view( FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW, $data );
	
								//$data['return'] = true;
							}
						}
					}
			}
		}
		
		
		$event_id							= $data['sitesectionswidgets']->result()[0]->id;

		

		
		$data['event_packages']				= $ci->queries->fetch_records("event_packages", "AND event_id = $event_id order by id desc")->result();
		
		return $ci->load->view( "frontend/cms/page_plugins/pp_event_form", $data, TRUE );
	}
	static public function show_form_canada( $data = array(), $ci, $mode = FALSE, $is_simple = false )
	{
		if($ci->uri->segments[5]){
			switch ($ci->uri->segments[5]) {
				case 'paymentsuccess':
					PP_Events_Activities_This_Menu::payment_success($data, $ci, $data['sitesectionswidgets']->row('email_text'));
					break;
				case 'paymentnotify':
					PP_Events_Activities_This_Menu::payment_success($data, $ci, $data['sitesectionswidgets']->row('email_text'));
					break;
				case 'paymentcancel':
					PP_Events_Activities_This_Menu::payment_cancel($data, $ci, $data['sitesectionswidgets']->row('email_text'));
					break;
			}
		}

		switch ( $mode )
		{
			case $mode == SLUG_EVENTS_ACTIVITIES:
				$mode									= FALSE;
				break;
				
			default:
				$mode									= " AND mode = '". $mode ."' ";	
				break;				
				
		}
		
		$data['is_package']					= $data['sitesectionswidgets']->result()[0]->is_package;
		
		if($_POST['btn_event_form']){
			$ci->form_validation->set_rules('donation_projects', lang_line('text_donationprojects'), 'trim|required');
			if($data['is_package']){
				$ci->form_validation->set_rules('package_id', lang_line('packages'), 'trim|required');
			}
			$ci->form_validation->set_rules('donate_name', lang_line('text_name'), 'required');
			$ci->form_validation->set_rules('donate_email', lang_line('text_email'), 'trim|required|valid_email');
			$ci->form_validation->set_rules('donate_phone', lang_line('text_phonenumber'), 'trim|required');
			
			if($data['is_package']){
				$ci->form_validation->set_rules('add_amount', lang_line('text_add_donation'), 'is_natural');		
			}else{
				$ci->form_validation->set_rules('add_amount', "Amount", 'is_natural|required');	
			}
			
			// $ci->form_validation->set_rules('mailing_addr', lang_line('label_arbaeen_form_address'), 'required');
			$ci->form_validation->set_rules('donation_mode', lang_line('text_donatemode'), 'trim|required');
			$ci->form_validation->set_rules('home_country', lang_line('text_country'), 'trim|required');
			$ci->form_validation->set_rules('custom_grecap', lang_line('text_captcha'), 'trim|required|callback_validate_recaptcha');

			// $card_information=[];
			
			// if($ci->input->post('paymenttype')=="card"){	
			// 	$ci->form_validation->set_rules('paymenttype', lang_line('text_paymenttype'), 'trim|required');
			// 	$ci->form_validation->set_rules('card_name', lang_line('label_card_holder'), 'trim|required');
			// 	$ci->form_validation->set_rules('card_number', lang_line('label_card_no'), 'trim|required');
			// 	$ci->form_validation->set_rules('card_expiry', lang_line('label_card_expiry'), 'trim|required');
			// 	$ci->form_validation->set_rules('card_cvv', lang_line('label_card_cvv'), 'trim|required');

			// 	$ci->load->library('payeezy');
			// 	$card_number = str_replace(' ','',$ci->input->post("card_number"));
			// 	$card_information=array(
			// 		'type'=> $ci->ccdetector->detect($card_number),
			// 		'name'=>$ci->input->post("card_name"),
			// 		'number'=> $card_number,
			// 		'expiry'=>$ci->input->post("card_expiry"),
			// 		'cvv'=>$ci->input->post("card_cvv")
			// 	);
			// }
		
			if ($ci->form_validation->run() == FALSE)
			{
				$ci->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
				//var_dump(validation_errors());die;
			}else{

				

				//$donate_amount = $ci->input->post("donate_amount");
				$package_id = explode("|", $ci->input->post("package_id"));
				$pkg_amount = $package_id[1];
				$package_id = $package_id[0];
				$total_amount = $ci->input->post("add_amount") + $pkg_amount;
				
				

				if ($ci->input->post("paymenttype")=="paypal") {
					$data['DONATEFORM']['_process_to_paypal']								= true;
				}
				// } elseif ($ci->input->post("paymenttype")=="card") {
				// 	//Pay via Payeezy
				// 	$pay = new Payeezy();
				// 	$recurring = $ci->input->post('donation_mode') == 'recurring' ? true : false;
				// 	//$pay = $pay->pay($card_information, $_POST['donate_amount'],$recurring);
				// 	//$pay = $pay->pay($card_information, $_POST['donate_amount'], $_POST['donate_email'], $recurring);
				// 	$pay = $pay->pay($card_information, $total_amount, $_POST['donate_email'], $recurring);
					
				// 	if (! is_array($pay)) {
				// 		$data['card_error'] = "Something Went Wrong! Please Try Again.";
				// 	}
				// }
				
				$checkIfaCampg = DropdownHelper::donation_projects_dropdown(false, $ci->input->post("donation_projects"), true);

				//This US country key id for now its being hardcoded
				// $international_id 		= 2;

				//If Canada website then Canada key id else, internation key id.
				// $international_id 		= (is_countryCheck()) ? 3 : 2;
				$international_id 		= is_countryCheck(FALSE,TRUE);

				//$data['donate_amount'] = $donate_amount + $pkg_amount;
				$data['donate_amount'] = $total_amount;
				$data['from_first_name'] = $ci->input->post("donate_name");

				$insertData	= array(
					"donation_projects_id"	=> $ci->input->post("donation_projects"),
					"first_name"			=> $ci->input->post("donate_name"),
					"email"				 	=> $ci->input->post("donate_email"),
					"donation_mode"			=> $ci->input->post("donation_mode"),
					"donation_freq"			=> 'M-1',
					"donate_amount"			=> $total_amount,
					"emp_name"				=> $ci->input->post("donation_empnames"),
					"emp_email"				=> $ci->input->post("donate_empemail"),
					"home_country"			=> $ci->input->post("home_country"),
					"user_id"				=> $ci->functions->_user_logged_in_details("id"),
					"date_added"			=> date("Y-m-d H:i:s"),
					"type"					=> "imiportal",
					"belongs_country"		=> $international_id
				);
				if (!is_null($checkIfaCampg) && isset($_POST["hideIdentity"])) {
					$insertData['hide_identity']			= 1;
				}
				
				$ci->queries->SaveDeleteTables($insertData, 's', "tb_donation_form", 'id');
				$data['donation_id']		= $ci->db->insert_id();
				$donationId=$ci->db->insert_id();
				
				$insertData	= array(
					"package_id"			=> $package_id,
					"event_id"				=> $data['sitesectionswidgets']->row('id'),
					"donation_form_id"		=> $donationId,
					"donate_name"			=> $ci->input->post("donate_name"),
					"donate_email"			=> $ci->input->post("donate_email"),
					"donate_phone"			=> $ci->input->post("donate_phone"),
					"mailing_addr"			=> $ci->input->post("mailing_addr"),
					"donate_amount"			=> $ci->input->post("add_amount") ? $ci->input->post("add_amount") : 0,
					"package_amount"		=> $pkg_amount,
				);
				if($data['is_package']){
					$ci->queries->SaveDeleteTables($insertData, 's', "tb_event_registrations", 'id');
				}
			  
					// if ($ci->input->post("paymenttype")=="card") {
					// 	if (is_array($pay)) {
					// 		//$TMP_table	= $this->db->query("SELECT * FROM tb_donation_form WHERE id = '" . $donationId . "' ");
					// 		$TMP_table	= $ci->db->query("SELECT df.* FROM tb_donation_form df WHERE df.id = '". $donationId ."' ");
	
					// 		$editData = array();
					// 		if (isset($pay['success'])) {
					// 			$editData['is_paid'] = 1;
					// 			$editData['id'] = $donationId;
					// 			$ci->queries->SaveDeleteTables($editData, 'e', "tb_donation_form", 'id');
					// 		}
	
					// 		$saveData		= array(
					// 		"user_id"		=> $ci->functions->_user_logged_in_details("id"),
					// 		"payer_email"	=> $ci->input->post("donate_email"),
					// 		"payment_status"=> isset($pay['success']) ? 'Completed' : 'Failed',
					// 		"payment_mode"	=> 'payeezy',
					// 		"table_name"	=> 'tb_donation_form',
					// 		"table_id_name"	=> 'id',
					// 		"table_id_value"=> $donationId,
					// 		"date_added"	=> date("Y-m-d H:i:s")
					// 	);
	
					// 		$ci->queries->SaveDeleteTables($saveData, 's', "tb_donation_payments", 'id');
					// 		$payment_id = $ci->db->insert_id();
						
					// 		$saveData		= array(
					// 		"payment_id"		=> $payment_id,
					// 		"card_name"			=> $card_information['name'],
					// 		'card_type'			=> isset($pay['response']->CardType) ? $pay['response']->CardType : $card_information['type'],
					// 		'card_expiry'		=> $card_information['expiry'],
					// 		'ref_no'			=> isset($pay['response']->Retrieval_Ref_No) ? $pay['response']->Retrieval_Ref_No : '',
					// 		'amount'			=> isset($pay['response']->DollarAmount) ? $pay['response']->DollarAmount : '',
					// 		'currency'			=> isset($pay['response']->Currency) ? $pay['response']->Currency : '',
					// 		'transaction_tag'	=> isset($pay['response']->Transaction_Tag) ? $pay['response']->Transaction_Tag : '',
					// 		'ctr'				=> isset($pay['response']->CTR) ? $pay['response']->CTR : '',
					// 		'transaction_id'	=> isset($pay['response']->Authorization_Num) ? $pay['response']->Authorization_Num : '',
					// 		'sequence_no'		=> isset($pay['response']->SequenceNo) ? $pay['response']->SequenceNo : '',
					// 		"date_added"		=> date("Y-m-d H:i:s"),
					// 	);
	
					// 		if (isset($pay['response']->CTR)) {
					// 			unset($pay['response']->CTR);
					// 		}
					// 		if (isset($pay['request']['Card_Number'])) {
					// 			unset($pay['request']['Card_Number']);
					// 		}
					// 		$saveData['payeezy_post'] 		= isset($pay['response']) ? json_encode($pay['response']) : '';
					// 		$saveData['request_data'] 		= isset($pay['request']) ? json_encode($pay['request']) : '';
					// 		if ($recurring) {
					// 			$saveData['token'] 			= isset($pay['response']->TransarmorToken) ? $pay['response']->TransarmorToken : '';
					// 			$saveData['trans_recur_id'] = isset($pay['response']->StoredCredentials->TransactionId) ? $pay['response']->StoredCredentials->TransactionId : '';
					// 		}
	
	
					// 		$ci->queries->SaveDeleteTables($saveData, 's', "tb_card_payments", 'id');
	
					// 		if (isset($pay['error'])) {
					// 			$data['card_error'] = $pay['error'];
					// 		}else{

							
					// 		#*************************** *************************** ***************************
					// 			#*************************** 	    EMAIL PREPARATION 	 ***************************
					// 			#*************************** *************************** ***************************

					// 			// This below work is for Shan-e-adab event only.								
					// 			$_event_id		= $data['sitesectionswidgets']->row('id');
					// 			$_is_shame_adab	= FALSE;
					// 			if($_event_id == 124){
					// 				$_is_shame_adab	= TRUE;
					// 			}
					// 			if($_is_shame_adab == TRUE){
					// 				$_POST['event_email_name'] 	= $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name;
					// 				$_POST['event_email_date'] 	= date("F j, Y");
					// 				$_POST['event_email_phone'] 	= $ci->input->post("donate_phone");
					// 				$_POST['event_email_amount'] = $pkg_amount;
									
					// 				$TMP_table_package		= $ci->db->query("SELECT dp.* FROM tb_event_packages dp WHERE dp.id = '". $package_id ."' ")->row_array();
									
					// 				$_POST['event_email_seats']		= $TMP_table_package['available_seats'];
					// 				$_POST['event_email_package'] 	= $TMP_table_package['package_title'];
					// 			}


					// 			#to_user
					// 			$_POST["TEXT_p"]				= 'Dear ' . $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name . ',
					// 									<br /> <br />Thank you for donating <br><br>
					// 									Donate Date: ' . date("d-m-Y");
														
					// 			$_POST["donation_details"]		= $TMP_table->row_array();

					// 			if( $_is_shame_adab == TRUE ){
					// 				$_event_file_path	= "email/frontend/event_form_shaneadab.php";
					// 			}
					// 			else{
					// 				$_event_file_path	= "email/frontend/event_form.php";
					// 			}

					// 			$_POST['event_email_text']		= $data['sitesectionswidgets']->row('email_text');
								
					// 			$email_template					= array("email_to"				=> $TMP_table->row()->email,
					// 										"email_heading"				=> "Donation Form",
					// 										"email_file"				=> $_event_file_path,
					// 										"email_subject"				=> "Donation Form",
					// 										"default_subject"			=> true,
					// 										"email_bcc"					=> getAdminEmails(),
					// 										"email_post"				=> $_POST
					// 										);
						
					// 			// $is_email_sent				= $ci->_send_email($email_template);
					// 			#to_user
						
					// 			#to send tax receipt
					// 			$ci->functions->send_tax_receipt($donationId , $ci);
						
						
					// 			#test email
					// 			$message 					= '<strong>DONATE FORM:</strong> test _ payment ' . serialize($_POST) ;
					// 			$email_template				= array("email_to"				=> 'ali.nayani@genetechsolutions.com',
					// 										"email_heading"			=> 'DONATION FORM',
					// 										"email_file"			=> "email/global/_blank_page.php",
					// 										"email_subject"			=> '---> DONATION FORM',
					// 										"email_post"			=> array("content"		=> $message) );
						
					// 			//$is_email_sent				= $ci->_send_email( $email_template );
					// 			#test email
						
						
						
					// 			#*************************** *************************** ***************************
					// 			#*************************** THANK YOU PAGE PREPARATION  ***************************
					// 			#*************************** *************************** ***************************
					// 			if($data['is_package']){
					// 				$sucess_message = "Thank you for registering. Event details will be emailed to you ahead of the event. For any questions, please feel free to contact <a href='mailto:imihq@imamiamedics.com'>imihq@imamiamedics.com</a>";

					// 				if($_is_shame_adab == TRUE){
					// 					$sucess_message = "<img src='" . base_url('assets/frontend/images/sham-adab-event-ty-banner.png') . "' /><br>
					// 					<br>
					// 					Thank you for purchasing tickets to Sham-e-Adab, Meet & Greet New Jersey.  The order/ticket confirmation has been sent to the email you provided.<br>
					// 					<br>
					// 					If you have any questions or have not received this email confirmation, please contact IMI HQ at <a href='mailto:imihq@imamiamedics.com'>imihq@imamiamedics.com</a> or by calling Reza Jawad at 609-481-9267 or Mehvesh Bilgrami at 202-705-3700.";

					// 				}
					// 			}else{
					// 				$sucess_message = "Thank your for your donation.";
					// 			}
					// 			$data['_messageBundle']				= $ci->_messageBundle(
					// 				'success_big',
					// 				/*"Thank you for your donation of $".$TMP_table->row()->donate_amount." for the ".DropdownHelper::donation_projects_dropdown(FALSE, $TMP_table->row()->donation_projects_id, false, false, $content_languages).". A copy
					// 				of your donation submission has been emailed to you at ".$TMP_table->row()->email."
					// 				from <a href='mailto:noreply@imamiamedics.com'>noreply@imamiamedics.com</a> and a tax receipt will be sent via email from
					// 				<a href='IMIFinance786@gmail.com'>IMIFinance786@gmail.com</a> to you as well no later than three to four weeks
					// 				after your donation has been processed. Please do not hesitate to contact
					// 				us at <a href='IMIFinance786@gmail.com'>IMIFinance786@gmail.com</a> should you have any questions or concerns.<br/><br/>Imamia Medics International<br/>EIN: 22330 920 8010 612",
					// 				"You’re what making a difference looks like"*/
					// 				$sucess_message,
					// 				//lang_line('success_page_text', array($TMP_table->row()->donate_amount, DropdownHelper::donation_projects_dropdown(FALSE, $TMP_table->row()->donation_projects_id, false, false, $data['content_languages']), $TMP_table->row()->email)),
					// 				lang_line('success_page_heading')
					// 			);

					// 			if($_is_shame_adab == TRUE){
					// 				$data['_messageBundle']				= $ci->_messageBundle(
					// 															'success_big_is_package',
					// 															$sucess_message,
					// 															""
					// 														);
					// 			}
	
					// 			$data['_pageview']						= "global/_blank_page.php";
	
					// 			unset($_POST);
					// 			$_POST['is_event_success']				= "yes";
					// 			//return $ci->load->view( "frontend/cms/page_plugins/pp_event_form", $data, TRUE );
					// 			return $ci->load->view( FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW, $data );
	
					// 			//$data['return'] = true;
					// 		}
					// 	}
					// }
			}
		}
		
		
		$event_id							= $data['sitesectionswidgets']->result()[0]->id;

		

		
		$data['event_packages']				= $ci->queries->fetch_records("event_packages", "AND event_id = $event_id order by id desc")->result();
		
		return $ci->load->view( "frontend/cms/page_plugins/pp_event_form_canada", $data, TRUE );
	}
	static public function payment_success(  &$data = array(), $ci , $email_text = FALSE )
	{
		$is_post_get								= FALSE;
		$is_post_get_data							= array();
		$process_payment							= FALSE;
		$payment_mode								= "paypal";	
		
		if ( count($ci->input->post()) > 1 )
		{
			$is_post_get								= TRUE;
			$is_post_get_data 							= $ci->input->post();
			$custom										= $is_post_get_data["custom"];
			$payment_status								= $is_post_get_data["payment_status"];
			$payer_id									= $is_post_get_data["payer_id"];
		}
		
		if ( count($ci->input->get()) > 1 )
		{
			$is_post_get								= TRUE;
			$is_post_get_data 							= $ci->input->get();
			$custom										= $is_post_get_data["cm"];
			$payment_status								= $is_post_get_data["st"];
			$payer_id									= $is_post_get_data["tx"];
		}

		if ( $is_post_get  )
		{
			$TMP_explode_strings							= explode("|", $custom); //0: reference number, 1: donation_form id
			$TMP_check_if_already_paid_for_donation_id		= $ci->db->query("SELECT * FROM tb_donation_payments WHERE 
																				table_name = '". $TMP_explode_strings[0] ."' AND 
																				table_id_name = '". $TMP_explode_strings[1] ."' AND 
																				table_id_value = '". $TMP_explode_strings[2] ."' AND user_id = '". $is_post_get_data["item_number"] ."' AND payment_status = 'Completed' ");

			if ( count($TMP_explode_strings) != 3 )
			{
				$data['_messageBundle']					= $ci->_messageBundle( 	'danger_big' , 
																				"You have not submiited Donation Form correctly. 
																				The payment cannot be process further. In-sufficient details.", 
																				"Process Failed");
				
				$data['_pageview']						= "global/_blank_page.php";		
			}
			else if ( $TMP_check_if_already_paid_for_donation_id -> num_rows() > 0 )
			{
				$data['_messageBundle']					= $ci->_messageBundle( 	'success_big' , 
								"Thank you for your gift. Tax receipts will be mailed no later than three to four weeks after your donation has been processed.<br/><br/>Imamia Medics International<br/>EIN: 22330 920 8010 612", 
								"You're what making a difference looks like");
			
				$data['_pageview']						= "global/_blank_page.php";	
			}
			else
			{
				$process_payment						= TRUE;
			}
			
		}
		else
		{
			$data['_messageBundle']						= $ci->_messageBundle( 	'danger_big' , 
																				"Invalid Donation Payment. <strong>Contact Administrator</strong>", 
																				"Process Failed");
			
			$data['_pageview']							= "global/_blank_page.php";		
		}
		
		
		
		
		if ( $process_payment )
		{
			$TMP_table										= $ci->db->query("SELECT df.*, dcc.comment as comments FROM tb_donation_form df LEFT JOIN `tb_dc_comments` dcc ON df.id = dcc.df_id WHERE df.id = '". $TMP_explode_strings[2] ."'");
			
			$TMP_payment_gross								= "onetime";
			$TMP_ipn_track_id								= $is_post_get_data["ipn_track_id"] ? $is_post_get_data["ipn_track_id"] : 0;
			$TMP_payment_status								= $payment_status;
			if ( $TMP_table->row()->donation_mode == "recurring" )
			{
				$TMP_payment_gross							= "amount3";
				$TMP_ipn_track_id							= rand(0, 300);
				$TMP_payment_status							= "Completed";
			}
			
			
		
			$saveData = array(
				// "user_id"								=> $is_post_get_data["item_number"],
				// "payer_email"							=> $is_post_get_data["payer_email"] ? $is_post_get_data["payer_email"] : "",
				"payment_status"						=> $TMP_payment_status,
				// "payment_mode"							=> $payment_mode,
				// "table_name"							=> $TMP_explode_strings[0],
				// "table_id_name"							=> $TMP_explode_strings[1],
				"table_id_value"						=> $TMP_explode_strings[2],
				// "date_added"							=> date("Y-m-d H:i:s"),
				'reference_number'						=> $is_post_get_data['txn_id'] ? $is_post_get_data['txn_id'] : ""
			);
				
				
			$check_data = $ci->queries->SaveDeleteTables($saveData, 'e', "tb_donation_payments", 'table_id_value');
			$payment_id = $ci->db->insert_id();

			$saveData = array(
				"payment_id"							=> $payment_id,
				"payment_gross"							=> $TMP_payment_gross,
				"ipn_track_id"							=> $TMP_ipn_track_id,
				"payer_id"								=> $payer_id,
				"paypal_post"							=> serialize( $is_post_get_data ),
			);
				
				
			$ci->queries->SaveDeleteTables($saveData, 's', "tb_paypal_payments", 'id');
			
			
			
			
			
		
			
			if ( $TMP_table -> num_rows() > 0 )
			{
				$TMP_data										= array("id"									=> $TMP_explode_strings[2],
																		"is_paid "								=> 1); 
					
				
				
				$ci->queries->SaveDeleteTables($TMP_data, 'e', "tb_donation_form", 'id'); 
				
				
				
				#*************************** *************************** *************************** 
				#*************************** 	    EMAIL PREPARATION 	 *************************** 
				#*************************** *************************** *************************** 
		
				// $donation_id = $TMP_explode_strings[2];
				// $event = $ci->quries->fetchrecord();

				#to_user
				$_POST["TEXT_p"]				= 'Dear ' . $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name . ',
												   <br /> <br />Thank you for donating <br><br>
												   Donate Date: ' . date("d-m-Y", strtotime($saveData['date_added']) );
												   
				$_POST["donation_details"]		= $TMP_table->row_array();
				$_POST['event_email_text']		= $email_text;					
				$_event_file_path				= "email/frontend/event_form.php";
				
				// This below work is for Shan-e-adab event only.
				$TMP_table_event_reg		= $ci->db->query("SELECT dr.* FROM tb_event_registrations dr WHERE dr.event_id = '124' AND dr.donation_form_id = '". $_POST["donation_details"]["id"] ."' ");
				$_is_shame_adab				= FALSE;
					if( $TMP_table_event_reg->num_rows() > 0 ){

						$_data_event_reg	= $TMP_table_event_reg->row_array();
						
						$_POST['event_email_name'] 		= $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name;
						$_POST['event_email_date'] 		= date("F j, Y");
						$_POST['event_email_phone'] 	= $_data_event_reg["donate_phone"];
						$_POST['event_email_amount'] 	= $_data_event_reg["package_amount"];
						$_package_id					= !empty($_data_event_reg["package_id"]) ?$_data_event_reg["package_id"]:"";
						
						if( !empty($_package_id) ) {
							$TMP_table_package		= $ci->db->query("SELECT dp.* FROM tb_event_packages dp WHERE dp.id = '". $_package_id ."' ")->row_array();
						
							$_POST['event_email_seats']		= $TMP_table_package['available_seats'];
							$_POST['event_email_package'] 	= $TMP_table_package['package_title'];
						}

						$_event_file_path					= "email/frontend/event_form_shaneadab.php";
						$_is_shame_adab						= TRUE;
					}
				
				$email_template					= array(
														"email_to"										=> $TMP_table->row()->email,
														"email_heading"									=> "Donation Form",
														"email_file"									=> $_event_file_path,
														"email_subject"									=> "Donation Form",
														"default_subject"								=> TRUE,
														"email_bcc"										=> getAdminEmails(),
														"email_post"									=> $_POST
														);

				// $is_email_sent				= $ci->_send_email( $email_template );
				#to_user
				
				#to send tax receipt
				$_event_id		= 0;
				$TMP_table_event_reg		= $ci->db->query("SELECT dr.* FROM tb_event_registrations dr WHERE dr.event_id = '163' AND dr.donation_form_id = '". $_POST["donation_details"]["id"] ."' ");
				if( $TMP_table_event_reg->num_rows() > 0 ){
					$_event_id		= 163;
				}
				$ci->functions->send_tax_receipt($TMP_explode_strings[2] , $ci, false, 'events', $_event_id);
				
				
				
				#test email
				$message 					= '<strong>DONATE FORM:</strong> test _ payment ' . serialize( $_POST ) ;
				$email_template				= array("email_to"				=> 'sadiq.hussain@genetechsolutions.com',
													"email_heading"			=> 'DONATION FORM',
													"email_file"			=> "email/global/_blank_page.php",
													"email_subject"			=> '---> DONATION FORM',
													"email_post"			=> array("content"		=> $message) );
				
				// $is_email_sent				= $ci->_send_email( $email_template );
				#test email
				
				
				
				#*************************** *************************** *************************** 
				#*************************** 	    EMAIL PREPARATION 	 *************************** 
				#*************************** *************************** *************************** 
				if($data['is_package'] || $_is_shame_adab == TRUE){
					if(site_url() == "https://medicsinternational.org/"){
						$sucess_message = "Thank you for registering. Event details will be emailed to you ahead of the event. For any questions, please feel free to contact <a href='mailto:medicsinternational@gmail.com'>medicsinternational@gmail.com</a>";
					}else{
						
						$sucess_message = "Thank you for registering. Event details will be emailed to you ahead of the event. For any questions, please feel free to contact <a href='mailto:imihq@imamiamedics.com'>imihq@imamiamedics.com</a>";
					}

					if($_is_shame_adab == TRUE){
						$sucess_message = "<img src='" . base_url('assets/frontend/images/sham-adab-event-ty-banner.png') . "' /><br>
									<br>
									Thank you for purchasing tickets to Sham-e-Adab, Meet & Greet New Jersey.  The order/ticket confirmation has been sent to the email you provided.<br>
									<br>
									If you have any questions or have not received this email confirmation, please contact IMI HQ at <a href='mailto:imihq@imamiamedics.com'>imihq@imamiamedics.com</a> or by calling Reza Jawad at 609-481-9267 or Mehvesh Bilgrami at 202-705-3700.";
					}

				}else{
					$sucess_message = "Thank your for your donation.";
				}
				
				#$_POST["_pageview"]							= "global/_blank_page.php";
				$data['_messageBundle']					= $ci->_messageBundle( 	'success_big' , 
				$sucess_message,
								//"Thank you for your gift. Tax receipts will be mailed no later than three to four weeks after your donation has been processed.<br/><br/>Imamia Medics International<br/>EIN: 22330 920 8010 612", 
								"You're what making a difference looks like");
				
					if($_is_shame_adab == TRUE){
						$data['_messageBundle']				= $ci->_messageBundle(
																	'success_big_is_package',
																	$sucess_message,
																	""
																);
					}
				$data['_pageview']							= "global/_blank_page.php";	
				$_POST['is_event_success']				    = "yes";
				#redirect( site_url( uri_string() ) );
			}
				
		}
		
		$ci->load->view( FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW, $data );
	
	}

	static public function payment_cancel(  &$data = array(), $ci  )
	{
		$data['_messageBundle']					= $ci->_messageBundle( 	'danger_big' , 
																		"You have cancelled the Paypal Payment Process.", 
																		"Process Cancelled");
		
		$data['_pageview']						= "global/_blank_page.php";
		
		unset($_POST);

		$ci->load->view( FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW, $data );
	}
	
}
