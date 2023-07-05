<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_mobilecontroller extends C_frontend {

	protected $method;
	protected $controller;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->controller 	= strtolower($this->router->fetch_class());
		$this->method 		= strtolower($this->router->fetch_method()); 
				
	}	

}