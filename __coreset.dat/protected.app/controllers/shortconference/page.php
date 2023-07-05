<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends C_frontend {

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
	

	
	public function index( $conference_slug = '', $page_slug = '' )
	{ 

		$data									= $this->data;
		
		
		

		$data['conference']						= $this->queries->fetch_records('conference', " AND slug = '". $conference_slug ."' ", ' * ');
		if ( $data['conference']	 -> num_rows() <= 0 )
		{
			page_error( $data );	
			return false;
		}
		
		
		
		$data['menu_detail']					= $this->queries->fetch_records('conferencemenu', " AND slug = '". $page_slug ."' AND status = '1'");
		if ( $data['menu_detail'] -> num_rows() <= 0 )
		{
			page_error( $data  );
			return false;
		}
		
		
		
		
		
		$data['menu_active']					= $data['menu_detail']->row("name");
		$data['_pagetitle']						= $data['menu_detail']->row("name");
		$data['content_detail']					= $this->queries->fetch_records('conferencecontent', " AND menuid = '". $data['menu_detail']->row("id") ."' ");
		
		
		
		$data['left_widgets']					= FALSE;	
		if ( $data['content_detail']->num_rows() > 0 )
		{
			#get widgets
			$data['left_widgets']					= $this->queries->fetch_records('conferencecontent_widgets', 
																					" AND parentid = '". $data['content_detail']->row("id") ."' AND is_mode = 'left' order by widget_id desc")->result_array();
		}
		
		
		
		
		$data['_pageview']						= "frontend/cms/page.php";		
		
		
		
		$data['_messageBundle2']				= $this->_messageBundle( 'warning' , 'To be announced soon' );
		
		
		
		
		
		
		
		
		if ( $data['left_widgets'] )
		{
			
			$this->load->view( FRONTEND_TEMPLATE_WIDGETS_VIEW, $data );	
		}
		else
		{
			$this->load->view( FRONTEND_TEMPLATE_INNER_VIEW, $data );	
		}
	}
	
}