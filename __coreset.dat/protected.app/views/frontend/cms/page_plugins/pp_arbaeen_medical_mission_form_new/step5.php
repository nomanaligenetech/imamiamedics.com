<h4>Health Information</h4>
<!-- <p>Please answer the following mandatory health questions. Please note: all information that you provide here will be kept confidential and used solely by IMI's Annual Arbaeen Medical Mission for your selection and participation. If you have any questions about the use/confidentiality of this information, you may email SakinaRizviIMI@gmail.com.</p> -->
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_how_old'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <select name="how_old">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="45 years and younger"><?php echo "45 years and younger"//lang_line('text_sep26tooct10'); ?></option>
            <option value="46 - 50 years"><?php echo "46 - 50 years"//lang_line('text_sep26tooct10'); ?></option>
            <option value="51 - 55 years"><?php echo "51 - 55 years"//lang_line('text_sep26tooct10'); ?></option>
            <option value="56 - 60 years"><?php echo "56 - 60 years"//lang_line('text_sep26tooct10'); ?></option>
            <option value="61 - 65 years"><?php echo "61 - 65 years"//lang_line('text_sep26tooct10'); ?></option>
            <option value="66 - 70 years"><?php echo "66 - 70 years"//lang_line('text_sep26tooct10'); ?></option>
            <option value="71 years and older"><?php echo "71 years and older"//lang_line('text_sep26tooct10'); ?></option>
        </select>
        <div class="error how_old"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <div class="col-sm-12 paddzERo">
        <label><?php echo lang_line('label_arbaeen_form_know_bmi'); ?><span class="required">*</span></label>
    </div>
    <div class="col-sm-6">
        <input id="r_yes_1" type="radio" name="know_bmi" value="yes">
        <label for="r_yes_1"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-6 paddRzERo">
        <input id="r_no_1" type="radio" name="know_bmi" value="no" data-value="showchart">
        <label for="r_no_1"><?php echo lang_line('text_no'); ?>, please show BMI Chart</label>
    </div>
    <div class="error know_bmi"></div>
</div>
<div class="form-group col-sm-12 no-padding showchart imi_form" style="display: none;">
    <img src="<?php echo base_url('assets/frontend/images/bmichart.jpg'); ?>" class='bmi-chart' />
</div> -->
<!-- <div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_bmi'); ?> <span class="required">*</span><br /><small>Please select the appropriate range for your current BMI. (If you don't know your BMI, please select Show BMI Chart above to estimate yours)</small></label>
    <div class="input-group col-sm-12">
        <select name="bmi">
            <option value=""><?php echo lang_line('text_pleaseselect'); ?></option>
            <option value="under 20"><?php echo "under 20";//lang_line('text_toserveasanimidelegate'); ?></option>
            <option value="20 - 24.9"><?php echo "20 - 24.9";//lang_line('text_toserveasanintfaculty'); ?></option>
            <option value="25 - 29.9"><?php echo "25 - 29.9";//lang_line('text_toserveasanimidelegateatcamps'); ?></option>
            <option value="30 - 34.9"><?php echo "30 - 34.9";//lang_line('text_toserveasanimidelegate'); ?></option>
            <option value="35 - 39.9"><?php echo "35 - 39.9";//lang_line('text_toserveasanintfaculty'); ?></option>
            <option value="40 or higher"><?php echo "40 or higher";//lang_line('text_toserveasanimidelegateatcamps'); ?></option>
        </select>
        <div class="error bmi"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <div class="col-sm-12 paddzERo">
        <label><?php echo lang_line('label_arbaeen_form_smoking_hist'); ?> <span class="required">*</span></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_sh_1" type="radio" name="smoking_hist" value="I do not smoke, nor have ever smoked in the past">
        <label for="r_sh_1"><?php echo "I do not smoke, nor have ever smoked in the past";//lang_line('text_medicalstaff'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_sh_2" type="radio" name="smoking_hist" value="I am a former smoker">
        <label for="r_sh_2"><?php echo "I am a former smoker";//lang_line('text_nursingstaff'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_sh_3" type="radio" name="smoking_hist" value='I am a current smoker'>
        <label for="r_sh_3"><?php echo "I am a current smoker";//lang_line('text_dentalstaff'); ?></label>
    </div>
    <div class="error smoking_hist"></div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <div class="col-sm-12 paddzERo">
        <label><?php echo lang_line('label_arbaeen_form_med_his'); ?> <span class="required">*</span></label>
    </div>
    <div class="col-sm-6">
        <input id="r_yes_2" type="radio" name="med_his" value="yes" data-value="showdetails">
        <label for="r_yes_2"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-6 paddRzERo">
        <input id="r_no_2" type="radio" name="med_his" value="no">
        <label for="r_no_2"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error med_his"></div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <div class="col-sm-12 paddzERo">
        <label><?php echo lang_line('label_arbaeen_form_med_curr'); ?> <span class="required">*</span></label>
    </div>
    <div class="col-sm-6">
        <input id="r_yes_3" type="radio" name="med_curr" value="yes" data-value="showdetails">
        <label for="r_yes_3"><?php echo lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-6 paddRzERo">
        <input id="r_no_3" type="radio" name="med_curr" value="no">
        <label for="r_no_3"><?php echo lang_line('text_no'); ?></label>
    </div>
    <div class="error med_curr"></div>
</div>
<div class="form-group col-sm-12 no-padding showdetails imi_form" style="display: none;">
    <label><?php echo lang_line('label_arbaeen_form_med_list'); ?></label>
    <div class="input-group col-sm-12">
        <textarea name="med_list" rows="5"></textarea>
        <div class="error med_list"></div>
    </div>
</div> -->
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_health_cond'); ?> <span class="required">*</span><br /><small><?php echo "Please select ALL that apply for health conditions you currently have or have a history of. Please note: it is not necessary that selecting a choice will automatically disqualify you for service.";//lang_line('text_selectallthatapply'); ?></small></label>
    <div class="input-group col-sm-8">
        <ul class="languages">
            <li><input id="c_hc1" type="checkbox" name="health_cond[]" value="Asthma" /><label for="c_hc1"><?php echo "Asthma";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc2" type="checkbox" name="health_cond[]" value="Bone Marrow or Blood Recipient" /><label for="c_hc2"><?php echo "Bone Marrow or Blood Recipient";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc3" type="checkbox" name="health_cond[]" value="Cancer" /><label for="c_hc3"><?php echo "Cancer";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc4" type="checkbox" name="health_cond[]" value="Cerebrovascular Disease" /><label for="c_hc4"><?php echo "Cerebrovascular Disease";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc5" type="checkbox" name="health_cond[]" value="COPD" /><label for="c_hc5"><?php echo "COPD";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc6" type="checkbox" data-value="covid19" class="showdetques" name="health_cond[]" value="COVID-19" /><label for="c_hc6"><?php echo "COVID-19";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc20" type="checkbox" name="health_cond[]" value="Cystic Fibrosis" /><label for="c_hc20"><?php echo "Cystic Fibrosis";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc7" type="checkbox" data-value="diabetes" class="showdetques" name="health_cond[]" value="Diabetes" /><label for="c_hc7"><?php echo "Diabetes";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc8" type="checkbox" data-value="heartdisease" class="showdetques select" name="health_cond[]" value="Heart Disease" /><label for="c_hc8"><?php echo "Heart Disease";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc9" type="checkbox" name="health_cond[]" value="HIV" /><label for="c_hc9"><?php echo "HIV";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc10" type="checkbox" name="health_cond[]" value="Hypertension" /><label for="c_hc10"><?php echo "Hypertension";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc11" type="checkbox" name="health_cond[]" value="Kidney Disease or Acute Injury / Infection" /><label for="c_hc11"><?php echo "Kidney Disease or Acute Injury / Infection";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc12" type="checkbox" name="health_cond[]" value="Liver Disease" /><label for="c_hc12"><?php echo "Liver Disease";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc13" type="checkbox" name="health_cond[]" value="Mental Health Condition" /><label for="c_hc13"><?php echo "Mental Health Condition";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc14" type="checkbox" name="health_cond[]" value="Neurological Condition" /><label for="c_hc14"><?php echo "Neurological Condition";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc15" type="checkbox" name="health_cond[]" value="Pulmonary Fibrosis" /><label for="c_hc15"><?php echo "Pulmonary Fibrosis";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc16" type="checkbox" name="health_cond[]" value="Sickle Cell" /><label for="c_hc16"><?php echo "Sickle Cell";//lang_line('text_arabicfluent'); ?></label></li>            
            <li><input id="c_hc17" type="checkbox" name="health_cond[]" value="Solid Organ Transplant Recipient" /><label for="c_hc17"><?php echo "Solid Organ Transplant Recipient";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc18" type="checkbox" name="health_cond[]" value="Thalassemia" /><label for="c_hc18"><?php echo "Thalassemia";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hc19" type="checkbox" name="health_cond[]" value="No Known Health Conditions" /><label for="c_hc19"><?php echo "No Known Health Conditions";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="health-other" type="checkbox" name="health_cond[]" value="Other" id="health-other" /><label for="health-other"><?php echo lang_line('text_other'); ?></label><input type="text" name="other_health_cond" value="" style="display:none;" /></li>
        </ul>
        <div class="error health_cond other_health_cond"></div>
    </div>
</div> -->
<!-- <div class="form-group col-sm-12 no-padding covid19 imi_form" style="display: none;">
    <div class="col-sm-12 paddzERo">
        <label><?php echo "COVID-19 Infection";//lang_line('text_interestedstayingwithfamily'); ?> <br/><small>Please select the option that applies for your current or past COVID-19 infection and include further details (including dates, severity, symptoms, and treatment) in your answer to the next question below.</small></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_c_1" type="radio" name="type_covid19" value="Current infection-mild; anticipated full recovery">
        <label for="r_c_1"><?php echo "Current infection-mild; anticipated full recovery";//lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_c_2" type="radio" name="type_covid19" value="Past COVID-19 infection-fully recovered">
        <label for="r_c_2"><?php echo "Past COVID-19 infection-fully recovered";//lang_line('text_no'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_c_3" type="radio" name="type_covid19" value='Unrecovered/Long-Haul COVID (though currently negative)'>
        <label for="r_c_3"><?php echo 'Unrecovered/"Long-Haul" COVID (though currently negative)';//lang_line('text_no'); ?></label>
    </div>
    <div class="error type_covid19"></div>
</div>
<div class="form-group col-sm-12 no-padding diabetes imi_form" style="display: none;">
    <div class="col-sm-12 paddzERo">
        <label><?php echo "Type of Diabetes";//lang_line('text_interestedstayingwithfamily'); ?> </label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_d_1" type="radio" name="type_diabetes" value="Type 1">
        <label for="r_d_1"><?php echo "Type 1";//lang_line('text_yes'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_d_2" type="radio" name="type_diabetes" value="Type 2">
        <label for="r_d_2"><?php echo "Type 2";//lang_line('text_no'); ?></label>
    </div>
    <div class="error type_diabetes"></div>
</div>
<div class="form-group col-sm-12 no-padding heartdisease imi_form" style="display: none;">
    <label><?php echo "Type of Heart Disease"//lang_line('text_whatlangcanyouspeak'); ?> <br /><small><?php echo "Please select all that apply and include further details in the answer to the next question below.";//lang_line('text_selectallthatapply'); ?></small></label>
    <div class="input-group col-sm-8">
        <ul class="languages">
            <li><input id="c_hdd1" type="checkbox" name="type_heart_disease[]" value="Heart failure or Cardiomyopathy" /><label for="c_hdd1"><?php echo "Heart failure or Cardiomyopathy";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hdd2" type="checkbox" name="type_heart_disease[]" value="Coronary Artery Disease (CAD)" /><label for="c_hdd2"><?php echo "Coronary Artery Disease (CAD)";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hdd3" type="checkbox" name="type_heart_disease[]" value="Arrhythmia" /><label for="c_hdd3"><?php echo "Arrhythmia";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hdd4" type="checkbox" name="type_heart_disease[]" value="Myocardial Infarction (Heart Attack)" /><label for="c_hdd4"><?php echo "Myocardial Infarction (Heart Attack)";//lang_line('text_arabicfluent'); ?></label></li>
            <li><input id="c_hdd5" type="checkbox" name="type_heart_disease[]" value="Other" /><label for="c_hdd5"><?php echo "Other (details below)";//lang_line('text_other'); ?></label></li>
        </ul>
        <div class="error type_heart_disease"></div>
    </div>
</div> -->
<div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_health_his'); ?><span class="required">*</span><!-- <br/><small>Examples:<ol>
<li>I had a stent placed 15 years ago but I am currently in good mental and physical condition. I walk 2 km daily without any issues.</li>
<li>I had COVID-19 in February/March 2021 with severe respiratory symptoms and was hospitalized for 4 days. I have fully recovered and am physically able to walk distances/participate in activities without any issues.</li>
<li>I have been diagnosed with mental illness (anxiety) but am managing my illness and currently in good mental and physical condition. </li>
<li>I have no health conditions and am currently in good mental & physical health and fitness.</li></ol></small> --></label>
    <div class="input-group col-sm-12">
        <textarea name="health_his" rows="5"></textarea>
        <div class="error health_his"></div>
    </div>
</div>
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <div class="col-sm-12 paddzERo">
        <label><?php echo lang_line('label_arbaeen_form_covid_vacc'); ?> <span class="required">*</span></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_cd_1" data-value="done" type="radio" name="covid_vacc" value="Yes, I have received all required doses of COVID-19 vaccinations.">
        <label for="r_cd_1"><?php echo "Yes, I have received all required doses of COVID-19 vaccinations.";//lang_line('text_toserveasanimidelegate'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_cd_2" data-value="schedule" type="radio" name="covid_vacc" value="No, but I am in the process of completing my vaccination and have received one dose of the COVID-19 vaccine.">
        <label for="r_cd_2"><?php echo "No, but I am in the process of completing my vaccination and have received one dose of the COVID-19 vaccine.";//lang_line('text_toserveasanintfaculty'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_cd_3" data-value="schedule" type="radio" name="covid_vacc" value='No, I have not been vaccinated yet, but am scheduled for my COVID-19 vaccine shortly.'>
        <label for="r_cd_3"><?php echo "No, I have not been vaccinated yet, but am scheduled for my COVID-19 vaccine shortly.";//lang_line('text_toserveasanimidelegateatcamps'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_cd_4" data-value="schedule" type="radio" name="covid_vacc" value="No, but I will be fully vaccinated prior to the trip.">
        <label for="r_cd_4"><?php echo "No, but I will be fully vaccinated prior to the trip.";//lang_line('text_toserveasanimidelegate'); ?></label>
    </div>
    <div class="col-sm-12 flex-center">
        <input id="r_cd_5" data-value="notdone" type="radio" name="covid_vacc" value='No, and I will not be fully vaccinated prior to the trip.'>
        <label for="r_cd_5"><?php echo "No, and I will not be fully vaccinated prior to the trip.";//lang_line('text_toserveasanintfaculty'); ?></label>
    </div>
    <div class="error covid_vacc"></div>
</div>
<div class="form-group col-sm-12 no-padding covid_det imi_form" style='display:none;'>
    <label class="done" style='display:none;'><?php echo "COVID-19 Vaccination Details"//lang_line('text_includeanyotherdetails'); ?><br/><small>Please include which vaccine you have received and the date(s) of your doses.</small></label>
    <label class="schedule" style='display:none;'><?php echo "COVID-19 Vaccination Plan"//lang_line('text_includeanyotherdetails'); ?><br/><small>Please include which vaccine you have been scheduled for (if known) and the (estimated) date(s) of your doses.</small></label>
    <label class="notdone" style='display:none;'><?php echo "Please explain why you will not be vaccinated prior to September 2021."//lang_line('text_includeanyotherdetails'); ?><br/><small>Please provide additional details.<br/>
Examples: <br/>
My doctor has advised against COVID-19 vaccination. <br/>
COVID-19 vaccines are unavailable in my country/location at this time. <br/>
I choose not to get the COVID-19 vaccine at this time.<br/></small></label>
    <div class="input-group col-sm-12">
        <textarea name="covid_vacc_det" rows="1"></textarea>
        <div class="error covid_vacc_det"></div>
    </div>
</div> -->