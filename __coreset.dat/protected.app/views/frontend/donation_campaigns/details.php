
<!-- 
<style type="text/css">
    .sidebar-box{
        float: none !important;
    }
</style> -->
<div class="donation-campaigns-details">
<?php $campaign = $campaigns_list[0];
 if ($campaign['id'] == 23) {
        ?>
        <style type="text/css">
            .sidebar-box{
                float: none !important;
            }
        </style> 
        <?php
    }


?>
    <script type="text/javascript">
    console.log(`<?php echo "mysite".site_url() ?>`)
    console.log(`<?php echo "myid".$campaign['id'] ?>`)
</script>


<?php
    

$url = site_url('page/'.SLUG_DONATION_CAMPAIGNS.'/'.$campaign['slug'].'#form_donate');
if ($DONATEFORM['_process_to_paypal']) {

$data["_messageBundle"]             = $DONATEFORM['_messageBundle_redirect_paypal'];
$this->load->view('frontend/template/_show_messages.php', $data);

?>

<?php 
    foreach($chapter_countries as $chapter_country){
        if( $chapter_country['country_id'] == $locationID)
       {
           $active_payPal['code'] = $chapter_country['code']; 
           $active_payPal['paypal_email'] = $chapter_country['paypal_email']; 
           $active_payPal['id'] = $chapter_country['id']; 
       }
    }
    if( site_url() == "https://imicanada.org/"){
        $payment_email_address = 'imamiacanada@gmail.com';
        $payment_code          = 'CAD';
        // $if_can = true;
    }else{
        $payment_email_address = $this->payment->paypal_form_details()->business_email;
        $payment_code          = 'USD';
        // $if_can = false;
    }
?>
<form name="form_donateform" action="<?php echo $this->payment->paypal_form_details()->url; ?>" method="post" novalidate>
    <input type="hidden" value="<?php echo $payment_email_address; ?>" name="business">
    <input type="hidden" value="<?php echo $payment_code; ?>" name="currency_code">
    <input type="hidden" value="<?php echo $this->functions->_user_logged_in_details("id"); ?>" name="item_number">


    <?php
if ($_POST["donation_mode"] == "onetimepay") {
    ?>
        <input type="hidden" value="_xclick" name="cmd">
        <input type="hidden" value="<?php echo set_value("donating_amount"); ?>" name="amount">
    <?php
} else {
    ?>
        <input type="hidden" value="_xclick" name="cmd">
        <input type="hidden" value="<?php echo set_value("donate_amount"); ?>" name="amount">
    <?php
}
?>




    <input type="hidden" value="2" name="rm">
    <input type="hidden" value="1" name="no_shipping">
    <input type="hidden" value="1" name="no_note">
    <input type="hidden" value="US" name="lc">

    <?php if ($_POST["donation_mode"] == "onetimepay") {
        ?>
        <input type="hidden" value="tb_give_honor_someone|id|<?php echo $donation_id; ?>" name="custom">
    <?php
} else { ?>

        <input type="hidden" value="tb_donation_form|id|<?php echo $donation_id; ?>" name="custom">
    <?php } ?>





    <?php if ($_POST["donation_mode"] == "onetimepay") { ?>

        <input type="hidden" value="<?php echo site_url('page/donate/payment_success_honor'); ?>" name="return">
        <input type="hidden" value="<?php echo site_url('page/donate/payment_notify_honor'); ?>" name="notify_url">
    <?php } else { ?>

        <input type="hidden" value="<?php echo site_url('page/'.SLUG_DONATION_CAMPAIGNS.'/'.$campaign['slug'].'/paymentsuccess'); ?>" name="return">
        <input type="hidden" value="<?php echo site_url('page/'.SLUG_DONATION_CAMPAIGNS.'/'.$campaign['slug'].'/paymentnotify'); ?>" name="notify_url">
    <?php } ?>


    <input type="hidden" value="<?php echo site_url('page/'.SLUG_DONATION_CAMPAIGNS.'/'.$campaign['slug'].'/paymentcancel'); ?>" name="cancel_return">


    <?php if ($_POST["donation_mode"] == "onetimepay") { ?>
        <input type="hidden" value="<?php echo set_value("name", $from_name); ?>" name="first_name">
        <input type="hidden" value="" name="last_name">

        <input type="hidden" value="<?php echo $_POST['donation_projects']; ?>" name="item_name">

    <?php } else { ?>

        <input type="hidden" value="<?php echo DropdownHelper::donation_projects_dropdown(FALSE, set_value("donation_projects")); ?>" name="item_name">

        <input type="hidden" value="<?php echo set_value("first_name", $from_first_name); ?>" name="first_name">
        <input type="hidden" value="<?php echo set_value("last_name", $from_last_name); ?>" name="last_name">

    <?php } ?>


    <input type="hidden" value="<?php echo set_value("address"); ?>" name="address1">
    <input type="hidden" value="" name="address2">
    <input type="hidden" value="<?php echo $DONATEFORM['city']; ?>" name="city">
    <input type="hidden" value="<?php echo $DONATEFORM['country']; ?>" name="country">
    <input type="hidden" value="<?php echo $DONATEFORM['state']; ?>" name="state">
    <input type="hidden" value="<?php echo $DONATEFORM['zip']; ?>" name="zip">

</form>

<script>
    $("form[name='form_donateform']").submit();
</script>
<?php
}?>

<?php

if(
    ($campaign['belongsto'] == 2 && is_countryCheck(FALSE,FALSE,TRUE) == 'canada')
    ||
    ($campaign['belongsto'] == 3 && site_url() == "https://imamiamedics.com/")){
    
        redirect(site_url());
}

if( site_url() == "https://imicanada.org/"){
    $payment_email_address = 'imamiacanada@gmail.com';
    $payment_text          = 'You can easily donate by using our secure online payment portal or send your donation via PayPal to imamiacanada@gmail.com';
    $if_can = true;
}else if( site_url() == "https://medicsinternational.org/" ){
    $payment_email_address = $this->payment->paypal_form_details()->business_email;
    $payment_text          = 'You can easily donate by using our secure online payment portal or send your donation via Zelle to Mi@medicsinternational.org or Venmo us at @medicsinternational';
    $if_can = false;
}else{
    $payment_email_address = $this->payment->paypal_form_details()->business_email;
    $payment_text          = 'You can easily donate by using our secure online payment portal or send your donation via Zelle, Venmo or PayPal to '. $this->payment->paypal_form_details()->business_email .' (Please include your email address to receive your receipt.)';
    $if_can = false;
}
?>

<div class="left_area fl_lft col-md-8 donation-campaigns-full add_form">

    <h1><?php echo $campaign['name']; ?></h1>


    <img src="<?php echo $campaign['featured_image']; ?>" class="img-responsive" alt="">

    <p><?php echo $campaign['content']; ?></p>


    <?php if (!empty($campaign['gallery_images'])) : ?>
        <h2><?php echo lang_line('heading_image_gallery'); ?></h2>

        <div class="row">
            <div class="image_slider" style="width:100%;float:left;">
                <?php
                    foreach ($campaign['gallery_images'] as $key => $image) { ?>

                    <li>
                        <a href="javascript:;">

                            <img src="<?php echo $this->functions->timthumb($image['gallery_image'], 830, 480, FALSE, FALSE); ?>" alt="javascript slider" title="event_img_" .<?php echo $key; ?> />

                        </a>
                    </li>

                <?php }
                    ?>
            </div>
            <div class="image_slider_nav" style="width:100%;float:left;">
                <?php
                    $img            = array();
                    $a              = 0;

                    foreach ($campaign['gallery_images'] as $si) {
                        $img[$a]['src']             = $this->functions->timthumb($si['gallery_image'], $IMAGES_details['size']['width'], $IMAGES_details['size']['height'], FALSE, FALSE);
                        ?>
                    <a href="javascript:;">
                        <img src="<?php echo $this->functions->timthumb($si['gallery_image'], $IMAGES_details['thumb_size']['width'], $IMAGES_details['thumb_size']['height'], FALSE, FALSE); ?>" alt="" />
                    </a>
                <?php
                        $a++;
                    }

                    ?>
            </div>

        </div>
    <?php endif; ?>


    <?php 
        if (!empty($campaign['gallery_videos'])) : ?>
        <h2 style="padding-bottom: 5px"><?php echo lang_line('heading_video_gallery'); ?></h2>
        <?php echo $campaign['gallery_text']; ?>
            <div class="row">
                <div class="video_slider" style="width:100%;float:left;">
                    <?php
                        foreach ($campaign['gallery_videos'] as $key => $image) { ?>

                        <li>
                            
                                <?php echo $image['gallery_image']; ?>

                        </li>

                    <?php }
                        ?>
                </div>
                <div class="video_slider_nav" style="width:100%;float:left;">
                    <?php
                        $img            = array();
                        $a              = 0;

                        foreach ($campaign['gallery_videos'] as $si) {
                            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/{$si['desc']}.php"))[0];
                            
                            $img[$a]['src']             = $hash['thumbnail_small'];

                            ?>

                        <?php 
                            $thumbnail = $hash['thumbnail_small'];
                            if (strpos($si['gallery_image'], 'youtube') !== false) {
                                $thumbnail =  "https://img.youtube.com/vi/".$si['desc']."/hqdefault.jpg";
                            }
                            ?>    
                        <a href="javascript:;">
                            <!-- <img src="<?php // echo $hash['thumbnail_small']; ?>" alt="" /> -->
                            <img src="<?php echo $thumbnail; ?>" alt="" />
                        </a>
                    <?php
                            $a++;
                        }?>
                </div>
            </div>
        <?php endif; ?>
    

    <div class="row">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#updates-block"><?php echo lang_line('heading_updates'); ?></a></li>
        </ul>

        <div class="tab-content">
            <div id="updates-block" class="tab-pane fade in active">
                <ul class="list-group" id="updates">

                </ul>

                <div class="text-center">
                    <button class="btn bg-warning" id="updates_load_more" data-val="0" data-campaign_id="<?php echo $campaign['id']; ?>"><?php echo lang_line('button_view_more_updates'); ?> <img style="display: none; height: 25px" id="updates_loader" src="<?php echo str_replace('index.php', '', base_url()) ?>assets/frontend/images/ajax-loader.gif"> </button>
                </div>
            </div>
        </div>

    </div>

    
    <!-- <div id="feedback-block" class="hidden">
        <h2>Feedback From Donors</h2>


    </div> -->

</div>

<!-- Changes only start from here 17/2/2023 -->

<div class="left_area col-md-4 right-padding">
<div class="donation-campaigns-box">
    <?php 

        if ($campaign['id'] == 23 && site_url() == 'https://imamiamedics.com/') {
            ?>
              <style type="text/css">
                /*.donation-campaigns-details .donation-campaigns-box h2 .broder{
                       padding: 27px 14px 0px 30px !important;
                }
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before{
                       bottom: -38px !important;
                    mix-blend-mode: darken !important;
                    height: 40px!important;
                }
                .donation-campaigns-details .donation-campaigns-box .schl-icon{
                     padding: 0px 20px 10px !important;
                }
                .broder::before {
                    height: 81% !important;  
                }
                .inner-content{
                    padding: 27 !important;
                }

                .inner-content h4{
                    margin-left: 0px !important;
                }*/
                .right_text_sider_bar{
                        padding-left: 69%;
                         width: 102.6% !important;
                            }
                .sidebar-box .don-box {
                    transform: translateX(20px);
                }
                     .donation-campaigns-details .donation-campaigns-box h2 .broder::before{
                       bottom: -37px !important;
                    mix-blend-mode: darken !important;
                    height: 40px!important;
                }
                .donation-campaigns-details .donation-campaigns-box .schl-icon{
                     padding: 0px 20px 10px !important;
                }
                .donation-campaigns-details .donation-campaigns-box h2 .broder{
                       padding: 27px 14px 0px 30px !important;
                }
                .donation-campaigns-box{
                    margin: 0px 0px 0px 17px;
                     background: #f7f7f7;
                }
                  .donation-campaigns-details .donation-campaigns-box:before{
                    /*content: "Give in Honor of Someone";*/
                    font-size: 25px !important;
                       color: #ffffff !important;
                       background-color: #0070b0;
                       padding: 16px 18px;
                       width: 100%;
                       position: absolute;
                       bottom: -67px;
                }
                @media screen and (max-width: 1187px) {
                    .donation-campaigns-details .donation-campaigns-box:before { font-size: 17px !important; }
                    .donation-campaigns-details .donation-campaigns-box h2 .broder{ padding: 27px 14px 5px 30px; }
                    .donation-campaigns-details .donation-campaigns-box h2 .broder::before{ bottom: -35px; }
                    .donation-campaigns-details .donation-campaigns-box .schl-icon{ flex-wrap: wrap; justify-content: center; }
                    .donation-campaigns-details .donation-campaigns-box:before{ bottom: -56px; }
                    .sidebar-box .don-box .mainbox .title a { font-size: 20px; line-height: 1.5em; }
                    .sidebar-box .don-box .mainbox .shortdesc { font-size: 16px; line-height: 1.3em; }

                }

                @media screen and (max-width: 980px) {
                    .donation-campaigns-details .donation-campaigns-box{ margin: 0 0 80px; }
                    .donation-campaigns-details .donation-campaigns-box h2 .broder{ padding: 27px 14px 5px 30px!important; max-width: 500px; margin: 0 auto 40px; }
                    .donation-campaigns-details .donation-campaigns-box h2 .broder::before { bottom: -55px!important; }
                    .donation-campaigns-details .donation-campaigns-box .inner-content{ padding: 10px 0px; max-width: 500px; margin: auto; }
                    .donation-campaigns-details .donation-campaigns-box h4{margin-top: 10px !important; margin: 0px; margin-left: 0px !important;}
                    .donation-campaigns-details .donation-campaigns-box:before { max-width: 500px; left: 50%; transform: translate(-50%, 0%); }
                    .donation-campaigns-details .donation-campaigns-box .schl-btn-wrp {margin: 20px 0 20px 0; }
                    .right_text_sider_bar{padding-left: 0%; width: 100%!important;  }
                    .right_text_sider_bar p{ Text-align : center }
                    .mainBody .cmsarea h3{text-align: center; max-width: 500px; margin: auto;}
                    .sidebar-box .don-box { transform: translateX(0px); }
                }
                
                @media screen and (max-width: 800px) {
                    .donation-campaigns-details .donation-campaigns-box h2 .broder::before { bottom: -40px !important; max-width: 499px; width: 100%; background-size: 100% 100%; }                    
                }
                @media screen and (max-width: 667px) {
                    .donation-campaigns-details .donation-campaigns-box h2 .broder::before { bottom: -39px !important; max-width: 499px; width: 100%; background-size: 100% 100%; }
                    .sidebar-box .don-box { transform: translateX(0px); }
                }
                @media screen and (max-width: 580px) {
                    .donation-campaigns-details .donation-campaigns-box h2 .broder{ max-width: 100%; }
                }

                @media screen and (max-width: 500px) and (max-width: 660px){
                    .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                        bottom: -57px
                    }
                }
              /*       @media screen and (max-width: 600px) and (max-width: 659px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -52px
                }
            
                }*/
                .cutom_post_desc{
                       margin-left: 40px !important;
                       margin-right: 40px !important;
                        margin-top: 15px !important;
                        font-size: 20px !important;
                        margin-top: 40px !important;
                }
                .donate_btn{
                    margin-top: -30px !important;
                }
                   @media screen and (max-width: 991px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder {
                    padding: 44px 14px 14px 30px;
                   margin-bottom: 53px;
                }
                    .donation-campaigns-details .donation-campaigns-box .donate_btn {
                        max-width: 233px;
                        margin: auto;
                        display: inline-block;
                        float: none;
                        margin-top: 1px !important;
                    }
                }
             @media screen and (max-width: 991px){
            .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                bottom: -52px;
               }
            }
            @media only screen and (min-width: 801px) and (max-width: 999px) {
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -68px;
                    height: 100% !important;
                }
                .cutom_post_desc{
                    /*margin-left: 200px !important;*/
                    margin-top: 47px !important;
                }
            }
             @media only screen and (min-width: 807px) and (max-width: 999px) {
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -71px;
                    /*height: 100% !important;*/

                }
             } 

         /*     @media screen and (max-width: 356px){
            .inner-content {
                    width: 103% !important;
               }
            }
                */
            </style>
          <h2> <span  class="broder">Support</span></h2>
          <div class="inner-content" style="text-align: center !important;float: none !important;">
            <h4  class="cutom_post_desc" style="margin-top: 38px">Your help is <strong>needed</strong> now!</h4>
          </div>
            <?php
        }else if ($campaign['id'] == 26 && site_url() == 'https://imicanada.org/') {
            ?>
                     <style type="text/css">
                .broder::before {
                    height: 81% !important;  
                }
                .inner-content{
                    padding: 27 !important;
                }

                .inner-content h4{
                    margin-left: 0px !important;
                }

                  @media screen and (max-width: 500px) and (max-width: 800px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -67px
                }
            
                }
                     @media screen and (max-width: 500px) and (max-width: 660px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -57px
                }
            
                }
              /*       @media screen and (max-width: 600px) and (max-width: 659px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -52px
                }
            
                }*/
                .cutom_post_desc{
                       margin-left: 40px !important;
                        margin-top: 15px !important;
                        font-size: 20px !important;
                            margin-top: 30px !important;
                }
                .donate_btn{
                    margin-top: -30px !important;
                }
                   @media screen and (max-width: 991px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder {
                    padding: 44px 14px 14px 30px;
                   margin-bottom: 53px;
                }
                    .donation-campaigns-details .donation-campaigns-box .donate_btn {
                max-width: 233px;
                margin: auto;
                display: inline-block;
                float: none;
                margin-top: 1px !important;
            }
                }
             @media screen and (max-width: 991px){
            .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                bottom: -52px;
               }
            }
              @media only screen and (max-width: 800px) and (min-width: 660px)  {
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -57px !important;

                }
 
            }
          @media only screen and (min-width: 801px) and (max-width: 999px) {
              .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -68px;
                    height: 100% !important;

                }
                .cutom_post_desc{
                    /*margin-left: 200px !important;*/
                    margin-top: 47px !important;
                }
            }
             @media only screen and (min-width: 807px) and (max-width: 999px) {
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -71px;
                    /*height: 100% !important;*/

                }
             } 

         /*     @media screen and (max-width: 356px){
            .inner-content {
                    width: 103% !important;
               }
            }
                */
            </style>
          <h2> <span  class="broder">Support</span></h2>
          <div class="inner-content" style="text-align: center !important;    width: 103% !important;">
            <h4  class="cutom_post_desc">Your help is <strong>needed</strong> now!</h4>
          </div>


            <?php
        }else if($campaign['id'] == 23 && site_url() == 'https://medicsinternational.org/'){

?>
                     <style type="text/css">
                .broder::before {
                    height: 81% !important;  
                }
                .inner-content{
                    padding: 27 !important;
                }

                .inner-content h4{
                    margin-left: 0px !important;
                }

                  @media screen and (max-width: 500px) and (max-width: 800px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -67px
                }
            
                }
                     @media screen and (max-width: 500px) and (max-width: 660px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -57px
                }
            
                }
              /*       @media screen and (max-width: 600px) and (max-width: 659px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -52px
                }
            
                }*/
                .cutom_post_desc{
                       margin-left: 40px !important;
                        margin-top: 15px !important;
                        font-size: 20px !important;
                            margin-top: 30px !important;
                }
                .donate_btn{
                    margin-top: -30px !important;
                }
                   @media screen and (max-width: 991px){
                .donation-campaigns-details .donation-campaigns-box h2 .broder {
                    padding: 44px 14px 14px 30px;
                   margin-bottom: 53px;
                }
                    .donation-campaigns-details .donation-campaigns-box .donate_btn {
                max-width: 233px;
                margin: auto;
                display: inline-block;
                float: none;
                margin-top: 1px !important;
            }
                }
             @media screen and (max-width: 991px){
            .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                bottom: -52px;
               }
            }
              @media only screen and (max-width: 800px) and (min-width: 660px)  {
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -57px !important;

                }
 
            }
          @media only screen and (min-width: 801px) and (max-width: 999px) {
              .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -68px;
                    height: 100% !important;

                }
                .cutom_post_desc{
                    /*margin-left: 200px !important;*/
                    margin-top: 47px !important;
                }
            }
             @media only screen and (min-width: 807px) and (max-width: 999px) {
                .donation-campaigns-details .donation-campaigns-box h2 .broder::before {
                    bottom: -71px;
                    /*height: 100% !important;*/

                }
             } 

         /*     @media screen and (max-width: 356px){
            .inner-content {
                    width: 103% !important;
               }
            }
                */
            </style>
          <h2> <span  class="broder">Support</span></h2>
          <div class="inner-content" style="text-align: center !important;    width: 103% !important;">
            <h4  class="cutom_post_desc">Your help is <strong>needed</strong> now!</h4>
          </div>


            <?php














        }else{
              ?>
            <h2> <span class="broder"><?php echo lang_line('heading_goal'); ?></span><span class="broder-content"> $<?php echo $campaign['goal_amount']; ?></span></h2>
<div class="inner-content">
        
    <?php $percent = (filter_var($campaign['donation_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) / filter_var($campaign['goal_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) * 100; ?>

    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <h4><strong><?php echo lang_line('heading_raised'); ?>:</strong> $<?php echo !is_null($campaign['donation_amount']) ? $campaign['donation_amount'] : "0"; ?></h4>

            <?php
        }

     ?>
<!--     <h2> <span class="broder"><?php echo lang_line('heading_goal'); ?></span><span class="broder-content"> $<?php echo $campaign['goal_amount']; ?></span></h2>
<div class="inner-content">
		
    <?php $percent = (filter_var($campaign['donation_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) / filter_var($campaign['goal_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) * 100; ?>

    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <h4><strong><?php echo lang_line('heading_raised'); ?>:</strong> $<?php echo !is_null($campaign['donation_amount']) ? $campaign['donation_amount'] : "0"; ?></h4> -->



<!-- Changes only end  here 17/2/2023 -->


    <div class="fl_lft sec1_2 schl-btn-wrp">

        <a href="<?php echo $url; ?>" class="donate_btn">
            <?php $imageExist = file_exists("./assets/frontend/images/donate_btn_orange-".is_countryCheck(true)."_".strtolower(SessionHelper::_get_session('LANG_CODE')).".png"); ?>
            <img src="<?php echo base_url("assets/frontend/images/donate_btn_orange-".is_countryCheck(true)."_".strtolower($imageExist?SessionHelper::_get_session('LANG_CODE'):DEFAULT_LANG_CODE).".png");?>" alt="donate_btn" />
            <span class="sp1"></span>
            <span class="sp2"></span>
        </a>
    </div>
    <div class="fl_lft sec1_2 schl-icon">
        <?php echo lang_line('heading_share_this_cause'); ?>
        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
            <a class="a2a_button_facebook"></a>
            <a class="a2a_button_twitter"></a>
            <a class="a2a_button_linkedin"></a>
            <a class="a2a_button_pinterest"></a>
        </div>
    </div>
                </div>
                </div>
<?php if(!is_null($campaign['sidebar'])){?>
    <div class="fl_lft sec1_3 sidebar-box">
        <?php echo $campaign['sidebar']; ?>
    </div>
<?php } ?>

</div>
</div>
 <div class="row donation_area donation_desktop m_bottom25 left_area fl_lft donation-campaigns-full form_donate">
        <div class="DonateNow sameheight">
            <div class="hundred">
                <div class="form_sec fl_lft w_100 custom-border">
                    <form name="form_donate" action="<?php echo site_url(uri_string()); ?>" id="form_donate" method="post" enctype="multipart/form-data" novalidate>
                	<h3 style="text-align: center;"><?php echo lang_line('donte_form_heading', array($campaign['name'])); ?></h3>
                	<p style="text-align: center;"><?php echo $payment_text ?>
                        <!-- <input type="hidden" value="<?php //echo $this->payment->paypal_form_details()->business_email; ?>" name="business">
                        <input type="hidden" value="USD" name="currency_code">
                        <input type="hidden" value="<?php //echo $this->functions->_user_logged_in_details("id"); ?>" name="item_number"> -->
                        <input type="hidden" name="donation_mode" value="onetime">
                        <input type="hidden" name="donation_projects" value="<?php echo $campaign['donation_project_id']; ?>">

                        <div class="flALlLeft customclass less-class cutsom-margin-style">
                            <div class="col-sm-6 paddzERo">
                                <input id="name" name="donate_name" placeholder="<?php echo lang_line('text_name'); ?> * " class="form-control donationPclass" value="<?php echo set_value('donate_name', $from_name) ?>" class="form-control input-md wiDthDef" type="text">
                                <?php echo form_error('donate_name'); ?>
                            </div>
                            <div class="col-sm-6 paddRzERo">
                                <input id="email" name="donate_email" placeholder="<?php echo lang_line('text_email'); ?> * " class="form-control donationPclass" value="<?php echo set_value('donate_email', $email_address) ?>" class="form-control input-md" type="text">
                                <?php echo form_error('donate_email'); ?>
                            </div>
                        </div>
                        <div class="flALlLeft customclass less-class cutsom-margin-style">
                            <div class="paddzERo">
                                <?php
                                    $requied_add = '';
                                    if( site_url() == "https://imicanada.org/"){
                                        $requied_add = '*';
                                    }
                                ?>
                                <input id="address" name="donate_address" placeholder="Address <?php echo $requied_add; ?>" class="form-control donationPclass" value="<?php echo set_value('donate_address', $donate_address) ?>" class="form-control input-md wiDthDef" type="text">
                                <?php echo form_error('donate_address'); ?>
                            </div>
                        </div>

                        <div class="flALlLeft customclass less-class cutsom-margin-style">
                            <div class="col-sm-6 paddzERo custom-select-style">
                                <?php echo form_dropdown('home_country', DropdownHelper::country_dropdown(), set_value("home_country", $home_country), 'class="form-control"') ?>
                                <?php echo form_error('home_country'); ?>
                            </div>
                            <div class="col-sm-6 paddRzERo ">
                                <input id="donate_amount" name="donate_amount" placeholder="<?php echo lang_line('label_donate_amount'); ?> * " class="form-control" value="<?php echo set_value('donate_amount', ''); ?>" class="form-control input-md" type="text">
                                <?php echo form_error('donate_amount'); ?>
                            </div>
                        </div>

                        <div class="flALlLeft customclass less-class cutsom-margin-style donate_honoree">
                            <label class="fl_lft m_bottom5 m_rite10"> <?php echo lang_line('label_share_honoree_name'); ?> </label>
                            <input id="donate_honoree" name="donate_honoree" placeholder="<?php echo lang_line('label_honoree_name'); ?>" class="form-control" value="" class="form-control input-md" type="text">
                            <?php echo form_error('donate_honoree'); ?>
                        </div>

                        <div class="flALlLeft col-sm-12 no-padding m_bottom10 custom_style1">
                            <label class="fl_lft m_bottom5 m_rite10">
                                <?php
                                echo form_radio(array('name' => 'paymenttype', 'value' => 'paypal', 'checked' => TRUE, 'id' => 'paypal'));
                                echo lang_line('label_pay_paypal');
                                ?>
                            </label>
                            <?php
                            if(is_countryCheck(FALSE,FALSE,TRUE) != 'canada'){?>
                                <label class="fl_lft m_bottom5 m_rite10" style="<?php  echo $if_can ? 'display:none' : '' ?>">
                                    <?php
                                    $checked = isset($_POST['paymenttype']) && $_POST['paymenttype'] == "card" ? true : false;
                                    echo form_radio(array('name' => 'paymenttype', 'value' => 'card', 'checked' => $checked, 'id' => 'card'));
                                    echo lang_line('label_pay_card');
                                    ?>
                                </label>
                            <?php    
                            }
                            ?>
                            
                        </div>

                        <?php if (isset($card_error)) { ?>
                            <p class="form_error col-sm-12 no-padding">
                                <?php echo $card_error; ?>
                            </p>
                        <?php } 
                         if(is_countryCheck(FALSE,FALSE,TRUE) != 'canada'){
                        ?>

                        <div class="card-details col-sm-12 no-padding m_bottom10" style="<?php echo isset($_POST['paymenttype']) && $_POST['paymenttype'] == "card" ? 'display:block;' : 'display:none;'; ?>">
                            <div class="col-sm-12 no-padding scal-bttom">
                            <div class="col-sm-12 no-padding m_bottom10">
                                <div class="col-sm-6 paddzERo">
                                    <?php
                                    $card_name       = array(
                                        "name"          => "card_name",
                                        "id"            => "card_name",
                                        "value"         => set_value("card_name"),
                                        "class"         => "donationPclass",
                                        "placeholder"   => lang_line('label_card_holder') . " * "
                                    );

                                    echo form_input($card_name);

                                    echo form_error('card_name');
                                    ?>
                                </div>
                                <div class="col-sm-6 paddRzERo">
                                    <?php
                                    $card_number       = array(
                                        "name"          => "card_number",
                                        "id"            => "card_number",
                                        "value"         => set_value("card_number"),
                                        "class"         => "donationPclass",
                                        "placeholder"   => lang_line('label_card_no') . " * "
                                    );

                                    echo form_input($card_number);

                                    echo form_error('card_number');
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-12 no-padding m_bottom10">
                                <div class="col-sm-6 paddzERo">
                                    <?php
                                    $card_expiry       = array(
                                        "name"          => "card_expiry",
                                        "id"            => "card_expiry",
                                        "value"         => set_value("card_expiry"),
                                        "class"         => "donationPclass",
                                        "placeholder"   => lang_line('label_card_expiry') . " * "
                                    );

                                    echo form_input($card_expiry);

                                    echo form_error('card_expiry');
                                    ?>
                                </div>
                                <div class="col-sm-6 paddRzERo">
                                    <?php
                                    $card_cvv       = array(
                                        "name"          => "card_cvv",
                                        "id"            => "card_cvv",
                                        "value"         => set_value("card_cvv"),
                                        "class"         => "donationPclass",
                                        "placeholder"   => lang_line('label_card_cvv') . " * ",
                                        "pattern"       => "\d*",
                                        "maxlength"     => "4"
                                    );

                                    echo form_input($card_cvv);

                                    echo form_error('card_cvv');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <input id="hiderecap" type="hidden" value="" name="custom_grecap">

                    <div align="center" class="hundred">
                        <button id="givenow" class="submit_btn field_row" name="btn_donate_form" type="submit" onclick="addItem('givenow'); return false;" value="Donate"><?php echo lang_line('button_donate'); ?></button>
                    </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- <div class="left_area col-md-4">

    <div id="donors-block" class="hidden">
        <h4>Donors</h4>


    </div>

</div> -->


<script async src="https://static.addtoany.com/menu/page.js"></script>


<script>
    project_id = '<?php echo $campaign['donation_project_id']; ?>';
    campaign_id = '<?php echo $campaign['id']; ?>';
    $(document).ready(function() {

        var form_donate = '';
        // $(window).on('resize', function(){
            var win = $(this);         
            form_donate = $('.form_donate');
            if (win.width() >= 991) { 
                form_donate.appendTo('.add_form');
            }else{
                $(form_donate).insertAfter('.donation-campaigns-details');
            }
        // });

    
        getUpdates(0, campaign_id);

        var link_header = $('.strip-wrap a.donation-button');
        var link_footer = $('.fl_lft.sec1_2 > a.donate_btn');
        //link.attr('href', link.attr('href') + '?donation_campaign=<?php //echo $campaign['donation_project_id']; ?>');
        link_header.attr('href', '<?php echo $url; ?>');
        link_footer.attr('href', '<?php echo $url; ?>');
        
        $("#updates_load_more").click(function(e) {
            e.preventDefault();
            var page = $(this).data('val');
            var campaign_id = $(this).data('campaign_id');
            getUpdates(page, campaign_id);
        });

    });

    // Feedback Ajax call function
    var getUpdates = function(page, campaign_id) {
        $("#updates_loader").show();
        $.ajax({
            url: "<?php echo site_url('page/'.SLUG_DONATION_CAMPAIGNS.'/getUpdates') ?>",
            type: 'GET',
            data: {
                page: page,
                campaign_id: campaign_id
            }
        }).done(function(response) {
            if (response && response.length) {
                // $("#feedback-block").removeClass('hidden');
                var itemsList = '';
                JSON.parse(response).forEach(item => {
                    itemsList += '<li class="list-group-item">';
                    itemsList += '<p class="list-group-item-text">' + item.description + '</p>';
                    itemsList += '<p class="list-group-item-text">' + new Date(item.date.replace(/-/g, "/")).toShortFormat() + '</p>';
                    itemsList += '</li>';
                });
                $("#updates").append(itemsList);
                $('#updates_load_more').data('val', ($('#updates_load_more').data('val') + 1));
            }else{
                $('#updates_load_more').hide();
            }
            $("#updates_loader").hide();
            // scroll();
        });
    };

    // var scroll = function() {
    //     $('html, body').animate({
    //         scrollTop: $('#donors_load_more').offset().top
    //     }, 1000);
    // };


    Date.prototype.toShortFormat = function() {

        var month_names = ["Jan", "Feb", "Mar",
            "Apr", "May", "Jun",
            "Jul", "Aug", "Sep",
            "Oct", "Nov", "Dec"
        ];

        var day = this.getDate();
        var month_index = this.getMonth();
        var year = this.getFullYear();

        return "" + day + "-" + month_names[month_index] + "-" + year;
    }

    function timeSince(date) {

        var seconds = Math.floor((new Date() - date) / 1000);

        var interval = Math.floor(seconds / 31536000);

        if (interval > 1) {
            return interval + " years ago";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
            return interval + " months ago";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
            return interval + " days ago";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
            return interval + " hours ago";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
            return interval + " minutes ago";
        }
        return Math.floor(seconds) + " seconds ago";
    }
</script>




<style type="text/css">
    .slick-prev {
        left: 10px !important;
        z-index: 99999;
    }

    .slick-next {
        right: 10px !important;
        z-index: 99999;
    }

    .slick-frame {
        visibility: hidden;
    }

    .slick-frame.slick-initialized {
        visibility: visible;
    }

    #events_slider_nav .slick-current {
        border-bottom: 2px solid #f00;
        outline: none !important;
    }

    #events_slider_nav .slick-slide:focus {
        border-bottom: 2px solid #0070b0;
        outline: none !important;
    }

    /*#events_slider_nav .slick-track {*/
        /*transform: initial !important*/
    /*}*/
</style>



<link rel="stylesheet" type="text/css" href="<?php echo FOLDER_WIDGETS . 'slick-1.8.0/slick/slick.css' ?>" />
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="<?php echo FOLDER_WIDGETS . 'slick-1.8.0/slick/slick-theme.css' ?>" />

<script type="text/javascript" src="<?php echo FOLDER_WIDGETS . 'slick-1.8.0/slick/slick.js' ?>"></script>

<script type="text/javascript">

    // console.log('hello test')

    $('.video_slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        infinite: false,
        asNavFor: '.video_slider_nav'
    });
    $('.video_slider_nav').slick({
        slidesToShow: 8,
        slidesToScroll: 1,
        asNavFor: '.video_slider',
        dots: false,
        centerMode: false,
        focusOnSelect: true
    });
    $('.image_slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        infinite: false,
        asNavFor: '.image_slider_nav'
    });
    $('.image_slider_nav').slick({
        slidesToShow: 8,
        slidesToScroll: 1,
        asNavFor: '.image_slider',
        dots: false,
        centerMode: false,
        focusOnSelect: true
    });

    $('.don-box').on('click', function(e){
        $('[name="donate_amount"]').val($(this).data('amount'));
    });


    $(document).on('change', 'input[name="paymenttype"]', function() {
        if ($(this).val() == "card") {
            $('.card-details').show();
        } else {
            $('.card-details').hide();
        }
    });
    new Cleave('#card_number', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            // update UI ...
        }
    });
    new Cleave('#card_expiry', {
        date: true,
        datePattern: ['m', 'y']
    });

function addItem(id){
    $('#'+id).attr('disabled', true);
    $('#'+id).addClass('submitthis');
    grecaptcha.execute();
}
function onSubm(token){
    $("input#hiderecap").val(token);
    if($.trim(token)){
        $("button.submitthis").attr('disabled', false);
        $("button.submitthis").prop("onclick", null).off("click");
        $("button.submitthis").trigger("click");
        $("button.submitthis").attr('disabled', true);
    } else {
        $("button.submitthis").removeClass("submitthis");
    }
}
</script>
<?php // $sitekey = '6Le_N_QUAAAAAKzKoKE3aopntNguOy7ppf7kzafV'; ?>
<?php // $sitekey = '6LdhgZgiAAAAALhWuyg_E8B0U-Arv1f8HsSKA60R'; ?>
<?php $sitekey = '6LcOBmMkAAAAAC92VBaY63YoB3ndL9lG5LeG13Up'; ?>
<div class="g-recaptcha" data-sitekey="<?php echo $sitekey; ?>" data-size="invisible" data-callback="onSubm"></div>
</script>