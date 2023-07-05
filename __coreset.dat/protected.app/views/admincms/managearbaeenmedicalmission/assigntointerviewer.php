<?php 

if (count($table_record) > 0) {
    $attributes 			= array("method"		=> "post",
                                "enctype"		=> "multipart/form-data");

    $row  = $table_record->row();

    echo form_open(site_url($_directory . "controls/assigntointerviewer/".$row->id), $attributes);
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
                <td>Interviewer: <span class="required">*</span> </td>
                <td>
                    <select name="interviewer" class="form-control">
                        <?php 
                         if ( isset($interviewers) && !empty($interviewers) ){
                            foreach ($interviewers as $key => $interviewer) {
                               ?>
                                <option value="<?php echo $interviewer->id;?>"><?php echo $interviewer->email.' ( '.$interviewer->username.' ) ';?></option>
                               <?php
                            }
                        }?>
                    </select>
                </td>
                <div class="error"><?php echo form_error('interviewer');?></div></td>
            </tr>
        </tbody>
    </table>

    <div class="crud_controls">
        <a href="javascript:;" data-operationid="managearbaeenmedicalmissioninterinterview">
            <input data-operation="interview" type="submit" class="btn btn-primary btn-flat submit_btn_form" name="submit" value="Submit"  />
        </a>
    </div>
<?php
echo form_close();
}