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
                        <td><?php echo $row["conference_name"];?></td>
                        <td>
						<?php 
						$_details				= abstractform_reviews( $row['id'] );
						$_tmp_status			= FALSE;
						
						if ( count($_details) > 0 )
						{
							$_tmp_status		= $_details['abs']['_status_approved'];
						}
						$tmp_dd					= DropdownHelper::abstractfinalstatus_dropdown();
						echo $tmp_dd[ $_tmp_status ];
						?>
                        </td>
                        
                        <td>
						<?php 
						if ( $this->functions->is_paid_by_cash( $row ) )
						{
							echo 'By Cash <small>(not received by IMI representative)</small>';
						}
						else
						{
							echo $row["paid_name"];	
						}
						?>
                        </td>
                        
                        
                        <td><?php echo DropdownHelper::abstracttype_dropdown(TRUE, $row["type"]);?></td>
                        <td>
                        <?php
						if ( !$row['is_paid']  and !$this->functions->is_paid_by_cash( $row ))
						{
						?>
                            <a href="<?php echo site_url("conference/". SessionHelper::_get_session("slug", "conference") ."/abstract_submission_form/". $row['type'] ."/" . $row['id'] );?>" target="_blank">
                                <input type="button" class="btn btn-success btn-sm" value="Edit"  />
                            </a>
                        <?php
						}
						else
						{
						?>
                            <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>">
                                <input type="button" class="btn btn-success btn-sm" value="View"  />
                            </a>
                        <?php
						}
						?>
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
    
