<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxMethods extends C_frontend {

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
		
		
		$this->data													= $this->default_data();	
		
	}
	
	
	
	function cmstype_with_typeid( $typeid = 0, $is_ajax = TRUE )
	{
		$data						= $this->data;
		$TMP_type_name				= FALSE;
		
		
		/*if ( ! $this->validations->is_numeric( $typeid ) )
		{
			$typeid 					= 0;
		}*/
		
		if ( $typeid > 0 )
		{
			$TYPE_list				= DropdownHelper::cmsmenutypes_dropdown();	
			$TMP_type_name			= $TYPE_list[ $typeid ];
		}
		else
		{
			$typeid 					= 0;	
		}
				
		
		
		if (  ($TMP_type_name == "content") || ($TMP_type_name == "hidden")  )
		{			
			$output					= _return_cms_textarea( TRUE );
		}
		else
		{
			
			
			#$output	= $this->load->view("admincms/managecmscontent/ajax_textarea.php");
			
			$output					= _return_cms_textarea( FALSE );
			
			if ( $TMP_type_name == "url_internal" )
			{
				$output					= '	<div style="float: left; margin-top: 8px;">' . base_url() . '</div>
											<div style="float:left;">' . $output . '</div>
											<div style="float: left; margin-top: 8px;">.html</div>';
			}
		}
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "cmstype_with_typeid";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	function cmstype_with_cmsmenu( $menuid = 0, $is_ajax = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $menuid ) )
		{
			$menuid 				= 0;
		}
		
		
		
		
		
		$rooms_list 				= $this->queries->fetch_records("cmsmenu", " AND id = '". $menuid ."' ");
		
		if (  ($rooms_list ->row("type_name") == "content") || ($rooms_list ->row("type_name") == "hidden")  )
		{			
			$output					= _return_cms_textarea( TRUE );
		}
		else
		{
			
			
			#$output	= $this->load->view("admincms/managecmscontent/ajax_textarea.php");
			
			$output					= _return_cms_textarea( FALSE );
			
			if ( $rooms_list ->row("type_name") == "url_internal" )
			{
				$output					= '	<div style="float: left; margin-top: 8px;">' . base_url() . '</div>
											<div style="float:left;">' . $output . '</div>
											<div style="float: left; margin-top: 8px;">.html</div>';
			}
		}
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "cmstype_with_cmsmenu";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	function cmstype_with_cmsmenu_by_lang( $menuid = 0, $is_ajax = TRUE, $languages = [] )
	{
		$data						= $this->data;
		
		if(empty($languages)){
			$languages = $this->queries->fetch_records("content_languages", " ORDER BY id DESC ")->result_array();
		}

		if ( ! $this->validations->is_numeric( $menuid ) )
		{
			$menuid 				= 0;
		}
		
		
		
		
		
		$rooms_list 				= $this->queries->fetch_records("cmsmenu", " AND id = '". $menuid ."' ");
		
		if (  ($rooms_list ->row("type_name") == "content") || ($rooms_list ->row("type_name") == "hidden")  )
		{			
			$output					= _return_cms_textarea_with_lang( TRUE, $languages );
		}
		else
		{
			
			
			#$output	= $this->load->view("admincms/managecmscontent/ajax_textarea.php");
			
			$output					= _return_cms_textarea_with_lang( FALSE, $languages );
			
			if ( $rooms_list ->row("type_name") == "url_internal" )
			{
				$output					= '	<div style="float: left; margin-top: 8px;">' . base_url() . '</div>
											<div style="float:left;">' . $output . '</div>
											<div style="float: left; margin-top: 8px;">.html</div>';
			}
		}
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "cmstype_with_cmsmenu";
		$data['_messageBundle']['_languages']				= $languages;
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	
	
	function cmsmenu_with_position( $positionid = 0, $is_ajax = TRUE )
	{


		$data						= $this->data;


		if ( ! $this->validations->is_numeric( $positionid ) )
		{
			$positionid 			= 0;
		}
		
		
		
		#if add (include all id's other than these ID's
		$other_ids					= " AND  positionid  != '". $positionid ."' || id = '". $this->input->post("id") ."' ";
		
		
		#if edit (include add query as well)
		if ( $this->input->post("id") != '' )
		{
			
			$previous_record		= $this->queries->fetch_records("cmsmenu",  ' AND id = "'. $this->input->post("id") .'" ', "parentid");
			if ( $previous_record->row("parentid") != 0 )
			{
				$TMP					= $this->queries->fetch_records("cmsmenu", " AND id != '". $previous_record->row("parentid") ."' ", " id ");
			}
			else
			{
				$TMP					= $this->queries->fetch_records("cmsmenu", "  ", " id ");
			}			
			
			#$other_ids				= $other_ids . " || id IN (". $this->db->last_query() .") ";
			
		}
		
	
		$parent_menus 			= $this->queries->fetch_records("cmsmenu",  $other_ids , "id");

		$output					= form_dropdown( "parentid", DropdownHelper::menu_dropdown( $this->db->last_query() ),  set_value("parentid", $this->input->post("parentid") ), "class='form-control' size='10'" );
	
		
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "cmsmenu_with_position";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	


	
	
	function conferencetype_with_conferencemenu( $menuid = 0, $is_ajax = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $menuid ) )
		{
			$menuid 				= 0;
		}
		
		
		
		
		
		$rooms_list 				= $this->queries->fetch_records("conferencemenu", " AND id = '". $menuid ."' ");
		
		if (  ( $rooms_list ->row("type_name") == "content" ) || ( $rooms_list ->row("type_name") == "hidden" ) )
		{
			
			#$output	=  $this->load->view("admincms/managecmscontent/ajax_textarea.php");
			
			$roomdata				= array("name"			=> "content",
											"id"			=> "content",
											"cols"			=> 50,
											"rows"			=> 10,
											"class"			=> "ckeditor1",
											"value"			=> set_value("content", $this->input->post('content') )
											);	
									
			$output					= "<br /><br /><small><strong>[ABS_FEES_CURRENT_CONFERENCE]</strong> = $50 for students, $100 for faculty members</small><br />";
			
			$tmp_conf				= $this->queries->fetch_records("conference", " AND id = '". SessionHelper::_get_session("id", "conference") ."'");
			$output					.= "<small><strong>[DURATION_DATE_CURRENT_CONFERENCE]</strong> = ". conference_durationdates( $tmp_conf ) ."</small><br /><br />";
			$output					.= form_textarea($roomdata);
		}
		else
		{
			#$output	= $this->load->view("admincms/managecmscontent/ajax_textarea.php");
			
			$roomdata				= array("name"			=> "content",
											"size"			=> 50,
											"class"			=> "form-control",
											"value"			=> set_value("content", $this->input->post('content') )
											);	
			
			$output					= form_input($roomdata);
			
			if ( $rooms_list ->row("type_name") == "url_internal" )
			{
				$output					= '	<div style="float: left; margin-top: 8px;">' . base_url() . '</div>
											<div style="float:left;">' . $output . '</div>
											<div style="float: left; margin-top: 8px;">.html</div>';
			}
		}
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "conferencetype_with_conferencemenu";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	

	function whoattend_by_short_conferenceid( $conferenceid = 0, $is_ajax = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $conferenceid ) )
		{
			$conferenceid 				= 0;
		}
		
	
		
		$output						= form_dropdown( 	"whoattendid", 
														DropdownHelper::short_conferencewhoattend_dropdown( 	FALSE, " AND conferenceid = '". $conferenceid ."' " ),  
														set_value("whoattendid", $this->input->post("whoattendid") ), 
														"class='form-control' " );
		
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "whoattend_by_short_conferenceid";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	
	
	
	function sightseeing_with_country( $countryid = 0, $is_ajax = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $countryid ) )
		{
			$countryid 				= 0;
		}
		
	
		
		$sight_seeing_list			= $this->queries->fetch_records("sight_seeing", " AND countryid = '". $countryid ."' ");
		$output						= "<small class='badge pull-right bg-red'>no record found</small>";
		if ( $sight_seeing_list->num_rows() > 0 )
		{
			
			$output					= "<ol class='ilinks_sortable'>";
			foreach ( $sight_seeing_list->result_array() as $TMP)
			{
				
				$TMP_input			= '<input type="checkbox" name="sight_seeingid[]" value="'. $TMP["id"] .'" '. set_checkbox('sight_seeingid[]', $TMP["id"]).' />';
				
				$output				.= "<li>". $TMP_input . ' ' . $this->functions->runtime_image( $TMP['photo_image'], "500", "", FALSE, TRUE) ."</li>";
			}
			$output					.= "</ol>";
		}
		
		
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "sightseeing_with_country";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	
	
	function conference_program_table_by_conferenceid( $conferenceid = 0, $is_ajax = TRUE )
	{
		$data							= $this->data;
		
		if ( ! $this->validations->is_numeric( $conferenceid ) )
		{
			$conferenceid 				= 0;
		}
		
		
		
	
		$data['conference']				= $this->queries->fetch_records("conference", " AND id = '". $conferenceid ."' ");
		
		$data['TMP_no_of_days']			= $this->functions->days_between_dates( $data['conference']->row("duration_from"), $data['conference']->row("duration_to"));
		
		
		$output							= $this->load->view("admincms/manageconferenceprograme/include_view", $data, TRUE);
		
	
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "conference_program_table_by_conferenceid";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	
	
	function conferencetopics_by_conferenceid( $conferenceid = 0, $is_ajax = TRUE )
	{
		$data							= $this->data;
		
		if ( ! $this->validations->is_numeric( $conferenceid ) )
		{
			$conferenceid 				= 0;
		}
		
		
		
	
		$data['conference']				= $this->queries->fetch_records("conference", " AND id = '". $conferenceid ."' ");
		
		
		$conference_topics				= $this->queries->fetch_records("conference_topics", " AND conferenceid  = '". $data['conference']->row("id") ."' 
																							   AND status = '1' ");
		
		
		$output						= "<small class='badge pull-right bg-red'>no record found</small>";
		if ( $conference_topics->num_rows() > 0 )
		{
			
			$output					= "<ol class='ilinks_sortable'>";
			foreach ( $conference_topics->result_array() as $TMP)
			{
				
				$TMP_input			= '<input type="checkbox" name="topics_id[]" value="'. $TMP["id"] .'" '. set_checkbox('topics_id[]', $TMP["id"]).' /> ';
				
				
				$TMP_input			.= '<input style="display:;" type="text" name="other_topics['. $TMP["id"] .']" 
										value="'. set_value("other_topics[". $TMP["id"] ."]", $_POST["other_topics"][ $TMP["id"] ] ) .'" size="50" />';
				
				$desc				= '';
				if ( $TMP["description"] != '' )
				{
					$desc			= ' <small>(' . $TMP["description"] . ')</small>';	
				}
				
				$output				.= "<li>". $TMP_input .  $TMP["name"] . $desc . "</li>";
			}
			
			
			
			$TMP_other_id		= "-9999";
			$TMP_input			= '<input type="checkbox" name="topics_id[]" value="'. $TMP_other_id .'" '. set_checkbox('topics_id[]', $TMP_other_id).' /> ';
			$output				.= "<li>". $TMP_input . 
									
									' Others 
									  <input type="text" name="other_topics['. $TMP_other_id .']" 
									  value="'. set_value("other_topics[". $TMP_other_id ."]", $_POST["other_topics"][$TMP_other_id] ) .'" size="50" />
									  
									</li>';
			
			$output					.= "</ol>";
		}
		
		
		
		
	
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "conferencetopics_by_conferenceid";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	
	
	
	
	
	function decrypt($param = '')
	{
		
		$this->load->library("Encrption");
		echo $this->encrption->decrypt("YeCjwfJ9ElCL2stmESB2uq51");
		die;	
	}
	
	###############################
	##     Forum                 ##
	###############################  
	
	
		function cmstopics_with_forum( $positionid = 0, $is_ajax = TRUE )
	    {


			//echo "positionid=".$positionid."/isAjax=".$is_ajax; die();

		$data						= $this->data;


		if ( ! $this->validations->is_numeric( $positionid ) )
		{
			$positionid 			= 0;
		}
		
		
			#if add (include all id's other than these ID's
		
		  //|| frmid = '". $this->input->post("id") ."' 
		
		$other_ids					= " AND  frmid  = '". $positionid ."'";
			
			
		#if edit (include add query as well)

		
		$output					= form_dropdown( "topic", DropdownHelper::topics_dropdown($positionid),  set_value("parentid", $this->input->post("parentid") ), "class='form-control' size='10'" );
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "cmsposts_with_forum";
		
		if ( $is_ajax )
		{
	  	
	  		 echo json_encode( $data['_messageBundle'] );	
		
		}
		else
		{
		
			 return 	$data['_messageBundle'];	
		
		}
	}


    function getMoreTopics()
    {

        $forumid = $this->input->post('forumid');
        $last_limit = $this->input->post('last_limit');
//echo $forumid; 
//echo $last_limit; die;


        $topic = $this->queries->fetch_records("getforumtopics", " 
                        AND frmid = '" . $forumid . "'  ORDER BY date DESC LIMIT " . $last_limit . ",3 ");

        /*echo "<pre>"; print_r($topic->result()); die;
        echo $this->db->last_query(); die;
        */
        if (empty($topic)) {
            return false;
        } else {
            foreach ($topic->result_array() as $rec) {

                $postedby = $rec['created_by_user'];
                $userid = $this->functions->_user_logged_in_details('id');

                $count = 0;
                $total_posts = 0;

                $totalComments = 0;
                $post_date = "";

                $getPosts = $this->queries->fetch_records("getPosts", "AND topic_id = '" . $rec['id'] . " ORDER BY id DESC'");

                foreach ($getPosts->result_array() as $postss) {

                    $count = $count + 1;

                    $total_posts = $total_posts + 1;

                    if ($count == 1) {

                        if ($postss['date'] < $post_date) {

                        } else {

                            $post_date = $postss['date'];

                        }//end post date

                    }//end count

                    $getComments = $this->queries->fetch_records("getComments", "AND post_id = '" . $postss['id'] . " ORDER BY id DESC'");
                    $numberofcomments = $getComments->num_rows();
                    $totalComments = $totalComments + $numberofcomments;

                }//end inner foreach


                $createdby = "";
                $profile_picture = "";

                if ($rec["created_by_admin"] != null) {

                    $getadmin = $this->queries->fetch_records("getAdmin", " AND id='" . $rec['created_by_admin'] . "' ORDER BY id desc ")->result()[0];
                    $createdby = $getadmin->username;
                    $profile_picture = $getadmin->profile_image;

                } else if ($rec["created_by_user"] != null) {

                    $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='" . $rec['created_by_user'] . "' ORDER BY id desc ")->result()[0];

                    $createdby = $user->name . " " . $user->last_name;


                    $profile_details = $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one",
                        "   AND conferenceregistrationid IN (SELECT id FROM tb_conference_registration_master WHERE userid = '" . $rec['created_by_user'] . "' )  ")->result()[0];


                    $profile_picture = $profile_details->photo_image;


                }//end else

                if ($profile_picture == "") $profile_picture = site_url() . "assets/files/profileimages/noimage.png";

                $tmp_data['rec'] = $rec;
                $tmp_data['total_posts'] = $total_posts;
                $tmp_data['totalComments'] = $totalComments;
                $tmp_data['post_date'] = $post_date;
                $tmp_data['createdby'] = $createdby;
                $tmp_data['profile_picture'] = $profile_picture;
                $tmp_data['postedby'] = $postedby;
                $tmp_data['userid'] = $userid;
                $tmp_data['menu_slug'] = 'discussion-board';

                $this->load->view('frontend/cms/page_plugins/_topic_list', $tmp_data);

            }
        }
    }


function getEditTopicDetail(){

 $id=$this->input->post("id");
 $topic              = $this->queries->fetch_records("getforumtopics", " 
                        AND id ='".$id."'");
  $return['json']=$topic->result();
  echo json_encode($return); 

}

 	function remNewspdf(){

 	        	$pdfPath=$this->input->post('pdfPath');
 	        	$this->remove_file($pdfPath);
				$saveData['news_pdf'] =$pdfPath;
				$this->queries->SaveDeleteTables($saveData, 'd', "tb_news_pdf", 'news_pdf') ;

	 }

	 function remNewsVideo(){

    	 	  	$videoPath=$this->input->post('videoPath');
 	        	$this->remove_file($videoPath);
				$saveData['news_videos'] =$videoPath;
				$this->queries->SaveDeleteTables($saveData, 'd', "tb_news_videos", 'news_videos') ;

	 }


	function setEditPostDetail(){

		$id=$this->input->post("id");

		$topic              = $this->queries->fetch_records("getPosts", " 
								AND id ='".$id."'");
		$return['json']=$topic->result();
		echo json_encode($return);

	}

	function edit_save_family_member(){

		$saveData = array(
			"id" => $_POST['id'],
			"family_relationship" => $_POST['family_relationship_id'],
			"family_name" => $_POST['family_name'],
			"family_email" => $_POST['family_email'],
			"family_age" => $_POST['family_age'],
			"family_birthdate" => $_POST['family_birthdate']
		);

		$this->queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_conference_registration_screen_one_family_details", 'id');

		$data['_messageBundle'] = $this->_messageBundle('output', true);
		$data['_messageBundle']['_call_name'] = "edit_save_family_member";

		echo json_encode($data['_messageBundle']);
	}
	
	function new_save_family_member()
	{

		$record = $this->imiconf_queries->fetch_records_imiconf('conference_registration_screen_one', ' and conferenceregistrationid in ( select id from tb_conference_registration_master where userid = ' . $_POST['id'] . ' and conferenceid is null and participanttypeid is null and regionid is null and registration_site = "IMI_FAMILY_MEMBER" )');
		
		if ( $record->num_rows() > 0 ){

			$screen_one_id = $record->row()->id;
			
		}else{

			$crm = $this->imiconf_queries->fetch_records_imiconf('conference_registration_master', ' and conferenceid is null and participanttypeid is null and regionid is null and registration_site = "IMI_FAMILY_MEMBER" and userid = '. $_POST['id']);

			if ($crm->num_rows() > 0) {
				$conferenceregistrationid = $crm->row()->id;
			} else {
				
				$saveData = array(
					"userid" => $_POST['id'],
					"date_added" => date('Y-m-d H:i:s'),
					"registration_site" => "IMI_FAMILY_MEMBER"
				);

				$this->queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_registration_master");
				$conferenceregistrationid = $this->db_imiconf->insert_id();
			}

			$saveData = array(
				"conferenceregistrationid" => $conferenceregistrationid,
				"date_added" => date('Y-m-d H:i:s'),
				"no_of_family_members" => 1
			);
			
			$this->queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_registration_screen_one");
			$screen_one_id = $this->db_imiconf->insert_id();
		}

		$saveData = array(
			'parentid' => $screen_one_id,
			"family_relationship" => $_POST['family_relationship_id'],
			"family_name" => $_POST['family_name'],
			"family_email" => $_POST['family_email'],
			"family_age" => $_POST['family_age'],
			"family_birthdate" => $_POST['family_birthdate']
		);

		$this->queries->SaveDeleteTables_imiconf($saveData, 's', "tb_conference_registration_screen_one_family_details");
		$family_id = $this->db_imiconf->insert_id();
		
		$data['_messageBundle'] = $this->_messageBundle('output', true);
		$data['_messageBundle']['_call_name'] = "edit_save_family_member";
		$data['_messageBundle']['family_id'] = $family_id;

		echo json_encode($data['_messageBundle']);
	}
	
	function delete_family_member(){

		$saveData = array(
			'id' => $_POST['id']
		);

		$this->queries->SaveDeleteTables_imiconf($saveData, 'd', "tb_conference_registration_screen_one_family_details","id");

		$data['_messageBundle'] = $this->_messageBundle('output', true);
		$data['_messageBundle']['_call_name'] = "edit_save_family_member";

		echo json_encode($data['_messageBundle']);
	}

	function upload_profile_picture(){

		$return = array('success' => false,'message' => 'An error occured please contact administrator.');

		if( isset($_POST['nonce']) && $this->encrption->decrypt( $_POST['nonce']) == "profile_nonce" ){


			if (isset($_FILES['profile_image']) && $_FILES['profile_image']['tmp_name'] != "") {
            
                #################################
                ###  	upload_image_1  	  ###
                #################################
                $other_upload						= array("validate"											=> true,
                                                            "input_field"										=> "profile_image",
                                                            "db_field"											=> "profile_image",
                                                            "input_nick"										=> "Image",
                                                            "hdn_field"											=> "profile_image",
                                                            "tmp_table_field"									=> "profile_image",
                                                            "is_multiple"										=> false
														);

				$this->data["images_dir"]	 								= "./assets/frontend/images/";
				$this->data["images_types"]	 								= "gif|png|jpg";
                    
                $config_image						= array(
                                                            "upload_path"										=> $this->data["images_dir"],
                                                            "allowed_types"										=> $this->data['images_types'],
                                                            "max_size"											=> '5096', //5MB
                                                            "encrypt_name"										=> true
                                                        );
                
                $config_thumb						= array();
                
                    
				$tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);
				
				if ( isset( $tmp_upload_image_1['error'] ) && $tmp_upload_image_1['reason'] != "pass" ){
					$return['message'] = $tmp_upload_image_1['msg'];
				}else{
				
					$user_profile_Data			= array("userid"							=> $this->functions->_user_logged_in_details("id"));

					if (isset($tmp_upload_image_1['hdn_array']['profile_image'])) {
						$user_profile_Data['profile_image'] =  $this->data['images_dir'].$tmp_upload_image_1['hdn_array']['profile_image'];

						$user_profile = $this->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = " . $this->functions->_user_logged_in_details("id"));
						if ($user_profile->num_rows() > 0) {
							$this->queries->SaveDeleteTables_imiconf($user_profile_Data, 'e', "tb_users_profile", 'userid');
						} else {
							$this->queries->SaveDeleteTables_imiconf($user_profile_Data, 's', "tb_users_profile", 'id');
						}

						$return['success'] = true;
						$return['message'] = 'success';
						$return['html'] = $this->functions->timthumb($this->data['images_dir'].$tmp_upload_image_1['hdn_array']['profile_image'], 200, 200);
					}
				}
            }
		}

		echo json_encode($return);
		die;
	}

	public function set_language($code = DEFAULT_LANG_CODE)
	{
		 
		SessionHelper::_set_session(['LANG_CODE'=>$code] );
		
		echo json_encode(['success'=>true ]);
	}
	public function get_country_states($countryID)
	{
		$country_states = DropdownHelper::state_dropdown(FALSE,'id',FALSE," AND country_id = {$countryID}");
		$html = "";
		foreach($country_states as $key => $name )
		{
			$html .= "<option value='{$key}'>{$name}</option>";	
		}
		echo json_encode(['status'=>'success','html'=>$html ]);
	}
	public function get_state_cities($stateID)
	{
		$state_cities = DropdownHelper::city_dropdown(FALSE,'id',FALSE," AND state_id = {$stateID}");
		$html = "";
		foreach($state_cities as $key => $name )
		{
			$html .= "<option value='{$key}'>{$name}</option>";	
		}
		echo json_encode(['status'=>'success','html'=>$html ]);
	}
	public function short_conferenceregion_by_conferenceid( $conferenceid = 0, $is_ajax = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $conferenceid ) )
		{
			$conferenceid 				= 0;
		}
		
	
		
		$output						= form_dropdown( 	"regionid", 
														DropdownHelper::short_conferenceregions_dropdown( 	FALSE, "", FALSE, " AND conferenceid = '". $conferenceid ."' " ),  
														set_value("regionid", $this->input->post("regionid") ), 
														"class='form-control' " );
		
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "short_conferenceregion_by_conferenceid";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	public function short_conferencepriceparent_by_conferenceid_whoattendid_regionid( $conferenceid = 0, $whoattendid = 0, $regionid = 0, $is_ajax = TRUE, $show_dropdown = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $conferenceid ) )
		{
			$conferenceid 				= 0;
		}
		
	
		
		// 	FALSE, "", FALSE, " AND conferenceid = '". $conferenceid ."' " 
		if ( $show_dropdown )
		{
			$output						= form_dropdown( 	"parent_id", 
															DropdownHelper::short_conferenceprices_dropdown(FALSE, ' AND is_addon = 1 AND  title != "" AND regionid = "'. $regionid .'" '),  
															set_value("parent_id", $this->input->post("parent_id") ), 
															"class='form-control' " );
		}
		else
		{
			$output						= DropdownHelper::short_conferenceprices_dropdown(TRUE, ' AND is_addon = 1 AND  title != "" AND regionid = "'. $regionid .'" ');
		}
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "short_conferencepriceparent_by_conferenceid_whoattendid_regionid";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	public function short_conferencetype_by_conferenceid( $conferenceid = 0, $type = 0, $is_ajax = TRUE, $show_dropdown = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $conferenceid ) )
		{
			$conferenceid 				= 0;
		}
	
		if ( $show_dropdown )
		{
			$output						= form_dropdown("type", DropdownHelper::pkgtype_dropdown($conferenceid), set_value("type", $type), "class='form-control'" );
			
		}
		else
		{
			$output						= DropdownHelper::pkgtype_dropdown($conferenceid);
				
		}
		
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "short_conferencetype_by_conferenceid";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
	function ajax_datatable_conferenceprice_addons( $conference_master_id = 0,  $is_ajax = TRUE )
	{
		$data						= $this->data;
		
		if ( ! $this->validations->is_numeric( $conference_master_id ) )
		{
			$conference_master_id 				= 0;
		}
	
		$get_all_price_addons		= $this->queries->fetch_records(	"short_conference_prices_master", 
																		" AND parent_id = '". $conference_master_id ."' ", 
																		" * ");
		
		
		if ( $get_all_price_addons->num_rows() > 0 )
		{
			$output						= ' <table id="tbl_records" class="table table-condensed">
											<thead>
												<tr>
													<th style="width:10px;"></th>
													<th>Title</th>
													<th>Description</th>
													<th style="width:10px;"></th>
												</tr>
											</thead>
											
											<tbody>';
											
			foreach ($get_all_price_addons->result_array() as $gapa)
			{
				$output						.= '<tr>
													<td>'. form_checkbox( array("name" => "checkbox_options[]", "value" => $gapa["id"]) ) .'</td>
													<td>'. $gapa["title"] .'</td>
													<td>'. nl2br( $gapa["description"] ) .'</td>
													<td>
													 <a href="'. site_url(  "admincms/manageshortconferenceprices/controls/edit/" . $gapa["id"]) .'">
														<input type="button" class="btn btn-success btn-sm" value="'. lang_line("text_edit") .'"  />
													</a>
													</td>
												</tr>';
			}
											
			$output						.= '								 
												</tbody>
												<tfoot>
												</tfoot>
											</table>';
												
		}
		else
		{
			$output						= '<small class="badge pull-center bg-red" style="">no addons found</small>';
		}
		
		$data['_messageBundle']								= $this->_messageBundle( 'output' , $output);
		$data['_messageBundle']['_call_name']				= "ajax_conferenceprice_addons";
		
		if ( $is_ajax )
		{
			echo json_encode( $data['_messageBundle'] );	
		}
		else
		{
			return 	$data['_messageBundle'];	
		}
	}
}