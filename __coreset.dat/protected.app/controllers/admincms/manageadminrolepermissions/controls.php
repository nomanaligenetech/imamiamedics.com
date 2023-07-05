<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		
		
		$this->data["_heading"]										= 'Manage Admin Role Permissions';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		
		$this->load->library("Encrption");
	}
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/edit" ) );
		}
			
		
		
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		$this->db->query("DELETE FROM tb_admin_roles_permissions");
		if ( !empty($_POST['permission']) ){
			foreach ($_POST['permission'] as $role_id => $permissions) {
				foreach ($permissions as $permission => $val) {
					$saveData = array(
									"admin_role_id"					=> $role_id,
									"operationid"					=> $permission
								);

					$this->queries->SaveDeleteTables($saveData, 's', "tb_admin_roles_permissions", 'id');
				}
			}
		}
	
		$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							lang_line("operation_saved_success"), 
																							lang_line("heading_operation_success"),
																							false, 
																							true);
		redirect( $data["_directory"] . "controls/edit" );
	}
	
	public function edit()
	{

		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";

		$superadmin = SessionHelper::_get_session("SUPERADMIN_ROLEID", "site_settings");
		$roles														= $this->queries->fetch_records("admin_roles"," AND id != ".$superadmin);
		$directories												= $this->queries->fetch_records("admin_operations", " AND parent = 0 ");
		$operations													= $this->queries->fetch_records("admin_roles_permissions");
		
		
		$data['roles']										= $roles->result();
		$data['directories']								= $directories->result();
		$data['operations']									= $operations->result();
		$data['options']									= "edit";
		$data['unique_formid']								= "";
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */