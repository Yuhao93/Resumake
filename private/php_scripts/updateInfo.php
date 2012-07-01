<?php 
	include_once('dbObject.php');
	$db = new dbObject;
	$db->connect();
	$uid = $_POST['uid'];
	$info = json_encode($_POST['info']);
	
	$db->updateUserInfo($uid, $info);
?>