<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Press_Releases extends C_frontend {

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
	
	
	
	
	static public function show( $data = array(), $ci)
	{
		
		$_pageview = 'frontend/cms/page_plugins/pp_press_releases';

		$TMP_data	= array(
							"menu_slug"				=> $data['menu_detail']->row("slug"),
							"pressreleasedetail"	=> $ci->queries->fetch_records("pressRelease","ORDER BY id DESC")->result()
						);
		
		return $ci->load->view( $_pageview, $TMP_data, TRUE );
	}

	static public function detail( $id = '' )
	{

		$ci =& get_instance();

		if ( !isset($data['slug']) )
		{
			$data['slug']				= FALSE;
		}
		
		$extra_query = '';
		$_pageview = 'frontend/cms/page_plugins/pp_press_releases';
		if ( $id != "" ){
			$extra_query = ' AND id = '.$id. ' ';
			$_pageview = 'frontend/cms/page_plugins/pp_press_releases_child';
		}

		$TMP_data						= array("slug"				=> $data['slug'],
												"readmore"			=> FALSE,
												"pressreleasedetail"	=> $ci->queries->fetch_records("pressRelease",$extra_query."ORDER BY id DESC")->result());
		
		//return $ci->load->view("frontend/template/widgets/chapterlocations", $TMP_data, TRUE );
		
		return $ci->load->view( $_pageview, $TMP_data );
	}
	
}