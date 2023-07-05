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
	 
	public function __construct( $load = TRUE )
	{
		parent::__construct();
	}
	
	
	
	public function _widget_create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("right_widget_id", "left_widget_id", "center_widget_id");
		
		$filled_inputs				= array("right_widget_id", "left_widget_id", "center_widget_id");
				
		
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
						$data[ $empty_inputs[$x] ][$db_data[$m][ $filled_inputs[$x] ] ]	= TRUE;
					}
				}
				
			
			}
			
			
			
			
			
			
			return $data;
		}
		else
		{
			
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				if ( $empty_inputs[$x] == "left_widget_id" )
				{
					foreach (left_widgets() as $lw )
					{	
						$data[ $empty_inputs[$x] ][ $lw['id'] ]			= '';	
					}
					
				}
				else if ( $empty_inputs[$x] == "right_widget_id" )
				{
					foreach (right_widgets() as $rw )
					{	
						$data[ $empty_inputs[$x] ][ $rw['id'] ]			= '';	
					}
				}
				else if ( $empty_inputs[$x] == "center_widget_id" )
				{
					foreach (center_widgets() as $rw )
					{	
						$data[ $empty_inputs[$x] ][ $rw['id'] ]			= '';	
					}
				}
				
			}
	
			
			return $data;
		
		}
	}
	
	public function _widget_edit_child( &$data, $edit_id = NULL, $cmssection = NULL )
	{
		$TMP_parentid_edit											= " AND parentid = '$edit_id' ";
		if ( $edit_id == NULL )
		{
			$TMP_parentid_edit										= " AND parentid is NULL ";
		}
		
		$child_details												= $this->queries->fetch_records("cmscontent_widgets", 
																									" $TMP_parentid_edit  AND is_mode = 'left' AND cmssection = '$cmssection' ", 
																									" widget_id as left_widget_id ");		
		
	
		$this->_widget_create_child_for_form(true, $data, $child_details->result_array() );
		$data['left_widget_id']										= $this->functions->sortArrayByArray( $data['left_widget_id'], $child_details->result_array(), "left_widget_id" );
		
		
		
		$child_details												= $this->queries->fetch_records("cmscontent_widgets", 
																									" $TMP_parentid_edit  AND is_mode = 'right' AND cmssection = '$cmssection' ",
																									" widget_id as right_widget_id ");		
		$this->_widget_create_child_for_form(true, $data, $child_details->result_array() );
		$data['right_widget_id']									= $this->functions->sortArrayByArray( $data['right_widget_id'], $child_details->result_array(), "right_widget_id" );
		
		
		$child_details												= $this->queries->fetch_records("cmscontent_widgets", 
																									" $TMP_parentid_edit  AND is_mode = 'center' AND cmssection = '$cmssection' ",
																									" widget_id as center_widget_id ");		
		$this->_widget_create_child_for_form(true, $data, $child_details->result_array() );
		$data['center_widget_id']									= $this->functions->sortArrayByArray( $data['center_widget_id'], $child_details->result_array(), "center_widget_id" );	
	}
	
	public function _widget_validate(  )
	{
		$this->form_validation->set_rules("right_widget_id[]", "Widget Id", "trim");
		$this->form_validation->set_rules("left_widget_id[]", "Widget Id", "trim");
		$this->form_validation->set_rules("center_widget_id[]", "Widget Id", "trim");			
	}
	
	public function _widget_save( $TMP_cmssection, $saveData )
	{
		
		if ( $saveData['id'] == NULL )
		{
			$this->db->query( "DELETE FROM tb_cmscontent_widgets WHERE parentid is NULL and cmssection = '". $TMP_cmssection ."' " );
		}
		else
		{
			$tmp_delete			= array("parentid"			=> $saveData['id'],
										"cmssection"		=> $TMP_cmssection);
			
			$this->queries->SaveDeleteTables($tmp_delete, 'd', "tb_cmscontent_widgets", 'parentid|cmssection');  
		}
		
		
		#left widgets
		if ( $this->input->post("left_widget_id") )
		{
			foreach ($this->input->post("left_widget_id") as $key => $value )
			{
				$childData					= array("parentid"			=> $saveData['id'],
													"is_mode"			=> "left",
													"widget_id"			=> $value,
													"cmssection"		=> $TMP_cmssection);
				
				$this->queries->SaveDeleteTables($childData, 's', "tb_cmscontent_widgets", 'id');  		
			}
		}
		
		
		
		#right widgets
		if ( $this->input->post("right_widget_id") )
		{
			foreach ($this->input->post("right_widget_id") as $key => $value )
			{
				$childData					= array("parentid"			=> $saveData['id'],
													"is_mode"			=> "right",
													"widget_id"			=> $value,
													"cmssection"		=> $TMP_cmssection);
				
				$this->queries->SaveDeleteTables($childData, 's', "tb_cmscontent_widgets", 'id');  		
			}
		}
		
		
		
		
		#center widgets
		if ( $this->input->post("center_widget_id") )
		{
			foreach ($this->input->post("center_widget_id") as $key => $value )
			{
				$childData					= array("parentid"			=> $saveData['id'],
													"is_mode"			=> "center",
													"widget_id"			=> $value,
													"cmssection"		=> $TMP_cmssection);
				
				$this->queries->SaveDeleteTables($childData, 's', "tb_cmscontent_widgets", 'id');  		
			}
		}	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */