<div class="pressReleaseContainer">
  <?php
 	foreach ($pressreleasedetail as $row )
  { 
?>
  <div class="PressRelease" >

    <div class="preswrpLeft">
    <div class="presWRapinlef">

      <div class="floatrght_press">
      <div class="pressReleaseTitle">
     <span> <?php echo $row->name;  ?>  </span> 
      </div>

    <div class="pressReleaseDate">
      <span><?php echo $row->pressreleas_date; ?></span>
    </div>
    </div>
   </div>
   <div class="presWRapinrght">
    <div class="pressReleasePdf"> 
      <div  class="pressPdfimg"></div>
       
       <div class="pressPdftitle"><?php if($row->pressrelease_pdf!=""){?>
        <a href="<?php echo site_url().$row->pressrelease_pdf;?>"><?php echo "click to download"; //$row->pressrelease_pdf;?> </a>
          <?php } else {?>
      <?php echo '<a class="noPdfMsg" href="javascript:;">No pdf document found</a>';} ?>
      </div>
   </div>

   </div>
   </div>

   <div class="preswrpright">
 
    <!-- <div class="pressReleaseDescription">-->
        <a href="<?php echo site_url().'page/'.$menu_slug.'/'.SLUG_PRESS.'/'.$row->slug;?>">View Detail</a>
   <!-- </div>-->
  </div>

  </div>

    <?php } ?>
  </div>
</div>