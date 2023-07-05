<h4>Passport Details</h4>
<div class="form-group col-sm-12 no-padding imi_form date-input-sty">
    <div class="input-group col-sm-12 ">
        <div class="col-sm-6 t-input-f">
            <label class="t-text-bold"><?php echo lang_line('label_arbaeen_form_citizenship'); ?> <span class="required">*</span></label>
            <input type="text" name="citizenship" value="" />
            <div class="error citizenship"></div>
        </div>
        <div class="input-group col-sm-6 date-time-imi t-input-f">
            <label class="t-text-bold"><?php echo lang_line('label_arbaeen_form_DOB'); ?> <span class="required">*</span></label>
            <input type="text" name="birth_date" value="" class="birthdate_datepicker" placeholder="<?php echo "YYYY-MM-DD"; ?>"/>
            <div class="error birth_date"></div>
        </div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form date-input-sty">
    <div class="input-group col-sm-12 ">
        <div class="col-sm-6 t-input-f">
            <label class="t-text-bold"><?php echo lang_line('text_passportno'); ?> <span class="required">*</span></label>
            <input type="text" name="passportno" value="" />
            <div class="error passportno"></div>
        </div>
        <div class="input-group col-sm-6 date-time-imi t-input-f">
            <label class="t-text-bold"><?php echo lang_line('text_dateofexpiry'); ?> <span class="required">*</span></label>
            <input type="text" name="passport_expiry" value="" class="passport_expiry_datepicker" placeholder="<?php echo "YYYY-MM-DD"; ?>"/>
            <div class="error passport_expiry"></div>
        </div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form imi-drag-input">
    <div class="input-group col-sm-12">
        <div class="col-sm-6 t-input-f">
            <label><?php echo lang_line('text_passportcopyupload'); ?> <span class="required">*</span><br><small>Please upload a color copy of your passport as a JPEG, PNG, .GIF or JPG file. Your passport must be valid for at least 6 months AFTER the travel dates.</small></label>
            <div class="uploader-wrap">
                <span class="remove-file">x</span>
                <span class="text"><?php echo lang_line('text_choosefileanddrag'); ?></span>
                <input type="file" name="passport_copy" id="passport_copy" />
            </div>
            <div class="error passport_copy"></div>
        </div>
        <div class="input-group col-sm-6 imi-input-group date-time-imi">
            <label><?php echo lang_line('text_passportsizephotoupload'); ?> <span class="required">*</span><br><small>Please upload a color, passport size photograph as an image file here. Please use an image that meets basic international requirements (white wall behind you, front-facing etc.)</small><br><small>This image will also be used for your ID cards. As such women are required to submit images with head-coverings.</small></label>
            <div class="uploader-wrap">
                <span class="remove-file">x</span>
                <span class="text"><?php echo lang_line('text_choosefileanddrag'); ?></span>
                <input type="file" name="passport_pic" id="passport_pic" />
            </div>
            <div class="error passport_pic"></div>
        </div>
    </div>
</div>
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <div class="col-sm-12 paddzERo">
        <label><?php echo lang_line('text_willyouavailforadverdates'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_willyouavailforadverdates_msg'); ?></small></label>
    </div>
    <div class="input-group col-sm-12 flex-center">
        <input id="r_yes_aondate" type="radio" name="available_on_date" value="Yes, I will be available for the entire duration September 19 to October 1, 2021">
        <label for="r_yes_aondate"><?php echo "Yes, I will be available for the entire duration September 19 to October 1, 2021";//lang_line('text_pleaseselect'); ?></label>
    </div>
    <div class="input-group col-sm-12 flex-center paddRzERo">
        <input id="r_no_aondate" type="radio" name="available_on_date" value="No, I will not be available for the entire duration September 19 to October 1, 2021">
        <label for="r_no_aondate"><?php echo "No, I will not be available for the entire duration September 19 to October 1, 2021";//lang_line('text_sep26tooct10'); ?></label>
    </div>
    <div class="error available_on_date"></div>
</div> -->
<!--<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_whichactivityapplying'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <select name="activities_applying_for">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="To serve as an IMI Delegate at the camps"><?php echo lang_line('text_toserveasanimidelegate'); ?></option>
            <option value="To serve as international faculty for the IMI Arbaeen Health Conference" data-value="only-health"><?php echo lang_line('text_toserveasanintfaculty'); ?></option>
            <option value="To serves as an IMI Delegate at the camps AND to serve as international faculty for the IMI Arbaeen Health Conference"><?php echo lang_line('text_toserveasanimidelegateatcamps'); ?></option>
        </select>
        <div class="error activities_applying_for"></div>
    </div>
</div>-->
<!-- <div class="form-group col-sm-12 no-padding hideonlyhealth imi_form">
    <label><?php echo lang_line('text_whichpositionapplying_new'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_whichdatewillyouavail_msg'); ?></small></label>
    <div class="input-group col-sm-12">
        <select name="applying_position">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="Medical Staff"><?php echo lang_line('text_medicalstaff'); ?></option>
            <option value="Nursing Staff"><?php echo lang_line('text_nursingstaff'); ?></option>
            <option value="Dental Staff"><?php echo lang_line('text_dentalstaff'); ?></option>
            <option value="Pharmacy Staff"><?php echo lang_line('text_pharmacystaff'); ?></option>
            <option value="Admin (non-health professionals & students)"><?php echo lang_line('text_adminstaff_new'); ?></option>
        </select>
        <div class="error applying_position"></div>
    </div>
</div> -->
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <div class="col-sm-12 paddzERo">
        <label><?php echo lang_line('text_whydoyouwantmedicalmission'); ?> <span class="required">*</span></label>
    </div>
    <div class="input-group col-sm-12 flex-center">
        <input id="r_yi_1" type="radio" name="your_intention" value="To perform ziyarat">
        <label for="r_yi_1"><?php echo lang_line('text_toperformzyarat'); ?></label>
    </div>
    <div class="input-group col-sm-12 flex-center">
        <input id="r_yi_2" type="radio" name="your_intention" value="To provide medical services to those in need">
        <label for="r_yi_2"><?php echo lang_line('text_toprovideservice'); ?></label>
    </div>
    <div class="input-group col-sm-12 flex-center paddRzERo">
        <input id="r_yi_3" type="radio" name="your_intention" value="To provide medical services to those in need and do ziyarat as time permits">
        <label for="r_yi_3"><?php echo lang_line('text_toprovideserviceandzyarat'); ?></label>
    </div>
    <div class="error your_intention"></div>
</div> -->
<!-- <div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_interestedstayingwithfamily'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <select name="stay_with_family">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="No, I will be coming alone and staying with the group without any adjustments"><?php echo lang_line('text_noiwillbecomingalone'); ?></option>
            <option value="Yes, I prefer to come and stay with my family living in Karbala and Najaf"><?php echo lang_line('text_yesipreferwithfamily'); ?></option>
            <option value="Yes, I will come alone to serve but would like to stay in a hotel with my family that would come for ziyarat separately"><?php echo lang_line('text_yesiwillcomealone'); ?></option>
        </select>
        <div class="error stay_with_family"></div>
    </div>
</div> -->
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('text_whatlangcanyouspeak'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_selectallthatapply'); ?></small></label>
    <div class="input-group col-sm-8">
        <ul class="languages">
            <li><input id="c_l_1" type="checkbox" name="languages[]" value="Arabic (Fluent)" /><label for="c_l_1"><?php echo lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_l_2" type="checkbox" name="languages[]" value="Arabic (Basic)" /><label for="c_l_2"><?php echo lang_line('text_arabicbasic'); ?></label></li>
            <li><input id="c_l_3" type="checkbox" name="languages[]" value="English (Fluent)" /><label for="c_l_3"><?php echo lang_line('text_englishfluent'); ?></label></li>
            <li><input id="c_l_4" type="checkbox" name="languages[]" value="English (Basic)" /><label for="c_l_4"><?php echo lang_line('text_englishbasic'); ?></label></li>
            <li><input id="c_l_5" type="checkbox" name="languages[]" value="Farsi" /><label for="c_l_5"><?php echo lang_line('text_farsi'); ?></label></li>
            <li><input id="c_l_6" type="checkbox" name="languages[]" value="Hindi" /><label for="c_l_6"><?php echo lang_line('text_hindi'); ?></label></li>
            <li><input id="c_l_7" type="checkbox" name="languages[]" value="Swahili" /><label for="c_l_7"><?php echo lang_line('text_swahili'); ?></label></li>
            <li><input id="c_l_8" type="checkbox" name="languages[]" value="Urdu" /><label for="c_l_8"><?php echo lang_line('text_urdu'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="Other" id="langauge-other" /><label for="langauge-other"><?php echo lang_line('text_other'); ?></label><input type="text" name="other_language" value="" style="display:none;" /></li>
        </ul>
        <div class="error languages other_language"></div>
    </div>
</div> -->
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('text_cvresumeupload'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_cvresumeupload_note'); ?></small></label>
    <div class="input-group col-sm-12">
        <div class="uploader-wrap">
            <span class="remove-file">x</span>
            <span class="text"><?php echo lang_line('text_choosefileanddrag'); ?></span>
            <input type="file" name="cv_resume" id="cv_resume" />
        </div>
        <div class="error cv_resume"></div>
    </div>
</div> -->
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('text_includeanyotherdetails_new'); ?></label>
    <div class="input-group col-sm-12">
        <textarea name="extra_information" rows="5"></textarea>
        <div class="error extra_information"></div>
    </div>
</div>  -->