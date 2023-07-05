<?php
$x = 0;
$TMP_button_text				= FALSE;
foreach ( $getinvolved -> result_array() as $gi )
{

	switch ( $gi['name'] )
	{
		case "Join Us":
			$TMP_button_text		= lang_line('button_joinnow');
			break;
			
		case "Volunteer":
			$TMP_button_text		= lang_line('button_supportus');
			break;
			
		case "Donate":
			$TMP_button_text		= lang_line('button_donatenow');
			break;
			
		default:
			$TMP_button_text		= lang_line('button_getinvolved');
			break;
			
	}

	if($x >= 4){
		break;
	}
	$x++;
	$cmsmenu_languages = $this->mixed_queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$gi['id']}")->result_array();
	replace_data_for_lang($gi, $content_languages, $cmsmenu_languages, ['name', 'subheading'], SessionHelper::_get_session('LANG_CODE') );	

	$TMP_content					= $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $gi['id'] ."' ");
	$TMP_attributes					= $this->functions->set_link_attributes( $gi, $TMP_content, SLUG_PAGE );

	if(!empty($TMP_content->row())){
		$cmscontent_languages = $this->mixed_queries->fetch_records("cmscontent_languages", " AND cmscontent_id = {$TMP_content->row('id')}")->result_array();
		replace_data_for_lang($TMP_attributes, $content_languages, $cmscontent_languages, ['short_desc'], SessionHelper::_get_session('LANG_CODE') );	
	}
	$count_column = count($getinvolved -> result_array());


?>

	<li class="Homeulli2 <?php echo 'column-'.$count_column; ?>">
        <div class="hwrap secHead">
            <div class="fl_lft heading">
                <label class="lbl1"><?php echo $gi['name'];?></label>
				<label class="lbl2"><?php echo $gi['subheading'];?></label>
            </div>
            
            <div class="fl_rit image">
            	<img src="<?php echo $this->functions->timthumb( $gi['photo_image'], 77, 59, FALSE, FALSE );?>" alt="<?php echo $gi['name'];?>" />
            </div>
        </div>
    
    <?php 
	if ( $TMP_attributes['short_desc'] )
	{
		echo $TMP_attributes['short_desc'];
	}
	
	

	
	if ( $TMP_button_text )
	{
	?>
        
        <a href="<?php echo ( $TMP_attributes['href'] );?>">
            <input class="getInvlvdRadiousBtn" value="<?php echo $TMP_button_text;?>" type="button">	
        </a>
    <?php
	}
	?>
    </li>
    
    
    
    
	
<?php
}
?>	