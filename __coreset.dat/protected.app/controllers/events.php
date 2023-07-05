<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends C_frontend {

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
	
	
	public function index()
	{ 
		
		$data														= $this->data;		
		
		
		
		
		
		$data['eventslist_category']								= $this->queries->fetch_records('sitesectionswidgets_details', 
																									" AND parentid IN (SELECT id FROM `tb_sitesectionswidgets` WHERE  mode = '". SLUG_EVENTS ."'  ORDER BY sort ) ");		
		
		$data['_pageview']											= "frontend/events.php";
		
		$this->load->view( FRONTEND_TEMPLATE_HOME_VIEW, $data );
	}

	public function event_joining()
	{
		$email_not_sent_yet = $this->queries->fetch_records('whojoinevents', ' and is_email_sent = 0');
		$eventcount = $this->queries->fetch_records('whojoinevents', ' and is_email_sent = 0 group by eventid', ' eventid , count(eventid) as eventcount ');

		if ($email_not_sent_yet->num_rows() > 0) {
			$result = $email_not_sent_yet->result();
			$count_result = $eventcount->result_array();

			foreach ($result as $key => $value) {
				$total = $email_not_sent_yet->num_rows();
				$k = array_search($value->eventid, array_column($count_result, 'eventid'));

				$event_details = $this->queries->fetch_records('sitesectionswidgets', " AND id='" . $value->eventid . "'");
				$events[$value->eventid] = array('details' => $event_details->row(), 'count' => $count_result[$k]['eventcount']);
			}

			/* Mail to Admin */
			
			/*
			$user_details = $this->queries->fetch_records_imiconf('users', " AND id='" . $userid . "'");
			$user = $user_details->row();
			 */
			$heading = 'Today\'s Event Join Report Dated (' . date('F j Y', strtotime('now')) . ')';

			$email_template = array(
				"email_heading" => $heading,
				"email_file" => "email/frontend/event_email.php",
				"email_subject" => $heading,
				"default_subject" => true,
				"email_post" => array('events' => $events, 'total' => $total, 'admin_url' => site_url('admincms/whojoinevents/controls/view'))
			);

			$is_email_sent = $this->_send_email($email_template);

			if ($is_email_sent) {

				foreach ($result as $key => $value) {

					$saveData = array(
						'id' => $value->id,
						'is_email_sent' => 1
					);

					$this->queries->SaveDeleteTables($saveData, 'e', "tb_join_event", 'id');
				}
			}
			
			/* Mail to Admin */

		}
	}
	
}