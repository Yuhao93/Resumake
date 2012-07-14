<?php
    $email = $_POST['email'];

    include_once('dbObject.php');
    $db = new dbObject;
	$db->connect();
    $db->addEmail($email);
    
    echo $email;
?>