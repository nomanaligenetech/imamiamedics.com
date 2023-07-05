<?php

if (count($table_record) > 0) {
	$attributes             = array(
		"method"        => "post",
		"enctype"        => "multipart/form-data"
	);

	$row  = $table_record->row();

	echo form_open(site_url($_directory . "controls/stage3/" . $row->id), $attributes);
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
				<td>Select Form Type</td>
				<td>
					<select name="stage3_link" class="form-control">
						<option value="<?php echo $stage3a_link; ?>">Stage 3A</option>
						<option value="<?php echo $stage3b_link; ?>">Stage 3B</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Stage 3 Details (Email Template): <span class="required">*</span> </td>
				<td>
					<textarea name="stage3_details" rows="5" class="form-control ckeditor1"><p>
			<b>Asalaam Aleikum,</b></p>
		<p>
			Congratulations!&nbsp;You have conditional approval to be a delegate for IMI&#39;s 10th Annual Arbaeen Medical Mission for the Karbala camp.&nbsp;&nbsp;As mentioned earlier, your final approval will be based on the following:&nbsp;</p>
		<ol>
			<li>
				Reviewing &amp; abiding by&nbsp;<u>all rules &amp; protocols</u>&nbsp;governing IMI&#39;s delegation, and; 2. Completing the elements outlined below by their deadlines.&nbsp; &nbsp;</li>
		</ol>
		<p>
			Based on the recommendation of your interviewer, the Arbaeen Committee is confident that you understand the basic requirements that each delegate must be:</p>
		<blockquote>
			&nbsp;</blockquote>
		<ol>
			<li>
				Committed to&nbsp;<b>follow the camp scheduled dates</b>&nbsp;and&nbsp;<b>appear on time</b>&nbsp;for all aspects of the mission--from group transports to your daily shifts</li>
			<li>
				Well mannered: behave with&nbsp;<b>professionalism and decorum&nbsp;</b>throughout including at the camps and in your shared accommodations.</li>
			<li>
				Able to be&nbsp;<b>utilized in this camp</b>. (Remember, our priority is to provide health services during Arbaeen--distinct from ziyarat groups--and do whatever it takes to keep working flowing&nbsp;<b>as one team</b>. The overwhelming need is for general health service not specialist work so all health providers will be required to provide basic medical care for adults. In rare instances, as needed, specialists MAY perform services at hospitals but that is NOT the core of work.)</li>
		</ol>
		<p>
			<b>By moving onto&nbsp;stage&nbsp;3&nbsp;of this process, you agree to abide by these basic, professional requirements&nbsp;<u>and the costs&nbsp;</u>as outlined in the application.&nbsp;</b> &nbsp; &nbsp; <b><u><br />
			</u></b> <b>IMI&#39;s 10th Annual Arbaeen Medical Mission:&nbsp;Application&nbsp;Stage&nbsp;3</b> <b><u>A. Online application</u></b><b><u>:</u></b><b>&nbsp;PLEASE</b><b>&nbsp;COMPLETE BY FRIDAY, SEPT 14<br />
			</b></p>
		<blockquote>
			For your conditional approval to be finalized,&nbsp;<b>you must complete the last application phase online as soon as possible (no later than FRIDAY, SEPT 14, 2018</b>&nbsp;at:&nbsp;<span id="OBJ_PREFIX_DWT344_com_zimbra_url"><a href="[stage3_link]" target="_blank" style="font-weight:bold;">[stage3_link]</a></span> &nbsp; During this&nbsp;stage&nbsp;we will collect details and documents for your visas including copies of your passport &amp; visa picture. When uploading your passport &amp; image, you must add the file, then once you see your file listed, click the green upload button that shows up. Once your images are properly loaded, you will see a green check mark next to your file name. &nbsp;</blockquote>
		<blockquote>
			NOTE: PLEASE ENSURE YOUR PASSPORT COPY IS A CLEAR, LEGIBLE, COLOR COPY.&nbsp;<br />
			<br />
			NOTE: You can bring the $500 USD payment as cash (in dollars) and do not have to submit online through PayPal as we just discussed.&nbsp;</blockquote>
		<blockquote>
			&nbsp;</blockquote>
		<blockquote>
			<b><u>B. Confirming IMI Membership:</u></b><b>&nbsp;PLEASE COMPLETE BY&nbsp;</b><b>Tuesday, September 18</b></blockquote>
		<blockquote>
			<p>
				n addition, each delegate is required to be a dues-paying IMI member. If you are not currently a dues-paying member, please sign up for membership through this link:&nbsp;<span id="OBJ_PREFIX_DWT345_com_zimbra_url"><a href="https://imamiamedics.com/page/join-us.html" target="_blank">https://imamiamedics.com/page/join-us.html</a></span>. For those from Europe, you can also use this form for membership to be processed by IMI UK in pounds:&nbsp;<span id="OBJ_PREFIX_DWT346_com_zimbra_url"><a href="http://imamiamedics.org.uk/membership/" target="_blank">http://imamiamedics.org.uk/membership/</a></span></p>
			<p>
				<b><u>C. Ticketing (for Karbala Camp only delegates):</u>&nbsp;PLEASE COMPLETE BY SATURDAY SEPTEMBER 18 FOR SPECIFIED DATES/TIMINGS/FLIGHTS.&nbsp;</b></p>
		</blockquote>
		<blockquote>
			<p>
				&nbsp;</p>
			<p>
				<b><u>You must ticket based on this schedule:&nbsp;</u></b></p>
			<p>
				Arrive into Najaf on&nbsp;<b>October 22th</b>&nbsp;<u>(between 7-11 am)</u>.&nbsp;&nbsp;</p>
			<p>
				Depart Najaf on&nbsp;<b>November 4&nbsp;</b>(evening between 7-11 pm)</p>
			<p>
				&nbsp;</p>
			<p>
				For logistics to remain smooth, we have been working with the following relevant travel agents</p>
			<p>
				<b>In the US/Canada:&nbsp;</b></p>
			<p>
				&nbsp;</p>
			<p>
				Rukhsana Dossani&nbsp;</p>
			<p>
				Ashfaq Bhai</p>
			<p>
				Five Star Travel&nbsp;</p>
			<p>
				<a href="tel:407-929-6125" target="_blank">407-929-6125</a></p>
			<p>
				<a href="tel:(407)%20786-8882" target="_blank">407-786-8882</a></p>
			<p>
				&nbsp;</p>
			<p>
				Please contact them&nbsp;<u>as soon as possible&nbsp;</u>to finalize and issue your ticket.&nbsp;</p>
			<p>
				&nbsp;</p>
			<p>
				Booking will be made for these flights:&nbsp;</p>
		</blockquote>
		<blockquote>
			<p>
				atar Airways Flights 704 &amp; 456 Departing JFK at 10:40 AM on October 21, connecting via Doha (2:05 layover) to arrive in Najaf at 10 AM on October 22.</p>
		</blockquote>
		<blockquote>
			<p>
				atar Airways Flights 461 &amp; 703 Departing Najaf at 9:45 PM on November 4, connecting via Doha (1:55 layover) to arrive at JFK at 7:40 AM on November 5.</p>
		</blockquote>
		<blockquote>
			<p>
				hose traveling from other parts but connecting through NYC may also discuss the group seats with Rukhsana Baji and whether there is availability for this choice for each of you.</p>
		</blockquote>
		<blockquote>
			<p>
				<b>In Europe:&nbsp;</b></p>
			<p>
				yed Safdar</p>
			<p>
				light Corner UK</p>
			<p>
				span id=&quot;OBJ_PREFIX_DWT347_com_zimbra_email&quot;&gt;<a href="mailto:syed.safder@flightcorner.co.uk" target="_blank">syed.safder@flightcorner.co.uk</a></p>
			<p>
				44 7980 394505</p>
		</blockquote>
		<blockquote>
			<p>
				n Europe we have been working with Syed Safdar of Flight Corner for the following tickets (though you may also book independently if you have a better fare for the SAME flights):</p>
			<p>
				atar Airways Flights 16 &amp; 456 Departing LHR at 21:55 on October 21, connecting via Doha (1:20 layover) to arrive in Najaf at 10 AM on October 22.</p>
			Qatar Airways Flights 461 &amp; 9 Departing Najaf at 21:45 on November 4, connecting via Doha (2:10 layover) to arrive at LHR at 6:20 AM on November 5.</blockquote>
		<blockquote>
			<p>
				<b>You must send a confirmation copy of your ticket to us as soon as possible and no later than September 18, 2018</b></p>
			<p>
				<b>Confirmation as a Delegate for IMI&#39;s 10th Annual Arbaeen Medical Mission happens once you complete ALL required&nbsp;stages&nbsp;(by deadlines).</b></p>
		</blockquote>
		<blockquote>
			<p>
				As soon as you fulfill these requirements, you are considered confirmed as a delegate for IMI&#39;s 10th International Arbaeen Medical Mission.&nbsp;</p>
			<p>
				&nbsp;</p>
			<p>
				<u>Please note, if you do not complete all&nbsp;stages&nbsp;by the deadlines set forth, your spot may be released to another delegate from the application pool/wait list.</u></p>
			<p>
				If you have any difficulties, please let us know immediately.</p>
			<p>
				As always, please let me know if you have any questions or concerns.</p>
		</blockquote>
		</textarea>
					<div class="error"><?php echo form_error('stage3_details'); ?>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="crud_controls">
		<a href="javascript:;" data-operationid="managearbaeenmedicalmissionstage3">
			<input data-operation="stage3" type="submit" class="btn btn-primary btn-flat submit_btn_form" name="submit" value="Submit" />
		</a>
	</div>
<?php
	echo form_close();
}
