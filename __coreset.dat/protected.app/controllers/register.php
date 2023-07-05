<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends C_frontend {

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
		
		$this->_auth_login( true );
		
		$this->data													= $this->default_data();
		
		$this->data['_pagetitle']									= lang_line("text_registeryouraccount");
		$this->data['h1']											= lang_line("text_newuserregisterhere");
		
	}
	
	public function activation( $activation_code = '' )
	{
		$data														= $this->data;		
		$data['_pageview']											= "frontend/register.php";
		
		$data['h1']								= '';
		$data['users']												= $this->imiconf_queries->fetch_records_imiconf('users', ' AND activation_code = "'. $activation_code .'"  ');
		
		if ( $data['users'] -> num_rows() > 0 )
		{
			if ( $data['users'] -> row("is_active") )
			{
				$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																		lang_line("text_already_register_desc"),
																		lang_line("text_already_register")
																	);
				
				
			}
			else
			{
				
				
				$data['_messageBundle']		= $this->_messageBundle( 	'success_big' , 
																		lang_line('text_account_activated_text'),
																		lang_line('text_account_activated'));
				
			}
			
			
			
			$updateData					= array("id"					=> $data['users']->row("id"),
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
		
		$data														= $this->data;		
		$data['_pageview']											= "frontend/register.php";
		
		
		
		$this->functions->unite_post_values_form_validation();
			
			
		$this->form_validation->set_rules('name', lang_line('text_name'), 'trim|required');
		$this->form_validation->set_rules('last_name', lang_line('text_lastname'), 'trim|required');
		

		$check_guest_user_exist			= $this->imiconf_queries->fetch_records_imiconf("users", " AND email = '". $this->input->post("email") ."' AND activation_code = ''  ");
		if($check_guest_user_exist->num_rows() <= 0){
			$tmp_validate_DB			= $this->imiconf_queries->fetch_records_imiconf("users", " AND email = '". $this->input->post("email") ."' ");
			$tmp_validate_VALUES		= $this->find_duplicate_values($tmp_validate_DB, $this->input->post("id"));
			$this->form_validation->set_rules('email', lang_line('text_email'), "trim|required|valid_email|callback_validate_duplicate[". $tmp_validate_VALUES ."]"); 
		}
		
		
		
		
		$this->form_validation->set_rules('password', lang_line('placeholder_password'), 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', lang_line('placeholder_cpassword'), 'trim|required|matches[password]');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			
			#$data['_messageBundle']			= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data );
		}
		else
		{

			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));

			$userIp = $this->input->ip_address();

			$secret = $this->config->item('google_secret');

			$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);

			$status = json_decode($output, true);

			if ($status['success']) {

				$this->load->library("Encrption");

				$insertData					= array(
					"name"					=> $this->input->post("name"),
					"last_name"				=> $this->input->post("last_name"),
					"email"					=> $this->input->post("email"),
					"password"				=> $this->encrption->encrypt($this->input->post("password")),
					"registration_site"		=> SITE_CODE,
					"name"					=> $this->input->post("name"),
					"activation_code"		=> random_string('alnum', 20),
					"date_added"			=> date("Y-m-d H:i:s"),
					"address"				=> $this->input->post("address"),
					"user_ip"				=> $userIp
				);

				$record = $this->imiconf_queries->fetch_records_imiconf('users', ' AND email = "'. $this->input->post("email") .'" AND activation_code = "" ');
				if($record->num_rows() <= 0	){
					
					$this->imiconf_queries->SaveDeleteTables_imiconf($insertData, 's', "tb_users", 'id');
				}else{

					$this->queries->SaveDeleteTables_imiconf($insertData, 'e', "tb_users", 'email'); 	
				}



				#to_user / bcc_admin
				$_POST['activation_link']	= site_url("register/activation/" . $insertData['activation_code']);
				$email_template				= array(
					"email_to"				=> $this->input->post("email"),
					"email_heading"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
					"email_file"			=> "email/frontend/user_activation_code.php",
					"email_subject"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
					"default_subject"		=> TRUE,
					"email_post"			=> $_POST
				);



				$is_email_sent				= $this->_send_email($email_template);
				#to_user / bcc_admin




				//            ~r(debug_backtrace());
				$data['_messageBundle']		= $this->_messageBundle(
					'success_big',
					lang_line("text_thankyou_for_register"),
					lang_line("heading_operation_success")
				);


				$data['h1']								= '';
				$data['_pageview']						= "global/_blank_page.php";
				$this->load->view(FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data);
				
			} else {
				$data['_messageBundle']			= $this->_messageBundle( 'danger' , 'Invalid Captcha Field', 'Error!');
				$this->load->view(FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data);
			}
			
		}
		
	}

    function resendActivationLink($email)
    {
        $email = base64_decode($email);
        $record = $this->imiconf_queries->fetch_records_imiconf('users', ' AND email = "'. $email .'" AND is_active = 0 ');
        if ($record->num_rows() > 0) {
            $register_link = site_url("register/activation/" . $record->row()->activation_code);
            $name = $record->row()->name;
            $last_name = $record->row()->last_name;
            $password = '************';

            $data = array(
                'activation_link' => $register_link,
                'name'				=> $name,
                'last_name'			=> $last_name,
                'email'				=> $email,
                'password'			=> $password
            );
            $email_template				= array("email_to"				=> $email,
                                                "email_heading"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
                                                "email_file"			=> "email/frontend/user_activation_code.php",
                                                "email_subject"			=> "Account Registration / Activation Code",//lang_line('text_accountregistration/code'),
                                                "default_subject"		=> true,
                                                "email_post"			=> $data );
            

            
            $is_email_sent				= $this->_send_email($email_template);
            
            $data['_messageBundle']		= $this->_messageBundle(
                'success_big',
                'Please check your email for activation link. Click here to go on <a href="'. site_url("memberlogin") .'">Login Page</a>',
                'Activation Link'
            );
            
            $data['_pageview']						= "global/_blank_page.php";
            $this->load->view(FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data);
        } else {
            redirect('memberlogin');
        }
    }
	
}