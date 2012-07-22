<?php
include_once("dbObject.php");
$db = new dbObject();
$db->connect();

$request = $_POST['request'];

if($request == 'delete'){
    $username = $_POST['username'];
    $uid = $_POST['uid'];
    $content = '[';
    $db->deleteResumesByRid($_POST['resumes'], $uid);
    $resumes = $db->getResumesByUid($uid);
    foreach($resumes as $resume){
        $content .= '\'<tr>';
        $content .= '<td>';
        $content .= '<div class="btn-checkbox btn-item-label" rid-label="' . $resume->rid . '"></div>';
        $content .= '</td>';
             
        $content .= '<td>';
                            
        $content .= '<a href="../rmks/' . addslashes($username) . '/' . $resume->rid . '">';

        $content .= addslashes($resume->name);
                            
        $content .= '</a>';
        $content .= '</td>';
        $content .= '<td>';
                            
        $content .= 'Created On ' . date('F j, Y', $resume->date_created);
        $content .= '</td>';
        $content .= '</tr>\',';
        
    }
    $result = substr($content, 0, -1);
    $result .= ']';
    
    echo $result;
}

if($request == 'edit'){
    $rid = $_POST['rid'];
    $content = json_encode($_POST['content']);
    $resume_name = $_POST['name'];
    $db->updateResume($rid, $resume_name, $content);
}

?>