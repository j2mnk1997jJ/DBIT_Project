<?php
session_start();
include_once "includes/connect.php";
include_once "includes/security_functions.php";

/*
* Sign Up
*/
if(isset($_POST['btnSignUp'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('fname', 'lname', 'email', 'phone', 'username', 'password');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//check for minimum length
	$fields_to_check_length = array('username' => 5, 'password' => 5);
	$form_errors = array_merge($form_errors, check_min_lenght($fields_to_check_length));
	
	
	//collect form data into variable
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$uname=$_POST['username'];
	$pass=$_POST['password'];
	
	//check email is available
	if(checkDuplicateEntries('users', 'email', $email, $db)){
		$result = flashMessage('Email already in use, please try another email address');
	}
	//check username doesn't already exist in db
	else if(checkDuplicateEntries('users', 'username', $uname, $db)){
		$result = flashMessage('Username is already taken, please select another one');
	}
		
	//check error array is empty
	else if (empty($form_errors)){
		//hashing password
		$hash_pass = password_hash($pass, PASSWORD_DEFAULT);
		$type='Chorister';

		try {
			$sqlInsert = 'INSERT INTO users (fname, lname, email, phone, type, username, password) 
					VALUES (:fname, :lname, :email, :phone, :type, :uname, :pass)';
			//PDO prepared statement: sanitize data		
			$stm = $db->prepare($sqlInsert);
			$stm->execute(array(':fname'=>$fname, ':lname'=>$lname, ':email'=>$email, ':phone'=>$phone, ':type'=>$type, ':uname'=>$uname, ':pass'=>$hash_pass)); //insert data into table
			
			//Check input was succesful: One raw created
			if($stm->rowCount()==1){
				//call sweet alert
				echo $result="<script type=\"text/javascript\">
							swal({
							  title: \"Congratulations $fname!\",
							  text: \"Registration Completed Successfully\",
							  type: 'success',
							  confirmButtonText: \"Thank You!\"
							});
						  </script>";
			}
		} catch (PDOException $ex) {
			$result = flashMessage("An error occured: ".$ex->getMessage());
		}
	}
	else {
		if(count($form_errors)==1){
			$result = flashMessage('There was 1 error in the form <br>');
		}
		else {
			$result = flashMessage('There were ' .count($form_errors) .' errors in the form <br>');
		}
	}
}

/*
* Login
*/
if(isset($_POST['btnLogin'])){
	$form_errors = array();
	
	//validate
	$required_fields = array('username', 'password');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//check if the error array is empty
	if(empty($form_errors)){
		//collect form data into variable
		$uname=$_POST['username'];
		$pass=$_POST['password'];
		
		//check user exist in the database
		$sqlQuery = "SELECT * FROM users WHERE username = :uname";
		$stm = $db->prepare($sqlQuery);
		$stm->execute(array(':uname' => $uname));
		
		if($stm->rowCount() < 1){
			$result = flashMessage('Invalid username');
		} else {
			while($row = $stm->fetch()){
				$id = $row['id'];
				$hashed_pass = $row['password'];
				$username = $row['username'];
				$userType = $row['type'];
				
				if(password_verify($pass, $hashed_pass)){
					
					if($userType === 'Admin'){
						//start admin session
						$_SESSION['adminId'] = $id;
						$_SESSION['admin'] = $username;
						
						//redirect to admin panel with sweet alert message
						echo $result="<script type=\"text/javascript\">
								swal({
								  title: \"Welcome Admin $username!\",
								  text: \"You are being logged in...\",
								  type: 'success',
								  timer: 3000,
								  showConfirmButton: false
								});
								setTimeout(function(){
									window.location.href = 'admin/index.php';
								}, 2000);
							  </script>";
					}else{
						//start Chorister session
						$_SESSION['chorId'] = $id;
						$_SESSION['chorister'] = $username;
						
						//redirect to chorister panel with sweet alert message
						echo $result="<script type=\"text/javascript\">
								swal({
								  title: \"Welcome Chorister $username!\",
								  text: \"You are being logged in...\",
								  type: 'success',
								  timer: 3000,
								  showConfirmButton: false
								});
								setTimeout(function(){
									window.location.href = 'news.php';
								}, 2000);
							  </script>";
						
					}
				} else {
					$result = flashMessage('Invalid password');
				}
			}
		}
	}
	else {
		if(count($form_errors)==1){
			$result = flashMessage('There was 1 error in the form');
		}
		else {
			$result = flashMessage("There were " .count($form_errors) ." errors in the form <br>");
		}
	}
}
?>

<html>
    <head>
		<title>Login</title>
		<!-- browser icon -->
        <link rel="shortcut icon" type="image/png" href="picture\icon.png">
		
		<!-- css sheets -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="assets/css/login-style.css" rel="stylesheet"/>
        <link href="assets/css/login-header.css" rel="stylesheet"/>
		
		<!-- SweetAlert -->
		<script src="assets/js/sweetalert.min.js"></script>
		<link href="assets/css/sweetalert.css" rel="stylesheet">
		
		
		
    </head>
	
    <body>
        <div id="box">
            <div id="main"></div>
			
			<!-- login form -->
			<form action="" method="POST">
               <div id="loginform">
               <h1>LOGIN</h1>
			   
			   <div>
				    <?php if(isset($result)) echo $result; ?>
					<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
			   </div>
               <input type="Username" placeholder="Username" name="username" required /><br>
               <input type="password" placeholder="Password"  name="password" required /><br>				
               <button name="btnLogin" type="submit">LOGIN</button>
                    <br><br><br><a href="index.php" id="a_forgot">Go Back</a>
                </div>
            </form>
			
			<!-- signup form -->
            <form action="" method="POST">
				<div id="signupform">
					<h1>SIGN UP</h1>
                
					<div>
						<?php if(isset($result)) echo $result; ?>
						<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
					</div>
					
					<input type="text" id="signupFname" name="fname" required  placeholder="Enter First Name" />
					<input type="text" id="signupLname" name="lname" required  placeholder="Enter Last Name" /><br>
					<input type="email" id="signupEmail" name="email" required  placeholder="Enter Email Address"/>
					<input type="phone" id="signupEmail" name="phone" required  placeholder="Enter Phone Number" /><br>
					<!--
					<select name="type" required>
						<option value="" >Select Type</option>
						<option value="Chorister">Chorister</option>
						<option value="User">Simple User</option>
					</select><br>
					-->
					<input type="text" name="username" required  placeholder="Enter Username"><br>
					<input type="password" name="password" required  placeholder="Enter Your password"><br>
					<button type="submit" name="btnSignUp"> SIGN UP</button>
					<br><br><a href="index.php" id="a_forgot">Go Back</a>
				</div>
			</form>

            <div id="login_msg">Have an account?</div>
            <div id="signup_msg">Don't have an account?</div>

			<button id="login_btn">LOGIN</button>
            <button id="signup_btn">SIGN UP</button>
        </div>
		
		<!-- js scripts-->
		<script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery-3.3.1.js"></script>
        <script src="assets/js/login.js"></script>
    </body>
</html>

