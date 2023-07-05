<table class="table table_form">
		
		
        <tr>
			<td class="td_bg fieldKey"><strong>Submitted By <?php echo required_field(); ?></strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo form_dropdown("userid", DropdownHelper::user_dropdown(TRUE, set_value('userid', $userid)), set_value("userid", $userid), "class='form-control' " );
                ?>
            </div>
			</td>
		</tr>
        

		<tr>
			<td class="td_bg fieldKey"><strong>Conference <?php echo required_field(); ?></strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo form_dropdown("conferenceid", DropdownHelper::conference_dropdown(TRUE, set_value('conferenceid', $conferenceid)), set_value("conferenceid", $conferenceid), "class='form-control'" );
				?>
            </div>
			</td>
		</tr>
        
		
        <tr>
			<td class="td_bg fieldKey"><strong>Gender <?php echo required_field(); ?></strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo form_dropdown("gender", DropdownHelper::gender_dropdown(), set_value("gender", $gender), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
        
        
        
        <tr>
          <td class="td_bg"><strong>Name <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "name",
									"id"			=> "name",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("name", $name ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        <tr>
          <td class="td_bg"><strong>Middle  Name <?php //echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2"><div class="input-group">
            <?php
			$specdata		= array("name"			=> "middle_name",
									"id"			=> "middle_name",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("middle_name", $middle_name ) );	

			echo form_input($specdata);
			?>
          </div></td>
        </tr>
        
        
        <tr>
          <td class="td_bg"><strong>Father Name <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "father_name",
									"id"			=> "father_name",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("father_name", $father_name ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Surname <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "surname",
									"id"			=> "surname",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("surname", $surname ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Passport Number <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "passport_number",
									"id"			=> "passport_number",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("passport_number", $passport_number ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Passport Type <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "passport_type",
									"id"			=> "passport_type",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("passport_type", $passport_type ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Date of Birth <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "date_of_birth",
                                        "id"			=> "date_of_birth",
                                        "class"			=> "form-control datepicker",
                                        "size"			=> 47,
                                        "value"			=> set_value("date_of_birth", $date_of_birth)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Place of Birth <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "place_of_birth",
									"id"			=> "place_of_birth",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("place_of_birth", $place_of_birth ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
			<td class="td_bg fieldKey"><strong>Country of Birth <?php echo required_field(); ?></strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo form_dropdown("country_of_birth", DropdownHelper::country_dropdown(), set_value("country_of_birth", $country_of_birth), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
        
        <tr>
          <td class="td_bg"><strong>Nationality <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "nationality",
									"id"			=> "nationality",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("nationality", $nationality ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        
        <tr>
			<td class="td_bg"><strong>Passport Image <?php echo required_field(); ?><br />
          </strong></td>
			<td class="td_bg" colspan="2">
				<div class="input-group">
				<input type="file" class="btn btn-default" name="file_passport_image"/>
				<input type="hidden" value="<?php echo set_value("passport_image", $passport_image);?>" name="passport_image" />  
				<small><?php echo image_link("passport_image", $passport_image);?></small>
				</div>
			</td>
		</tr>
        
        
        
        <tr>
			<td class="td_bg"><strong>Photo Image <?php echo required_field(); ?><br />
          </strong></td>
			<td class="td_bg" colspan="2">
				<div class="input-group">
				<input type="file" class="btn btn-default" name="file_photo_image"/>
				<input type="hidden" value="<?php echo set_value("photo_image", $photo_image);?>" name="photo_image" />  
				<small><?php echo image_link("photo_image", $photo_image);?></small>
				</div>
			</td>
		</tr>
        
        
        <tr>
			<td class="td_bg fieldKey"><strong>Marital Status <?php echo required_field(); ?></strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo form_dropdown("marital_status", DropdownHelper::marital_status_dropdown(), set_value("marital_status", $marital_status), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
        
        <tr>
          <td class="td_bg"><strong>Gender Father Name <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "gender_father_name",
									"id"			=> "gender_father_name",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("gender_father_name", $gender_father_name ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        
        <tr>
          <td class="td_bg"><strong>Previous Nationality <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "previous_nationality",
									"id"			=> "previous_nationality",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("previous_nationality", $previous_nationality ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Date of Issue <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "date_of_issue",
                                        "id"			=> "date_of_issue",
                                        "class"			=> "form-control",
										
										"data-datemode"	=> "start",
										"data-currdate"	=> "1",
									
                                        "size"			=> 47,
                                        "value"			=> set_value("date_of_issue", $date_of_issue)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Place of Issue <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "place_of_issue",
									"id"			=> "place_of_issue",									
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("place_of_issue", $place_of_issue ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Expiry Date <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "expiry_date",
                                        "id"			=> "expiry_date",
										
										"data-datemode"	=> "end",
										"data-currdate"	=> "1",
									
                                        "class"			=> "form-control",
                                        "size"			=> 47,
                                        "value"			=> set_value("expiry_date", $expiry_date)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          </td>
        </tr>
       
       
       <tr>
          <td class="td_bg"><strong>Occupation <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "occupation",
									"id"			=> "occupation",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("occupation", $occupation ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>Position <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "position",
									"id"			=> "position",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("position", $position ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>Name of Institute Company <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "name_of_institute_company",
									"id"			=> "name_of_institute_company",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("name_of_institute_company", $name_of_institute_company ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>Title of Activity <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "title_of_activity",
									"id"			=> "title_of_activity",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("title_of_activity", $title_of_activity ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
       
        
       <tr>
          <td class="td_bg"><strong>Visa Issuance Place <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "visa_insurance_place",
									"id"			=> "visa_insurance_place",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("visa_insurance_place", $visa_insurance_place ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>Duration of Stay <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "duration_of_stay",
									"id"			=> "duration_of_stay",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("duration_of_stay", $duration_of_stay ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>No. of Previous Travels <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "no_of_previous_travels",
									"id"			=> "no_of_previous_travels",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("no_of_previous_travels", $no_of_previous_travels ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>Date of Entry for Conference <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "date_of_entry_for_conference",
                                        "id"			=> "date_of_entry_for_conference",
                                        "class"			=> "form-control ",
                                        "size"			=> 47,
                                        "value"			=> set_value("date_of_entry_for_conference", $date_of_entry_for_conference)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>Last Date of Entry <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "last_date_of_entry",
                                        "id"			=> "last_date_of_entry",
                                        "class"			=> "form-control datepicker",
                                        "size"			=> 47,
                                        "value"			=> set_value("last_date_of_entry", $last_date_of_entry )
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          </td>
        </tr>
       
       <tr>
          <td class="td_bg"><strong>Date of Departure <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "date_of_departure",
                                        "id"			=> "date_of_departure",
                                        "class"			=> "form-control ",
                                        "size"			=> 47,
                                        "value"			=> set_value("date_of_departure", $date_of_departure)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          </td>
        </tr>
       

       
       
       
       
       
     
       
       <tr>
          <td class="td_bg"><strong>Date of Registration <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<?php echo set_value("registration_date", $registration_date);?>
          </td>
        </tr>
       
       
		
		
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>