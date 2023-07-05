<?php
$TMP_hidethistr					= TRUE;
$TMP_page_2_input				= TRUE;
$TMP_page_1						= TRUE;
$TMP_page_4						= TRUE;
$TMP_page_5						= TRUE;
$TMP_proceedfurther				= TRUE;
$TMP_text_readonly				= TRUE;
$TMP_default_text				= TRUE;
$TMP_conf_reg_tabletab_details	= TRUE;


#if imi_group (show inputs, show hidethistr, hide default_text
if ( $conferenceregistration_screenone -> row("travelling_with") != "independently" )
{
	$TMP_hidethistr				= FALSE;
	$TMP_page_2_input			= FALSE;
	$TMP_page_1					= FALSE;
	$TMP_page_4					= FALSE;
	$TMP_page_5					= FALSE;
	$TMP_proceedfurther			= FALSE;
	$TMP_text_readonly			= FALSE;
	?>
    	<style>
		.hidethistr{ display:none;}
		.page_2 input{ display:none;}
		.page_1, .page_4, .page_5{ display:none;}
		input[name='proceedfurther']{ display:;}
		.conf-reg-tabletab  span.text_readonly{ display:none;}
		</style>
        
    <?php
	if ( $_SHOW_INPUTS )
	{
		
	}
}
else
{
	$TMP_default_text			= FALSE;
	?>
    	
	<style>
    span.default_text{ display:none;}
    </style>
        
        
    <?php
	
	if ( $_SHOW_INPUTS )
	{
		$TMP_text_readonly		= FALSE;
		
		?>
        <style>
		span.text_readonly{ display:none}
		</style>
        <?php	
	}
	else
	{
		$TMP_conf_reg_tabletab_details		= FALSE;
		
		?>
		<style type="text/css">
		.conf-reg-tabletab input, 
		.conf-reg-tabletab .cal-container, 
		.conf-reg-tabletab .tr_applyforsame,
		.conf-reg-tabletab textarea,
		.conf-reg-tabletab select{ display:none;}
		</style>
		<?php	
	}
}
?>

<p>&nbsp;</p>
<div class="conf-reg-tabletab">
	
    <?php
	if ( $TMP_page_1 )
	{
	?>
    <div class="page_1">
            <h1>Travel and Itinerary Planner</h1>
            <h2>Arrival at <?php echo SessionHelper::_get_session("arrival_at", "conference");?></h2>
            
            
            
            
            
            
            
            
            
            
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th width="1%" align="left">&nbsp;</th>
              <th width="20%" align="left">Name of Passenger</th>
              <th width="5%" align="left">Age</th>
              <th width="21%" align="left">Airline</th>
              <th width="10%" align="left">Flight Number</th>
              <th width="20%" align="left">Arrival Day and Date</th>
              <th width="12%" align="left">Local Arrival Time </th>
                <th width="1%" align="left">&nbsp;</th>
            </tr>
                
                
            <?php
                $TMP_key					= 0;
                if ( $conferenceregistration_screenthree -> num_rows() > 0 )
                {
                ?>
                <tr>
                    <td class="tableborderhide">&nbsp;</td>
                    <td class="tableborderhide">
                      <?php
                        $tmp_name		= 'travelitinerary_name_of_passenger['. $TMP_key .']';
                        
                        if ( $TMP_conf_reg_tabletab_details )
                        {
                            $specdata		= array("name"			=> $tmp_name,
                                                    "id"			=> $tmp_name,
                                                    
                                                    "type"			=> "text",
                                                    "class"			=> set_class( $tmp_name ),
                                                    "value"			=> set_value( $tmp_name, $travelitinerary_name_of_passenger[ $TMP_key ] ),
                                                    "placeholder"	=> "Name of Passenger");	
                        
                            echo form_input($specdata);
                        }
						
						if ( $TMP_text_readonly )
						{
                        ?>
                      		<span class="text_readonly"> <?php echo set_value( $tmp_name, $travelitinerary_name_of_passenger[ $TMP_key ] );?></span>
						<?php
						}
						?>
                    </td>
                    <td class="tableborderhide">
                      <?php
                        $tmp_name				= 'travelitinerary_age['. $TMP_key .']';
                        $arrayindex				= NumberHelper::number_array( range("1", "90") );
                        ksort($arrayindex);
                        if ( $TMP_conf_reg_tabletab_details )
                        {
                            echo form_dropdown( $tmp_name, 
                                                $arrayindex, 
                                                set_value($tmp_name, $travelitinerary_age[ $TMP_key ]), 
                                                "class='form-control ". set_class( $tmp_name ) ." '" );
                        }				
						
						if (  $TMP_text_readonly )
						{
                        ?>
                      	<span class="text_readonly"> <?php echo set_value($tmp_name, $travelitinerary_age[ $TMP_key ]);?></span>
                        <?php
						}
						?>
                    </td>
                    <td class="tableborderhide">
                      <?php
                        $tmp_name		= 'travelitinerary_airline['. $TMP_key .']';
                        
                        if ( $TMP_conf_reg_tabletab_details )
                        {
                            $specdata		= array("name"			=> $tmp_name,
                                                    "id"			=> $tmp_name,
                                                    
                                                    "type"			=> "text",
                                                    "class"			=> set_class( $tmp_name ),
                                                    "value"			=> set_value( $tmp_name, $travelitinerary_airline[ $TMP_key ] ),
                                                    "placeholder"	=> "Airline");	
                        
                            echo form_input($specdata);
                        }
						
						if (  $TMP_text_readonly )
						{
                        ?>
                      	<span class="text_readonly"> <?php echo set_value( $tmp_name, $travelitinerary_airline[ $TMP_key ] );?></span>
                        <?php
						}
						?>
                    </td>
                    <td class="tableborderhide">
                      <?php
                        $tmp_name		= 'travelitinerary_flightnumber['. $TMP_key .']';
                        
                        if ( $TMP_conf_reg_tabletab_details )
                        {
                            $specdata		= array("name"			=> $tmp_name,
                                                    "id"			=> $tmp_name,
                                                    
                                                    "type"			=> "text",
                                                    "class"			=> set_class( $tmp_name ),
                                                    "value"			=> set_value( $tmp_name, $travelitinerary_flightnumber[ $TMP_key ] ),
                                                    "placeholder"	=> "Flight Number");	
                        
                            echo form_input($specdata);
                        }
						
						if (  $TMP_text_readonly )
						{
                        ?>
                      	<span class="text_readonly"> <?php echo set_value( $tmp_name, $travelitinerary_flightnumber[ $TMP_key ] );?></span>
                        <?php
						}
						?>
                    </td>
                    <td class="tableborderhide">
                        
                      <?php
                        $tmp_name		= 'travelitinerary_arrivaldaydate['. $TMP_key .']'; 
                        if ( $TMP_conf_reg_tabletab_details )
                        {
                        ?>
                        <div class="cal-container <?php echo set_class( $tmp_name );?>">
                          <div class="cal-input">
                            <?php
                            
                            $specdata		= array("name"			=> $tmp_name,
                                                    "id"			=> $tmp_name,
                                                    "type"			=> "text",
                                                    "class"			=> "datepicker ",
                                                    "value"			=> set_value( $tmp_name, $travelitinerary_arrivaldaydate[ $TMP_key ] ),
                                                    "placeholder"	=> "Arrival Day and Date");	
                        
                            echo form_input($specdata);
                            ?>
                          </div>
                          <div class="cal-btn"><a href="javascript:;"><img border="0" src="<?php echo base_url("assets/frontend/images/table-calander.png");?>" /></a></div>
                      </div>
                      <?php
                        }
						
						if (  $TMP_text_readonly )
						{
                        ?>
                        
                      	<span class="text_readonly"> <?php echo set_value( $tmp_name, $travelitinerary_arrivaldaydate[ $TMP_key ] );?></span>
                        <?php
						}
						?>
                    </td>
                    <td class="tableborderhide">
                      <?php
                        $tmp_name		= 'travelitinerary_localarrivaltime['. $TMP_key .']';
                        
                        if ( $TMP_conf_reg_tabletab_details )
                        {
                            $specdata		= array("name"			=> $tmp_name,
                                                    "id"			=> $tmp_name,
                                                    
                                                    "type"			=> "text",
                                                    "class"			=> "timepicker " . set_class( $tmp_name ),
                                                    "value"			=> set_value( $tmp_name, $travelitinerary_localarrivaltime[ $TMP_key ] ),
                                                    "placeholder"	=> "Local Arrival Time");	
                        
                            echo form_input($specdata);
                        }
						
						if (  $TMP_text_readonly )
						{
                        ?>
                      	<span class="text_readonly"> <?php echo set_value( $tmp_name, $travelitinerary_localarrivaltime[ $TMP_key ] );?></span>
                        <?php
						}
						?>
                    </td>
                    <td class="tableborderhide">&nbsp;</td>
                </tr>
            <?php
                }
                
                if ( $TMP_conf_reg_tabletab_details )
                {
                ?>
                
                    
                
					<?php
                    if ( $family_records -> num_rows() > 0 )
                    {
						?>
                        <tr bgcolor="#efefef" class="tr_applyforsame">
                          <td class="tableborderhide" colspan="8" align="center" height="25">
                            Accompanying Family Members 
                            <a href="javascript:;" onclick="applysameforall('.page_1')">Apply same for all</a>
                          </td>
                    	</tr>
                        
                        <?php
                        foreach ( $family_records -> result_array() as $fr)
                        {
                            $TMP_key++;
                        ?>
                        <tr>
                            <td class="tableborderhide">&nbsp;</td>
                            <td class="tableborderhide">
                              <?php
                                $tmp_name		= 'travelitinerary_name_of_passenger['. $TMP_key .']';
                                
                                if ( $TMP_conf_reg_tabletab_details )
                                {
                                    $specdata		= array("name"			=> $tmp_name,
                                                            "id"			=> $tmp_name,
                                                            
                                                            "type"			=> "text",
                                                            "class"			=> set_class( $tmp_name ),
                                                            "value"			=> set_value( $tmp_name, $travelitinerary_name_of_passenger[ $TMP_key ] ),
                                                            "placeholder"	=> "Name of Passenger");	
                                
                                    echo form_input($specdata);
                                }
                                
                                if (  $TMP_text_readonly )
                                {
                                ?>
                                <span class="text_readonly"> <?php echo set_value( $tmp_name, $travelitinerary_name_of_passenger[ $TMP_key ] );?></span>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="tableborderhide">
                              <?php
                                $tmp_name				= 'travelitinerary_age['. $TMP_key .']';
                                $arrayindex				= NumberHelper::number_array( range("1", "90") );
                                ksort($arrayindex);
                                
                                if ( $TMP_conf_reg_tabletab_details )
                                {
                                    echo form_dropdown( $tmp_name, 
                                                        $arrayindex, 
                                                        set_value($tmp_name, $travelitinerary_age[ $TMP_key ]), 
                                                        "class='form-control ". set_class( $tmp_name ) ." '" );
                                }
                                
                                
                                if (  $TMP_text_readonly )
                                {
                                ?>
                                <span class="text_readonly"> <?php echo set_value($tmp_name, $travelitinerary_age[ $TMP_key ]);?></span>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="tableborderhide">
                              <?php
                                $tmp_name		= 'travelitinerary_airline['. $TMP_key .']';
                                
                                if ( $TMP_conf_reg_tabletab_details )
                                {
                                    $specdata		= array("name"			=> $tmp_name,
                                                            "id"			=> $tmp_name,
                                                            
                                                            "type"			=> "text",
                                                            "class"			=> set_class( $tmp_name ),
                                                            "value"			=> set_value( $tmp_name, $travelitinerary_airline[ $TMP_key ] ),
                                                            "placeholder"	=> "Airline");	
                                
                                    echo form_input($specdata);
                                }
                                
                                
                                if (  $TMP_text_readonly )
                                {
                                ?>
                                <span class="text_readonly"> <?php echo set_value( $tmp_name, $travelitinerary_airline[ $TMP_key ] );?></span>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="tableborderhide">
                              <?php
                                $tmp_name		= 'travelitinerary_flightnumber['. $TMP_key .']';
                                
                                if ( $TMP_conf_reg_tabletab_details )
                                {
                                    $specdata		= array("name"			=> $tmp_name,
                                                            "id"			=> $tmp_name,
                                                            
                                                            "type"			=> "text",
                                                            "class"			=> set_class( $tmp_name ),
                                                            "value"			=> set_value( $tmp_name, $travelitinerary_flightnumber[ $TMP_key ] ),
                                                            "placeholder"	=> "Flight Number");	
                                
                                    echo form_input($specdata);
                                }
                                
                                if (  $TMP_text_readonly )
                                {
                                ?>
                                <span class="text_readonly"><?php echo set_value( $tmp_name, $travelitinerary_flightnumber[ $TMP_key ] );?></span>
                                <?php
                                }?>
                            </td>
                            <td class="tableborderhide">
                              <?php
                                $tmp_name		= 'travelitinerary_arrivaldaydate['. $TMP_key .']'; 
                                if ( $TMP_conf_reg_tabletab_details )
                                {
                                ?>
                                <div class="cal-container <?php echo set_class( $tmp_name );?>">
                                  <div class="cal-input">
                                    <?php
                                    $specdata		= array("name"			=> $tmp_name,
                                                            "id"			=> $tmp_name,
                                                            "type"			=> "text",
                                                            "class"			=> "datepicker ",
                                                            "value"			=> set_value( $tmp_name, $travelitinerary_arrivaldaydate[ $TMP_key ] ),
                                                            "placeholder"	=> "Arrival Day and Date");	
                                
                                    echo form_input($specdata);
                                    ?>
                                  </div>
                                  <div class="cal-btn"><a href="javascript:;"><img border="0" src="<?php echo base_url("assets/frontend/images/table-calander.png");?>" /></a></div>
                              </div>
                              <?php
                                }
                                
                                
                                if (  $TMP_text_readonly )
                                {
                                ?>
                                
                                <span class="text_readonly"><?php echo set_value( $tmp_name, $travelitinerary_arrivaldaydate[ $TMP_key ] );?></span>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="tableborderhide">
                              <?php
                                $tmp_name		= 'travelitinerary_localarrivaltime['. $TMP_key .']';
                                
                                if ( $TMP_conf_reg_tabletab_details )
                                {
                                    $specdata		= array("name"			=> $tmp_name,
                                                            "id"			=> $tmp_name,
                                                            
                                                            "type"			=> "text",
                                                            "class"			=> "timepicker " . set_class( $tmp_name ),
                                                            "value"			=> set_value( $tmp_name, $travelitinerary_localarrivaltime[ $TMP_key ] ),
                                                            "placeholder"	=> "Local Arrival Time");	
                                
                                    echo form_input($specdata);
                                }
                                
                                if (  $TMP_text_readonly )
                                {
                                ?>
                                
                                <span class="text_readonly"><?php echo set_value( $tmp_name, $travelitinerary_localarrivaltime[ $TMP_key ] );?></span>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="tableborderhide">&nbsp;</td>
                        </tr>
                    <?php
                        }
                    }
				}
                ?>
                
        </table>
        <p>&nbsp;</p>
        </div>
    <?php
	}
	?>
    
    
    
    
    <?php
	if ( $conference_accommodation_planner->num_rows() > 0 )
	{
	?>
        <div class="page_2">
            <h1>Accommodation Planner</h1>
            <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="1%" scope="col">&nbsp;</th>
              <th width="25%" align="left" scope="col">City</th>
              <th width="25%" align="left" scope="col">Dates / Day</th>
              <th width="48%" align="left" scope="col">Hotel Name / Address of Accommodation</th>
              <th width="1%" scope="col">&nbsp;</th>
            </tr>
            
            
            <?php
			foreach ($conference_accommodation_planner->result_array() as $ap)
			{
			?>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $ap['city'];?></td>
                    <td>
					<?php
					echo show_datefrom_dateto_format_date( $ap['date_from'], $ap['date_to'], TRUE, TRUE );
					
					echo '<br />';
					
					echo show_datefrom_dateto_format_day(  $ap['date_from'], $ap['date_to']);
					?>
                    </td>
                    
                    <td height="50">
                    
                    <?php
					if( $TMP_default_text )
					{
					?>
                    	<span class="default_text"><?php echo $ap['hotel_name_address'];?></span>
					<?php
					}
					?>
                    
                    
                    <?php
					if ( $TMP_page_2_input)
					{
						if ( $TMP_conf_reg_tabletab_details  )
						{
							$tmp_name		= 'accommodationplanner_hotelnameaddress['. $ap['id'] .']';
							$specdata		= array("name"			=> $tmp_name,
													"id"			=> $tmp_name,
													
													"type"			=> "text",
													"class"			=> set_class( $tmp_name ),
													"value"			=> set_value( $tmp_name, $accommodationplanner_hotelnameaddress[ $ap['id'] ] ),
													"placeholder"	=> "Hotel Name / Address of Accommodation");	
						
							echo form_input($specdata);
						}
					}
					
					if (  $TMP_text_readonly )
					{
					?>
                    
                    <span class="text_readonly"><?php echo set_value( $tmp_name, $accommodationplanner_hotelnameaddress[ $ap['id'] ] );?></span>
                    <?php
					}
					?>
                    </td>
                    <td>&nbsp;</td>
                </tr>
			<?php
			}
			?>
            
            
            </table>
            <p>&nbsp;</p>
        </div>
	<?php
	}
	?>



	<?php
	if ( $conference_local_chartered_flights->num_rows() > 0 )
	{
	?>
        <div id="page_3" class="page_3">
            <h1>Local Chartered Flights</h1>
            <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th width="1%" scope="col">&nbsp;</th>
                    <th width="17%" align="left" scope="col">From</th>
                  <th width="16%" align="left" scope="col">To</th>
                    <th width="17%" align="left" scope="col">Date / Day </th>
                    
                    
                    <?php
					if ( $TMP_hidethistr )
					{
					?>
               	  <th width="48%" align="left" class="hidethistr" scope="col">In case all family members are not accompanying, name and age of those will travel by air</th>
		      <?php
					}
					?>
                  <th width="1%" scope="col">&nbsp;</th>
                </tr>
                
                
                <?php
                foreach ($conference_local_chartered_flights->result_array() as $ap)
				{
					?>
                    	<tr>
                            <td>&nbsp;</td>
                            <td><?php echo $ap['from_city'];?></td>
                            <td><?php echo $ap['to_city'];?></td>
                            <td>
							<?php echo show_datefrom_dateto_format_date( $ap['this_date'], FALSE, TRUE, TRUE );?>,<br />
                            
                            <?php echo show_datefrom_dateto_format_day( $ap['this_date'] );?>,
                            <?php echo $ap['this_time'];?>
                            </td>
                            
                            
                            <?php
							if ( $TMP_hidethistr )
							{
							?>
                                <td height="50" class="hidethistr">
                                <?php
                                $tmp_name		= 'localcharteredflights_details['. $ap['id'] .']';
								
								if ( $TMP_conf_reg_tabletab_details )
								{
									$specdata		= array("name"			=> $tmp_name,
															"id"			=> $tmp_name,
															
															"type"			=> "text",
															"class"			=> set_class( $tmp_name ),
															"value"			=> set_value( $tmp_name, $localcharteredflights_details[ $ap['id'] ] ),
															"placeholder"	=> "Name & Age");	
								
									echo form_input($specdata);
								}
								
								if (  $TMP_text_readonly )
								{
                                ?>
                                
                                <span class="text_readonly"><?php echo set_value( $tmp_name, $localcharteredflights_details[ $ap['id'] ] );?></span>
                                <?php
								}
								?>
                                </td>
                            <?php
							}
							?>
                            <td>&nbsp;</td>
                        </tr>
                    <?php
				}
				?>
            </table>
            <p>&nbsp;</p>
        </div>
    <?php
	}
	?>
    
    
    
    <?php
	if ( $TMP_page_4 )
	{
	?>
		<div class="page_4">
        <h1><?php echo sprintf( lang_line("text_screen5_planningtostay"), date("jS F", strtotime(SessionHelper::_get_session("duration_to", "conference")) )) ;?></h1>
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <th width="1%" align="left" scope="col">&nbsp;</th>
            <th width="20%" align="left" scope="col">City</th>
            <th width="20%" align="left" scope="col">Dates / Day</th>
            <th width="29%" align="left" scope="col">Name of Hotel / Address of Accommodation </th>
            <th width="29%" align="left" scope="col">Name, address and phone number of friend / family member</th>
              <th width="1%" align="left" scope="col">&nbsp;</th>
          </tr>
            
            <?php
            foreach ($after_duration_date as $i => $value )
            {
            ?>
            <tr>
                <td>&nbsp;</td>
                <td valign="top">
                  <?php
                    $tmp_name		= 'afterduration_city['. $i .']';
                    
                    if ( $TMP_conf_reg_tabletab_details )
                    {
                        $specdata		= array("name"			=> $tmp_name,
                                                "id"			=> $tmp_name,
                                                
                                                "type"			=> "text",
                                                "class"			=> set_class( $tmp_name ),
                                                "value"			=> set_value( $tmp_name, $afterduration_city[ $i ] ),
                                                "placeholder"	=> "City");	
                    
                        echo form_input($specdata);
                    }
                    
                    if (  $TMP_text_readonly )
                    {
                    ?>
                    
                    <span class="text_readonly"><?php echo set_value( $tmp_name, $afterduration_city[ $i ] );?></span>
                    <?php
                    }
                    ?>
                </td>
                <td valign="top">
                  <?php
                    $tmp_name		= 'afterduration_datesday['. $i .']';
                    
                    if ( $TMP_conf_reg_tabletab_details )
                    {
                        $specdata		= array("name"			=> $tmp_name,
                                                "id"			=> $tmp_name,
                                                
                                                "type"			=> "text",
                                                "class"			=> "datepicker " . set_class( $tmp_name ),
                                                "value"			=> set_value( $tmp_name, $afterduration_datesday[ $i ] ),
                                                "placeholder"	=> "Dates / Day");	
                    
                        echo form_input($specdata);
                    }
                    
                    
                    if (  $TMP_text_readonly )
                    {
                    ?>
                    
                    <span class="text_readonly"><?php echo set_value( $tmp_name, $afterduration_datesday[ $i ] );?></span>
                    <?php
                    }
                    ?>
                </td>
                <td height="80">
                  <?php
                    $tmp_name		= 'afterduration_hotelnameaddress['. $i .']';
                    if ( $TMP_conf_reg_tabletab_details )
                    {
                        
                        $specdata		= array("name"			=> $tmp_name,
                                                "id"			=> $tmp_name,
                                                "style"			=> "min-height:0px;",
                                                "rows"			=> "4",
                                                "class"			=> set_class( $tmp_name ),
                                                "value"			=> set_value( $tmp_name, $afterduration_hotelnameaddress[ $i ] ),
                                                "placeholder"	=> "Hotel Name / Address");	
                    
                        echo form_textarea($specdata);
                    }
                    
                    
                    if (  $TMP_text_readonly )
                    {
                    ?>
                    
                    <span class="text_readonly"><?php echo set_value( $tmp_name, $afterduration_hotelnameaddress[ $i ] );?></span>
                    <?php
                    }
                    ?>
                </td>
                <td height="80">
                  <?php
                    $tmp_name		= 'afterduration_frienddetails['. $i .']';
                    if ( $TMP_conf_reg_tabletab_details )
                    {
                        
                        $specdata		= array("name"			=> $tmp_name,
                                                "id"			=> $tmp_name,
                                                
                                                "style"			=> "min-height:0px;",
                                                "rows"			=> "4",
                                                "class"			=> set_class( $tmp_name ),
                                                "value"			=> set_value( $tmp_name, $afterduration_frienddetails[ $i ] ),
                                                "placeholder"	=> "Name, address & phone of friend");	
                    
                        echo form_textarea($specdata);
                    }
                    
                    
                    if (  $TMP_text_readonly )
                    {
                    ?>
                    
                    <span class="text_readonly"><?php echo set_value( $tmp_name, $afterduration_frienddetails[ $i ] );?></span>
                    <?php
                    }
                    ?>
                </td>
                <td>&nbsp;</td>
            </tr>
          <?php
            }
            ?>
        </table>
    <p>&nbsp;</p>
    </div>
    <?php
	}
	?>
    
    
    
    <?php
	if ( $TMP_page_5 )
	{
	?>
<div class="page_5">
        <h1>Departure from <?php echo SessionHelper::_get_session("departure_from", "conference");?></h1>
    <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <th width="1%" align="left" class="tableborderhide">&nbsp;</th>
        <th width="24%" align="left" class="tableborderhide">Name of Passenger</th>
        <th width="24%" align="left" class="tableborderhide">Airline</th>
        <th width="12%" align="left" class="tableborderhide">Flight Number</th>
        <th width="23%" align="left" class="tableborderhide">Arrival Day and Date</th>
        <th width="13%" align="left" class="tableborderhide">Local Arrival Time </th>
          <th width="1%" align="left" class="tableborderhide">&nbsp;</th>
      </tr>
        
        
      <?php
		$TMP_key					= 0;
		if ( $conferenceregistration_screenthree -> num_rows() > 0 )
		{
		?>
		<tr>
			<td class="tableborderhide">&nbsp;</td>
			<td class="tableborderhide">
			  <?php
				$tmp_name		= 'departure_name_of_passenger['. $TMP_key .']';
				
				if ( $TMP_conf_reg_tabletab_details )
				{
					$specdata		= array("name"			=> $tmp_name,
											"id"			=> $tmp_name,
											
											"type"			=> "text",
											"class"			=> set_class( $tmp_name ),
											"value"			=> set_value( $tmp_name, $departure_name_of_passenger[ $TMP_key ] ),
											"placeholder"	=> "Name of Passenger");	
				
					echo form_input($specdata);
				}
				
				if (  $TMP_text_readonly )
				{
				?>
                
              	<span class="text_readonly"><?php echo set_value( $tmp_name, $departure_name_of_passenger[ $TMP_key ] );?></span>
                <?php
				}
				?>
		    </td>
				
			<td class="tableborderhide">
			  <?php
				$tmp_name		= 'departure_airline['. $TMP_key .']';
				
				if ( $TMP_conf_reg_tabletab_details )
				{
					$specdata		= array("name"			=> $tmp_name,
											"id"			=> $tmp_name,
											
											"type"			=> "text",
											"class"			=> set_class( $tmp_name ),
											"value"			=> set_value( $tmp_name, $departure_airline[ $TMP_key ] ),
											"placeholder"	=> "Airline");	
				
					echo form_input($specdata);
				}
				
				if (  $TMP_text_readonly )
				{
				?>
                
              	<span class="text_readonly"><?php echo set_value( $tmp_name, $departure_airline[ $TMP_key ] );?></span>
                <?php
				}
				?>
		    </td>
			<td class="tableborderhide">
			  <?php
				$tmp_name		= 'departure_flightnumber['. $TMP_key .']';
				
				if ( $TMP_conf_reg_tabletab_details )
				{
					$specdata		= array("name"			=> $tmp_name,
											"id"			=> $tmp_name,
											
											"type"			=> "text",
											"class"			=> set_class( $tmp_name ),
											"value"			=> set_value( $tmp_name, $departure_flightnumber[ $TMP_key ] ),
											"placeholder"	=> "Flight Number");	
				
					echo form_input($specdata);
				}
				
				
				if (  $TMP_text_readonly )
				{
				?>
                
              	<span class="text_readonly"><?php echo set_value( $tmp_name, $departure_flightnumber[ $TMP_key ] );?></span>
                <?php
				}
				?>
		    </td>
			<td class="tableborderhide">
                
              <?php
				$tmp_name		= 'departure_departuredaydate['. $TMP_key .']'; 
				if ( $TMP_conf_reg_tabletab_details )
				{
				?>
				<div class="cal-container <?php echo set_class( $tmp_name );?>">
				  <div class="cal-input">
					<?php
					$specdata		= array("name"			=> $tmp_name,
											"id"			=> $tmp_name,
											"type"			=> "text",
											"class"			=> "datepicker ",
											"value"			=> set_value( $tmp_name, $departure_departuredaydate[ $TMP_key ] ),
											"placeholder"	=> "Day and Date");	
				
					echo form_input($specdata);
					?>
				  </div>
				  <div class="cal-btn"><a href="javascript:;"><img border="0" src="<?php echo base_url("assets/frontend/images/table-calander.png");?>" /></a></div>
			  </div>
              <?php
				}
				
				if (  $TMP_text_readonly )
				{
				?>
                
              	<span class="text_readonly"><?php echo set_value( $tmp_name, $departure_departuredaydate[ $TMP_key ] );?></span>
                <?php
				}
				?>
		    </td>
			<td class="tableborderhide">
			  <?php
				$tmp_name		= 'departure_localdeparturetime['. $TMP_key .']';
				
				if ( $TMP_conf_reg_tabletab_details )
				{
					$specdata		= array("name"			=> $tmp_name,
											"id"			=> $tmp_name,
											
											"type"			=> "text",
											"class"			=> "timepicker " . set_class( $tmp_name ),
											"value"			=> set_value( $tmp_name, $departure_localdeparturetime[ $TMP_key ] ),
											"placeholder"	=> "Time");	
				
					echo form_input($specdata);
				}
				
				if (  $TMP_text_readonly )
				{
				?>
                
              	<span class="text_readonly"><?php echo set_value( $tmp_name, $departure_localdeparturetime[ $TMP_key ] );?></span>
                <?php
				}
				?>
		    </td>
			<td class="tableborderhide">&nbsp;</td>
	    </tr>
	  <?php
		}
		
		
		if ( $TMP_conf_reg_tabletab_details )
		{
			if ( $family_records -> num_rows() > 0 )
			{
				?>
                <tr bgcolor="#efefef" class="tr_applyforsame">
                <td class="tableborderhide" colspan="8" align="center" height="25">
                  Accompanying Family Members 
                  <a href="javascript:;" onclick="applysameforall('.page_5')">Apply same for all</a>
                </td>
            </tr>
                <?php
				foreach ( $family_records -> result_array() as $fr)
				{
					$TMP_key++;
				?>
                    <tr>
                          <td class="tableborderhide">&nbsp;</td>
                          <td class="tableborderhide">
                            <?php
                            $tmp_name		= 'departure_name_of_passenger['. $TMP_key .']';
                            
                            if ( $TMP_conf_reg_tabletab_details )
                            {
                                $specdata		= array("name"			=> $tmp_name,
                                                        "id"			=> $tmp_name,
                                                        
                                                        "type"			=> "text",
                                                        "class"			=> set_class( $tmp_name ),
                                                        "value"			=> set_value( $tmp_name, $departure_name_of_passenger[ $TMP_key ] ),
                                                        "placeholder"	=> "Name of Passenger");	
                            
                                echo form_input($specdata);
                            }
                            
                            if (  $TMP_text_readonly )
                            {
                            ?>
                            
                            <span class="text_readonly"><?php echo set_value( $tmp_name, $departure_name_of_passenger[ $TMP_key ] );?></span>
                            <?php
                            }
                            ?>
                          </td>
                            
                          <td class="tableborderhide">
                            <?php
                            $tmp_name		= 'departure_airline['. $TMP_key .']';
                            if ( $TMP_conf_reg_tabletab_details )
                            {
                                $specdata		= array("name"			=> $tmp_name,
                                                        "id"			=> $tmp_name,
                                                        
                                                        "type"			=> "text",
                                                        "class"			=> set_class( $tmp_name ),
                                                        "value"			=> set_value( $tmp_name, $departure_airline[ $TMP_key ] ),
                                                        "placeholder"	=> "Airline");	
                            
                                echo form_input($specdata);
                            }
                            
                            if (  $TMP_text_readonly )
                            {
                            ?>
                            
                            <span class="text_readonly"><?php echo set_value( $tmp_name, $departure_airline[ $TMP_key ] );?></span>
                            <?php
                            }
                            ?>
                          </td>
                          <td class="tableborderhide">
                            <?php
                            $tmp_name		= 'departure_flightnumber['. $TMP_key .']';
                            if ( $TMP_conf_reg_tabletab_details )
                            {
                                $specdata		= array("name"			=> $tmp_name,
                                                        "id"			=> $tmp_name,
                                                        
                                                        "type"			=> "text",
                                                        "class"			=> set_class( $tmp_name ),
                                                        "value"			=> set_value( $tmp_name, $departure_flightnumber[ $TMP_key ] ),
                                                        "placeholder"	=> "Flight Number");	
                            
                                echo form_input($specdata);
                            }
                            
                            if (  $TMP_text_readonly )
                            {
                            ?>
                            
                            <span class="text_readonly"><?php echo set_value( $tmp_name, $departure_flightnumber[ $TMP_key ] );?></span>
                            <?php
                            }
                            ?>
                          </td>
                          <td class="tableborderhide">
                            <?php
                            $tmp_name		= 'departure_departuredaydate['. $TMP_key .']';
                            if ( $TMP_conf_reg_tabletab_details )
                            {
                            ?>
                              <div class="cal-container <?php echo set_class( $tmp_name );?>">
                                <div class="cal-input">
                                <?php
                                $specdata		= array("name"			=> $tmp_name,
                                                        "id"			=> $tmp_name,
                                                        "type"			=> "text",
                                                        "class"			=> "datepicker ",
                                                        "value"			=> set_value( $tmp_name, $departure_departuredaydate[ $TMP_key ] ),
                                                        "placeholder"	=> "Day and Date");	
                            
                                echo form_input($specdata);
                                ?>
                                </div>
                                <div class="cal-btn"><a href="javascript:;"><img border="0" src="<?php echo base_url("assets/frontend/images/table-calander.png");?>" /></a></div>
                            </div>
                            <?php
                            }
                            
                            if (  $TMP_text_readonly )
                            {
                            ?>
                            <span class="text_readonly"><?php echo set_value( $tmp_name, $departure_departuredaydate[ $TMP_key ] );?></span>
                            <?php
                            }
                            ?>
                          </td>
                          <td class="tableborderhide">
                            <?php
                            $tmp_name		= 'departure_localdeparturetime['. $TMP_key .']';
                            if ( $TMP_conf_reg_tabletab_details )
                            {
                                $specdata		= array("name"			=> $tmp_name,
                                                        "id"			=> $tmp_name,
                                                        
                                                        "type"			=> "text",
                                                        "class"			=> "timepicker " . set_class( $tmp_name ),
                                                        "value"			=> set_value( $tmp_name, $departure_localdeparturetime[ $TMP_key ] ),
                                                        "placeholder"	=> "Time");	
                            
                                echo form_input($specdata);
                            }
                            
                            if (  $TMP_text_readonly )
                            {
                            ?>
                            
                            <span class="text_readonly"><?php echo set_value( $tmp_name, $departure_localdeparturetime[ $TMP_key ] );?></span>
                            <?php
                            }
                            ?>
                          </td>
                          <td class="tableborderhide">&nbsp;</td>
                    </tr>
				<?php
				}
			}
		
		}
		?>
        
        
    </table>
    <p>&nbsp;</p>
    </div>
    <?php
	}
	?>
    
    

<?php 
if ( $important_content )
{
	echo $important_content->row("content");
}



if ( $conference_regions )
{
	if ( !$conference_regions->row("allow_payment") )
	{
		echo $conference_regions->row("paymentdescription_conference");	
	}
}
?>

</div>