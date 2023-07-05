<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form rolespermissions">
		<tr>
		  	<th class="td_bg fieldKey">Permissions <?php echo required_field(); ?></th>
		  
		  	<?php
				$num_roles = 0;
				if (!empty($roles)) {
					$num_roles = count($roles);
                    foreach ($roles as $role) {
						echo '<th class="td_bg">'. $role->name .'</th>';
                    }
                }
			?>
	  	</tr>

	  	<?php
			$oper = array();
			if (!empty($operations)) {
				foreach ($operations as $key => $operation) {
					$oper[$operation->admin_role_id][$operation->operationid] = $operation->operationid;
				}
			}

			if (!empty($directories)) {
				
				$data = array();
				$d = _admin_permissions_list($directories,$data);
				foreach ($d as $directory) {
					echo '<tr>';
						echo '<td>';
							$margin = 10 * $directory->level;							
							if(is_has_child_admin_menu($directory->id)){
								$title = '<b>' . $directory->operation_title . '</b>';
							}else{
								
								$title = $directory->operation_title;
							}
							echo '<span style="margin-left:'.$margin.'px;">' .$title. '</span>';
						echo '</td>';
						
						for($a=0;$a<$num_roles;$a++){
							$id = '';
							$classes = '';

							$ids = array();
							$parents = _parent_menus_ids_by_child_id($directory->id, $ids);

							foreach ($parents as $key => $parent) {
								$classes .= ' child-' . $parent . $roles[$a]->id;
							}

							$check = '';
							if ( isset($oper[$roles[$a]->id]) )
							{
								$check = in_array($directory->operationid,$oper[$roles[$a]->id]) ? 'checked="checked"' : '';
							}

							if ( is_has_child_admin_menu($directory->id) ){
								$classes .= ' parent';
								$id = 'parent-' . $directory->id . $roles[$a]->id;
							}
							echo '<td><input type="checkbox" id="'.$id.'" class="'.$classes.'" name="permission['.$roles[$a]->id.']['.$directory->operationid .']" value="1" '. $check .'></td>';
						}

					echo '</tr>';
				}
			}
		?>
		
  </table>
    
    <div class="crud_controls">
        <button type="submit" data-operationid="manageadminrolepermissionssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
    </div>

</form>