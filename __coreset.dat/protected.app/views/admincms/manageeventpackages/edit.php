<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
			<td class="td_bg fieldKey">Event <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("event_id", DropdownHelper::events_dropdown( FALSE, TRUE ), set_value("event_id", $event_id), "class='form-control'" );
                ?>
            </div>
            
            
            
			</td>
		</tr>
		
      
      
	  <tr>
		  <td class="td_bg">Title <?php echo required_field(); ?></td>
		  <td class="td_bg">
          <div class="input-group">
			  
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#package_title_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="package_title_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "package_title[{$lang['code']}]",
														"id"			=> "package_title[{$lang['code']}]",
														"class"			=> "form-control",
														"size"			=> "70",
														"value"			=> $lang_content[$lang['id']]['package_title'] );	

								echo form_input($specdata);
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
		<td class="td_bg fieldKey"> Seats <?php  required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="form-group">
				<div class="input-group">
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#available_seats_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="available_seats_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "available_seats[{$lang['code']}]",
														"id"			=> "available_seats[{$lang['code']}]",
														"class"			=> "form-control",
														"size"			=> "70",
														"value"			=> $lang_content[$lang['id']]['available_seats'] );	

								echo form_input($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
					</div>
				</div>
			</div>
			</td>
		</tr>
	  <tr>
		<td class="td_bg fieldKey"> Amount <?php  required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="form-group">
				<div class="input-group">
					
					<?php
					$specdata       = array("name"      => "amount",
											"id"        => "amount",
											"size"      => 45,
											"class"     => "form-control",
											"value"     => set_value("amount", $amount));  
					
					echo form_input($specdata);
					?>
				</div>
			</div>
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
			<td class="td_bg">&nbsp;</td>
			<td class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="manageeventpackagessave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="manageeventpackagesview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>
