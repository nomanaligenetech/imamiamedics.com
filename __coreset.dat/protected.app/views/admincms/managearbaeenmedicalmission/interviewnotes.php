<?php 

if (count($table_record) > 0) {
    $attributes 			= array("method"		=> "post",
                                "enctype"		=> "multipart/form-data");

    $row  = $table_record->row();

    echo form_open(site_url($_directory . "controls/interviewnotes/".$row->id), $attributes);
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
            <tr>
                <td>Recommend ? <span class="required">*</span> </td>
                <td>
                    <div class="form-group">
                        <div class="input-group">
                            <select name="interview_recommendation" value="" class="form-control" >
                                <option value="no">No</option>
                                <option value="yes">Yes</option>  
                            </select>
                        </div>
                    </div>
                    <div class="error"><?php echo form_error('interview_recommendation');?></div>
                </td>
            </tr>
            <tr>
                <td>Interview Notes: <span class="required">*</span> </td>
                <td>
                    <textarea name="interview_notes" rows="5" class="form-control ckeditor1"></textarea>
                    <div class="error"><?php echo form_error('interview_notes');?></div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="crud_controls">
        <a href="javascript:;" data-operationid="managearbaeenmedicalmissioninterviewnotes">
            <input data-operation="interviewnotes" type="submit" class="btn btn-primary btn-flat submit_btn_form" name="submit" value="Submit"  />
        </a>
    </div>
<?php
echo form_close();
}