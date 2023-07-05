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
                <th style="width:10px" ><?php echo lang_line("text_option");?></th>
            </tr>
        </thead>
        
        <tbody>
            <?php
             $get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
             $get_role_id 		=  $this->functions->_admincms_logged_in_details( "roleid" ); 
            foreach ( $table_record -> result_array() as $key => $row )
            {

                if($get_role_id != 1 && $get_role_id != 4){ // check if admin or super admin
                
                    $explode = explode(',',$get_belongsto);
                    if(!in_array($row['belongsto'],$explode)){
                        continue;
                    }
                }
                
                ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>
                        <td><?php echo $row["menu_name"];?></td>
                        <td>
						<?php 
						$widgets			= $this->queries->fetch_records("cmscontent_widgets", " AND parentid = '". $row['id'] ."' AND is_mode = 'left' ");
						if ( $widgets->num_rows() > 0 )
						{
							?>
                            <ul>
								<?php
                                foreach ($widgets->result_array() as $r)
                                {
									?>
									<li><?php echo left_widgets(  $r["widget_id"] );?></li>
									<?php
                                }
                                ?>
                            </ul>
                            <?php
							
						}
						?>
                        </td>
                        
                        <td>
						<?php 
						$widgets			= $this->queries->fetch_records("cmscontent_widgets", " AND parentid = '". $row['id'] ."' AND is_mode = 'right' ");
						if ( $widgets->num_rows() > 0 )
						{
							?>
                            <ul>
								<?php
                                foreach ($widgets->result_array() as $r)
                                {
									?>
									<li><?php echo right_widgets(  $r["widget_id"] );?></li>
									<?php
                                }
                                ?>
                            </ul>
                            <?php
							
						}
						?>
                        </td>
                        
                        
                        
                        <td>
						<?php 
						$widgets			= $this->queries->fetch_records("cmscontent_widgets", " AND parentid = '". $row['id'] ."' AND is_mode = 'center' ");
						if ( $widgets->num_rows() > 0 )
						{
							?>
                            <ul>
								<?php
                                foreach ($widgets->result_array() as $r)
                                {
									?>
									<li><?php echo center_widgets(  $r["widget_id"] );?></li>
									<?php
                                }
                                ?>
                            </ul>
                            <?php
							
						}
						?>
                        </td>
                        
                        <td><?php echo DropdownHelper::cmsmenubelongsto_dropdown(false, $row["belongsto"]);?></td>
                        <td><?php echo getUserNameByID($row["added_by"]);?></td>
                        <td>
                        <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>" data-operationid="managecmscontentedit">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_edit");?>"  />
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
    
}
?>

    <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="managecmscontentadd">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" data-operationid="managecmscontentdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
    </div>

</form>
    
