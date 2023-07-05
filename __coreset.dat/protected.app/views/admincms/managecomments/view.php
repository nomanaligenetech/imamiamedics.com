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
             foreach ( $table_record  ->result_array() as $key => $row )
            {
                 if(isset($row['id'])){

                ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row['id']) );?></td>
                        <td><?php echo $row["post"];?></td>
                        <td><?php echo $row["comment"];?></td>
                        <?php 
                        $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$row['user_id']."' ORDER BY id desc "); ?>
                        <td><?php foreach($user ->result_array() as $rec ) {  echo $rec["name"]." ".$rec['last_name']; }?></td>
                        <td><?php echo $row["date"];?></td>
                      
                     
                        <td>
                        <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>" data-operationid="managecommentsedit">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_edit");?>"  />
                        </a>
                        </td>
                    </tr>
                <?php
               } 
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
       
         <input data-operation="delete" data-operationid="managecommentsdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
       
    </div>

</form>
    
