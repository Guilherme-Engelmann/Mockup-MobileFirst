<?php
session_start();
session_destroy();
header("Location: tela de login2.php");
exit();
?>
