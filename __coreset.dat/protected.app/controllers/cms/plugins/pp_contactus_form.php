<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Contactus_Form extends C_frontend {

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
		
		
		#$ci->data													= $ci->default_data();
		
	}
	
	
	
	
	static public function show( $data = array(), $ci )
	{
		return $ci->load->view( "frontend/cms/page_plugins/pp_contactus_form", $data, TRUE );
	}
	
	
	static public function index( &$data = array(), $ci )
	{

		#$ci->load->library('form_validation','','form_validation');
		
		//$ci->load->view( "frontend/cms/page_widgets/pw_contactus_form", array(), TRUE )
		$ci->form_validation->set_rules('name', lang_line('text_name'), 'trim|required');
		$ci->form_validation->set_rules('email', lang_line('text_email'), 'trim|required|valid_email'); //
		
		$ci->form_validation->set_rules('phone', lang_line('text_phonenumber'), 'trim');
		$ci->form_validation->set_rules('country', lang_line('text_country'), 'trim|required');
		$ci->form_validation->set_rules('city', lang_line('placeholder_arbaeen_form_city'), 'trim|required');
		
		$ci->form_validation->set_rules('profession', lang_line('text_profession'), 'trim');
		$ci->form_validation->set_rules('preciouswords', lang_line('text_preciouswords'), 'trim|required');

		$ci->form_validation->set_rules('custom_grecap', lang_line('text_captcha'), 'trim|required|callback_validate_recaptcha');
		
		if ($ci->form_validation->run() == FALSE)
		{
			$ci->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
			
			#$data['_messageBundle']			= $ci->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			return TRUE;
			#$ci->load->view( FRONTEND_TEMPLATE_LEFT_WIDGETS_VIEW, $data);	
			#return $ci->load->view( "frontend/cms/page_plugins/pp_contactus_form", $data, TRUE);	
		}
		else 
		{
			
			/*$insertData					= array("name"					=> $ci->input->post("name"),
												"email"				 	=> $ci->input->post("email"),
												"phone"					=> $ci->input->post("phone"),
												"country"				=> $ci->input->post("country"),
												"city"					=> $ci->input->post("city"),
												"profession"			=> $ci->input->post("profession"),
												"preciouswords"			=> $ci->input->post("preciouswords"),
												"type"					=> "imiportal");*/
													
			
		#	$ci->queries->SaveDeleteTables($insertData, 's', "tb_contact_inquiries", 'id'); 
			
			
			$_POST['country']			= DropdownHelper::country_dropdown(false, 'id', $_POST['country']);
			#to site admin
			$email_template				= array("email_heading"			=> "Contact Us",//lang_line('text_contactus'),
												"email_file"			=> "email/frontend/contact_inquiry_admin.php",
												"email_subject"			=> "Contact Inquiry",//lang_line('text_contactussubject'),
												"default_subject"		=> TRUE,
												"email_to"				=> getAdminEmails(),
												"email_post"			=> $_POST);
			
			
			
			$is_email_sent				= $ci->_send_email( $email_template );
			#to_site_admin / bcc_admin
			
			
			
		
			#to user
			$email_template				= array("email_to"				=> $ci->input->post("email"),
												"email_heading"			=> "Contact Us",//lang_line('text_contactus'),
												"email_file"			=> "email/frontend/contact_us_thank_you.php",
												"email_subject"			=> "Contact Inquiry",//lang_line('text_contactussubject'),
												"default_subject"		=> TRUE,
												"email_post"			=> $_POST );
			
			$is_email_sent				= $ci->_send_email( $email_template );
			#to_user / bcc_admin
				
			
			$data['_messageBundle']		= $ci->_messageBundle( 	'success_big' , 
																	lang_line("text_contactus_thankyou_sucess_frontend"), 
																	lang_line("heading_operation_success"));
			
			$data['_pageview']											= "global/_blank_page.php";		
			
			#$ci->load->view( FRONTEND_TEMPLATE_LEFT_WIDGETS_VIEW, $data );	
			
		}
		
	}
	
	
	
	
	
	
}