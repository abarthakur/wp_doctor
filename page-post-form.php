<?php
$response=array();
if ($_POST && array_key_exists("submitted",$_POST) && $_POST['submitted']){
	$response["success"]=False;
	if($_POST['formType']=="appointment"){
		$appointment_details=validate_appointment_form();
		if ($appointment_details){
			$sent=send_appointment_email($appointment_details);
			$response["success"]=$sent;
		}
	}

	echo json_encode($response);
}
else{
	echo 'Oops, you shouldn\'t be here...<a href="' . esc_url( home_url( '/' ) ) .'"> Go back </a> ';
}

function validate_appointment_form(){
	global $response;
	$response["success"]=True;
	
	$text_fields=array(
		array(
			"field_name"=>"submitted",
			"mandatory"=>True,
		),
		array(
			"field_name"=>"formType",
			"mandatory"=>True,
		),
		array(
			"field_name"=>"message_name",
			"mandatory"=>True,
			"min" => "5",
			"max" => "30"
		),
		array(
			"field_name"=>"message_phn",
			"mandatory"=>True,
			"min" => "5",
			"max" => "13"
		),
		array(
			"field_name"=>"message_email",
			"mandatory"=>True,
			"min" => "5",
			"max" => "30"
		),
		array(
			"field_name"=>"message_details",
			"mandatory"=>False,
			"max" =>"400"
		)
	);
	
	$checkbox_fields= array(
		array(
			"field_name"=>"message_bcpl_yes",
			"mandatory"=>False,
		),
		array(
			"field_name"=>"message_ayursundra_yes",
			"mandatory"=>False,
		),
		array(
			"field_name"=>"message_time_9_11",
			"mandatory"=>False,
		),
		array(
			"field_name"=>"message_time_1_5",
			"mandatory"=>False,
		),
		array(
			"field_name"=>"message_time_6_8",
			"mandatory"=>False,
		)
	);

	$appointment_details=check_empty_and_fill($text_fields);
	$appointment_details=array_merge($appointment_details,check_empty_and_fill_checkbox($checkbox_fields));
	if (!$response["success"]){
		return False;
	}
	check_min_max_length($text_fields);
	if (!$response["success"]){
		return False;
	}
	return $appointment_details;
}

function check_empty_and_fill($fields)
{	
	global $response;
	$my_post=array();
	foreach($fields as $field){
		if (!array_key_exists($field["field_name"],$_POST) || empty($_POST[$field["field_name"]])){
			if ($field["mandatory"]){
				$response["success"]=False;
				if (!array_key_exists("required",$response) || !is_array($response["required"])){
					$response["required"]=array();
				}	
				array_push($response["required"],$field["field_name"]);
			}
			elseif($response["success"]){
				$my_post[$field["field_name"]]="";
			}
		}
		else{
			$data=$_POST[$field["field_name"]];
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data); 
			$my_post[$field["field_name"]]=$data;
		}
	}
	return $my_post;
}

function check_empty_and_fill_checkbox($fields)
{	
	global $response;
	$my_post=array();
	foreach($fields as $field){
		if (array_key_exists($field["field_name"],$_POST) && $_POST[$field["field_name"]]==True ){
			$my_post[$field["field_name"]]=True;
		}
		else{
			$my_post[$field["field_name"]]=False;
		}
	}
	return $my_post;
}


function check_min_max_length($fields)
{
	global $response;
	foreach($fields as $field){
		if (array_key_exists("min",$field) and strlen($_POST[$field["field_name"]]) < intval($field["min"])){
			$response["success"]=False;
			if (!array_key_exists("minimum",$response) || !is_array($response["minimum"])){
				$response["minimum"]=array();
			}	
			array_push($response["minimum"],$field["field_name"]);
		}

		if (array_key_exists("max",$field) and strlen($_POST[$field["field_name"]]) > intval($field["max"])){
			$response["success"]=False;
			if (!array_key_exists("maximum",$response) || !is_array($response["maximum"])){
				$response["maximum"]=array();
			}	
			array_push($response["maximum"],$field["field_name"]);
		}

	}
}


function send_appointment_email($appointment_details)
{
	$human_readable = array ("message_name"=>"Name",
							"message_phn" => "Phone number",
							"message_email"=> "Email");
	$to="dev@doctorayona.com";
	$subject="Appointment Request | " . $appointment_details["message_name"];
	$message="";
	foreach ($appointment_details as $key => $value){
		if (array_key_exists($key,$human_readable)){
			$key = $human_readable[$key];
		}
		$message .= $key . ":\t";
		$message .= $value . "\n";
	}
	$headers = 'From: '. 'dev@doctorayona.com' . "\r\n" ;
  	$headers .=	'Reply-To: ' . $appointment_details["message_email"] . "\r\n";
	
	$sent = wp_mail($to, $subject, $message, $headers);
	return $sent;
}
?>