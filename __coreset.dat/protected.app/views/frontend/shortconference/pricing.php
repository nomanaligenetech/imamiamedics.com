<div class="conf-reg-page-top">
    <h1><?php echo lang_line('text_conferenceregistration');?></h1>
    <p><?php echo conference_fullname( $conference );?></p>
    <span><?php echo conference_durationdates( $conference );?> </span>
</div>





<?php
#if conf. registration is EXPIRED...
if (  $this->validations->is_conference_registration_expired( FALSE ) )
{
	$expired_content		= $this->mixed_queries->fetch_records('conference_content_with_menu', " AND m.slug = 'conference-registration-closed' AND m.conferenceid = '". $conference->row("id") ."' ");
	
	if ( $expired_content -> num_rows() > 0 )
	{
		echo $expired_content->row("content");	
	}
}
?>




<?php
if ( $conference_regions->num_rows() > 0 )
{
?>
    <div class="conf-reg-page-content"> 
        <?php echo $this->functions->content_shortcodes( $conference_regions->row("description") );?>
    </div>
<?php
}
?>





<?php
#if conf. registration is not expired
if ( ! $this->validations->is_conference_registration_expired( FALSE ))
{
?>
	<p>&nbsp;</p>
    
    <div class="int-part-tab <?php echo (@SessionHelper::_get_session("regionid", "conferenceregistration")=="16")?" iraqian_table":""?>">
        <div class="int-part-lefttab">
            <h1>Discounted Early<br />Bird Registration <span>*</span></h1>
        
            <div class="rightdatesection"> 
                <span class="datebefore"><img src="<?php echo base_url("assets/frontend/images/date-before.png");?>" /></span>
                <div class="greendate"> (By <?php echo $registration_beforedate;?>) </div>
                <span class="dateafter"><img src="<?php echo base_url("assets/frontend/images/date-after.png");?>" /></span> 
            </div>
            
            <p>&nbsp;</p>
            <?php
            if ( count($prices_chart['others']['earlybird_price']) > 0 )
            {
            ?>
                <div class="gradiansection">
                    <div class="gradianshadow"> Conference Registration ONLY : </div>
                    <?php
                    foreach ( $prices_chart['others']['earlybird_price'] as $k => $p )
                    {
                        ?>
                            <p><?php echo $p['whoattend_name'];?>: <?php echo $p['pricedisplay'];?></p>
                        <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            
            <div class="gradiansection">
                <div class="gradianshadow"> Conference Registration Package with Accommodations & Local Travel </div>
            </div>
            
            <div class="reg-table">
                <div class="table-row">
                    <div class="row1-col"> &nbsp; </div>
                    <div class="row1-col2"> &nbsp; </div>
                    <div class="row1-col3"> <?php $first_key			= 1; echo $confreg_paymenttype_dropdown[ $first_key ];?> </div>
                    <div class="row1-col4"> &nbsp; </div>
                    <div class="row1-col5"> <?php $second_key			= 2; echo $confreg_paymenttype_dropdown[ $second_key ];?> </div>
                </div>
                
                <div class="table-rowtop">
                    <div class="row1-col"> &nbsp; </div>
                    <div class="row1-col2"> &nbsp; </div>
                    <div class="row1-col3"> &nbsp; </div>
                    <div class="row1-col4"> &nbsp; </div>
                    <div class="row1-col5"> &nbsp; </div>
                </div>
                
                <?php
                if ( count($prices_chart['members']['all']) > 0 )
                {
                    
                    foreach ( $prices_chart['members']['all'] as $k => $p )
                    {
                        ?>
                            <div class="table-row3">
                                <div class="row1-col"> <?php echo $p[  $first_key  ]['whoattend_name'];?> </div>
                                <div class="row1-col2"> &nbsp; </div>
                                <div class="row1-col3"> <?php echo $p[  $first_key  ]['earlybird_pricedisplay'];?> </div>
                                <div class="row1-col4"> &nbsp; </div>
                                <div class="row1-col5"> <?php echo $p[  $second_key  ]['earlybird_pricedisplay'];?> </div>
                            </div>
                            
                            <div class="table-row4">
                                <div class="row1-col"> &nbsp; </div>
                                <div class="row1-col2"> &nbsp; </div>
                                <div class="row1-col3"> &nbsp; </div>
                                <div class="row1-col4"> &nbsp; </div>
                                <div class="row1-col5"> &nbsp; </div>
                            </div>
                        <?php
    
                    }
                }
                ?>
    
                <div class="table-rowbottom">
                    <div class="row1-col"> &nbsp; </div>
                    <div class="row1-col2"> &nbsp; </div>
                    <div class="row1-col3"> &nbsp; </div>
                    <div class="row1-col4"> &nbsp; </div>
                    <div class="row1-col5"> &nbsp; </div>
                </div>
                
            </div>
        </div>
        
        <div class="int-part-lefttab int-part-righttab">
            <h1>General<br />Registration </h1>
            
            <div class="rightdatesection"> 
                <span class="datebefore"><img src="<?php echo base_url("assets/frontend/images/date-before.png");?>" /></span>
                <div class="greendate"> (<?php echo conference_registrationdates( $conference, TRUE );?> ) </div>
                <span class="dateafter"><img src="<?php echo base_url("assets/frontend/images/date-after.png");?>" /></span> 
            </div>
            
            <p>&nbsp;</p>
            <?php
            if ( count($prices_chart['others']['regular_price']) > 0 )
            {
            ?>
                <div class="gradiansection">
                    <div class="gradianshadow"> Conference Registration ONLY : </div>
                    <?php
                    foreach ( $prices_chart['others']['regular_price'] as $k => $p )
                    {
                        ?>
                            <p><?php echo $p['whoattend_name'];?>: <?php echo $p['pricedisplay'];?></p>
                        <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            
            
            <div class="gradiansection">
                <div class="gradianshadow"> Conference Registration Package with Accommodations &amp; Local Travel </div>
            </div>
            
            
            <div class="reg-table">
                <div class="table-row">
                    <div class="row1-col"> &nbsp; </div>
                    <div class="row1-col2"> &nbsp; </div>
                    <div class="row1-col3"> Non Members </div>
                    <div class="row1-col4"> &nbsp; </div>
                    <div class="row1-col5"> <?php echo lang_line('ajax_update_regions_text_' . is_medicsinternational(TRUE));?> Members </div>
                </div>
                
                <div class="table-rowtop">
                    <div class="row1-col"> &nbsp; </div>
                    <div class="row1-col2"> &nbsp; </div>
                    <div class="row1-col3"> &nbsp; </div>
                    <div class="row1-col4"> &nbsp; </div>
                    <div class="row1-col5"> &nbsp; </div>
                </div>
                
                <?php
                if ( count($prices_chart['members']['all']) > 0 )
                {
                    
                    foreach ( $prices_chart['members']['all'] as $k => $p )
                    {
                        ?>
                            <div class="table-row3">
                                <div class="row1-col"> <?php echo $p[  $first_key  ]['whoattend_name'];?> </div>
                                <div class="row1-col2"> &nbsp; </div>
                                <div class="row1-col3"> <?php echo $p[  $first_key  ]['regular_pricedisplay'];?> </div>
                                <div class="row1-col4"> &nbsp; </div>
                                <div class="row1-col5"> <?php echo $p[  $second_key  ]['regular_pricedisplay'];?> </div>
                            </div>
                            
                            <div class="table-row4">
                                <div class="row1-col"> &nbsp; </div>
                                <div class="row1-col2"> &nbsp; </div>
                                <div class="row1-col3"> &nbsp; </div>
                                <div class="row1-col4"> &nbsp; </div>
                                <div class="row1-col5"> &nbsp; </div>
                            </div>
                        <?php
    
                    }
                }
                ?>
                
                <div class="table-rowbottom">
                    <div class="row1-col"> &nbsp; </div>
                    <div class="row1-col2"> &nbsp; </div>
                    <div class="row1-col3"> &nbsp; </div>
                    <div class="row1-col4"> &nbsp; </div>
                    <div class="row1-col5"> &nbsp; </div>
                </div>
                
            </div>
        </div>
    </div>
    <br />
    <br />
    
    
    <div class="registercontent">
        <?php
        echo $conference_regions->row("onsite_note");
        ?>
        
        
        
    </div>
    
    
    <div class="alng-mid">
        <a href="<?php echo site_url( "conference/" . $conference->row("slug") . "/registration/screen/1" );?>" style="text-decoration:none">
            <input class="bluebuttons" type="button" value="To register for the <?php echo conference_fullname( $conference );?>, please click here" />
        </a>
    </div>
<?php
}
?>