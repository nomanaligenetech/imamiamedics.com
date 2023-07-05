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
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row['id']) );?></td>
                        <td><?php echo $row["cat_type_name"];?></td>
                        <td><?php echo $row["cat_name"];?></td>
                        <td><?php echo $row["slug"];?></td>
                        <td><?php echo form_input( array("name" => "sorting[". $row['id'] ."]", "type" => "text", "size" => "3", "value" => $row['sort'] ) )?></td>
                       
                         <td>
                         <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>" data-operationid="managecategoryedit">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_edit");?>"  />
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
    
}
?>

    <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="managecategoryadd">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" data-operationid="managecategorydelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
        
        
        <a href="javascript:;">
        	<input data-operation="ajax_update_sorting" data-operationid="managecategoryupdatesorting" type="button" class="btn btn-primary btn-flat submit_btn_form" value="<?php echo lang_line("text_update_sort");?>"  />
        </a>
    </div>

</form>
    
