<!--
template #1
<div class="alert alert-<?php $_messageBundle['_CSS_show_messages'];?> alert-dismissable">
    <i class="fa fa-check"></i>
    
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&Theta;</button>
    <b><?php  $_messageBundle['_HEADING_show_messages'];?></b> <?php  $_messageBundle['_TEXT_show_messages'];?>
    
</div>


template #2
<div class="callout callout-<?php  $_messageBundle['_CSS_show_messages'];?>">
    <h4><?php  $_messageBundle['_HEADING_show_messages'];?></h4>
    <?php  $_messageBundle['_TEXT_show_messages'];?>
</div>
-->




<?php

if ( ($_messageBundle['_TEXT_show_messages'] != '') and ($_messageBundle['_ALERT_mode'] == "") )
{
?>
	<div class="callout callout-<?php echo $_messageBundle['_CSS_show_messages'];?>">
        <h4><?php echo $_messageBundle['_HEADING_show_messages'];?></h4>
        <?php echo $_messageBundle['_TEXT_show_messages'];?>
    </div>
    
    
<?php
}
else if ($this->session->flashdata('_flash_data_inline') and $this->session->flashdata('_flash_messages_content') != "")
{
?>

	<div class="callout callout-<?php echo $this->session->flashdata('_flash_messages_type');?>">
        <h4><?php echo $this->session->flashdata('_flash_messages_title');?></h4>
        <?php echo $this->session->flashdata('_flash_messages_content');?>
    </div>

    
<?php
}
?>	