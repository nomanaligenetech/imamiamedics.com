<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_termsofservice'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="checkbox" name="agree_terms" value="1">
        <div id="personal-covenant-liability" title="Terms of Service" style="display:none">
            <h4><?php echo lang_line('text_PERSONALCONVENANT'); ?></h4>
            <p><?php echo lang_line('text_theguidlineslistedbelow'); ?> </p>
            <ol>
                <li><?php echo lang_line('text_theguidlineslistedbelow_1'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_2'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_3'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_4'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_5'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_6'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_7'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_8'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_9'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_10'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_11'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_12'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_13'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_14'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_15'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_16'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_17'); ?></li>
            </ol>
            <p><strong><?php echo lang_line('text_signingthisapplication'); ?></strong></p>
        </div>
        <label><?php echo lang_line('text_iagreetopersonalconvenant'); ?></label>
        <div class="error agree_terms"></div>
    </div>
</div>

<div class="col-sm-12 no-padding m_bottom20">
    <label><?php echo lang_line('text_bysubmittingthisapplication'); ?> </label>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iamanactiveduespayingimimember'); ?><span class="required">*</span></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_active_paying_member" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_active_paying_member" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_active_paying_member"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iunderstandgeneralmedicalcamp'); ?> <span class="required">*</span></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_general_medical_camp" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_general_medical_camp" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_general_medical_camp"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iwillworkdiligently'); ?></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_work_diligently" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_work_diligently" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_work_diligently"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iwillworkwithprofessionalism'); ?></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_work_with_professionalism" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_work_with_professionalism" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_work_with_professionalism"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iwillworkasrequiredincluding'); ?></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_additional_shifts" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_additional_shifts" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_additional_shifts"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_icommittoadhering'); ?></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_commit_adhering_imi_governance" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_commit_adhering_imi_governance" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_commit_adhering_imi_governance"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iunderstandalldelegates'); ?></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_represent_imi_in_the_field" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_represent_imi_in_the_field" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_represent_imi_in_the_field"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iunderstandfutureactivities'); ?></label>
    </div>
    <div class="col-sm-3">
        <input type="radio" name="agree_activity_reported_to_imi" value="yes">
        <label><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input type="radio" name="agree_activity_reported_to_imi" value="no">
        <label><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_activity_reported_to_imi"></div>
</div>
<div class="form-group col-sm-12 no-padding">
    <div class="input-group col-sm-12">
        <label><?php echo lang_line('text_digitalsignatureihereby'); ?></small></label>
        <div id="signature"></div>
        <input type="hidden" name="signature" value="" />
    </div>
    <div class="error signature"></div>
</div>