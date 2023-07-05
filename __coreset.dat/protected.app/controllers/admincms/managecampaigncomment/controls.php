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
		
		
		$this->data["_heading"]										= 'Manage Campaign Comments';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";	
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Comment', 'Campaign', 'User Email', 'Status');
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		//$data["table_record"]										= $this->queries->fetch_records("dc_comments", " ORDER BY id DESC ");
		$data["table_record"]										= $this->db->query('select dcc.*, dp.name, df.email from tb_dc_comments dcc INNER JOIN tb_donation_form df ON df.id = dcc.df_id LEFT JOIN tb_donation_projects dp ON dp.id = df.donation_projects_id WHERE df.is_paid = 1 ORDER BY id DESC');
		$data["table_properties"]									= $this->view_table_properties();


		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function status( $id, $statusId )
	{
		$data											= $this->data;

		$saveData['id']									= $id;
		$saveData['status']								= $statusId;
		$saveData['updated_date']						= date('Y-m-d H:i:s');
		$saveData['updated_by']							= $this->functions->_admincms_logged_in_details( "id" );
		$this->queries->SaveDeleteTables($saveData, 'e', "tb_dc_comments", 'id');

		$data['_messageBundle']							= $this->_messageBundle('success' , 
														lang_line("operation_saved_success"), 
														lang_line("heading_operation_success"), 
														false,
														true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
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
	
	public function delete( $id )
	{
		$data												= $this->data;
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_dc_comments", 'id') ;
		}
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
}

/* End of file */