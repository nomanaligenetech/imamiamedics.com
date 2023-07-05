<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_IMI_News extends C_frontend {

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
  
 
 		$_pageview = 'frontend/cms/page_plugins/pp_imi_news';
		$TMP_data	= array(
							"menu_slug"				=> $data['menu_detail']->row("slug"),
							"iminews"	=> $ci->queries->fetch_records("news","ORDER BY id DESC")->result()
						);


		return $ci->load->view( $_pageview, $TMP_data, TRUE );
	}

}