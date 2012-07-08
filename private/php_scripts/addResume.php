<?php 
	include_once "dbObject.php";
	$db = new dbObject();
	$db->connect();
	
	$content = $_POST['content'];
	$username = $_POST['username'];
	$name = $_POST['name'];
	$uid = $_POST['uid'];
	$output;
	
	//Write the raw resume data to the rmks folder
	$file = '../../rmks/' . $username . '.rmks';
	$fh = fopen($file, 'w');
	fwrite($fh, $stringData);
	fclose($fh);
	
	//Use a Java script to parse the raw data and return json
	$json = exec('java ../java_scripts/Parser ../../rmks/' . $username . '.rmks', $output);
	$finalOut = '';
	for($i = 0; $i < sizeof($output); $i ++)
		$finalOut .= $output[$i];
		
	$db->addResumeByUid($uid, $finalOut, $name);
?>