<table width="100%" class="table table_form">

<tr>
<td class="td_bg">Left   Widgets</td>
<td class="td_bg">
<?php
$TMP_widgets				= "<ol class='ilinks_sortable'>";
foreach ( left_widgets( FALSE, FALSE, $left_widget_id ) as $key => $value)
{


$TMP_input			= '<input type="checkbox" name="left_widget_id[]" value="'. $value["id"] .'" ' 
            . set_checkbox('left_widget_id[]', $value["id"], format_bool( $left_widget_id[$value["id"]], $value["id"]  )).' />';

$TMP_widgets		.= "<li>". $TMP_input . " " . $value['name'] . "</li>";
}
$TMP_widgets				.= "</out>";

echo $TMP_widgets;
?>
</td>
</tr>               

<tr>
<td class="td_bg">Right Widgets</td>
<td class="td_bg">
<?php
$TMP_widgets				= "<ol class='ilinks_sortable'>";
foreach ( right_widgets( FALSE, FALSE, $right_widget_id ) as $key => $value)
{
 
    $TMP_input			= '<input type="checkbox" name="right_widget_id[]" value="'. $value["id"] .'" '
                            . set_checkbox('right_widget_id[]', $value["id"], format_bool( $right_widget_id[$value["id"]], $value["id"]  )).' />';
        
    $TMP_widgets		.= "<li>". $TMP_input . " " . $value['name'] . "</li>";
}
$TMP_widgets				.= "</out>";

echo $TMP_widgets;
?>
</td>
</tr>

<tr>
<td class="td_bg">Center Widgets</td>
<td class="td_bg">
<?php
$TMP_widgets				= "<ol class='ilinks_sortable'>";
foreach ( center_widgets( FALSE, FALSE, $center_widget_id ) as $key => $value)
{
 
    $TMP_input			= '<input type="checkbox" name="center_widget_id[]" value="'. $value["id"] .'" '
                            . set_checkbox('center_widget_id[]', $value["id"], format_bool( $center_widget_id[$value["id"]], $value["id"]  )).' />';
        
    $TMP_widgets		.= "<li>". $TMP_input . " " . $value['name'] . "</li>";
}
$TMP_widgets				.= "</out>";

echo $TMP_widgets;
?>
</td>
</tr>

</table>