<table cellpadding="2" cellspacing="5" width="100%" class="semiform tableform" >
        <tbody>
        
        <tr>
          <td>Gender <?php echo required_field();?></td>
          <td>
          	<?php
			$tmp_name			= 'gender';
			?>
		  	<label>
                                
            <input type="radio" name="<?php echo $tmp_name;?>" 
            class="<?php echo set_class( $tmp_name );?>" value="m"  <?php echo set_checkbox($tmp_name, 'm', format_bool('m', $$tmp_name) );?>  />
            Male
            </label>
            
            <label>
                                
            <input type="radio" name="<?php echo $tmp_name;?>" 
            class="<?php echo set_class( $tmp_name );?>" value="f"  <?php echo set_checkbox($tmp_name, 'f', format_bool('f', $$tmp_name));?>  />
            Female
            </label>
            
            <?php echo  form_error( $tmp_name );?>
          </td>
        </tr>
        <tr>
            <td width="40%">Full Name <?php echo required_field();?></td>
            <td width="60%"><?php
            $tmp_name		= 'full_name';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name, $$tmp_name ),
                                    "placeholder"	=> "Full Name");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
        
        
        <tr>
            <td>Email <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'email';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name, $$tmp_name ),
                                    "placeholder"	=> "Email ");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?>
            </td>
        </tr>
          
          
          
          <tr>
            <td>Phone <?php echo required_field();?></td>
            <td><?php
            $tmp_name		= 'phone';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name, $$tmp_name ),
                                    "placeholder"	=> "Phone");	
    
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?></td>
          </tr>
          
          
         <tr>
            <td>Mailing Address <?php echo required_field();?></td>
            <td>
            <?php
            $tmp_name		= 'mailing_address';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ),
                                    "value"			=> set_value( $tmp_name, $$tmp_name ),
                                    "placeholder"	=> "Mailing Address");	
            
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?>
            </td>
        </tr>
        
        

        
        <tr>
            <td>Speciality / Area of Interest <?php  required_field();?></td>
            <td>
            <?php
            $tmp_name		= 'speciality_interest';
            $specdata		= array("name"			=> $tmp_name,
                                    "id"			=> $tmp_name,
                                    
                                    "type"			=> "text",
                                    "class"			=> set_class( $tmp_name ) . ' selectize',
                                    "value"			=> set_value( $tmp_name, $$tmp_name ),
                                    "placeholder"	=> "Speciality / Area of Interest");	
            
            echo form_input($specdata);
            echo form_error( $tmp_name );
            ?>
            </td>
        </tr>
        
        
        <tr>
            <td>Level of School <?php  required_field();?></td>
            <td>
            <?php
			#conferencelevelofschool_dropdown
            $tmp_name		= 'age_level_of_school';
			echo form_dropdown(	$tmp_name, 
								DropdownHelper::conferencelevelofschool_dropdown( FALSE ), 
								set_value($tmp_name, $$tmp_name), 
								"class='form-control '" );
											
            echo form_error( $tmp_name );
            ?>
            </td>
        </tr>
        
        
            
		
       
        </tbody>
    </table>
    
    