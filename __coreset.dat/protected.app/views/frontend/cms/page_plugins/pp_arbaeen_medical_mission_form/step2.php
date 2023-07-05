<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_name'); ?> <span class="required">*</span></label>
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
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_DOB'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="birth_date" value="" class="birthdate_datepicker" placeholder="<?php echo lang_line('label_arbaeen_form_DOB'); ?>"/>
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
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_occupation'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="occupation" value="<?php echo isset($user) ? $user->occupation: ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_occupation'); ?>"/>
        <div class="error occupation"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_speciality'); ?> <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="speciality" value="<?php echo isset($user) ? $user->specialties: ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_speciality'); ?>" />
        <div class="error speciality"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_email'); ?> <span class="required">*</span><br/><small><?php echo lang_line('label_arbaeen_form_email_note'); ?></small></label>
    <div class="input-group col-sm-12">
        <input type="email" name="email" value="<?php echo isset($user) ? $user->email: ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_email'); ?>" />
        <div class="error email"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_phone'); ?> <span class="required">*</span><br/><small><?php echo lang_line('label_arbaeen_form_phone_note'); ?></small></label>
    <div class="input-group col-sm-12">
        <input type="text" name="phone_number" value="<?php echo isset($user) ? $user->cellphone_number: ''?>" placeholder="<?php echo lang_line('label_arbaeen_form_phone'); ?>" />
        <div class="error phone_number"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label><?php echo lang_line('label_arbaeen_form_address'); ?> <span class="required">*</span></label>
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
                            echo '<option value="'.$country['countries_name'].'" '.$selected.' >'.$country['countries_name'].'</option>';
                        }
                    }
                ?>
            </select>
            <div class="error country"></div>
        </div>
    </div>
</div>