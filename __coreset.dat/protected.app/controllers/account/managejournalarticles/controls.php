<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls extends C_Frontend {

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
		
		$this->load->library( "../controllers/admincms/managejournalarticles/controls_include.php", array("load" => FALSE) );
		
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		$this->data['fake_admincms_path']							= "admincms/{$this->uri->segments[2]}/";
		
		$this->data["_heading"]										= 'Manage Journal Articles';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/journalarticles/";
		
		
			
			
		$this->controls_include->view_table_query( $this->data );
		
		
		
		
		$this->data['assignedto_ids'][]								= 0;
		json_encode( $this->data['assignedto_ids'] );
		
		
		
		$this->data['show_text_only']								= FALSE;
		
		
		
		#pre-filled values for input fields
		$this->controls_include->_create_fields_for_form(false, $this->data);	
		$this->controls_include->_create_child_for_form(false, $this->data, array() );	
		
	}
	
	
	public function view( $is_ajax = 0 )
	{
		$data									= $this->data;
		
		$data["table_record"]					= $this->queries->fetch_records("journalarticle", 
																				" 	AND revised_article_id = 0  AND is_published = '0'
																					AND created_by_user = '{$this->functions->_user_logged_in_details('id')}' ORDER BY id desc ");		
		$data["table_properties"]				= $this->controls_include->view_table_properties();
		
		$data['_pageview']						= $data['fake_admincms_path'] . "view.php";
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}


	public function add()
	{
		$data														= $this->data;
		
		$data['_pageview']											= $data['fake_admincms_path'] . "edit.php";
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );	
	}

	
	public function edit( $edit_id )
	{
		
		$data									= $this->data;
		$data['_pageview']						= $data["fake_admincms_path"] . "edit.php";
		
		$data["edit_id"]						= $edit_id;
		$edit_details							= $this->queries->fetch_records("journalarticle", " AND created_by_user = '{$this->functions->_user_logged_in_details('id')}' AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		$is_assigned_to_reviewers				= $this->queries->fetch_records("journalarticle_approval", " AND journalarticleid = '$edit_id' ");
		if ( $is_assigned_to_reviewers -> num_rows() > 0 )
		{
			$data['show_text_only']				= TRUE;	
			$TMP_data							= array();
			$this->controls_include->edit_detail( $this, $edit_id, $edit_details, $TMP_data );	
			$data['journalarticle_details']		= $TMP_data;
		}
		else
		{
			$this->controls_include->edit_detail( $this, $edit_id, $edit_details, $data );	
		}
		
		
		
		
		
		
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
	
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		
	
		$data['_pageview']									= $data['fake_admincms_path'] . "edit.php";
		if ( isset( $_POST['btn_assign'] ) )
		{
			$data['_pageview']								= $data['fake_admincms_path'] . "assign.php";	
		}

		$this->controls_include->save_detail( 	$this,
											 	FRONTEND_TEMPLATE_ACCOUNT_VIEW,  
						   						$data, 
						   						$this->functions->_user_logged_in_details( "id" ), 
						   						NULL 
						   					);
		
	}


	public function assign( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "assign.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("journalarticle", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		
		
		$TMP_assignedto_ids				= $this->queries->fetch_records("journalarticle_approval", " AND  journalarticleid = '". $edit_id ."' ", " DISTINCT(assignedto) ");
		$data['assignedto_ids']			= json_encode( get_column_result_array( $TMP_assignedto_ids -> result_array(), "assignedto" ) );
		$this->_create_child_for_form(true, $data, $TMP_assignedto_ids->result_array() );	
		

		
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
	
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		
		if ( $_POST['options'] == "ajax_update_sorting" )
		{
			$is_post		= TRUE;
		}
		else if ( $_POST['options'] == "ajax_archiveclonethisarticle" )
		{
			if ( $this->input->post("jid") )
			{
				$is_post		= TRUE;
			}
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
					$this->controls_include->delete( $this, $_POST['checkbox_options'] );
					break;
					
				case "ajax_update_sorting":
					$this->controls_include->ajax_update_sorting( $this, $_POST['sorting'] );
					break;
					
				case "ajax_archiveclonethisarticle":
					echo $this->controls_include->ajax_archiveclonethisarticle( $this, $_POST['jid'] );
					die;
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