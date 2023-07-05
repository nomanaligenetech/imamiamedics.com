<?php 
if (count($table_record) > 0) {
    $attributes 			= array("method"		=> "post",
                                "enctype"		=> "multipart/form-data");

    $row  = $table_record->row();

    echo form_open(site_url($_directory . "controls/reject/".$row->id), $attributes);
    ?>
    <table id="" class="table table-bordered table-striped arbaeen-medical-mission-table-view">
        <tbody>
            <tr>
                <td>Name</td>
                <td><?php echo $row->first_name.' '.$row->middle_name.' '.$row->last_name; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $row->email; ?></td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td><?php echo $row->phone_number; ?></td>
            </tr>
            <?php

            if ((bool)$row->interview_1_scheduled && (bool)$row->interview_2_scheduled) {
                //rejection 2
                
                ?>
                <input type="hidden" name="reject" value="2" />
                <h3>Rejection After Interview 2</h3>
                <tr>
                    <td>Rejection Notes: <span class="required">*</span> </td>
                    <td>
                        <textarea name="interview_2_rejected_notes" rows="5" class="form-control"></textarea>
                        <div class="error"><?php echo form_error('interview_2_rejected_notes');?></div>
                    </td>
                </tr>
                <?php
            } elseif ((bool)$row->interview_1_scheduled) {
                //rejection 1

                ?>
                <input type="hidden" name="reject" value="1" />
                <h3>Rejection After Interview 1</h3>
                <tr>
                    <td>Rejection Notes: <span class="required">*</span> </td>
                    <td>
                        <textarea name="interview_1_rejected_notes" rows="5" class="form-control"></textarea>
                        <div class="error"><?php echo form_error('interview_1_rejected_notes');?></div>
                    </td>
                </tr>
                <?php
            }else{
                //rejection 0
                ?>
                <input type="hidden" name="reject" value="0" />
                <h3>Rejection Without Interview</h3>
                <tr>
                    <td>Rejection Notes: <span class="required">*</span> </td>
                    <td>
                        <textarea name="rejected_notes" rows="5" class="form-control"></textarea>
                        <div class="error"><?php echo form_error('rejected_notes');?></div>
                    </td>
                </tr>
                <?php
            }?>
        </tbody>
    </table>

    <div class="crud_controls">
        <a href="javascript:;" data-operationid="managearbaeenmedicalmissioninterreject">
            <input data-operation="reject" type="submit" class="btn btn-danger btn-flat submit_btn_form" name="submit" value="Submit"  />
        </a>
    </div>
<?php
echo form_close();
}