<?php
include_once("dbObject.php");
$db = new dbObject();
$db->connect();

$request = $_POST['request'];

if($request == 'delete'){
    $db->deleteResumesByRid($_POST['resumes']);
}

?>