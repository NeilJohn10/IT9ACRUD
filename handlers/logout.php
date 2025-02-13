<?php
session_start();

// ✅ Delete cookie by setting expiration to the past
setcookie("user", "", time() - 3600, "/"); 

session_destroy();
header("Location: ../views/login.php");
exit();
?>
