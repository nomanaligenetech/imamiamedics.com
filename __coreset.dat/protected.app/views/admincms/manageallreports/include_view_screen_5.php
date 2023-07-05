<?php 
switch ( $conference->row()->slug )
{
	case strpos($conference->row()->slug, 'future-advancements---technology-in-medicine---allied-sciences--fatima-') !== FALSE:
		$this->load->view("frontend/conference/12/include_screen_five.php");
		break;
	
	default:
		$this->load->view("frontend/conference/include_screen_five.php");
		break;
}

?>