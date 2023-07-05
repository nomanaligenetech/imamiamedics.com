<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( $table_record -> num_rows() > 0 )
{
    ?>
    
    <table id="tbl_records" class="table table-bordered table-striped bFilter bLengthChange bPaginate">
        <thead>
            <tr>
            
                <!--<th style="width:0px" ><?php #echo form_checkbox( array("name" => "select_all", "class" => "flat-red") );?></th>-->
                <?php
                foreach ($table_properties["tr_heading"] as $trheading)
                {
                    ?>
                        
                        <th><?php echo $trheading;?></th>
                        
                    <?php	
                }
                ?>
                <th style="width:100px" ><?php echo lang_line("text_option");?></th>
            </tr>
        </thead>
        
        <tbody>
        
        
            <?php
            foreach ( $table_record -> result_array() as $key => $row )
            { 
                
                ?>
                    <tr>
                        <!--<td><?php #echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>-->
                        <td><?php echo $row["title"];?></td>
                        <td style="width: 110px;"><?php echo date('M, j Y',strtotime($row["date_added"]));?></td>
                        <td style="width: 110px;"><?php echo date('M, j Y',strtotime($row["date_updated"]));?></td>
                        <td style="color:<?php echo $row["event"] == "Interested" ? "#1aa579" : ($row["event"] == "Going" ? "#fbb126" : ($row["event"] == "Not Going" ? "" : "#ff0000")); ?>"><?php echo $row["event"]; ?></td>
                        <td>
                            <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>">
                                <input type="button" class="btn btn-success btn-sm" value="Change Status"  />
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
else
{
	$data["_messageBundle"]				= $_messageBundle2;
	
    $this->load->view('frontend/template/_show_messages.php', $data);
}
?>

    <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        
    </div>

</form>
    
