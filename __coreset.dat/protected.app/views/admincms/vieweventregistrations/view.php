<a href="<?php echo site_url( $_directory . "controls/exporteventregistrations" );?>" class="btn btn-primary" style="margin-bottom:15px;">Export Csv</a>
<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( $table_record -> num_rows() > 0 )
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
             </tr>
        </thead>
        
        <tbody>
            <?php
            $admindata = $admindata -> result_array();
            $get_role_id 		=  $this->functions->_admincms_logged_in_details( "roleid" ); 
            $get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
            
            foreach ( $table_record -> result_array() as $key => $row )
            {
                if($get_role_id != 1 && $get_role_id != 4){ // check if admin or super admin
                    $explode = explode(',',$get_belongsto);
                    
                    if( !in_array($row['belongsto'], $explode) ){
                        continue;
                    }
                }
               ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>
                        <td><?php echo $row["donate_name"];?></td>
                        <td><?php echo $row['donate_email'];?></td>
                        <td><?php echo $row['title'];?></td>
                        <td><?php echo $row['payment_mode'];?></td>
                        <td><?php echo $row['package_title'];//$row["emp_email"];?></td>
                        <td><?php echo DropdownHelper::yesno_dropdown($row["is_paid"]) ;?></td>
                        <td><?php echo $row["package_amount"];?></td>
                        <td><?php echo $row["donate_amount"];?></td>
                        <td><?php echo $row['donate_phone']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
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
 echo "Registrations not found";   
}
?>

     <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <input data-operation="delete" data-operationid="vieweventregistrationsdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
   </div>
   <div>
   </div>
</form>
    
