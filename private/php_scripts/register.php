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
		$db->addUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['username']); 
		mkdir("../../" . $_POST['username']);
		copy("../default/me.jpg","../../" . $_POST['username'] . "/me.jpg");
		copy("../default/index.php","../../" . $_POST['username'] . "/index.php");
		$response .= ",'username':'" . $_POST['username'] . "'";
	}
	
	echo $response . '}';
?>