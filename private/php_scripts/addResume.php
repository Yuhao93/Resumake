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
	fwrite($fh, $content);
	fclose($fh);
	
	//Use a Java script to parse the raw data and return json
	$execStr = 'java -Xmx64m -cp ../java_scripts Parser ' . $username . '.rmks';

	exec($execStr, $output); 	

	$finalOut = $output[0];
		
	$db->addResumeByUid($uid, $finalOut, $name);
?>
