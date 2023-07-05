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




<div class="conf-reg-page-content"> 
	<?php echo $this->functions->content_shortcodes( $content );?>
</div>














<?php
#if conf. registration is not expired
if ( ! $this->validations->is_conference_registration_expired( FALSE ) )
{
	

	?>
    
    <p>&nbsp;</p>
    
    <?php
	$attributes 			= array("method"		=> "post",
									"enctype"		=> "multipart/form-data",
									"name"			=> "form1");
	
	echo form_open(site_url( uri_string() ), $attributes);
	
	
	
	
	$data["_messageBundle"]				= $_messageBundle2;
	$this->load->view('frontend/template/_show_messages.php', $data);
	
	
	$key_local				= DropdownHelper::conferenceparticipants_dropdown(TRUE, 'local');
	$key_international		= DropdownHelper::conferenceparticipants_dropdown(TRUE, 'international');
	?>
		<div class="conf-reg-page-content2 participant_section  ">
			<h1 class="leftheading"><?php echo lang_line('text_areyou?');?></h1>
			
			<div class="conf-reg-page-content2-label">
				<label>
					<?php 
					echo form_radio( "participanttypeid", 
									 $key_local, 
									 set_checkbox("participanttypeid", $key_local, format_bool( set_value("participanttypeid"), $key_local ) ) 
									 );
					
					echo lang_line("text_alocalparticipant");
					?>
				</label>
				<br />
				
				<span class="disactive desc"><?php echo lang_line("text_alocalparticipant_desc");?></span> 
			</div>
			
			
			<div class="conf-reg-page-content2-label gray">
				<label>
					<?php 
					echo form_radio("participanttypeid", 
									$key_international, 
									set_checkbox("participanttypeid", $key_international, format_bool( set_value("participanttypeid"), $key_international ) )
									);
					
					echo lang_line("text_aninternationalparticipant");
					?>
				</label>
				<br />
				
				<span class="disactive  desc"><?php echo lang_line('text_aninternationalparticipant_desc');?></span> 
			</div>
			
			
			
			
			<div class="conf-reg-page-content2-label">
			<label class="selectregion"><?php echo lang_line('text_plsselectregion');?></label>
			<?php echo form_dropdown("regionid", DropdownHelper::conferenceregions_dropdown( FALSE, FALSE, TRUE ), set_value("regionid"), "class='form-control ". set_class("regionid") ."'" );?>
			</div>
			
		</div>
		
		<div class="flt-rgt"><input class="bluebuttons" type="submit" value="Continue" /></div>
	<?php
	echo form_close();

}
?>