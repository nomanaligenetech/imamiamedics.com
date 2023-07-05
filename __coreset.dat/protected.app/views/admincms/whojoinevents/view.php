<?php 
$attributes             = array("method"        => "post",
                                "enctype"       => "multipart/form-data");

echo form_open(site_url( $_directory . "controls/options" ), $attributes);

if ( count($table_record) > 0 )
{
    ?>
    
    <table id="tbl_records" class="table table-bordered table-striped">
        <thead>
            <tr>
            
                <th style="width:10px" ><?php echo form_checkbox( array("name" => "select_all", "class" => "flat-red") );?> </th>
                <?php
                foreach ($table_properties["tr_heading"] as $trheading)
                {
                    ?>
                        
                        <th><?php echo $trheading;?></th>
                    
                    <?php   
                }
                ?>
            <!--     <th style="width:10px" ><?php echo lang_line("text_option");?></th> -->
            </tr>
        </thead>
        
        <tbody>
            <?php
            foreach ( $table_record  -> result_array() as $key => $row )
            {
                if(isset($row['id'])){
                   
                    $eventdetail            = $this->queries->fetch_records('getEventDetail', " AND id = ".$row['eventid']."")->result()[0];
                  
                  //echo $row['userid']; die;
                    $profile                                  = $this->imiconf_queries->fetch_records_imiconf("users", " AND id = '".$row['userid']."'")->result()[0];  
                //  
              //   echo "<pre>";   
                // var_dump($profile); die;
                ?>
                       <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row['id']) );?></td>
                        <td><?php echo $profile->name;?></td>
                        <td><?php echo $profile->email;?></td>
                        <td><?php echo $eventdetail->title;?></td>
                        <td><?php echo date('Y-m-d',strtotime($eventdetail->start_date)).' To '.date('Y-m-d',strtotime($eventdetail->end_date));?></td>
                        <td><?php echo $row["date_added"];?></td>
                        <td style="color:<?php echo $row["event"] == "Interested" ? "#1aa579" : ($row["event"] == "Going" ? "#fbb126" : ($row["event"] == "Not Going" ? "" : "#ff0000"));?>"><?php echo $row["event"];?></td>
                       <!--  <td>
                        <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>" data-operationid="whojoineventsedit">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_edit");?>"  />
                        </a>
                      </td> -->
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
        <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="whojoineventsadd">
      <!--       <input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
 -->        </a>
        <input data-operation="delete" data-operationid="whojoineventsdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
        
    </div>

</form>
    
