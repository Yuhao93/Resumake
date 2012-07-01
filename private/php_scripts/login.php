<?php 
	include_once('dbObject.php');
	$db = new dbObject;
	$db->connect();

	$email = $_POST['email'];
	$password = $_POST['password'];
	$remeber = $_POST['remember'];
	$user = $db->getUserByEmail($email);
	
	if($user->password == $password){
		//good to go
		$uid = $user->uid;
		$_SESSION['uid'] = $uid;
		setcookie("remember", $uid, time()+(60 * 60 * 24 * 14), "/");
		echo '{"result":pass, "username":' . $user->username . '}';
	}else{
		echo '{"result":fail}';
	}
?>
