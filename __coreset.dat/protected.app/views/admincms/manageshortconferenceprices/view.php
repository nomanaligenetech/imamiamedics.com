<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( $table_record -> num_rows() > 0 )
{
    ?>
    <style>
	td.details-control {
		background: url('<?php echo base_url('assets/admincms/img/details_open.png');?>') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('<?php echo base_url('assets/admincms/img/details_close.png');?>') no-repeat center center;
	}
	
	.table-dark {
	  color: $table-dark-color;
	  background-color: $table-dark-bg;
	
	  th,
	  td,
	  thead th {
		border-color: $table-dark-border-color;
	  }
	
	  &.table-bordered {
		border: 0;
	  }
	
	  &.table-striped {
		tbody tr:nth-of-type(odd) {
		  background-color: $table-dark-accent-bg;
		}
	  }
	
	  &.table-hover {
		tbody tr {
		  @include hover {
			color: $table-dark-hover-color;
			background-color: $table-dark-hover-bg;
		  }
		}
	  }
}
	</style>
    

    
    <table id="tbl_records" class="table table-bordered table-striped">
        <thead>
            <tr>
            
                <th style="width:10px" ><?php echo form_checkbox( array("name" => "select_all", "class" => "flat-red") );?></th>
                <th style="width:20px"  ></th>
                
                <th style="display:none;"  ></th>
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
            foreach ( $table_record -> result_array() as $key => $row )
            {
 
              $addon_add_class = $row['is_addon'] == 1 ? "details-control" : '';
                ?>
                    <tr>
                        
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>

                        <td class="<?php echo $addon_add_class;?>" ></td>
                        
                        <td class="tmp_ID" style="display:none;"><?php echo $row["id"];?></td>
                        
                        
                        <td><?php echo $row["conference_name"];?></td>
                        <td><?php echo $row["title"];?></td>
                        <td><?php echo $row["whoattend_name"];?></td>
                        <td><?php echo $row["region_name"];?></td>
                        <td><?php echo $row["paymenttype_key"];?></td>
                        <td>
                        <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>">
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
        <a href="<?php echo site_url( $_directory . "controls/add" );?>">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
        
        

    </div>

</form>
    
