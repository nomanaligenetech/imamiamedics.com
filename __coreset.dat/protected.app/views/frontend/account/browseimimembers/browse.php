<?php 
$attributes 			= array("name"			=> "myForm",
                                "method"		=> "post",
                                "enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( uri_string()), $attributes, $unique_form);

?>    
<div class="members_sec fl_lft w_100">
    <!--Search Flter-->
    <div class="mem_filter m_bottom30 fl_lft w_100">
        <div class="ritBorTit m_bottom30">
            <h4 class="headingnewstyle1">Search Filter</h4>
        </div>


        <div class="form_sec fl_lft w_100">

            <div class="field_row w_50 p_right10">
                <label class="">By Name :</label>
                <?php
				$TMP_field		= "name";
				$specdata		= array("name"				=> $TMP_field,
										"id"				=> $TMP_field,
				
										"class"				=> "typeTwo",
										"value"				=> set_value($TMP_field) );
				
				echo form_input($specdata);
                ?>
            </div>

            <div class="field_row w_50 p_right10">
                <label class="">By Occupation :</label>
                <div id="fakeSelectContaier" class="custom_dropdown typeTwo">
                    <span class="fakeSelect"></span>
                    <?php echo form_dropdown("occupation", DropdownHelper::runtime_dropdown( $occupations_dropdown, array("key" => "id", "value" => "occupation") ), set_value("occupation"), "class='typeTwo' " ); ?>
                </div>
            </div>

            <div class="field_row w_50 p_right10">
                <label class="">By Location :</label>
                <div id="fakeSelectContaier" class="custom_dropdown typeTwo">
                    <span class="fakeSelect"></span>
                    <?php echo form_dropdown("location", DropdownHelper::runtime_dropdown( $locations_dropdown, array("key" => "id", "value" => "name") ), set_value("location"), "class='typeTwo' " ); ?>
                </div>
            </div>

            <div class="field_row w_50 p_right10">
                <label class="">Keyword Search :</label>
                <?php
				$TMP_field		= "keyword";
				$specdata		= array("name"				=> $TMP_field,
										"id"				=> $TMP_field,
				
										"class"				=> "typeTwo",
										"value"				=> set_value($TMP_field) );
				
				echo form_input($specdata);
                ?>
            </div>


            <div class="field_row w_50 p_right10">
                <a href="javascript:;" onclick="$('form[name=myForm]').submit()" class="ViewDetail_btn grey_btn">
                    Search
                </a>
            </div>
        </div>
    </div>
    <!--Search Flter-->
    <div class="datatable_template_1">


        <table id="tbl_records_serverside" class="table table-bordered table-striped" style="width:100%;">
            <thead>
                <tr>

                    <th align="left"> IMI Members </th>
                </tr>
            </thead>

            <!-- AJAX CONTENT HERE -->

            <tfoot>
            </tfoot>
        </table>
    </div>
    <?php
/*if ( $finded_users )
	{
    ?>
        <table>
        	<?php
			foreach ($finded_users -> result_array() as $fu)
			{

    ?>
                <tr>
                    <td>
                    	<!--Member-->
                        <div class="mem_single fl_lft w_100" style="display:;">
                            <div class=" w_60 disp_tc">
                                <div class="memImg ronded">
									<?php 
                                    if ( $fu['photo_image'] != "" )
                                    {
                                        echo $this->functions->imiconf_timthumb( $fu['photo_image'], 200, 200 );	
                                    }
                                    else
                                    {
                                        echo $this->functions->timthumb( "assets/frontend/images/no-image.jpg", 200, 200 );	
                                    }									
    ?>
                                </div>
                                <div class="memName"><?php echo $fu['prefix'];?> <?php echo $fu['name'];?>
                                <span class="blue"><?php echo $fu['education'];?></span>
                                <span class="blue"><?php echo $fu['occupation'];?></span>

                                </div>
                            </div>

                            <div class="memDetails w_40 disp_tc">
                                <p><span>Phone No</span><strong>&nbsp; : &nbsp;</strong><?php echo $fu['phone'];?></p>
                                <p><span>Email</span><strong>&nbsp; : &nbsp;</strong><?php echo $fu['email'];?></p>
                                <p><span>IMI Chapter</span><strong>&nbsp; : &nbsp;</strong>
								<?php 
								echo $fu['region_name'];
								if ( $fu['country_name_of_birth'] ) 
								{
									echo ' - ' . $fu['country_name_of_birth'];	
								}

								if ( $fu['place_of_birth'] )
								{
									echo ', ' . $fu['place_of_birth'];	
								}
    ?>
                                </p>
                            </div>

                            <div class="fl_lft w_100 memProLink">
                                <a class="blue_btn1 fontFam_aleoReg fl_rit m_top20" href="javascript:;">View Complete Details</a>
                            </div>
                        </div>
                    	<!--Member-->
                    </td>
                </tr>
            <?php
			}
    ?>
        </table>
    <?php
	}*/
    ?>

</div>


<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
<input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />

</form>


<?php /*

<table class="table table_form formarea">
    <tr>
        <td class="td_bg fieldKey">Name <?php echo required_field();?> </td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "name",
                                "id"				=> "name",

                                "class"				=> "form-control",
                                "value"				=> set_value("name", $name) );

        echo form_input($specdata);
?>
        </div>
        </td>
    </tr>
    <tr>
      <td class="td_bg fieldKey">Last Name <?php echo required_field();?></td>
      <td class="td_bg fieldValue"><div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "last_name",
                                "id"				=> "last_name",

                                "class"				=> "form-control",
                                "value"				=> set_value("last_name", $last_name) );

        echo form_input($specdata);
?>
      </div></td>
    </tr>
    <tr>
      <td class="td_bg fieldKey">Email <?php echo required_field();?></td>
      <td class="td_bg fieldValue"><div class="input-group col-xs-5">
        <?php
		echo set_value("email", $email);
        $specdata		= array("name"				=> "email",
                                "id"				=> "email",
                                "readonly"			=> "readonly",
                                "class"				=> "form-control",
								"type"				=> "hidden",
                                "value"				=> set_value("email", $email) );

        echo form_input($specdata);
?>
      </div></td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Enter Old Password <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_password",
                                "id"				=> "txt_password",

                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_password", "") );

        echo form_input($specdata);
?>
        </div>
        </td>
    </tr>


    <tr>
        <td class="td_bg fieldKey">Enter New Password <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_newpassword",
                                "id"				=> "txt_newpassword",

                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_newpassword") );

        echo form_input($specdata);
?>
        </div>
        </td>
    </tr>


    <tr>
        <td class="td_bg fieldKey">Confirm New Password <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_cnewpassword",
                                "id"				=> "txt_cnewpassword",

                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_cnewpassword") );

        echo form_input($specdata);
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
    <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
    <!--<a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
        <?php lang_line("text_cancel");?>
    </a>-->
</div>
*/ ?>
