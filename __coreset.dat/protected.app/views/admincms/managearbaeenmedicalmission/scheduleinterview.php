<?php

if (count($table_record) > 0) {
    $attributes             = array(
        "method"        => "post",
        "enctype"        => "multipart/form-data"
    );

    $row  = $table_record->row();

    echo form_open(site_url($_directory . "controls/scheduleinterview/" . $row->id), $attributes);
    ?>
    <table id="" class="table table-bordered table-striped arbaeen-medical-mission-table-view">
        <tbody>
            <tr>
                <td>Name</td>
                <td><?php echo $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name; ?></td>
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
                <td>Interview Details (Email Template): <span class="required">*</span> </td>
                <td>
                    <textarea name="interview_details" rows="5" class="form-control ckeditor1"><b>Asalaam Aleikum,</b><br />
	    <br />
	    I hope you are doing well.<br />
	    <br />
	    I am writing to facilitate your phone interview scheduling as an applicant for IMI&#39;s 10th Annual Arbaeen Medical Mission. This interview will be held over a conference line--the number and access code is shared in the confirmation email for the appointment.<br />
	    <br />
	    Please use the following link to schedule your interview for your (first) available time over the next two week <strong>(June 5-17 only)</strong>: <strong>https://imihq.setmore.com</strong><br />
	    <br />
	    The service you should select is &quot;<strong>Arbaeen Interview: Delegates from North America</strong>&quot; (even if you are not from North America). The staff to select (on the next screen) is WGV Interviewer (only option). Then you will see a calendar and an array of available timings. Please select a date/time that works for you. There are only 30 of you in this batch of interview scheduling at this time, so there should be ample choice of interview timings for each of you inshallah.<br />
	    <br />
	    Please schedule your interview slot as soon as possible and no later than <strong>June 7</strong>. (This does not mean your interview must be completed by <strong>June 7</strong>, just that you should book your interview time by then or let us know if the listed timings over the next 2 weeks do not work for you so we can add you to the next batch.)<br />
	    <br />
	    As you schedule your appointment, our preference is to have 24 hours advance notice (to allow us to adequately organize our work days as well) but if that is not possible, minimum time frames have been outlined below:</p>
    <p>
	    <strong>When booking your appointments:</strong><br />
	    You must allow for at least 2 hours advance notice even if there are time slots available with a shorter notice window (like 15-30 minutes from when you sign up) as interviewers may not be immediately available.</p>
    <p>
	    For late night appointments (9 pm EST onwards), please allow for at least 3 hours advance notice (so a midnight interview should be booked no later than 9 pm that day--though for obvious reasons we appreciate as much advance notice as possible.)</p>
    <p>
	    Any time slots prior to 10:30 am must be booked no later than 9 pm the night before.</p>
    <p>
	    For late night appointments (9 pm EST onwards), please allow for at least 3 hours advance notice (so a midnight interview should be booked no later than 9 pm that day, not at 11:30 pm).</p>
    <p>
	    If you are available for interviews during the daytime on weekdays, please book for those times over evening slots (to leave those open for applicants who are unable to interview during the day due to their jobs/school schedules.) In addition, while there is time available over the weekend as well, our preference is to take care of these interviews during the week where possible.</p>
    <p>
	    If you do not show up for your interview time (and do not cancel your interview in advance) due to an unavoidable/urgent situation, you may reschedule the time slot once within this period (following the same rules above). After a second no-show, you should not rebook your time but email SakinaRizviIMI@gmail.com regarding the no-show and then wait to hear from us about how to proceed.</p>
    <p>
	    <strong>Please note:</strong> All times listed are Eastern/New York City timings. You can view the times in your local timings by changing your time zone on the top right side of the calendar so you do not miss your appointment time or book for an incorrect one:<br />
	    <br />
	    We are allocating 20 minutes but your interview should not last that full duration. We realize that you may have many questions yourself (that could even result in calls over an hour!), but should you be selected, there will be a full orientation call as well to go over specifics of this mission. Given this, please do limit yourself to the time allocated.<br />
	    <br />
	    Finally, we envision the interview to be more of a conversation and, as some of you have asked, there is nothing special you need to do to prepare.<br />
	    <br />
	    <b>Thank you,<br />
	    IMI Arbaeen WGV Committee<br />
	    Imamia Medics International</b></textarea>
                    <div class="error"><?php echo form_error('interview_details'); ?></div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="crud_controls">
        <a href="javascript:;" data-operationid="managearbaeenmedicalmissionscheduleinterview">
            <input data-operation="scheduleinterview" type="submit" class="btn btn-primary btn-flat submit_btn_form" name="submit" value="Submit" />
        </a>
    </div>
    <?php
    echo form_close();
}
