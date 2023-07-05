<?php
/**
 * @var CI_Loader $this
 */
//~r(debug_backtrace());
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
} else {
//    ~r($this->session->flashdata('_flash_messages_content') != "");
//    ~r($this->session->flashdata('_flash_data_inline'), $this->session->flashdata('_flash_messages_content') != "");
    if ($this->session->flashdata('_flash_data_inline') and $this->session->flashdata('_flash_messages_content') != "") {
        ?>
        <div class="error_style">
            <div class="alert alert-<?= $this->session->flashdata('_flash_messages_type'); ?>">
                <!-- <a href="javascript:;" class="close" data-dismiss="alert">&times;</a>-->
                <strong><?= $this->session->flashdata('_flash_messages_title'); ?></strong> <?= $this->session->flashdata('_flash_messages_content'); ?>
            </div>
        </div>

        <!--<div class="alert <?php
        $this->session->flashdata('_flash_messages_type'); ?>_messages_style">
         <h5><strong><?php $this->session->flashdata('_flash_messages_title');?></strong></h5>
         <?php $this->session->flashdata('_flash_messages_content');?>
      </div>        -->

        <?php
    }
}
?>

<script type="text/javascript">
    var is_event_thank_you = "<?php echo isset($_POST['is_event_success']) ? $_POST['is_event_success'] : ''; ?>";
    var is_donation_detail_thankyou = "<?php echo isset($return) ? $return : ''; ?>";
    var is_donation_thank_you = "<?php echo isset($is_donation_success) ? $is_donation_success : ''; ?>";
   
    if(is_event_thank_you == "yes" || is_donation_detail_thankyou == true || is_donation_thank_you == "yes"){
        $(window).load(function() {
            setTimeout(function () {
                window.location.href = "<?php echo site_url(); ?>";// the redirect goes here
            },10000); // 10 seconds
        });
    }
    
</script>
