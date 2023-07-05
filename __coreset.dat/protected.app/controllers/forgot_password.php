<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_Password extends C_frontend {

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
		
		$this->data['_pagetitle']									= lang_line("text_forgotpassword");
		$this->data['h1']											= lang_line("text_forgotpassword");
	}
	
	public function index()
	{ 
		$data														= $this->data;		
		$data['_pageview']											= "frontend/forgot_password.php";
		
		
		
		$this->functions->unite_post_values_form_validation();
			
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_validate_useremail');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			$this->load->view( FRONTEND_TEMPLATE_FORMS_VIEW, $data );
		}
		else
		{
			
			$this->load->library("Encrption");
			$_new_password					= random_string('alnum', 8);
			
			$updateData						= array("password"				=> $this->encrption->encrypt( $_new_password ),
													"email"					=> $this->input->post("email") );
													
			 
			$this->imiconf_queries->SaveDeleteTables_imiconf($updateData, 'e', "tb_users", 'email');
			
			
			
			#to_user / bcc_admin
			$_POST['login_link']		= site_url( "memberlogin" ); 
			$_POST['password']			= $_new_password;
			$email_template				= array("email_to"				=> $this->input->post("email"),
												"email_heading"			=> "Forgot Password",//lang_line('text_forgotpassword'),
												"email_file"			=> "email/frontend/forgot_password.php",
												"email_subject"			=> "Forgot Password",//lang_line('text_forgotpassword'),
												"default_subject"		=> TRUE,
												"email_post"			=> $_POST );
			
			$is_email_sent				= $this->_send_email( $email_template );
			#to_user / bcc_admin
			
			
			
			
			$data['_messageBundle']								= $this->_messageBundle('info' , 
																						"<p>" . lang_line("text_forgotpassword_thankyou") . "</p>", 
																						'', 
																						false,
																						true);
			
			redirect ( "memberlogin" );
			
		}
		
		
		
		
	}
	
}