<?php
if ( $_is_breadcrumbs )
{
?>
	<div class="breadcrumbs cont2">
		<div class="cont1">
			<ul>
				<?php
				$TMP_count_breadcrumbs					= 0;
				foreach ( $_is_breadcrumbs as $k => $v )
				{
					$TMP_count_breadcrumbs++;
					
					echo '<li>';
					if ( array_key_exists("is_active", $v ) )
					{
						echo $v['name'];
					}
					else if ( !array_key_exists("link", $v ) )
					{
						echo '<a href="javascript:;">'. $v['name'] .'</a>';
					}
					else
					{
						echo '<a href="'. $v['link'] .'">'. $v['name'] .'</a>';
					}
					echo '</li>';
					
					
					
					if ( $TMP_count_breadcrumbs != count($_is_breadcrumbs) )
					{
						echo '<li>/</li>';	
					}
				}
				?>
			</ul>
		</div>
	</div>
<?php
}
?>