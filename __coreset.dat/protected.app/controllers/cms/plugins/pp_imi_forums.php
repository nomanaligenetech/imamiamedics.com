<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_IMI_Forums extends C_frontend {

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




      // $CI->data													= $CI->default_data();
		
		//$CI->data["_directory"]									= $CI->router->directory;
	//	$CI->data["_pagepath"]									= $CI->router->directory . $CI->router->class;
		
		
		$TMP_data["_heading"]										= 'Forums';
		$TMP_data["_pagetitle"]									=$TMP_data["_heading"];
		
		//$TMP_dir												= "frontend/";
		//$CI->data['_pageview']									= $CI->TMP_dir . $CI->data["_directory"] . "view.php";
		



	//	$data														= $CI->data;
		
		$_pageview											= "frontend/cms/page_plugins/imi_forums_view.php";
		
		$TMP_data=array(
							"menu_slug"				=> $data['menu_detail']->row("slug"),
							"forums_details"	=> $ci->queries->fetch_records("forumsdetails", " ORDER BY id DESC ")
						);
		
		#
		//$TMP_data['forums_details']									= $ci->queries->fetch_records("forumsdetails", " ORDER BY id DESC ");	
		
		#$CI->load->library("Encrption");
		#echo $CI->encrption->decrypt("VwAmSaPM/mb2bAtnfuuS0nL1H0alixEfm5Y="); //Woodbridge001
		#die;
		if ( $TMP_data['forums_details'] -> num_rows() <= 0 )
		{
			$TMP_data['_messageBundle']										= $ci->_messageBundle( 'info' , lang_line("text_norecordfound"), ' ');
		}
		
	   //print_r($_pageview); die;
		return $ci->load->view( $_pageview	, $TMP_data ,TRUE);





  


  /*
 
 		$_pageview = 'frontend/cms/page_plugins/pp_imi_news';
		$TMP_data	= array(
							"menu_slug"				=> $data['menu_detail']->row("slug"),
							"iminews"	=> $ci->queries->fetch_records("news","ORDER BY id DESC")->result()
						);


		return $ci->load->view( $_pageview, $TMP_data, TRUE );
*/	}

}