<h3>Passport Details</h3>
<div class="form-group col-sm-12 no-padding">
    <label>Citizenship <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="citizenship" value="" />
        <div class="error citizenship"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Passport Number <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="passport_number" value="" />
        <div class="error passport_number"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Date of Issue <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="passport_issue_date" value="" class="issue_datepicker" placeholder="YYYY-MM-DD" />
        <div class="error passport_issue_date"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Date of Expiration <span class="required">*</span>
        <small>Your passport MUST be valid until at least April 2018</small></label>
    <div class="input-group col-sm-12">
        <input type="text" name="passport_expiry_date" value="" class="expiry_datepicker" placeholder="YYYY-MM-DD" />
        <div class="error passport_expiry_date"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Place of Issue <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="passport_issue_place" value="" />
        <div class="error passport_issue_place"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Date of Birth <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="birth_date" value="" class="birthdate_datepicker" placeholder="YYYY-MM-DD" />
        <div class="error birth_date"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Place of Birth <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="birth_place" value="" />
        <div class="error birth_place"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Passport Copy Upload (color copies required) <span class="required">*</span><br /><small>Please upload a color copy of your passport as a PDF or JPG file. Your passport must be valid for at least 6 months AFTER the travel dates. To add files, click the Add files button then select your document. Once your document is selected, you will see a green Upload Files button. You must click that to attach the document.</small></label>
    <div class="input-group col-sm-12">
        <div class="uploader-wrap">
            <span class="remove-file">x</span>
            <span class="text">Choose file or drag here</span>
            <input type="file" name="passport_copy" id="passport_copy" />
        </div>
        <div class="error passport_copy"></div>
    </div>
</div>

<div class="form-group col-sm-12 no-padding">
    <label>Passport Sized Photograph Upload <span class="required">*</span><br /><small>Please upload a color, passport size photograph as a image file here. As this image will be used for your visa, please remember to upload an image that meets basic international requirements (blank wall, front facing; see examples at http://travel.state.gov/content/passports/english/passports/photos/photocompositiontemplate.html).<br>This image will also be used for your ID cards. As such women are required to submit images with head-coverings.<br />To add files, click the Add files button then select your document. Once your document is selected, you will see a green Upload Files button. You must click that to attach the document.</small></label>
    <div class="input-group col-sm-12">
        <div class="uploader-wrap">
            <span class="remove-file">x</span>
            <span class="text">Choose file or drag here</span>
            <input type="file" name="passport_pic" id="passport_pic" />
        </div>
        <div class="error passport_pic"></div>
    </div>
</div>