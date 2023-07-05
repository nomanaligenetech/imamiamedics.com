<?php 

$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data",
								"style"			=> "font-size:12px;");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( count($table_record) > 0 )
{
	echo $this->load->view( "admincms/manageconferenceregistration/include_view_table" );
}
else
{
    
}
?>

    <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <!--<a href="<?php  site_url( $_directory . "controls/add" );?>">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php  lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php  lang_line("text_delete");?>" />-->
        
    </div>

</form>

<script>
$(document).ready(function(){

	$("#tbl_records tr").each(function(){
			
			$(this).find("td:eq(2)").hide();
			$(this).find("th:eq(2)").hide();
	});
	
});
</script>
    
