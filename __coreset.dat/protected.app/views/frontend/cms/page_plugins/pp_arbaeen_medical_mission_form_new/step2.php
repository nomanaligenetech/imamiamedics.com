<?php 
/* echo '<pre>';
print_r($user); die;
echo '</pre>'; */
 ?>
<div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_name'); ?> <span class="required">*</span><br/><small>If no middle name, please write None for the middle name</small></label>
    <div class="input-group col-sm-12">
        <div class="col-sm-4 paddzERo">
            <input type="text" name="first_name" value="<?php echo isset($user) ? $user->name: ''?>" placeholder="<?php echo lang_line('placeholser_arbaeen_first_name'); ?>"/>
            <div class="error first_name"></div>
        </div>
        <div class="col-sm-4">
            <input type="text" name="middle_name" value="<?php echo isset($user) ? $user->middle_name: ''?>" placeholder="<?php echo lang_line('placeholser_arbaeen_middle_name'); ?>" />
            <div class="error middle_name"></div>
        </div>
        <div class="col-sm-4 paddRzERo">
            <input type="text" name="last_name" value="<?php echo isset($user) ? $user->last_name: ''?>" placeholder="<?php echo lang_line('placeholser_arbaeen_last_name'); ?>" />
            <div class="error last_name"></div>
        </div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_othername'); ?></label>
    <div class="input-group col-sm-12">
        <input type="text" name="other_name" value="<?php echo isset($user) ? $user->other_name: ''?>" placeholder="<?php echo lang_line('placeholser_arbaeen_other_name'); ?>" />
        <div class="error other_name"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_address'); ?> <span class="required">*</span><br/><small><?php echo lang_line('label_arbaeen_form_address_note'); ?></small></label>
    <div class="input-group col-sm-12 m_bottom10">
        <input type="text" name="street_address" value="<?php echo isset($user) ? $user->home_full_address: ''?>" placeholder="<?php echo lang_line('placeholder_arbaeen_form_street'); ?>" />
        <div class="error street_address"></div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <input type="text" name="street_address_2" value="" placeholder="<?php echo lang_line('placeholder_arbaeen_form_street_2'); ?>" />
        <div class="error street_address_2"></div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="city" value="<?php echo isset($user) ? $user->home_city: ''?>" placeholder="<?php echo lang_line('placeholder_arbaeen_form_city'); ?>" />
            <div class="error city"></div>
        </div>
        <div class="col-sm-6 paddRzERo">
            <input type="text" name="region" value="<?php echo isset($user) ? $user->home_state_province: ''?>" placeholder="<?php echo lang_line('placeholder_arbaeen_form_region'); ?>" />
            <div class="error region"></div>
        </div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="postal_code" value="<?php echo isset($user) ? $user->home_zipcode: ''?>" placeholder="<?php echo lang_line('placeholder_arbaeen_form_zipcode'); ?>" />
            <div class="error postal_code"></div>
        </div>
        <div class="col-sm-6 ui-widget paddRzERo">
            <select id="combobox" name="country" placeholder="<?php echo lang_line('text_country'); ?>">
                <option value="">Please Select</option>
                <?php
                    if ( !empty($countries) ){
                        foreach ($countries as $country) {
                            $selected = isset($user) && $user->home_country_name == $country['countries_name'] ? 'selected="selected"' : '';
                            echo '<option value="'.$country['countries_name'].'" '.$selected.' data-id='. $country['id'] .' >'.$country['countries_name'].'</option>';
                        }
                    }
                ?>
            </select>
            <div class="error country"></div>
        </div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_email'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="email" name="email" value="<?php echo isset($user) ? $user->email: ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_email'); ?>" />
        <div class="error email"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form mq-dev">
    <label><?php echo lang_line('label_arbaeen_form_phone'); ?> <span class="required">*</span><br/><small><?php echo lang_line('label_arbaeen_form_phone_note'); ?></small></label>
    <div class="input-group col-sm-2 ui-widget paddRzERo">
        <select id="combobox-code" name="phone_country_code" placeholder="<?php echo lang_line('text_phone_country_code'); ?>">
            <option value="">Please Select</option>
            <?php
                if ( !empty($countries) ){
                    foreach ($countries as $country) {
                        $selected = isset($user) && $user->home_country_name == $country['countries_name'] ? 'selected="selected"' : '';
                        if(isset($user) && $user->home_country_name == $country['countries_name']){
                            $code     = $country['phone_code'];
                        }
                        $county_name = preg_replace('/\s+/', '-', $country['countries_name']);
                        // echo '<option value="'.$country_code['countries_name'].'" '.$selected.' >'.$country_code['countries_name'].'</option>';
                        echo '<option value="'.$country['phone_code'].'" data-id="'. $country['country'] .'" data-cname="'. $county_name .'" '.$selected.' >'. $country['countries_name'] .' (+'.$country['phone_code'].')</option>';
                    }
                }
            ?>
        </select>
    <div class="error phone_country_code"></div>
    </div>
    <div class="input-group col-sm-10">
        <?php
            $phone_number = str_replace("+" . $code, "", $user->cellphone_number);
        ?>
        <input type="text" name="phone_number" value="<?php echo isset($user) ? $phone_number : ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_phone'); ?>" />
        <div class="error phone_number"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <p><?php echo lang_line('text_application'); ?></p>
</div>
<div class="form-group col-sm-12 no-padding imi_form imi-card-selector-main">
    <div class="col-sm-12 paddzERo imi-card-col">
        <label><?php echo lang_line('label_role'); ?><span class="required">*</span><br><small><?php echo lang_line('label_arbaeen_form_role_note'); ?></small></label>
    </div>
    <div class="col-sm-4 imi-card-col">
        <input id="doctor" type="radio" name="occupation" value="doctor" <?php echo isset($user) && $user->occupation == "doctor" ? 'checked' : ''?>>
        <label for="doctor"><?php echo lang_line('text_doctor'); ?></label>
    </div>
    <div class="col-sm-4 paddRzERo imi-card-col">
        <input id="nurse" type="radio" name="occupation" value="nurse" <?php echo isset($user) && $user->occupation == "nurse" ? 'checked' : ''?>>
        <label for="nurse"><?php echo lang_line('text_nurse'); ?></label>
    </div>
    <div class="col-sm-4 paddRzERo imi-card-col">
        <input id="pharm" type="radio" name="occupation" value="pharm" <?php echo isset($user) && $user->occupation == "pharm" ? 'checked' : ''?>>
        <label for="pharm"><?php echo lang_line('text_pharm'); ?></label>
    </div>
    <div class="col-sm-4 paddRzERo imi-card-col">
        <input id="dental" type="radio" name="occupation" value="dental" <?php echo isset($user) && $user->occupation == "dental" ? 'checked' : ''?>>
        <label for="dental"><?php echo lang_line('text_dental'); ?></label>
    </div>
    <div class="col-sm-4 paddRzERo imi-card-col">
        <input id="admin" type="radio" name="occupation" value="admin" <?php echo isset($user) && $user->occupation == "admin" ? 'checked' : ''?>>
        <label for="admin"><?php echo lang_line('text_admin'); ?></label>
    </div>
    <div class="col-sm-4 paddRzERo imi-card-col">
        <input id="accompanying_family" type="radio" name="occupation" value="accompanying_family" <?php echo isset($user) && $user->occupation == "accompanying_family" ? 'checked' : ''?>>
        <label for="accompanying_family"><?php echo lang_line('text_accompanying_family'); ?></label>
    </div>
    <div class="error occupation"></div>
</div>
<div class="form-group col-sm-12 no-padding imi_form imi-cv-box">
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
<!-- <div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_DOB'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="birth_date" value="" class="birthdate_datepicker" placeholder="<?php echo "YYYY-MM-DD";//lang_line('label_arbaeen_form_DOB'); ?>"/>
        <div class="error birth_date"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_age'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="number" name="age" value="<?php echo isset($user) ? $user->age : ''?>" class="age" placeholder="<?php echo lang_line('label_arbaeen_form_age'); ?>" min="1" oninput="validity.valid||(value='');" />
        <div class="error age"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_occupation'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="occupation" value="<?php echo isset($user) ? $user->occupation: ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_occupation'); ?>"/>
        <div class="error occupation"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding imi_form">
    <label><?php echo lang_line('label_arbaeen_form_speciality'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="speciality" value="<?php echo isset($user) ? $user->specialties: ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_speciality'); ?>" />
        <div class="error speciality"></div>
    </div>
</div> -->