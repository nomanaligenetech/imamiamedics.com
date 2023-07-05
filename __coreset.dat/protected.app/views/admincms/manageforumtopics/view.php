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
             
             $admin="";
             $user="";
             if($row['created_by_admin']!=null){
               $admin=$this->queries->fetch_records("getAdmin","AND id='".$row['created_by_admin']."'")->result()[0];
              }else if($row['created_by_user']!=null){
                     $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$row['created_by_user']."' ORDER BY id desc ")->result()[0]; 
              }
             $forum=$this->queries->fetch_records("forums","AND id='".$row['frmid']."'")->result()[0];

            /* echo "<pre>";
             print_r($forum->name); die();*/

               if(isset($row['id'])){

                ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row['id']) );?></td>
                        <td><?php echo $row["name"];?></td>
                        <td><?php echo $forum->name;?></td>
                        <td><?php echo $row["slug"];?></td>
                        <td><?php echo $row["date"];?></td>
                        <td><?php if($admin!="") echo $admin->username; else if($user!="")echo $user->name.' '.$user->last_name;?></td>
                        <td>
                        <?php echo $row["total_posts"];?>
                        <a href="<?php echo site_url($_postdir . "controls/view/" . $row["id"]);?>" data-operationid="managepostsview">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo "Posts";?>"/>
                        </a>
                        
                        </td>

                        <td>
                        <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>" data-operationid="manageforumtopicsedit">
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
        <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="manageforumtopicsadd">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
        <input data-operation="delete" data-operationid="manageforumtopicsdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
        
    </div>

</form>
    
