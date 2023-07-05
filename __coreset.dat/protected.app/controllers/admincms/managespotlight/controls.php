<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Queries queries
 */
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
		
		
		$this->data["_heading"]										= lang_line("text_spotlight");
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		
		
	
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array(lang_line("text_username") );
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		
		redirect ( redirect( $data["_directory"] . "controls/edit" ) );
		
	}

    public function save()
    {
        $data = $this->data;

        if (!$this->validations->is_post()) {
            redirect(site_url($data["_directory"] . "controls/view"));
        }


        #standard validation
        $this->form_validation->set_rules("id", "id", "trim");
        $this->form_validation->set_rules("title", "Title", "trim|required");
        $this->form_validation->set_rules("description", "Description", "trim|required");
        $this->form_validation->set_rules("url", "Url", "trim|required");
        $this->form_validation->set_rules("buttontype", "Button Type", "trim|required");
        // $this->form_validation->set_rules("button_link", "Button Link", "trim|required");
        
   

        if ($this->form_validation->run() == FALSE) {
            $data['_pageview'] = $data["_directory"] . "edit.php";
            $data['_messageBundle'] = $this->_messageBundle('danger', validation_errors(), 'Error!');

            $this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
        } else {


            $saveData = array("id" => $this->input->post("id"),

                "title" => $this->input->post("title"),
                "short_desc" => $this->input->post("description"),
                "url" => $this->input->post("url"),
                "button_type" => $this->input->post("buttontype"),
                "button_link" => $this->input->post("button_link"),
            );

			
            $this->queries->SaveDeleteTables($saveData, 'e', "tb_spotlight", 'id');


            $data['_messageBundle'] = $this->_messageBundle('success',
                lang_line("operation_saved_success"),
                lang_line("heading_operation_success"),
                false,
                true);

            redirect($data["_directory"] . "controls/edit");


        }

    }
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
    $empty_inputs				= array( "id", "title", "short_desc","url","button_type", "button_link" );
		
    $filled_inputs				= array( "id", "title", "short_desc","url","button_type", "button_link" );
		
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


    public function edit($edit_id = 0)
    {
        $data = $this->data;


        $data['_pageview'] = $data["_directory"] . "edit.php";

        $data["edit_id"] = $edit_id;
        $edit_details = $this->queries->fetch_records("spotlight");

        if ($edit_details->num_rows() <= 0) {
            #show_404();
        }


        #pre-filled values for input fields

        $edit_details = $edit_details->row_array();
        $edit_details['options'] = "edit";
        $edit_details['unique_formid'] = "";

        $this->_create_fields_for_form(true, $data, $edit_details);


        $this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);

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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */