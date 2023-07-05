<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( $table_record -> num_rows() > 0 )
{
    ?>
    <table id="tbl_records" class="table table-bordered table-striped" style="width:100%;">
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
            foreach ($table_record->result_array() as $key => $row) {

                ?>
                    <tr>
                        <td><?php echo form_checkbox(array("name" => "checkbox_options[]", "value" => $row["id"])); ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["code"]; ?></td>
                        <td><?php echo $row["direction"]; ?></td>
                        <td>
                        <a href="<?php echo site_url($_directory . "controls/edit/" . $row["id"]); ?>" data-operationid="managelanguagesedit">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_edit"); ?>"  />
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
}
?>
<div class="crud_controls">
        <?php echo form_input(array("name" => "options", "type" => "hidden", "value" => "delete")) ?>
        <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="managelanguagesadd">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" data-operationid="managelanguagesdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete"); ?>" />
    </div>
<?php
echo form_close();
?>