<?php
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$page = 'dashboard';
header("Location: http://$host$uri/$page");
exit;
?>
