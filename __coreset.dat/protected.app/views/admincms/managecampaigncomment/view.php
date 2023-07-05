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
                <th style="width:10px" ><?php echo lang_line("text_option");?></th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            $status = DropdownHelper::comments_status_dropdown();
            foreach ( $table_record -> result_array() as $key => $row )
            {
                
                ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>
                        <td><?php echo $row["comment"];?></td>
                        <td><?php echo $row["name"];?></td>
                        <td><?php echo $row["email"];?></td>
                        <td><?php echo $status[$row["status"]]['status'];?></td>
                        <td>
                        <?php foreach($status as $key => $singlestatus){
                            if($key != $row['status'] && $key != 0){?>
                                <a href="<?php echo site_url( $_directory . "controls/status/" . $row["id"]."/".$key);?>" data-operationid="managecmscontentedit">
                                    <input type="button" class="btn btn-success btn-sm <?php echo $singlestatus['class']; ?>" value="<?php echo $singlestatus['update'];?>"  />
                                </a>
                                &nbsp;
                            <?php
                            }
                        }?>
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
else
{
    
}
?>

    <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <input data-operation="delete" data-operationid="managecmscontentdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
    </div>

</form>