<a href="<?php echo site_url( $_directory . "controls/export")?>" class="btn btn-primary" style="margin-bottom:15px;">Export Members</a>
<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( $table_record -> num_rows() > 0 )
{
    ?>
    <table id="tbl_records_serverside" class="table table-bordered table-striped" style="width:100%;"
           data-tbl_records_serverside_additional_options-var="tbl_records_serverside_additional_options">
            <thead>
                <tr>

                   <th style="width:10px" ><?php echo form_checkbox( array("name" => "select_all", "class" => "flat-red") );?></th>
					<?php
                    foreach ($table_properties["tr_heading"] as $trheading)
                    {
                        ?>
                            
                            <th><?php echo $trheading;?></th>
                            
                        <?php	
                    }
                    ?>
                    <th style="width:10px" ><?php echo lang_line("text_option");?></th>
                    
                </tr>
            </thead>

            <!-- AJAX CONTENT HERE -->

            <tfoot>
            </tfoot>
        </table>
        
    <?php
	/*
    <table id="tbl_records1" class="table table-bordered table-striped" style="display:none;">
        <thead>
            <tr>
            
                <th style="width:10px" ><?php echo form_checkbox( array("name" => "select_all", "class" => "flat-red") );?></th>
                <?php
                foreach ($table_properties["tr_heading"] as $trheading)
                {
                    ?>
                        
                        <th><?php echo $trheading;?></th>
                        
                    <?php	
                }
                ?>
                <th style="width:10px" ><?php echo lang_line("text_option");?></th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            foreach ( $table_record -> result_array() as $key => $row )
            {
                
                ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>
                        <td><?php echo $row["name"];?></td>
                        <td><?php echo $row["last_name"];?></td>
                        <td><?php echo $row["email"];?></td>
                        <td><?php echo  $this->encrption->decrypt( $row["password"] );?></td>
                        <td><?php echo $row["registration_site"];?></td>
                        <td><?php echo $row["is_active_name"];?></td>
                        <td><?php echo date("d-m-Y", strtotime($row["date_added"]));?></td>
                        <td>
                        <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_edit");?>"  />
                        </a>
                        </td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <?php
	*/
}
?>

    <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="manageusersadd">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" data-operationid="manageusersdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
 
    </div>

<?php
echo form_close();
?>
<script>
    jQuery(function ($) {
        var $tblRecordsServerside = $('#tbl_records_serverside');
        var reloadData = function () {
            var dataTable = $tblRecordsServerside.DataTable();
            dataTable.clearPipeline();
            dataTable.ajax.reload(null, false);
        };
        $tblRecordsServerside.delegate('.member_status_toggle_link', 'click', function () {
            $.post(
                <?php echo json_encode(site_url($_directory . "controls/toggleMemberStatus")); ?>,
                {
                    "userId": $(this).data('user-id'),
                },
                reloadData
            );
        });
        $tblRecordsServerside.delegate('.member_blocking_status_toggle_link', 'click', function () {
            $.post(
                <?php echo json_encode(site_url($_directory . "controls/toggleMemberBlockingStatus")); ?>,
                {
                    "userId": $(this).data('user-id'),
                },
                reloadData
            );
        });
        $tblRecordsServerside.delegate('.paid_membership_status_change_link', 'click', function () {
            var $this = $(this);
            $.post(
                <?php echo json_encode(site_url($_directory . "controls/changePaidMembershipStatus")); ?>,
                {
                    "action": $this.data('action'),
                    "userId": $this.data('user-id'),
                },
                reloadData
            );
        });
    });
    var tbl_records_serverside_additional_options = {
        'columnDefs': [{
            'orderable': false,
            'aTargets': [
                7,11, // Make the "Paid Membership Status" column un-sortable (as it is computed in PHP and can't be correctly sorted in the SQL unless the computation is implemented within the DB).
            ],
        }],
    };
</script>
