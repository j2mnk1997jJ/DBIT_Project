<?php
	//variables to hold connection parameters
	$uname='root';
	$dsn='mysql:host=127.0.0.1; dbname=sekamonyo';
	$pass='';
	
	//connection
	try {
		//instance of pdo class
		$db = new PDO($dsn, $uname, $pass);
		//pdo error mode set to exception
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected to database";
	} catch (PDOException $e){
		//display error message
		echo "Error ".$e->getMessage();
	}
	
?>