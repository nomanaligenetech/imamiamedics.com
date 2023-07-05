<style>
.error_style{ display:none;}
.inline_error_style .error_style{ display:block;}
.conf-reg-tabletab select{ padding:5px;}
</style>
<div class="conf-reg-page-top">
    <h1><?php echo lang_line('text_conferenceregistration');?></h1>
    <p><?php echo conference_fullname( $conference );?></p>
    <span><?php echo conference_durationdates( $conference );?> </span>
</div>


 
        
<?php $this->load->view("frontend/template/_confregistrationbreadcrumbs.php");?>

<p>&nbsp;</p>



<?php
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data",
								"name"			=> "form1",
								"id"			=> "form1");

echo form_open(site_url( uri_string() ), $attributes);




$data["_messageBundle"]				= $_messageBundle2;
?>
<div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $data); ?> </div>





<?php
$_Combine_Notes															= "";
if ( $country_notes->num_rows() > 0 )
{
	
	if ( $country_notes->row()->note_2 != "" )
	{
		$TMP_message["_messageBundle"]["_ALERT_mode"]					= "";
		$TMP_message["_messageBundle"]["_TEXT_show_messages"]			= $country_notes->row()->note_2;
		$TMP_message["_messageBundle"]["_CSS_show_messages"]			= "danger";
					
		?>
		<div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $TMP_message); ?> </div>
		<?php
	}
	
	
	
	if ( $country_notes->row()->note_1 != "" )
	{
		$_Combine_Notes													.= $country_notes->row()->note_1 . '<br />';
	}
}


if ( $conference_regions )
{
	if ( $conference_regions->row("step5_note1")  != "" )
	{
		$_Combine_Notes													.= $conference_regions->row("step5_note1");
	}
}


if ( $_Combine_Notes != "" )
{
	$TMP_message["_messageBundle"]["_ALERT_mode"]					= "";
	$TMP_message["_messageBundle"]["_TEXT_show_messages"]			= $_Combine_Notes;
	$TMP_message["_messageBundle"]["_CSS_show_messages"]			= "info";
				
	?>
	<div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $TMP_message); ?> </div>
	<?php
}
?>





<?php $this->load->view("frontend/shortconference/10/include_screen_two.php");?>

<p>&nbsp;</p>

<p>&nbsp;</p>



<?php $this->load->view("frontend/shortconference/10/include_participant_UID.php");?>





<?php $this->load->view("frontend/shortconference/10/include_screen_five.php");?>
            
            
            	
			
<div class="flt-rgt">
    <input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
    
   
    
    
    
    <?php
	if ( $SHOW_submit_button_screen_5 )
	{
		$_make_payment_button				= FALSE;
		if ( $conference_regions -> row("allow_payment") )
		{
			$_make_payment_button				= TRUE;			
		}
		
		
		if ( $country_notes->num_rows() > 0 )
		{
			if ( !$country_notes->row()->allow_payment_for_this_country )
			{
				$_make_payment_button		= FALSE;
			}
		}
		
		/*
		if ( $conferenceregistration_screenone -> row("travelling_with") == "independently" )
		{
			$_make_payment_button			= FALSE;
		}
		*/
		
		
		
		if ( !$_make_payment_button )
		{
			?>
				<input type="submit"	name="proceedfurther"		value="Finish"			class="bluebuttons flt-">
			<?php
		}
		else 
		{
		?>
			
			<input type="submit"	name="makepayment"			value="Make Payment"	class="blackbuttons flt-rgt" />
			
			<br />
			<small class="flt-rgt" style="font-style:italic; margin-top:5px;">
				You dont need a PayPal account to pay. You can also pay <br />by using your Debit or Credit Card. 
				<a href="<?php echo base_url( "assets/frontend/images/credit-card-not-paypal.gif" );?>" class="modelImage">Click here</a> to see how.
			</small>
		<?php	
		}
		
		
	}
	?>


</div>



<?php
echo form_close();
?>