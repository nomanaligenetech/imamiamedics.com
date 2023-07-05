<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
			<td class="td_bg fieldKey">Donation Project <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("donation_project_id", DropdownHelper::donation_projects_dropdown( FALSE, "", true ), set_value("donation_project_id", $donation_project_id), "class='form-control'" );
                ?>
            </div>
            
            
            
			</td>
		</tr>
		
      <tr>
		  <td class="td_bg">Short Description <?php echo required_field(); ?></td>
		  <td class="td_bg">
          <div class="input-group">

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
        </td>
	  </tr>
      
      
      
	  <tr>
		  <td class="td_bg">Content <?php echo required_field(); ?></td>
		  <td class="td_bg">
          <div class="input-group">

					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#content_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="content_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "content[{$lang['code']}]",
														"id"			=> "content[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['content'] );	

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
		  <td class="td_bg">Sidebar <?php echo required_field(); ?></td>
		  <td class="td_bg">
          <div class="input-group">
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#sidebar_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="sidebar_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "sidebar[{$lang['code']}]",
														"id"			=> "sidebar[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['sidebar'] );	

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
		  <td class="td_bg">Video Gallery Description <?php echo required_field(); ?></td>
		  <td class="td_bg">
          <div class="input-group">
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#gallery_text_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="gallery_text_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "gallery_text[{$lang['code']}]",
														"id"			=> "gallery_text[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['gallery_text'] );	

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
		<td class="td_bg fieldKey">Goal Amount <?php echo required_field(); ?></td>
		<td class="td_bg fieldValue" colspan="2">
		<div class="input-group">
		<?php
		$goal_amount_data = array("name"		=> "goal_amount",
								"id"		=> "goal_amount",
								"size"		=> 50,
								"class"		=> "form-control",
								"type"		=> "number",
								"min"		=> 1,
								"value"		=> set_value("goal_amount", $goal_amount) );	
		
		echo form_input($goal_amount_data);
		?>
		</div>
		<?php if(isset($amount_received)){
			echo "Amount Received: ".$amount_received;
		} ?>
		</td>
	</tr>

		<tr>
			<td class="td_bg fieldKey">Is Active <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("status", DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control'" );
                ?>
            </div>
            
            
            
			</td>
		</tr>

		<tr>
		  <td class="td_bg">International/Canada <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          
          	<div class="input-group">
				<?php echo form_dropdown('belongsto', DropdownHelper::cmsmenubelongsto_dropdown(), set_value("belongsto", $belongsto), "class='form-control '" )?>
            </div>
            
            </td>
	  </tr>

	<tr>
                <td class="td_bg">Featured Image <?php echo required_field(); ?><br />
                
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
                    <input type="file" class="btn btn-default" name="file_featured_image"/>
                    <input type="hidden" value="<?php echo set_value("featured_image", $featured_image);?>" name="featured_image" />  
                    <small><?php echo image_link("featured_image", $featured_image);?></small>
                    </div>
                </td>
            </tr>
            
            
            
            <tr>
                <td class="td_bg">Gallery Images <?php required_field(); ?><br />
                
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
                    <input type="file" class="btn btn-default" name="file_gallery_image[]" multiple />
                    <?php echo image_link("gallery_image", $gallery_image, FALSE, TRUE);?>		
                    </div>
                </td>
			</tr>
			
			<tr class="clear_border_bottom">
              <td colspan="3" class="td_bg">
              	
					<?php echo $this->load->view( "admincms/managecampaigncontent/_table_breadcrumbs.php" ) ;?>
				
              </td>
            </tr>
	


		
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managedonationcampaignssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managedonationcampaignsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>


<script language="javascript" type="text/javascript">
// window.onload = function () {
//     var fileUpload = document.getElementById("image_gallery");
//     fileUpload.onchange = function () {
//         if (typeof (FileReader) != "undefined") {
//             var dvPreview = document.getElementById("image_show");
//             dvPreview.innerHTML = "";
//             var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
//             for (var i = 0; i < fileUpload.files.length; i++) {
//                 var file = fileUpload.files[i];
//                 if (regex.test(file.name.toLowerCase())) {
//                     var reader = new FileReader();
//                     reader.onload = function (e) {
//                         var img = document.createElement("IMG");
//                         img.height = "100";
//                         img.width = "100";
//                         img.style.margin = "5px";
//                         img.src = e.target.result;
//                         dvPreview.appendChild(img);
//                     }
//                     reader.readAsDataURL(file);
//                 } else {
//                     alert(file.name + " is not a valid image file.");
//                     dvPreview.innerHTML = "";
//                     return false;
//                 }
//             }
//         } else {
//             alert("This browser does not support HTML5 FileReader.");
//         }
//     }
// };
</script>