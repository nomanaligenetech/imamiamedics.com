<?php
switch ( TRUE )
{
	case strpos( SessionHelper::_get_session("slug", "conference"), 'future-advancements---technology-in-medicine---allied-sciences--fatima') !== FALSE:  //if 12
		$this ->load->view( "admincms/manageshortconferenceregistration/12/view_table" ) ;
		break;

	case strpos( SessionHelper::_get_session("slug", "conference"), '10th') !== FALSE:  //if 9
		$this ->load->view( "admincms/manageshortconferenceregistration/10/view_table" ) ;
		break;
		
	case strpos( SessionHelper::_get_session("slug", "conference"), '9th') !== FALSE:  //if 9
		$this ->load->view( "admincms/manageshortconferenceregistration/9/view_table" ) ;
		break;
		
		
		
		
	default: //if 8
		$this ->load->view( "admincms/manageshortconferenceregistration/8/view_table" ) ;
		break;
}
?>
