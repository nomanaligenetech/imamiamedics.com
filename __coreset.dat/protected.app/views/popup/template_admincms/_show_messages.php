<style>
.error_style{ font-size:14px;}
.error_style .close {
    color: #000;
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    opacity: 0.2;
    text-shadow: 0 1px 0 #fff;
}
.error_style .close:hover, .error_style .close:focus {
    color: #000;
    cursor: pointer;
    opacity: 0.5;
    text-decoration: none;
}
.error_style button.close {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 0 none;
    cursor: pointer;
    padding: 0;
}
.error_style .alert {
    border: 1px solid transparent;
    border-radius: 4px;
    margin-bottom: 20px;
    padding: 15px;
}
.error_style  .alert h4 {
    color: inherit;
    margin-top: 0;
}
.error_style .alert .alert-link {
    font-weight: 700;
}
.error_style .alert > p, .error_style .alert > ul {
    margin-bottom: 0;
}
.error_style .alert > p + p {
    margin-top: 5px;
}
.error_style .alert-dismissable, .error_style .alert-dismissible {
    padding-right: 35px;
}
.error_style .alert-dismissable .close, .error_style .alert-dismissible .close {
    color: inherit;
    position: relative;
    right: -21px;
    top: -2px;
}
.error_style .alert-success {
    background-color: #dff0d8;
    border-color: #d6e9c6;
    color: #3c763d;
}
.error_style .alert-success hr {
    border-top-color: #c9e2b3;
}
.error_style .alert-success .alert-link {
    color: #2b542c;
}
.error_style .alert-info {
    background-color: #d9edf7;
    border-color: #bce8f1;
    color: #31708f;
}
.error_style .alert-info hr {
    border-top-color: #a6e1ec;
}
.error_style .alert-info .alert-link {
    color: #245269;
}
.error_style .alert-warning {
    background-color: #fcf8e3;
    border-color: #faebcc;
    color: #8a6d3b;
}
.error_style .alert-warning hr {
    border-top-color: #f7e1b5;
}
.error_style .alert-warning .alert-link {
    color: #66512c;
}
.error_style .alert-danger {
    background-color: #FFDFDF;
    border-color: #ebccd1;
    color: #a94442;
}
.error_style .alert-danger hr {
    border-top-color: #e4b9c0;
}
.error_style .alert-danger .alert-link {
    color: #843534;
}



.error_style .alert-special {
    background-color: #cffff5;
    border-color: #b9ecce;
    color: #000; /*#a94442;*/
}
.error_style .alert-special hr {
    border-top-color: #b9ecce;
}
.error_style .alert-special .alert-link {
    color: #843534;
}

</style>
<?php
if ( ($_messageBundle['_TEXT_show_messages'] != '') and ($_messageBundle['_ALERT_mode'] == "") )
{
?>
	<div class="error_style">
        <div class="alert alert-<?=$_messageBundle['_CSS_show_messages'];?>">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong><?=$_messageBundle['_HEADING_show_messages'];?></strong> <?=$_messageBundle['_TEXT_show_messages'];?>
        </div>
    </div>


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