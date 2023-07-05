<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("controls_include.php");
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
		
		
		$this->data["_heading"]										= 'Manage CMS Content';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./images/station/";
		
		$this->data['content_languages'] = $this->queries->fetch_records("content_languages", " ORDER BY id DESC ")->result_array();
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_lang_fields_for_form(false, $this->data, array());
		$this->_widget_create_child_for_form(false, $this->data, array());
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Menu', 'Left Widgets', 'Right Widgets', 'Center Widgets', 'Int/Can', 'Last Updated');
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("cmscontent", " ORDER BY ID DESC ");
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
		
		
		
		include_once(APPPATH.'controllers/ajaxmethods.php');
		
		
		#standard validation
		#$this->form_validation->set_rules("id", "id", "trim");
		#$this->form_validation->set_rules("options", "options", "trim");
		#$this->form_validation->set_rules("unique_formid", "unique_formid", "trim");
		
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		
		
		
		
	
		//$tmp_validate_DB				= $this->queries->fetch_records("cmscontent", " AND menuid = '". $this->input->post("menuid") ."' ");
		$tmp_validate_DB				= $this->queries->fetch_records("cmscontent", " AND menuid = '". $this->input->post("menuid") ."' AND belongsto IN (1, ".$this->input->post("belongsto").") ");
		$tmp_validate_VALUES			= $this->find_duplicate_values($tmp_validate_DB, $this->input->post("id"));
		$this->form_validation->set_rules("menuid", "Menu", "trim|required|callback_validate_duplicate[". $tmp_validate_VALUES ."]");
		
		
		$this->_widget_validate();
		
		$this->rules_for_array_content('content');
		
		
		if( $this->form_validation->run() == FALSE )
		{
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');

			// $cmscontent = $tmp_validate_DB->row_array();
			
			// $edit_lang_details = [];
			// if(!empty($cmscontent)){
			// 	$edit_lang_details									= $this->queries->fetch_records("cmscontent_languages", " AND cmscontent_id = {$cmscontent['id']} ")->result_array();
			// }
			// foreach ($edit_lang_details as $key => $record) {
			// 	$_POST["content"][$record['content_languages_id']]	= $record;
			// }
			// $this->_create_lang_fields_for_form(true, $data, $this->data['content_languages'], $edit_lang_details );	

			$tmp_ajax_output1									= (new AjaxMethods())->cmstype_with_cmsmenu_by_lang( $this->input->post("menuid"), FALSE, $this->data['content_languages'] );
			if ( $tmp_ajax_output1["_CSS_show_messages"] != "error" )
			{
				$data['ajax_output1']							= $tmp_ajax_output1["_TEXT_show_messages"];
			}
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			$short_desc = $this->input->post("short_desc");
			$content = $this->input->post("content");
			$user_id =  $this->functions->_admincms_logged_in_details( "id" );
			$saveData											= array("menuid"						=> $this->input->post("menuid"),
																		"belongsto"						=> $this->input->post('belongsto'),
																		"short_desc" 					=> $short_desc[DEFAULT_LANG_CODE],
																		"content" 						=> $content[DEFAULT_LANG_CODE],
																		"added_by"						=> $user_id
																	);		
			
	
		
			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_cmscontent", 'id');  

				$this->_save_lang_content($saveData['id'], 'e');
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_cmscontent", 'id');  		
				$saveData['id']										= $this->db->insert_id();

				$this->_save_lang_content($saveData['id'], 's');
			}
			
			
			
		
			$this->_widget_save( WIDGET_CMSSECTION_CMSCONTENT, $saveData );
			
			
			
			
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	}

	private function rules_for_array_content($field = 'content')
	{
		$content = $this->input->post($field);
		if($field){
			$isAllEmpty = true;
			foreach ($content as $key => $record) {
				if(!empty($record)){
					$isAllEmpty = false;
				}
			}
			if($isAllEmpty)
			{
				$this->form_validation->set_rules($field, "Content", "trim|required");
			}
		}
	}
	
	private function _save_lang_content($ref_id, $action){
		$short_desc = $this->input->post("short_desc");
		$content = $this->input->post("content");

		$cmscontent = $this->queries->fetch_records("cmscontent_languages", " AND cmscontent_id = '$ref_id' ")->result_array();

		foreach ($this->data['content_languages'] as $lang_key => $lang) {
			$saveData = [
				'short_desc' => $short_desc[$lang['code']],
				'content' => $content[$lang['code']],
				'cmscontent_id' => $ref_id,
				'content_languages_id' => $lang['id']
			];
			
			// if(!$cmscontent && !in_array($lang['code'], array_column($cmscontent,'content_languages_id'))){
			if(!$cmscontent || ($cmscontent && !in_array($lang['id'], array_column($cmscontent,'content_languages_id')))){
				$col = 'id';
				$action = 's';
			}else{
				$col = 'content_languages_id|cmscontent_id';
				$action = 'e';
			}
			
			$this->queries->SaveDeleteTables($saveData, $action, "tb_cmscontent_languages", $col);
		}
	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "include_title", "custom_title", "menuid", "belongsto", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "include_title", "custom_title", "menuid", "belongsto", "options", "unique_formid" );
		
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
	
	public function _create_lang_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array( "short_desc", "content");
		$filled_inputs				= array( "short_desc", "content");
		
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
						if ( $loop["content_languages_id"] == $language_id )
						{
							$detail_array[ $main["id"] ] [ $empty_inputs[$x] ]			= $loop[ $filled_inputs[$x] ];	
						}
						
					}
				}
			}			
			
			ksort( $detail_array );
		
			$data["lang_content"]	= $detail_array;
			
			
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
			
			$data["lang_content"]	= $detail_array;
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("cmscontent", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		

		
		$this-> _widget_edit_child( $data, $edit_id, WIDGET_CMSSECTION_CMSCONTENT );

		
		include_once(APPPATH.'controllers/ajaxmethods.php');

		$edit_lang_details									= $this->queries->fetch_records("cmscontent_languages", " AND cmscontent_id = '$edit_id' ")->result_array();
		$this->_create_lang_fields_for_form(true, $data, $this->data['content_languages'], $edit_lang_details );	
		
		foreach ($edit_lang_details as $key => $record) {
			$_POST["content"][$record['content_languages_id']]	= $record;
		}
        $tmp_ajax_output1									= (new AjaxMethods())->cmstype_with_cmsmenu_by_lang( $edit_details["menuid"], FALSE, $this->data['content_languages'] );
		if ( $tmp_ajax_output1["_CSS_show_messages"] != "error" )
		{
			$data['ajax_output1']							= $tmp_ajax_output1["_TEXT_show_messages"];
		}
		
		
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
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_cmscontent", 'id') ;
			$this->queries->SaveDeleteTables(['cmscontent_id'=>$result], 'd', "tb_cmscontent_languages", 'cmscontent_id') ;
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