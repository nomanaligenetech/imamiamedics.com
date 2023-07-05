<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( count($table_record) > 0 )
{
    ?>
    
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
                <th style="width:10px" ><?php echo lang_line("text_option");?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach ( $table_record  as $key => $row )
            {
                if(isset($row['id'])){
                ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>
                        <td><?php echo $row["package_title"];?></td>
                        <td><?php echo $row["available_seats"];?></td>
                        <td><?php echo $row["amount"];?></td>
                        <td><?php echo $row["status"];?></td>
                        <td>
                            <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>" data-operationid="manageeventpackagesedit">
                                <input type="button" class="btn btn-info btn-xs" value="<?php echo lang_line("text_edit");?>"  />
                            </a>
                        </td>
                    </tr>
                <?php
               } 
            }
            ?>
        </tbody>
    </table>
    <?php
}
else
{
    echo 'No Records Found';
}
?>
 <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="manageeventpackagesadd">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" data-operationid="manageeventpackagesdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
        
    </div>

</form>