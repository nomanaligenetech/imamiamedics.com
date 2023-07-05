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

			#upload files extensions
		

	}
	
	
	public function ajax_update_sorting( $THIS, $id )
	{
		
		foreach ($id	as $key	=> $result)
		{
			$saveData['sort']										= $result;	
			$saveData['id']											= $key;	
			
			$THIS->queries->SaveDeleteTables($saveData, 'e', "tb_pressrelease", 'id') ;
		}
		
		$data['_messageBundle']									= $THIS->_messageBundle( 'success' , "Sort Updated", 'Success!', FALSE, TRUE);
		
		redirect ( site_url( $THIS->data["_directory"] . "controls/view" ) );
	}
	
	
	public function save_detail( $THIS, $LOAD_VIEW, &$data, $created_by_user = NULL, $created_by_admin = NULL )
	{
		

	//	echo $data['video_types']; die;
     
     $adminid=$this->functions->_admincms_logged_in_details('id'); 
		

		#re-unite post values + language array with form_validations
		$THIS->functions->unite_post_values_form_validation();
		
		
		$this->form_validation->set_rules("name", "News Title ", "trim|required");
		$this->form_validation->set_rules("description", "News Description", "trim|required");
		$this->form_validation->set_rules("date", "News Date", "trim|required");
	
	

		if( $THIS->form_validation->run() == FALSE )
		{
			$data['_messageBundle']								= $THIS->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$THIS->load->view( $LOAD_VIEW, $data );
		}
		else
		{
				#################################
				###  	upload_video_1  	  ###
				#################################
		

			if ( 1==1 )
			{
				
				$other_upload						= array("validate"		=> TRUE,
															"input_field"	=> "file_video_news",
															"db_field"		=> "news_video",
															"input_nick"	=> "Video",
															"hdn_field"		=> "files_news_videos",
															"tmp_table_field"	=> "upload_1",
															"is_multiple"	=> TRUE);

				
				$config_video						= array("upload_path"	=> $data["videos_dir"],
															"allowed_types"	=> $data['video_types'],
															'max_size'		=> '1048576', //1GB
															"encrypt_name"	=> TRUE);

			
				$config_thumb						= array();
				
				$tmp_upload_video_1					= $THIS->upload_image($config_video, $config_thumb, $other_upload);
			

					$THIS->tmp_record_uploads_in_db( TRUE, $tmp_upload_video_1  );
			
			}


			#################################
			###  	News Pdf Uploads 	  ###
			#################################

			if ( 1==1 )
			{

			$other_upload						= array("validate"											=> FALSE,
														"input_field"										=> "file_pdf_news",
														"db_field"											=> "news_pdf",
														"input_nick"										=> "news_pdf",
														"hdn_field"											=> "files_news_pdf",
														"tmp_table_field"									=> "upload_2",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["pdfs_dir"],
														"allowed_types"										=> $data['pdf_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
		
		

			$tmp_upload_image_2					= $this->upload_image($config_image, $config_thumb, $other_upload);
	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_2  );

			
        	}	
	
		
			
			 $saveData											= array("name"	=> $this->input->post('name'),
																		"date"=>date('Y-m-d',strtotime($this->input->post('date'))),
																		"description"=>$this->input->post('description'),
																		"slug"		=>$this->queries->make_slug("tb_forum",
																															"id",
																															"slug",
																															"name",
																															$this->input->post("name"),
																															$this->input->post("id")
																															),
																		);
			
			

			if ($THIS->input->post('options') == "edit")
			{
				$saveData['id']										= $THIS->input->post('id');
				$THIS->queries->SaveDeleteTables($saveData, 'e', "tb_news", 'id');  		
				$saveData['id']								     = $THIS->input->post('id');

			
  foreach($tmp_upload_image_2  as $array){
            
              if(isset($array['news_pdf']))
              {

					$childData					= array("parentid"					=> $saveData['id'],
														"news_pdf"			=> $tmp_upload_image_2['upload_path'].$array['news_pdf']
														);
	$this->queries->SaveDeleteTables($childData, 's', "tb_news_pdf", 'id');  		
				}
			}


			foreach($tmp_upload_video_1 ['hdn_array'] as $array){
            
            if(isset($array['full_path']))
            {
			
					$childData					= array("parentid"					=> $saveData['id'],
														"news_videos"			=> $tmp_upload_video_1['upload_path'].$array['file_name']
														);
					
					
					
					$this->queries->SaveDeleteTables($childData, 's', "tb_news_videos", 'id');  		
				}
			}
			
			
			
		$data['_messageBundle']									= $THIS->_messageBundle( 'success' , 
																							 lang_line("News Successfully Saved"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);
						 
			}
			else
			{

				$THIS->queries->SaveDeleteTables($saveData, 's', "tb_news", 'id');  		
				$saveData['id']								     = $this->db->insert_id();


		
		
	    foreach($tmp_upload_image_2  as $array){
            
            if(isset($array['hdn_array']))
            {
					$childData					= array("parentid"					=> $saveData['id'],
														"news_pdf"			=> $tmp_upload_image_2['upload_path'].$array['file_name']
														);

					$this->queries->SaveDeleteTables($childData, 's', "tb_news_pdf", 'id');  		
				}
			}


			foreach($tmp_upload_video_1 ['hdn_array'] as $array){
            
            if(isset($array['full_path']))
            {
			
					$childData					= array("parentid"					=> $saveData['id'],
														"news_videos"			=> $tmp_upload_video_1['upload_path'].$array['file_name']
														);
					
					$this->queries->SaveDeleteTables($childData, 's', "tb_news_videos", 'id');  		
				}
			}
			
			
			
			$data['_messageBundle']									= $THIS->_messageBundle( 'success' , 
																							 lang_line("News Successfully Saved"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			}

		}	
			redirect( site_url( $data["_directory"] . "controls/view" ) );
	}
	
	
	
	public function edit_detail( $THIS, $edit_id, $edit_details, &$data)
	{
		$edit_details												= $edit_details->row_array();
		
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		if ( $THIS == NULL )
		{
			$THIS				= $this;	
		}
		
		$THIS->_create_fields_for_form(true, $data, $edit_details);
	  }
	
	
	public function delete( $THIS, $id )
	{
		$data												= $THIS->data;

		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
		
			$saveData['id']									= $result;	
			$THIS->queries->SaveDeleteTables($saveData, 'd', "tb_news", 'id') ;

			$row											= $this->queries->fetch_records("news_videos", " AND parentid = '$result' ");
		
			foreach($row->result_array()as $rec){
	            $file=$rec['news_videos'];
	         
	         	$this->remove_file($file);
				$saveData['id'] =$rec['id'];
				$THIS->queries->SaveDeleteTables($saveData, 'd', "tb_news_videos", 'id') ;		

			}

			$row											= $this->queries->fetch_records("news_pdf", " AND parentid = '$result' ");
			
			foreach($row->result_array()as $rec){
				
				$file=$rec['news_pdf'];
				$this->remove_file($file);
				$saveData['id'] =$rec['id'];
				$THIS->queries->SaveDeleteTables($saveData, 'd', "tb_news_pdf", 'id') ;
			}
	
					
	
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
	
	  $empty_inputs				= array( "id", "name",  "slug", "description","date","sort","options");
		
		$filled_inputs				= array(  "id", "name", "slug", "description","date","sort","options");	
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