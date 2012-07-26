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
        $db->setNewPassword($uid, $password, $code);
    }else if($request == 'changeUsername'){
        $username = $_POST['username'];
        $db->setNewUsername($uid, $username);
    }else if($request == 'delete'){
        $password = $_POST['password'];
        $db->removeAccount($uid, $password);
    }
?>