<div>
    <p>
    <strong>NOTE:</strong> All the email addresses with domains <strong>*@yopmail.com</strong>, <strong>*@mailinator.com</strong>, amd <strong>*@genetechsolutions.com</strong> are test payments and may not be reflected under live Payeezy and PayPal.
    </p>
</div>
<form method="POST" action="<?php echo site_url( $_directory . "controls/bulk_short_conference_receipt_zip" );?>" class="bulk-receipt-download-form">
    <div class="input-group bulk-receipt-fields">
        <div class="bulk-date-field">
            <label>From Date</label>
            <input type="date" name="bulk_receipt_from_date" class="form-control">
        </div>
        <div class="bulk-date-field">
            <label>To Date</label>
            <input type="date" name="bulk_receipt_to_date" class="form-control">
        </div>
        <div class="bulk-date-download">
            <input type="submit" name="bulk_receipt_zip" class="btn btn-primary" value="Download Bulk Receipt Zip">
        </div>
    </div>
</form>

<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);
?>
<a href="javascript:;" style="display: inline-block; margin: 0px 0px 18px;">
    <input data-operation="ajax_download_csv" type="button" class="btn btn-primary btn-flat submit_btn_form" value="Download CSV"  />
</a>
<?php if ( count($table_record) > 0 )
{
	echo $this->load->view( "admincms/manageshortconferenceregistration/include_view_table" );
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
    
