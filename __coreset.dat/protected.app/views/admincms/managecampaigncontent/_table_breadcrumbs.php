<table class="table table-striped table-bordered">
    <tr>
        <td>
            <strong>
                Video Gallery
            </strong>
        </td>
    </tr>
    
    <tr>
        <td>
        
            <table class="table table-striped table-bordered" width="100%" cellpadding="5" cellspacing="5">
                <thead>
                    <tr>
                      <th width="80%" style="text-align:center;">Video (iframe)</th>
                      <th width="15%" style="text-align:center;">Video ID</th>
                      <th></th>
                    </tr>
                </thead>
                
                
                <tr class="add_menus_boxes">
                
                <td align="center">
                    <div class="input-group ">
                    <?php
                    $specdata		= array("name"			=> "video_iframe[]",									
                                            "size"			=> 200,
                                            "class"			=> "form-control ",
                                            "value"			=> set_value("video_iframe[]", @$video_iframe[0]) 
                                            );	
                    
                    echo form_input($specdata);
                    //echo form_error("sort[0]");
                    ?>
                    </div>
                </td>
                
                <td  align="center">
                    <div class="input-group">
                        <?php
                        $specdata		= array("name"			=> "video_id[]",									
                                                "size"			=> 50,
                                                "class"			=> "form-control ",
                                                "value"			=> set_value("video_id[]", @$video_id[0]) 
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
                if(isset($_POST['video_iframe'][1]))
                {
                    for($key = 1 ; $key < sizeof($_POST['video_iframe']);$key++)
                    {
                    ?>
                        <tr class="add_menus_boxes">
                
                            <td align="center">
                                <div class="input-group ">
                                <?php
                                $specdata		= array("name"			=> "video_iframe[]",									
                                                        "size"			=> 200,
                                                        "class"			=> "form-control ",
                                                        "value"			=> set_value("video_iframe[". $key ."]", @$video_iframe[ $key ]) 
                                                        );	
                                
                                echo form_input($specdata);
                                //echo form_error("sort[0]");
                                ?>
                                </div>
                            </td>
                
                            <td  align="center">
                                <div class="input-group">
                                    <?php
                                    $specdata		= array("name"			=> "video_id[]",									
                                                            "size"			=> 50,
                                                            "class"			=> "form-control ",
                                                            "value"			=> set_value("video_id[". $key ."]", @$video_id[ $key ]) 
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