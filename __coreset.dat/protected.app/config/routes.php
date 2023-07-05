<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES 
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
 

$route['default_controller'] = "home";

#$route['404_override'] = 'home/_404';
#$route['404'] = "home/_404";

$route['404_override'] = 'home/_404';



$route['data_scraper'] = "data_scraper";
$route['data_scraper/scrape'] = "data_scraper/scrape";

$route['shortconference/([a-zA-Z-0-9.&]+)/conference_login'] = "shortconference/registration/pricing/conference_login/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration'] = "shortconference/registration/index/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/summary'] = "shortconference/registration/index/summary/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/closed'] = "shortconference/registration/index/closed/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/pricing'] = "shortconference/registration/pricing/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/1'] = "shortconference/registration/screen_one/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/2'] = "shortconference/registration/screen_two/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/2/1'] = "shortconference/registration/screen_two/index/$1/1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/3'] = "shortconference/registration/screen_three/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/4'] = "shortconference/registration/screen_four/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/4/([a-zA-Z-0-9.&]+)'] = "shortconference/registration/screen_four/index/$1/$2";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/5/payment/([a-zA-Z-0-9.&]+)'] = "shortconference/registration/screen_five/payment/$1/$2";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/screen/5'] = "shortconference/registration/screen_five/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/success'] = "shortconference/registration/index/success/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/paymentsuccess'] = "shortconference/registration/index/payeezy_success/$1";

$route['shortconference/([a-zA-Z-0-9.&]+)/registration/form'] = "shortconference/registration/form/index/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/form/success'] = "shortconference/registration/form/success/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/form/paymentsuccess'] = "shortconference/registration/form/payeezy_success/$1";
$route['shortconference/([a-zA-Z-0-9.&]+)/registration/form/itemForm'] = "shortconference/registration/form/itemForm/$1";

$route['page/'.SLUG_DONATION_CAMPAIGNS] = "donation_campaigns/show";
$route['page/'.SLUG_DONATION_CAMPAIGNS . '/getCampaigns'] = "donation_campaigns/getCampaigns";
$route['page/'.SLUG_DONATION_CAMPAIGNS . '/getDonors'] = "donation_campaigns/getDonors";
$route['page/'.SLUG_DONATION_CAMPAIGNS . '/getFeedback'] = "donation_campaigns/getFeedback";
$route['page/'.SLUG_DONATION_CAMPAIGNS . '/getUpdates'] = "donation_campaigns/getUpdates";
$route['page/'.SLUG_DONATION_CAMPAIGNS . '/([a-zA-Z-0-9.&]+)'] = "donation_campaigns/show/$1";
$route['page/'.SLUG_DONATION_CAMPAIGNS . '/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&]+)'] = "donation_campaigns/show/$1/$2";


$route['page/([a-zA-Z-0-9.&]+)'] = "cms/page/index/$1";
$route['page/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&_]+)'] = "cms/page/index/$1/$2";

$route['pay_recurring'] = "cms/page/payeezy_recurring_payment/$1";

$route[SLUG_CHAPTERS . '/([a-zA-Z-0-9.&]+)'] = "cms/page/chapters/$1";
$route[SLUG_TIMELINE . '/([a-zA-Z-0-9.&]+)'] = "cms/page/timeline/$1";


$route['page/([a-zA-Z-0-9.&]+)/' . SLUG_EVENTS] = "cms/page/events_or_activities_list/$1/events";
$route['page/([a-zA-Z-0-9.&]+)/' . SLUG_ACTIVITIES] = "cms/page/events_or_activities_list/$1/activities";


$route['page/([a-zA-Z-0-9.&]+)/' . SLUG_EVENTS . '/([a-zA-Z-0-9.&]+)'] = "cms/page/events_activities/$1/$2";
$route['page/([a-zA-Z-0-9.&]+)/' . SLUG_ACTIVITIES . '/([a-zA-Z-0-9.&]+)'] = "cms/page/events_activities/$1/$2";
$route['page/([a-zA-Z-0-9.&]+)/' . SLUG_EVENTS . '/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&]+)'] = "cms/page/events_activities/$1/$2/$3";

$route['page/([a-zA-Z-0-9.&]+)/press/([a-zA-Z-0-9.&]+)'] = "cms/page/press_releases_details/$1/$2"; 
$route['page/([a-zA-Z-0-9.&]+)/news/([a-zA-Z-0-9.&]+)'] = "cms/page/imi_news_detail/$1/$2"; //

$route['page/([a-zA-Z-0-9.&]+)/topic_detail/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&]+)'] = "cms/page/imi_topic_detail/$1/$2/$3/$4/$5/"; //
$route['page/([a-zA-Z-0-9.&]+)/topic_detail/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&]+)/([a-zA-Z-0-9.&]+)'] = "cms/page/imi_topic_detail/$1/$2/$3/$4/"; //

$route['page/([a-zA-Z-0-9.&]+)/comments/([a-zA-Z-0-9.&]+)'] = "cms/page/comments/$1/$2/"; //

$route['admincms'] = "admincms/index";

/* End of file routes.php */
/* Location: ./application/config/routes.php */