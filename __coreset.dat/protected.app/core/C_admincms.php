<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_admincms extends C_validationcallbacks{

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
	private $notallowed_operations;
	private $admin_role_id;
	 
	public function __construct()
	{
		parent::__construct();
		
		$this->admin_role_id = $this->functions->_admincms_logged_in_details("role_id");
		$this->admin_allowed_countries = $this->functions->_admincms_logged_in_details("countryid");
        if ($this->admin_role_id > 0) {
			
			$superadmin = SessionHelper::_get_session("SUPERADMIN_ROLEID", "site_settings");
			$this->is_superadmin = $this->admin_role_id == $superadmin ? TRUE : FALSE;
            $operations = $this->queries->fetch_records("admin_operations", " AND operationid NOT IN (SELECT operationid FROM tb_admin_roles_permissions Where admin_role_id = $superadmin)", "operationid");
			
            if ($operations->num_rows() > 0) {
				foreach ($operations->result() as $key => $value) {
					$saveData = array(
						"admin_role_id" => $superadmin,
						"operationid" => $value->operationid
					);
					
                    $this->queries->SaveDeleteTables($saveData, 's', "tb_admin_roles_permissions", 'id');
                }
            }
			
			$q_allow = $this->queries->fetch_records("admin_operations", " AND operationid NOT IN (SELECT operationid FROM tb_admin_roles_permissions Where admin_role_id = $this->admin_role_id)", "operationid");
			$this->notallowed_operations = json_encode($q_allow->result());
			
            if (!is_null($this->uri->segments[2]) && 'sitecontrol' != $this->uri->segments[2] && isset($this->uri->segments[3]) && !is_null($this->uri->segments[3]) && !is_null($this->uri->segments[4])) {
                $uri_request = $this->uri->segments[2] . '/' . $this->uri->segments[3] . '/' . $this->uri->segments[4];

                $q = $this->queries->fetch_records("admin_operations", " AND path = '".$uri_request."'", "operationid");

                if ($q->num_rows() > 0) {
                    $operationid = $q->row()->operationid;

                    $q2 = $this->queries->fetch_records("admin_roles_permissions", " AND admin_role_id = '". $this->admin_role_id ."' AND operationid = '" . $operationid . "'", "id");
                
                    if ($q2->num_rows() == 0) {
                        redirect('/admincms/no_access');
                    }
                } else {
                    redirect('/admincms/no_access');
                }
            }
        }

		$this->showThings										= array();
		
		
	}
	
	
	
	public function default_data_extend( &$data )
	{
		$data['admin_menus'] = $this->queries->fetch_records("admin_operations"," AND operationid IN (SELECT operationid FROM tb_admin_roles_permissions Where admin_role_id = $this->admin_role_id) and is_menu > 0 AND parent = 0");
		$data['notallowed_operations'] = $this->notallowed_operations;
		return $data;
	}
	
	
	public function _create_User_Session($user_details)
	{
		$newdata	= array("admincms_logged_in"				=> TRUE,
							"admincms_logged_details"			=> $user_details);
							
		SessionHelper::_set_session( $newdata );
	}
	
	public function _auth_admin_id( $compare_with )
	{
		if ( $compare_with == $this->functions->_admincms_logged_in_details( "id" ) )
		{
			return TRUE;	
		}
		
		return FALSE;
	}
	
	public function _auth_login( $login_or_not = true, $show_msg = false, $msg_array = array(), $exempt_pages = array() )
	{

		
		if ($login_or_not)
		{
			if ($this->session->userdata('admincms_logged_in'))
			{
				if ($show_msg)
				{
					$this->_messageBundle( $msg_array['class'] , $msg_array['msg'], $msg_array['title'], TRUE);
				}
				
				redirect( "admincms/dashboard" );
				
			}
		}
		else
		{

			$e				= FALSE;
			for ($x=0; $x < count($exempt_pages); $x++)
			{
				if (in_array($exempt_pages[$x], $this->uri->segments))
				{
					$e				= TRUE;
				}
			}

			
			if (!$this->session->userdata('admincms_logged_in') and !$e)
			{
				if ($show_msg)
				{
					$this->_messageBundle( $msg_array['class'] , $msg_array['msg'], $msg_array['title'], TRUE);
				}
				
				
				//if ( !is_localhost() )
				//{
					redirect( "admincms/sitecontrol/login" );	
				//}
			}
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */