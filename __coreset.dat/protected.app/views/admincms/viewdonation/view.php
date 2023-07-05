<a href="<?php echo site_url( $_directory . "controls/exportpaypal" );?>" class="btn btn-primary" style="margin-bottom:15px;">Export Paypal Csv</a>
<a href="<?php echo site_url( $_directory . "controls/exportpayeezy" );?>" class="btn btn-primary" style="margin-bottom:15px;">Export Payeezy Csv</a>
<form method="POST" action="<?php echo site_url( $_directory . "controls/bulk_receipt_zip" );?>" class="bulk-receipt-download-form">
    <div class="input-group bulk-receipt-fields">
        <div class="bulk-date-field">
            <label>From Date</label>
            <input type="date" name="bulk_receipt_from_date" class="form-control">
        </div>
        <div class="bulk-date-field">
            <label>To Date</label>
            <input type="date" name="bulk_receipt_to_date" class="form-control">
        </div>
        <div class="bulk-date-download">
            <input type="submit" name="bulk_receipt_zip" class="btn btn-primary" value="Download Bulk Receipt Zip">
        </div>
    </div>
</form>
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
            <!--     <th style="width:10px" ><?php echo lang_line("text_option");?></th>-->
             </tr>
        </thead>
        
        <tbody>
            <?php
            $admindata = $admindata -> result_array();
            $get_role_id 		=  $this->functions->_admincms_logged_in_details( "roleid" ); 
            $get_belongsto 		= $this->functions->_admincms_logged_in_details( "belongs_country" );
            foreach ( $table_record -> result_array() as $key => $row )
            {
                // echo '<pre>';
                // print_r($row);
                // echo '</pre>';
                // die;
                if($get_role_id != 1 && $get_role_id != 4){ // check if admin or super admin
                    $explode = explode(',',$get_belongsto);
                    
                    if(!in_array($row['belongs_country'],$explode)){
                       continue;
                    }
                }
               //$donationProject_id=$row['donation_projects_id'];
               //$project=$this->queries->fetch_records("get_donation_projectname", " AND id='".$donationProject_id."' ORDER BY id desc ")->result()[0];
               //$reference=$this->queries->fetch_records("get_donation_refkey", " AND table_id_value ='".$row['id']."' AND table_name = 'tb_donation_form' ORDER BY dp.id desc ")->result()[0];
                ?>
                    <tr>
                        <td><?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>
                        <td><?php echo $row["name"];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['payment_mode'];//$row["emp_name"];?></td>
                        <td><?php echo $row['ref_id'];//$row["emp_email"];?></td>
                        <td><?php echo $row["donation_mode"] ;?></td>
                        <td><?php echo $row["donation_freq"];?></td>
                         
                        <td><?php echo $row["dpdesc"];//$project->name;//$row["donate_type"] ;?>
                        <?php
                                // SELECT comment FROM tb_df_dp_comments WHERE df_id = 8747 AND dp_id = 47
                                if( !empty($row["id"]) && !empty($row["dpid"]) ) {
                                    $usercomment = $this->db->query("select comment from tb_df_dp_comments where df_id = ".$row["id"]." and dp_id = ".$row["dpid"]);
                                    if($usercomment->row()->comment !== "" && $usercomment->row()->comment !== NULL) echo "(" . $usercomment->row()->comment . ")";
                                }
                                ?>
                        </td>
                        <td><?php echo $row["sehm"];?></td>
                        <!---<td><?php //echo $row["marjaa"];?></td>-->
                        <td><?php echo $row["is_syed"];?></td>
                        <td><?php echo $row["donate_amount"];?></td>
                        <td><?php echo $row['status'];?></td>
                        <td><?php  echo $row['Date']; ?></td>
                        <!-- <td><?php  // echo (trim($row['home_full_address']) ? ($row['home_full_address'] . ", ") : "") . (trim($row['home_city']) ? ($row['home_city'] . ", ") : "") . $row['home_state_province']; ?></td> -->
                        <td><?php  echo (trim($row['home_full_address']) ); ?></td>
                        <!-- <td><?php // echo $row['cellphone_number']; ?></td>
                        <td><?php // echo $row["comments"] ;?></td> -->
                        <td><?php echo $row["donation_mode"] == "recurring" ? $row['num_of_recurring'] : 'N/A';?></td>
                        <td><?php echo $row["donation_mode"] == "recurring" ? $row['last_recurring_payment'] : 'N/A';?></td>
                        <td><?php echo $row["donation_mode"] == "recurring" ? ($row['cancelled'] == 0 ? '<a onclick="return checkIt()" href="'.site_url( $_directory . "controls/cancel_recurring/" . $row["id"] ).'">Cancel Recurring</a>' : 'Cancelled') : 'Non-Recurring';?></td>
                        <td><?php echo $row["donation_mode"] == "recurring" ? ($row['cancelled'] == 1 ? $row['cancel_date'] : 'N/A') : 'N/A';?></td>
                        <td><?php echo $row["donation_mode"] == "recurring" ? ($row['cancelled'] == 1 ? $admindata[array_search($row['cancel_by'], array_column($admindata, 'id'))]['username'] : 'N/A') : 'N/A';?></td>
                        <td>
                        <?php
                                if(  (!empty($row["receipt_number"] && $row["receipt_number"] != NULL)) ) {
                                    echo $row["receipt_prefix"].$row["receipt_number"];
                                } else {
                                    echo "N/A";
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                            // $row["belongs_country"] == '2' &&
                            if(  (!empty($row["tax_receipt_num"] && $row["tax_receipt_num"] != NULL)) ||  (!empty($row["receipt_number"] && $row["receipt_number"] != NULL))) { ?>
                                <a class="btn btn-success btn-sm" href="<?php echo site_url( $_directory . "controls/receipt/" . $row["id"])?>" data-operationid="viewdonationtaxreceipt">Download</a>
                            <?php } else { ?>
                                N/A
                            <?php } ?>
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
 echo "Record not found";   
}
?>

     <div class="crud_controls">
    	<?php echo form_input( array("name" => "options", "type" => "hidden", "value" => "delete" ) )?>
        <!-- <a href="<?php echo site_url( $_directory . "controls/add" );?>" data-operationid="viewdonationadd">
        	<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="<?php echo lang_line("text_add");?>"  />
        </a>
         --><input data-operation="delete" data-operationid="viewdonationdelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete");?>" />
         
      <!-- <a href="javascript:;" data-operationid="viewdonationupdatesorting">
        	<input data-operation="ajax_update_sorting" type="button" class="btn btn-primary btn-flat submit_btn_form" value="<?php echo lang_line("text_update_sort");?>"  />
        </a>  -->
   </div>
   <div>
   <?php if($total_record['total'] > 1000){
       for($i =1; $i<=ceil($total_record['total']/1000); $i++){
           if($pageno == $i){
               echo "page $i &nbsp;";
           } else {?>
            <a href="<?php echo site_url( $_directory . "controls/view/0/0/".$i );?>">page <?php echo $i; ?></a>&nbsp;&nbsp;&nbsp;
       <?php
           }
       }
   }?>
   </div>
</form>
<script>
function checkIt(){
    return confirm('Do you want to remove this payment recurring option?');
}
</script>
    
