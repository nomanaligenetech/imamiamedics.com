<table class="table table-striped table-bordered">
    <tr>
        <td>
            <strong>
                Breadcrumbs (use [BASE_URL] for <?php echo site_url();?>
            </strong>
        </td>
    </tr>
    
    <tr>
        <td>
        
            <table class="table table-striped table-bordered" width="100%" cellpadding="5" cellspacing="5">
                <thead>
                    <tr>
                      <th width="35%" style="text-align:center;">Text</th>
                      <th width="35%" style="text-align:center;">Link</th>
                      <th width="5%" style="text-align:center;">&nbsp;</th>
                      <th width="35%" style="text-align:center;">Menu</th>
                      
                      <th></th>
                    </tr>
                </thead>
                
                
                <tr class="add_menus_boxes">
                
                <td align="center">
                    <div class="input-group ">
                    <?php
                    $specdata		= array("name"			=> "breadcrumb_text[]",									
                                            "size"			=> 50,
                                            "class"			=> "form-control ",
                                            "value"			=> set_value("breadcrumb_text[]", @$breadcrumb_text[0]) 
                                            );	
                    
                    echo form_input($specdata);
                    //echo form_error("sort[0]");
                    ?>
                    </div>
                </td>
                
                <td  align="center">
                    <div class="input-group">
                        <?php
                        $specdata		= array("name"			=> "breadcrumb_link[]",									
                                                "size"			=> 50,
                                                "class"			=> "form-control ",
                                                "value"			=> set_value("breadcrumb_link[]", @$breadcrumb_link[0]) 
                                                );	
                        
                        echo form_input($specdata);
                        //echo form_error("sort[0]");
                        ?>
                    </div>
                </td>
                
                
                <td  align="center">
                    <span class="badge bg-blue" >OR</span>
                </td>
                
                
                <td  align="center">
                    <div class="input-group">
                        <?php
                        echo form_dropdown("breadcrumb_menuid[]", DropdownHelper::menu_dropdown( FALSE, FALSE ), set_value("breadcrumb_menuid", @$breadcrumb_menuid), "class='form-control' " );
                        ?>
                    </div>
                </td>
                
                
                
                
                
                
                
                <td align="left" class="columndelete">
                    <div><span style="cursor:pointer;" onclick="operation_menus_boxes_for_conference_program('remove', $(this))" class="badge bg-light-blue ">remove</span></div>
                </td>
                
                </tr>
  
  
  
				<?php
                if(isset($_POST['breadcrumb_text'][1]))
                {
                    for($key = 1 ; $key < sizeof($_POST['breadcrumb_text']);$key++)
                    {
                    ?>
                        <tr class="add_menus_boxes">
                
                            <td align="center">
                                <div class="input-group ">
                                <?php
                                $specdata		= array("name"			=> "breadcrumb_text[]",									
                                                        "size"			=> 50,
                                                        "class"			=> "form-control ",
                                                        "value"			=> set_value("breadcrumb_text[". $key ."]", @$breadcrumb_text[ $key ]) 
                                                        );	
                                
                                echo form_input($specdata);
                                //echo form_error("sort[0]");
                                ?>
                                </div>
                            </td>
                
                            <td  align="center">
                                <div class="input-group">
                                    <?php
                                    $specdata		= array("name"			=> "breadcrumb_link[]",									
                                                            "size"			=> 50,
                                                            "class"			=> "form-control ",
                                                            "value"			=> set_value("breadcrumb_link[". $key ."]", @$breadcrumb_link[ $key ]) 
                                                            );	
                                    
                                    echo form_input($specdata);
                                    //echo form_error("sort[0]");
                                    ?>
                                </div>
                            </td>
                            
                            <td  align="center">
                                <span class="badge bg-blue" >OR</span>
                            </td>
                
                            
                            <td  align="center">
                                <div class="input-group">
									<?php
                                    echo form_dropdown("breadcrumb_menuid[]", DropdownHelper::menu_dropdown( FALSE, FALSE ), set_value("breadcrumb_menuid[". $key ."]", @$breadcrumb_menuid[ $key ]), "class='form-control' " );
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