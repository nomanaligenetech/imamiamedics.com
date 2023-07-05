<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_whichdatewillyouavail'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_whichdatewillyouavail_msg'); ?></small></label>
    <div class="input-group col-sm-12">
        <select name="available_on_date">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="September 26 - October 10"><?php echo lang_line('text_sep26tooct10'); ?></option>
        </select>
        <div class="error available_on_date"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
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
</div>
<div class="form-group col-sm-12 no-padding hideonlyhealth">
    <label><?php echo lang_line('text_whichpositionapplying'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_whichpositionapplying_msg'); ?></small></label>
    <div class="input-group col-sm-12">
        <select name="applying_position">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="Medical Staff"><?php echo lang_line('text_medicalstaff'); ?></option>
            <option value="Nursing Staff"><?php echo lang_line('text_nursingstaff'); ?></option>
            <option value="Dental Staff"><?php echo lang_line('text_dentalstaff'); ?></option>
            <option value="Pharmacy Staff"><?php echo lang_line('text_pharmacystaff'); ?></option>
            <option value="Admin (General)"><?php echo lang_line('text_adminstaff'); ?></option>
        </select>
        <div class="error applying_position"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_whydoyouwantmedicalmission'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <select name="your_intention">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="To perform ziyarat"><?php echo lang_line('text_toperformzyarat'); ?></option>
            <option value="To provide medical services to those in need"><?php echo lang_line('text_toprovideservice'); ?></option>
            <option value="To provide medical services to those in need and do ziyarat as time permits"><?php echo lang_line('text_toprovideserviceandzyarat'); ?></option>
        </select>
        <div class="error your_intention"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
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
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_whatlangcanyouspeak'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_selectallthatapply'); ?></small></label>
    <div class="input-group col-sm-8">
        <ul class="languages">
            <li><input type="checkbox" name="languages[]" value="Arabic (Fluent)" /><label><?php echo lang_line('text_arabicfluent'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="Arabic (Basic)" /><label><?php echo lang_line('text_arabicbasic'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="English (Fluent)" /><label><?php echo lang_line('text_englishfluent'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="English (Basic)" /><label><?php echo lang_line('text_englishbasic'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="Farsi" /><label><?php echo lang_line('text_farsi'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="Hindi" /><label><?php echo lang_line('text_hindi'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="Swahili" /><label><?php echo lang_line('text_swahili'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="Urdu" /><label><?php echo lang_line('text_urdu'); ?></label></li>
            <li><input type="checkbox" name="languages[]" value="Other" id="langauge-other" /><label><?php echo lang_line('text_other'); ?></label><input type="text" name="other_language" value="" style="display:none;" /></li>
        </ul>

        <div class="error languages other_language"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_cvresumeupload'); ?> <span class="required">*</span><br /><small><?php echo lang_line('text_cvresumeupload_note'); ?></small></label>
    <div class="input-group col-sm-12">
        <div class="uploader-wrap">
            <span class="remove-file">x</span>
            <span class="text"><?php echo lang_line('text_choosefileanddrag'); ?></span>
            <input type="file" name="cv_resume" id="cv_resume" />
        </div>
        <div class="error cv_resume"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_includeanyotherdetails'); ?></label>
    <div class="input-group col-sm-12">
        <textarea name="extra_information" rows="5"></textarea>
        <div class="error extra_information"></div>
    </div>
</div> 