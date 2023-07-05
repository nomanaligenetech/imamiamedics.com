<?php
    $createDate = new DateTime($table_record->date_added);
    $strip = $createDate->format('Y-m-d');
    $to_decrypt = strtotime($strip) >= strtotime("2023-05-29");
?>
<table class="table table_form">
    <tr>
        <td class="td_bg" style="width:50%">First Name: </td>
        <td colspan="2" class="td_bg" style="width:50%">
            <?php echo $table_record->first_name; ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Middle Name: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->middle_name; ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Last Name: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->last_name; ?>
        </td>
    </tr>

    <?php if(!is_null($table_record->other_name)){?>
    <tr>
        <td class="td_bg">Name you prefer to be called by others (if not your legal name): </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->other_name; ?>
        </td>
    </tr>
    <?php } ?>

    <?php if(!is_null($table_record->street_address)){?>
    <tr>
        <td class="td_bg">Street Address: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->street_address; ?>
        </td>
    </tr>
    <?php } ?>

    <?php if(!is_null($table_record->street_address2)){?>
    <tr>
        <td class="td_bg">Street Address 2: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->street_address_2; ?>
        </td>
    </tr>
    <?php } ?>

    <?php if(!is_null($table_record->city)){?>
    <tr>
        <td class="td_bg">City: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->city; ?>
        </td>
    </tr>
    <?php } ?>

    <?php if(!is_null($table_record->region)){?>
    <tr>
        <td class="td_bg">Region: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->region; ?>
        </td>
    </tr>
    <?php } ?>

    <?php if(!is_null($table_record->postal_code)){?>
    <tr>
        <td class="td_bg">Postal Code: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->postal_code; ?>
        </td>
    </tr>
    <?php } ?>

    <tr>
        <td class="td_bg">Country: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->country; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Email: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->email; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Phone: </td>
        <td colspan="2" class="td_bg">
            <?php echo $to_decrypt ? $this->encrption->decrypt($table_record->phone_number) : $table_record->phone_number ; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Occupation: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->occupation; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">CV/Resume : </td>
        <td colspan="2" class="td_bg">
            <?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $table_record->cv_resume . '" style="font-weight:bold" download="download">click here</a> to download'; ?>
        </td>
    </tr>
    
    <?php if(!is_null($table_record->health_his)){?>
    <tr>
        <td class="td_bg">Brief information regarding any health history/current conditions/allergies AND personal physical & mental fitness self-assessment:</td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->health_his; ?>
        </td>
    </tr>
    <?php } ?>

    <tr>
        <td class="td_bg">Citizenship: </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->citizenship; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Date of Birth: </td>
        <td colspan="2" class="td_bg">
            <?php echo $to_decrypt ? $this->encrption->decrypt($table_record->birth_date) : $table_record->birth_date ; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Passport Number: </td>
        <td colspan="2" class="td_bg">
            <?php echo $to_decrypt ? $this->encrption->decrypt($table_record->passportno) : $table_record->passportno ; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Date of Expiration: </td>
        <td colspan="2" class="td_bg">
            <?php echo $to_decrypt ? $this->encrption->decrypt($table_record->passport_expiry) : $table_record->passport_expiry ; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Passport Copy : </td>
        <td colspan="2" class="td_bg">
            <?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $table_record->passport_copy . '" style="font-weight:bold" download="download">click here</a> to download'; ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Passport Sized Photograph : </td>
        <td colspan="2" class="td_bg">
            <?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $table_record->passport_pic . '" style="font-weight:bold" download="download">click here</a> to download'; ?>
        </td>
    </tr>

    <?php if ($table_record->agree_terms != 0) { ?>

    <tr>
        <td class="td_bg">I agree to the personal covenant and liability form and agree to abide by all rules and processes of IMI. : </td>
        <td colspan="2" class="td_bg">
            <?php echo $table_record->agree_terms == 1 ? 'Yes' : 'No'; ?>
        </td>
    </tr>

    <?php 
} ?>
    <tr>
        <td class="td_bg">Digital Signature : </td>
        <td colspan="2" class="td_bg">
            <?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $table_record->signature . '" style="font-weight:bold" download="download">click here</a> to download'; ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Status : </td>
        <td colspan="2" class="td_bg">
            <?php
            switch ($table_record->status) {
                case 'pending':
                    echo "Pending";
                    break;
                
                case 'waitlist':
                    echo "Waitlist";
                    break;
                
                case 'reject':
                    echo "Rejected";
                    break;
                
                case 'approve':
                    echo "Approved";
                    break;
                
                case 'assigntointerviewer':
                    echo "Assigned To Interviewer";
                    break;
                
                default:
                    break;
            }
            ?>
        </td>
    </tr>
</table>
<hr />
<a class="btn btn-info btn-flat" style="margin-top:20px;" href="<?php echo site_url($_directory . "controls/view"); ?>">Go Back</a> 