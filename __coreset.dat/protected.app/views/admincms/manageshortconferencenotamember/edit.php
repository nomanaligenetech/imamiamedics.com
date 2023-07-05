<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
			<td class="td_bg fieldKey">Select Conference <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
                    echo form_dropdown("conferenceid", DropdownHelper::short_conference_dropdown(), set_value("conferenceid", $conferenceid), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
        
        
        
		<tr>
		  <td class="td_bg">Name <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
			  
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#name_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="name_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "name[{$lang['code']}]",
														"id"			=> "name[{$lang['code']}]",
														"size"			=> 50,
														"class"			=> "form-control",
														"value"			=> $lang_content[$lang['id']]['name'] );	

								echo form_input($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
						
					</div>
					<!-- /.tab-content -->

		    </div></td>
	  </tr>
		
		
	


		
		<tr>
		  <td class="td_bg">Price <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "price",
									"id"			=> "price",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("price", $price ) );	

			echo form_input($specdata);
			?>
		    </div></td>
	  </tr>
      
      
      <tr>
		  <td class="td_bg">Per <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
				<?php
                    echo form_dropdown("per", DropdownHelper::per_dropdown(), set_value("per", $per), "class='form-control'" );
                ?>
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