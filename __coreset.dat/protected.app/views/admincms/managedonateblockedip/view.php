<?php 
$attributes 			= array("method"		=> "post");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( $table_record -> num_rows() > 0 )
{?>
    
    <table id="tbl_records" class="table table-bordered table-striped">
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
            </tr>
        </thead>
        
        <tbody>
            <?php
            foreach ( $table_record -> result_array() as $key => $row )
            {?>
                <tr>
                    <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>
                    <td><?php echo $row["ip_address"];?></td>
                    <td><?php echo $row["totalhits"];?></td>
                    <td><?php echo date("Y-m-d h:i a", $row["block_time"]);?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <?php
}
else
{
    
}
?>

    <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <input data-operation="delete" data-operationid="managedonateblockedip" type="button" class="btn btn-success btn-flat submit_btn_form" value="UnBlock" />
    </div>

</form>