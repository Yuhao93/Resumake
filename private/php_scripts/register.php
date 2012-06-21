<?php
	$isOkay = true;
	$errors = array();
	$response = '{errors:[';
	
	include_once('dbObject.php');
	$db = new dbObject;
	$db->connect();
	
	if(!$db->getUserByUsername($_POST['username'])){
	}else{
		$isOkay = false;
		array_push($errors, "'username'");
	}
	
	if(!$db->getUserByEmail($_POST['email'])){}
	else{
		$isOkay = false;
		array_push($errors, "'email'");
	}

	for($i = 0; $i < count($errors); $i++){
		$response .= $errors[$i];
		if($i < count($errors) - 1)
			$response .= ',';
	}
	$response .= ']';
	
	if($isOkay){
		$username_64 = base64_encode($_POST['username']);
		$confirmation_code = base64_encode($username_64 + time() * rand(0,100));
		$db->addUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['username'], $confirmation_code); 
		
		$from = "mailer@resumake.thegbclub.com";
		$to = $_POST['email']; 
		$subject = "Welcome to Resumake!"; 
		$user_name = $_POST['name'];

		$message = "Hi $user_name,
		Thank you for registering for Resumake!
		
		Please confirm your account by clicking on this link:
		http://resumake.thegbclub.com/confirm?id=$confirmation_code
		
		Thank you,
		The Resumake Team";

		$headers = 'From: '. $from ."\r\n" .
		    'Reply-To: '. $to . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers); 
		
		$response .= ",'username':'" . $_POST['username'] . "'";
	}
	
	echo $response . '}';
?>