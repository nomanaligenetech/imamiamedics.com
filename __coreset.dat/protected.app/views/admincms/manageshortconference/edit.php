<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
		  <td class="td_bg fieldKey">Theme <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg fieldValue">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "theme",
									"id"			=> "theme",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("theme", $theme ) );	

			echo form_input($specdata);
			?>
		    </div>
            </td>
	  </tr>
      
      <tr>
		  <td class="td_bg fieldKey">Slug <?php required_field(); ?></td>
		  <td colspan="2" class="td_bg fieldValue">
          <div class="input-group">
		    <?php
			echo set_value("slug", $slug );
			?>
		    </div>
            </td>
	  </tr>
      
		<tr>
		  <td class="td_bg">Name <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "name",
									"id"			=> "name",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("name", $name ) );	

			echo form_input($specdata);
			?>
		    </div></td>
	  </tr>
      
      <tr>
		  <td class="td_bg">Venue <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "venue",
									"id"			=> "venue",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("venue", $venue ) );	

			echo form_input($specdata);
			?>
		    </div></td>
	  </tr>
      
      
      
      <tr>
		  <td class="td_bg">Description <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          <div class="input------group">
		    <?php
			$specdata		= array("name"			=> "description",
									"id"			=> "description",
									"size"			=> 50,
									"style"			=> "width:100%",
									"class"			=> "form-control",
									"value"			=> set_value("description", $description ) );	

			echo form_textarea($specdata);
			?>
		    </div></td>
	  </tr>
      
      
      
		<tr>
		  <td rowspan="2" class="td_bg">Duration <?php echo required_field(); ?></td>
		  <td bgcolor="#CCCCCC" class="td_bg">From</td>
		  <td bgcolor="#CCCCCC" class="td_bg">
          
       	  <div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "duration_from",
                                        "id"			=> "duration_from",
                                        "class"			=> "form-control",
										"data-datemode"	=> "start",
                                        "size"			=> 47,
                                        "value"			=> set_value("duration_from", $duration_from)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          
          </td>
      </tr>
		<tr>
		  <td bgcolor="#CCCCCC" class="td_bg">To</td>
		  <td bgcolor="#CCCCCC" class="td_bg">
          <div class="input-group ">
            <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
            <?php
            $specdata			= array("name"			=> "duration_to",
                                        "id"			=> "duration_to",
                                        "class"			=> "form-control",
										"data-datemode"	=> "end",
                                        "size"			=> 47,
                                        "value"			=> set_value("duration_to", $duration_to)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          </td>
      </tr>
		<tr>
		  <td rowspan="2" class="td_bg">Registration <?php echo required_field(); ?></td>
		  <td bgcolor="#E8E8E8" class="td_bg">From</td>
		  <td bgcolor="#E8E8E8" class="td_bg">
          <div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "registration_from",
                                        "id"			=> "registration_from",
                                        "class"			=> "form-control",
										"data-datemode"	=> "start",
                                        "size"			=> 47,
                                        "value"			=> set_value("registration_from", $registration_from)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
          
          </td>
      </tr>
		<tr>
		  <td bgcolor="#E8E8E8" class="td_bg">To</td>
		  <td bgcolor="#E8E8E8" class="td_bg">
          
          	<div class="input-group ">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
			<?php
            $specdata			= array("name"			=> "registration_to",
                                        "id"			=> "registration_to",
                                        "class"			=> "form-control",
										"data-datemode"	=> "end",
                                        "size"			=> 47,
                                        "value"			=> set_value("registration_to", $registration_to)
                                        );	
            
            echo form_input($specdata);
            ?>
            </div>
           </td>
      </tr>
		<tr>
		  <td class="td_bg">Arrival At <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		    <?php
			$specdata		= array("name"			=> "arrival_at",
									"id"			=> "arrival_at",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("arrival_at", $arrival_at ) );	

			echo form_input($specdata);
			?>
	      </div></td>
	  </tr>
		<tr>
		  <td class="td_bg">Departure From <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		    <?php
			$specdata		= array("name"			=> "departure_from",
									"id"			=> "departure_from",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("departure_from", $departure_from ) );	

			echo form_input($specdata);
			?>
	      </div></td>
	  </tr>
		<tr>
		  <td class="td_bg">Country <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
            <div class="input-group">
            	<?php echo form_dropdown('countryid', DropdownHelper::country_dropdown(), set_value("countryid", $countryid), "class='form-control '" )?>
            </div>
          </td>
	  </tr>
		<tr>
		  <td class="td_bg">Sight Seeing</td>
		  <td colspan="2" class="td_bg">
          
          	<div class="input-group targetBox_sightseeing">
            	<?php
				if ( empty( $ajax_output1 ) )
				{
				?>
					<small class="badge pull-right bg-green" style="">please select country first</small>
                <?php
				}
				else
				{
					echo $ajax_output1;	
				}
				?>
                
                <ol style="display:none;">
                    <li><input type="checkbox" /> <a>Abc</a></li>
                    <li><input type="checkbox" /> Abc</li>
                    <li><input type="checkbox" /> Abc</li>
                    <li><input type="checkbox" /> Abc</li>
                    <li><input type="checkbox" /> Abc</li>
                </ol>
            </div>
            
          	
          
          </td>
	  </tr>
		<tr>
		  <td class="td_bg">Registration Closed</td>
		  <td colspan="2" class="td_bg">
            <div class="input-group">
            	<?php echo form_dropdown('registration_closed', DropdownHelper::yesno_dropdown(), set_value("registration_closed", $registration_closed), "class='form-control '" )?>
            </div>
          </td>
	  </tr>
		<tr>
		  <td class="td_bg">Status</td>
		  <td colspan="2" class="td_bg">
          
          	<div class="input-group">
				<?php echo form_dropdown('status', DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control '" )?>
            </div>
            
            </td>
	  </tr>
	


		
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>