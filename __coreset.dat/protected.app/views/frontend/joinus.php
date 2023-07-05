<div class="main_formPayment">
	<div class="row">
		<h2 class="h2Style2 m_bot25 paddLft">Register</h2>
	</div>

	<form class="form-horizontal bgAllform" action="<?php echo site_url('joinus');?>" method="post" name="membershipForm">

		<fieldset>

			<div class="row">
				<h2 class="h2Style2 m_bot25 paddLft">Member Information</h2>
			</div>

			<!-- first column -->
			<div class="float_leftWrap">

				<div class="col-sm-3">
     				<input id="first-name" name="first-name" placeholder="First Name" class="form-control input-md"  type="text" value="<?php echo set_value('first-name');?>">
						<span class="first-name"><?php echo form_error('first-name');?></span> 
    				</div>	
    			
				
				
				<div class="col-sm-3">
						<input id="middle-name" name="middle-name" placeholder="Middle Name " class="form-control input-md"  type="text" value="<?php echo set_value('middle-name');?>">
						<span class="middle-name"><?php echo form_error('middle-name');?></span>  
					
				</div>	

					
				
					<div class="col-sm-3">
						<input id="last-name" name="last-name" placeholder=" Last Name" class="form-control input-md"  type="text" value="<?php echo set_value('last-name');?>">
						<span class="last-name"><?php echo form_error('last-name');?></span>  
					</div>
				
					<div class="col-sm-3">
						<input id="spacialtiy" name="spaciality" placeholder=" Speciality" class="form-control input-md"  type="text" value="<?php echo set_value('spaciality');?>">
						<span class="spacialtiy"><?php echo form_error('spaciality');?></span>  
					</div>
			</div>

			<!-- first column -->

			<!-- second column -->	
			<div class="float_lefullW">

				<div class="col-sm-12">
					<label class="control-label" for="nama"></label>  
					
					
						<input id="address" name="address" placeholder="Address" class="form-control input-md"  type="text" value="<?php echo set_value('address');?>">
						<span class="address"><?php echo form_error('address');?></span>  
					
				</div>
			</div>
			<!-- second column -->

			<!-- thrid column -->	
			<div class="float_leftWrap">

					<div class="col-sm-3">
						<input id="password" name="password" placeholder=" Password" class="form-control input-md"  type="password" >
						<span class="password"><?php echo form_error('password');?></span>  
					</div>

					  
					<div class="col-sm-3">
						<input id="cpassword" name="cpassword" placeholder=" Confrimpassword" class="form-control input-md"  type="password">
						<span class="cpassword"><?php echo form_error('cpassword');?></span>  
					</div>

					
					<div class="col-sm-3">
						<input id="city" name="city" placeholder="City" class="form-control input-md" type="text" value="<?php echo set_value('city');?>">
						<span class="city"><?php echo form_error('city');?></span>  

					</div>


					<div class="col-sm-3">
						<input id="state" name="state" placeholder="State" class="form-control input-md" type="text" value="<?php echo set_value('state');?>">
						<span class="state"><?php echo form_error('state');?></span>  

					</div>
			</div>
			<!-- third column -->

			<!-- fourth column -->

			<div class="float_leftWrap">

					<div class="col-sm-3">

						<?php echo form_dropdown('home_country', DropdownHelper::country_dropdown(), set_value("home_country", $home_country),'class="form-control"' )?>
						<span class="country"><?php echo form_error('home-country');?></span>  

				</div>


					<div class="col-sm-3">
						<input id="zip-code" name="zip-code" placeholder="Zip Code" class="form-control input-md" type="text" value="<?php echo set_value('zip-code');?>">
						<span class="zip-code"><?php echo form_error('zip-code');?></span> 
				</div>

					<div class="col-sm-3">
						<input id="cell" name="contact-home" placeholder="home-contact" class="form-control input-md" type="text" value="<?php echo set_value('contact-home');?>">
						<span class="cell"><?php echo form_error('contact-home');?></span> 
				</div>

					<div class="col-sm-3">
						<input id="cell" name="cell" placeholder="Cell" class="form-control input-md" type="text" value="<?php echo set_value('cell');?>">
						<span class="cell"><?php echo form_error('cell');?></span> 
				</div>


					<div class="col-sm-3">
						<input id="email" name="email" placeholder="Email" class="form-control input-md" type="text" value="<?php echo set_value('email');?>">
						<span class="email"><?php echo form_error('email');?></span> 
					</div>
			</div>
			<!-- fourth column -->


			<div class="row padMarg">

				<h2 class="h2Style2 m_bot25 paddLft">Professional Information</h2>
			</div>


			<!-- fifth column -->

			<div class="float_leftWrap">
					
					<div class="col-sm-6">
						<input id="company-name" name="company-name" placeholder="Company Name" class="form-control input-md wiDthDef"  type="text" value="<?php echo set_value('company-name');?>">
						<span class="company-name"><?php echo form_error('company-name');?></span> 
					</div>

					<div class="col-sm-6">
						<input id="title" name="title" placeholder="Title" class="form-control input-md wiDthDef"  type="text" value="<?php echo set_value('title');?>">
						<span class="title"><?php echo form_error('title');?></span> 
					</div>
			</div>

			<!-- fifth column -->	

			<!-- sixth column -->	
			<div class="float_lefullW">
					<div class="col-sm-12">
						<input id="office-address" name="office-address" placeholder="Office Address" class="form-control input-md"  type="text" value="<?php echo set_value('office-address');?>">
						<span class="office-address"><?php echo form_error('office-address');?></span> 
				</div>
			</div>

			<!-- sixth column -->	

			<!-- seventh column -->	

			<div class="float_leftWrap">
					<div class="col-sm-3">
						<input id="personal-city" name="personal-city" placeholder="City" class="form-control input-md" type="text" value="<?php echo set_value('city');?>">
						<span class="personal-city"><?php echo form_error('city');?></span> 

					</div>
					<div class="col-sm-3">
						<input id="personal-state" name="personal-state" placeholder="State" class="form-control input-md" type="text" value="<?php echo set_value('personal-state');?>">
						<span class="personal-state"><?php echo form_error('personal-state');?></span>
					</div>

					<div class="col-sm-3">
						<?php echo form_dropdown('office_country', DropdownHelper::country_dropdown(), set_value("office_country", $home_country),'class="form-control"'  )?>

						<!-- office_country-->
						<span class="personal-country"><?php echo form_error('office-country');?></span>
					</div>

			 
					<div class="col-sm-3">
						<input id="personal-zip-code" name="personal-zip-code" placeholder="Zip Code" class="form-control input-md" type="text" value="<?php echo set_value('personal-zip-code');?>">
						<span class="personal-zip-code"><?php echo form_error('personal-zip-code');?></span>
					</div>
			</div>

			<!-- seventh column -->	

			<!-- eight column -->	

			<div class="float_leftWrap">
					
					<div class="col-sm-6">
						<input id="office-phone" name="office-phone" placeholder="Office Phone Number" class="form-control input-md wiDthDef" type="text" value="<?php echo set_value('office-phone');?>">
						<span class="office-phone"><?php echo form_error('office-phone');?></span>
					</div>


					<div class="col-sm-6">
						<input id="office-fax" name="office-fax" placeholder="Office Fax Number" class="form-control input-md wiDthDef" type="text" value="<?php echo set_value('office-fax');?>">
						<span class="office-fax"><?php echo form_error('office-fax');?></span>  
				</div>
			</div>

			<!-- eight column -->	

			<div class="float_leftWrap marginTOp">
				<div class="col-xs-6 lftWrap">
					<span>Preferred Address</span>
						<input type="radio" name="prefered-office-address" value="Home" <?php if ($_POST['prefered-office-address'] == 'Home'){echo 'checked=checked';}?>>
							<label class="radio-inline">
								Home
							</label>
					<label class="radio-inline">

						<input type="radio" name="prefered-office-address" <?php if ($_POST['prefered-office-address'] == 'Office'){echo 'checked=checked';}?> value="Office">Office
					</label>
						<span class="office-fax"><?php echo form_error('office-address');?></span>  
				</div>


				<div class="col-xs-6 rghtWrap">
					<span>Preferred Phone</span>
					<label class="radio-inline">
						<input type="radio" name="prefered-phone"  <?php if ($_POST['prefered-phone'] == 'Home'){echo 'checked=checked';}?> value="Home">Home
					</label>
					<label class="radio-inline">
						<input type="radio" name="prefered-phone" <?php if ($_POST['prefered-phone'] == 'Office'){echo 'checked=checked';}?> value="Office">Office
					</label>
					<label class="radio-inline">
						<input type="radio" name="prefered-phone" <?php if ($_POST['prefered-phone'] == 'Cell'){echo 'checked=checked';}?> value="Cell">Cell
					</label>
						<span class="office-fax"><?php echo form_error('office-phone');?></span>  
				</div>
			</div>
			
			<!-- eight column -->	

			<!-- nine column -->	
			<div class="bgAllform">
				<div class="row headingMid">
					<h2 class="h2Style2 m_bot25"><b>Membership Type-</b> Return today to start enjoying member benifits today (Please Check One)</h2>
				</div>

				<!-- eighth column -->

				<!-- ninth column -->

				<div class="flALlLeft">
						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="Life Membership ( MD, DO, PhD, Dentist )$1500.00" <?php if ($_POST['membership'] == 'Life Membership ( MD, DO, PhD, Dentist )$1500.00'){echo 'checked=checked';}?>   />
							<label class="control-label">Life Membership ( MD, DO, PhD, Dentist ) $1500.00</label> 
						</div>

						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="Life Membership ( MD, DO, PhD, Dentist )$1500.00" <?php if ($_POST['membership'] == 'Life Membership ( MD, DO, PhD, Dentist )$1500.00'){echo 'checked=checked';}?>  />
							<label class="control-label">Life Membership ( MD, DO, PhD, Dentist ) $1500.00</label> 
						</div>
				</div>
				<!-- ninth column -->

				<!-- tenth column -->

				<div class="flALlLeft">

					<div class="form-group">
						<label class="control-label h2Style2 paddLft" for="test strucrt">family Membership Options</label>
					</div>

					<div class="form-group">
						<label class=" control-label" for="test strucrt"></label>  
						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="family with 2 Medical Professionals ( MD, DO, PhD, Dentist )$250.00/Y" <?php if ($_POST['membership'] == 'family with 2 Medical Professionals ( MD, DO, PhD, Dentist )$250.00/Y'){echo 'checked=checked';}?>  />
							<label class="control-label ">family with 2 Medical Professionals ( MD, DO, PhD, Dentist ) $250.00/Y</label> 
						</div>
					</div>



					<div class="form-group">
						<label class=" control-label" for="test strucrt"></label>  
						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="family with 2 Medical Professional ( MD, DO, PhD, Dentist )$200.00/Y" <?php if ($_POST['membership'] == 'family with 2 Medical Professional ( MD, DO, PhD, Dentist )$200.00/Y'){echo 'checked=checked';}?>  />
							<label class="control-label">family with 2 Medical Professional ( MD, DO, PhD, Dentist ) $200.00/Y</label> 

						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="family membership for non-healthcare profesionals( MD, DO, PhD, Dentist )$75.00/Y" <?php if ($_POST['membership'] == 'family membership for non-healthcare profesionals( MD, DO, PhD, Dentist )$75.00/Y'){echo 'checked=checked';}?>  />
							<label class="control-label">family membership for non-healthcare profesionals( MD, DO, PhD, Dentist ) $75.00/Y</label> 

						</div>
					</div>
				</div>

				<!-- tenth column -->


				<!-- elventh column -->

				<div class="flALlLeft">

					<div class="form-group">
						<label class=" control-label h2Style2 paddLft" for="test strucrt">individual Membership Options </label>  
					</div>
					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="Medical Professionals ( MD, DO, PhD, Dentist )$150.00/Y" <?php if ($_POST['membership'] == 'Medical Professionals ( MD, DO, PhD, Dentist )$150.00/Y'){echo 'checked=checked';}?>  />
							<label class="control-label">Medical Professionals ( MD, DO, PhD, Dentist ) $150.00/Y</label> 

						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-8 bg_greyText">
							<input type="radio" name="membership" id="membership" value="Resident fellow/Alied heath professionl( Pharmacist, Nurse, Technician, etc )$75.00/Y" <?php if ($_POST['membership'] == 'Resident fellow/Alied heath professionl( Pharmacist, Nurse, Technician, etc )$75.00/Y'){echo 'checked=checked';}?>  />
							<label class="control-label">Resident fellow/Alied heath professionl( Pharmacist, Nurse, Technician, etc ) $75.00/Y</label> 

						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="Associate Member(non-healthcare profesionals/Community Member)$25.00/Y" <?php if ($_POST['membership'] == 'Associate Member(non-healthcare profesionals/Community Member)$25.00/Y'){echo 'checked=checked';}?>  />
							<label class="control-label">Associate Member(non-healthcare profesionals/Community Member) $25.00/Y</label> 

						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-7 bg_greyText">
							<input type="radio" name="membership" id="membership" value="Student $25.00/Y" <?php if ($_POST['membership'] == 'Student $25.00/Y'){echo 'checked=checked';}?>  />
							<label class="control-label">Student $25.00/Y</label> 

						</div>
						<span class="membership"><?php echo form_error('membership');?></span>
					</div>
				</div>
				<!-- elventh column -->


				<!-- twevelth column -->

				<div class="flALlLeft">
					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-6">
							<label class="h2Style2">
								I wish to make an additional tax-deductible donation of $  
							</label>
							<input type="text"  class="form-control" name="donation" id="donation" placeholder="" value="<?php echo set_value('donation');?>">
							<span class="donation"><?php //echo form_error('donation');?></span>
						</div>

					</div>
				</div>
				<!-- twevelth column -->

				<!-- thirth column -->

				<div class="flALlLeft">
					<div class="holdWrap_width">
						<div class="row midd_Heading">
							<h2 class="h2Style2 m_bot25 paddLft" >Payment type</h2>
						</div>  

						<div class="form-group floatmin">
                        	
							<div class="col-md-3 margRgt">
								<input type="radio" name="payment-type" <?php if ($_POST['payment-type'] == 'Visa'){echo 'checked=checked';}?> id="payment-type" value="Visa" />
								<label class="control-label allPayimg"></label> 
							</div>
							<div class="col-md-3 margRgt">
								<input type="radio" name="payment-type" id="payment-type" <?php if ($_POST['payment-type'] == 'MasterCard'){echo 'checked=checked';}?> value="MasterCard" />
								<label class="control-label allPayimgsec"></label> 
							</div>
							<div class="col-md-3 margRgt">
								<input type="radio" name="payment-type" id="payment-type" <?php if ($_POST['payment-type'] == 'Amex'){echo 'checked=checked';}?> value="Amex" />
								<label class="control-label allPayimgth"></label> 
							</div>
							<div class="col-md-3 margRgt">
								<input type="radio" name="payment-type" id="payment-type" <?php if ($_POST['payment-type'] == 'paypal'){echo 'checked=checked';}?> value="paypal" />
								<label class="control-label allPayimgfi"></label> 
							</div>
							
						</div>
					</div>
					<span class="payment-type"><?php echo form_error('payment-type'); ?></span>
				</div>
				<!-- thirth column -->

				<!-- fouthen column -->
				<div class="flALlLeft">

						<div class="col-sm-4">
							<input id="card-number" name="card-number" placeholder="Card Number" class="form-control input-md wiDthDef"  type="text" value="<?php echo set_value('card-number');?>">
							<span class="card-number"><?php echo form_error('card-number'); ?></span>

						</div>

						<div class="col-sm-2">
							<input id="monthsa" name="month" placeholder="Month(01)" class="form-control input-md" type="text" value="<?php echo set_value('month');?>">
							<span class="expiration"><?php echo form_error('month'); ?></span>
						</div>

						<div class="col-sm-2">
							<input id="expiration" name="expiration" placeholder="Year(2017)" class="form-control input-md" type="text" value="<?php echo set_value('expiration');?>">
							<span class="expiration"><?php echo form_error('expiration'); ?></span>
						</div>

						

						<div class="col-sm-3">
							<input id="ccv" name="ccv" placeholder="CCV" class="form-control input-md" type="text" value="<?php echo set_value('ccv');?>">
							<span class="ccv"><?php echo form_error('ccv'); ?></span>
						</div>
					
				</div>

				<div class="flALlLeft">

						<div class="col-md-8 bg_greyText">
							<label>
								Members may simplify payment of dues through anual automatic planes on thier card you may cancel enrollment  at any time by emailing imihq@imamiamedics.com.Intial here to enroll 
							</label> 
							<div class="col-md-4 paddzERo">

								<input type="text"  class="form-control input-md " name="enroll" id="enroll" placeholder="Enroll here " value="<?php echo set_value('enroll');?>" />
								<span class="enroll"><?php echo form_error('enroll'); ?></span>
							</div>
					</div>
				</div>
				<!-- fouthen column -->

				<!-- fiften column -->

				<div class="flALlLeft">

						<div class="col-sm-4">
							<label class="control-label h2Style2">Signature</label>
							<input type="text"  class="form-control input-md" name="signature" id="signature" placeholder="Signature" value="<?php echo set_value('signature');?>" />
							<span class="signature"><?php echo form_error('signature'); ?></span>
						</div>

						<div class="col-md-4">
							<label class="control-label h2Style2">Date</label>
							<input type="text"  class="form-control datepicker " name="date" id="date" placeholder="Date " value="<?php echo set_value('date');?>" />
							<span class="date"><?php echo form_error('date'); ?></span>
						</div>
				</div>

				<!-- fiften column -->

				<!-- sixten column -->

				<div class="flALlLeft">

						<div class="col-md-8">
							<label class="labelbgo">Please complete the information above and mail with your payment IMI PO box 8209 , Princeton , NJ08543 or Visit http://www.imamiamedics.com to electronically update and process your membership.</label>
						</div>
				</div>
				<!-- sixten column -->


				<!-- seventh column -->

				<div class="flALlLeft">

						<div class="col-md-2">
							<button id="submit" name="submit" class="btn btn-primary">Register</button>
						</div>
					</div>
				</div>
		</fieldset>
	</form>
</div>