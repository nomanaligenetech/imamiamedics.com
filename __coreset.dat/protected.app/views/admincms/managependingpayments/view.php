<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);
?>

<div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
</div>

<?php
if ( count($table_record) > 0 )
{
	echo $this->load->view( "admincms/managependingpayments/include_view_table" );
}
else
{
    
}
?>

    

</form>
    
