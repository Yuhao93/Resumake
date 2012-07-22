<?php
    $to = $_POST['to'];
    $subject = "FROM:" . addslashes($_POST['from']) . '_SUBJECT:' . addslashes($_POST['subject']);
    $body = addslashes($_POST['content']);
    mail($to, $subject, $body);
?>