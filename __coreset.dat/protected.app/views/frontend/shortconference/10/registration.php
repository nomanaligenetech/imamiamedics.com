<div class="conf-reg-page-top pak_top-content">
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











<style>
.conference-table-10 td:hover{ background-color:#CCCCCC;  }
.conference-table-10 td.active{ background-color:#933;  }
</style>


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
    
    	<div class="conf-reg-page-content2  participant_section">
        	
            <div width="100%" class="conference-table-10">
            	<div class="pak_region-select-row">
                	<div class="pak_region-select-col">
                    	<div class="pak_region-select-img pak_region-pakistan">
                            <img src="<?php echo base_url("assets/frontend/images/10/pakistan-icon.png");?>" class="img-circle" />
                        </div>    
						<div class="pak_region-select-content">
                            <?php 
                            echo form_radio( "participanttypeid", $key_local, set_checkbox("participanttypeid", $key_local, format_bool( set_value("participanttypeid"), $key_local ) ));?>    
                            <h2> <?php echo lang_line("text_alocalparticipant"); ?></h2>               
                            <p class="disactive desc"><?php echo lang_line("text_alocalparticipant_desc");?></p>
                        </div>
                    </div>
                    
                    <div class="pak_region-select-col">
                        <div class="pak_region-select-img pak_region-international">
                    	    <img src="<?php echo base_url("assets/frontend/images/10/international-icon.png");?>" class="img-circle" />
                        </div>   
                        <div class="pak_region-select-content"> 
                            <?php 
                            echo form_radio("participanttypeid", $key_international, set_checkbox("participanttypeid", $key_international, format_bool( set_value("participanttypeid"), $key_international ) ));?>
                            <h2> <?php echo lang_line("text_aninternationalparticipant"); ?></h2>  
                            <p class="disactive  desc"><?php echo lang_line('text_aninternationalparticipant_desc');?></p> 
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="conf-reg-page-content2-label" style="display:none;">
			<label class="selectregion"><?php echo lang_line('text_plsselectregion');?></label>
			<?php echo form_dropdown("regionid", DropdownHelper::conferenceregions_dropdown( TRUE, FALSE, TRUE ), set_value("regionid"), "class='form-control ". set_class("regionid") ."'" );?>
			</div>
            
            
            <div class="flt-rgt" style="display:none;"><input class="bluebuttons" type="submit" value="Continue" /></div>
        </div>
        <script>
            $(document).ready(function(){
                $('input[name=participanttypeid]').click(function() {
                    $('.pak_region-select-col').removeClass('pak_region-active');
	                $(this).parents('.pak_region-select-col').addClass('pak_region-active');
                });
                $('input[name=participanttypeid]').hover(function() {
	                $(this).parents('.pak_region-select-col').toggleClass('pak_region-hover');
                });
            });
        </script>
        
        
        
		
		
		
	<?php
	echo form_close();

}
?>