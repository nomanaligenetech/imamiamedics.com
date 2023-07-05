<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class No_Access extends CI_Controller {

	public function __construct()
	{
        parent::__construct();

		$this->data = array();

		$this->data["_directory"] = $this->router->directory;
		$this->data["_pagepath"] = $this->router->directory . $this->router->class;

		$this->data["_heading"] = lang_line("heading_dashboard");
		$this->data["_pagetitle"] = "No Access - ";
		$this->data['_pageview'] = $this->data["_directory"] . "no-access";
		
	}
	public function index()
	{
		$data = $this->data;
		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */