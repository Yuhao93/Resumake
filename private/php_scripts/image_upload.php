<?php
	$username = $_POST['username'];
	$tmp_img = $_FILE['img']['tmp_name'];
	$new_name = '../../imgs/' . $tmp_img . '-' . $username;
	move_uploaded_file($tmp_img, $new_name);
	echo $new_name;
?>










