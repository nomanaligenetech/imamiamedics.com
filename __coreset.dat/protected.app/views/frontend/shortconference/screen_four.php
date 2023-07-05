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
<input type="submit" name="proceedfurther" value="Submit" class="bluebuttons btnSubmit" style="display:none;"  >

<table cellpadding="2" cellspacing="5" width="100%" class="semiform tableform" >
    <tbody>
        <tr>
            <td colspan="2">
                <h2>Family Guest Information
                <?php 
				if ( $FAMILY_registration_number )
				{
					echo '(' . $FAMILY_registration_number . ')';
				}
				?>
                </h2>
            </td>
        </tr>
        
        

        <?php
		if ( $list_family_members -> num_rows() > 0 )
		{
		?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            
            <?php
			foreach ( $list_family_members->result_array() as $f)
			{
				$is_completed							= $this->queries->fetch_records('conference_registration_screen_three', 
																						" AND parentid  = '". $conferenceregistration_screenthree->row("id") ."' 
																						  AND screen_one_detail_id = '". $f['id'] ."' ");
				
			?>
                <tr>
                    <td colspan="2">
                    - <?php echo '<strong>'. $f['family_name'] . '</strong> (' . $f['family_email'] . ')';?>
                    
                    <?php
					if ( $is_completed -> num_rows() > 0 )
					{
						?>
                        	<img src="<?php echo base_url( "assets/frontend/images/icon-completed.png" );?>"  />
                        <?php	
					}
					?>
                    
                    <a style="text-decoration:none;" href="<?php echo site_url('conference/'. $conference->row("slug") .'/registration/screen/4/' . $f['id']);?>">
                    <strong>(update information)</strong>
                    </a>
                    
                    
                    
                    
                    
                    <input type="image"  
                    src="<?php echo base_url("assets/frontend/images/delete_icon.png");?>"  name="delete[<?php echo $f['id'];?>]" value="delete" />
                    </td>
                </tr>
			<?php
			}
			?>
            
            <tr>
                <td colspan="2" class="linespace"><hr /></td>
            </tr>
            <?php
		}
		else
		{
			$data["_messageBundle"]				= $_messageBundle2_nofamilyguest;
			?>
            	<tr>
                    <td><div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $data); ?> </div></td>
                </tr>
            <?php	
		}
		?>
    </tbody>
</table>

<?php
if ( $FAMILY_registration_number )
{
?>

    
    <?php $this->load->view("frontend/conference/include_screen_three.php");?>
    
                
                
    <div class="flt-rgt">
       
        <input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
        <input type="button" onclick="$('.btnSubmit').click();" value="<?php echo lang_line('text_saveandproceed');?>" class="bluebuttons"  >
	</div>

<?php
}
else
{
	?>
    <div class="flt-rgt">
        
        <a style="text-decoration:none;" href="<?php echo site_url( "conference/" . $conference->row("slug") . "/registration/screen/5" );?>">
        	<input type="button" name="proceedfurther" value="<?php echo lang_line('text_proceed');?>" class="bluebuttons">
        </a>
    </div>
    <?php	
}
echo form_close();
?>