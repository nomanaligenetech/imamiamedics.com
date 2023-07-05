<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Queries queries
 */
class Controls extends C_admincms {

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

		$this->_auth_login( false );
		
		$this->data													= $this->default_data();
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= lang_line("heading_managesitesettings");
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/admincms/profileimages/";
		$this->data['email_desc_text']								= "<br />
																	  <small>comma seperated for multiple emails</small><br />
																	  <small>after | (pipe) BCC emails</small><br />
																	  <small>xxx,xxx,xxx|abc,abc</small>";
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array(lang_line("text_username") );
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		
		redirect ( redirect( $data["_directory"] . "controls/edit" ) );
		
	}

    public function save()
    {
        $data = $this->data;

        if (!$this->validations->is_post()) {
            redirect(site_url($data["_directory"] . "controls/view"));
        }


        #standard validation
        $this->form_validation->set_rules("id", "id", "trim");
        $this->form_validation->set_rules("options", "options", "trim");
        $this->form_validation->set_rules("unique_formid", "unique_formid", "trim");

        $this->form_validation->set_rules("site_meta_title", "Site Meta Title", "trim|required");
        $this->form_validation->set_rules("admincms_meta_title", "AdminCMS Meta Title", "trim|required");
        $this->form_validation->set_rules("getinvolved_menuid", "Get Involved (Select Menu)", "trim|required");
        $this->form_validation->set_rules("whatwedo_menuid", "What We Do (Select Menu)", "trim|required");
        $this->form_validation->set_rules("events_menuid", "Event (Select Menu)", "trim");
        $this->form_validation->set_rules("superadmin_roleid", "Super Admin Role (Select Role)", "trim");
        $this->form_validation->set_rules("interviewer_roleid", "Interviewer for Arbaeen Medical Mission (Select Role)", "trim");
        $this->form_validation->set_rules("stage3a_menuid", "Stage 3A (Select Menu)", "trim|required");
        $this->form_validation->set_rules("stage3b_menuid", "Stage 3B (Select Menu)", "trim|required");


        $this->form_validation->set_rules("email_mode", "Email Mode", "trim|required");
        $this->form_validation->set_rules("email_subject", "Email Subject", "required");
        $this->form_validation->set_rules("email_from_name", "Email From", "trim|required");
        $this->form_validation->set_rules("email_from", "Email From", "trim|required|valid_email");
        $this->form_validation->set_rules("email_to", "Email To", "trim|required");


        $this->form_validation->set_rules("paypal_mode", "Paypal Mode", "trim|required");

        $this->form_validation->set_rules("paypal_url_sandbox", "Sandbox Paypal Url", "trim|required");
        $this->form_validation->set_rules("paypal_url_live", "Live Paypal Url", "trim|required");

        $this->form_validation->set_rules("paypal_email_sandbox", "Sandbox Paypal Email", "trim|required|valid_email");
        $this->form_validation->set_rules("paypal_email_live", "Live Paypal Email", "trim|required|valid_email");

        $this->form_validation->set_rules("payeezy_mode", "Payeezy Mode", "trim|required");
        
        $this->form_validation->set_rules("payeezy_url_sandbox", "Sandbox Payeezy Url", "trim|required");
        $this->form_validation->set_rules("payeezy_url_live", "Live Payeezy Url", "trim|required");

        $this->form_validation->set_rules("payeezy_exactid_sandbox", "Sandbox Payeezy Exact Id", "trim|required");
        $this->form_validation->set_rules("payeezy_exactid_live", "Live Payeezy Exact Id", "trim|required");

        $this->form_validation->set_rules("payeezy_password_sandbox", "Sandbox Payeezy Password", "trim|required");
        $this->form_validation->set_rules("payeezy_password_live", "Live Payeezy Password", "trim|required");

        $this->form_validation->set_rules("payeezy_hmacid_sandbox", "Sandbox Payeezy Hmac Id", "trim|required");
        $this->form_validation->set_rules("payeezy_hmacid_live", "Live Payeezy Hmac Id", "trim|required");

        $this->form_validation->set_rules("payeezy_hmackey_sandbox", "Sandbox Payeezy Hmac Key", "trim|required");
        $this->form_validation->set_rules("payeezy_hmackey_live", "Live Payeezy Hmac Key", "trim|required");

        /*$this->form_validation->set_rules("payeezy_token_url", "Payeezy Token Url", "trim|required");
        
        $this->form_validation->set_rules("payeezy_apikey_sandbox", "Sandbox Payeezy API Key", "trim|required");
        $this->form_validation->set_rules("payeezy_apikey_live", "Live Payeezy API Key", "trim|required");

        $this->form_validation->set_rules("payeezy_apisecret_sandbox", "Sandbox Payeezy API Secret", "trim|required");
        $this->form_validation->set_rules("payeezy_apisecret_live", "Live Payeezy API Secret", "trim|required");

        $this->form_validation->set_rules("payeezy_mertoken_sandbox", "Sandbox Payeezy Merchant Token", "trim|required");
        $this->form_validation->set_rules("payeezy_mertoken_live", "Live Payeezy Merchant Token", "trim|required");

        $this->form_validation->set_rules("payeezy_transtoken_sandbox", "Sandbox Payeezy Transarmor Token", "trim|required");
        $this->form_validation->set_rules("payeezy_transtoken_live", "Live Payeezy Transarmor Token", "trim|required");*/

        if ($this->form_validation->run() == FALSE) {
            $data['_pageview'] = $data["_directory"] . "edit.php";
            $data['_messageBundle'] = $this->_messageBundle('danger', validation_errors(), 'Error!');

            $this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
        } else {


            $saveData = array("id" => $this->input->post("id"),

                "site_meta_title" => $this->input->post("site_meta_title"),
                "admincms_meta_title" => $this->input->post("admincms_meta_title"),

                "email_mode" => $this->input->post("email_mode"),
                "email_from" => $this->input->post("email_from"),
                "email_to" => $this->input->post("email_to"),
                "email_subject" => $this->input->post("email_subject"),
                "email_from_name" => $this->input->post("email_from_name"),

                "paypal_mode" => $this->input->post("paypal_mode"),
                "paypal_url_sandbox" => $this->input->post("paypal_url_sandbox"),
                "paypal_url_live" => $this->input->post("paypal_url_live"),
                "paypal_email_sandbox" => $this->input->post("paypal_email_sandbox"),
                "paypal_email_live" => $this->input->post("paypal_email_live"),

                "payeezy_mode" => $this->input->post("payeezy_mode"),
                "payeezy_url_sandbox" => $this->input->post("payeezy_url_sandbox"),
                "payeezy_url_live" => $this->input->post("payeezy_url_live"),
                "payeezy_exactid_sandbox" => $this->input->post("payeezy_exactid_sandbox"),
                "payeezy_exactid_live" => $this->input->post("payeezy_exactid_live"),
                "payeezy_password_sandbox" => $this->input->post("payeezy_password_sandbox"),
                "payeezy_password_live" => $this->input->post("payeezy_password_live"),
                "payeezy_hmacid_sandbox" => $this->input->post("payeezy_hmacid_sandbox"),
                "payeezy_hmacid_live" => $this->input->post("payeezy_hmacid_live"),
                "payeezy_hmackey_sandbox" => $this->input->post("payeezy_hmackey_sandbox"),
                "payeezy_hmackey_live" => $this->input->post("payeezy_hmackey_live"),

                /*"payeezy_token_url" => $this->input->post("payeezy_token_url"),
                "payeezy_apikey_sandbox" => $this->input->post("payeezy_apikey_sandbox"),
                "payeezy_apikey_live" => $this->input->post("payeezy_apikey_live"),
                "payeezy_apisecret_sandbox" => $this->input->post("payeezy_apisecret_sandbox"),
                "payeezy_apisecret_live" => $this->input->post("payeezy_apisecret_live"),
                "payeezy_mertoken_sandbox" => $this->input->post("payeezy_mertoken_sandbox"),
                "payeezy_mertoken_live" => $this->input->post("payeezy_mertoken_live"),
                "payeezy_transtoken_sandbox" => $this->input->post("payeezy_transtoken_sandbox"),
                "payeezy_transtoken_live" => $this->input->post("payeezy_transtoken_live"),*/

                "getinvolved_menuid" => $this->input->post("getinvolved_menuid"),
                "whatwedo_menuid" => $this->input->post("whatwedo_menuid"),
                "events_menuid" => $this->input->post("events_menuid"),
                "superadmin_roleid" => $this->input->post("superadmin_roleid"),
                "interviewer_roleid" => $this->input->post("interviewer_roleid"),
                "stage3a_menuid" => $this->input->post("stage3a_menuid"),
                "stage3b_menuid" => $this->input->post("stage3b_menuid")
            );

            {// Notify people via email when the PayPal mode (Live/Sandbox) is changed.

                $localhost = array('127.0.0.1', "::1");

                if (!in_array($_SERVER['REMOTE_ADDR'], $localhost)) {

                    /** @var CI_DB_mysqli_result $current_settings_result */
                    $current_settings_result = $this->queries->fetch_records("site_settings_master");
                    if ((!$current_settings_result) || ($current_settings_result->num_rows() != 1) ||
                        false) {
                        ~r(array_reverse(get_defined_vars()));
                    }
                    $current_settings_row = $current_settings_result->row_array();
                    if ((!$current_settings_row) || (!isset($current_settings_row['paypal_mode'])) ||
                        false) {
                        ~r(array_reverse(get_defined_vars()));
                    }
                    if ($current_settings_row['paypal_mode'] != $saveData['paypal_mode']) { // THE setting is changing
                        $paymentmode_number_to_name_map = DropdownHelper::paymentmode_dropdown();
                        $this->email(array(
                            'to' => array(
                                'shabbir.bhojani@genetechsolutions.com',
                                'neelam.raheel@genetechsolutions.com',
                                // 'shamim.rajani@genetechsolutions.com',
                                'ahmed.abbas@genetechsolutions.com',
                                'support@genetechsolutions.com',
                                'sakinarizviimi@gmail.com',
                            ),
                            'bcc' => array(),
                            'message' =>
                                'PayPal Mode on imamiamedics.com is being changed from ' .
                                $paymentmode_number_to_name_map[$current_settings_row['paypal_mode']] .
                                ' to ' .
                                $paymentmode_number_to_name_map[$saveData['paypal_mode']] .
                                ' by someone using the IP address ' .
                                $_SERVER['REMOTE_ADDR'] .
                                '.',
                            'subject' => 'PayPal Mode changed!',
                            'from' => 'noreply@imamiamedics.com',
                        ));
                    }
                }
            }

            $this->queries->SaveDeleteTables($saveData, 'e', "tb_site_settings_master", 'id');


            $data['_messageBundle'] = $this->_messageBundle('success',
                lang_line("operation_saved_success"),
                lang_line("heading_operation_success"),
                false,
                true);

            redirect($data["_directory"] . "controls/edit");


        }

    }
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
    $empty_inputs				= array( "id", "email_from", "email_to", "email_mode", "site_meta_title", "admincms_meta_title", "getinvolved_menuid", "whatwedo_menuid", "stage3a_menuid" , "stage3b_menuid" , "events_menuid", "superadmin_roleid", "interviewer_roleid","email_subject", "email_from_name", "paypal_mode", "paypal_email_sandbox", "paypal_email_live", "paypal_url_sandbox", "paypal_url_live", "options", "unique_formid", "payeezy_mode", "payeezy_url_sandbox", "payeezy_url_live", "payeezy_exactid_sandbox", "payeezy_exactid_live", "payeezy_password_sandbox", "payeezy_password_live", "payeezy_hmacid_sandbox", "payeezy_hmacid_live", "payeezy_hmackey_sandbox", "payeezy_hmackey_live"/*, "payeezy_token_url", "payeezy_apikey_sandbox", "payeezy_apikey_live", "payeezy_apisecret_sandbox", "payeezy_apisecret_live", "payeezy_mertoken_sandbox", "payeezy_mertoken_live", "payeezy_transtoken_sandbox", "payeezy_transtoken_live"*/ );
		
    $filled_inputs				= array( "id", "email_from", "email_to", "email_mode", "site_meta_title", "admincms_meta_title", "getinvolved_menuid", "whatwedo_menuid", "stage3a_menuid" , "stage3b_menuid", "events_menuid", "superadmin_roleid", "interviewer_roleid" , "email_subject", "email_from_name", "paypal_mode", "paypal_email_sandbox", "paypal_email_live", "paypal_url_sandbox", "paypal_url_live", "options", "unique_formid", "payeezy_mode", "payeezy_url_sandbox", "payeezy_url_live", "payeezy_exactid_sandbox", "payeezy_exactid_live", "payeezy_password_sandbox", "payeezy_password_live", "payeezy_hmacid_sandbox", "payeezy_hmacid_live", "payeezy_hmackey_sandbox", "payeezy_hmackey_live"/*, "payeezy_token_url", "payeezy_apikey_sandbox", "payeezy_apikey_live", "payeezy_apisecret_sandbox", "payeezy_apisecret_live", "payeezy_mertoken_sandbox", "payeezy_mertoken_live", "payeezy_transtoken_sandbox", "payeezy_transtoken_live"*/ );
		
		//$filled_inputs				= array( "id", "resorts_id", "promo_code_percentage_discount_code", "promo_code_percentage_discount_percent", "promo_code_percentage_discount_datefrom", "promo_code_percentage_discount_expiry", "promo_code_value_add_code", "promo_code_value_add_details", "promo_code_value_add_datefrom", "promo_code_value_add_expiry",  "options" );
		
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]		= $db_data[ $filled_inputs[$x] ];
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]		= "";
			}
			
			return $data;
		
		}
	}


    public function edit($edit_id = 0)
    {
        $data = $this->data;


        $data['_pageview'] = $data["_directory"] . "edit.php";

        $data["edit_id"] = $edit_id;
        $edit_details = $this->queries->fetch_records("site_settings_master");

        if ($edit_details->num_rows() <= 0) {
            #show_404();
        }


        #pre-filled values for input fields

        $edit_details = $edit_details->row_array();
        $edit_details['options'] = "edit";
        $edit_details['unique_formid'] = "";

        $this->_create_fields_for_form(true, $data, $edit_details);


        $this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);

    }
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		if ( isset($_POST['checkbox_options']) )
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */