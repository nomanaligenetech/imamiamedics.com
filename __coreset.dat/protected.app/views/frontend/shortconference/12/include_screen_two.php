<style>
.alert-success_big, .alert-special_big, .alert-warning_big, .alert-danger_big, .alert-info_big{ margin:0px !important;}
body .mi-primary-registrant{border-radius: 15px;overflow: hidden;}

body .mi-primary-registrant .mi-primary-registrant-family{display: flex;align-items: center;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-heading,
body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-heading{width: 30%;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-heading h3,
body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-heading h3{    background-color: #1C5F8D; color: white; font-style: normal; font-weight: 700; font-size: 20px; vertical-align: middle;padding: 0px 0 0 26px;margin: 0;height: 100%;min-height: 80px;display: flex;align-items: center;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-title{width: 15%;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-email{width: 20%;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-rel{width: 20%;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-age{width: 15%;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-hd h4,
body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-hd h4{margin: 0;padding: 12px 16px;    background-color: #41AAF3; color: white; font-style: normal;font-size: 13px;font-weight: 700;font-family: 'Aleo';border-left: 1.5px solid rgba(255, 255, 255, 0.05);}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-title .mi-primary-registrant-family-hd h4,
body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-title .mi-primary-registrant-guest-hd h4{border-left: 0;}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-val p,
body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-val p{margin: 0;padding: 12px 16px;color: #000; font-style: normal;font-size: 13px;font-weight: 700;font-family: 'Aleo';border-left: 1.5px solid rgba(90, 90, 90, 0.05);}

body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-title .mi-primary-registrant-family-val p,
body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-title .mi-primary-registrant-guest-val p{border-left: none;}

body .mi-primary-registrant .mi-primary-registrant-guest{display: flex;}

body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-title{width: 15%;}

body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-email{width: 20%;}

body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-rel{width: 20%;}

body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-age{width: 15%;}

@media screen and (max-width: 980px) {

    body .mi-primary-registrant .mi-primary-registrant-family,
    body .mi-primary-registrant .mi-primary-registrant-guest{flex-wrap: wrap;}
    
    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-heading, body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-heading { width: 100%; }

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-title,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-title{width: 20%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-email,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-email{width: 30%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-rel,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-rel{width: 30%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-age,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-age{width: 20%;}

}

@media screen and (max-width: 600px) {
    
    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-title, body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-title{width: 50%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-email,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-email{width: 50%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-rel,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-rel{width: 50%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-age,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-age{width: 50%;}

}

@media screen and (max-width: 428px) {
    
    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-title, body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-title{width: 100%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-col-email,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-col-email{width: 100%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-rel,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-rel{width: 100%;}

    body .mi-primary-registrant .mi-primary-registrant-family .mi-primary-registrant-family-age,
    body .mi-primary-registrant .mi-primary-registrant-guest .mi-primary-registrant-guest-age{width: 100%;}

}
</style>



<div class="mi-primary-registrant">
        <div class="mi-primary-registrant-family">
            <div class="mi-primary-registrant-family-heading">
                <h3>Primary Registrant</h3>
            </div>
            <div class="mi-primary-registrant-family-col-title">
                <div class="mi-primary-registrant-family-hd">
                    <h4>Title:</h4>
                </div>
                <div class="mi-primary-registrant-family-val">
                    <p><?php echo $conferenceregistration_screenone->row("prefix");?></p>
                </div>
            </div>
            <div class="mi-primary-registrant-family-col-title">
                <div class="mi-primary-registrant-family-hd">
                    <h4>Name:</h4>
                </div>
                <div class="mi-primary-registrant-family-val">
                    <p><?php echo $conferenceregistration_screenone->row("name");?></p>
                </div>
            </div>
            <div class="mi-primary-registrant-family-col-email">
                <div class="mi-primary-registrant-family-hd">
                    <h4>Email:</h4>
                </div>
                <div class="mi-primary-registrant-family-val">
                    <p><?php echo $conferenceregistration_screenone->row("email");?></p>
                </div>
            </div>
            <div class="mi-primary-registrant-family-rel">
                <div class="mi-primary-registrant-family-hd">
                    <h4>Phone:</h4>
                </div>
                <div class="mi-primary-registrant-family-val">
                    <p><?php echo $conferenceregistration_screenone->row("phone");?></p>
                </div>
            </div>
        </div>
        <?php if ( $conferenceregistration_screenone_family_details->num_rows() > 0 )
            {
            ?>
        <div class="mi-primary-registrant-guest">
            <div class="mi-primary-registrant-guest-heading">
                <h3>Family Guest Information</h3>
            </div>
            <div class="mi-primary-registrant-guest-col-title">
                <div class="mi-primary-registrant-guest-hd">
                    <h4>Name:</h4>
                </div>
                <?php
                foreach( $conferenceregistration_screenone_family_details->result_array() as $child)
                {?>
                    <div class="mi-primary-registrant-guest-val">
                        <p><?php echo $child['family_name']; ?> </p>
                    </div>
                <?php } ?>
            </div>
            <div class="mi-primary-registrant-guest-col-email">
                <div class="mi-primary-registrant-guest-hd">
                    <h4>Email:</h4>
                </div>
                <?php
                foreach( $conferenceregistration_screenone_family_details->result_array() as $child)
                {?>
                    <div class="mi-primary-registrant-guest-val">
                        <p><?php echo $child['family_email']; ?> </p>
                    </div>
                <?php } ?>
            </div>
            <div class="mi-primary-registrant-guest-rel">
                <div class="mi-primary-registrant-guest-hd">
                    <h4>Relationship:</h4>
                </div>
                <?php
                foreach( $conferenceregistration_screenone_family_details->result_array() as $child)
                {?>
                    <div class="mi-primary-registrant-guest-val">
                        <p><?php echo $child['family_relationship_name']; ?> </p>
                    </div>
                <?php } ?>
            </div>
            <div class="mi-primary-registrant-guest-age">
                <div class="mi-primary-registrant-guest-hd">
                    <h4>Age:</h4>
                </div>
                <?php
                foreach( $conferenceregistration_screenone_family_details->result_array() as $child)
                {?>
                    <div class="mi-primary-registrant-guest-val">
                        <p><?php echo $child['family_age']; ?> </p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>