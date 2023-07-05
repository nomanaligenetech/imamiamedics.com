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
		
		
		$this->data["_heading"]										= 'Manage Arbaeen Medical Mission';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";

		$this->data['content_languages'] = $this->queries->fetch_records("content_languages", " ORDER BY id DESC ")->result_array();

		$this->load->library("Encrption");

	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('First Name','Last Name','Email','Phone Number','Submission Date','Membership Package','CV','Interviewer','Interviewer Recommendation & Notes','Status');
	
		return $tmp;
	}
	
	public function view_interviewer_table_properties()
	{
		$tmp["tr_heading"]											= array('First Name','Last Name','Email','Phone Number','Submission Date','Membership Package','CV','Status');
	
		return $tmp;
	}
	
	public function rejectedapplications_table_properties()
	{
		$tmp["tr_heading"]											= array('First Name','Last Name','Email','Phone Number','Submission Date','Membership Package','CV','Interviewer','Interviewer Recommendation & Notes','Rejected Notes','Status');
	
		return $tmp;
	}
	
	public function view( $id = 0 )
	{
		$interviewer_roleid = SessionHelper::_get_session("INTERVIEWER_ROLEID", "site_settings");
		$loggedin_roleid = $this->functions->_admincms_logged_in_details( "role_id" );
		$user_id = $this->functions->_admincms_logged_in_details("id");

		$where = '';
		if ( $id > 0 ){
			$where .= ' and amm.id = '.$id;
			$this->data['_pageview']									= $this->data["_directory"] . "view_record.php";
		}else{
			$where .= $interviewer_roleid == $loggedin_roleid ? ' and amm.status = "assigntointerviewer" or amm.status = "scheduleinterview"' : ' and amm.status = "pending" or amm.status = "waitlist" or amm.status = "interviewcallrejected" or amm.status = "recommended" or amm.status = "not-recommended" or amm.status = "stage3"';
		}
		
		$where .= $interviewer_roleid == $loggedin_roleid ? ' and amm.interviewer = '. $user_id : '';

		$data														= $this->data;
		
		$records													= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", $where." ORDER BY amm.date_added desc ");
		
		if ( $id > 0 && $records -> num_rows() <= 0) {
			show_404();
		}

		$data['is_interviewer'] = $interviewer_roleid == $loggedin_roleid ? true : false;

		$data["table_record"]										= $id > 0 ? $records->row() : $records->result_array();
	
		$data["table_properties"]									= $interviewer_roleid == $loggedin_roleid ? $this->view_interviewer_table_properties() : $this->view_table_properties();
	

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
	}

	public function ongoinginterviews()
	{
		$data														= $this->data;

		$where = ' and amm.status = "scheduleinterview" or amm.status = "assigntointerviewer"';
		$records													= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", $where . " ORDER BY amm.date_added desc ");

		$data["table_record"]										= $records->result_array();
		$data["table_properties"]									= $this->view_table_properties();

		$data['_pageview']									= $this->data["_directory"] . "view.php";
		$data["_heading"]									= 'Ongoing Interviews - Arbaeen Medical Mission';


		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}
	
	public function approvedapplications()
	{
		$data														= $this->data;
		
		$where = ' and amm.status = "approve"';
		$records													= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", $where." ORDER BY amm.date_added desc ");

		$data["table_record"]										= $records->result_array();
		$data["table_properties"]									= $this->rejectedapplications_table_properties();

		$data['_pageview']									= $this->data["_directory"] . "rejectedapplications.php";
		$data["_heading"]									= 'Approved Applications - Arbaeen Medical Mission';
	

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
	}
	
	public function rejectedapplications()
	{
		$data														= $this->data;
		
		$where = ' and amm.status = "reject"';
		$records													= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", $where." ORDER BY amm.date_added desc ");

		$data["table_record"]										= $records->result_array();
		$data["table_properties"]									= $this->rejectedapplications_table_properties();

		$data['_pageview']									= $this->data["_directory"] . "rejectedapplications.php";
		$data["_heading"]									= 'Rejected Applications - Arbaeen Medical Mission';
	

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
	}

	public function content()
	{
		if ( (isset($_POST['content']) && $_POST['content'] != "") || (isset($_POST['content_fp']) && $_POST['content_fp'] != "") || (isset($_POST['stage3_form']) && $_POST['stage3_form'] != "")  || (isset($_POST['stage3b_form']) && $_POST['stage3b_form'] != "") ){
			$saveData['id'] = 1;
			// $saveData['content'] = $_POST['content'];
			// $saveData['stage3_form'] = $_POST['stage3_form'];
			// $saveData['stage3b_form'] = $_POST['stage3b_form'];

			// $this->queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission_content", 'id');
			$this->_save_lang_content($saveData['id'], 'e'); 

			$data['_messageBundle'] = $this->_messageBundle(
				'success' ,
				"Content Updated",
				lang_line("heading_operation_success"),
				false,
				true
			);

			redirect(site_url($this->data["_directory"] . "controls/content"));
		}

		$this->data['_pageview']									= $this->data["_directory"] . "content.php";

		$data														= $this->data;
		
		$records													= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission_content"," and id = 1 ");

		if ( $records -> num_rows() <= 0) {
			show_404();
		}

		$data["table_record"]										= $records->row();
	
		$data["table_properties"]									= $this->view_table_properties();

		$edit_lang_details											= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission_content_languages", " AND arbaeenmedicalmission_content_id = 1 ")->result_array();
		$this->_create_lang_fields_for_form(true, $data, $this->data['content_languages'], $edit_lang_details );
	

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
	}

	private function _save_lang_content($ref_id, $action){
		$content = $this->input->post("content");
		$content_fp = $this->input->post("content_fp");
		$stage3_form = $this->input->post("stage3_form");
		$stage3b_form = $this->input->post("stage3b_form");

		$arbaeenmedicalmission_content = $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission_content_languages", " AND arbaeenmedicalmission_content_id = '$ref_id' ")->result_array();

		foreach ($this->data['content_languages'] as $lang_key => $lang) {
			$saveData = [
				'content' => $content[$lang['id']],
				'content_fp' => $content_fp[$lang['id']],
				'stage3_form' => $stage3_form[$lang['id']],
				'stage3b_form' => $stage3b_form[$lang['id']],
				'arbaeenmedicalmission_content_id' => $ref_id,
				'content_languages_id' => $lang['id']
			];
			
			// if(!$arbaeenmedicalmission_content && !in_array($lang['id'], array_column($arbaeenmedicalmission_content,'content_languages_id'))){
			if($arbaeenmedicalmission_content && !in_array($lang['id'], array_column($arbaeenmedicalmission_content,'content_languages_id'))){
				$col = 'id';
				$action = 's';
			}else{
				$col = 'content_languages_id|arbaeenmedicalmission_content_id';
				$action = 'e';
			}
			
			$this->queries->SaveDeleteTables_imiconf($saveData, $action, "tb_arbaeenmedicalmission_content_languages", $col);
		}
	}

	public function _create_lang_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array("content", "content_fp", "stage3_form", 'stage3b_form');
		$filled_inputs				= array("content", "content_fp", "stage3_form", 'stage3b_form');
		
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
				
				case "reject":
					$this->reject( $_POST['checkbox_options'] );
					break;
				
				case "approve":
					$this->approve( $_POST['checkbox_options'] );
					break;

				case "assigntointerviewer":
					$this->assigntointerviewer($_POST['checkbox_options']);
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

	public function delete( $ids )
	{
		$data												= $this->data;

		#remove record from DETAIL table
		foreach ($ids	as $key	=> $result)
		{
			$saveData['id']									= $result;
			$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'd', "tb_arbaeen_medical_mission", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
	
	public function reject( $id )
	{
		if ( $id == "" || $id == 0 ){
			show_404();
		}

		$this->data['_pageview']									= $this->data["_directory"] . "reject.php";
		$data														= $this->data;

		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
		if ( $record->num_rows() > 0 ){
			$row = $record->row();
		}else{
			show_404();
		}

		$data['table_record']										= $record;

		if ( isset($_POST) && isset($_POST['reject']) ){

			switch($_POST['reject']){
				case 0:
					$this->form_validation->set_rules('rejected_notes','Rejected Notes','required');

					if ( $this->form_validation->run() == true ){

						//save in db
						$saveData['id']									= $id;
						$saveData['status']								= 'reject';
						$saveData['rejected_notes']						= $this->input->post('rejected_notes');;
						$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id') ;						
					}
				break;

				default:
				break;
			}

            if ($this->form_validation->run() == true) {
                $__data = array_merge((array) $row, $_POST);

                //send admin email
                $email_template			= array(
					"email_heading"			=> "Applicant rejected for Arbaeen Medical Mission",
					"email_file"			=> "email/frontend/arbaeen_medical_reject_admin.php",
					"email_subject"			=> "Applicant rejected for Arbaeen Medical Mission",
					"default_subject"		=> true,
					"email_post"			=> $__data
				);
                $is_email_sent			= $this->_send_email($email_template);

                //send user email
                $email_template			= array(
					"email_to"				=> $row->email,
					"email_heading"			=> "Your application is now rejected for Arbaeen Medical Mission",
					"email_file"			=> "email/frontend/arbaeen_medical_reject_user.php",
					"email_subject"			=> "Your application is now rejected for Arbaeen Medical Mission",
					"default_subject"		=> true,
					"email_post"			=> $__data
				);
                $is_email_sent			= $this->_send_email($email_template);

                $data['_messageBundle'] = $this->_messageBundle(
                            'success',
                            "Applicant ".$row->email." Rejected Successfully",
                            lang_line("heading_operation_success"),
                            false,
                            true
                        );

                redirect(site_url($data["_directory"] . "controls/view"));
            }
		}

		$data["_heading"]									= 'Reject Application - Arbaeen Medical Mission';

		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}
	
	public function approve( $id )
	{
		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id =".$id);
        if ($record->num_rows() > 0) {
            $row = $record->row();
        } else {
            show_404();
		}
		
		$data												= $this->data;

		$saveData['id']									= $id;
		$saveData['status']								= 'approve';
		$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id') ;
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					'Applicant '.$row->email.' Approved Successfully', 
																					lang_line("heading_operation_success"), 
																					false,
																					true);

		//send admin email
        $email_template			= array(
            "email_heading"			=> "Applicant approved for Arbaeen Medical Mission",
            "email_file"			=> "email/frontend/arbaeen_medical_approve_admin.php",
            "email_subject"			=> "Applicant approved for Arbaeen Medical Mission",
            "default_subject"		=> true,
            "email_post"			=> (array) $row
        );
		$is_email_sent			= $this->_send_email($email_template);
		
		//send user email
		$email_template			= array(
			"email_to"				=> $row->email,
			"email_heading"			=> "Your application is now approved for Arbaeen Medical Mission",
			"email_file"			=> "email/frontend/arbaeen_medical_approve_user.php",
			"email_subject"			=> "Your application is now approved for Arbaeen Medical Mission",
			"default_subject"		=> true,
			"email_post"			=> (array) $row
		);
		$is_email_sent			= $this->_send_email($email_template);

		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}

	public function pending( $id )
	{
		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
        if ($record->num_rows() > 0) {
            $row = $record->row();
        } else {
            show_404();
        }
		
		$data												= $this->data;
		$saveData['id']									= $id;
		$saveData['status']								= 'pending';
		$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id') ;
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					'Applicant '.$row->email.' UnRejected Successfully', 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		//send admin email
		$email_template			= array(
			"email_heading"			=> "An application is now pending for Arbaeen Medical Mission",
			"email_file"			=> "email/frontend/arbaeen_medical_pending_admin.php",
			"email_subject"			=> "An application is now pending for Arbaeen Medical Mission",
			"default_subject"		=> true,
			"email_post"			=> (array) $row
		);
		$is_email_sent			= $this->_send_email($email_template);
		
		//send user email
		$email_template			= array(
			"email_to"				=> $row->email,
			"email_heading"			=> "Your application is now pending for Arbaeen Medical Mission",
			"email_file"			=> "email/frontend/arbaeen_medical_pending_user.php",
			"email_subject"			=> "Your application is now pending for Arbaeen Medical Mission",
			"default_subject"		=> true,
			"email_post"			=> (array) $row
		);
		$is_email_sent			= $this->_send_email($email_template);
		
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
	}

	public function waitlist( $id )
	{
		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id =".$id);
        if ($record->num_rows() > 0) {
            $row = $record->row();
        } else {
            show_404();
		}
		
		$data												= $this->data;

		$saveData['id']									= $id;
		$saveData['status']								= 'waitlist';
		$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id') ;
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					'Applicant '.$row->email.' moved to waitlist Successfully', 
																					lang_line("heading_operation_success"), 
																					false,
																					true);

		//send admin email
        $email_template			= array(
            "email_heading"			=> "Applicant moved to waitlist for Arbaeen Medical Mission",
            "email_file"			=> "email/frontend/arbaeen_medical_waitlist_admin.php",
            "email_subject"			=> "Applicant moved to waitlist for Arbaeen Medical Mission",
            "default_subject"		=> true,
            "email_post"			=> (array) $row
        );
		$is_email_sent			= $this->_send_email($email_template);
		
		//send user email
		$email_template			= array(
			"email_to"				=> $row->email,
			"email_heading"			=> "Your application is now moved to waitlist for Arbaeen Medical Mission",
			"email_file"			=> "email/frontend/arbaeen_medical_waitlist_user.php",
			"email_subject"			=> "Your application is now moved to waitlist for Arbaeen Medical Mission",
			"default_subject"		=> true,
			"email_post"			=> (array) $row
		);
		$is_email_sent			= $this->_send_email($email_template);

		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}

	public function assigntointerviewer( $id )
	{
		if ($id == "" || $id == 0) {
			show_404();
		}

		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
		if ( $record->num_rows() > 0 ){
			$row = $record->row();
		}else{
			show_404();
		}

		$this->data['_pageview']									= $this->data["_directory"] . "assigntointerviewer.php";
		$data														= $this->data;

		if ( isset($_POST) && isset($_POST['interviewer']) && $_POST['interviewer'] != "" ){

			$saveData['id']									= $id;
			$saveData['interviewer']						= $_POST['interviewer'];
			$saveData['status']								= 'assigntointerviewer';
			$saveData['is_interview_call_accepted']			= 0;
			
			$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id') ;

			$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
			$row = $record->row();
			$data['_messageBundle']								= $this->_messageBundle('success' , 
																						'Applicant '.$row->email.' assigned to interviewer Successfully', 
																						lang_line("heading_operation_success"), 
																						false,
																						true);

			//send admin email
			$email_template			= array(
				"email_heading"			=> "Applicant assigned to interviewer for Arbaeen Medical Mission",
				"email_file"			=> "email/frontend/arbaeen_medical_assgintointerviewer_admin.php",
				"email_subject"			=> "Applicant assigned to interviewer for Arbaeen Medical Mission",
				"default_subject"		=> true,
				"email_post"			=> (array) $row
			);
			$is_email_sent			= $this->_send_email($email_template);

			//send user email
			$email_template			= array(
				"email_to"				=> $row->interviewer_email,
				"email_heading"			=> "We have assigned an applicant interview for Arbaeen Medical Mission",
				"email_file"			=> "email/frontend/arbaeen_medical_assigntointerviewer_user.php",
				"email_subject"			=> "We have assigned an applicant interview for Arbaeen Medical Mission",
				"default_subject"		=> true,
				"email_post"			=> (array) $row
			);
			$is_email_sent			= $this->_send_email($email_template);

			redirect(  site_url( $data["_directory"] . "controls/view" )  );
		}
		
		$data['table_record']										= $record;
		
		
		$interviewers														= $this->queries->fetch_records("interviewers");
		$data['interviewers'] 								= $interviewers->result();

		$data["_heading"]									= 'Assign to Interviewer - Arbaeen Medical Mission';

		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}

	public function scheduleinterview( $id )
	{
		if ($id == "" || $id == 0) {
			show_404();
		}

		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
		if ( $record->num_rows() > 0 ){
			$row = $record->row();
		}else{
			show_404();
		}

		$this->data['_pageview']									= $this->data["_directory"] . "scheduleinterview.php";
		$data														= $this->data;

		if ( isset($_POST) && isset( $_POST['interview_details'] ) && $_POST['interview_details'] != "" ){

			$saveData['id']									= $id;
			$saveData['interview_details']					= $_POST['interview_details'];
			$saveData['status']								= 'scheduleinterview';
			
			$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id') ;

			$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
			$row = $record->row();
			$data['_messageBundle']								= $this->_messageBundle('success' , 
																						'Interview has been scheduled for '.$row->email, 
																						lang_line("heading_operation_success"), 
																						false,
																						true);

			//send admin email
			$email_template			= array(
				"email_heading"			=> "Interview has been scheduled for Arbaeen Medical Mission",
				"email_file"			=> "email/frontend/arbaeen_medical_scheduleinterview_admin.php",
				"email_subject"			=> "Interview has been scheduled for Arbaeen Medical Mission",
				"default_subject"		=> true,
				"email_post"			=> (array) $row
			);
			$is_email_sent			= $this->_send_email($email_template);

			//send user email
			$email_template			= array(
				"email_to"				=> $row->email,
				"email_heading"			=> "Your interview scheduled for Arbaeen Medical Mission",
				"email_file"			=> "email/frontend/arbaeen_medical_scheduleinterview_user.php",
				"email_subject"			=> "Your interview scheduled for Arbaeen Medical Mission",
				"default_subject"		=> true,
				"email_post"			=> (array) $row
			);
			$is_email_sent			= $this->_send_email($email_template);

			redirect(  site_url( $data["_directory"] . "controls/view" )  );
		}
		
		$data['table_record']										= $record;

		$data["_heading"]									= 'Schedule Interview - Arbaeen Medical Mission';

		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}

	public function stage3( $id )
	{
		if ($id == "" || $id == 0) {
			show_404();
		}

		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
		if ( $record->num_rows() > 0 ){
			$row = $record->row();
		}else{
			show_404();
		}

		$this->data['_pageview']									= $this->data["_directory"] . "stage3.php";
		$data														= $this->data;
		
		$stage3a_menu_id = SessionHelper::_get_session("STAGE3A_MENUID", "site_settings");

		$data['stage3a_link'] = '';
		if ( $stage3a_menu_id ){
			$stage3a_link = $this->queries->fetch_records('cmsmenu',' and id = "'.$stage3a_menu_id.'"');
			$data['stage3a_link'] = site_url('page/'.$stage3a_link->row()->slug);
		}
		
		$stage3b_menu_id = SessionHelper::_get_session("STAGE3B_MENUID", "site_settings");

		$data['stage3b_link'] = '';
		if ( $stage3b_menu_id ){
			$stage3b_link = $this->queries->fetch_records('cmsmenu',' and id = "'.$stage3b_menu_id.'"');
			$data['stage3b_link'] = site_url('page/'.$stage3b_link->row()->slug);
		}


		if ( isset($_POST) && isset( $_POST['stage3_details'] ) && $_POST['stage3_details'] != "" ){

			$saveData['id']									= $id;
			$saveData['stage3_details']						= $_POST['stage3_details'];
			$saveData['stage3_link']						= $_POST['stage3_link'];
			$saveData['status']								= 'stage3';
			
			$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id') ;

			$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
			$row = $record->row();
			$data['_messageBundle']								= $this->_messageBundle('success' , 
																						'Stage 3 has been send to '.$row->email, 
																						lang_line("heading_operation_success"), 
																						false,
																						true);

			//send admin email
			$email_template			= array(
				"email_heading"			=> "Stage 3 has been send for Arbaeen Medical Mission",
				"email_file"			=> "email/frontend/arbaeen_medical_stage3_admin.php",
				"email_subject"			=> "Stage 3 has been send for Arbaeen Medical Mission",
				"default_subject"		=> true,
				"email_post"			=> (array) $row
			);
			$is_email_sent			= $this->_send_email($email_template);

			//send user email
			$email_template			= array(
				"email_to"				=> $row->email,
				"email_heading"			=> "Stage 3 for Arbaeen Medical Mission",
				"email_file"			=> "email/frontend/arbaeen_medical_stage3_user.php",
				"email_subject"			=> "Stage 3 for Arbaeen Medical Mission",
				"default_subject"		=> true,
				"email_post"			=> (array) $row
			);
			$is_email_sent			= $this->_send_email($email_template);

			redirect(  site_url( $data["_directory"] . "controls/view" )  );
		}
		
		$data['table_record']										= $record;

		$data["_heading"]									= 'Stage 3 - Arbaeen Medical Mission';

		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}

	public function acceptinterviewcall($id)
	{
		if ($id == "" || $id == 0) {
			show_404();
		}

		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
		if ($record->num_rows() > 0) {
			$row = $record->row();
		} else {
			show_404();
		}

		$data														= $this->data;

		$saveData['id']									= $id;
		$saveData['is_interview_call_accepted']			= 1;

		$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id');

		$data['_messageBundle']								= $this->_messageBundle(
			'success',
			'Interview Call Accepted Successfully',
			lang_line("heading_operation_success"),
			false,
			true
		);

		//send admin email
		$email_template			= array(
			"email_heading"			=> "Interview Call Accepted by Interviewer for Arbaeen Medical Mission",
			"email_file"			=> "email/frontend/arbaeen_medical_acceptinterviewcall_admin.php",
			"email_subject"			=> "Interview Call Accepted by Interviewer Arbaeen Medical Mission",
			"default_subject"		=> true,
			"email_post"			=> (array) $row
		);
		$is_email_sent			= $this->_send_email($email_template);

		redirect(site_url($data["_directory"] . "controls/view"));
	}
	
	public function rejectinterviewcall($id)
	{
		if ($id == "" || $id == 0) {
			show_404();
		}

		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
		if ($record->num_rows() > 0) {
			$row = $record->row();
		} else {
			show_404();
		}

		$data														= $this->data;

		$saveData['id']									= $id;
		$saveData['status']								= 'interviewcallrejected';
		$saveData['is_interview_call_accepted']			= -1;

		$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id');

		$data['_messageBundle']								= $this->_messageBundle(
			'success',
			'Interview Call Rejected Successfully',
			lang_line("heading_operation_success"),
			false,
			true
		);

		//send admin email
		$email_template			= array(
			"email_heading"			=> "Interview Call Rejected by Interviewer for Arbaeen Medical Mission",
			"email_file"			=> "email/frontend/arbaeen_medical_rejectinterviewcall_admin.php",
			"email_subject"			=> "Interview Call Rejected by Interviewer Arbaeen Medical Mission",
			"default_subject"		=> true,
			"email_post"			=> (array) $row
		);
		$is_email_sent			= $this->_send_email($email_template);

		redirect(site_url($data["_directory"] . "controls/view"));
	}

	public function interviewnotes($id)
	{
		if ($id == "" || $id == 0) {
			show_404();
		}

		$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
		if ($record->num_rows() > 0) {
			$row = $record->row();
		} else {
			show_404();
		}

		$this->data['_pageview']									= $this->data["_directory"] . "interviewnotes.php";
		$data														= $this->data;

		if (isset($_POST) && isset($_POST[ 'interview_recommendation']) && $_POST[ 'interview_recommendation'] != "" && isset($_POST['interview_notes']) && $_POST['interview_notes'] != "")
		{

			$saveData['id']									= $id;
			$saveData['interview_recommendation']			= $_POST['interview_recommendation'];
			$saveData['interview_notes']					= $_POST['interview_notes'];
			$saveData['status']								= $_POST['interview_recommendation'] == "yes" ? 'recommended' : 'not-recommended';

			$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_arbaeen_medical_mission", 'id');

			$record														= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " and amm.id = $id");
			$row = $record->row();
			$data['_messageBundle']								= $this->_messageBundle(
				'success',
				'Interview notes has been updated',
				lang_line("heading_operation_success"),
				false,
				true
			);

			//send admin email
			$email_template			= array(
				"email_heading"			=> "Interviewer updated interview notes for Arbaeen Medical Mission",
				"email_file"			=> "email/frontend/arbaeen_medical_interviewnotes_admin.php",
				"email_subject"			=> "Interviewer updated interview notes for Arbaeen Medical Mission",
				"default_subject"		=> true,
				"email_post"			=> (array) $row
			);
			$is_email_sent			= $this->_send_email($email_template);

			redirect(site_url($data["_directory"] . "controls/view"));
		}

		$data['table_record']										= $record;

		$data["_heading"]									= 'Update Interview Notes - Arbaeen Medical Mission';

		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}

	public function export()
	{
		// create file name
        $filename = 'data-'.time().'.xlsx';
		// load excel library
        $this->load->library('excel');
		
		$records			= $this->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission", " ORDER BY amm.date_added desc ");

		$fields = array(
			'first_name'								=> 'First Name',
			'middle_name'								=> 'Middle Name',
			'last_name'									=> 'last Name',
			'street_address'							=> 'Street Address',
			'street_address_2'							=> 'Street Address 2',
			'city'										=> 'City',
			'region'									=> 'Region',
			'postal_code'								=> 'Postal Code',
			'country'									=> 'Country',
			'email'										=> 'Email',
			'phone_number'								=> 'Cell Number',
			'occupation'								=> 'Occupation',
			'cv_resume'									=> 'CV/Resume',
			'health_his' 								=> 'Brief information below regarding any health history/current conditions',
			'citizenship' 								=> 'Citizenship',
			'birth_date'								=> 'Date of Birth',
			'passportno'								=> 'Passport Number',
			'passport_expiry'							=> 'Date of Expiration',
			'passport_copy'							    => 'Passport Copy',
			'passport_pic'							    => 'Passport Sized Photograph',
			'agree_terms'							    => 'I agree to the personal covenant and liability form and agree to abide by all rules and processes of IMI',
			'interviewer'								=> 'Interviewer',
			'interview_datetime'						=> 'Interview Date/Time',
			'interview_details'							=> 'Interview Details',
			'interview_recommendation'					=> 'Interviewer Recommendation',
			'interview_notes'							=> 'Interviewer Notes',
			'rejected_notes'							=> 'Rejected Notes',
			'signature'									=> 'Digital Signature',
			'date_added'								=> 'Date Added',
			'status'									=> 'Status'
		);
		
		$headers = albhabeticRange(count($fields));
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$a = 0;
		foreach ($fields as $key => $value) {
			$objPHPExcel->getActiveSheet()->SetCellValue($headers[$a].'1', $value)->getStyle($headers[$a].'1')->getFont()->setBold(true);
			$a++;
		}
        // set Row
        $rowCount = 2;
        if ( $records->num_rows() > 0 ){
			foreach ($records->result() as $key => $record) {
				$a = 0;
				// echo '<pre>';
				// 	print_r($record);
				// 	echo '</pre>';
				foreach ($fields as $k=> $v) {
					$value = $record->{$k};
					
					$createDate = new DateTime($record->date_added);
					$strip = $createDate->format('Y-m-d');
					$to_decrypt = strtotime($strip) >= strtotime("2023-05-29");
					if ( $k == 'cv_resume' || $k == 'signature' || $k == 'passport_copy' || $k == 'passport_pic'){
						$url = site_url().'assets/files/arbaeen-mission/'.$value;
						$value = 'Click to Download';
						$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($a,$rowCount)->getHyperlink()->setUrl($url);
					}

					if( $k == 'interviewer' ){
						$value = $record->interviewer_email != "" ? $record->interviewer_email . ' ( ' . $record->interviewer_username . ' ) ' : '';
					}

					if( $k == 'phone_number' || $k == 'birth_date' || $k == 'passportno' || $k == 'passport_expiry' ){
						$value = $to_decrypt ? $this->encrption->decrypt($record->$k) : $record->$k;
					}

					if ( @unserialize($value) !== false || $value == 'b:0;' ){
						$lang = unserialize($value);
						$i = 1;
						$value = '';
						foreach ($lang as $lng) {
							if ($lng != 'Other') {
								if ($i > 1) {
									$value.= ',';
								}
								$value.=$lng;
							}
							$i++;
						}
					}
					/* if($k == 'gender'){
						$value = DropdownHelper::gender_dropdown(true, $value);
					}
					if($k == 'type_covid19' || $k == 'type_diabetes' || $k == 'type_heart_disease' ){
						if($value === "0"){
							$value = "";
						}
					} */
					$objPHPExcel->getActiveSheet()->SetCellValue($headers[$a]. $rowCount, $value);
					$a++;
				}
				$rowCount++;
			}
		}
		header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */