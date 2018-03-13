<?php
session_start();
$_SESSION = [];
session_destroy();
echo 'Logout successfull';
header("location: /");
exit;
?>
