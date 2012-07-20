<?php
include_once("dbObject.php");
$db = new dbObject();
$db->connect();

$request = $_POST['request'];
$content = '{';
$username = $_POST['username'];

if($request == 'delete'){
    $resumes = $db->deleteResumesByRid($_POST['resumes'], $_POST['uid']);
    foreach($resumes as $resume){
        $content .= '<tr>';
        $content .= '<td>';
        $content .= '<div class="btn-checkbox btn-item-label" rid-label="' . $resume->rid . '"></div>';
        $content .= '</td>';
             
        $content .= '<td>';
                            
        $content .= '<a href="../rmks/' . $username . '/' . $resume->rid . '">';

        $content .= $resume->name;
                            
        $content .= '</a>';
        $content .= '</td>';
        $content .= '<td>';
                            
        $content .= 'Created On ' . date('F j, Y', $resume->date_created);
        $content .= '</td>';
        $content .= '</tr>';
        $content .= '},';
    }
    $content = substr($content, 0, -1);
}
return $content;
?>