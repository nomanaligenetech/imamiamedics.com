<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		
            
            
            
        
		
        	<tr>
				<td width="241" class="td_bg fieldKey">Title <?php echo required_field(); ?></td>
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
                                  "size"    => 70,
                                  "class"			=> " form-control",
                                  "value"			=> $lang_content[$lang['id']]['title'] );	

                      echo form_input($specdata);
                      ?>
                      </div>
                    </div>

                    <?php endforeach; ?>

                  </div>

              </div>
				</td>
			</tr>
            
            
            
              <tr>
				<td class="td_bg fieldKey">Country <?php echo required_field(); ?></td>
				<td width="188" class="td_bg ">
                <div class="input-group">
					<?php echo form_dropdown('countryid', DropdownHelper::country_dropdown(), set_value("countryid", $countryid), "class='form-control '" )?>
                </div>
                
				</td>
                
				<td width="226" align="left" class="td_bg fieldValue">
                	<div class="badge bg-green">
                    	<?php #var_dump( set_value("show_map_with_title", $show_map_with_title) );die;?>
						<?php echo form_checkbox(	"show_map_with_title", 1, set_checkbox("show_map_with_title", 1, format_bool( $show_map_with_title, 1 ) ) );?>
                        Show Map With Title
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

    <?php 
    if(!empty($id)):
    if(!getChapterId($countryid,$id)):?>
      <tr>
				<td class="td_bg fieldKey">Do you want this country to belongs </td>
				<td class="td_bg fieldValue" colspan="2">
            <?php
            echo form_checkbox(	"add_belongs_country", 1, set_checkbox("add_belongs_country", 1, format_bool( $add_belongs_country, 1 ) ) );?>

				</td>
			</tr>
            
    <?php endif;
  endif;?>        
  <tr <?php echo (!empty($id) && getChapterId($countryid,$id)) || $is_separate ? '': 'hidden'?> class="paypal-account">
				<td class="td_bg fieldKey">Do you want to set separate paypal account</td>
				<td class="td_bg fieldValue" colspan="2">
            <?php echo form_checkbox(	"is_separate", 1, set_checkbox("is_separate", 1, format_bool( $is_separate, 1 ) ) );?>
				</td>
			</tr>
      <tr  <?php echo  $is_separate ? '': 'hidden'?>  class="paypal-account-details">
				<td class="td_bg fieldKey">Live Paypal Email</td>
				<td class="td_bg fieldValue" colspan="2">
         	<?php echo form_input( array("name" => "paypal_email", "value" => $paypal_email,"class"=>'form-control' ) )?>
				</td>
			</tr>
      <?php if($paypal_setting_id ): ?>
        <input type="hidden" name="paypal_setting_id" value="<?php echo set_value('paypal_setting_id', $paypal_setting_id); ?>" />
      <?php endif;?>
      <tr  <?php echo  $is_separate ? '': 'hidden'?>  class="paypal-account-details">
				<td class="td_bg fieldKey">Paypal Currency</td>
				<td class="td_bg fieldValue" colspan="2">
            	<?php echo form_dropdown('currency_id', DropdownHelper::currency_dropdown(), set_value("currency_id", $currency_id), "class='form-control '" )?>
				</td>
			</tr>
            <tr>
				<td class="td_bg fieldKey">Full Description <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <p>&nbsp;</p>
                <small><strong>[CHAPTER_THIS_LOCATION]</strong> = Detail box about this location</small><br />
                <small><strong>[WHERE_WE_WORK_WORLD_MAP]</strong> = World Map (with Markers - lat/lon)</small>
                <p>&nbsp;</p>
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
            
            
            <tr class="">
              <td class="td_bg">Status</td>
              <td colspan="2" class="td_bg">
              <div class="input-group">
              	<?php echo form_dropdown('status', DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control '" )?>
              </div>
              </td>
          </tr>


    
            
            
            
            
            <tr class="">
              <td colspan="3" class="td_bg">&nbsp;</td>
            </tr>
            <tr class="clear_border_bottom">
              <td colspan="3" class="td_bg">&nbsp;</td>
            </tr>
            <tr class="clear_border_bottom">
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
            
            
            <tr class="clear_border_bottom">
              <td colspan="3" class="td_bg">
              	
					<?php echo $this->load->view( "admincms/managecmscontent/_table_breadcrumbs.php" ) ;?>
				
              </td>
            </tr>
            
            
            <tr class="clear_border_bottom">
              <td class="td_bg">&nbsp;</td>
              <td colspan="2" class="td_bg">&nbsp;</td>
            </tr>
            
		
		
		
        <tr class="clear_border_bottom">
	          <td class="td_bg">&nbsp;</td>
	          <td colspan="2" class="td_bg"></td>
      </tr>
        <tr class="clear_border_bottom">
		      <td class="td_bg">&nbsp;</td>
		      <td colspan="2" class="td_bg"></td>
      </tr>
	    <tr class="clear_border_bottom">
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
			</td>
		</tr>
        <tr>
          <td colspan="3" class="td_bg">
          <table class="table table-striped table-bordered" width="100%" cellpadding="5" cellspacing="5">
                  <thead>
                    <tr>
                      <th width="25%" style="text-align:center;">Address</th>
                      <th width="25%" style="text-align:center;">Tel</th>
                      <th width="25%" style="text-align:center;">Mobile</th>
                      <th width="25%" style="text-align:center;">Website</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tr class="add_menus_boxes">
                  
                    <td align="center">
                        <div class="input-group ">
                        <?php
                        $specdata		= array("name"			=> "chapter_address[]",									
                                                "size"			=> 50,
                                                "class"			=> "form-control ",
                                                "value"			=> set_value("chapter_address[]", @$chapter_address[0]) 
                                                );	
                        
                        echo form_input($specdata);
                        //echo form_error("sort[0]");
                        ?>
                        </div>
                    </td>
                    
                    <td  align="center">
                        <div class="input-group">
                            <?php
                            $specdata		= array("name"			=> "chapter_tel[]",									
                                                    "size"			=> 50,
                                                    "class"			=> "form-control ",
                                                    "value"			=> set_value("chapter_tel[]", @$chapter_tel[0]) 
                                                    );	
                            
                            echo form_input($specdata);
                            //echo form_error("sort[0]");
                            ?>
                        </div>
                    </td>
                    
                    
                    <td  align="center">
                        <div class="input-group">
                            <?php
                            $specdata		= array("name"			=> "chapter_mobile[]",									
                                                    "size"			=> 50,
                                                    "class"			=> "form-control ",
                                                    "value"			=> set_value("chapter_mobile[]", @$chapter_mobile[0]) 
                                                    );	
                            
                            echo form_input($specdata);
                            //echo form_error("sort[0]");
                            ?>
                        </div>
                    </td>
                    
                    
                    <td  align="center">
                        <div class="input-group">
                            <?php
                            $specdata		= array("name"			=> "chapter_website[]",									
                                                    "size"			=> 50,
                                                    "class"			=> "form-control ",
                                                    "value"			=> set_value("chapter_website[]", @$chapter_website[0]) 
                                                    );	
                            
                            echo form_input($specdata);
                            //echo form_error("sort[0]");
                            ?>
                        </div>
                    </td>
                    
                    
                    
                    
                    <td align="left" class="columndelete">
                        <div><span style="cursor:pointer;" onclick="operation_menus_boxes_for_conference_program('remove', $(this))" class="badge bg-light-blue ">remove</span></div>
                    </td>
                    
                  </tr>
                  
                  
                  
                  <?php
                    if(isset($_POST['chapter_address'][1]))
                    {
                        for($key = 1 ; $key < sizeof($_POST['chapter_address']);$key++)
                        {
                        ?>
                            <tr class="add_menus_boxes">
                  
                                <td align="center">
                                    <div class="input-group ">
                                    <?php
                                    $specdata		= array("name"			=> "chapter_address[]",									
                                                            "size"			=> 50,
                                                            "class"			=> "form-control ",
                                                            "value"			=> set_value("chapter_address[". $key ."]", @$chapter_address[ $key ]) 
                                                            );	
                                    
                                    echo form_input($specdata);
                                    //echo form_error("sort[0]");
                                    ?>
                                    </div>
                                </td>
                    
                                <td  align="center">
                                    <div class="input-group">
                                        <?php
                                        $specdata		= array("name"			=> "chapter_tel[]",									
                                                                "size"			=> 50,
                                                                "class"			=> "form-control ",
                                                                "value"			=> set_value("chapter_tel[". $key ."]", @$chapter_tel[ $key ]) 
                                                                );	
                                        
                                        echo form_input($specdata);
                                        //echo form_error("sort[0]");
                                        ?>
                                    </div>
                                </td>
                                
                                
                                
                                <td  align="center">
                                    <div class="input-group">
                                        <?php
                                        $specdata		= array("name"			=> "chapter_mobile[]",									
                                                                "size"			=> 50,
                                                                "class"			=> "form-control ",
                                                                "value"			=> set_value("chapter_mobile[". $key ."]", @$chapter_mobile[ $key ]) 
                                                                );	
                                        
                                        echo form_input($specdata);
                                        //echo form_error("sort[0]");
                                        ?>
                                    </div>
                                </td>
                    
                    
                    
                    
                                <td align="center">
                                    <div class="input-group">
                                    <?php
                                    $specdata			= array("name"			=> "chapter_website[]",									
                                                                "size"			=> 50,
                                                                "class"			=> "form-control " ,
                                                                "value"			=> set_value("chapter_website[". $key ."]", @$chapter_website[ $key ]) 
                                                                );	
                                    
                                    echo form_input($specdata);
                                    //echo form_error("sort[0]");
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
        <button type="submit" data-operationid="managechapterlocationsave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managechapterlocationview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>