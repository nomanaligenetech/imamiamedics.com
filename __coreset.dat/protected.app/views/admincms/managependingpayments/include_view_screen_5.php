<?php 
switch ( $conference->row()->slug )
{
	case strpos($conference->row()->slug, 'imi-north-american-conference') !== FALSE:
		$this->load->view("frontend/conference/12/include_screen_five.php");
		break;
	
	default:
		$this->load->view("frontend/conference/include_screen_five.php");
		break;
}

?>