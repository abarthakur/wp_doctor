<?php
/* --------------------------------------------------------------------
Contact Form
-------------------------------------------------------------------- */

require_once get_stylesheet_directory() . "/includes/utils.php";

$container_classes="";
if ($args && array_key_exists("container_classes",$args) && $args["container_classes"]){
	$container_classes=trim($args["container_classes"]);
}

$pow_options=array( 
	array( "label" =>"Barthakur Clinic",
			"input_name" => "message_bcpl_yes"),
	array("label" =>"Ayursundra",
		"input_name" => "message_ayursundra_yes")
);

$timings_options=array( 
	array( "label" =>"9 AM - 11 PM",
			"input_name"=> "message_time_9_11"),
	array(	"label" =>"1 PM - 5 PM",
			"input_name"=> "message_time_1_5"),
	array("label" =>"6 PM - 8 PM",
		"input_name"=> "message_time_6_8")
);
?>
<div class="appform-container horizontal-align <?php echo $container_classes;?>">
	<div class="vertical-align">
		<form method="post" class="appform">	
			<input type="hidden" name="submitted" value="1">
			<input type="hidden"  name="formType" value="appointment">
			<div class="form-group">
				<input type="text" class="form-control" name="message_name" 
				placeholder="Your name..." minlength="5" maxlength="30" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="message_phn" 
				placeholder="+91-88888-88888" minlength="10" max-length="13" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="message_email" 
				placeholder="youremail@example.com" minlength="10" max-length="30" required>
			</div>
			<?php
				print_checkbox_group("Preferred Location",$pow_options);
				print_checkbox_group("Preferred Time",$timings_options);
			?>
			<div class="details-form-group">
				<label>Details</label>
				<textarea rows="4" placeholder="I am experiencing severe nausea and..." name="message_details" maxlength="300"></textarea>
			</div>
			<div class="appform-submit-container">
				<button type="submit">Submit</button>
			</div>
		</form>
	</div>
</div>