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





<?php $this->load->view("frontend/shortconference/9/include_screen_two.php");?>

<p>&nbsp;</p>





<?php $this->load->view("frontend/shortconference/9/include_screen_five.php");?>
            
            
            	
			
<div class="flt-rgt">
    <input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
    
   
    
    
    
    <?php
	if ( $SHOW_submit_button_screen_5 )
	{
		if ( $conference_regions -> row("allow_payment") )
		{
			if ( $conferenceregistration_screenone -> row("travelling_with") == "independently" )
			{
				?>
					<input type="submit"	name="proceedfurther"		value="Save"			class="bluebuttons flt-rgt">
				<?php
			}
			?>
				
				<input type="submit"	name="makepayment"			value="Make Payment"	class="blackbuttons flt-rgt" />
				
				<br />
				<small class="flt-rgt" style="font-style:italic; margin-top:5px;">
					You dont need a PayPal account to pay. You can also pay <br />by using your Debit or Credit Card. 
					<a href="<?php echo base_url( "assets/frontend/images/credit-card-not-paypal.gif" );?>" class="modelImage">Click here</a> to see how.
				</small>
			<?php	
		}
		else
		{
			?>
				<input type="submit"	name="makepayment"			value="Save"	class="blackbuttons flt-rgt" />
			<?php	
		}
	}
	?>


</div>



<?php
echo form_close();
?>