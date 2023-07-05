<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("controls_include.php");
class Controls extends Controls_Include {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displaye d at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct( $global_parameters = array() )
	{
		parent::__construct();
		
		$IS_auth_login				= TRUE;
		if ( count( $global_parameters ) > 0 )
		{
			if ( array_key_exists("required_login", $global_parameters ) )
			{
				if ( ! $global_parameters['required_login'] )
				{
					$IS_auth_login		= FALSE;
				}
			}
		}
		
		
		if ( $IS_auth_login )
		{
			$this->_auth_login( false );
		}
		
		$this->data													= $this->default_data();
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'Manage All Reports';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";

		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/conference_registration/";
		$this->data['_messageBundle2']								= $this->data['_messageBundle'];
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	

	}
	


	
	
	
	public function view()
	{
		$data	    = $this->data;

		/* Paypal Start */
		$data_paypal = $this->db->query("SELECT * FROM `tb_paypal_transaction_data`");

		if($data_paypal->num_rows() > 0){
			$data_paypal_array = $data_paypal->result_array(); 

			
			foreach ($data_paypal_array as $data_paypal_item) {

				$record_id = $data_paypal_item['id'];

				$existance_check = $this->db->query("SELECT id FROM `tb_external_payments` WHERE transaction_paypal_id={$record_id}");

				if(!($existance_check->num_rows() > 0)){
				
					$external_tb_query   = "INSERT INTO `tb_external_payments` (transaction_paypal_id, transaction_payeezy_id) VALUES ({$record_id},null)";
					$external_tb_data    = $this->db->query($external_tb_query);
					$external_tb_data_id = $this->db->insert_id();
					$transaction_id      = $data_paypal_item['transaction_id'];

					if($data_paypal_item['transaction_event_code'] == 'T0002'){
						$payment_mode    =  'recurring';

						$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, null, null)");

						/* $paypal_id_record = $this->db->query("SELECT * FROM tb_donation_form WHERE donation_mode = 'recurring' AND donate_amount = {$donation_amount} AND ({$like_query} email LIKE '%{$email_address}%')");
						var_dump($this->db->last_query());die; */


					}else if($data_paypal_item['transaction_event_code'] == 'T0007'){
						$payment_mode     =  'onetime';
						if(preg_match("/donation/", $data_paypal_item['custom_field'])){
							$paypal_id_record 			= $this->db->query("SELECT * FROM tb_paypal_payments pp INNER JOIN tb_donation_payments dp ON pp.payment_id = dp.id INNER JOIN tb_donation_form df ON dp.table_id_value = df.id WHERE pp.payer_id='{$transaction_id}'");
							$paypal_record = $paypal_id_record->result_array();

							if($paypal_record){
								$donation_form_id = $paypal_record[0]['table_id_value'];
								
								$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, {$donation_form_id}, null, null, null)");
							}else{
								$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, null, null)");
							}

						}elseif(preg_match("/membership/", $data_paypal_item['custom_field'])){
							$paypal_id_record 			= $this->db->query("SELECT id,paypal_post FROM `imi_conf_restore2`.tb_user_memberships um WHERE um.paypal_post LIKE '%{$transaction_id}%'");
							$paypal_record = $paypal_id_record->result_array();

							if($paypal_record){
								$membership_form_id = $paypal_record[0]['id'];
								
								$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, {$membership_form_id}, null, null)");
							}else{
								$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, null, null)");
							}
						}else{
							$paypal_id_record 			= $this->db->query("SELECT conference_registration_id FROM tb_short_conference_payments scp WHERE scp.payer_id='{$transaction_id}'");
							$paypal_record = $paypal_id_record->result_array();
							
							if($paypal_record){
								$conference_form_id = $paypal_record[0]['conference_registration_id'];
								$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, {$conference_form_id}, null)");
							}else{
								$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, null, null)");
							}
						}
					}else{
						$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, null, null)");
					}
				}
					
			}
		}

		/* Paypal End */

		/* Payeezy Start */
		$data_payeezy = $this->db->query("SELECT * FROM `tb_payeezy_transaction_data`");
		if($data_payeezy->num_rows() > 0){
			$data_payeezy_array = $data_payeezy->result_array(); 
			foreach ($data_payeezy_array as $data_payeezy_item) {

				$record_id = $data_payeezy_item['id'];

				$existance_check = $this->db->query("SELECT id FROM `tb_external_payments` WHERE transaction_payeezy_id={$record_id}");

				if(!($existance_check->num_rows() > 0)){

					$external_tb_query   = "INSERT INTO `tb_external_payments` (transaction_paypal_id, transaction_payeezy_id) VALUES (null,{$record_id})";
					$external_tb_data    = $this->db->query($external_tb_query);
					$external_tb_data_id = $this->db->insert_id();

					if($data_payeezy_item['status'] == 'Approved'){
						// $payment_mode    =  'recurring';
						$transaction_id = $data_payeezy_item['tag'];
						// echo '<pre>';
						// print_r($data_payeezy_item);
						// echo '</pre>';

						$payeezy_donation_record 	     = $this->db->query("SELECT * FROM tb_card_payments cp INNER JOIN tb_donation_payments dp ON cp.payment_id = dp.id WHERE cp.transaction_tag='{$transaction_id}'");

						if( $payeezy_donation_record->num_rows() > 0){
							$payeezy_for_donation_id = $payeezy_donation_record->result_array();
							$payeezy_donation_id     = $payeezy_for_donation_id[0]['table_id_value'];


							$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, $payeezy_donation_id, null, null, null)");

						}else{
								$payeezy_short_conference_record = $this->db->query("SELECT conference_registration_id FROM tb_short_conference_payments WHERE payer_id='{$transaction_id}'");
								
								if($payeezy_short_conference_record->num_rows() > 0){
									$payeezy_for_short_conference_id = $payeezy_short_conference_record->result_array();
									$payeezy_short_conference_id     = $payeezy_for_short_conference_id[0]['conference_registration_id'];

									$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, $payeezy_short_conference_id, null)");

								}else{
									$this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, null, null)");
								}

							
						}
						
						// echo '</pre>';

						// $this->db->query("INSERT INTO tb_all_payments_compiled(external_payment_id,df_id,um_id,sc_id,recurring_no) VALUES ({$external_tb_data_id}, null, null, null, null)");
						// $save_data['']  = transaction_subject;
					}
				}
			}
		}

		/* Payeezy End */

			
		$this->load->library("Encrption");
		$data['table_record'] 										= $this->fetch_records_for_view( array(), false );
		
		
		$data["table_properties"]									= $this -> view_table_properties(  SessionHelper::_get_session("slug", "conference") );
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function index ()
	{
		
	}

	public function options()
	{
		
		$data					= $this->data;
		$is_post				= FALSE;
		
		
		if ( $this->input->post("TMP_change_payment_status_for_this_id") ) 
		{
			$is_post			= TRUE;
		}
		else if ( isset($_POST['checkbox_options']) )
		{
		
			if (count($_POST['checkbox_options']) > 0 )
			{
				$is_post		= TRUE;
			}
				
		}
		
		if ($is_post)
		{
			switch ($_POST['options'])
			{
				
				case "delete":
					$this->delete( $_POST['checkbox_options'] );
					break;
					
				
				case "ajax_download_csv":
					$this->download_csv( $_POST['checkbox_options'], 'all' );
					break;
					
				case "ajax_download_paypalcsv":
					$this->download_csv( $_POST['checkbox_options'], 'paypal');
					break;

				case "ajax_download_payeezycsv":
					$this->download_csv( $_POST['checkbox_options'], 'payeezy' );
					break;

				case "ajax_get_data":
					$this->update_records();
					break;
				
				default:
					$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
					redirect(  site_url( $data["_directory"] . "controls/view" ) );
					break;
				
			}
		}
		else
		{
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
			redirect( site_url( $data["_directory"] . "controls/view" ) );
		}

	}

	public function receipt( $userid, $type='', $recept_num = '', $date = '', $is_bulk = false ){
		$has_data       = false;

		if($type == 'shortconferencceregistration'){

			$receipt_pdf 	= "receipts/global-shortconference.php";
		
			$data					= $this->data;
	
			$_POST['conference']						= $this->queries->fetch_records('short_conference', " AND slug = '". SessionHelper::_get_session("slug", "conference") ."' ");
			
			$_POST['conferenceregistration']			= $this->queries->fetch_records('short_conference_registration_master', 
			" AND userid = '". $userid . "' 
			  AND conferenceid = '". $_POST['conference'] -> row("id") ."' ");

			// var_dump($_POST['conference'] -> row("id"));
			// var_dump($_POST['conferenceregistration']);
					  
			$_POST['conferenceregistration_screenone']		= $this->queries->fetch_records('short_conference_registration_screen_one', " AND conferenceregistrationid = '". $_POST['conferenceregistration']->row("id") ."' ");
	
			$_POST['conferenceregistration_screenone_family_details']	= $this->queries->fetch_records('short_conference_registration_screen_one_family_details'," AND parentid = '". $_POST['conferenceregistration_screenone']->row("id") ."' ");
			
			$_POST['conferenceregistration_screentwo']		= $this->queries->fetch_records('short_conference_registration_screen_two', " AND conferenceregistrationid = '". $_POST['conferenceregistration']->row("id") ."' ");
	
			$_POST['conferenceregistration_screentwo_details']	= $this->queries->fetch_records('short_conference_registration_screen_two_details', " AND parentid = '". $_POST['conferenceregistration_screentwo']->row("id") ."' ");
			
			$_POST['donation_details']['name'] = isset($_POST['conferenceregistration_screenone']->row()->name) ? $_POST['conferenceregistration_screenone']->row()->name : '';

			if( $_POST['conferenceregistration_screenone']->num_rows() > 0 ){
				$has_data       = true;
				$pdf_post		= $_POST;
				$name			= $_POST['conferenceregistration_screenone']->row()->name;
				$email			= $_POST['conferenceregistration_screenone']->row()->email;
				$project		= $_POST['conferenceregistration']->row()->conference_name;
				$amount			= $_POST['conferenceregistration_screentwo']->row()->price_total_payable;
				$date 			= $_POST['conferenceregistration']->row()->date_added;
				$serial_num 	= 'SC' . $_POST['conferenceregistration']->row()->tax_receipt_num;
			}
		}elseif($type == 'donation' || $type == 'eventregistration'){

			$data					= $this->data;
			$TMP_table	= $this->db->query("SELECT df.*, dcc.comment as comments, dpp.name as dpdesc, dc.name as home_city_name, ds.name as home_state_name, dr.receipt_number, dr.receipt_prefix FROM tb_donation_form df LEFT JOIN `tb_dc_comments` dcc ON df.id = dcc.df_id LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_cities dc ON dc.id = df.home_city LEFT JOIN tb_states ds ON ds.id = df.home_state LEFT JOIN tb_payment_receipts dr ON df.id = dr.table_id_value AND dr.table_name = 'tb_donation_form'  WHERE df.id = '". $userid ."' ");

			if($TMP_table->row()->belongs_country == '3'){
				$receipt_pdf 	= "receipts/canada.php";
			}
			// international
			else{
				$receipt_pdf 	= "receipts/global.php";
			}

			if( $TMP_table->num_rows() > 0 ){
				$has_data       = true;
				$pdf_post		= $_POST;
				$name			= $TMP_table->row()->first_name;
				$address		= $TMP_table->row()->home_city_name . $_homestate;
				$email			= $TMP_table->row()->email;
				$project		= $TMP_table->row()->dpdesc;
				$amount			= $TMP_table->row()->donate_amount;
				$date 			= !empty($date) ? $date : date("Y-m-d", strtotime( $TMP_table->row()->date_added));
				$serial_num 	= $TMP_table->row()->receipt_number ? ($recept_num != $TMP_table->row()->receipt_number ? $TMP_table->row()->receipt_prefix . $recept_num : $TMP_table->row()->receipt_prefix . $TMP_table->row()->receipt_number) : "N/A";
			}

		}elseif( $type == 'membershipregistration' ){

			$receipt_pdf 	= "receipts/global.php";

			$TMP_table	= $this->db_imiconf->query("SELECT um.id as ms_id, um.user_id, um.membership_package_name, um.membership_package_price, um.date_purchased, ud.*, up.home_country as country, up.home_state_province as state, up.home_city as city FROM tb_user_memberships um LEFT JOIN `tb_users` ud ON  ud.id =  um.user_id LEFT JOIN tb_users_profile up ON up.userid = ud.id WHERE um.id = '". $userid ."' ");

			if( $TMP_table->num_rows() > 0 )
			{
				$_homestate	= ($TMP_table->row()->state) ? ', ' . $TMP_table->row()->state : "";
				$TMP_receipt_table	= $this->db->query("SELECT receipt_number, receipt_prefix FROM tb_payment_receipts WHERE table_name = 'tb_user_memberships' AND table_id_value = '". $userid ."' ");

				$has_data       = true;
				$pdf_post		= $_POST;
				$name			= $TMP_table->row()->first_name;
				$address		= $TMP_table->row()->home_city_name . $_homestate;
				$email			= $TMP_table->row()->email;
				$project		= $TMP_table->row()->membership_package_name;
				$amount			= $TMP_table->row()->membership_package_price;
				$date 			= date("Y-m-d", strtotime( $TMP_table->row()->date_purchased));
				$serial_num     = (($TMP_receipt_table->row()->receipt_number) ? $TMP_receipt_table->row()->receipt_prefix . $TMP_receipt_table->row()->receipt_number : "N/A");
			}
		}

		if($has_data){

			$this->load->library('pdf');
	
			$pdfData = array(
				"pdf_post"		=> $pdf_post,
				"name"			=> $name,
				"email"			=> $email,
				"project"		=> $project,
				"amount"		=> $amount,
				"date" 			=> $date,
				"serial_num" 	=> $serial_num,
			);
			
			$file_name = 'tax-receipt-' . $userid . '.pdf';
			$html_code = '<link rel="preconnect" href="https://fonts.googleapis.com">';

	
			$html_code .= $this->load->view( $receipt_pdf, $pdfData, TRUE );
			$pdf = new Pdf();
			$pdf->load_html($html_code);
			$pdf->render();
	
			if($is_bulk){
				
				$output = $pdf->output();
	
				//temp directory path of live and local
				$localhost = array('127.0.0.1', "::1");
				if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
					$path = $_SERVER['DOCUMENT_ROOT'].'/imamiamedicscom/assets/temp-tax-files/';
				} else {
					$path = $_SERVER['DOCUMENT_ROOT'].'/assets/temp-tax-files/';
				}
				file_put_contents($path.$file_name, $output);
			}else{
	
				$pdf->stream($file_name);
			}
		}


		if(!$is_bulk){
			redirect( site_url( $data["_directory"] . "controls/view" ) );
		}
	}

	public function download_csv( $id, $csvtype)
	{ 
		$data												= $this->data;
		
		
		header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='. strtotime("now") . '-' . $csvtype . '.csv');
		
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		
		// output the column headings
		
		$TMP_heading					= array( 
											'Card Holder\'s Name',
											'Full Name',
											'Amount',
											'Date',
											'Purpose',
											'Payment Method',
											'Payment Mode',
											'Country Name',
											'Email',
											'Status',
											'Tax Receipt',
											'Automated Reconciliation Status'
										);
		
		fputcsv($output, $TMP_heading);

		if($csvtype == 'all'){
			$table_record 					= $this->fetch_records_for_view( [], false, $csvtype);	
		}elseif($csvtype == 'paypal'){
			$table_record 					= $this->fetch_records_for_csv_paypal( [], false, $csvtype);	
		}elseif($csvtype == 'payeezy'){
			$table_record 					= $this->fetch_records_for_csv_payeezy( [], false, $csvtype);	
		}

		foreach ($table_record as $row) 
		{
			$receipt = !empty($row['tax_receipt']) ? $row['receipt_prefix'].$row['tax_receipt'] : '';

			$abc						= 		array(

												$row["card_holder_name"],

												$row['full_name'],

                        						$row['transaction_amount'],
                        
												$row['date'],
												
												$row['purpose'],
												
												$row['payment_method'],

												$row['doantion_mode'],

												$row['country_name'],
												
												$row['email_address'],

												$row['transaction_status'],

												$receipt,

												$row['reconciliation_status']
												);
												
			fputcsv($output, $abc);
		}/* die; */
		
	}

	public function update_records(){
		$this->fetch_paypal_records();
		$this->fetch_payeeezy_records();
		
		
		redirect( site_url( $this->data["_directory"] . "controls/view" ) );
	}

	public function fetch_paypal_records(){

		$start_date   = "2023-01-01T00:00:00-0700";
		$end_date     = "2023-01-26T00:00:00-0700";
		$current_date = date('Y-m-d' , strtotime(date('Y-m-d') . "+1 day" ) );

		$current_paypal_data = $this->db->query("SELECT transaction_initiation_date FROM `tb_paypal_transaction_data` ORDER BY transaction_initiation_date DESC LIMIT 1");
		$last_inserted_date  = $current_paypal_data->result_array()[0]['transaction_initiation_date'];
		$from_date           = new DateTime($current_paypal_data->result_array()[0]['transaction_initiation_date']);
		
		// update start and end dates for current month
		$start_date = date('Y-m-d', strtotime($from_date->format('Y-m-d') . "-7 days")).'T00:00:00-0700';
		$end_date   = $current_date.'T00:00:00-0700';
		
		$clientId = 'AS8ZTNY_42mftLLMBg9eSFH58j18uffVrrSbi7zIK7Q0MADl0E3XRvCawo2Tyj7-qE9KwlovqhWA-9zz';
		$secret   = "EP0ybwA8zdGJt2W2C5Oa4JVdIB8tD2HF5HqbpGSzB_p48VY4LgSR6RsInHnLTtu3-oLO97NBY09iWMPP";
		$url_base = 'https://api-m.paypal.com/';

		$ch = curl_init();
		ini_set('max_input_vars', 15000);
		ini_set('max_execution_time', 300); // 300 seconds = 5 minutes
		ini_set('memory_limit', '256M'); // 256MB
		curl_setopt($ch, CURLOPT_URL, $url_base . "v1/oauth2/token");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Accept-Language: en_US'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
		
		$result = curl_exec($ch);

		if(empty($result)){
			die("Error: No response.");
		}
		else
		{
			$json = json_decode($result, true);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url_base . "v1/reporting/transactions?fields=all&page_size=100&page=1&start_date=".$start_date."&end_date=".$end_date."");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json',"Authorization: Bearer ".$json['access_token']."", 'Accept-Language: en_US', 'Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($ch);
			if(empty($result)){
				die("Error: No response.");
			}
			else
			{
				$transaction_info = '';
				$prayer_infor = '';
				$final = array(); 
				$data1= json_decode($result, true);
				
				if (isset($data1['total_items']) != 0) {
				
					
					$serialize_data = '';
					$i = 0;
					foreach ($data1['transaction_details'] as  $value) {

						$serialize_data = serialize($value);

				
						$alternate_full_name = empty($value['payer_info']['payer_name']['alternate_full_name']) ? null : $value['payer_info']['payer_name']['alternate_full_name'];
						$email_address = empty($value['payer_info']['email_address']) ? null : $value['payer_info']['email_address'];
						$item_name = empty($value['cart_info']['item_details'][0]['item_name']) ? $value['transaction_info']['transaction_subject'] : $value['cart_info']['item_details'][0]['item_name'];

						if ($item_name != '') {
							$item_name = empty($value['cart_info']['item_details'][0]['item_name']) ? $value['transaction_info']['transaction_subject'] : $value['cart_info']['item_details'][0]['item_name'];
						}else{
							$item_name = null;
						}

						$custom_field   = empty($value['transaction_info']['custom_field']) ? null : $value['transaction_info']['custom_field'];

						$transaction_initiation_date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $value['transaction_info']['transaction_initiation_date'])));
						$transaction_updated_date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $value['transaction_info']['transaction_updated_date'])));

						$array['FinalArray'][] = array(
							"card_holder_name"=>$alternate_full_name,
							"transaction_id"=>$value['transaction_info']['transaction_id'],
							"custom_field"=>$custom_field,
							"transaction_event_code"=>$value['transaction_info']['transaction_event_code'],
							"email_address"=>$email_address,
							"transaction_amount"=>$value['transaction_info']['transaction_amount']['value'],
							"item_name"=>$item_name,
							"post_data"=>$serialize_data,
							"transaction_initiation_date"=>$transaction_initiation_date,
							"transaction_updated_date"=>$transaction_updated_date,
							"transaction_status"=>$value['transaction_info']['transaction_status']
							);

					}
				}
			}

		}

		curl_close($ch);
		// echo '<pre>';
		// print_r($array);
		// echo '</pre>';
		
		foreach ($array as $items) {
			foreach ($items as $itemss) {
				// var_dump($itemss['transaction_id']);
				$get = $this->db->query("SELECT * FROM `tb_paypal_transaction_data` where transaction_id='".$itemss['transaction_id']."'");
				// var_dump($this->db->last_query());
				// var_dump($get->result_array());
				if (count($get->result()) > 0) {
					continue;
				}

				// echo '<pre>';
				// print_r($itemss);
				// echo '</pre>';
				// die;

				$card_holdername = str_replace("'",'',$itemss['card_holder_name']);
				$item_names = str_replace("'",'',$itemss['item_name']);
		
				$q = "INSERT INTO `tb_paypal_transaction_data`
					(
					card_holder_name,
					transaction_id,
					custom_field,
					transaction_event_code,
					email_address,
					transaction_amount,
					item_name,
					post_data,
					transaction_initiation_date,
					transaction_updated_date,
					transaction_status
				)VALUES(
					'".$card_holdername."',
					'".$itemss['transaction_id']."',
					'".$itemss['custom_field']."',
					'".$itemss['transaction_event_code']."',
					'".$itemss['email_address']."', 
					'".$itemss['transaction_amount']."',
					'".$item_names."',
					'".$itemss['post_data']."',
					'".$itemss['transaction_initiation_date']."',
					'".$itemss['transaction_updated_date']."',
					'".$itemss['transaction_status']."')";

				$res = $this->db->query($q) or trigger_error($this->db->error, E_USER_ERROR);

			} /* die; */

		}

	}

	public function fetch_payeeezy_records(){

		$username     = "aghaabbas";
		$password     = "IM1hq543679";
		$credentials  = base64_encode("$username:$password");
		$array        = array();

		$current_date = date('Y-m-t');

		$current_payeezy_data = $this->db->query("SELECT time FROM `tb_payeezy_transaction_data` ORDER BY time DESC LIMIT 1");
		$last_inserted_date  = $current_payeezy_data->result_array()[0]['time'];
		$from_date           = new DateTime($current_payeezy_data->result_array()[0]['time']);
		// update start and end dates for current month
		$start_date = date('Y-m-d', strtotime($from_date->format('Y-m-d') . "-7 days"));
		$end_date   = $current_date;
		
		// var_dump($start_date);
		// var_dump($end_date); die;
		
		$url = "https://api.globalgatewaye4.firstdata.com/transaction/search?start_date=" . $start_date . "&end_date=" . $end_date;
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Authorization: Basic $credentials"
				),
				));
				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);

				if (!$err) {

					$data1 = array_map('str_getcsv', explode("\n", $response));
						/*echo "<pre>";
						print_r($data1);
						echo "</pre>";
						die;*/
						foreach ($data1 as $key => $value) {
								
							$Tag = empty($value[0]) ? '' : $value[0];
							$Cardholder_Name = empty($value[1]) ? '' : $value[1];
							$Card_Number = empty($value[2]) ? '' : $value[2];
							$Expiry = empty($value[3]) ? '' : $value[3];
							$Card_Type = empty($value[4]) ? '' : $value[4];
							$Amount = empty($value[5]) ? '' : $value[5];
							$amount = str_replace("$", "", $Amount);
							$Transaction_Type = empty($value[6]) ? '' : $value[6];
							$Status = empty($value[7]) ? '' : $value[7];
							$Auth_No = empty($value[8]) ? '' : $value[8];
							$Time = empty($value[9]) ? '' : $value[9];
							$time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $Time)));
							$Ref_Num = empty($value[10]) ? '' : $value[10];
							$Cust_Ref_Num = empty($value[11]) ? '' : $value[11];
							$Reference_3 = empty($value[12]) ? '' : $value[12];
							$Account_Name = empty($value[13]) ? '' : $value[13];
							$Merchant_Name = empty($value[14]) ? '' : $value[14];
							$Merchant_code = empty($value[15]) ? '' : $value[15];
							$Terminal_Name = empty($value[16]) ? '' : $value[16];
							$Gateway = empty($value[17]) ? '' : $value[17];

							$array['fnal'][]  = array(
								'Tag' => $Tag,
								'Cardholder Name' => $Cardholder_Name,
								'Card Number' => $Card_Number,
								'Expiry' => $Expiry,
								'Card Type' => $Card_Type,
								'Amount' => $amount,
								'Transaction Type' => $Transaction_Type,
								'Status' => $Status,
								'Auth No' => $Auth_No,
								'Time' => $time,
								'Ref Num' => $Ref_Num,
								'Cust. Ref Num' => $Cust_Ref_Num,
								'Reference 3' => $Reference_3,
								'Account Name' => $Account_Name,
								'Merchant Name' => $Merchant_Name,
								'Merchant Code' =>$Merchant_code,
								'Terminal Name' =>$Terminal_Name,
								'Gateway' => $Gateway
							);
						}

			unset($array['fnal'][0]);


			foreach ($array['fnal'] as  $items) {
				$get = $this->db->query("SELECT * FROM `tb_payeezy_transaction_data` where tag='".$items['Tag']."'");

				if (! (count($get->result()) > 0) ) {
							
					$q = "INSERT INTO `tb_payeezy_transaction_data`
						(
							`tag`,
							`cardholder_name`,
							`card_number`,
							`expiry`,
							`card_type`,
							`amount`,
							`transaction_type`,
							`status`,
							`auth_no`,
							`time`,
							`ref_num`,
							`cust_ref_num`,
							`reference_3`,
							`account_name`,
							`merchant_name`,
							`merchant_code`,
							`terminal_name`,
							`gateway`
						)
						VALUES(
								'".$items['Tag']."',
								'".$items['Cardholder Name']."',
								'".$items['Card Number']."',
								'".$items['Expiry']."',
								'".$items['Card Type']."',
								'".$items['Amount']."',
								'".$items['Transaction Type']."',
								'".$items['Status']."',
								'".$items['Auth No']."',
								'".$items['Time']."',
								'".$items['Ref Num']."',
								'".$items['Cust. Ref Num']."',
								'".$items['Reference 3']."',
								'".$items['Account Name']."',
								'".$items['Merchant Name']."',
								'".$items['Merchant Code']."',
								'".$items['Terminal Name']."',
								'".$items['Gateway']."'
						)";

						$res = $this->db->query($q) or trigger_error($this->db->error, E_USER_ERROR);
				}
			}
		}
	}

	public function bulk_all_reports_receipt_zip(){
		$data											= $this->data;

		$from_date 	= isset($_POST["bulk_receipt_from_date"])  && !empty($_POST["bulk_receipt_from_date"]) ? $_POST["bulk_receipt_from_date"] : '';
		$to_date  	= isset($_POST["bulk_receipt_to_date"])  && !empty($_POST["bulk_receipt_to_date"]) ? $_POST["bulk_receipt_to_date"] : '';
		
		if(isset($from_date) && isset($to_date)){
			$this->load->helper('file');
			$this->load->helper('directory');

			if(strtotime($from_date) == strtotime($to_date)){
				$where  = "WHERE CAST(tb_short_conference_registration_master.date_added as Date) = '$from_date'";
				$where2 = "WHERE 
				COALESCE(
				petd.time, 
				CAST(
					tb_donation_form.date_added AS DATETIME
				)
				) = '$from_date'";
				$where3 = "WHERE CAST(tb_user_memberships.date_purchased as Date) = '$from_date'";
			}else{
				$where  = "WHERE tb_short_conference_registration_master.date_added BETWEEN '$from_date' AND '$to_date'";
				$where2 = "WHERE 
				COALESCE(
				petd.time, 
				CAST(
					tb_donation_form.date_added AS DATETIME
				)
				) BETWEEN '$from_date' AND '$to_date'";
				$where3 = "WHERE tb_user_memberships.date_purchased BETWEEN '$from_date' AND '$to_date'";
			}

			$query = "SELECT tb_short_conference_registration_master.userid as id, '' as receipt_num, '' as Date, 'shortconferencceregistration' as purpose FROM tb_short_conference_registration_master RIGHT JOIN tb_payment_receipts On tb_payment_receipts.table_name = 'tb_short_conference_registration_master' AND tb_payment_receipts.table_id_value = tb_short_conference_registration_master.userid $where";

			$query2 = "SELECT 
			tb_donation_form.id as id, 
			tb_payment_receipts.receipt_number as receipt_num, 
			COALESCE(
			  petd.time, 
			  CAST(
				tb_donation_form.date_added AS DATETIME
			  )
			) as Date, 
			'donation' as purpose 
			FROM 
			tb_donation_form 
			left join tb_all_payments_compiled apc on apc.df_id = tb_donation_form.id 
			LEFT join tb_external_payments ep on ep.id = apc.external_payment_id 
			LEFT join tb_payeezy_transaction_data petd on petd.id = transaction_payeezy_id 
			RIGHT JOIN tb_payment_receipts On tb_payment_receipts.table_name = 'tb_donation_form' 
			AND tb_payment_receipts.table_id_value = tb_donation_form.id 
			AND (
			petd.id is null 
			OR CAST(
				tb_payment_receipts.created_at AS DATE
			) = CAST(petd.time AS DATE)
			) 
			$where2";

			$query3 = "SELECT tb_user_memberships.id as id, '' as receipt_num, '' as Date, 'membershipregistration' as purpose FROM `imi_conf_restore2`.tb_user_memberships RIGHT JOIN `imi_conf_restore2`.tb_users On tb_users.id = tb_user_memberships.user_id $where3";

			$query = $this->db->query($query . ' UNION ALL ' . $query2 . ' UNION ALL ' . $query3);
			// var_dump($this->db->last_query()); die;

			//temp directory path of live and local
			$localhost = array('127.0.0.1', "::1");
			if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
				$path = $_SERVER['DOCUMENT_ROOT'].'/imamiamedicscom/assets/temp-tax-files/';
			} else {
				$path = $_SERVER['DOCUMENT_ROOT'].'/assets/temp-tax-files/';
			}

			// Delete all files before downloading
			$files = directory_map($path);
			foreach($files as $file)
			{ 
				if(is_file($path.$file)){
					unlink($path.$file);
				}
			}
			// For downloading a zip file
			if($query->num_rows() > 0){
				$result = $query->result();
				// echo '<pre>';
				// print_r($result);
				// echo '</pre>';die;
				
				$this->load->library('zip');
				if(isset($result) && !empty($result)){
					
					foreach ($result as $key => $value) {
						$this->receipt($value->id, $value->purpose, $value->receipt_num, $value->Date, true);
					}
					
					$this->zip->read_dir($path, FALSE);
					
					foreach ($result as $key => $value) {
						
						$file_name = 'tax-receipt-' . $value->id . '.pdf';
						$this->zip->archive($path.$file_name);	
					}
			
					$this->zip->download('bulk-receipt.zip');
				}else{
					$data['_messageBundle'] = $this->_messageBundle( 'danger' , "No Receipts Found", 'Error!', true);
				}
			}
			redirect( site_url( $this->data["_directory"] . "controls/view" ) );
		}
	}
}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */