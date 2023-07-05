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
    <label><?php echo lang_line('label_arbaeen_form_biography'); ?><span class="required">*</span><br /><small><?php echo lang_line('label_arbaeen_form_biography_note'); ?> </label>
    <div class="input-group col-sm-12">
        <textarea name="biography"><?php echo isset($_POST['biography']) ? $_POST['biography'] : '';?></textarea>
        <div class="error biography"></div>
    </div>
</div>