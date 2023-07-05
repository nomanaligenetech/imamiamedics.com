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
                        <td><?php echo $row["countries_name"];?></td>
                        <td><?php echo $row["countries_iso_code_2"];?></td>
                        <td><?php echo $row["countries_iso_code_3"];?></td>
                        <td><?php echo $row["paypal_email"];?></td>
                        <td>
                            <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>" data-operationid="managecountriesedit">
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
</form>