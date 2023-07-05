<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include( APPPATH . 'controllers/admincms/managepressrelease/control_includes.php' );
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
		
		/*$this->data["_forumtopicdir"]									="admincms/manageforumtopics/";
*/
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'Manage Pressrelease';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		$this->data["images_types"]									= "pdf";
		$this->data["images_dir_pressrelease"]	 					= SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/press_release_uploads/";
	
		#upload files extensions
		

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
		$tmp["tr_heading"]											= array('Name','Release Date','slug');
	
		return $tmp;
	}
	
	public function view( $is_ajax = 0 )
	{
		
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("pressRelease", " ORDER BY id desc ");
	
		//echo $this->db->last_query(); die;
		$data["table_properties"]									= $this->view_table_properties();
	

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
		
	}

	public function add()
	{
		$data												= $this->data;
		
		
		$data["table_record"]										= $this->queries->fetch_records("pressRelease", " ORDER BY id DESC ");
	
	
		$data['_pageview']									= $data["_directory"] . "edit.php";

		$this->load->view(ADMINCMS_TEMPLATE_VIEW,$data);	
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
		$edit_details												= $this->queries->fetch_records("pressRelease", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		$this->edit_detail( $this, $edit_id, $edit_details, $data);
		
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
	

		public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "name", "pressreleas_date", "slug", "description","pressrelease_pdf","options");
		
		$filled_inputs				= array(  "id", "name", "pressreleas_date", "slug", "description","pressrelease_pdf","options");
		
		//$filled_inputs				= array( "id", "resorts_id", "promo_code_percentage_discount_code", "promo_code_percentage_discount_percent", "promo_code_percentage_discount_datefrom", "promo_code_percentage_discount_expiry", "promo_code_value_add_code", "promo_code_value_add_details", "promo_code_value_add_datefrom", "promo_code_value_add_expiry",  "options" );
		
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				

				$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]				= $explode_empty_inputs[0];
				$tmp_value						= $db_data[ $filled_inputs[$x] ];
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "day_time":
							$TMP_sd					= strtotime($db_data[ "start_date" ]);
							if ( $TMP_sd > 0 )
							{
								$tmp_value			= date("d/m/Y h:i A",  $TMP_sd);
								
								
								$TMP_ed					= strtotime($db_data[ "end_date" ]);
								if ( $TMP_ed > 0 )
								{
									$tmp_value		.= " - " . date("d/m/Y h:i A",  $TMP_ed);
								}
							}
							else
							{
								$tmp_value			= "";
							}
							
							break;
							
						case "default_date":
							$d						= strtotime( $db_data[ $filled_inputs[$x] ] );
							if ( $d > 0 )
							{
								$tmp_value			= date("d-m-Y",  $d);
							}
							else
							{
								$tmp_value			= "00-00-0000";
							}
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
				
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				$explode_empty_inputs				= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]					= $explode_empty_inputs[0];
				$tmp_value							= "";
				
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						case "default_date":	
							$tmp_value				= "00-00-0000";
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
			}
			
			return $data;
		
		}
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */