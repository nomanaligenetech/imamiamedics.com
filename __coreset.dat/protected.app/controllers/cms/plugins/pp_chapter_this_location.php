<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Chapter_This_Location extends C_frontend {

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
	}
	
	
	
	
	static public function show( $data = array(), $ci )
	{
		if ( !isset($data['slug']) )
		{
			$data['slug']				= FALSE;
		}
		
		
		$TMP_data						= array("slug"				=> $data['slug'],
												"readmore"			=> FALSE);
		
		return $ci->load->view("frontend/template/widgets/chapterlocations", $TMP_data, TRUE );
		
		#return $ci->load->view( "frontend/cms/page_plugins/pp_chapter_this_location", $data, TRUE );
	}
	
}