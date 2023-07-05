<?php
$attributes             = array(
    "method"        => "post",
    "enctype"        => "multipart/form-data"
);

echo form_open(site_url($_directory . "controls/options"), $attributes);

if (count($table_record) > 0) {
    ?>
    <table id="tbl_records" class="table table-bordered table-striped arbaeen-medical-mission-table-view">
        <thead>
            <tr>
                <th style="width:10px"><?php echo form_checkbox(array("name" => "select_all", "class" => "flat-red")); ?></th>
                <?php
                foreach ($table_properties["tr_heading"] as $trheading) {
                    ?>
                    <th><?php echo $trheading; ?></th>
                <?php
                }
                ?>
                <th style="width:10px"><?php echo lang_line("text_option"); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($table_record  as $key => $row) {
                if (isset($row['id'])) {
                    ?>
                    <tr class="<?php echo $row["status"] ?>">
                        <td><?php echo form_checkbox(array("name" => "checkbox_options[]", "value" => $row['id'])); ?></td>
                        <td><?php echo $row["first_name"]; ?></td>
                        <td><?php echo $row["last_name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["phone_number"]; ?></td>
                        <td><?php echo $row["date_added"]; ?></td>
                        <td><?php echo $row['membership_details_package_name']; ?></td>
                        <td><a href="<?php echo site_url() . 'assets/fies/arbaeen-mission/' . $row['cv_resume']; ?>">Download</a></td>
                        <td><?php echo $row['interviewer_email'] != "" ? $row['interviewer_email'] . ' ( ' . $row['interviewer_username'] . ' ) ' : ''; ?></td>
                        <td><?php echo $row['interview_recommendation'] != "" ? '<b>Recommend? ' . ucfirst($row['interview_recommendation']) . '</b><br/><br/>' . $row['interview_notes'] : ''; ?></td>
                        <td><?php echo $row['status'] == 'reject' ? $row['rejected_notes'] : ''; ?></td>
                        <td>
                            <?php
                            switch ($row['status']) {
                                case 'pending':
                                    ?>
                                <input type="button" class="btn btn-warning btn-xs" value="Pending" />
                                <?php
                                break;

                            case 'waitlist':
                                ?>
                                <input type="button" class="btn btn-warning btn-xs" value="Waitlist" />
                                <?php
                                break;

                            case 'reject':
                                ?>
                                <a href="<?php echo site_url($_directory . "controls/pending/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissionpending"><input type="button" class="btn btn-danger btn-xs" value="Un-Reject" /></a></td>
                            <?php
                            break;

                        case 'approve':
                            ?>
                            <input type="button" class="btn btn-success btn-xs" value="Approved" />
                            <?php
                            break;

                        case 'assigntointerviewer':
                            ?>
                            <input type="button" class="btn btn-info btn-xs" value="Assigned To Interviewer" />
                            <?php
                            break;

                        case 'scheduleinterview':
                            ?>
                            <input type="button" class="btn btn-info btn-xs" value="Schedule Interview" />
                            <?php
                            break;

                        default:
                            break;
                    }
                    ?>
                        <td>
                            <a href="<?php echo site_url($_directory . "controls/view/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissionview">
                                <input type="button" class="btn btn-info btn-xs" value="<?php echo lang_line("text_view"); ?>" />
                            </a>
                            <?php if ($row['status'] != "reject") { ?>
                                <a href="<?php echo site_url($_directory . "controls/reject/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissionreject">
                                    <input type="button" class="btn btn-danger btn-xs" value="Reject" />
                                </a>
                            <?php } ?>
                            <?php if ($row['status'] != "approve") { ?>
                                <a href="<?php echo site_url($_directory . "controls/approve/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissionapprove">
                                    <input type="button" class="btn btn-success btn-xs" value="Approve" />
                                </a>
                            <?php } ?>
                            <?php if ($row['status'] != "waitlist") { ?>
                                <a href="<?php echo site_url($_directory . "controls/waitlist/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissionwaitlist">
                                    <input type="button" class="btn btn-warning btn-xs" value="Waitlist" />
                                </a>
                            <?php } ?>
                            <?php if ($row['status'] != "approve" && $row['status'] != "reject") { ?>
                                <a href="<?php echo site_url($_directory . "controls/assigntointerviewer/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissionassigntointerviewer">
                                    <input type="button" class="btn btn-info btn-xs" value="Assign to Interviewer" />
                                </a>
                            <?php } ?>
                            <?php if ($is_interviewer) { ?>
                                <a href="<?php echo site_url($_directory . "controls/scheduleinterview/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissionscheduleinterview">
                                    <input type="button" class="btn btn-info btn-xs" value="Schedule Interview" />
                                </a>
                            <?php } ?>
                            <?php if ($row['status'] == "scheduleinterview") { ?>
                                <a href="<?php echo site_url($_directory . "controls/interviewnotes/" . $row["id"]); ?>" data-operationid="managearbaeenmedicalmissioninterviewnotes">
                                    <input type="button" class="btn btn-info btn-xs" value="Interview Notes" />
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                }
            }
            ?>
        </tbody>
    </table>

    <div class="crud_controls">
        <?php echo form_input(array("name" => "options", "type" => "hidden", "value" => "delete")); ?>
        <input data-operation="delete" data-operationid="managearbaeenmedicalmissiondelete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="<?php echo lang_line("text_delete"); ?>" />
        <a href="<?php echo site_url($_directory . "controls/export"); ?>" data-operationid="managearbaeenmedicalmissionexport">
            <input type="button" class="btn btn-info btn-flat" value="Export in Excel" />
        </a>
    </div>

<?php
} else {
    echo 'No Records Found';
}
?>
</form>