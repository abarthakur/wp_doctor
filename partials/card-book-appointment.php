<?php
$primary_num = get_option( 'primary-phone-number' );
?>
<div class="card sidebar-card shadow-hover sidebar-appointment-card  d-flex flex-column justify-content-between">
	<h3>Request an appointment now</h3>
	<hr>
	<p class="appointment-buttons">
		<a class="btn btn-primary form-button" href="<?php echo esc_url(home_url('/'));?>#appointments" role="button">Form</a>
		<a class="btn btn-primary call-button" href="tel:<?php echo $primary_num;?>" role="button">Call</a>
	</p>
</div>