<form method="POST" action="<?php echo site_url( $_directory . "controls/bulk_all_reports_receipt_zip" );?>" class="bulk-receipt-download-form">
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

    <div class="crud_controls">
        <div>
            <strong>NOTE:</strong>
            <p>
                The table shows data for the past 'six' months. Click 'Get Latest Data' to fetch the latest payment records.
            </p>
        </div>
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <!--<a href="<?php  site_url( $_directory . "controls/add" );?>">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php  lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php  lang_line("text_delete");?>" />-->
        
        
        <a href="javascript:;">
        <input data-operation="ajax_download_csv" type="button" class="btn btn-primary btn-flat submit_btn_form" value="Download CSV" style="margin-bottom:15px;" />
        </a>
        <a href="javascript:;">
            <input data-operation="ajax_download_paypalcsv" type="button" class="btn btn-primary btn-flat submit_btn_form" value="Export Paypal CSV" style="margin-bottom:15px;" />
        </a>
        <a href="javascript:;">
            <input data-operation="ajax_download_payeezycsv" type="button" class="btn btn-primary btn-flat submit_btn_form" value="Export Payeezy CSV" style="margin-bottom:15px;" />
        </a>
        <a href="javascript:;">
        <input data-operation="ajax_get_data" type="button" class="btn btn-success btn-flat submit_btn_form" value="Get Latest Data" style="margin-bottom:15px;" />
        </a>
    </div>
    <?php
if ( count($table_record) > 0 )
{
	echo $this->load->view( "admincms/manageallreports/include_view_table" );
}
else
{
    
}
?>

</form>
    
