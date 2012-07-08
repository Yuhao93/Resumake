<?php 
	include('SimpleImage.php');
	include('dbObject.php');

	$username = $_POST['username'];
	$file = $_POST['file'];
	$x = $_POST['x'];
	$y = $_POST['y'];
	$width = $_POST['width'];
	$height = $_POST['height'];
	$path = '../../imgs/' . $file;
	$image = new SimpleImage();
	$image->load($path);
	$image->crop($x, $y, $width, $height);
	$image->save($path);

	$db = new dbObject;
	$db->connect();	
	$db->addImagePathByUsername('imgs/' . $file, $username);

	echo 'imgs/' . $file;
?>
