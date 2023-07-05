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
class Joinus extends C_frontend {

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


        if (!$this->session->userdata('user_logged_in')) {
            if ($this->router->method != 'payment_notify') { // PayPal IPN notifications don't have a session with the user logged in.
                $this->_auth_login(false);
            }
        }

		$this->data													= $this->default_data();

		$this->data['_pagetitle']									= lang_line("text_registeryouraccount");
		$this->data['h1']											= lang_line("text_newuserregisterhere");
		$this->load->library('pdf');




    }

	public function activation( $activation_code = '' )
	{
        $data = $this->data;
		$data['_pageview']											= "frontend/joinus.php";

		$data['h1']								= '';
		$data['users']												= $this->imiconf_queries->fetch_records_imiconf('users', ' AND activation_code = "'. $activation_code .'"  ');

		if ( $data['users'] -> num_rows() > 0 )
		{
			if ( $data['users'] -> row("is_active") )
			{
                $data['_messageBundle'] = $this->_messageBundle('success_big',
																		'Your account is already activated.',
																		'Already Activated');

			}
			else
			{


                $data['_messageBundle'] = $this->_messageBundle('success_big',
																		'Your account is now activated. Click here to go on <a href="'. site_url( "memberlogin" ) .'">Login Page</a>',
																		'Account Activated');

			}


            $updateData = array("id" => $data['users']->row("id"),
												"is_active"				=> 1,
												"activation_code"		=> '');


            $this->queries->SaveDeleteTables_imiconf($updateData, 'e', "tb_users", 'id');

			$data['_pageview']						= "global/_blank_page.php";
			$this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );
		}
		else
		{
			page_error( $data );
			return false;
		}

    }


	public function index()
    {
        ~r(debug_backtrace()); // Shabbir, 2/16/18: I believe this is unused now so breaking it.

        $data = $this->data;
		$data['_pageview']											= "frontend/joinus.php";

		$this->functions->unite_post_values_form_validation();

		$this->form_validation->set_rules('first-name', 'first-name', 'trim|required');
		$this->form_validation->set_rules('last-name', 'last-name', 'trim|required');
		$this->form_validation->set_rules('middle-name', 'middle-name', 'trim|required');

		$tmp_validate_DB			= $this->imiconf_queries->fetch_records_imiconf("users", " AND email = '". $this->input->post("email") ."' ");
		$tmp_validate_VALUES		= $this->find_duplicate_values($tmp_validate_DB, $this->input->post("id"));

        $this->form_validation->set_rules('email', 'Email', "trim|required|valid_email|callback_validate_duplicate[" . $tmp_validate_VALUES . "]");

		$this->form_validation->set_rules('spaciality', 'spaciality', 'trim|required');

		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'cpassword', 'trim|required|matches[password]');

		$this->form_validation->set_rules('address', 'address', 'trim|required');

		$this->form_validation->set_rules('city', 'member-city', 'trim|required');
		$this->form_validation->set_rules('state', 'member-state', 'trim|required');

		$this->form_validation->set_rules('home_country', 'home-country', 'trim|required');
		$this->form_validation->set_rules('zip-code', 'member-zip-code', 'trim|required');

		$this->form_validation->set_rules('contact-home', 'home-contact', 'trim|required');
		$this->form_validation->set_rules('cell', 'member-cell', 'trim|required');

		$this->form_validation->set_rules('company-name', 'company-name', 'trim|required');
		$this->form_validation->set_rules('title', 'title', 'trim|required');

		$this->form_validation->set_rules('office-address', 'office-address', 'trim|required');
		$this->form_validation->set_rules('personal-city', 'city', 'trim|required');

		$this->form_validation->set_rules('personal-state', 'personal-state', 'trim|required');
		$this->form_validation->set_rules('office_country', 'office-country', 'trim|required');

        $this->form_validation->set_rules('personal-zip-code', 'personal-zipcode', 'trim|required');
		$this->form_validation->set_rules('office-fax', 'office-fax', 'trim|required');

        $this->form_validation->set_rules('office-phone', 'office-phone', 'trim|required');
		$this->form_validation->set_rules('prefered-office-address', 'office-address', 'trim|required');

		$this->form_validation->set_rules('prefered-phone', 'preffered-phone', 'trim|required');
		$this->form_validation->set_rules('membership', 'membership', 'trim|required');


		$this->form_validation->set_rules('signature', 'signature', 'trim|required');
		$this->form_validation->set_rules('date', 'date', 'trim|required');

		$this->form_validation->set_rules('payment-type', 'payment-type', 'trim|required');

		if($this->input->post('payment-type')!="paypal")
		{
			$this->form_validation->set_rules('card-number', 'card-number', 'trim|required');
			$this->form_validation->set_rules('month', 'month', 'trim|required');
			$this->form_validation->set_rules('expiration', 'expiration', 'trim|required');

			$this->form_validation->set_rules('ccv', 'ccv', 'trim|required');
		}
		$this->form_validation->set_rules('enroll', 'enroll', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{

			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');

			#$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );
		}
		else
		{
			$craditCard							= "";
			$preferdNo							= "";
			$Country							= "";
			$craditCard							= $this->input->post("card-number");


            $preferedAddress = $this->input->post("prefered-office-address");
			if( $preferedAddress == "Home" )
			{
				$tmp_countries					= $this->imiconf_queries->fetch_records_imiconf("countries", " AND id = '". $this->input->post("home_country") ."' ")->result()[0];
				$Country						= $tmp_countries->countries_iso_code_2;
			}
			else
			{
				$tmp_countries					= $this->imiconf_queries->fetch_records_imiconf("countries", " AND id = '". $this->input->post("office_country") ."' ")->result()[0];
				$Country						= $tmp_countries->countries_iso_code_2;
			}

			// print_r($tmp_countries);

			$preferedPhone						= $this->input->post("prefered-phone");


            if ($preferedPhone == "Office")
			{
				$preferdNo						= $this->input->post("office-phone");
			}
			else if($preferedPhone=="Home")
			{
				$preferdNo						= $this->input->post("contact-home");
			}
			else
			{
				$preferdNo						= $this->input->post("cell");
			}

			//echo "country=".$Country."prferedPhone=".$preferdNo; die;

			$this->load->library("Encrption");

			$insertData					= array	(
													"name"					=> $this->input->post("first-name"),
													"middle_name"			=> $this->input->post("middle-name"),
													"last_name"				=> $this->input->post("last-name"),
													"email"			        => $this->input->post("email"),
													"password"				=> $this->encrption->encrypt( $this->input->post("password") ),
													"registration_site"		=> SITE_CODE,
													"activation_code"		=> random_string('alnum', 20),
													"date_added"			=> date("Y-m-d H:i:s"),
													"address"				=> $this->input->post("address")
												);

            $this->imiconf_queries->SaveDeleteTables_imiconf($insertData, 's', "tb_users", 'id');


            $userid = $this->db_imiconf->insert_id();


			$personal_information   = array("userid"                =>$userid,
											"specialties"			=> $this->input->post("spaciality"),
											"home_full_address"     => $this->input->post("address"),
											"home_city"				=> $this->input->post("city"),
											"home_state_province"	=> $this->input->post("state"),
											"home_country"			=> $this->input->post("home_country"),
											"home_zipcode"			=> $this->input->post("zip-code"),
											"home_phone_number"		=> $this->input->post("contact-home"),
											"cellphone_number"		=> $this->input->post("cell"),
											"company_name"			=> $this->input->post("company-name"),
											"title"			        => $this->input->post("title"),
											"office_full_address"	=> $this->input->post("office-address"),
											"office_city"			=> $this->input->post("personal-city"),
											"office_state_province"	=> $this->input->post("personal-state"),
											"office_country"		=> $this->input->post("office_country"),
											"office_zip_code"		=> $this->input->post("personal-zip-code"),
											"office_phone_number"	=> $this->input->post("office-phone"),
											"office_fax_number"		=> $this->input->post("office-fax"),
											"prefered_mode_address" => $this->input->post("prefered-office-address"),
											"preffered_mode_of_contact"	=> $this->input->post("prefered-phone"),
											"membership"			=> $this->input->post("membership"),
											"donation"				=> $this->input->post("donation"),
											"payment_type"			=> $this->input->post("payment-type"),
											"cardit_card_number"	=>$this->encrption->encrypt($this->input->post("card-number")),
											"exiration"				=> $this->input->post('month').$this->input->post("expiration"),
											"ccv"				    => $this->input->post("ccv"),
											"enroll"			    => $this->input->post("enroll"),
											"signature"				=> $this->input->post("signature"),
											"date_added"			=> date('Y-m-d',strtotime($this->input->post("date")))
											);


            $this->imiconf_queries->SaveDeleteTables_imiconf($personal_information, 's', " tb_users_profile", 'id');

            $_POST['activation_link'] = site_url("register/activation/" . $insertData['activation_code']);
			$email_template				= array("email_to"				=> $useremail,
										"email_heading"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
										"email_file"			=> "email/frontend/user_activation_code.php",
										"email_subject"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
										"default_subject"		=> TRUE,
										"email_post"			=> $_POST );


            $is_email_sent = $this->_send_email($email_template);


            $membership_name = "";

			$_donation					= "";

			if($this->input->post("membership")=="Associate Member(non-healthcare profesionals/Community Member)$25.00/Y")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 25;
			}
			else if($this->input->post("membership")=="Resident fellow/Alied heath professionl( Pharmacist, Nurse, Technician, etc )$75.00/Y")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 75;
			}
			else if($this->input->post("membership")=="Medical Professionals ( MD, DO, PhD, Dentist )$150.00/Y")
			{

				$membership_name		= $this->input->post("membership");
				$membership_amount		= 150;

            } else if ($this->input->post("membership") == "Family membership for non-healthcare profesionals( MD, DO, PhD, Dentist )$75.00/Y")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 75;
            } else if ($this->input->post("membership") == "Family with 1 Medical Professional ( MD, DO, PhD, Dentist )$200.00/Y")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 200;

            } else if ($this->input->post("membership") == "Family with 2 Medical Professionals ( MD, DO, PhD, Dentist )$250.00/Y")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 250;
			}
			else if($this->input->post("membership")=="Life Membership ( MD, DO, PhD, Dentist )$1500.00")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 1500;
			}
			else if($this->input->post("membership")=="Life Membership ( non-physician )$750.00")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 750;

			}
			else if($this->input->post("membership")=="Student $25.00/Y")
			{
				$membership_name		= $this->input->post("membership");
				$membership_amount		= 25;
			}

			if($this->input->post("donation")!="")
			{
				$_donation				= "Donation";
				$donation_amount		= $this->input->post("donation");
			}
			else
			{
				$_donation				= "Donation";
				$donation_amount		= 0;
			}

			$totalAmount				= $donation_amount+$membership_amount;

			/*
			$getPaypal = $this->queries->fetch_records('site_settings_master')->result()[0];

			$paypal_mode = $getPaypal->paypal_mode;

			if ( $paypal_mode == CONS_TRUE ) {

			$paypal_url = $getPaypal->paypal_url_live;
			$paypal_email = $getPaypal->paypal_email_live;

			}else{

			$paypal_url = $getPaypal->paypal_url_sandbox;
			$paypal_email = $getPaypal->paypal_email_sandbox;
			}

			*/

			$paypal_url						= $this->payment->paypal_form_details() -> url;
			$paypal_email					= $this->payment->paypal_form_details() -> business_email;

			//     $amount="&amount=".$totalAmount;


            //	$this->imiconf_queries->SaveDeleteTables_imiconf(array("id" => $userid), 'd', "tb_users", 'id');


            ~r(array_reverse(get_defined_vars()));
			$TMP_array			= array("business"		=>  $paypal_email,
										"cmd"			=> "_cart",
										"item_name_1"   => $membership_name,
										"amount_1"		=> $membership_amount,
										"item_name_2"	=> $_donation,
										"amount_2"      => $donation_amount,
										"currency_code" => "USD",
										"upload"		=> 1,
										"return_url"    => site_url('resgister/success/'.$userid.'/'),
                "cancel_url" => site_url('register/cancel/')
								);

            $paypal_url .= "?";
			foreach ($TMP_array as $k => $v)
			{
				$paypal_url 		.= $k . '=' . $v . '&';
			}

            $paypal_url = substr($paypal_url, 0, strlen($paypal_url) - 1);

            if ($this->input->post('payment-type') == "paypal")
			{
                ~r($TMP_array);
				redirect($paypal_url);
			}
			else
			{
				$this->doPayment($insertData,$personal_information,$membership_amount,$totalAmount,$membership_name,$donation_amount,$craditCard,$preferdNo,$Country);
            }
        }
    }

    /**
     * PayPal redirects here after successful payment. PayPal is supposed to redirect here with PDT data but seems to be redirecting here with IPN data for some reason.
     */
	public function success($userid){

        $user_from_db = $this->db_imiconf->query(<<<EOQ
select * from tb_users where id = ?
EOQ
            ,
            array(
                $userid,
            )
        )->row_array();
        if (!$user_from_db) {
            ~rt(debug_backtrace());
        }
		$ipn_verifier = new \apih\PayPal\IPN();

		if ( !SessionHelper::_get_session("PAYPAL_MODE", "site_settings") ){
			$ipn_verifier->useSsl(false);
		}

        $ipn_verifier->useSandbox(!SessionHelper::_get_session("PAYPAL_MODE", "site_settings"));
        $ipn_data = $ipn_verifier->process($_POST);
        if (!$ipn_data) {
			log_message('info', sprintf('PayPal IPN not received IPN Data: %s', var_export($_POST, true)));
			// $raw_post_data  = file_get_contents('php://input');
			// $raw_post_array = explode('&', $raw_post_data);
			// $myPost         = array();
			// foreach ($raw_post_array as $keyval) {
			// 	$keyval = explode('=', $keyval);
			// 	if (count($keyval) == 2)
			// 		$myPost[$keyval[0]] = urldecode($keyval[1]);
			// }
			// // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
			// $req = 'cmd=_notify-validate';
			// if (function_exists('get_magic_quotes_gpc')) {
			// 	$get_magic_quotes_exists = true;
			// }
			// foreach ($myPost as $key => $value) {
			// 	if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
			// 		$value = urlencode(stripslashes($value));
			// 	} else {
			// 		$value = urlencode($value);
			// 	}
			// 	$req .= "&$key=$value";
			// }
			// log_message('error', "IPN DATA: " . $req);
			//~rt(debug_backtrace());
        } else {
			log_message('info', sprintf('PayPal IPN received IPN Data: %s', var_export($ipn_data, true)));
		}
        unset($ipn_verifier);

        $membership_id_from_paypal = json_decode($ipn_data['custom'], true)['membership'];
		if (!$ipn_data && !$membership_id_from_paypal) {
			$membership_id_from_paypal = json_decode($_GET['cm'], true)['membership'];
        }
        /** @var CI_DB_mysqli_driver $conference_db */
        $conference_db = $this->load->database('imiconf', true);
        $conference_db->initialize();

        $chosen_membership = $conference_db->query('SELECT * FROM tb_conference_prices_not_a_member WHERE conferenceid IS NULL AND id = ?', array($membership_id_from_paypal))->row_array();
        if (!$chosen_membership) {
			die("membership not exists: ".$membership_id_from_paypal);
            //~r($chosen_membership);
        }
        unset($membership_id_from_paypal);

        // if (
        //     ($chosen_membership['name'] != $ipn_data['item_name1']) ||
        //     ($chosen_membership['price'] != $ipn_data['mc_gross_1']) ||
        //     false
        // ) {
		// 	die("membership not correct");
        //     //~r($chosen_membership, $ipn_data);
		// }

		$membership_start_date = date('Y-m-d h:i:s');
		$membership_end_date = "9999-12-31 00:00:00";

		if ( strtolower($chosen_membership['per']) == "year" || strtolower($chosen_membership['per']) == 'yearly' ){
			$user_memberships = $this->imiconf_queries->fetch_records_imiconf("user_memberships", " AND user_id = '  $userid' AND member_expiry IS NOT NULL ORDER BY id DESC LIMIT 1");

			$membership_end_date = date('Y-m-d h:i:s', strtotime("+1 year", strtotime($membership_start_date)));

			if ($user_memberships->num_rows() > 0) {

				if ( $user_memberships->row()->member_expiry > strtotime('+6 years') ){
					$membership_start_date = date('Y-m-d h:i:s');
				}else{
					$member_expiry = strtotime($user_memberships->row()->member_expiry);
					$membership_start_date = date('Y-m-d h:i:s', $member_expiry);
				}

				
			}
		}

        $conference_db->query(<<<EOQ
insert into tb_user_memberships(user_id, membership_package_id, date_purchased, member_expiry , membership_package_name, membership_package_price, membership_package_per, paypal_payer_email, paypal_payment_gross, paypal_ipn_track_id, paypal_payer_id, paypal_payment_status, paypal_post) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
EOQ
            ,
            array(
                $userid,
				$chosen_membership['id'],
				$membership_start_date,
				$membership_end_date,
                $chosen_membership['name'],
                $chosen_membership['price'],
                $chosen_membership['per'],
                isset($ipn_data['payer_email']) ? $ipn_data['payer_email'] : null,
                isset($ipn_data['payment_gross']) ? $ipn_data['payment_gross'] : $_GET['amt'],
                isset($ipn_data['ipn_track_id']) ? $ipn_data['ipn_track_id'] : null,
                isset($ipn_data['payer_id']) ? $ipn_data['payer_id'] : null,
                isset($ipn_data['payment_status']) ? $ipn_data['payment_status'] : $_GET['st'],
                !empty($ipn_data) ? serialize($ipn_data) : serialize($_GET)
            )
        );

        $data = $this->data;
		$data['_pageview']											= "frontend/register.php";

        $saveData['id'] = $userid;
				$saveData['ispaid']=1;

        $this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_users", 'id');

        if ($user_from_db['is_paid_membership_approved'] == 0) { // 0 = pending, 1 = approved, -1 = rejected
			
			$profile_data											= $this->imiconf_queries->fetch_records_imiconf('users_profile', ' AND userid= "' . $user_from_db['id'] . '"');
			$home_country = $profile_data->row()->home_country;
			if ( NULL != $home_country && $home_country != 0 ){
				$__where = " and ( roleid = 4 or countryid is NULL or countryid LIKE '%".$profile_data->row()->home_country."%' ) ";
			}else{
				$__where = "";
			}
			$admins = $this->queries->fetch_records("admin",$__where,"email");
			$admin_emails = array();

			if ( $admins->num_rows() > 0 ){
				foreach ($admins->result() as $key => $value) {
					$admin_emails[] = $value->email;
				}
			}
			
			$_finance = array('RomeenaIMI@Gmail.com');
			// $_TO_EMAILS = array_merge($_finance,$this->getAdminEmailsArray(),$admin_emails);
			
			$this->_send_email(array(
                "email_to" => $_finance,
                "email_heading" => 'New Paid IMI member is now waiting for approval.',
                "email_file" => "email/frontend/paid_member_pending_approval.php",
                "email_subject" => 'New Paid IMI member is now waiting for approval.',
                "default_subject" => TRUE,
                "email_post" => array(
                    'user name' => self::user_row_to_displayable_name($user_from_db),
                    'email address' => $user_from_db['email'],
                    'amount' => $chosen_membership['price'],
                    'package' => $chosen_membership['name'],
                    'address_name' => $ipn_data['address_name'],
                    'address_street' => $ipn_data['address_street'],
                    'address_city' => $ipn_data['address_city'],
                    'address_state' => $ipn_data['address_state'],
                    'address_country_code' => $ipn_data['address_country_code'],
                    'address_zip' => $ipn_data['address_zip'],
                ),
                'email_from' => 'noreply@imamiamedics.com',
            ));
            $string_template_engine = new \StringTemplate\Engine;
			
			$_finance = array('Imifinance786@gmail.com','sakinarizviimi@gmail.com','imiwaiting@att.net','rida.fatima@genetechsolutions.com','imihq@imamiamedics.com');
            // $_BCCUSER_EMAILS = array_merge($_finance,$admin_emails);

			$this->email(array(
                'to' => array(
                    $user_from_db['email'],
                ),
                'bcc' => $_finance,
                'message' => nl2br($string_template_engine->render(<<<EOD
Hi {user name},

Your paid IMI membership is now pending approval. You will be notified once it has been approved.

Thanks,
IMI Team.
EOD
                    , array(
                        'user name' => self::user_row_to_displayable_name($user_from_db),
                    ))),
                'subject' => 'Your Paid IMI member is now pending approval.',
                'from' => 'noreply@imamiamedics.com',
            ));
        }


		# line added because data required for auto-receipt.
		$load_membership = $this->imiconf_queries->fetch_records_imiconf("user_memberships", " AND user_id = '$userid' ORDER BY id DESC LIMIT 1");
		
		// create tax receipt pdf and send it to user.
		self::send_tax_receipt_members($load_membership->row()->id, $this);

        $data['_messageBundle'] = $this->_messageBundle('success_big',
            "Thank you for the payment. Your IMI membership is now pending approval. You will be notified once your membership is approved.",
																	lang_line("heading_operation_success"));


        $data['h1'] = '';
			$data['_pageview']						= "global/_blank_page.php";

			$this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );
	}

    /**
     * PayPal redirects here if user cancels payment on PayPal
     */
	public function cancel(){

//        ~r(debug_backtrace());

        $data = $this->data;
		$data['_pageview']											= "frontend/register.php";


        $data['_messageBundle'] = $this->_messageBundle('danger_big', "You have cancelled the Paypal Payment Process.", "Process Cancelled");

				$data['h1']								= '';
				$data['_pageview']						= "global/_blank_page.php";

				 $this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );

    }

    function doPayment($insertData, $personal_information, $membership_amount, $totalAmount, $membership_name, $donation_amount, $craditCard, $preferdNo, $Country)
    {


        $DPFields = array(
							'paymentaction' => 'Sale', 						// How you want to obtain payment.  Authorization indidicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
							'ipaddress' => $_SERVER['REMOTE_ADDR'], 							// Required.  IP address of the payer's browser.
							'returnfmfdetails' => '1' 					// Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
						);

        $CCDetails = array(
							'creditcardtype' => $personal_information['payment_type'], 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
            'acct' => $craditCard,                                // Required.  Credit card number.  No spaces or punctuation.
							'expdate' => $personal_information['exiration'], 							// Required.  Credit card expiration date.  Format is MMYYYY
							'cvv2' => $personal_information['ccv'], 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
							'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
							'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
						);


        $PayerInfo = array(
							'email' => $insertData['email'], 								// Email address of payer.
							'payerid' => '', 							// Unique PayPal customer ID for payer.
							'payerstatus' => '', 						// Status of payer.  Values are verified or unverified
							'business' => 'Testers, LLC' 							// Payer's business name.
						);

        $PayerName = array(
							'salutation' => 'Mr\Mrs', 						// Payer's salutation.  20 char max.
							'firstname' => $insertData['name'], 							// Payer's first name.  25 char max.
							'middlename' => $insertData['middle_name'], 						// Payer's middle name.  25 char max.
							'lastname' => $insertData['last_name'] , 							// Payer's last name.  25 char max.
							'suffix' => ''								// Payer's suffix.  12 char max.
						);


        if ($personal_information['prefered_mode_address'] == "Home")
	 	{

		$BillingAddress = array(
								'street' => $personal_information['home_full_address'], 						// Required.  First street address.
								'street2' => '', 						// Second street address.
								'city' => $personal_information['home_city'], 							// Required.  Name of City.
								'state' => $personal_information['home_state_province'], 							// Required. Name of State or Province.
								'countrycode' => $Country, 					// Required.  Country code.
								'zip' => $personal_information['home_zipcode'], 							// Required.  Postal code of payer.
								'phonenum' => $preferdNo 						// Phone Number of payer.  20 char max.
							);

            $ShippingAddress = array(
								'shiptoname' => 'Mr.'.$insertData['name'].' '.$insertData['middle_name'].' '.$insertData['last_name'], 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
								'shiptostreet' => $personal_information['home_full_address'], 					// Required if shipping is included.  First street address.  100 char max.
								'shiptostreet2' => '', 					// Second street address.  100 char max.
								'shiptocity' => $personal_information['home_city'], 					// Required if shipping is included.  Name of city.  40 char max.
								'shiptostate' => $personal_information['home_state_province'], 					// Required if shipping is included.  Name of state or province.  40 char max.
								'shiptozip' => $personal_information['home_zipcode'], 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
								'shiptocountry' => $Country, 					// Required if shipping is included.  Country code of shipping address.  2 char max.
								'shiptophonenum' =>$preferdNo					// Phone number for shipping address.  20 char max.
								);

        } else {

		       $BillingAddress = array(
										'street' => $personal_information['office_full_address'], 						// Required.  First street address.
										'street2' => '', 						// Second street address.
										'city' => $personal_information['office_city'], 							// Required.  Name of City.
										'state' => $personal_information['office_state_province'], 							// Required. Name of State or Province.
										'countrycode' => $Country, 					// Required.  Country code.
										'zip' => $personal_information['office_zip_code'], 							// Required.  Postal code of payer.
										'phonenum' => $preferdNo 						// Phone Number of payer.  20 char max.
									);


            $ShippingAddress = array(
										'shiptoname' => 'Mr\Mrs.'.$insertData['name'].' '.$insertData['middle_name'].' '.$insertData['last_name'], 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
										'shiptostreet' => $personal_information['office_full_address'], 					// Required if shipping is included.  First street address.  100 char max.
										'shiptostreet2' => '', 					// Second street address.  100 char max.
										'shiptocity' => $personal_information['office_city'], 					// Required if shipping is included.  Name of city.  40 char max.
										'shiptostate' => $personal_information['office_state_province'], 					// Required if shipping is included.  Name of state or province.  40 char max.
										'shiptozip' => $personal_information['office_zip_code'], 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
										'shiptocountry' => $Country, 					// Required if shipping is included.  Country code of shipping address.  2 char max.
										'shiptophonenum' => $preferdNo 					// Phone number for shipping address.  20 char max.
										);
		}

		$PaymentDetails = array(
            'amt' => $totalAmount,                            // Required.  Total amount of order, including shipping, handling, and tax.
								'currencycode' => 'USD', 					// Required.  Three-letter currency code.  Default is USD.
								'itemamt' => $totalAmount, 						// Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
								'shippingamt' => '', 					// Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
            'shipdiscamt' => '',                    // Shipping discount for the order, specified as a negative number.
								'handlingamt' => '', 					// Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
            'taxamt' => '',                        // Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax.
								'desc' => 'Web Order', 							// Description of the order the customer is purchasing.  127 char max.
								'custom' => '', 						// Free-form field for your own use.  256 char max.
								'invnum' => '', 						// Your own invoice or tracking number
								'notifyurl' => ''						// URL for receiving Instant Payment Notifications.  This overrides what your profile is set to use.
        );

		$OrderItems = array();
		$Item	 = array(
							'l_name' => $membership_name, 						// Item Name.  127 char max.
							'l_desc' => 'The best test widget on the planet!', 						// Item description.  127 char max.
							'l_amt' => $membership_amount, 							// Cost of individual item.
							'l_number' => '', 						// Item Number.  127 char max.
            'l_qty' => '1',                            // Item quantity.  Must be any positive integer.
							'l_taxamt' => '', 						// Item's sales tax amount.
							'l_ebayitemnumber' => '', 				// eBay auction number of item.
							'l_ebayitemauctiontxnid' => '', 		// eBay transaction ID of purchased item.
							'l_ebayitemorderid' => '' 				// eBay order ID for the item.
					);
		$Item2	 = array(
							'l_name' =>'Donation', 						// Item Name.  127 char max.
							'l_desc' => 'The best test widget on the planet!', 						// Item description.  127 char max.
							'l_amt' =>  $donation_amount, 							// Cost of individual item.
							'l_number' => '', 						// Item Number.  127 char max.
            'l_qty' => '1',                            // Item quantity.  Must be any positive integer.
							'l_taxamt' => '', 						// Item's sales tax amount.
							'l_ebayitemnumber' => '', 				// eBay auction number of item.
							'l_ebayitemauctiontxnid' => '', 		// eBay transaction ID of purchased item.
							'l_ebayitemorderid' => '' 				// eBay order ID for the item.
					);
		array_push($OrderItems, $Item,$Item2);

        $Secure3D = array(
            'authstatus3d' => '',
            'mpivendor3ds' => '',
            'cavv' => '',
            'eci3ds' => '',
						  'xid' => ''
						  );

        $PayPalRequestData = array(
            'DPFields' => $DPFields,
            'CCDetails' => $CCDetails,
            'PayerInfo' => $PayerInfo,
            'PayerName' => $PayerName,
            'BillingAddress' => $BillingAddress,
            'ShippingAddress' => $ShippingAddress,
            'PaymentDetails' => $PaymentDetails,
            'OrderItems' => $OrderItems,
								'Secure3D' => $Secure3D
							);


        $PayPalResult = $this->paypal_pro->DoDirectPayment($PayPalRequestData);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$error="";
			$error=$PayPalResult['L_LONGMESSAGE0'];


            $data = $this->data;
		$data['_pageview']											= "frontend/repayment.php";

            $data['_messageBundle'] = $this->_messageBundle('danger', "Registered successfull Payment failed pay now:" . $error);


        $useremail=$PayPalResult['REQUESTDATA']['EMAIL'];
	    $saveData['email']=$useremail;
	    $data['email']=$useremail;

            //	$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'd', "tb_users", 'email');




				$data['h1']								= '';

		       $this->load->view(FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );
		}
		else
		{


            if ($PayPalResult['ACK'] == "SuccessWithWarning") {

                $data = $this->data;
                //$data=array();
		 $data['_pageview']											= "frontend/joinus.php";


                $useremail = $PayPalResult['REQUESTDATA']['EMAIL'];

                $saveData['email'] = $useremail;
				$saveData['ispaid']=1;

                $this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_users", 'email');


                $_POST['activation_link'] = site_url("register/activation/" . $insertData['activation_code']);
			$email_template				= array("email_to"				=> $useremail,
												"email_heading"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
												"email_file"			=> "email/frontend/user_activation_code.php",
												"email_subject"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
												"default_subject"		=> TRUE,
												"email_post"			=> $_POST );


                $is_email_sent = $this->_send_email($email_template);


                $data['_messageBundle'] = $this->_messageBundle('success_big',
                    lang_line("text_thankyou_for_register"),
																	lang_line("heading_operation_success"));


                $data['h1'] = '';
			$data['_pageview']						= "global/_blank_page.php";

			$this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );
        }

        if($PayPalResult['ACK']=="Success"){


            $data = $this->data;

            // $data=array();

		 $data['_pageview']											= "frontend/joinus.php";


            $useremail = $PayPalResult['REQUESTDATA']['EMAIL'];

            $saveData['email'] = $useremail;
				$saveData['ispaid']=1;

            $this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_users", 'email');


            $data['_messageBundle'] = $this->_messageBundle('success_big',
                lang_line("text_thankyou_for_register"),
																	lang_line("heading_operation_success"));


            $data['h1'] = '';
			$data['_pageview']						= "global/_blank_page.php";

			$this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );


        }

        }

	}

    /**
     * The membership options/payment form is submitted to this
     */
	function pay(){

        $data = $this->data;
		$data['_pageview']											= "frontend/repayment.php";

        $this->form_validation->set_rules('payment-type', 'payment-type', 'trim|required');
        $this->form_validation->set_rules('donation', 'decimal');
        $this->form_validation->set_rules('membership', 'required|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			#$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );

        }
		else
		{
            if ($this->input->post('payment-type') != "paypal") {
                ~r($this->input->post('payment-type'));
            }

            $userid = $this->session->userdata('user_logged_details')['id'];

            /** @var CI_DB_mysqli_driver $conference_db */
            $conference_db = $this->load->database('imiconf', true);
            $conference_db->initialize();

            $conference_db->query('INSERT INTO tb_users_profile(userid) VALUES (?) ON DUPLICATE KEY UPDATE userid = userid', array($userid)); // ensure the record, that we are updating below, exists

            $this->imiconf_queries->SaveDeleteTables_imiconf(
                array(
                    "userid" => $userid,
                    "payment_type" => $this->input->post("payment-type"),
                ),
                'e',
                "tb_users_profile",
                'userid'
            );

            $chosen_membership = $conference_db->query('SELECT * FROM tb_conference_prices_not_a_member WHERE conferenceid IS NULL AND id = ?', array($this->input->post("membership")))->row_array();
            if (!$chosen_membership) {
                ~r($chosen_membership);
            }

            $donation = $this->input->post("donation");

            if ($donation != "") {
                $donation_amount = $donation;
            } else {
                $donation_amount = 0;
            }

			$paypal_url						= $this->payment->paypal_form_details() -> url;
			$paypal_email					= $this->payment->paypal_form_details() -> business_email;

//			~r($this->payment->paypal_form_details(), array_reverse(get_defined_vars()));

            //            ~r(array_reverse(get_defined_vars()));

            $paypal_url .= "?";
            foreach (
                array(
                    "business" => $paypal_email,
                    "cmd" => "_cart",
                    "item_name_1" => $chosen_membership['name'],
                    "amount_1" => $chosen_membership['price'],
                    "item_name_2" => "Donation",
                    "amount_2" => $donation_amount,
                    "currency_code" => "USD",
                    "upload" => 1,
                    "return" => site_url('joinus/success/' . $userid . '/'),
                    "cancel_return" => site_url('joinus/cancel/'),
                    "notify_url" => site_url('joinus/payment_notify/' . $userid . '/'),
                    'rm' => 2,
                    'custom' => json_encode(array(
                        'membership' => $chosen_membership['id'],
                    )),
                )
                as
                $k => $v)
			{
				$paypal_url 		.= $k . '=' . $v . '&';
			}

            $paypal_url = substr($paypal_url, 0, strlen($paypal_url) - 1);


            if ($this->input->post('payment-type') == "paypal")
			{
//                ~r($TMP_array);
//			    ~r($TMP_array['return_url']);
				redirect($paypal_url);
			}
			else
			{
                ~r($this->input->post('payment-type'));
			}

        }
	}


    /**
     * Displays the membership options/payment form.
     */
   function payment($id)
   {

       $data = $this->data;
		$data['_pageview']										= "frontend/repayment.php";

       /** @var CI_DB_mysqli_driver $conference_db */
       $conference_db = $this->load->database('imiconf', true);
       /** @var CI_DB_mysqli_result $membership_options_result */
       $membership_options_result = $conference_db->query("
SELECT
mcl.name AS classification_name,
  p.id,
  p.name,
  p.price,
  p.per
FROM
  tb_membership_classification c LEFT JOIN tb_conference_prices_not_a_member p ON c.id = p.membership_classification_id
  	JOIN tb_membership_classification_languages mcl ON mcl.membership_classification_id = c.id 
	JOIN imiportal_2.tb_content_languages l ON mcl.content_languages_id=l.id
	WHERE p.conferenceid IS NULL AND l.code='".SessionHelper::_get_session('LANG_CODE')."'
	ORDER BY c.sort_order, p.sort
"
       );
       $membership_packages = $membership_options_result->result_array();
       $membership_packages_by_classification = _group_by($membership_packages, 'classification_name');
       $data['membership_packages_by_classification'] = $membership_packages_by_classification;

		$data['membership']		= $data['email']				= "";
	   $data['user'] = $id;
       $userdata = $this->imiconf_queries->fetch_records_imiconf('users', ' AND id= "' . $id . '"');
		if ( $userdata -> num_rows() > 0 )
		{
			$profile_data											= $this->imiconf_queries->fetch_records_imiconf('users_profile', ' AND userid= "' . $id . '"');
			if ( $profile_data -> num_rows() > 0 )
			{
				$data['membership']									= $profile_data->row()->membership;
			}


            $data['email'] = $userdata->row()->email;
        }


       /*
       $email														= $userdata->email;
       $membership												= $profile_data->membership;
       $donation													= $profile_data->donation;

       $data['email']												= $email;
       $data['membership']										= $membership;
       // echo  $data['membership']; die();
       */

       $data['h1'] = '';

	 $this->load->view(FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );
   }

    /**
     * Shabbir, 2/16/18: PayPal is supposed to hit this URL with IPN notifications. However I haven't been able to get PayPal to hit it (except with the IPN simulator).
     */
    public function payment_notify($userid)
    {
        header('HTTP/1.1 500 Internal Server Error'); // To ensure we don't inadvertently return a 200 which PayPal interprets as "IPN was received correctly".

        $ipn_verifier = new \apih\PayPal\IPN();
        $ipn_verifier->useSandbox(!SessionHelper::_get_session("PAYPAL_MODE", "site_settings"));
        $ipn_data = $ipn_verifier->process($_POST);
        if (!$ipn_data) {
            ~rt(debug_backtrace());
        }

        log_message('info', sprintf('PayPal IPN received IPN Data: %s', var_export($ipn_data, true)));

        ~rt($userid, $ipn_data);

        // Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
        header("HTTP/1.1 200 OK");
    }

    protected function getAdminEmailsArray()
    {
        return SessionHelper::_get_session("EMAIL_TO", "site_settings");
    }

	public function send_tax_receipt_members($ms_id, $ci){
		// pdfwork start			
		$TMP_receipt	= $ci->db_imiconf->query("SELECT um.id as ms_id, um.user_id, um.membership_package_name, um.membership_package_price, um.date_purchased, ud.*, up.home_country as country, up.home_state_province as state, up.home_city as city FROM tb_user_memberships um LEFT JOIN `tb_users` ud ON  ud.id =  um.user_id LEFT JOIN tb_users_profile up ON up.userid = ud.id WHERE um.id = '". $ms_id ."' ");
		$_POST['donation_details']['first_name'] = isset($TMP_receipt->row()->name) ? $TMP_receipt->row()->name : '';
		if( $TMP_receipt->num_rows() > 0 )
		{

			// canada
			if(is_countryCheck(FALSE,FALSE,TRUE) == 'canada'){
				$receipt_pdf 	= "receipts/canada.php";
				$receipt_email 	= "email/frontend/donate_receipt_canada.php";
				$email_subject	= "Your Tax Receipt for the membership purchased to Imamia Canada";
				$receipt_prefix = 'C';
				// $email_bcc		= array("imicanada@gmail.com","nooranimd@yahoo.com","drsyahaider@yahoo.ca","Donnarmoz@gmail.com","imihq@imamiamedics.com","imiwaiting@att.net", "imamiahq@gmail.com", "sakinarizviimi@gmail.com");
				$email_bcc		= array("drsyahaider@yahoo.ca","mali.kermali@outlook.com","imamiacanada@gmail.com", "neelam.raheel@genetechsolutions.com");
			}
			// international
			elseif(is_countryCheck(FALSE,FALSE,TRUE) == 'medics'){
				$receipt_pdf 	= "receipts/medics-international.php";
				$receipt_email 	= "email/frontend/donate_receipt_medics.php";
				$receipt_prefix = 'MI';
				$email_subject	= "Your Tax Receipt for the membership purchased to Medics International";				
				$email_bcc		= array("imifinance786@gmail.com", "neelam.raheel@genetechsolutions.com");
			} else {
				$receipt_pdf 	= "receipts/global.php";
				$receipt_email 	= "email/frontend/donate_receipt.php";
				$email_subject	= "Your Tax Receipt for the membership purchased to Imamia Medics International";
				$receipt_prefix = 'A';
				// $email_bcc		= array("imifinance786@gmail.com", "sakinarizviimi@gmail.com", "RomeenaIMI@gmail.com", "rizvi.sakina@gmail.com", "gsdeveloper786@gmail.com", "zainabwebadmin@yopmail.com", "fatemawebadmin@yopmail.com", "drsyahaider@yahoo.ca", "asma.shahab@yopmail.com", "Donnarmoz@gmail.com", "aymenharoon5@gmail.com", "aahmed@trinity.edu");
				$email_bcc		= array("IMIFinance786@gmail.com", "imihq@imamiamedics.com","imiwaiting@att.net","sakinarizviimi@gmail.com", "neelam.raheel@genetechsolutions.com");
			}

				$get_max_receipt_no	= $ci->db->query("SELECT MAX(receipt_number) AS largest_receipt_no FROM `tb_payment_receipts` WHERE receipt_prefix = '$receipt_prefix'");
				// $get_max_receipt_no	= $ci->db->query("SELECT MAX(tax_receipt_num) AS largest_receipt_no FROM `tb_donation_form` WHERE belongs_country = ".$belongs_to);

				if( count($get_max_receipt_no->row()) > 0 ){
					$max_receipt_num	= intval($get_max_receipt_no->row()->largest_receipt_no);
					// $max_receipt_num	= $max_receipt_num + 1;

					if(is_countryCheck(FALSE,FALSE,TRUE) == 'canada'){
						$max_receipt_num	= ($max_receipt_num <= 120000) ? 120001 : $max_receipt_num + 1;
					} elseif( is_countryCheck(FALSE,FALSE,TRUE) == 'medics') {
						$max_receipt_num	= ($max_receipt_num <= 130000) ? 130001 : $max_receipt_num + 1;
					} else {
						$max_receipt_num	= ($max_receipt_num <= 110000) ? 110001 : $max_receipt_num + 1;
					}
					$current_date = new DateTime();
					$dataForReceipt	= array();
					$dataForReceipt['receipt_number']	= $max_receipt_num;
					$dataForReceipt['receipt_prefix']	= $receipt_prefix;
					$dataForReceipt['table_name']		= 'tb_user_memberships';
					$dataForReceipt['table_id_name']	= 'id';
					$dataForReceipt['table_id_value']	= $ms_id;
					$dataForReceipt['created_at']	    = $current_date->format('Y-m-d H:i:s');

					$ci->queries->SaveDeleteTables($dataForReceipt, 's', "tb_payment_receipts", 'id');					
				}

			$_homestate	= ($TMP_receipt->row()->state) ? ', ' . $TMP_receipt->row()->state : "";
			$_receipt_date	=  date("Y-m-d", strtotime( $TMP_receipt->row()->date_purchased));
			
			$pdfData = array(
				"name"			=> $TMP_receipt->row()->name,
				"address"		=> $TMP_receipt->row()->city . $_homestate,
				// "address"		=> $TMP_receipt->row()->home_address,
				"email"			=> $TMP_receipt->row()->email,
				"project"		=> $TMP_receipt->row()->membership_package_name,
				"amount"		=> $TMP_receipt->row()->membership_package_price,
				"date" 			=> $_receipt_date,
				"serial_num" 	=> $receipt_prefix . $max_receipt_num
			);
			
			$file_name = './assets/temp-tax-files/tax-receipt-' . $ms_id . '.pdf';
			$html_code = '<link rel="preconnect" href="https://fonts.googleapis.com">';
			$html_code .= $ci->load->view( $receipt_pdf, $pdfData, TRUE );
			$pdf = new Pdf();
			$pdf->load_html($html_code);
			$pdf->render();
			$file = $pdf->output();
			file_put_contents($file_name, $file);

			$email_template		= array("email_to"					=> $TMP_receipt->row()->email,
										"email_heading"				=> "Membership Tax Receipt",
										"email_file"				=> $receipt_email,
										"email_subject"				=> $email_subject,
										"default_subject"			=> TRUE,
										"email_post"				=> $_POST,
										// "email_bcc"					=> ( SessionHelper::_get_session("EMAIL_TO", "site_settings") ),
										"email_bcc"					=> $email_bcc,
										"email_attachment"			=> $file_name
										);

			$is_email_sent_2				= $ci->_send_email( $email_template );
			unlink($file_name);
		
		} 
		// pdfwork end
	}
}
