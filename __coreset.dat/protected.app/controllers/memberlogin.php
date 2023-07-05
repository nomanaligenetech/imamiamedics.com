<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Functions functions
 * @property CI_Session session
 */
class MemberLogin extends C_frontend {

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
		
		$this->data['_pagetitle']									= lang_line("text_login");
		$this->data['h1']											= lang_line("text_login") . " IMI";
		
	}
	
	
	
	public function breadcrumbs( $current_page_title = FALSE )
	{		
		$TMP_array[]												= array("name"			=> lang_line('text_home'),
																			"link"			=> site_url());
		
		
		$TMP_array[]												= array("name"			=> $current_page_title,
																			"is_active"		=> TRUE);
		
		return $TMP_array;
	}

    public function index()
    {
        $data = $this->data;
        $data['_pageview'] = "frontend/memberlogin.php";


        $data['_is_breadcrumbs'] = $this->breadcrumbs($data['_pagetitle']);


        $this->functions->unite_post_values_form_validation();


        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email'); //
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_validate_usercredentials[imiconf]');


        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');

            $this->load->view(FRONTEND_TEMPLATE_HALF_CENTER_VIEW, $data);
        } else {

            $cookie = $this->encrption->encrypt($this->input->post("email"));

            setcookie("validate", $cookie, time() + 2592000, "/");

            $_details = $this->imiconf_queries->fetch_records_imiconf("users", " AND email = '" . $this->input->post("email") . "' ")->row_array();


            $_details['logintime'] = strtotime("now");
            $_details['is_member'] = FALSE;


            /*
            $TMP_imi_coupon_code			= $this->imiconf_queries->fetch_records_imiconf( "site_settings_master", " ", "id, imi_coupon_code ");

            $TMP_crm						= $this->imiconf_queries->fetch_records_imiconf( "conference_registration_master", " AND userid = '". $_details['id'] ."' ", "id");
            if ( $TMP_crm -> num_rows() > 0 )
            {


                $TMP_is_member				= $this->imiconf_queries->fetch_records_imiconf(	"conference_registration_screen_two",
                                                                                                  " AND conferenceregistrationid IN (". $this->db_imiconf->last_query() .")
                                                                                                  AND (be_a_member = 1 OR coupon_code = '". $TMP_imi_coupon_code->row("imi_coupon_code") ."') OR ispaid = 1 ");



                if ( $TMP_is_member -> num_rows() > 0 )
                {
                    $_details['is_member']	= TRUE;
                }
            }
            */


            if ($this->functions->validate_if_user_is_a_paid_member($_details['id'], $is_membership_expired, $is_membership_pending_approval, $is_membership_rejected)) {
                $_details['is_member'] = TRUE;
            }


            $this->_create_User_Session($_details);

            if (
                (!$_details['is_member']) &&
                (!$is_membership_pending_approval) &&
                (!$is_membership_rejected) &&
                true
            ) {
                redirect(site_url('joinus/payment/' . $_details['id']));
            } else if ($this->validations->is_session("last_url")) {
                $r = SessionHelper::_get_session("last_url");
                SessionHelper::_unset_session("last_url");

                redirect(site_url($r));
            } else {
                redirect("account/myprofile/controls/view");
            }

        }


    }
	
}