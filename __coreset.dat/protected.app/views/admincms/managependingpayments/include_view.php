<?php
switch ( TRUE )
{
	case strpos( SessionHelper::_get_session("slug", "conference"), 'imi-north-american-conference') !== FALSE:  //if 12
		$this ->load->view( "admincms/manageallreports/12/view" ) ;
		break;
		
	default: //if 8
		$this ->load->view( "admincms/manageshortconferenceregistration/8/view" ) ;
		break;
}
?>