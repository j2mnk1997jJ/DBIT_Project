<?php
session_start();

unset($_SESSION['chorister']);
unset($_SESSION['chorId']);
	

session_destroy();


header("Location: index.php");

?>