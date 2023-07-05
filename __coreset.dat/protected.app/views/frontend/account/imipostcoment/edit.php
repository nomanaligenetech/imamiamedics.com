<?php 
$attributes             = array("name"          => "myForm",
                                "method"        => "post",
                                "enctype"       => "multipart/form-data");
$unique_form            = array("unique_formid" => set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( uri_string()), $attributes, $unique_form);
?>    

<!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididuon proident, sunt in culpa qui officia cmollit anim id est laborum. uis aute irure dolor in reprehenderit in voluptate velit esse cillum dolor</p>
 -->
 <div class="profileSettings fl_lft w_100">

    <div class="profileForm m_bottom30 fl_lft w_100">
        <div class="form_sec fl_lft w_100">



            <div class="field_row myLabel w_50 p_right10">
                <label class="">Select a Topic :</label>
                <div id="fakeSelectContaier" class="typeOne custom_dropdown">
                <span class="fakeSelect"></span>
                     <?php echo form_dropdown('topic', DropdownHelper::topic( set_value("forum", $id) ), 
                                            set_value("forum", $id), 
                                            "class='form-control '" )?>
                </div>
            </div>
            


            

            <div class="field_row myLabel w_50 p_right10">
                <label class="">Post Name :</label>
                <?php
                $TMP_input      = "name";
                $specdata       = array("name"              => $TMP_input,
                                        "id"                => $TMP_input,                                      
                                        "class"             => "form-control",
                                        "value"             => set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
                        
            
            <div class="fl_lft w_100 memProLink">
              <a class="blue_btn1 big fontFam_aleoReg m_top20" href="javascript:;" onclick="$('input[name=submit]').click()">
                 Add a post
             </a>
                
                <input type="submit" name="submit"  style="display:none;" />
            </div>
        </div>
    </div>

</div>




<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
<input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />

</form>