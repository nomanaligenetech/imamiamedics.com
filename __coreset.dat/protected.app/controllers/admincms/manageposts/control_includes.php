<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls_Include extends C_admincms {

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
	 
	public function __construct( $param = TRUE )
	{
		$include_construct					= TRUE;
		if ( is_array($param) )
		{
			if ( array_key_exists("load", $param) )
			{
				if ( !$param['load'] )
				{
					$include_construct		= FALSE;
				}
			}
		}
		
		if ( $include_construct )
		{
			parent::__construct();
		}
	}
	
	
	public function ajax_update_sorting( $THIS, $id )
	{
		
		foreach ($id	as $key	=> $result)
		{
			$saveData['sort']										= $result;	
			$saveData['id']											= $key;	
			
			$THIS->queries->SaveDeleteTables($saveData, 'e', "tb_forum_topics", 'id') ;
		}
		
		$data['_messageBundle']									= $THIS->_messageBundle( 'success' , "Sort Updated", 'Success!', FALSE, TRUE);
		
		redirect ( site_url( $THIS->data["_directory"] . "controls/view" ) );
	}
	
	
	public function save_detail( $THIS, $LOAD_VIEW, &$data, $created_by_user = NULL, $created_by_admin = NULL )
	{

	    $adminid=$this->functions->_admincms_logged_in_details('id'); 
	
		#re-unite post values + language array with form_validations
		$THIS->functions->unite_post_values_form_validation();
		
		
		$this->form_validation->set_rules("topic", "Topic ", "trim|required");
		$this->form_validation->set_rules("name", "Topic Post", "trim|required");
		
	

		if ( 1==1 )
		{
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> FALSE,
														"input_field"										=> "photo_path",
														"db_field"											=> "photo_image",
														"input_nick"										=> "Image",
														"hdn_field"											=> "photo_image",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $THIS->upload_image($config_image, $config_thumb, $other_upload);
		
			
			#insert in tmp table	
			$THIS->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1  );
			
		
			#################################
			###  	upload_image_1  	  ###
			#################################
			
		}
		
		
		if( $THIS->form_validation->run() == FALSE )
		{
		
			
			
			$data['_messageBundle']								= $THIS->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$THIS->load->view( $LOAD_VIEW, $data );
		}
		else
		{
				
			 $saveData											= array("name"	=> $this->input->post('name'),
																		"description"=>$this->input->post('description'),
																		"slug"		=>$this->queries->make_slug("tb_posts",
																															"id",
																															"slug",
																															"name",
																															$this->input->post("name"),
																															$this->input->post("id")
																															),
																		"topic_id"   =>$this->input->post('topic'),
																		"created_by_admin"  =>$adminid
																		);
		
		 $updateData											= array("name"	=> $this->input->post('name'),
																		"description"=>$this->input->post('description'),
																		"slug"		=>$this->queries->make_slug("tb_posts",
																															"id",
																															"slug",
																															"name",
																															$this->input->post("name"),
																															$this->input->post("id")
																															),
																		"topic_id"   =>$this->input->post('topic')
																		);
		



	if ($THIS->input->post('options') == "edit")
			{
				$updateData['id']										= $this->input->post('id');
				$THIS->queries->SaveDeleteTables($updateData, 'e', "tb_posts", 'id');
			
			}
			else
			{
				$THIS->queries->SaveDeleteTables($saveData, 's', "tb_posts", 'id');  		
				$saveData['id']										= $THIS->db->insert_id();
			}
			
			
			
			
			$data['_messageBundle']									= $THIS->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( site_url( $data["_directory"] . "controls/view" ) );
			
		
		}	
	}
	
	
	
	public function edit_detail( $THIS, $edit_id, $edit_details, &$data )
	{
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		if ( $THIS == NULL )
		{
			$THIS				= $this;	
		}
		
		$THIS->_create_fields_for_form(true, $data, $edit_details );
	}
	
	
	public function delete( $THIS, $id )
	{
		$data												= $THIS->data;
		
		
		
	
		#remove images
		foreach ($id	as $key	=> $result)
		{
			$row											= $THIS->queries->fetch_records("category", " AND id = '$result' ")->row();
			$THIS->remove_file($row->photo_image);
		}
		
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$THIS->queries->SaveDeleteTables($saveData, 'd', "tb_posts", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $THIS->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
	    $empty_inputs				= array("id","topic_id","name","description","slug","date","created_by_admin","options");
		
		$filled_inputs				= array("id","topic_id","name","description","slug","date","created_by_admin","options");
		
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

	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */