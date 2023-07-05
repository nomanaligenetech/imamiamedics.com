<?php
/** @var CI_Loader $this */
$is_user_paid_approved_imi_member = $this->functions->validate_if_user_is_a_paid_member($this->functions->_user_logged_in_details("id"));
?>
<div class="template_left fl_lft w_30">
    <div class="left_area fl_lft m_bottom25">
        <div class="left_top_title left_title"><?php echo lang_line('text_menu'); ?></div>
        <div class="left_area_bottom testi_bottom_area fl_lft no-padding">
            <ul class="ulstyleone">
                <li><a href="<?php echo site_url("account/myprofile/controls/view"); ?>"><?php echo lang_line('text_myprofile'); ?></a></li>
                <li><a href="<?php echo site_url("account/profilesettings/controls/view");?>"><?php echo lang_line('text_updateyourprofile'); ?></a></li>

                <?php
                if ($is_user_paid_approved_imi_member) {
                    ?>
<!--                    <li>-->
<!--                        <a href="--><?php //echo site_url("account/browseimimembers/controls/view"); ?><!--">Browse IMI Members</a>-->
<!--                    </li>-->
                    <?php
                }
                ?>


                <!--<li><a href="<?php echo site_url("account/documentrepository/controls/view");?>">Document Repository</a></li>-->
                <li><a href="<?php echo site_url("account/conferenceeventsattended/controls/view");?>"><?php echo lang_line('text_confeventsattended'); ?></a></li>
                <li><a href="<?php echo site_url("account/donationtransactionhistory/controls/view");?>"><?php echo lang_line('text_financialtranshistory'); ?></a></li>

                <!--<li><a href="<?php echo site_url("account/imimembershiphistory/controls/view");?>">IMI Membership History</a></li>-->
                <?php
                if ($is_user_paid_approved_imi_member) {
                    ?>
                    <li><a href="<?php echo site_url("page/discussion-board"); ?>"><?php echo lang_line('text_discussion_board'); ?></a></li>
                    <?php
                }
                ?>

                <!-- Volunteer Form -->

                <?php
                $v_form = $this->db->query("select count(id) as total from tb_volunteer_form where user_id = " . $this->functions->_user_logged_in_details("id"));

                if ($v_form->row()->total > 0) {
                    ?>
                    <li><a href="<?php echo site_url("account/imivolunteerform/controls/view"); ?>"><?php echo lang_line('text_imi_volunteer_form'); ?>
                            </a></li>
                    <?php
                }
                ?>

                <!-- Internship Form -->

                <?php
                $i_form = $this->db->query("select count(id) as total from tb_internship_form where user_id = " . $this->functions->_user_logged_in_details("id"));

                if ($i_form->row()->total > 0) {
                    ?>
                    <li><a href="<?php echo site_url("account/imiinternshipform/controls/view"); ?>"><?php echo lang_line('text_imi_intern_form'); ?></a></li>
                    <?php
                }
                ?>

                <!-- Mentorship Form -->

                <?php
                $m_form = $this->db->query("select count(id) as total from tb_mentorship_form where user_id = " . $this->functions->_user_logged_in_details("id"));

                if ($m_form->row()->total > 0) {
                    ?>
                    <li><a href="<?php echo site_url("account/imimentorshipform/controls/view"); ?>"><?php echo lang_line('text_imi_mentor_form'); ?></a></li>
                    <?php
                }
                ?>

                <!-- Event Interested -->
                <?php
                $events = $this->db->query('Select je.eventid,je.event,je.date_added,sw.title From tb_join_event je inner join tb_sitesectionswidgets sw ON sw.id = je.eventid where je.userid = "' . $this->functions->_user_logged_in_details("id").'"');
                if ( $events->num_rows() > 0 ){
                    ?>
                     <li><a href="<?php echo site_url("account/imieventsjoined/controls/view"); ?>"><?php echo lang_line('text_events_joined'); ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>