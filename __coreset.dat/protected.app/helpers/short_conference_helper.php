<?php
class ShortConferenceHelper 
{
	function __construct()
	{
		parent::__construct();
		
		#$this->CI 								=& get_instance();
	}
	
	
	static  function calculate_screentwo_from_database( $conferenceregistrationid  = FALSE )
	{
		$CI										=& get_instance();
		$TMP_amount								= 0;
		if ( $conferenceregistrationid )
		{
			$_screen_two						= $CI->queries->fetch_records("short_conference_registration_screen_two", " AND conferenceregistrationid = '". $conferenceregistrationid ."' ");
			
			
			if ( $_screen_two->num_rows() > 0 )
			{
				$TMP_amount							= $_screen_two->row("price_package_fee");
				if ( $_screen_two->row('be_a_member') > 0 )
				{
					$TMP_amount						+= $_screen_two->row('be_a_member_fee_price');
				}
				
				if ( $_screen_two->row('price_less_absfee') > 0 )
				{
					$TMP_amount						-= $_screen_two->row('price_less_absfee');
				}
			}
		}
		
		return $TMP_amount	;
	}
	
}

?>