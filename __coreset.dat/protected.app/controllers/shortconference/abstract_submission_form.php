<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abstract_Submission_Form extends C_frontend {

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
		
		$this->_auth_login( FALSE );
		
		
		$this->data													= $this->default_data();
		
		$this->data['_pagetitle']									= lang_line('text_abstractsubmissionform');
		$this->data['h1']											= '';
		
		$this->data['visitor_types']								= $this->queries->fetch_records('visitor_types', " AND status = '1' ORDER BY sort DESC ");
		$this->data['conference_topics']							= $this->queries->fetch_records('conference_topics', " AND status = '1' ORDER BY sort DESC ");
		
		$this->data['arrayindex']									= NumberHelper::number_array( range("2", "8") );
		
		$this->_create_fields_for_form(FALSE, $this->data, array());
		$this->_create_checkbox_for_form(FALSE, $this->data, array() );	
		$this->_create_child_for_form( FALSE, $this->data, array() );
		
		
		
		$this->data['introduction_wordcount'] 						= FALSE;
		$this->data['methods_wordcount'] 							= FALSE;
		$this->data['results_wordcount'] 							= FALSE;
		$this->data['conclusion_wordcount'] 						= FALSE;
	
		
	}
	
	
	public function success(  $conference_slug = ''  )
	{
		$data									= $this->data;
		$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																'for submitting Abstract Submission Form. Out team will cordinate with you in 2-4 hours.', 
																'Thank you');
		
	

		$data['_pageview']			= "global/_blank_page.php";
		$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
	}
	
	
	public function _create_checkbox_for_form( $return_array = false, &$data, $db_data = array() )
	{ 
		#print_r($db_data);
		$empty_inputs				= array("conferencetopics_id", "visitortypes_id");
		
		$filled_inputs				= array("conferencetopics_id", "visitortypes_id");
				
				
		
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
					
					if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					{
						$tmp_empty					= $data[ $empty_inputs[$x] ];
						$tmp_filled					= $db_data[$m][ $filled_inputs[$x] ];
				
						
						if ( array_key_exists ( $tmp_filled, $tmp_empty ) )
						{
							$data[ $empty_inputs[$x] ][ $db_data[$m][ $filled_inputs[$x] ] ]	=  TRUE; #$db_data[$m][ $filled_inputs[$x] ];
							#$data[ $empty_inputs[$x] ][]		= $db_data[$m][ $filled_inputs[$x] ];
							$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
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
				switch ( $empty_inputs[$x]  )
				{
					case "conferencetopics_id":
						$loop_with				= $data['conference_topics'];
						foreach ($loop_with->result_array() as $l )
						{
							$data[ $empty_inputs[$x] ][ $l['id'] ]				= '';
						}
						break;
						
					case "visitortypes_id":
						$loop_with				= $data['visitor_types'];
						foreach ($loop_with->result_array() as $l )
						{
							$data[ $empty_inputs[$x] ][ $l['id'] ]				= '';
						}
						break;
						
					
					default:
						$loop_with				= count($data['arrayindex']);
						for ($i=0; $i <= $loop_with; $i++)
						{
							$data[ $empty_inputs[$x] ][ $i ]				= '';
						}
						break;
				}
				
				
				
				
			}
			
			return $data;
		
		}
	
	}
	
	
	public function _create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{
		#print_r($db_data);
		$empty_inputs				= array("author", "affiliations");
		
		$filled_inputs				= array("author", "affiliations");
				
				
				
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
					
					if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					{
						$data[ $empty_inputs[$x] ][ $m ]	= $db_data[$m][ $filled_inputs[$x] ];
						$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
						
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
				for ($i=0;  $i < count($data['arrayindex']); $i++)
				{
					$data[ $empty_inputs[$x] ][ $i ]				= '';
				}
			}
			
			return $data;
		
		}

	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "userid", "conferenceid", "title", "presenter_speaker", "affiliation", "address", "email", "phone", "introduction", "methods", "results", "conclusion", "keywords", "acknowledgements", "academic_level", "nationality", "passport_number", "regionid", "another_presentation", "accompanied_by_family", "type", "date_added|default_date", "status", "is_paid" );
		
		$filled_inputs				= array( "id", "userid", "conferenceid", "title", "presenter_speaker", "affiliation", "address", "email", "phone", "introduction", "methods", "results", "conclusion", "keywords", "acknowledgements", "academic_level", "nationality", "passport_number", "regionid", "another_presentation", "accompanied_by_family", "type", "date_added", "status", "is_paid" );
		
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

	
	
	public function payment( $conference_slug = '', $abstractformid = '' )
	{ 
	

		$data								= $this->data;
		$data['_pagetitle']					= lang_line('text_abspayment');
		$data['h1']							= lang_line('text_abspayment');
		$data['abstractformid']				= $abstractformid;
		
		
		
		$data['conference']					= $this->queries->fetch_records('conference', " AND slug = '". $conference_slug ."' ");

		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		
		
		
		
		
		
		
		
		$abstract_submission_form						= $this->queries->fetch_records('abstract_submission_form', 
																						" 	AND id = '". $abstractformid ."' 
																							AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																							AND conferenceid = '". $data['conference']->row("id") ."' LIMIT 1 ");
		
		
		
		
		########################################
		$conference_regions								= $this->queries->fetch_records( "conference_regions", " AND id = '". $abstract_submission_form->row("regionid") ."' ");
		########################################

		
		
		if ( $abstract_submission_form -> num_rows() > 0 )
		{
			$data['total_amount']						= total_payment_abstractforms( $abstract_submission_form -> row ("type" ) );
			
			#check if end_date expired or not
			$TMP_end_date								= $this->queries->fetch_records("conference_abstractforms", 
																						" AND conferenceid = '". $data['conference']->row("id") ."'", " end_date " );
			
			
			
			
			$conferenceregistration						= $this->queries->fetch_records('conference_registration_master', 
																						" AND userid = '". $this->functions->_user_logged_in_details( "id" ) . "' 
																						  AND conferenceid = '". $data['conference'] -> row("id") ."' 
																						  AND is_paid = '1' ", " id ");
		
			$data['is_paid']							= TRUE;
			switch ( TRUE )
			{
				case !SessionHelper::_get_session("PAYMENT_TOGGLE_ABS", "site_settings"):
					$message_class				= 'danger_big';
					$message_heading			= "Thanks for submitting your abstract";
					$message_text				= 'Your abstract submission is not complete yet without payment. The payment option on website will open on 16th January. Thanks for your patience and consideration.';
					break;
					
					
					
				
				case !dateexpiredpayment_abstractform( $TMP_end_date ):
					$message_class				= 'danger_big';
					$message_heading			= "Last date expired";
					$message_text				= 'Last date for payment has expired.';
					break;
					
					
				case !$abstract_submission_form ->row("is_complete"):
					$message_class				= 'danger_big';
					$message_heading			= "Form Incomplete";
					$message_text				= 'Your Abstract Submission Form is incomplete.  
													<a href="'. site_url( 'conference/' . $data['conference']->row("slug")  . '/abstract_submission_form/'. 
													$abstract_submission_form ->row("type") . '/' . $abstract_submission_form ->row("id") ) .'">click here</a> 
													to complete your form.';
					break;
					
		
				
				
				#if payment is not by paypal  - and not paid by cash
				case !$abstract_submission_form -> row( "is_paid" ) and
					 $abstract_submission_form -> row( "payment_type" ) != "cash":
				
					$data['is_paid']			= FALSE;
					
					if ( $conferenceregistration->num_rows() > 0 )
					{
						$data['total_amount']	= $data['total_amount'] - 100;
						if ( $data['total_amount'] <= 0 )
						{
							$data['total_amount']				= 0;	
							$data['is_paid']					= TRUE;
							
							
							
							#insert payment status (for conference registration paid)
							$saveData										= array("userid"								=> $this->functions->_user_logged_in_details( "id" ),
																					"conferenceid"							=> $data['conference'] -> row("id"),
																					"abstractformid"						=> $abstractformid,
																					"payer_email"							=> '',
																					"payment_gross"							=> $data['total_amount'],
																					"ipn_track_id"							=> '',
																					"payer_id"								=> '',
																					"payment_status"						=> 'Complete_+_ConferenceRegistrationPaid',
																					"paypal_post"							=> 'Conference Registration Already Paid 
																																- id# ' . $conferenceregistration->row("id"),
																					"date_added"							=> date("Y-m-d H:i:s"));
								
								
							
							$this->queries->SaveDeleteTables($saveData, 's', "tb_abstract_submission_form_payments", 'id'); 
							
							
							
							
							
							#update abstract form id as IS_PAID.
							$saveData										= array("id"									=> $abstractformid,
																					"is_paid "								=> '1'); 
								
							
							
							$this->queries->SaveDeleteTables($saveData, 'e', "tb_abstract_submission_form", 'id'); 
						}
					}
					
					
				
					
					#if payment mode is CASH
					if ( !$conference_regions->row("allow_payment") )
					{
						include_once(APPPATH.'controllers/home.php');
						
						$_POST["item_number"]						= $this->functions->_user_logged_in_details( "id" ); #userid
						$_POST["payer_email"]						= $this->functions->_user_logged_in_details( "email" );
						$_POST["payment_gross"]						= $data['total_amount'];
						$_POST["ipn_track_id"]						= 0;
						$_POST["payer_id"]							= 0;
						$_POST["payment_status"]					= 'Completed';
						
						Home::abstract_form_payment_notify( $conference_slug, $abstractformid, "cash" );
						
						$message_class				= 'success_big';
						$message_heading			= "Abstract Submission Complete";
						$message_text				= $conference_regions->row("paymentdescription_abstract");
						$data['is_paid']			= TRUE;
					}
					else
					{
					
						if ( $data['is_paid'] )
						{
							$message_class				= 'success_big';
							$message_heading			= "Payment done";
							$message_text				= 'You already paid for Conference Registration.';
						}
						else
						{
							$message_class				= 'warning_big';
							$message_heading			= "Please Wait..";
							$message_text				= 'Total amount to be charged: <strong>' . format_price( $data['total_amount'] ) . '</strong><br /><br /> 
															You are being redirect to Payment Page';
						}
					}
					break;
					
					
					
				default:
					$message_class				= 'success_big';
					$message_heading			= "Payment done";
					$message_text				= 'You already paid for this Abstract Submission Form.';
					break;
			}

			
			
			
			$data['h1']									= '';					
			$data['_messageBundle2']					= $this->_messageBundle( $message_class, $message_text, $message_heading);
			$data['_pageview']							= "frontend/abstractsubmissionform/payment.php";
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
		}
		else
		{
			page_error( $data );
			return false;
		}
		
		
		
	}
	
	
	public function index( $conference_slug = '', $type = '', $edit_id = 0 )
	{ 
		$data								= $this->data;
		
		
		$type_dropdown						= DropdownHelper::abstracttype_dropdown( TRUE );
		if ( !array_key_exists( $type, $type_dropdown ) )
		{
			page_error( $data );
			return false;
		}
		
		$data['type_key']					= $type;
		$data['type_text']					= $type_dropdown[ $type ];

		
		
		
		
		$data['conference']						= $this->queries->fetch_records('conference', " AND slug = '". $conference_slug ."' ");
		if ( $data['conference'] -> num_rows() <= 0 )
		{
			page_error( $data );
			return false;
		}
		
		
		if ( !$this->validations->is_numeric($edit_id) )
		{
			$edit_id						= 0;
		}
		
		
		
		
		
		#check if end_date expired or not
		$TMP_end_date				= $this->queries->fetch_records("conference_abstractforms", " AND conferenceid = '". $data['conference']->row("id") ."'", " end_date " );
		$data['enddate_valid']		= dateexpiredpayment_abstractform( $TMP_end_date );
		$lastdate_abstractform		= date("jS F Y", strtotime($TMP_end_date->row("end_date")));
		if ( $data['enddate_valid'] )
		{
			$last_date_alert				= 'Last date for submitting Abstract Submission Form is ' . $lastdate_abstractform;
			$last_date_class				= 'warning';
		}
		else
		{
			//$last_date_alert				= 'Last date ' . $lastdate_abstractform . ' expired for payment';
			
			$last_date_alert 				= "Results of approved abstracts for Poster and Regular Scientific Presentation will be announced soon. Please visit conference website and check your e-mails frequently. ";
			
			$last_date_class				= "success";//'danger';
			
		}
		
		$data['_messageBundle']			= $this->_messageBundle( 	$last_date_class , 
																	$last_date_alert, 
																	'Please note: ');
		
		
		
		
		
		
		

		
		$message_class						= '';
		$conference_registration			= $this->queries->fetch_records('conference_registration', 
																			" AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																			  AND conferenceid = '". $data['conference']->row("id") ."' 
																			  AND parentid = '0'  LIMIT 1 ");
		
		
		
		
		
		/*if ( $conference_registration->num_rows() > 0 )
		{
			$data['total_amount']					= total_payment( $conference_registration );			
			
			$TMP_total_family_registrations			= $conference_registration->row("no_of_family_members_accompanied");
				
			$TMP_family_registered_no				= $this->queries->fetch_records('conference_registration', 
																						" AND parentid = '".  $conference_registration->row("id") ."' ")->num_rows();
	
			switch ( TRUE )
			{
				case $conference_registration->row("accompanied_by_family") == '1' and  $TMP_family_registered_no < $TMP_total_family_registrations:
					$message_class				= 'danger_big';
					$message_heading			= "Registration Incomplete";
					$message_text				= 'Your family registration form is incomplete.  
													<a href="'. site_url( 'conference/' . $data['conference']->row("slug")  . '/register/'. $conference_registration->row("id") ) .'">click here</a> 
													to redirect on <strong>Family Registration</strong> page';
					break;
					
					
					
				case !$conference_registration -> row( "is_paid" ):
					$message_class				= 'danger_big';
					$message_heading			= "Payment Required";
					$message_text				= 'Your registration is complete without payment. 
													Please <a href="'. site_url( 'conference/' . $data['conference']->row("slug")  . '/register/payment/'. $conference_registration->row("id") ) .'">click here</a> 
													to redirect on <strong>Payment Page</strong>';
					break;
					
					
					
				default:
					break;
			}
		}
		else if ( $conference_registration->num_rows() <= 0 )
		{
			$message_class				= 'danger_big';
			$message_heading			= "Registration required";
			$message_text				= 'Please complete your registration first. <a href="'. site_url("conference/" . $data['conference']->row("slug") . "/register") .'">Click here</a> to register for conference';
		}

		if ( $message_class != '' )
		{
			$data['_messageBundle']			= $this->_messageBundle( $message_class, $message_text, $message_heading);
			
			$data['_pageview']				= "global/_blank_page.php";
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
			return false;
		}
		*/
		
		
		
		//$data['h1']								= lang_line('text_abstractsubmissionform') . ' <span style="border-bottom:1px dashed;">(' . $data['type_text'] . ')</span>';
		
		$data['h1']								= 'Abstract Submission Closed <span style="border-bottom:1px dashed;">(' . $data['type_text'] . ')</span>';
		
		$data['conference_registration']		= $conference_registration;
		
		
		

		$is_validate							= TRUE;
		
		if ( $edit_id > 0 )
		{
			$abs_form								= $this->queries->fetch_records("abstract_submission_form", 
																					" AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
																					  AND conferenceid = '". $data['conference']->row("id") ."'
																					  AND type = '". $type ."' 
																					  AND id = '". $edit_id ."' ");
			
		
			
			#FAKE ID - hack attempt
			if ( $abs_form -> num_rows() <= 0 )
			{
				page_error( $data );
				return false;
			}
			
			if ( $abs_form -> num_rows() > 0 and !$this->validations->is_post())
			{
				if ( !$abs_form->row("is_paid") and $abs_form -> row( "payment_type" ) != "cash" )
				{
					
					$edit_details												= $abs_form->row_array();				
					$this->_create_fields_for_form(true, $data, $edit_details );		
					
					$edit_id													= $edit_details["id"];
					$child_details												= $this->queries->fetch_records("abstract_submission_form_conference_topics", " AND parentid = '$edit_id' ");	
					$this->_create_checkbox_for_form(true, $data, $child_details->result_array() );	
					
					
					$child_details												= $this->queries->fetch_records("abstract_submission_form_visitor_types", " AND parentid = '$edit_id' ");		
					$this->_create_checkbox_for_form(true, $data, $child_details->result_array() );	
					
					
					$child_details												= $this->queries->fetch_records("abstract_submission_form_others", " AND parentid = '$edit_id' ");
					$this->_create_child_for_form(true, $data, $child_details->result_array() );	
					
					$is_validate	= FALSE;
					
					
				}
				else
				{
					$message_class				= 'success_big';
					$message_heading			= "Payment done";
					$message_text				= 'You already paid for this Abstract Submission Form.';
					
					$data['_messageBundle']		= $this->_messageBundle( $message_class, $message_text, $message_heading);
					
					$data['_pageview']											= "global/_blank_page.php";
					$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
					return false;
			
				}
			}
		
		
		}
		
		
		
		
		
		#get word count.
		$TMP_wordcount								= array( "introduction", "methods", "results", "conclusion" );
		foreach ($TMP_wordcount as $wc)
		{
			$TMP_length								= str_word_count( set_value( $wc, $data[ $wc ] ) );
			if ( $TMP_length > 0 )
			{
				$data[ $wc . '_wordcount' ] 			= "word count: " . $TMP_length;
			}
		}
				
				
		$data['_pageview']							= "frontend/abstract_submission_form.php";
		
		if ( $is_validate )
		{
			#$this->functions->unite_post_values_form_validation();
		
		
			$is_required				= '|required';
			if ( isset( $_POST["save_x"]  ) ) 
			{
				$is_required			= '';
			}
	
			$this->form_validation->set_rules('id', 'id', 'trim');
			$this->form_validation->set_rules('visitor_type[]', 'Visitor Type(s)', 'trim' . $is_required);
			$this->form_validation->set_rules('conference_topics[]', 'Conference Topic(s)', 'trim' . $is_required);
			$this->form_validation->set_rules('title', 'Title', 'trim' . $is_required);
			$this->form_validation->set_rules('presenter_speaker', 'Poster Presenter/ Speaker', 'trim' . $is_required);
			
			
		
			if ( $this->input->post("affiliations") )
			{
				$arrayindex				= NumberHelper::number_array( range("2", "8") );
				foreach ( $arrayindex as $key => $value )
				{
					$this->form_validation->set_rules('author['. $key .']', NumberHelper::ordinalize( $key ) . ' Author', 'trim');
					$this->form_validation->set_rules('affiliations['. $key .']', NumberHelper::ordinalize( $key ) . ' Affiliation', 'trim');
					
					
						if ( $_POST['author'][$key] != '' and $_POST['affiliations'][$key] == '' )
						{
							$this->form_validation->set_rules('affiliations['. $key .']', NumberHelper::ordinalize( $key ) . ' Affiliation', 'trim' . $is_required);
						}
						
						
						if ( $_POST['affiliations'][$key] != '' and $_POST['author'][$key] == '' )
						{
							$this->form_validation->set_rules('author['. $key .']', NumberHelper::ordinalize( $key ) . ' Author', 'trim' . $is_required);
						}
					
				}
			}
			
			$this->form_validation->set_rules('affiliation', 'Affiliation', 'trim' . $is_required);
			
			
			
			$this->form_validation->set_rules('address', 'Address', 'trim' . $is_required);
			$this->form_validation->set_rules('email', 'Email', 'trim' . $is_required . '|valid_email');
			$this->form_validation->set_rules('phone', 'Phone', 'trim' . $is_required);
			
			
			$this->form_validation->set_rules('introduction', 'Abstract (Introduction)', 'trim'. $is_required .'|max_length[580]');			
			$this->form_validation->set_rules('methods', 'Abstract (Methods)', 'trim' . $is_required . '|max_length[650]');
			$this->form_validation->set_rules('results', 'Abstract (Results)', 'trim'. $is_required .'|max_length[580]');
			$this->form_validation->set_rules('conclusion', 'Abstract (Conclusion)', 'trim'. $is_required.'|max_length[500]');
			
			$this->form_validation->set_rules('abstract_total_characters', 'Abstract Total', 'trim|callback_validate_abstract_form_word_limit['. $is_required .']');
			
			
			

			
			
			
			
			
			$this->form_validation->set_rules('keywords', 'Keywords', 'trim' . $is_required);
			
			
			
			if ( isset( $_POST["save_x"]  ) ) 
			{
			}
			else
			{
				$explode_keywords			= explode(",", $this->input->post("keywords") );
				if ( count($explode_keywords) > 5 )
				{
					$this->form_validation->set_rules('keywords', 'Keywords', 'trim|callback_print_error[Keywords must be less than or equal to 5 words]');		
				}
			}
			
			
			
			
			$this->form_validation->set_rules('acknowledgements', 'Acknowledgements', 'trim' . $is_required);
			$this->form_validation->set_rules('academic_level', 'academic_level', 'trim' . $is_required);
			$this->form_validation->set_rules('nationality', 'Nationality', 'trim' . $is_required);
			$this->form_validation->set_rules('passport_number', 'Passport Number', 'trim' . $is_required);
			
			$this->form_validation->set_rules('regionid', 'Region', 'trim' . $is_required);
			
			
			$this->form_validation->set_rules('another_presentation', 'Present another poster or oral presentation', 'trim' . $is_required);
			$this->form_validation->set_rules('accompanied_by_family', 'Accompanied by your family', 'trim' . $is_required);
			
			
			if ($this->form_validation->run() == FALSE)
			{
				
				#get word count.
				$TMP_wordcount								= array( "introduction", "methods", "results", "conclusion" );
				foreach ($TMP_wordcount as $wc)
				{
					$TMP_length								= str_word_count( set_value( $wc, $data[ $wc ] ) );
					if ( $TMP_length > 0 )
					{
						$data[ $wc . '_wordcount' ] 			= "word count: " . $TMP_length;
					}
				}
		
		
				$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
				
				#$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
				$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
			}
			else
			{
				
				$saveData										= array("userid"						=> $this->functions->_user_logged_in_details( "id" ),
																		"conferenceid"					=> $data['conference']->row("id"),
																		"title"							=> $this->input->post("title"),
																		"presenter_speaker"				=> $this->input->post("presenter_speaker"),
																		"affiliation"					=> $this->input->post("affiliation"),
																		"address"						=> $this->input->post("address"),
																		"email"							=> $this->input->post("email"),
																		"phone"							=> $this->input->post("phone"),
																		"introduction"					=> $this->input->post("introduction"),
																		"methods"						=> $this->input->post("methods"),
																		"results"						=> $this->input->post("results"),
																		"conclusion"					=> $this->input->post("conclusion"),
																		"keywords"						=> $this->input->post("keywords"),
																		"acknowledgements"				=> $this->input->post("acknowledgements"),
																		"academic_level"				=> $this->input->post("academic_level"),
																		"nationality"					=> $this->input->post("nationality"),
																		"passport_number"				=> $this->input->post("passport_number"),
																		"regionid"						=> $this->input->post("regionid"),
																		"another_presentation"			=> $this->input->post("another_presentation"),
																		"accompanied_by_family"			=> $this->input->post("accompanied_by_family"),
																		"date_added"					=> date("Y-m-d H:i:s"),
																		"type"							=> $type,
																		'status'						=> '1',  //status =1  (in review)
																		'is_complete'					=> '0' );
				
				
				
				if ( isset( $_POST["save_x"]  ) ) 
				{
					
				}
				else
				{
					$saveData['is_complete']					= '1';
				}
			
			
			
				if ($this->input->post('id') != "")
				{
					$saveData['id']									= $this->input->post('id');
					$this->queries->SaveDeleteTables($saveData, 'e', "tb_abstract_submission_form", 'id'); 
				}
				else
				{
					
					$this->queries->SaveDeleteTables($saveData, 's', "tb_abstract_submission_form", 'id'); 
					$saveData['id']									= $this->db->insert_id();
				}
			
			
				
				
				
				
				
				$childrecord										= array("parentid"				=> $saveData['id']);
				$this->queries->SaveDeleteTables($childrecord, 'd', "tb_abstract_submission_form_visitor_types", 'parentid');  	
				if ( is_array( $_POST['visitor_type'] ) )
				{
					if ( count($_POST['visitor_type']) > 0 )
					{
						foreach ( $_POST['visitor_type'] as $key => $value)
						{
							if ( $value != "" )
							{
								$childrecord						= array("parentid"				=> $saveData['id'],
																			"visitortypes_id"		=> $value);
								
								$this->queries->SaveDeleteTables($childrecord, 's', "tb_abstract_submission_form_visitor_types", 'parentid');  		
							}
						}
					}
				}
				
				
				
				
				
				
				$childrecord										= array("parentid"				=> $saveData['id']);
				$this->queries->SaveDeleteTables($childrecord, 'd', "tb_abstract_submission_form_conference_topics", 'parentid');  	
				if ( is_array( $_POST['conference_topics'] ) )
				{
					if ( count($_POST['conference_topics']) > 0 )
					{
						foreach ( $_POST['conference_topics'] as $key => $value)
						{
							if ( $value != "" )
							{
								$childrecord						= array("parentid"				=> $saveData['id'],
																			"conferencetopics_id"	=> $value);
								
								$this->queries->SaveDeleteTables($childrecord, 's', "tb_abstract_submission_form_conference_topics", 'parentid');  		
							}
						}
					}
				}
				
				
				
				
				
				
				$childrecord										= array("parentid"				=> $saveData['id']);
				$this->queries->SaveDeleteTables($childrecord, 'd', "tb_abstract_submission_form_others", 'parentid');  	
				if ( is_array( $_POST['author'] ) )
				{
					if ( count($_POST['author']) > 0 )
					{
						foreach ( $_POST['author'] as $key => $value)
						{
							if ( $value != "" )
							{
								
								$childrecord						= array("parentid"					=> $saveData['id'],
																			"author"					=> $_POST[ 'author' ][$key],
																			"affiliations"				=> $_POST[ 'affiliations' ][$key]);
								
								$this->queries->SaveDeleteTables($childrecord, 's', "tb_abstract_submission_form_others", 'parentid');  		
							}
						}
					}
				}
																		
				
				
				
				if ( isset( $_POST["save_x"]  ) ) 
				{
					/*$data['_messageBundle']		= $this->_messageBundle( 	'info' , 
																			'Your Abstract Submission Form is Saved - Edit later and payment.', 
																			'Saved',
																			FALSE, TRUE);*/
					
				
			
			
					redirect( "conference/" . $conference_slug . "/abstract_submission_form/" . $type . '/' . $saveData['id'] );
				}
				else
				{
					#to_admin
					$email_template				= array("email_heading"			=> 'Abstract Submission Form',
														"email_file"			=> "email/frontend/abstract_submission_form.php",
														"email_subject"			=> 'Abstract Submission Form',
														"default_subject"		=> TRUE,
														"email_post"			=> $_POST );
					
					#$is_email_sent				= $this->_send_email( $email_template );
					#to_admin
					
		
					
					redirect( "conference/" . $conference_slug . "/abstract_submission_form/payment/" . $saveData['id']  );
				}
				
				
			}
		}
		else
		{
			
			#$this->form_validation->run();
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
		}
		
		
		
		
	}
	
}