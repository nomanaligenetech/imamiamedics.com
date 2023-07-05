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
		
		
		$this->data["_heading"]										= 'Manage Donate Page Blocked Ip';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";	
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Ip Address', 'No of Hits', 'Blocked Time');
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->db->query('SELECT b.*, count(a.ip_address) as totalhits FROM tb_donatepage_blocked b LEFT JOIN tb_donatepage_ips a on b.ip_address = a.ip_address GROUP BY b.id');
		$data["table_properties"]									= $this->view_table_properties();


		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );		
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
		
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;
			$this->db->query('UPDATE `tb_donatepage_ips` SET is_resolved = 1 where ip_address = (SELECT ip_address from tb_donatepage_blocked where id = '.$result.')');
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_donatepage_blocked", 'id') ;
		}
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					'Ip(s) Unblocked Successfully', 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
}

/* End of file */