<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		
            
            <tr>
				<td class="td_bg fieldKey">Event / Article <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
				<?php
				echo form_dropdown('mode', DropdownHelper::eventactivities_dropdown(), set_value("mode", $mode), "class='form-control '" )
				?>
                </div>
				</td>
			</tr>

			<tr>
				<td class="td_bg fieldKey">Donation Project </td>
				<td class="td_bg fieldValue">
				<div class="input-group">
					<?php
					echo form_dropdown("don_proj_id", DropdownHelper::donation_projects_dropdown( FALSE, "", false, false, true ), set_value("don_proj_id", $don_proj_id), "class='form-control'" );
					?>
				</div>
				</td>
			</tr>
            
            
			<tr>
				<td class="td_bg fieldKey">Is An Package </td>
				<td class="td_bg fieldValue">
				<div class="input-group">
					<?php
					$data = [
						'name'    => 'is_package',
						'id'      => 'is_package',
						'value'   => 1,
						'checked' => $is_package,
					];
			
					echo form_checkbox($data);
					?>
				</div>
				</td>
			</tr>
          	<tr>
                <td class="td_bg">Sections</td>
                <td colspan="2" class="td_bg">
                
                <?php
				$TMP_widgets				= "<ol class='' style='list-style:none;'>";
				foreach ( $whatwedo_menus as $value)
				{
				 
					$TMP_input				= '	<input type="checkbox" name="sitesections_id[]" 
												value="'. $value["id"] .'" '. set_checkbox('sitesections_id[]', $value["id"], format_bool( $sitesections_id[$value["id"]], $value["id"]  )).' />';
						
					$TMP_widgets			.= "<li>". $TMP_input . "  &nbsp;&nbsp; " . $value['name'] . "</li>";
				}
				
				$TMP_widgets				.= "</out>";
				
				echo $TMP_widgets;
				?>
            	
                </td>
            </tr>
            
            
            
            
            <tr>
                <td class="td_bg">Year</td>
                <td colspan="2" class="td_bg">
                <div class="input-group">
                <?php 
				$arrayindex				= NumberHelper::number_array( range("1980", "2030") );
				$arrayindex[""]			= "Select";
				ksort( $arrayindex );
				echo form_dropdown('year', DropdownHelper::runtime_dropdown( $arrayindex ), set_value("year", $year), "class='form-control '" )
				?>
                </div>
                </td>
            </tr>
            
             <tr>
                <td class="td_bg">Month</td>
                <td colspan="2" class="td_bg">
                <div class="input-group">
                <?php 
				$arrayindex				= NumberHelper::number_array( range("1", "12") );
				$arrayindex[""]			= "Select";
				ksort( $arrayindex );
				echo form_dropdown('month', DropdownHelper::runtime_dropdown( $arrayindex ), set_value("month", $month), "class='form-control '" )
				?>
                </div>
                </td>
            </tr>

		
        	<tr>
				<td class="td_bg fieldKey">Title <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">

					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<?php foreach ($content_languages as $lang_key => $lang): ?>
								<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#title_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($content_languages as $lang_key => $lang): ?>

								<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="title_<?php echo $lang['code']; ?>">
									<div class="input-group">
									<?php
									$specdata		= array("name"			=> "title[{$lang['code']}]",
															"id"			=> "title[{$lang['code']}]",
															"size"			=> 50,
															"class"			=> "form-control",
															"value"			=> $lang_content[$lang['id']]['title'] );	

									echo form_input($specdata);
									?>
									</div>
								</div>

							<?php endforeach; ?>
							
						</div>
						<!-- /.tab-content -->
					</div>
                </div>
				</td>
			</tr>
            
            
			<tr>
			  <td class="td_bg fieldKey">Day and Date <?php  required_field(); ?></td>
			  <td class="td_bg fieldValue" colspan="2">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        
                        <?php
                        $specdata		= array("name"		=> "day_and_date",
                                                "id"		=> "day_and_date",
                                                "size"		=> 45,
                                                "class"		=> " form-control timepicker_range",
                                                "value"		=> set_value("day_and_date", $day_and_date) );	
                        
                        echo form_input($specdata);
                        ?>
                    </div>
                </div>
              </td>
	  </tr>
			<tr>
			  <td class="td_bg fieldKey">Address</td>
			  <td class="td_bg fieldValue" colspan="2">
              	<div class="input-group">
				<?php
				$specdata		= array("name"		=> "address",
										"id"		=> "address",
										"rows"		=> 3,
										"cols"		=> 70,
										"class"		=> " form-control",
										"value"		=> set_value("address", $address) );	
				
				echo form_textarea($specdata);
				?>
                </div>
              </td>
	  </tr>
			<tr>
				<td class="td_bg fieldKey">Short Description <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">

					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<?php foreach ($content_languages as $lang_key => $lang): ?>
								<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#short_desc_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($content_languages as $lang_key => $lang): ?>

								<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="short_desc_<?php echo $lang['code']; ?>">
									<div class="input-group">
									<?php
									$specdata		= array("name"			=> "short_desc[{$lang['code']}]",
															"id"			=> "short_desc[{$lang['code']}]",
															"rows"			=> 10,
															"cols"			=> 70,
															"class"			=> " form-control",
															"value"			=> $lang_content[$lang['id']]['short_desc'] );	

									echo form_textarea($specdata);
									?>
									</div>
								</div>

							<?php endforeach; ?>
							
						</div>
						<!-- /.tab-content -->
					</div>
                </div>
				</td>
			</tr>
            
            
            <tr>
				<td class="td_bg fieldKey">Full Description <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <p>&nbsp;</p>
                
                <div class="input-group">
                  <input class=" form-control"  readonly="readonly" value="[THREE_IMAGES_SLIDER]"  /> 
                	<small>ImageSlider with 3 Images (left,right faded) - Slider contains <strong>(Other Images)</strong> </small>
                </div>
                <br />
                <div class="input-group">
                  <input class="form-control"   readonly="readonly" value="[THUMBNAILS_IMAGES_SLIDER]"  /> 
                  	<small> ImageSlider with small thumbnails - Slider contains <strong>(Other Images)</strong> </small>
                </div>
                
                <br />
                
                
                
                
                <div class="input-group">

					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<?php foreach ($content_languages as $lang_key => $lang): ?>
								<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#full_desc_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($content_languages as $lang_key => $lang): ?>

								<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="full_desc_<?php echo $lang['code']; ?>">
									<div class="input-group">
									<?php
									$specdata		= array("name"			=> "full_desc[{$lang['code']}]",
															"id"			=> "full_desc[{$lang['code']}]",
															"rows"			=> 5,
															"class"			=> "ckeditor1 form-control",
															"value"			=> $lang_content[$lang['id']]['full_desc'] );	

									echo form_textarea($specdata);
									?>
									</div>
								</div>

							<?php endforeach; ?>
							
						</div>
						<!-- /.tab-content -->
					</div>
                </div>
				</td>
			</tr>


			<tr>
				<td class="td_bg fieldKey">Text For Email </td>
				<td class="td_bg fieldValue" colspan="2">
                <p>&nbsp;</p>
                
                <div class="input-group">
				<?php
				$specdata		= array("name"		=> "email_text",
										"id"		=> "email_text",
										"rows"		=> 5,
										"class"		=> "ckeditor1 form-control",
										"value"		=> set_value("email_text", $email_text) );	
				
				echo form_textarea($specdata);
				?>
                </div>
				</td>
			</tr>


    
            
            <tr>
                <td class="td_bg">Image <?php echo required_field(); ?><br />
                
                <?php
                if ( isset( $is_dimension ) )
                {
					if ( $is_dimension )
					{
					?>
						<br /><br />
						<small class="badge  bg-blue">
						<?php
						if ( $images_width )
						{
							echo 'width: ' . $images_width . '<br />';
						}
						if ( $images_height )
						{
							echo 'height: ' . $images_height;
						}
						?>
						</small>
					<?php
					}
                }
                ?>
                
                
                <!--<small class="badge  bg-blue">width: <?php #echo $images_width;?> / height: <?php #echo $images_height;?></small>-->
                </td>
                <td class="td_bg" colspan="2">
                    <div class="input-group">
                    <input type="file" class="btn btn-default" name="file_photo_image"/>
                    <input type="hidden" value="<?php echo set_value("photo_image", $photo_image);?>" name="photo_image" />  
                    <small><?php echo image_link("photo_image", $photo_image);?></small>
                    </div>
                </td>
            </tr>
            
            
            
            <tr>
                <td class="td_bg">Other Images <?php required_field(); ?><br />
                
                <small class="badge  bg-silver">select multiple files</small>
            
				<?php
                if ( isset( $is_dimension_2 ) )
                {
					if ( $is_dimension_2 )
					{
					?>
						<br /><br />
						<small class="badge  bg-blue">
						<?php
						if ( $images_width_2 )
						{
							echo 'width: ' . $images_width_2 . '<br />';
						}
						if ( $images_height_2 )
						{
							echo 'height: ' . $images_height_2;
						}
						?>
						</small>
					<?php
					}
                }
                ?>
            
            
                <!--<small class="badge  bg-blue">width: <?php #echo $images_width;?> / height: <?php #echo $images_height;?></small>-->
                </td>
                <td class="td_bg" colspan="2">
                	<div class="input-group">
                    <input type="file" class="btn btn-default" name="file_photo_other_image[]" multiple />
                    <?php echo image_link("photo_other_image", $photo_other_image, FALSE, TRUE);?>		
                    </div>
                </td>
            </tr>
            
            
            <tr>
              <td class="td_bg">Status</td>
              <td colspan="2" class="td_bg"><div class="input-group">
              <?php echo form_dropdown('status', DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control '" )?></div>
              </td>
          </tr>
		
		  <tr>
		  <td class="td_bg">International/Canada <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          
          	<div class="input-group">
				<?php 
				$get_role_id 					= $this->functions->_admincms_logged_in_details( "roleid" ); 
				
				$get_belongsto 					= $this->functions->_admincms_logged_in_details( "belongs_country" );
				

				 /****  Admin and Super Admins IDs 
				 * 	Admin 					= 1
				 * 	Super Admin 			= 4
				 ******/
				
				if($get_role_id == 1 || $get_role_id == 4){ // check if admin or super admin
					$Temp_value = DropdownHelper::cmsmenubelongsto_dropdown();
				}else{

					$explode = explode(',',$get_belongsto);
					foreach ($explode as $key => $value) {
						$Temp_value[$value] = DropdownHelper::cmsmenubelongsto_dropdown(false,$value);
					}

			
				}

				echo form_dropdown('belongsto', $Temp_value, set_value("belongsto", $belongsto), "class='form-control '" )?>
            </div>
            
            </td>
	  </tr>
		
		
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
			</td>
		</tr>
		<tr>
		  <td class="td_bg">&nbsp;</td>
		  <td colspan="2" class="td_bg"></td>
	  </tr>
		<tr>
		  <td colspan="3" class="td_bg">
          <table class="table table-striped table-bordered">
                	<tr>
                        <td><strong>
                        Inner Page Widgets Information
                        </strong></td>
                    </tr>
                    
                    <tr>
                        <td>
                        	<?php echo $this->load->view( "admincms/managecmscontent/_table_widget.php" ) ;?>
                        </td>
                    </tr>
                </table>
          </td>
	  </tr>
		<tr>
		  <td colspan="3" class="td_bg">&nbsp;</td>
	  </tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managesitesectionswidgetssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managesitesectionswidgetsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>
