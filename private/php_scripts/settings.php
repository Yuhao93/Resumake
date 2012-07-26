<?php
    include_once('dbObject.php');
    $db = new dbObject();
    $db->connect();
    
    $request = $_POST['request'];
    $uid = $_POST['uid'];
    
    if($request == 'sendEmail'){
        $db->requestPasswordChange($uid);
    }else if($request == 'changePassword'){
        $password = $_POST['password'];
        $code = $_POST['code'];
        setNewPassword($uid, $password, $code)
    }
?>