<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property MY_Session session
 * @property Payment payment
 * @property Imiconf_Queries imiconf_queries
 * @property CI_DB_mysqli_driver db_imiconf
 * @property CI_DB_mysqli_driver db
 * @property CI_Loader load
 * @property CI_Config config
 */
class Donation_Campaigns extends C_frontend {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
     *    - or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
     * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


    private $userid					= "";


    public function __construct()
    {
        parent::__construct();


        // if (!$this->session->userdata('user_logged_in')) {
        //     if ($this->router->method != 'payment_notify') { // PayPal IPN notifications don't have a session with the user logged in.
        //         $this->_auth_login(false);
        //     }
        // }
		$this->load->library('payeezy');
		$this->load->library('pdf');
		$this->load->library('custom_log');
		
		$this->data													= $this->default_data();
		$this->data['_pageview']									= "frontend/donation_campaigns/list.php";
		$this->data[ 'DONATEFORM']['_process_to_paypal']								= FALSE;
		$this->data[ 'DONATEFORM' ]["_messageBundle_redirect_paypal"]					= $this->_messageBundle( 'info' , '<p>You are now redirected to Paypal</p>', "Please Wait...");
    }

	public function payment_cancel(  &$data = array()  )
	{
		$data['_messageBundle']					= $this->_messageBundle( 	'danger_big' , 
																		"You have cancelled the Paypal Payment Process.", 
																		"Process Cancelled");
		
		$data['_pageview']						= "global/_blank_page.php";
		
		unset($_POST);
	}

	public function payment_success(  &$data = array() )
	{
		$is_post_get								= FALSE;
		$is_post_get_data							= array();
		$process_payment							= FALSE;
		$payment_mode								= "paypal";	
		
		if ( count($this->input->post()) > 1 )
		{
			$is_post_get								= TRUE;
			$is_post_get_data 							= $this->input->post();
			$custom										= $is_post_get_data["custom"];
			$payment_status								= $is_post_get_data["payment_status"];
			$payer_id									= $is_post_get_data["payer_id"];
		}
		
		if ( count($this->input->get()) > 1 )
		{
			$is_post_get								= TRUE;
			$is_post_get_data 							= $this->input->get();
			$custom										= $is_post_get_data["cm"];
			$payment_status								= $is_post_get_data["st"];
			$payer_id									= $is_post_get_data["tx"];
		}

		if ( $is_post_get  )
		{
			$TMP_explode_strings							= explode("|", $custom); //0: reference number, 1: donation_form id
			$TMP_check_if_already_paid_for_donation_id		= $this->db->query("SELECT * FROM tb_donation_payments WHERE 
																				table_name = '". $TMP_explode_strings[0] ."' AND 
																				table_id_name = '". $TMP_explode_strings[1] ."' AND 
																				table_id_value = '". $TMP_explode_strings[2] ."' AND user_id = '". $is_post_get_data["item_number"] ."' ");
			
			if ( count($TMP_explode_strings) != 3 )
			{
				$data['_messageBundle']					= $this->_messageBundle( 	'danger_big' , 
																				"You have not submiited Donation Form correctly. 
																				The payment cannot be process further. In-sufficient details.", 
																				"Process Failed");
				
				$data['_pageview']						= "global/_blank_page.php";		
			}
			else if ( $TMP_check_if_already_paid_for_donation_id -> num_rows() > 0 )
			{
				$data['_messageBundle']					= $this->_messageBundle( 	'success_big' , 
								"Thank you for your gift. Tax receipts will be mailed no later than three to four weeks after your donation has been processed.<br/><br/>Imamia Medics International<br/>EIN: 22330 920 8010 612", 
								"You’re what making a difference looks like");
			
				$data['_pageview']						= "global/_blank_page.php";	
			}
			else
			{
				$process_payment						= TRUE;
			}
			
		}
		else
		{
			$data['_messageBundle']						= $this->_messageBundle( 	'danger_big' , 
																				"Invalid Donation Payment. <strong>Contact Administrator</strong>", 
																				"Process Failed");
			
			$data['_pageview']							= "global/_blank_page.php";		
		}
		
		
		
		
		
		if ( $process_payment )
		{
			$TMP_table										= $this->db->query("SELECT df.* FROM tb_donation_form df WHERE df.id = '". $TMP_explode_strings[2] ."'");
			
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
				"user_id"								=> $is_post_get_data["item_number"],
				"payer_email"							=> $is_post_get_data["payer_email"] ? $is_post_get_data["payer_email"] : "",
				"payment_status"						=> $TMP_payment_status,
				"payment_mode"							=> $payment_mode,
				"table_name"							=> $TMP_explode_strings[0],
				"table_id_name"							=> $TMP_explode_strings[1],
				"table_id_value"						=> $TMP_explode_strings[2],
				"date_added"							=> date("Y-m-d H:i:s"),
				'reference_number'						=> $is_post_get_data['txn_id'] ? $is_post_get_data['txn_id'] : ""
			);
				
				
			$this->queries->SaveDeleteTables($saveData, 's', "tb_donation_payments", 'id');
			$payment_id = $this->db->insert_id();

			$saveData = array(
				"payment_id"							=> $payment_id,
				"payment_gross"							=> $TMP_payment_gross,
				"ipn_track_id"							=> $TMP_ipn_track_id,
				"payer_id"								=> $payer_id,
				"paypal_post"							=> serialize( $is_post_get_data ),
			);
				
				
			$this->queries->SaveDeleteTables($saveData, 's', "tb_paypal_payments", 'id');
			
			
			
			
			
		
			
			if ( $TMP_table -> num_rows() > 0 )
			{
				$TMP_data										= array("id"									=> $TMP_explode_strings[2],
																		"is_paid "								=> 1); 
					
				
				
				$this->queries->SaveDeleteTables($TMP_data, 'e', "tb_donation_form", 'id'); 
				
				
				
				#*************************** *************************** *************************** 
				#*************************** 	    EMAIL PREPARATION 	 *************************** 
				#*************************** *************************** *************************** 
		
				#to_user
				$_POST["TEXT_p"]				= 'Dear ' . $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name . ',
												   <br /> <br />Thank you for donating <br><br>
												   Donate Date: ' . date("d-m-Y", strtotime($saveData['date_added']) );
												   
				$_POST["donation_details"]		= $TMP_table->row_array();
											
										
				$email_template					= array("email_to"										=> $TMP_table->row()->email,
														"email_heading"									=> "Donation Form",
														"email_file"									=> "email/frontend/donate_form.php",
														"email_subject"									=> "Donation Form",
														"default_subject"								=> TRUE,
														"email_post"									=> $_POST,
														"email_cc"					=> "Imifinance786@gmail.com,sakinarizviimi@gmail.com,
														imiwaiting@att.net,rida.fatima@genetechsolutions.com,imihq@imamiamedics.com"
														);
				
				$is_email_sent				= $this->_send_email( $email_template );
				#to_user
				
				// create tax receipt pdf and send it to user.
				// self::send_tax_receipt($TMP_explode_strings[2], $this);
				$this->functions->send_tax_receipt($TMP_explode_strings[2], $this);
				
				
				#test email
				$message 					= '<strong>DONATE FORM:</strong> test _ payment ' . serialize( $_POST ) ;
				$email_template				= array("email_to"				=> 'sadiq.hussain@genetechsolutions.com',
													"email_heading"			=> 'DONATION FORM',
													"email_file"			=> "email/global/_blank_page.php",
													"email_subject"			=> '---> DONATION FORM',
													"email_post"			=> array("content"		=> $message) );
				
				//$is_email_sent				= $this->_send_email( $email_template );
				#test email
				
				
				
				#*************************** *************************** *************************** 
				#*************************** 	    EMAIL PREPARATION 	 *************************** 
				#*************************** *************************** *************************** 
				
				
				#$_POST["_pageview"]							= "global/_blank_page.php";
				$data['_messageBundle']					= $this->_messageBundle( 
								'success_big' , 
								lang_line('success_page_text', array($TMP_table->row()->donate_amount, DropdownHelper::donation_projects_dropdown(FALSE, $TMP_table->row()->donation_projects_id, false, false, false, $content_languages), $TMP_table->row()->email)),
								lang_line('success_page_heading')
				);
				
				$data['_pageview']							= "global/_blank_page.php";
				$data['return']							= true;
			}
				
		}
		
		
	
	}

	public function show( $slug = null, $secondparam = null )
    {
		$data								= $this->data;
		
		$data['menu_detail']				= $this->queries->fetch_records('cmsmenu', " AND slug = 'donation-campaigns' AND status = '1'");
		$data['menu_detail']				= new CustomMySql($data['menu_detail'], $this, 'cmsmenu', ['name','subheading']);


		if ( $data['menu_detail'] -> num_rows() <= 0 )
		{
			show_404();
		}
		
		$data['menu_active']					= $data['menu_detail']->row("name");
		$data['_pagetitle']						= $data['menu_detail']->row("subheading");

		if($slug != null){

			if($_POST['btn_donate_form']){
				$this->form_validation->set_rules('donation_projects', lang_line('text_donationprojects'), 'trim|required');
				$this->form_validation->set_rules('donate_amount', lang_line('label_donate_amount'), 'trim|required|numeric');
				$this->form_validation->set_rules('donate_name', lang_line('text_name'), 'required');
				$this->form_validation->set_rules('donate_email', lang_line('text_email'), 'trim|required|valid_email');		
				$this->form_validation->set_rules('donation_mode', lang_line('text_donatemode'), 'trim|required');
				$this->form_validation->set_rules('home_country', lang_line('text_country'), 'trim|required');
				// $this->form_validation->set_rules('custom_grecap', lang_line('text_captcha'), 'trim|required|callback_validate_recaptcha');

				if( site_url() == "https://imicanada.org/"){
					$this->form_validation->set_rules('donate_address', 'Address', 'trim|required');
				}
	
				$card_information=[];
				
				if($this->input->post('paymenttype')=="card"){	
					$this->form_validation->set_rules('paymenttype', lang_line('text_paymenttype'), 'trim|required');
					$this->form_validation->set_rules('card_name', lang_line('label_card_holder'), 'trim|required');
					$this->form_validation->set_rules('card_number', lang_line('label_card_no'), 'trim|required');
					$this->form_validation->set_rules('card_expiry', lang_line('label_card_expiry'), 'trim|required');
					$this->form_validation->set_rules('card_cvv', lang_line('label_card_cvv'), 'trim|required');

					$card_number = str_replace(' ','',$this->input->post("card_number"));
					$card_information=array(
						'type'=> $this->ccdetector->detect($card_number),
						'name'=>$this->input->post("card_name"),
						'number'=> $card_number,
						'expiry'=>$this->input->post("card_expiry"),
						'cvv'=>$this->input->post("card_cvv")
					);
				}
			
				if ($this->form_validation->run() == FALSE)
				{
					// var_dump(validation_errors());die('validation');

					$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
					// return TRUE;
				}else{
					
					if ($this->input->post("paymenttype")=="paypal") {

						$data['DONATEFORM']['_process_to_paypal']								= true;
					} elseif ($this->input->post("paymenttype")=="card") {
						//Pay via Payeezy
						$rand_uuid = $this->functions->gen_uuid();
						$pay = new Payeezy();
						$recurring = $this->input->post('donation_mode') == 'recurring' ? true : false;
						//$pay = $pay->pay($card_information, $_POST['donate_amount'],$recurring);
						$pay = $pay->pay($card_information, $_POST['donate_amount'], $_POST['donate_email'], $recurring, $rand_uuid);

						if (isset($pay['error'])) {
						    $logging = new Custom_log();
						    $check = $logging->write_log('error',  __FILE__.' '.$pay['error']. " line " .__LINE__.'  '.print_r($pay['request'],true));	
		     		    }
						
						if (! is_array($pay)) {
							 $data['card_error'] = "Something Went Wrong! Please Try Again.";
							$logging->write_log('error',  __FILE__.' '.$data['card_error']. " line " .__LINE__, true);
						}
					}
					
					$checkIfaCampg = DropdownHelper::donation_projects_dropdown(false, $this->input->post("donation_projects"), true);
		
					$insertData	= array(
						"donation_projects_id"	=> $this->input->post("donation_projects"),
						"first_name"			=> $this->input->post("donate_name"),
						"email"				 	=> $this->input->post("donate_email"),
						"donation_mode"			=> $this->input->post("donation_mode"),
						"donation_freq"			=> 'M-1',
						"donate_amount"			=> $this->input->post("donate_amount"),
						"donate_honoree"		=> $this->input->post("donate_honoree"),
						"emp_name"				=> $this->input->post("donation_empnames"),
						"emp_email"				=> $this->input->post("donate_empemail"),
						"home_country"			=> $this->input->post("home_country"),
						"home_address"			=> $this->input->post("donate_address"),
						"user_id"				=> $this->functions->_user_logged_in_details("id"),
						"date_added"			=> date("Y-m-d H:i:s"),
						"type"					=> "imiportal",
						"payeezy_uuid"			=> $rand_uuid
						
					);
					if (!is_null($checkIfaCampg) && isset($_POST["hideIdentity"])) {
						$insertData['hide_identity']			= 1;
					}
					
					if( site_url() == "https://imicanada.org/" ){
						$insertData['belongs_country'] = 3;
					}elseif( site_url() == "https://medicsinternational.org/" ){
						$insertData['belongs_country'] = 4;
					}else{
						$insertData['belongs_country'] = 2;
					}
					$this->queries->SaveDeleteTables($insertData, 's', "tb_donation_form", 'id');
					$data['donation_id']		= $this->db->insert_id();
					$donationId=$this->db->insert_id();
					
				  
                        if ($this->input->post("paymenttype")=="card") {
                            if (is_array($pay)) {
                                //$TMP_table	= $this->db->query("SELECT * FROM tb_donation_form WHERE id = '" . $donationId . "' ");
                                $TMP_table	= $this->db->query("SELECT df.*, dcc.comment as comments FROM tb_donation_form df LEFT JOIN `tb_dc_comments` dcc ON df.id = dcc.df_id WHERE df.id = '". $donationId ."' ");
        
                                $editData = array();
                                if (isset($pay['success'])) {
                                    $editData['is_paid'] = 1;
                                    $editData['id'] = $donationId;
                                    $this->queries->SaveDeleteTables($editData, 'e', "tb_donation_form", 'id');
                                }
        
                                $saveData		= array(
                                "user_id"		=> $this->functions->_user_logged_in_details("id"),
                                "payer_email"	=> $this->input->post("donate_email"),
                                "payment_status"=> isset($pay['success']) ? 'Completed' : 'Failed',
                                "payment_mode"	=> 'payeezy',
                                "table_name"	=> 'tb_donation_form',
                                "table_id_name"	=> 'id',
                                "table_id_value"=> $donationId,
                                "date_added"	=> date("Y-m-d H:i:s")
                            );
        
                                $this->queries->SaveDeleteTables($saveData, 's', "tb_donation_payments", 'id');
                                $payment_id = $this->db->insert_id();
                            
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
        
        
                                $this->queries->SaveDeleteTables($saveData, 's', "tb_card_payments", 'id');
        
                                if (isset($pay['error'])) {
                                    $data['card_error'] = $pay['error'];
                                }else{

                                
                                #*************************** *************************** ***************************
                                    #*************************** 	    EMAIL PREPARATION 	 ***************************
                                    #*************************** *************************** ***************************
                    
                                    #to_user
                                    $_POST["TEXT_p"]				= 'Dear ' . $TMP_table->row()->first_name . ' ' . $TMP_table->row()->last_name . ',
															<br /> <br />Thank you for donating <br><br>
															Donate Date: ' . date("d-m-Y");
                                                            
                                    $_POST["donation_details"]		= $TMP_table->row_array();
                                                        
                                                    
                                    $email_template					= array("email_to"				=> $TMP_table->row()->email,
                                                                "email_heading"				=> "Donation Form",
                                                                "email_file"				=> "email/frontend/donate_form.php",
                                                                "email_subject"				=> "Donation Form",
                                                                "default_subject"			=> true,
                                                                "email_post"				=> $_POST
                                                                );
                            
                                    $is_email_sent				= $this->_send_email($email_template);
                                    #to_user
                            
									// create tax receipt pdf and send it to user.
									// self::send_tax_receipt($donationId, $this);
									$this->functions->send_tax_receipt($donationId, $this);
                            
                            
                            
                                    #test email
                                    $message 					= '<strong>DONATE FORM:</strong> test _ payment ' . serialize($_POST) ;
                                    $email_template				= array("email_to"				=> 'ali.nayani@genetechsolutions.com',
                                                                "email_heading"			=> 'DONATION FORM',
                                                                "email_file"			=> "email/global/_blank_page.php",
                                                                "email_subject"			=> '---> DONATION FORM',
                                                                "email_post"			=> array("content"		=> $message) );
                            
                                    //$is_email_sent				= $this->_send_email( $email_template );
                                    #test email
                            
                            
                            
                                    #*************************** *************************** ***************************
                                    #*************************** 	    EMAIL PREPARATION 	 ***************************
                                    #*************************** *************************** ***************************
        
                                    $data['_messageBundle']				= $this->_messageBundle(
                                        'success_big',
                                        /*"Thank you for your donation of $".$TMP_table->row()->donate_amount." for the ".DropdownHelper::donation_projects_dropdown(FALSE, $TMP_table->row()->donation_projects_id, false, false, $content_languages).". A copy
										of your donation submission has been emailed to you at ".$TMP_table->row()->email."
										from <a href='mailto:noreply@imamiamedics.com'>noreply@imamiamedics.com</a> and a tax receipt will be sent via email from
										<a href='IMIFinance786@gmail.com'>IMIFinance786@gmail.com</a> to you as well no later than three to four weeks
										after your donation has been processed. Please do not hesitate to contact
										us at <a href='IMIFinance786@gmail.com'>IMIFinance786@gmail.com</a> should you have any questions or concerns.<br/><br/>Imamia Medics International<br/>EIN: 22330 920 8010 612",
										"You’re what making a difference looks like"*/
										lang_line('success_page_text', array($TMP_table->row()->donate_amount, DropdownHelper::donation_projects_dropdown(FALSE, $TMP_table->row()->donation_projects_id, false, false, false, $content_languages), $TMP_table->row()->email)),
										lang_line('success_page_heading')
									);
        
                                    $data['_pageview']						= "global/_blank_page.php";
        
                                    unset($_POST);
        
                                    $data['return'] = true;
                                }
                            }
                        }
				}
			} else if ( $secondparam == "paymentsuccess" ) {
				$this->payment_success( $data );
				$data['return'] = true;
			}
			else if ( $secondparam == "paymentnotify" )
			{
				$this->payment_success( $data );
				$data['return'] = true;
			}
			else if ( $secondparam == "paymentcancel" )
			{
				$this->payment_cancel( $data );
				$data['return'] = true;
			}
			$where = " AND status=1 AND slug = '$slug' ";
			
			if(!$data['return']){
				$country_name = self::getIPLocation();
			
				$data['locationID'] = $this->db->query("SELECT id FROM `tb_countries` WHERE countries_name = '{$country_name}' ")->row()->id;

				$data['chapter_countries'] = $this->db->query('SELECT `tb_belongs_country`.id, `tb_belongs_country`.country_id, `tb_chapter_paypal_settings`.paypal_email,`tb_currencies`.code,`tb_belongs_country`.country_title, tb_countries.countries_iso_code_2 as iso_code_2 FROM `tb_belongs_country` INNER JOIN `tb_chapter_paypal_settings` ON `tb_belongs_country`.chapter_id = `tb_chapter_paypal_settings`.chapter_id INNER JOIN `tb_currencies` ON `tb_chapter_paypal_settings`.`currency_id` = `tb_currencies`.id inner join tb_countries  on tb_countries.id = `tb_belongs_country`.country_id   ')->result_array();

				if( is_countryCheck(FALSE,FALSE,TRUE) == 'canada' ){
					$data['chapter_countries'] = array_reverse($data['chapter_countries']);
				}
				
				$data['_pageview'] = "frontend/donation_campaigns/details.php";
			}

			$campaigns_list						= $this->queries->fetch_records("donation_campaigns", $where, '', $limit, $offset)->result_array();
	
			if(!$campaigns_list){
				show_404();
			}
			$data['_pagetitle']					= $campaigns_list[0]['name'];
			
			$data['campaigns_list'] 			= $this->refactorCampaign($campaigns_list);
			
			$data['_is_breadcrumbs']			= $this->breadcrumbs( $data['menu_detail']->row("id"), $data['campaigns_list'][0] );
		
		} else {

			$data['_is_breadcrumbs']			= $this->breadcrumbs( $data['menu_detail']->row("id") );
		}

		
		$this->load->view( FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW, $data );	
	}

	private function refactorCampaign($campaigns_list)
	{
			
		foreach ($campaigns_list as $key => &$campaign) {
			if($campaign['id'] == "2"){
				$campaign['donation_amount'] = 1640000;
			} else {
				$donation_data		= $this->queries->fetch_records("who_donate", " AND donation_projects_id = '". $campaign['donation_project_id'] ."' AND is_paid = 1 ")-> result_array();
				foreach ($donation_data as $k => $donation) {
					//$campaign['country_code']	= $this->queries->fetch_records("countries", " AND id={$donation['home_country']}")->row('countries_iso_code_2');
					$campaign['donation_amount']	+= $donation['donate_amount'];
					if($donation['donation_mode'] == "recurring"){
						if($donation['num_of_recurring'] > 0){
							$payments = $this->db->query("SELECT dcp.amount FROM tb_donation_payments dp INNER JOIN `tb_card_payments` dcp ON dp.id = dcp.payment_id WHERE dp.table_id_value = ".$donation['id']." AND dp.table_name = 'tb_donation_form' AND dp.payment_mode = 'payeezy' AND dcp.is_cron = 1 AND dcp.transaction_id != '' AND dcp.sequence_no != 0")->result_array();
							foreach($payments as $payment) {
								$campaign['donation_amount']	+= $payment['amount'];
							}
						}
					}
				}
	
				$camp_data			= $this->queries->fetch_records("dc_offline_donation", " AND camp_id = '". $campaign['id'] ."' AND status = 1 ")-> result_array();
				foreach ($camp_data as $k => $donation) {
					$campaign['donation_amount']	+= $donation['donate_amount'];
				}
			}
			
			// replace language specific fields
			$campaigns_languages = $this->queries->fetch_records("donation_campaigns_languages", " AND donation_campaigns_id = {$campaign['id']}")->result_array();
			replace_data_for_lang($campaign, $this->data['content_languages'], $campaigns_languages, ['short_desc', 'content', 'sidebar'], SessionHelper::_get_session('LANG_CODE') );	
			
			$projects_languages = $this->queries->fetch_records("donation_projects_languages", " AND donation_projects_id = {$campaign['donation_project_id']}")->result_array();
			replace_data_for_lang($campaign, $this->data['content_languages'], $projects_languages, ['name'], SessionHelper::_get_session('LANG_CODE') );	

			$campaign['goal_amount']			= number_format($campaign['goal_amount'], 0, '.', ',');
			$campaign['donation_amount']		= number_format($campaign['donation_amount'], 0, '.', ',');
			$campaign_gallery		= $this->queries->fetch_records("donation_campaigns_gallery", " AND donation_campaigns_id = {$campaign['id']} ")->result_array();	
			$campaign['gallery_images'] = array_filter($campaign_gallery, function($child) {
				return $child['type'] == "image";
			});
			$campaign['gallery_videos'] = array_filter($campaign_gallery, function($child) {
				return $child['type'] == "video";
			});
		}
		
		return $campaigns_list;
	}

	public function getCampaigns(){
		$siteIdQuery = getSiteId();
		$page =  $_GET['page'];
		
		$limit = 10;
		$offset = 10*$page;
		
		$campaigns_list			= $this->queries->fetch_records("donation_campaigns", " AND status=1 ".$siteIdQuery, '', $limit, $offset)->result_array();
		if(!empty($campaigns_list)){
			$campaigns_data = $this->refactorCampaign($campaigns_list);

			if(empty($campaigns_data)){
				echo "";
			}else{
				echo json_encode($campaigns_data);
			}
		} else {
			echo "";
		}
	}

	public function getDonors(){
		$project_id =  $_GET['project_id'];
		$page =  $_GET['page'];
		$campaign_id = $_GET['campaign_id'];

		$limit = 10;
		$offset = 10*$page;
		
		//$donation_data =  $this->queries->fetch_records("who_donate", " AND donation_projects_id = '". $project_id ."' AND is_paid = 1 ", '', $limit, $offset)-> result_array();

		//foreach ($donation_data as $k => &$donation) {
		//	$donation['country_code']	= $this->queries->fetch_records("countries", " AND id={$donation['home_country']}")->row('countries_iso_code_2');
		//}
		// countries_iso_code_2
		
		$donation_data =  $this->db->query("SELECT df.id, ct.countries_iso_code_2 as country_code, df.donate_amount, df.first_name, df.date_added, df.hide_identity FROM `tb_donation_form` df left join tb_countries ct ON df.home_country = ct.id WHERE df.is_paid = 1 and df.donation_projects_id = '".$project_id."'
		UNION ALL
		SELECT df.id, ct.countries_iso_code_2 as country_code, df.donate_amount, df.first_name, cp.date_added, df.hide_identity FROM `tb_donation_form` df INNER JOIN tb_donation_payments dp ON df.id = dp.table_id_value AND dp.table_name = 'tb_donation_form' INNER JOIN tb_card_payments cp ON cp.payment_id = dp.id left join tb_countries ct ON df.home_country = ct.id WHERE df.donation_mode = 'recurring' and cp.is_cron = 1 and cp.transaction_id != '' and df.is_paid = 1 and df.donation_projects_id = '".$project_id."'
        UNION ALL
		SELECT df.id, ct.countries_iso_code_2 as country_code, df.donate_amount, df.first_name, df.date_added, df.hide_identity FROM `tb_dc_offline_donation` df left join tb_countries ct ON df.home_country = ct.id WHERE df.status = 1 and df.camp_id = '".$campaign_id."'
		order by date_added DESC limit $offset, $limit")-> result_array();
        
		if(empty($donation_data)){
			echo "";
		}else{
			echo json_encode($donation_data);
		}
	}

	public function getFeedback(){
		$project_id =  $_GET['project_id'];
		$page =  $_GET['page'];
		$campaign_id =  $_GET['campaign_id'];

		$limit = 10;
		$offset = 10*$page;
		
		/*$result = $this->db->select('tb_dc_comments.*, tb_donation_form.first_name, tb_donation_form.hide_identity')
		->from('tb_dc_comments')
		->join('tb_donation_form', 'tb_donation_form.id = tb_dc_comments.df_id')
		->where('tb_donation_form.is_paid', 1)
		->where('tb_dc_comments.status', 1)
		->where('tb_donation_form.donation_projects_id', $project_id)
		->limit($limit, $offset)
		->order_by('id', 'desc')
		->get()->result_array();*/
		
		$result =  $this->db->query("SELECT dc.comment, dc.added_date, df.first_name, df.hide_identity FROM `tb_dc_comments` dc join tb_donation_form df ON df.id = dc.df_id WHERE df.is_paid = 1 and df.donation_projects_id = '".$project_id."' and dc.status = 1
		UNION ALL
		SELECT dc.comment, dc.date_added as added_date, dc.first_name, dc.hide_identity FROM `tb_dc_offline_donation` dc WHERE dc.status = 1 and dc.camp_id = '".$campaign_id."' and dc.comment_status = 1
		order by added_date DESC limit $offset, $limit")-> result_array();

		if(empty($result)){
			echo "";
		}else{
			echo json_encode($result);
		}
    }
	public function getUpdates(){
		$campaign_id =  $_GET['campaign_id'];
		$page =  $_GET['page'];
		
		$limit = 10;
		$offset = 10*$page;
		
		$updates_list			= $this->queries->fetch_records("donation_campaigns_updates", " AND status=1 AND donation_campaigns_id=$campaign_id ORDER BY date DESC", '', $limit, $offset)->result_array();

		foreach ($updates_list as $key => &$update) {
			$campaigns_updates_languages = $this->queries->fetch_records("donation_campaigns_updates_languages", " AND donation_campaigns_updates_id = {$update['id']}")->result_array();
			replace_data_for_lang($update, $this->data['content_languages'], $campaigns_updates_languages, ['description'], SessionHelper::_get_session('LANG_CODE') );
		}
        
		if(empty($updates_list)){
			echo "";
		}else{
			echo json_encode($updates_list);
		}
    }

	public function breadcrumbs( $menu_parent_id = FALSE, $detailPage = FALSE )
	{		
		//echo $menu_parent_id; die;

		$TMP_array[]												= array("name"			=> lang_line('text_home'),
																			"link"			=> site_url());
		
		
		
		$TMP_breadcrumbs											= array();
		$TMP_is_exceptional											=  $this->queries->fetch_records("cmsmenu", 
																									 " 	AND id = '". $menu_parent_id ."' 
																									 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) IN ('footer') " );
		

		if ( $TMP_is_exceptional -> num_rows() > 0 )
		{
			$TMP_is_exceptional										= " AND parentid != '0' ";	
		}
		else
		{
			$TMP_is_exceptional										= FALSE;
		}
		
		$this->recursive_menus( $menu_parent_id, TRUE, $TMP_breadcrumbs, TRUE, $TMP_is_exceptional ); 
		
		foreach ( $TMP_breadcrumbs as $b_key => $b_value)
		{
			$cmsmenu_languages = $this->queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$b_key}")->result_array();

			replace_data_for_lang($b_value, $this->data['content_languages'], $cmsmenu_languages, ['name'], SessionHelper::_get_session('LANG_CODE') );
			
			if($detailPage){
				unset($b_value['is_active']);
			}
			$TMP_array[]											= $b_value;
		}
		
		if($detailPage){
			$TMP_array[]											= array("name"				=> $detailPage["name"],
																			"is_active"			=> TRUE);
		}
		
	//echo print_r($TMP_array); die;
		return $TMP_array;
	}

	function recursive_menus( $menu_id = FALSE, $is_current_menu, &$return_array = array(), $sort_asc = TRUE, $is_exceptional = FALSE )
	{
		
		$TMP_attributes									= array();
		
		if (  $is_current_menu  )
		{
			#current_item
			$TMP											= $this->queries->fetch_records("cmsmenu", " AND id = '". $menu_id ."' ");
			$TMP_content									= $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $menu_id ."' ");	
			$TMP_attributes									= $this->functions->set_link_attributes( $TMP->row_array(), $TMP_content, SLUG_PAGE );
			$TMP_attributes['link']							= $TMP_attributes['href'];
			$TMP_attributes['is_active']					= TRUE;
			$return_array[ $TMP->row('id') ]				= $TMP_attributes; #array("name"				=> $TMP->row('name') );	
		}
		
		
		
		
		#recursive -> parent - child - subchild
		$this->queries->fetch_records("cmsmenu", " AND id = '". $menu_id ."' ", "parentid");
		$TMP												= $this->queries->fetch_records("cmsmenu", " AND id IN (". $this->db->last_query() .") $is_exceptional ");
		foreach ( $TMP->result_array() as $t)
		{
			$TMP_attributes									= array();
			$TMP_content									= $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $t['id'] ."' ");	
			$TMP_attributes									= $this->functions->set_link_attributes( $t, $TMP_content, SLUG_PAGE );
			$TMP_attributes['link']							= $TMP_attributes['href'];
			$return_array[ $t['id'] ]						= $TMP_attributes;
			
			#sorting values:
			if ( $sort_asc )
			{
				ksort( $return_array );	
			}
			
			
			
			$this->recursive_menus( $t['id'], FALSE, $return_array, $sort_asc, $is_exceptional );
		}
	}
	static public function getIPLocation()
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		$ch = curl_init('http://ipwhois.app/json/'.$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);
		curl_close($ch);

		// Decode JSON response
		$ipwhois_result = json_decode($json, true);
		// Country code output, field "country_code"
		return strtolower($ipwhois_result['country']);

	}
}