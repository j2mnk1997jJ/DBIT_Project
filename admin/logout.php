<?php
session_start();

unset($_SESSION['admin']);
unset($_SESSION['adminId']);

session_destroy();


header("Location: ../login.php");

?>