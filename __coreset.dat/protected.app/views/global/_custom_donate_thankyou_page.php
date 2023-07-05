<?php
//~r(array_reverse(get_defined_vars()));
if ( isset( $content ) )
{
	// echo $content;
}
?>
<div class="new-donate-page">
	<div class="donate-div-view">
		<div class="donate_form_continer">
			<div class="donate-form-container">
				<div class="form-section step-cause completetab">
					<h3 class="step-title ntab_1">
						<span>01</span> Select Cause
					</h3>
					
				</div>
				<div class="form-section step-amount completetab">
					<h3 class="step-title ntab_2">
						<span>02</span> Select Amount
					</h3>
															
				</div>
				<div class="form-section step-checkout completetab">
					<h3 class="step-title ntab_3">
						<span>03</span> Single Checkout
					</h3>
					
				</div>
				<div class="form-section step-completed activetab">
					<h3 class="step-title ntab_4">
						<span>04</span> Completed
					</h3>
					<div class="fields-contianer nfieldset_4 donate-thankyou" style="display: block;">
						<?php if(isset($custom_donate_ty_data)){ ?>
							<h3><?php echo $custom_donate_ty_data['title']; ?></h3>
							<p><?php echo $custom_donate_ty_data['message']; ?></p>
						<?php } else { ?>
							<p>Donation completed!</p>
						<?php }  ?>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>