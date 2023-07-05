<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_TOPIC_detail extends C_frontend {

	/**
	 * Index Page for CI controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since CI controller is set as the default controller in 
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




        $TMP_data["_heading"]										= 'Forums';
		$TMP_data["_pagetitle"]									=$TMP_data["_heading"];
		
		



	//	$data														= $CI->data;
		
		$_pageview											= "frontend/cms/page_plugins/imi_topic_detail.php";
		
		$TMP_data=array(
							"menu_slug"				=> $data['menu_detail']->row("slug"),
							"forums_details"	=> $ci->queries->fetch_records("forumsdetails", " ORDER BY id DESC ")
						);
		
	
		if ( $TMP_data['forums_details'] -> num_rows() <= 0 )
		{
			$TMP_data['_messageBundle']										= $ci->_messageBundle( 'info' , lang_line("text_norecordfound"), ' ');
		}
		
		return $ci->load->view( $_pageview	, $TMP_data ,TRUE);





  	}

}