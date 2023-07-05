<a id="hash_contactus_form" name="hash_contactus_form"></a>
<h3 class="h3Style1">Leave us a message</h3>
<?php
$attributes 			= array("method"		=> "post",
								"name"			=> "form1",
								"enctype"		=> "multipart/form-data",
                                "onsubmit"      => "submit_with_hash('form1', 'hash_contactus_form',true)");

echo form_open(site_url( uri_string() ), $attributes);
?>

<div class="form_sec fl_lft w_100">

    <div class="field_row w_50 p_right10">
		<?php
        $specdata		= array("name"			=> "name",
                                "id"			=> "name",
                                "value"			=> set_value("name"),
								"class"			=> set_class("name"),
								"placeholder"	=> "Your Name *");	
        
        echo form_input($specdata);
		echo form_error("name");
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_left10">
    	<?php
        $specdata		= array("name"			=> "email",
                                "id"			=> "email",
                                "value"			=> set_value("email"),
								"class"			=> set_class("email"),
								"placeholder"	=> "Your Email Address *");
        
        echo form_input($specdata);
		echo form_error("email");
        ?>
	</div>
    
    
    
    <div class="field_row w_50 p_right10">
    	<?php
        $specdata		= array("name"			=> "phone",
                                "id"			=> "phone",
                                "value"			=> set_value("phone"),
								"class"			=> set_class("phone"),
								"placeholder"	=> "Phone Number (optional)");
        
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
        $specdata		= array("name"			=> "country",
                                "id"			=> "country",
                                "value"			=> set_value("country"),
								"class"			=> set_class("country"),
								"placeholder"	=> "Country *");
        
        echo form_input($specdata);
		echo form_error("country");
		*/
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_right10">
    	<?php
        $specdata		= array("name"			=> "city",
                                "id"			=> "city",
                                "value"			=> set_value("city"),
								"class"			=> set_class("city"),
								"placeholder"	=> "City *");
        
        echo form_input($specdata);
		echo form_error("city");
        ?>
    </div>
    
    
    
    <div class="field_row w_50 p_left10">
    	<?php
        $specdata		= array("name"			=> "profession",
                                "id"			=> "profession",
                                "value"			=> set_value("profession"),
								"class"			=> set_class("profession"),
								"placeholder"	=> "Profession (Optional)");
        
        echo form_input($specdata);
		echo form_error("profession");
        ?>
    </div>
    
    
    
    <div class="field_row w_100">
    	<?php
        $specdata		= array("name"			=> "preciouswords",
                                "id"			=> "preciouswords",
                                "value"			=> set_value("preciouswords"),
								"class"			=> set_class("preciouswords"),
								"placeholder"	=> "Precious Words *");
        
        echo form_textarea($specdata);
		echo form_error("preciouswords");
        ?>
    </div>
    
    
    <input class="submit_btn" name="btn_contactus_form" type="submit" value="Submit Your Words" />
</div>
<?php
echo form_close();
?>