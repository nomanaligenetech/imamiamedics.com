<?php
$TMP_array						= array("boardid"			=> $boardid,
										"extra_cond"		=> "ORDER BY sort ASC");

$TMP_designations				= $this->mixed_queries->fetch_records("chapterpersons_by_boardid", 
																	  $TMP_array, 
																	  "	DISTINCT( designationid ) as designationid,sort, 
																	  	(SELECT name FROM tb_designation WHERE id = tb_chapterpersons_master.designationid) as designation_name ");
if ( $TMP_designations -> num_rows() > 0 )
{
	$BOARD_details				= $this->mixed_queries->fetch_records("boards", " AND id = '". $boardid ."' ", "name");
?>
<?php //echo $name;
$text=lang_line('heading_board_regents');
//if(strpos($name , $text)!==false){ echo 'true';}else{ echo 'false';} 

?>
<!--w_31_half-->
    <div class="Temp3_cols Temp_Right_Right <?php if(strpos($name , $text)!==false){ echo 'w_100';}else{ echo 'w_31_half';} ?> fl_rit m_bottom30">
    
   <!-- <div class="Temp3_cols Temp_Right_Right w_31_half fl_rit m_bottom30">-->
        <div class="right_top_title"><?php echo $BOARD_details->row("name");?></div>
        
        <div class="Temp_Right_Right_bottom">
        	<?php
			foreach ( $TMP_designations -> result_array() as $d )
			{
				$TMP_array						= array("designationid"		=> $d['designationid'],
														"boardid"			=> $boardid,
														"extra_cond"		=> "ORDER BY sort ASC");
				
				$person_details				= $this->mixed_queries->fetch_records("chapterpersons_by_boardid", $TMP_array);
			?>
                <!-- <h2 class="h2_redstyle1"><?php echo $d['designation_name'];?></h2> -->
                
                
                <?php
				if ( $person_details -> num_rows() > 0 )
				{
				?>
                    <ul class="persons m_bottom25 fl_lft w_100">
                    	<?php
						foreach( $person_details->result_array() as $pd)
						{
						?>
                            <li>
                                <div class="avator">
                                	<?php echo $this->functions->runtime_image($pd["photo_image"], "53");?>
                                </div>
                                
                                 <div class="avator_desc">
									<span class="profileName">
									<?php 
										echo $pd['profile_link'] != "" ? '<a href="'.$pd['profile_link'].'">' : '';
										echo $pd['name'];
										echo $pd['profile_link'] != "" ? '</a>' : '';
									?>
									</span>
                                    <br />
                                    <span class="pJobTitle"><?php echo $pd['job_title'];?>&nbsp;</span>
                                   <?php if(strpos($name , $text)!==false) echo $pd['biography'];?>
                                </div>
                            </li>
                        <?php
						}
						?>
                    </ul>
                    <?php
				}
				break;
			}
			?>
        </div>
    </div>
<?php
}
?>