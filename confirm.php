<?php 
	include_once('private/php_scripts/dbObject.php');
	$db = new dbObject;
	$db->connect();
	
	$get_id = $_GET['id'];
	$user = $db->getUserByConfirmationCode($get_id);
	if(!$user)
		echo 'User Not Found';
	else if($user->is_confirmed){
		echo 'User Already Registered';
	}else{
		$uid = $user->uid;
		$db->confirmUser($uid);
		echo 'User Registered';
	}
?>