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

<p class="align_center m_bottom25" ><strong>Note</strong> : In case of technical support, please reach out to <a href="mailto:neelam.raheel@genetechsolutions.com">neelam.raheel@genetechsolutions.com</a> or send whastapp message +92-3002522862. Live help with immediate assistance via WhatsApp is available from <strong>8:00 pm CST - 1:00 pm CST</strong>.</p>


<table cellpadding="2" cellspacing="5" width="100%" class="semiform tableform" >
	<tbody>
        <tr>
            <td colspan="2">
            	<h2><?php echo lang_line('text_primaryregistrant');?></h2>
            </td>
        </tr>
    </tbody>
</table>



<?php $this->load->view("frontend/conference/9/include_screen_three.php");?>
            
            
<div class="flt-rgt">
	<input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
	<input type="submit" name="proceedfurther" value="<?php echo lang_line('text_saveandproceed');?>" class="bluebuttons">
</div>

<?php
echo form_close();
?>