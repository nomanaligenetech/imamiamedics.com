<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		
            
           
            

		
        	<tr>
				<td class="td_bg fieldKey">Title <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">

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
				</td>
			</tr>
            
            
			<tr>
				<td class="td_bg fieldKey">Short Description <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
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
														"class"			=> "ckeditor1 form-control",
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
				<td class="td_bg fieldKey">Full Description <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                
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
														"rows"			=> 10,
														"cols"			=> 70,
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
			</td>
		</tr>
		<tr>
		  <td colspan="3" class="td_bg">
          <table class="table table-striped table-bordered" width="100%" cellpadding="5" cellspacing="5">
                  <thead>
                    <tr>
                      <th width="20%" style="text-align:center;">Title</th>
                      <th width="20%" style="text-align:center;">Address</th>
                      <th width="20%" style="text-align:center;">Country</th>
                      <th width="20%" style="text-align:center;">Latitude</th>
                      <th width="20%" style="text-align:center;">Longtitude</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tr class="add_menus_boxes">
                  
                    <td align="center">
                        <div class="input-group ">
                        <?php
                        $specdata		= array("name"			=> "map_title[]",									
                                                "size"			=> 50,
                                                "class"			=> "form-control ",
                                                "value"			=> set_value("map_title[]", @$map_title[0]) 
                                                );	
                        
                        echo form_input($specdata);
                        //echo form_error("sort[0]");
                        ?>
                        </div>
                    </td>
                    
                    <td  align="center">
                        <div class="input-group">
                            <?php
                            $specdata		= array("name"			=> "map_address[]",									
                                                    "size"			=> 50,
                                                    "class"			=> "form-control ",
                                                    "value"			=> set_value("map_address[]", @$map_address[0]) 
                                                    );	
                            
                            echo form_input($specdata);
                            //echo form_error("sort[0]");
                            ?>
                        </div>
                    </td>
                    
                    
                    <td  align="center">
                        <div class="input-group">
                            <?php
                            $specdata		= array("name"			=> "map_country[]",									
                                                    "size"			=> 50,
                                                    "class"			=> "form-control ",
                                                    "value"			=> set_value("map_country[]", @$map_country[0]) 
                                                    );	
                            
                            echo form_input($specdata);
                            //echo form_error("sort[0]");
                            ?>
                        </div>
                    </td>
                    
                    
                    <td  align="center">
                        <div class="input-group">
                            <?php
                            $specdata		= array("name"			=> "map_lat[]",									
                                                    "size"			=> 50,
                                                    "class"			=> "form-control ",
                                                    "value"			=> set_value("map_lat[]", @$map_lat[0]) 
                                                    );	
                            
                            echo form_input($specdata);
                            //echo form_error("sort[0]");
                            ?>
                        </div>
                    </td>
                    
                    
                    <td align="center">
                        <div class="input-group">
                        <?php
                        $specdata		= array("name"			=> "map_lon[]",									
                                                "size"			=> 50,
                                                "class"			=> "form-control ",
                                                "value"			=> set_value("map_lon[]", @$map_lon[0]) 
                                                );	
                        
                        echo form_input($specdata);
                        //echo form_error("sort[0]");
                        ?>
                        </div>
                    </td>

                    <td align="center">
                        <div class="input-group">
                        <?php
                        echo form_dropdown("chapter_link[]", DropdownHelper::chapter_locations_dropdown(), set_value("chapter_link[]", @$chapter_link[0]), "class='form-control' ");
                        ?>
                        </div>
                    </td>
                    
                    <td align="left" class="columndelete">
                        <div><span style="cursor:pointer;" onclick="operation_menus_boxes_for_conference_program('remove', $(this))" class="badge bg-light-blue ">remove</span></div>
                    </td>
                    
                  </tr>
                  
                  
                  
                  <?php
                    if(isset($_POST['map_title'][1]))
                    {
                        for($key = 1 ; $key < sizeof($_POST['map_title']);$key++)
                        {
                        ?>
                            <tr class="add_menus_boxes">
                  
                                <td align="center">
                                    <div class="input-group ">
                                    <?php
                                    $specdata		= array("name"			=> "map_title[]",									
                                                            "size"			=> 50,
                                                            "class"			=> "form-control ",
                                                            "value"			=> set_value("map_title[". $key ."]", @$map_title[ $key ]) 
                                                            );	
                                    
                                    echo form_input($specdata);
                                    //echo form_error("sort[0]");
                                    ?>
                                    </div>
                                </td>
                    
                                <td  align="center">
                                    <div class="input-group">
                                        <?php
                                        $specdata		= array("name"			=> "map_address[]",									
                                                                "size"			=> 50,
                                                                "class"			=> "form-control ",
                                                                "value"			=> set_value("map_address[". $key ."]", @$map_address[ $key ]) 
                                                                );	
                                        
                                        echo form_input($specdata);
                                        //echo form_error("sort[0]");
                                        ?>
                                    </div>
                                </td>
                                
                                
                                
                                <td  align="center">
                                    <div class="input-group">
                                        <?php
                                        $specdata		= array("name"			=> "map_country[]",									
                                                                "size"			=> 50,
                                                                "class"			=> "form-control ",
                                                                "value"			=> set_value("map_country[". $key ."]", @$map_country[ $key ]) 
                                                                );	
                                        
                                        echo form_input($specdata);
                                        //echo form_error("sort[0]");
                                        ?>
                                    </div>
                                </td>
                    
                    
                                <td  align="center">
                                    <div class="input-group">
                                        <?php
                                        $specdata		= array("name"			=> "map_lat[]",									
                                                                "size"			=> 50,
                                                                "class"			=> "form-control ",
                                                                "value"			=> set_value("map_lat[". $key ."]", @$map_lat[ $key ]) 
                                                                );	
                                        
                                        echo form_input($specdata);
                                        //echo form_error("sort[0]");
                                        ?>
                                    </div>
                                </td>
                    
                    
                                <td align="center">
                                    <div class="input-group">
                                    <?php
                                    $specdata		= array("name"			=> "map_lon[]",									
                                                            "size"			=> 50,
                                                            "class"			=> "form-control " ,
                                                            "value"			=> set_value("map_lon[". $key ."]", @$map_lon[ $key ]) 
                                                            );	
                                    
                                    echo form_input($specdata);
                                    //echo form_error("sort[0]");
                                    ?>
                                    </div>
                                </td>
                                
                                <td align="center">
                                    <div class="input-group">
                                    <?php
                                    echo form_dropdown("chapter_link[]", DropdownHelper::chapter_locations_dropdown(), set_value("chapter_link[". $key ."]", @$chapter_link[ $key ]), "class='form-control' ");
                                    ?>
                                    </div>
                                </td>
                    
                                <td align="left" class="columndelete">
                                    <div><span style="cursor:pointer;" onclick="operation_menus_boxes_for_conference_program('remove', $(this))" class="badge bg-light-blue ">remove</span></div>
                                </td>
                    
                  		</tr>
                        
                        <?php
                        }
                    }
                  
                  ?>
                  
                  
                  <tr id="add_more">
                    <td colspan="5" class="td_bg" align="right">
                    <a onclick="operation_menus_boxes_for_conference_program('add', $(this));" class="btn-sm bg-navy btn-flat margin" href="javascript:;">Add more </a>
                    </td>
                  </tr>
                </table>
          </td>
	  </tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managewhereweworksave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managewhereweworkview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>