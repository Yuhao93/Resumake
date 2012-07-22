<?php
    include_once("dbObject.php");
    $db = new dbObject();
    $db->connect();
    
    $uid = $_POST['uid'];
    $request = $_POST['request'];
    
    if($request == 'push'){ 
        $name = $_POST['name'];
        $content = json_encode($_POST['content']);
        echo $content;
        $db->pushDraft($content, $name, $uid);
    }
    
    if($request == 'get'){
        return $db->getLatestDraft($uid);
    }
    
    if($request == 'clear'){
        $db->clearDraft($uid);
    }
?>