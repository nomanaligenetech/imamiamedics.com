<?php

//echo "<pre>";
//print_r($this->functions->_user_logged_in_details("is_member")); die;
  if ( $this->functions->_user_logged_in_details( "is_member" ) ==1)
  { ?>
<div class="pressReleaseContainer">
<?php
      foreach ($iminews as $row )
       { 
  ?>
  <div class="PressRelease bgpress_media" >
<div class="subdetailWrap">
    <div class="detailLft">
    <div class="presWRimg">

      <div class="floatrght_press">
      
<!-- <div class="pressReleaseDate">
      <span><?php echo $row->date; ?></span>
    </div> -->
    </div>
   </div>
   </div>
   <div class="detailRght">


<div class="pressReleaseTitle bgpresstitle">
     <span> <?php echo $row->name;  ?>  </span> 
     </div>
<div class="destile_media">
<?php  

    $content = preg_replace("/<img[^>]+\>/i", "(image) ", $row->description); 

    $string = strip_tags($content);

    $stringCut = substr($string, 0, 330);
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
    echo $string.'<a href="'.site_url().''.'page/'.$menu_slug.'/'.SLUG_IMI.'/'.$row->slug.'">..Read More</a>';

  ?>
</div>
   
   </div>
  
  </div>

    <div class="margBoth_btn">
      <!--  <div class="preswrpDetail"> -->

        <!-- <div class="pressReleaseDescription">-->
           <!-- <a href="<?php echo site_url().'page/'.$menu_slug.'/'.SLUG_IMI.'/'.$row->slug;?>">View Detail</a>-->
       <!-- </div>-->
      <!--  </div> -->

      <div class="mediaDownloads">

         <?php 
          $pdf=$this->queries->fetch_records("news_pdf","AND parentid={$row->id}")->result()[0];
     
            if(isset($pdf->news_pdf)!=""){
            ?>

        <div class="MediaReleasePdf"> 
       
           
           <div class="pressPdftitle">

            <a href="<?php echo site_url().$pdf->news_pdf;?>"><?php echo "Download Pdf"; ?> </a>
          </div>
           
       </div>
       <?php
              } 
           ?>

      </div>
      </div>


      </div>

<?php } ?>

</div>
<?php }else{ 
  echo "Thank you for visiting this page. This page is only  available for IMI Members."; 
 } ?>