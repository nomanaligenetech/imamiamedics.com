<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sight_Seeing extends C_frontend {

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
		
		$this->data['_pagetitle']									= lang_line('text_sightseeing');
		
	}
	
	
	public function index( $conference_slug = '' )
	{ 



		$data									= $this->data;
		
		
		
		
		$data['conference']						= $this->queries->fetch_records('conference', " AND slug = '". $conference_slug ."' ", ' name ');
		if ( $data['conference']	 -> num_rows() <= 0 )
		{
			page_error( $data  );	
			return false;
		}
		
		
		
		$data['h1']								= lang_line('text_sightseeing') . ' ('. $data['conference']->row("name") .')';
		$data['sight_seeing']					= $this->mixed_queries->fetch_records("sightseeing_by_conference", 
																					  " AND countryid = '". SessionHelper::_get_session("countryid", "conference") ."' AND status = 1 ");


		$data['_pageview']						= "frontend/sight_seeing.php";		
		$this->load->view( FRONTEND_TEMPLATE_INNER_VIEW, $data );	
	}
	
	

}