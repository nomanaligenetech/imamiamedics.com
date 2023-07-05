<?php
~r(debug_backtrace());
if ( ($_messageBundle['_TEXT_show_messages'] != '') and ($_messageBundle['_ALERT_mode'] == "") )
{
	$TMP_where				= explode("_", $_messageBundle['_CSS_show_messages']);
	$is_big					= FALSE;
	if ( is_array($TMP_where) )
	{
		if ( count($TMP_where) > 1 )
		{
			$is_big												= TRUE;
			#$_messageBundle['_CSS_show_messages']				= $TMP_where[0];
		}
	}
	
	
	if ( $is_big ) 
	{
		?>
			<div class="error_style">
                <div class="alert alert-<?=$_messageBundle['_CSS_show_messages'];?>">
                    <h1><?=$_messageBundle['_HEADING_show_messages'];?></h1> 
                    
                    <?=$_messageBundle['_TEXT_show_messages'];?>
                </div>
            </div>

        <?php
	}
	else
	{
		?>
            <div class="error_style">
                <div class="alert alert-<?=$_messageBundle['_CSS_show_messages'];?>">
                    <strong><?=$_messageBundle['_HEADING_show_messages'];?></strong> 
                    
                    <?=$_messageBundle['_TEXT_show_messages'];?>
                </div>
            </div>
        <?php
	}
?>


	


	<?php
	if (  1!=1 )
	{
	?>
        <div class="error_style_1 alert <?=$_messageBundle['_CSS_show_messages'];?>_messages_style">
             <p class="messageheading"><?=$_messageBundle['_HEADING_show_messages'];?></p>
             <?=$_messageBundle['_TEXT_show_messages'];?>
        </div>
	<?php
	}
}
else if ($this->session->flashdata('_flash_data_inline') and $this->session->flashdata('_flash_messages_content') != "")
{
?>
	<div class="error_style">
        <div class="alert alert-<?=$this->session->flashdata('_flash_messages_type');?>">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong><?=$this->session->flashdata('_flash_messages_title');?></strong> <?=$this->session->flashdata('_flash_messages_content');?>
        </div>
    </div>

	<!--<div class="alert <?php$this->session->flashdata('_flash_messages_type');?>_messages_style">
         <h5><strong><?php$this->session->flashdata('_flash_messages_title');?></strong></h5>
         <?php$this->session->flashdata('_flash_messages_content');?>
      </div>        -->
    
<?php
}
?>	