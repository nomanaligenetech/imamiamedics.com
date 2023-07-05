<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
		  <td class="td_bg fieldKey"><strong>Visitor Types  <?php echo required_field(); ?></strong></td>
		  <td class="td_bg fieldValue">
          
			<?php
            if ( $visitor_types->num_rows() > 0 )
            {
				foreach ( $visitor_types->result_array() as $vt )
				{
				
					if ( in_array( $vt['id'], $visitortypes_id ) )
					{
					?>
                     
                   	  <div class="input-group">
                        	
                            <div class="visitor_types">
                                 <?php echo $vt['name'];?>
                                
                            </div>
                            
            </div>
                        
						
					<?php	
					}
				}
            }
            ?>
        
        
          
          </td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Conference Topics <?php echo required_field(); ?></strong></td>
		  <td class="td_bg">
          	<?php
			$TMP_topics_description				= array();
			if ( $conference_topics->num_rows() > 0 )
			{

				foreach ( $conference_topics->result_array() as $ct )
				{
					if ( in_array( $ct['id'], $conferencetopics_id ) )
					{
						if ( $ct['description'] != '' )
						{
							$TMP_topics_description[]			= $ct['description'];
						}
						?>	
							<div class="input-group">
								<div class="conference_topics">
									<?php  echo $ct['name'];?>								
								</div>
							</div>
						<?php	
					}
				}
			}
			
			
			if ( count($TMP_topics_description) > 0 )
			{
				echo implode("<br />", $TMP_topics_description);
			}
			?>
         </td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Title</strong></td>
		  <td class="td_bg"><div class="input-group">
          <?php
			echo set_value("title", $title );
			?>
          </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Poster Presenter/ Speaker</strong></td>
		  <td class="td_bg"><div class="input-group">
          <?php
			echo set_value("presenter_speaker", $presenter_speaker );
			?>
          </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Affiliation</strong></td>
		  <td class="td_bg"><div class="input-group">
          <?php
			echo set_value("affiliation", $affiliation );
			?>
          </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Address</strong></td>
		  <td class="td_bg"><div class="input-group">
          <?php
			echo set_value("address", $address );
			?>
          </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Email</strong></td>
		  <td class="td_bg"><div class="input-group">
          <?php
			echo set_value("email", $email );
			?>
          </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Phone</strong></td>
		  <td class="td_bg"><div class="input-group">
          	<?php
			echo set_value("phone", $phone );
			?>
          </div></td>
	  </tr>
		<tr class="">
		  <td class="td_bg">&nbsp;</td>
		  <td class="td_bg">&nbsp;</td>
	  </tr>
		<tr class="clear_border_bottom">
		  <td class="td_bg"><strong>Others</strong></td>
		  <td class="td_bg">
          <table width="100%">
          	<tr>
              <td><strong>Other (Author)</strong></td>
              <td><strong>Other (Affiliation)</strong></td>
            </tr>
          	<?php
            for ( $i = 0; $i < count($author); $i++ )
            {
                ?>
                    
                    <tr>
                        <td width="50%"  >
                        <div class="input-group">
                        <?php
						echo $author[ $i ];
                        ?>
                        </div>
                        </td>
                        
                        <td width="50%"  >
                        <div class="input-group">
                        <?php
                        echo $affiliations[ $i ];
                        ?>
                        </div>
                        </td>
                    </tr>
                <?php
            }
			?>
          </table>
          </td>
	  </tr>
      
      <tr class="clear_border_bottom">
		  <td class="td_bg">&nbsp;</td>
		  <td class="td_bg">&nbsp;</td>
	  </tr>
		
		<tr>
		  <td class="td_bg"><strong>Introduction</strong></td>
		  <td class="td_bg">
          	<div class="input-group">
			<?php
			echo set_value("introduction", $introduction);
            ?>
            </div>
          </td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Methods</strong></td>
		  <td class="td_bg">
          <div class="input-group">
			<?php
            echo set_value("methods", $methods);
            ?>
            </div>
          </td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Results</strong></td>
		  <td class="td_bg">
          <div class="input-group">
			<?php
            echo set_value("results", $results);
            ?>
            </div>
          </td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Conclusion</strong></td>
		  <td class="td_bg">
          <div class="input-group">
			<?php
            echo set_value("conclusion", $conclusion);
            ?>
            </div>
          </td>
	  </tr>
		
		<tr>
		  <td class="td_bg"><strong>Keywords</strong></td>
		  <td class="td_bg"><div class="input-group">
		    <?php
			echo set_value("keywords", $keywords ) ;
			?>
		  </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Acknowledgements</strong></td>
		  <td class="td_bg"><div class="input-group">
		    <?php
			echo set_value("acknowledgements", $acknowledgements );
			?>
		  </div></td>
	  </tr>
		
		<tr>
		  <td class="td_bg"><strong>Academic Level</strong></td>
		  <td class="td_bg"><div class="input-group">
		    <?php
			echo set_value("academic_level", $academic_level );
			?>
		  </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Nationality</strong></td>
		  <td class="td_bg"><div class="input-group">
		    <?php
			echo set_value("nationality", $nationality );
			?>
		  </div></td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Passport Number</strong></td>
		  <td class="td_bg">
          <div class="input-group">
		    <?php
			echo set_value("passport_number", $passport_number );
			?>
		  </div></td>
	  </tr>
		
		<tr>
		  <td class="td_bg"><strong>Region</strong></td>
		  <td class="td_bg">
          <div class="input-group">
		    <?php
			echo DropdownHelper::conferenceregions_dropdown(TRUE, set_value("regionid", $regionid ));
			?>
		  </div>
          </td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Would you like to present another poster or oral presentation?</strong></td>
		  <td class="td_bg">
          <?php echo $another_presentation_name;?>
          </td>
	  </tr>
		<tr>
		  <td class="td_bg"><strong>Will you be accompanied by your family</strong></td>
		  <td class="td_bg">
          <?php echo $accompanied_by_family_name;?>
          </td>
	  </tr>
		
		<tr>
		  <td class="td_bg"><strong>Status</strong></td>
		  <td class="td_bg">
          
          	<div class="input-group">
				<?php echo set_value("status_name", $status_name)?>
            </div>
            
          </td>
	  </tr>
	


		
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
       
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>