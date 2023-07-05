<h3>Emergency Contact Details</h3>
<div class="form-group col-sm-12 no-padding">
    <label>Primary Emergency Contact Name <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="emergency_primary_first_name" value="" placeholder="First" />
            <div class="error emergency_primary_first_name"></div>
        </div>
        <div class="col-sm-6 paddRzERo">
            <input type="text" name="emergency_primary_last_name" value="" placeholder="Last" />
            <div class="error emergency_primary_last_name"></div>
        </div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label>Primary Emergency Contact Email <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="email" name="emergency_primary_email" value="" placeholder="Email" />
        <div class="error emergency_primary_email"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label>Primary Emergency Contact Phone <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="emergency_primary_phone" value="" placeholder="Phone" />
        <div class="error emergency_primary_phone"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label>Primary Emergency Contact Address <span class="required">*</span></label>
    <div class="input-group col-sm-12 m_bottom10">
        <input type="text" name="emergency_primary_address" value="" placeholder="Street Address" />
        <div class="error emergency_primary_address"></div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <input type="text" name="emergency_primary_address_2" value="" placeholder="Street Address Line 2" />
        <div class="error emergency_primary_address_2"></div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="emergency_primary_city" value="" placeholder="City" />
            <div class="error emergency_primary_city"></div>
        </div>
        <div class="col-sm-6 paddRzERo">
            <input type="text" name="emergency_primary_state" value="" placeholder="Region" />
            <div class="error emergency_primary_state"></div>
        </div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="emergency_primary_postal_code" value="" placeholder="Postal/Zip Code" />
            <div class="error emergency_primary_postal_code"></div>
        </div>
        <div class="col-sm-6 ui-widget paddRzERo">
            <select id="combobox" name="emergency_primary_country">
                <option value="">Please Select</option>
                <?php
                if (!empty($countries)) {
                    foreach ($countries as $country) {
                        echo '<option value="' . $country['countries_name'] . '">' . $country['countries_name'] . '</option>';
                    }
                }
                ?>
            </select>
            <div class="error emergency_primary_country"></div>
        </div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label>Secondary Emergency Contact Name <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="emergency_secondary_first_name" value="" placeholder="First" />
            <div class="error emergency_secondary_first_name"></div>
        </div>
        <div class="col-sm-6 paddRzERo">
            <input type="text" name="emergency_secondary_last_name" value="" placeholder="Last" />
            <div class="error emergency_secondary_last_name"></div>
        </div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label>Secondary Emergency Contact Email <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="email" name="emergency_secondary_email" value="" placeholder="Email" />
        <div class="error emergency_secondary_email"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label>Secondary Emergency Contact Phone <span class="required">*</span></label>
    <div class="input-group col-sm-12">
        <input type="text" name="emergency_secondary_phone" value="" placeholder="Phone" />
        <div class="error emergency_secondary_phone"></div>
    </div>
</div>
<div class="form-group col-sm-12 no-padding">
    <label>Secondary Emergency Contact Address <span class="required">*</span></label>
    <div class="input-group col-sm-12 m_bottom10">
        <input type="text" name="emergency_secondary_address" value="" placeholder="Street Address" />
        <div class="error emergency_secondary_address"></div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <input type="text" name="emergency_secondary_address_2" value="" placeholder="Street Address Line 2" />
        <div class="error emergency_secondary_address_2"></div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="emergency_secondary_city" value="" placeholder="City" />
            <div class="error emergency_secondary_city"></div>
        </div>
        <div class="col-sm-6 paddRzERo">
            <input type="text" name="emergency_secondary_state" value="" placeholder="Region" />
            <div class="error emergency_secondary_state"></div>
        </div>
    </div>
    <div class="input-group col-sm-12 m_bottom10">
        <div class="col-sm-6 paddzERo">
            <input type="text" name="emergency_secondary_postal_code" value="" placeholder="Postal/Zip Code" />
            <div class="error emergency_secondary_postal_code"></div>
        </div>
        <div class="col-sm-6 ui-widget paddRzERo">
            <select id="combobox" name="emergency_secondary_country">
                <option value="">Please Select</option>
                <?php
                if (!empty($countries)) {
                    foreach ($countries as $country) {
                        echo '<option value="' . $country['countries_name'] . '">' . $country['countries_name'] . '</option>';
                    }
                }
                ?>
            </select>
            <div class="error emergency_secondary_country"></div>
        </div>
    </div>
</div>