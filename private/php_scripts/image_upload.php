<?php
	$username = $_POST['username'];
	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = '../img/' . $username . '.png';
	file_put_contents($file, $data);
?>










