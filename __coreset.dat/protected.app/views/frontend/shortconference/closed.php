<div style="background-color:#DF0000" class="conf-reg-page-top">
    <h1><?php echo lang_line('text_conferenceregistration');?></h1>
    <p><?php echo conference_fullname( $conference );?></p>
    <span><?php echo conference_durationdates( $conference );?> </span>
</div>


<?php
if ( $this->validations->is_conference_registration_expired() ) 
{
	$expired_content		= $this->mixed_queries->fetch_records('conference_content_with_menu', " AND m.slug = 'conference-registration-closed' AND m.conferenceid = '". $conference->row("id") ."' ");
	
	if ( $expired_content -> num_rows() > 0 )
	{
		echo $expired_content->row("content");	
	}
		
}
?>