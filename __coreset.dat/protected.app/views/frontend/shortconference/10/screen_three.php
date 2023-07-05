<style>
.error_style{ display:none;}
.inline_error_style .error_style{ display:block;}
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
}
?>


<table cellpadding="2" cellspacing="5" width="100%" class="semiform tableform" >
	<tbody>
        <tr>
            <td colspan="2">
            	<h2><?php echo lang_line('text_primaryregistrant');?></h2>
            </td>
        </tr>
    </tbody>
</table>



<?php $this->load->view("frontend/conference/10/include_screen_three.php");?>
            
            
<div class="flt-rgt">
	<input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
	<input type="submit" name="proceedfurther" value="<?php echo lang_line('text_saveandproceed');?>" class="bluebuttons">
</div>

<?php
echo form_close();
?>