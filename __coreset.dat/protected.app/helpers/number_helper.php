<?php
class NumberHelper
{
	function __construct()
	{
		parent::__construct();
		
	} 

	function convert_number_to_words($number) 
	{
		
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = lang_line('text_numberwords_dictionary');
		
		if (!is_numeric($number)) {
			return false;
		}
		
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}
		
		$string = $fraction = null;
		
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
		
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convert_number_to_words($remainder);
				}
				break;
		}
		
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
		
		return $string;
	}
	
	
	function number_array( $range = array(), $change_index = TRUE )
	{
		$tmp_array			= array();
		
		foreach ( $range as $key => $value )
		{
			if ( $change_index )
			{
				$tmp_array[ $value ]	= $value;
			}
			else
			{
				$tmp_array[]	= $value;
			}
		}
		
		return $tmp_array;
	}
	
	function ordinalize($num) 
	{
        $suff = 'th';
        if ( ! in_array(($num % 100), array(11,12,13))){
            switch ($num % 10) {
                case 1:  $suff = 'st'; break;
                case 2:  $suff = 'nd'; break;
                case 3:  $suff = 'rd'; break;
            }
            return "{$num}{$suff}";
        }
        return "{$num}{$suff}";
    }
	
	function number_to_text_array( $range = array(), $additional_text = "", $uppercase = FALSE, $change_index = FALSE )
	{
		$tmp_array			= array();
		
		foreach ( $range as $key => $value )
		{
			
			$TMP_text				= $additional_text;
			if ( $value == 1 and $additional_text != "")
			{
				$TMP_text			= " " . lang_line('text_person');	
			}
			
			$text			= NumberHelper::convert_number_to_words( $value );
			
			if (  $uppercase  )
			{
				$text		= ucfirst( $text );
			}
			
			
			if ( $change_index )
			{
				
				$tmp_array[ $value ]	= $text . $TMP_text;
			}
			else
			{
				$tmp_array[]	= $text . $TMP_text;
			}
		}
		
		return $tmp_array;
	}
	
	
	
	function timehour_array( $_12format = FALSE )
	{
		$tmp_arr						= array();
		
		
		
		$start_range						= 0;
		$end_range							= 23;
		if ( $_12format )
		{
			$start_range					= 1;
			$end_range						= 12;
		}
		
		
		foreach (range($start_range, $end_range) as $key => $value)
		{
			$tmp_data					= sprintf('%02d', $value);
			$tmp_arr[ $tmp_data ]		= $tmp_data;
		}
		
		return $tmp_arr;
		
	}
	
	function timeminutes_array()
	{
		$tmp_arr						= array();
		foreach (range(0, 59) as $key => $value)
		{
			$tmp_data					= sprintf('%02d', $value);
			$tmp_arr[ $tmp_data ]		= $tmp_data;
		}
		
		return $tmp_arr;
		
	}
	
	
	function timeformat_array()
	{
		$tmp_array["AM"]			= "AM";
		$tmp_array["PM"]			= "PM";
		
		return $tmp_array;
	}
	
	function datemonth_array( $hide_first_index = FALSE )
	{
		$tmp_arr						= array();
		
		
		if ( !$hide_first_index )
		{
			$tmp_arr[""]							= "--";
		}
		
		foreach (range(1, 12) as $key => $value)
		{
			$tmp_data					= sprintf('%02d', $value);
			$tmp_arr[ $tmp_data ]		= $tmp_data;
		}
		
		return $tmp_arr;
		
	}
	
	function dateyear_array( $hide_first_index = FALSE )
	{
		$tmp_arr						= array();
		
		
		if ( !$hide_first_index )
		{
			$tmp_arr[""]							= "--";
		}
		
		foreach (range(2011, 2023) as $key => $value)
		{
			$tmp_data					= sprintf('%02d', $value);
			$tmp_arr[ $tmp_data ]		= $tmp_data;
		}
		
		return $tmp_arr;
		
	}
}