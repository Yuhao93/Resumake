<?php
    $to = $_POST['to'];
    $subject = addslashes($_POST['subject']);
    $body = $_POST['from'] . ' wrote:' . '\n' . addslashes($_POST['content']);
    mail($to, $subject, $body);
?>