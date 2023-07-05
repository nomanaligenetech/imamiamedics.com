<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include( APPPATH . 'controllers/admincms/managecategorytype/control_includes.php' );
class Controls extends Controls_Include {

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
	 * So any other public methods not prefixed with an underscore will<strong></strong>
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
		
		
		$this->data["_heading"]										= 'Manage Category Type';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/category/";
		
	
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		
		//$this->_create_fields_for_form(false, $this->data);	
		
		
		#include_once(APPPATH . 'controllers/admincms/managecmscontent/controls_include.php');
		#$this->data['Controls_Include']								= new Controls_Include();
		#$this->data['Controls_Include']->_create_child_for_form(false, $this->data, array());
		//$this->_widget_create_child_for_form(false, $this->data, array()); #controls_include
		
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('Name');
		
		return $tmp;
	}
	
	public function view( $is_ajax = 0 )
	{
				$data														= $this->data;
		
		
		$data["table_record"]										= $this->queries->fetch_records("categorytype", " ORDER BY id desc ");
		$data["table_properties"]									= $this->view_table_properties();
	

	
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
		
	}
	
	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $data["_directory"] . "edit.php";

		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
	}
	
	
	

	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		
	
		$data['_pageview']											= $data["_directory"] . "edit.php";
		$this->save_detail( 	$this,
						   		ADMINCMS_TEMPLATE_VIEW,  
						   		$data, 
						   		NULL, 
						   		$this->functions->_admincms_logged_in_details( "id" ) 
						   );
		
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("categorytype", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		$this->edit_detail( $this, $edit_id, $edit_details, $data );
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
		
	}
	
	
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		
		if ( $_POST['options'] == "ajax_update_sorting" )
		{
			$is_post		= TRUE;
		}
		else if ( isset($_POST['checkbox_options']) )
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
					$this->delete( $this, $_POST['checkbox_options'] );
					break;
					
				case "ajax_update_sorting":
					$this->ajax_update_sorting( $this, $_POST['sorting'] );
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