<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('text_termsofservice'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12 flex-center">
        <input id="terms" type="checkbox" name="agree_terms" value="1">
        <div id="personal-covenant-liability" title="Terms of Service" style="display:none">
            <h4><?php echo lang_line('text_PERSONALCONVENANT'); ?></h4>
            <p><?php echo lang_line('text_theguidlineslistedbelow'); ?> </p>
            <ol>
                <li><?php echo lang_line('text_theguidlineslistedbelow_cond_1'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_cond_2'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_cond_3'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_cond_4'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_cond_5'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_cond_6'); ?></li>
            </ol>
            <p><?php echo lang_line('text_theguidlineslistedbelow_iagree'); ?></p>
            <ol>
                <li><?php echo lang_line('text_theguidlineslistedbelow_9'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_10'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_18'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_19'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_20'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_11'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_2'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_3'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_4'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_5'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_6'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_21'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_8'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_22'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_13'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_23'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_24'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_16'); ?></li>
                <li><?php echo lang_line('text_theguidlineslistedbelow_1'); ?></li>
            </ol>
            <p><strong><?php echo lang_line('text_signingthisapplication'); ?></strong></p>
        </div>
        <label for="terms"><?php echo lang_line('text_iagreetopersonalconvenant'); ?></label>
        <div class="error agree_terms"></div>
    </div>
</div>

<!-- <div class="form-group col-sm-12 no-padding m_bottom20">
    <label><?php echo lang_line('text_bysubmittingthisapplication'); ?> </label>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iamanactiveduespayingimimember_new'); ?><span class="required">*</span></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_1" type="radio" name="agree_active_paying_member" value="yes">
        <label for="terms_yes_1"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_1" type="radio" name="agree_active_paying_member" value="no">
        <label for="terms_no_1"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_active_paying_member"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_adhereimiprotocols'); ?><span class="required">*</span></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_2" type="radio" name="agree_commit_adhering_imi_governance" value="yes">
        <label for="terms_yes_2"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_2" type="radio" name="agree_commit_adhering_imi_governance" value="no">
        <label for="terms_no_2"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_commit_adhering_imi_governance"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_agree_covid19_risk'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_3" type="radio" name="agree_covid19_risk" value="yes">
        <label for="terms_yes_3"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_3" type="radio" name="agree_covid19_risk" value="no">
        <label for="terms_no_3"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_covid19_risk"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iunderstandgeneralmedicalcamp'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_4" type="radio" name="agree_general_medical_camp" value="yes">
        <label for="terms_yes_4"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_4" type="radio" name="agree_general_medical_camp" value="no">
        <label for="terms_no_4"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_general_medical_camp"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iwillworkdiligently'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_5" type="radio" name="agree_work_diligently" value="yes">
        <label for="terms_yes_5"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_5" type="radio" name="agree_work_diligently" value="no">
        <label for="terms_no_5"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_work_diligently"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iwillworkwithprofessionalism'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_6" type="radio" name="agree_work_with_professionalism" value="yes">
        <label for="terms_yes_6"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_6" type="radio" name="agree_work_with_professionalism" value="no">
        <label for="terms_no_6"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_work_with_professionalism"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iwillworkasrequiredincluding'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_7" type="radio" name="agree_additional_shifts" value="yes">
        <label for="terms_yes_7"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_7" type="radio" name="agree_additional_shifts" value="no">
        <label for="terms_no_7"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_additional_shifts"></div>
</div> -->

<!-- <div class="form-group col-sm-12 no-padding">
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
</div> -->

<!-- <div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iunderstandalldelegates'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_8" type="radio" name="agree_represent_imi_in_the_field" value="yes">
        <label for="terms_yes_8"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_8" type="radio" name="agree_represent_imi_in_the_field" value="no">
        <label for="terms_no_8"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_represent_imi_in_the_field"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_iunderstandfutureactivities'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_9" type="radio" name="agree_activity_reported_to_imi" value="yes">
        <label for="terms_yes_9"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_9" type="radio" name="agree_activity_reported_to_imi" value="no">
        <label for="terms_no_9"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_activity_reported_to_imi"></div>
</div>

<div class="form-group col-sm-12 no-padding">
    <div class="col-sm-6 paddzERo">
        <label><?php echo lang_line('text_understand_med_camp'); ?></label>
    </div>
    <div class="col-sm-3">
        <input id="terms_yes_10" type="radio" name="agree_medical_camp" value="yes">
        <label for="terms_yes_10"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-3 paddRzERo">
        <input id="terms_no_10" type="radio" name="agree_medical_camp" value="no">
        <label for="terms_no_10"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error agree_medical_camp"></div>
</div> -->

<div class="form-group col-sm-12 no-padding">
    <div class="input-group col-sm-12">
        <label><?php echo lang_line('text_digitalsignature'); ?><span class="required">*</span><br/><small>Please check that you have completed all parts of this written application, sign & date below<br/>
        • Completed Form—including your documents & signed personal covenant & liability form.<br/>
        • Copy of your passport (must be valid for at least 6 months AFTER the travel dates)<br/>
        • Passport Size Photo<br/>
        To sign: use your mouse, trackpad or finger on touchscreen devices.</small></label>
        <div id="signature"></div>
        <div class="overlay-imi"></div>
        <input type="hidden" name="signature" value="" />
    </div>
    <div class="error signature"></div>
</div>