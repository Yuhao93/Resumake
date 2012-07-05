<?php 
	include('SimpleImage.php');
	$file = $_POST['file'];
	$x = $_POST['x'];
	$x = $_POST['y'];
	$width = $_POST['width'];
	$height = $_POST['height'];
	$path = '../../imgs/' . $file;
	$image = new SimpleImage();
	$image->load($path);
	$image->crop($x, $y, $width, $height);
	$image->save($path);
	//echo 'imgs/' . $file;
?>
