<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/


define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
 
define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');





define("IMI_NON_MEMBER", 1);
define('ADMIN_LOGIN_ATTEMPTS',								3);


define('FRONTEND_FOLDER_CSS',								'/assets/frontend/css/');
define('FRONTEND_FOLDER_JS',								'/assets/frontend/js/');
define('FOLDER_WIDGETS',									'/assets/widgets/');
 



#templates
define('ADMINCMS_TEMPLATE_VIEW',					'admincms/template/index.php');
define('ADMINCMS_TEMPLATE_LOGIN_VIEW',				'admincms/template_login/index.php');
define('ADMINCMS_TEMPLATE_LOCKSCREEN_VIEW',			'admincms/template_lockscreen/index.php');

 
define('FRONTEND_TEMPLATE_HOME_VIEW',									'frontend/template/index_home.php');
define('FRONTEND_TEMPLATE_LEFT_RIGHT_CENTER_WIDGETS_VIEW',				'frontend/template/index_left_right_center_widgets.php');
define('FRONTEND_TEMPLATE_LEFT_RIGHT_WIDGETS_VIEW',						'frontend/template/index_left_right_widgets.php');
define('FRONTEND_TEMPLATE_HALF_CENTER_VIEW',							'frontend/template/index_half_center.php');
//define('FRONTEND_TEMPLATE_FULL_CENTER_VIEW',							'frontend/template/index_full_center.php');
#define('SITE_CODE','IMIPORTAL');
define('FRONTEND_TEMPLATE_FORMS_VIEW',                                                          'frontend/template/index_half_center.php');


define('FRONTEND_TEMPLATE_LEFT_WIDGETS_VIEW',		'frontend/template/index_left_widgets.php');
define('FRONTEND_TEMPLATE_RIGHT_WIDGETS_VIEW',		'frontend/template/index_right_widgets.php');
define('FRONTEND_TEMPLATE_CENTER_WIDGETS_VIEW',		'frontend/template/index_center_widgets.php');


define('FRONTEND_TEMPLATE_ACCOUNT_VIEW',			'frontend/template_account/index.php');

define('FRONTEND_TEMPLATE_FULL_CONF_VIEW',				'frontend/template/index_full_conf.php');



define("SLUG_PAGE", "page");
define("SLUG_WHATWEDO", "whatwedo");
define("SLUG_GETINVOLVED", "getinvolved");
define("SLUG_CHAPTERS", "chapters");
define("SLUG_ACTIVITIES", "activities");
define("SLUG_EVENTS", "events");
define("SLUG_PRESS", "press");
define("SLUG_comments", "comments");
define("SLUG_IMI", "news");
define("SLUG_TOPIC_DETAIL","topic_detail");
define("SLUG_EVENTS_ACTIVITIES", "events_activities");
define("SLUG_TIMELINE", "timeline");
define("SLUG_DONATION_CAMPAIGNS", "donation-campaigns");




define("MENUPOSITION_HEADERSOCIALBUTTONS", "header-socialbuttons");
define("MENUPOSITION_FOOTERSOCIALBUTTONS", "footer-socialbuttons");
define("MENUPOSITION_GETINVOLVED", "getinvolved");
define("MENUPOSITION_EVENTARTICLES", "event/articles");
define("MENUPOSITION_BIGFOOTER", "big-footer");
define("MENUPOSITION_FOOTER", "footer");
define("MENUPOSITION_HEADER", "header");


define("WIDGET_CMSSECTION_CMSCONTENT", "cmscontent");
define("WIDGET_CMSSECTION_CHAPTERLOCATION", "chapterlocation");
define("WIDGET_CMSSECTION_TIMELINE", "timeline");
define("WIDGET_CMSSECTION_ACTIVITIESEVENTS", "activitiesevents");


define("IMICONF_DATABASE_GROUP", "imiconf");

define("VIRTUALHOST_SLUG_IMI_INTERNATIONAL", "international");
define("VIRTUALHOST_SLUG_IMI_CANADA", "canada");
define("VIRTUALHOST_SLUG_IMI_INTERNATIONAL_MEDICS", "medics");

define("VIRTUALHOST_IMI_CANADA", "imicanada.org" );
define("VIRTUALHOST_IMI_CANADA_LOCALHOST",  "127.0.0.1" );

define("VIRTUALHOST_IMI_MEDICS_INTERNATIONAL", "medicsinternational.org" );
define("VIRTUALHOST_IMI_MEDICS_INTERNATIONAL_LOCALHOST", "127.0.0.2");

$lang = 'EN';
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $lang = $_GET['lang'];
}
//define("DEFAULT_LANG_CODE", 'EN');
define("DEFAULT_LANG_CODE", $lang);
/* End of file constants.php */
/* Location: ./application/config/constants.php */