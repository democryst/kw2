<?php
session_start();
session_destroy();
header("location:05_log_in.php");
exit();
?>
