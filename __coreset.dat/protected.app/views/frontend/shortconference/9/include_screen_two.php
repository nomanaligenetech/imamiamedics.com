<style>
.alert-success_big, .alert-special_big, .alert-warning_big, .alert-danger_big, .alert-info_big{ margin:0px !important;}
</style>


<div class="screentwo_information">

<table width="100%" border="0" bgcolor="f7f7f7" cellspacing="0" cellpadding="0" class="firsttable">
        <tr>
            <td></td>
        </tr>
        
        <tr>
            <td width="5%">&nbsp;</td>
            <td colspan="3"><h1><?php echo lang_line('text_primaryregistrant');?></h1></td>
            <td width="">&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td ><strong>Title :</strong></td>
            <td>&nbsp;</td>
            <td><?php echo $conferenceregistration_screenone->row("prefix");?></td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><strong>Name :</strong></td>
            <td>&nbsp;</td>
            <td><?php echo $conferenceregistration_screenone->row("name");?></td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><strong>Phone :</strong></td>
            <td>&nbsp;</td>
            <td><?php echo $conferenceregistration_screenone->row("phone");?></td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><strong>Email :</strong></td>
            <td>&nbsp;</td>
            <td><?php echo $conferenceregistration_screenone->row("email");?></td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
    </table>


<table width="100%" bgcolor="f7f7f7" border="0" cellspacing="0" cellpadding="0" class="secondtable">
    
    
    <?php
    if ( $conferenceregistration_screenone_family_details->num_rows() > 0 )
    {
    ?>
        <tr>
            <td width="5%">&nbsp;</td>
            <td colspan="7"><h1>Family Guest Information</h1></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><strong>Title :</strong></td>
            <td>&nbsp;</td>
            <td><strong>Email.</strong></td>
            <td>&nbsp;</td>
            <td><strong>Relationship</strong></td>
            <td>&nbsp;</td>
            <td><strong>Age</strong></td>
            <td>&nbsp;</td>
        </tr>
    
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        
        <?php
        foreach( $conferenceregistration_screenone_family_details->result_array() as $child)
        {
        ?>
            <tr>
                <td></td>
                <td><?php echo $child['family_name'];?></td>
                <td></td>
                <td><?php echo $child['family_email'];?></td>
                <td></td>
                <td><?php echo $child['family_relationship_name'];?></td>
                <td></td>
                <td><?php echo $child['family_age'];?></td>
                <td></td>
            </tr>
        
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
    <?php
        }
    }
    else
    {
        ?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            
            <tr>
                <td colspan="9" class="inline_error_style">
                <?php
                $data["_messageBundle"]				= $_messageBundle2_nofamilyguest;
                $this->load->view('frontend/template/_show_messages.php', $data);
                ?>
                </td>
            </tr>
            
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

        <?php	
    }
    ?>


</table>
    
</div>