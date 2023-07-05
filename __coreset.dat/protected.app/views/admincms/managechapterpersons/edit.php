<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		

		
        
       
		
		<tr>
            <td class="td_bg fieldKey">Board <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
            	<?php echo form_dropdown("boardid[]", DropdownHelper::chapterspersons_boards_dropdown(), set_multiselect("boardid", $boardid), "class='form-control' size='10' multiple='multiple'" ); ?>
            </div>
            </td>
        </tr>
        
        
        <tr>
            <td class="td_bg fieldKey">Designation <?php echo required_field(); ?></td>
            <td class="td_bg" colspan="2">
            <div class="input-group">
            	<?php echo form_dropdown('designationid', DropdownHelper::chapterspersons_designations_dropdown(), set_value("designationid", $designationid), "class='form-control '" )?>
            </div>
            
            </td>
        </tr>
        
        <tr>
		  <td class="td_bg fieldKey">Name <?php echo required_field(); ?></td>
		  <td class="td_bg" colspan="2">
          	<div class="input-group">
			<?php
            $specdata		= array("name"		=> "name",
                                    "id"		=> "name",
									"size"		=> 50,
                                    "class"		=> "form-control",
                                    "value"		=> set_value("name", $name) );	
            
            echo form_input($specdata);
            ?>
            </div>
          
          </td>
	  </tr>

      
       <tr>
          <td class="td_bg">Biography</td>
          <td class="td_bg">
          <div class="input-group">
                    <ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#biography_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="biography_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "biography[{$lang['code']}]",
														"id"			=> "biography[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"value"			=> $lang_content[$lang['id']]['biography'] );	

								echo form_textarea($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
						
					</div>
					<!-- /.tab-content -->
            </div>
        </td>
      </tr>
      
      
      <tr>
		  <td class="td_bg fieldKey">Job Title <?php echo required_field(); ?></td>
		  <td class="td_bg" colspan="2">
          	<div class="input-group">
			<?php
            $specdata		= array("name"		=> "job_title",
                                    "id"		=> "job_title",
									"size"		=> 50,
                                    "class"		=> "form-control",
                                    "value"		=> set_value("job_title", $job_title) );	
            
            echo form_input($specdata);
            ?>
            </div>
          
          </td>
	  </tr>
      
      <tr>
		  <td class="td_bg fieldKey">Profile Link <?php echo required_field(); ?></td>
		  <td class="td_bg" colspan="2">
          	<div class="input-group">
			<?php
    $specdata = array(
        "name" => "profile_link",
        "id" => "profile_link",
        "size" => 50,
        "class" => "form-control",
        "value" => set_value("profile_link", $profile_link)
    );

    echo form_input($specdata);
    ?>
            </div>
          
          </td>
	  </tr>
      
      
      
        <tr>
            <td class="td_bg">Image <?php echo required_field(); ?><br />
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
            <td class="td_bg">Status</td>
            <td colspan="2" class="td_bg"><div class="input-group">
            	<?php echo form_dropdown('status', DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control '" )?></div>
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
        <button type="submit" data-operationid="managechapterpersonssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managechapterpersonsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>