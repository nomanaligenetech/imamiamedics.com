<script>
function addItem(){
    $('input.submit_btn').attr('disabled', true);
    $('input.submit_btn').addClass('submitthis');
    grecaptcha.execute();
}
function onSubm(token){
    $("input#hiderecap").val(token);
    if($.trim(token)){
        $("input.submitthis").attr('disabled', false);
        $("input.submitthis").prop("onclick", null).off("click");
        $("input.submitthis").trigger("click");
        $("input.submitthis").attr('disabled', true);
    } else {
        $("input.submitthis").removeClass("submitthis");
    }
}
</script>
<?php
//$sitekey = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'; testing
$sitekey = '6Le_N_QUAAAAAKzKoKE3aopntNguOy7ppf7kzafV';?>
<div class="g-recaptcha" data-sitekey="<?php echo $sitekey; ?>" data-size="invisible" data-callback="onSubm"></div>
<a id="hash_contactus_form" name="hash_contactus_form"></a>
<h3 class="h3Style1"><?php echo lang_line('text_sendusamsg'); ?></h3>
<?php
$attributes             = array("method"        => "post",
                                "name"          => "form1",
                                "enctype"       => "multipart/form-data",
                                "onsubmit"      => "submit_with_hash('form1', 'hash_contactus_form',true)");

echo form_open(site_url( uri_string() ), $attributes);
?>

<div class="form_sec fl_lft w_100">

    <div class="field_row w_50 p_right10">
        <?php
        $specdata       = array("name"          => "name",
                                "id"            => "name",
                                "value"         => set_value("name"),
                                "class"         => set_class("name"),
                                "placeholder"   => lang_line('label_your_name') . "*");  
        
        echo form_input($specdata);
        echo form_error("name");
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_left10">
        <?php
        $specdata       = array("name"          => "email",
                                "id"            => "email",
                                "value"         => set_value("email"),
                                "class"         => set_class("email"),
                                "placeholder"   => lang_line('text_youremailaddress') . "*");
        
        echo form_input($specdata);
        echo form_error("email");
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_right10">
        <?php
        $specdata       = array("name"          => "phone",
                                "id"            => "phone",
                                "value"         => set_value("phone"),
                                "class"         => set_class("phone"),
                                "placeholder"   => lang_line('text_phonenooptional'));
        
        echo form_input($specdata);
        echo form_error("phone");
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_left10">
        
        <?php 
        echo form_dropdown('country', DropdownHelper::country_dropdown(), set_value("country"), "class='form-control ". set_class("country") ."'" );
        echo form_error("country");
        ?>
            
    
        <?php
        /*
        $specdata       = array("name"          => "country",
                                "id"            => "country",
                                "value"         => set_value("country"),
                                "class"         => set_class("country"),
                                "placeholder"   => "Country *");
        
        echo form_input($specdata);
        echo form_error("country");
        */
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_right10">
        <?php
        $specdata       = array("name"          => "city",
                                "id"            => "city",
                                "value"         => set_value("city"),
                                "class"         => set_class("city"),
                                "placeholder"   => lang_line('placeholder_arbaeen_form_city') ." *");
        
        echo form_input($specdata);
        echo form_error("city");
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_left10">
        <?php
        $specdata       = array("name"          => "profession",
                                "id"            => "profession",
                                "value"         => set_value("profession"),
                                "class"         => set_class("profession"),
                                "placeholder"   => lang_line('text_professionoptional'));
        
        echo form_input($specdata);
        echo form_error("profession");
        ?>
    </div>
    
    
    
    <div class="field_row w_100">
        <?php
        $specdata       = array("name"          => "preciouswords",
                                "id"            => "preciouswords",
                                "value"         => set_value("preciouswords"),
                                "class"         => set_class("preciouswords"),
                                "placeholder"   => lang_line('text_writeyourcomments') . " *");
        
        echo form_textarea($specdata);
        echo form_error("preciouswords");
        ?>
    </div>
    
    <input id="hiderecap" type="hidden" value="" name="custom_grecap">
    <div class="fl_lft w_100 text-center"><?php if(isset($_POST['name']) && trim($_POST['name'])){
        echo form_error("custom_grecap");
    } ?>
    </div>
    
    <input class="submit_btn" name="btn_contactus_form" type="submit" value="<?php echo lang_line('text_sendyouremail'); ?>" onclick="addItem(); return false;" />
</div>
<?php
echo form_close();
?>