<?php
$page_title = "";
include_once "includes/header.php";

/*
* check user is logged in
*/
if(!isset($_SESSION['admin']) && !isset($_SESSION['adminId'])){
	echo "<script type=\"text/javascript\">
				swal({
					title: \"User Not Logged In!\",
					text: \"Please login and proceed...\",
					type: 'error',
					timer: 3000,
					showConfirmButton: false
				});
				setTimeout(function(){
					window.location.href = '../login.php';
				}, 2000);
			</script>";
}

/*
* Add news
*/
if(isset($_POST['btnAddAdmin'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('fname', 'lname', 'email', 'phone', 'uname', 'pass');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$uname=$_POST['uname'];
	$pass=$_POST['pass'];
	
	
	//check username name is not already used
	if(checkDuplicateEntries('users', 'username', $uname, $db)){
		$result = flashMessage('username is already in use, please assign another name');
	}
	//check email is available
	else if(checkDuplicateEntries('users', 'email', $email, $db)){
		$result = flashMessage('Email already in use, please try another email address');
	}
	//check error array is empty
	else if (empty($form_errors)){
		//hashing password
		$hash_pass = password_hash($pass, PASSWORD_DEFAULT);
		$type='Admin';
		
		try {
			$sqlInsert = 'INSERT INTO users (fname, lname, email, phone, type, username, password) 
					VALUES (:fname, :lname, :email, :phone, :type, :username, :pass)';
			//PDO prepared statement: sanitize data		
			$stmIn = $db->prepare($sqlInsert);
			$stmIn->execute(array(':fname'=>$fname, ':lname'=>$lname, ':email'=>$email, ':phone'=>$phone, ':type'=>$type, ':username'=>$uname, ':pass'=>$hash_pass));
			
			//Check input was succesful: One raw created
			if($stmIn->rowCount()==1){
				//redirect to news with sweet alert message
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Created Admin $fname!\",
							  text: \"The Administrator was succesfully Added...\",
							  type: 'success',
							  timer: 3000,
							  showConfirmButton: false
							});
							setTimeout(function(){
								window.location.href = 'index.php';
							}, 2000);
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
?>

				<!-- main section -->
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Add Admin</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Admin</span></li>
								
								<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
							</ol>
						</div>
					</header>

					<!-- start: page -->
					<div class="row">
						<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
										</div>
						
										<h2 class="panel-title">Fill In Details of Chorister</h2>
									</header>
									
									<div class="panel-body">
										<form class="form-horizontal form-bordered" action="" method="post">
											
											<?php if(isset($errors) || !empty($form_errors)) : ?>
											<div class="form-group">
												<?php if(isset($result)) echo $result; ?>
												<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
											</div>
											<?php endif ?>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">First Name</label>
												<div class="col-md-6">
													<input type="text" name="fname" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Last Name</label>
												<div class="col-md-6">
													<input type="text" name="lname" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Email Address</label>
												<div class="col-md-6">
													<input type="email" name="email" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Phone Number</label>
												<div class="col-md-6">
													<input type="phone" name="phone" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Default Username</label>
												<div class="col-md-6">
													<input type="text" name="uname" class="form-control" id="inputDefault">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Default Password</label>
												<div class="col-md-6">
													<input type="password" name="pass" class="form-control">
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnAddAdmin" class="btn btn-primary">Add Admin</button>
														<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>&nbsp; &nbsp; Reset Form</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</section>
							</div>
					</div>
					<!-- end: page -->
				</section>
			

<?php
include_once "includes/footer.php";
?>