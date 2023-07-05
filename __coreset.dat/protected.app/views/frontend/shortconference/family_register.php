<?php
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data",
								"name"			=> "form1",
								"id"			=> "form1");

echo form_open(site_url( uri_string() ), $attributes);
?>
<a name="hash_form" id="hash_form"></a>
<div class="formarea">
  <div class="abstract-form-content">
    
    <div class="subheading">
      <?php echo conference_fullname( $conference ); ?>
    </div>
    
    <div class="subheading-2">
    	<?php echo conference_durationdates( $conference ); ?>
    </div>
    
    <br />
    <?php echo  sprintf( lang_line('text_abstractform_desc'), POSTER_DATE );?> </div>
    
    
    
    
    
    
    
    
    <table cellpadding="2" cellspacing="5" width="100%" class="semiform" >
        <tbody>

        
        <tr>
          <td colspan="2" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center">&nbsp;</td>
        </tr>
        
        <tr>
          <td colspan="2" align="center" style="text-align:center"><strong>2 family members accompanying you. Please register them all.</strong></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="40%">Name <?php echo required_field();?></td>
            <td width="60%"><?php
            $tmp_name		= 'name';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Name");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Fathers Name <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'father_name';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Father Name");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>SurName <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'surname';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "SurName");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Passport Number <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'passport_number';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Passport Number");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        
        <tr>
            <td>Passport Type <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'passport_type';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Passport Type");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        
        <tr>
            <td>Date of Birth <small>(dd/mm/yyyy)</small> <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'date_of_birth';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "datepicker " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Date of Birth");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Place of Birth <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'place_of_birth';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Place of Birth");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        
        <tr>
            <td>Country of Birth <?php echo required_field();?></td>
            <td>
			<?php echo form_dropdown('country_of_birth', DropdownHelper::country_dropdown(), set_value("country_of_birth"), "class='form-control '" )?>
            
			<?php
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Nationality <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'nationality';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Nationality");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Passport Image <?php echo required_field();?></td>
            <td>
			<input type="file" class="btn btn-default" name="file_passport_image"/>
            <input type="hidden" value="<?php echo set_value("passport_image");?>" name="passport_image" /> 
            <br /> 
            <small><?php echo image_link("passport_image", '');?></small>
            
			<?php
            echo form_error( 'file_passport_image' );
            ?>
            </td>
          </tr>
        
        
        
        <tr>
            <td>Photo <?php echo required_field();?></td>
            <td>
            <input type="file" class="btn btn-default" name="file_photo_image"/>
            <input type="hidden" value="<?php echo set_value("photo_image");?>" name="photo_image" />  
            <br />
            <small><?php echo image_link("photo_image", '');?></small>
            
			<?php
            echo form_error( 'file_photo_image' );
            ?>
            
			</td>
          </tr>
        
        
        <tr>
            <td>Marital Status <?php echo required_field();?></td>
            <td>
			<label>
                                
            <input type="radio" name="marital_status" 
            class="<?php echo set_class("marital_status");?>" value="single"  <?php echo set_checkbox("marital_status", 'single');?>  />
            Single
            </label>
            
            <label>
                                
            <input type="radio" name="marital_status" 
            class="<?php echo set_class("marital_status");?>" value="married"  <?php echo set_checkbox("marital_status", 'married');?>  />
            Married
            </label>
            
            <?php echo  form_error( 'marital_status' );?>
            </td>
          </tr>
        
        
        <tr>
            <td>Gender Father's Name<br /><small>(only for arab national)</small></td>
            <td><?php
            $tmp_name		= 'gender_father_name';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Gender Father's Name (only for arab national)");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?>
            </td>
          </tr>
        
        
        <tr>
            <td>Previous Nationality <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'previous_nationality';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Previous Nationality");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Date of Issue <small>(dd-mm-yyyy)</small> <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'date_of_issue';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "datepicker " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Date of Issue");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Place of Issue <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'place_of_issue';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Place of Issue");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Expiry Date <small>(dd-mm-yyyy)</small> <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'expiry_date';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "datepicker " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Expiry Date");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Occupation <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'occupation';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Occupation");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Position <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'position';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Position");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Name of Institute / Company <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'name_of_institute_company';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Name of Institute / Company");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Title of Activity <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'title_of_activity';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Title of Activity");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Visa Issuance Place <?php echo required_field();?><br /><small>For USA and Canadian nationals, visa will be sent to Interest Section, Pakistani Embassy, Washington D.C.</small></td>
            <td><?php
            $tmp_name		= 'visa_insurance_place';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Visa Issuance Place");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?>
            </td>
          </tr>
        
        
        <tr>
            <td>Duration of Stay in <?php echo SessionHelper::_get_session("country_name", "conference");?></td>
            <td><?php
            $tmp_name		= 'duration_of_stay';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "numericonly " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name, 15 ),
                                    "placeholder"	=> "Duration of Stay in " . SessionHelper::_get_session("country_name", "conference") );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Number of Previous Travels to Iran</td>
          <td><?php
            $tmp_name		= 'no_of_previous_travels';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "numericonly " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name, 0 ),
                                    "placeholder"	=> "Duration of Stay in " . SessionHelper::_get_session("country_name", "conference") );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
        <tr>
          <td>Date of entry For Conference <?php echo required_field();?></td>
          <td><?php
            $tmp_name		= 'date_of_entry_for_conference';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "datepicker " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Date of entry For Conference" );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
        <tr>
          <td>The Last Date of Entry to Iran [date you left Iran last time] <?php echo required_field();?></td>
          <td><?php
            $tmp_name		= 'last_date_of_entry';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "datepicker " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "The Last Date of Entry to ". SessionHelper::_get_session("country_name", "conference") ." [date you left ". SessionHelper::_get_session("country_name", "conference") ." last time]" );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
        <tr>
          <td>Date of Departure from Iran after conference <?php echo required_field();?></td>
          <td><?php
            $tmp_name		= 'date_of_departure';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> "datepicker " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Date of Departure from ". SessionHelper::_get_session("country_name", "conference") ." after conference" );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
        <tr>
          <td>Are you accompanied by family members? <?php echo required_field();?></td>
          <td>
		 	<?php
			$tmp_name			= 'accompanied_by_family';
			?>
		  	<label>
                                
            <input type="radio" name="<?php echo $tmp_name;?>" 
            class="<?php echo set_class( $tmp_name );?>" value="1"  <?php echo set_checkbox($tmp_name, '1');?>  />
            Yes
            </label>
            
            <label>
                                
            <input type="radio" name="<?php echo $tmp_name;?>" 
            class="<?php echo set_class( $tmp_name );?>" value="0"  <?php echo set_checkbox($tmp_name, '0');?>  />
            No
            </label>
            
            <?php echo  form_error( $tmp_name );?>
            
            </td>
        </tr>
        <tr>
          <td>Number of family members Accompanying you?</td>
          <td>
		  <?php
            $tmp_name		= 'no_of_family_members_accompanied';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
									"disabled"		=> "disabled",
                                    "class"			=> "numericonly " . set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name, 0 ),
                                    "placeholder"	=> "Number of family members accompanying you?" );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>E-Mail <?php echo required_field();?></td>
          <td><?php
            $tmp_name		= 'email';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Email" );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
        <tr>
          <td>Mobile&nbsp; <?php echo required_field();?></td>
          <td><?php
            $tmp_name		= 'mobile';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Mobile" );	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
        <tr>
          <td>Mailing Address <?php echo required_field();?></td>
          <td><?php
            $tmp_name		= 'mailing_address';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name ),
                                    "placeholder"	=> "Mailing Address");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
        </tr>
          
		<?php
		$arrayindex				= NumberHelper::number_array( range("2", "8") );
		foreach ( $arrayindex as $key => $value )
		{
			?>
            <?php
		}
		?>
        
        
        
        
        
        
        </tbody>
    </table>
</div>
<div class="formbtns"> 
  <input type="button" value="Submit"  onclick="submit_with_hash('form1', 'hash_form')" />
</div>
<?php
echo form_close();
?>