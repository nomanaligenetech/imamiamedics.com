<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include( APPPATH . 'controllers/admincms/managecmscontent/controls_include.php' );
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
		
		
		$this->data["_heading"]										= 'Manage Chapter Location';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/timelinehistory/";
		
	
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		
		
		#include_once(APPPATH . 'controllers/admincms/managecmscontent/controls_include.php');
		#$this->data['Controls_Include']								= new Controls_Include();
		#$this->data['Controls_Include']->_create_child_for_form(false, $this->data, array());
		$this->_widget_create_child_for_form(false, $this->data, array()); #controls_include
		
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('Title', 'Slug', 'Country', 'Short Desc', 'Sort', 'Status');
		
		return $tmp;
	}
	
	public function view( $is_ajax = 0 )
	{
		$data														= $this->data;
		
		
		$data["table_record"]										= $this->queries->fetch_records("chapterslocation_master", " ORDER BY id desc ");
		$data["table_properties"]									= $this->view_table_properties();
	

	
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
		
	}
	
	public function index ()
	{
		
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
		
		
		
	
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		
		
		
		$this->form_validation->set_rules("title", "Title", "trim|required");
		$this->form_validation->set_rules("countryid", "Country", "trim|required");
		$this->form_validation->set_rules("show_map_with_title", "show_map_with_title", "trim");
		$this->form_validation->set_rules("short_desc", "Short Description", "trim|required|max_length[200]");
		$this->form_validation->set_rules("full_desc", "Full Description", "trim|required");
		
		
		for( $x=0; $x < count( $_POST["chapter_address"] ); $x++ )
		{
			$this->form_validation->set_rules("chapter_address[$x]", "Chapter Address", "trim|required");
			$this->form_validation->set_rules("chapter_tel[$x]", "Chapter Tel", "trim");
			$this->form_validation->set_rules("chapter_mobile[$x]", "Chapter Mobile", "trim");
			$this->form_validation->set_rules("chapter_website[$x]", "Chapter Website", "trim");
		}
		
		
		
		
		$this-> _widget_validate(); #controls_include
		
		
		
		for( $x=0; $x < count( $_POST["breadcrumb_text"] ); $x++ )
		{
			$this->form_validation->set_rules("breadcrumb_text[$x]", "BreadCrumb Text", "trim");
			$this->form_validation->set_rules("breadcrumb_link[$x]", "BreadCrumb Link", "trim");
			$this->form_validation->set_rules("chapter_website[$x]", "BreadCrumb Website", "trim");
			$this->form_validation->set_rules("breadcrumb_menuid[$x]", "BreadCrumb Menuid", "trim");
		}
		
		
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			
		
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			
			
			
			 $saveData											= array("title"					=> $this->input->post('title'),
																		"countryid"				=> $this->input->post('countryid'),
																		
																		"show_map_with_title"	=> format_bool( $this->input->post('show_map_with_title') ),
																		
																		"slug"					=> $this->queries->make_slug(	"tb_chapterslocation_master",
																																"id",
																																"slug",
																																"title",
																																$this->input->post("title"),
																																$this->input->post("id")
																															),
																		
																		"short_desc"			=> $this->input->post('short_desc'),
																		"full_desc"				=> $this->input->post('full_desc'),
																		"status"				=> format_bool( $this->input->post('status') ),
																		"date_added"			=> date("Y-m-d H:i:s"));
			 
			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_chapterslocation_master", 'id');  
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_chapterslocation_master", 'id');  		
				$saveData['id']										= $this->db->insert_id();
			}
			
			
			
			
			
			
			$TMP_child						= array("parentid"				=> $saveData['id']);
			$this->queries->SaveDeleteTables($TMP_child, 'd', "tb_chapterslocation_details", 'parentid');  
			if ( isset($_POST['chapter_address']) )
			{
				
				$_POST['chapter_address']						= array_values($_POST['chapter_address']);
				$_POST['chapter_tel']							= array_values($_POST['chapter_tel']);
				$_POST['chapter_mobile']						= array_values($_POST['chapter_mobile']);
				$_POST['chapter_website']						= array_values($_POST['chapter_website']);
				
				for ($m=0; $m < count($_POST['chapter_address']); $m++)
				{
					
					$TMP_child						= array("parentid"						=> $saveData['id'],
															"chapter_address"				=> $_POST["chapter_address"][$m],
															"chapter_tel"					=> $_POST["chapter_tel"][$m],
															"chapter_mobile"				=> $_POST["chapter_mobile"][$m],
															"chapter_website"				=> $_POST["chapter_website"][$m]
															);
					
					
					$this->queries->SaveDeleteTables($TMP_child, 's', "tb_chapterslocation_details", 'parentid');  
				}
			}
			
			
			
			$TMP_child						= array("parentid"				=> $saveData['id']);
			$this->queries->SaveDeleteTables($TMP_child, 'd', "tb_chapterslocation_breadcrumbs", 'parentid');  
			if ( isset($_POST['breadcrumb_text']) )
			{
				
				$_POST['breadcrumb_text']						= array_values($_POST['breadcrumb_text']);
				$_POST['breadcrumb_link']						= array_values($_POST['breadcrumb_link']);
				$_POST['breadcrumb_menuid']						= array_values($_POST['breadcrumb_menuid']);
				
				for ($m=0; $m < count($_POST['breadcrumb_text']); $m++)
				{
					if ( $_POST["breadcrumb_menuid"][$m] == "" )
					{
						$_POST["breadcrumb_menuid"][$m]			= NULL;	
					}
					
					$TMP_child						= array("parentid"						=> $saveData['id'],
															"breadcrumb_text"				=> $_POST["breadcrumb_text"][$m],
															"breadcrumb_link"				=> $_POST["breadcrumb_link"][$m],
															"breadcrumb_menuid"				=> $_POST["breadcrumb_menuid"][$m]
															);
					
					
					$this->queries->SaveDeleteTables($TMP_child, 's', "tb_chapterslocation_breadcrumbs", 'parentid');  
				}
			}
			
			$this->_widget_save( WIDGET_CMSSECTION_CHAPTERLOCATION, $saveData ); #this file
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	}

	public function _widget_save($TMP_cmssection, $saveData)
	{

		if ($saveData['id'] == null) {
			$this->db->query("DELETE FROM tb_chapterlocation_widgets WHERE parentid is NULL and cmssection = '" . $TMP_cmssection . "' ");
		} else {
			$tmp_delete = array(
				"parentid" => $saveData['id'],
				"cmssection" => $TMP_cmssection
			);

			$this->queries->SaveDeleteTables($tmp_delete, 'd', "tb_chapterlocation_widgets", 'parentid|cmssection');
		}
		
		
		#left widgets
		if ($this->input->post("left_widget_id")) {
			foreach ($this->input->post("left_widget_id") as $key => $value) {
				$childData = array(
					"parentid" => $saveData['id'],
					"is_mode" => "left",
					"widget_id" => $value,
					"cmssection" => $TMP_cmssection
				);

				$this->queries->SaveDeleteTables($childData, 's', "tb_chapterlocation_widgets", 'id');
			}
		}
		
		
		
		#right widgets
		if ($this->input->post("right_widget_id")) {
			foreach ($this->input->post("right_widget_id") as $key => $value) {
				$childData = array(
					"parentid" => $saveData['id'],
					"is_mode" => "right",
					"widget_id" => $value,
					"cmssection" => $TMP_cmssection
				);

				$this->queries->SaveDeleteTables($childData, 's', "tb_chapterlocation_widgets", 'id');
			}
		}
		
		
		
		
		#center widgets
		if ($this->input->post("center_widget_id")) {
			foreach ($this->input->post("center_widget_id") as $key => $value) {
				$childData = array(
					"parentid" => $saveData['id'],
					"is_mode" => "center",
					"widget_id" => $value,
					"cmssection" => $TMP_cmssection
				);

				$this->queries->SaveDeleteTables($childData, 's', "tb_chapterlocation_widgets", 'id');
			}
		}
	}
	
	
	
	public function _create_child_for_form2( $return_array = false, &$data, $db_data = array() )
	{		
		$empty_inputs				= array("chapter_address", "chapter_tel", "chapter_mobile", "chapter_website");
		
		$filled_inputs				= array("chapter_address", "chapter_tel", "chapter_mobile", "chapter_website");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				
				for ($m=0; $m < count($db_data); $m++)
				{
					
					if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					{
						
						$data[ $empty_inputs[$x] ][ $m ]	= $db_data[$m][ $filled_inputs[$x] ];
						$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
						
					}
				}
				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			#$this->form_validation->run();
		
		
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ][] = '';
			}
			
			return $data;
		
		}

	}
	
	
	
	public function _create_child_for_form3( $return_array = false, &$data, $db_data = array() )
	{		
	
		$empty_inputs				= array("breadcrumb_text", "breadcrumb_link", "breadcrumb_menuid");
		
		$filled_inputs				= array("breadcrumb_text", "breadcrumb_link", "breadcrumb_menuid");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				
				for ($m=0; $m < count($db_data); $m++)
				{
					
					if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					{
						
						$data[ $empty_inputs[$x] ][ $m ]	= $db_data[$m][ $filled_inputs[$x] ];
						$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
						
					}
				}
				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			#$this->form_validation->run();
		
		
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ][] = '';
			}
			
			return $data;
		
		}

	}
	
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "title", "countryid", "show_map_with_title", "short_desc", "full_desc", "status", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "title", "countryid", "show_map_with_title", "short_desc", "full_desc", "status", "options", "unique_formid" );
		
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
						case "default_date":	
							$tmp_value			= date("d-m-Y", strtotime( $db_data[ $filled_inputs[$x] ] ) );
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
	
	public function _create_array_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array( "caption" );
		$filled_inputs				= array( "caption" );
		$languages					= $data["languages"];

		
		
		if ($return_array == true and count($db_data) > 0 )
		{
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			
			#loop with the parent object... for e.g. Types of Promo Codes
			foreach ($loop_object as $main)
			{
				
				$language_id				= $main["id"];
				
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					#second - if value found it will overwrite above array.
					foreach ( $db_data as $loop )
					{
						if ( $loop["languageid"] == $language_id )
						{
							$detail_array[ $main["id"] ] [ $empty_inputs[$x] ]			= $loop[ $filled_inputs[$x] ];	
						}
						
					}
				}
			}			
			
			ksort( $detail_array );
		
			$data["_detail_array"]	= $detail_array;
			
			
			return $data;
		}
		else
		{
			
			

			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			$data["_detail_array"]	= $detail_array;
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("chapterslocation_master", " AND id = '$edit_id' ");
		//echo $this->db->last_query(); die;
		
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		
		
		$child_details												= $this->queries->fetch_records("chapterslocation_details", " AND parentid = '$edit_id' ");
		$this->_create_child_for_form2(true, $data, $child_details->result_array());
		
		
		
		$child_details												= $this->queries->fetch_records("chapterslocation_breadcrumbs", " AND parentid = '$edit_id' ");
		$this->_create_child_for_form3(true, $data, $child_details->result_array());
		
		
		$this-> _widget_edit_child( $data, NULL, WIDGET_CMSSECTION_CHAPTERLOCATION ); #controls_include
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	
	
	public function ajax_update_sorting( $id )
	{
		
		foreach ($id	as $key	=> $result)
		{
			$saveData['sort']										= $result;	
			$saveData['id']											= $key;	
			
			$this->queries->SaveDeleteTables($saveData, 'e', "tb_chapterslocation_master", 'id') ;
		}
		
		$data['_messageBundle']									= $this->_messageBundle( 'success' , "Sort Updated", 'Success!', FALSE, TRUE);
		
		redirect ( site_url( $this->data["_directory"] . "controls/view" ) );
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
					$this->delete( $_POST['checkbox_options'] );
					break;
			
				case "ajax_update_sorting":
					$this->ajax_update_sorting( $_POST['sorting'] );
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
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_chapterslocation_master", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */