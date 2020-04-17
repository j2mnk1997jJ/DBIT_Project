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
* get Id of users & details
*/
if(isset($_GET['userId'])){
	$userId = $_GET['userId'];
	
	//retrieve user details
	try {
		$sqlSeluser = 'SELECT * FROM users WHERE id = :userId'; 
		$stmuser = $db->prepare($sqlSeluser);
		$stmuser->execute(array(':userId'=>$userId));
		
		if($stmuser->rowCount() > 0){
			while($rowuseredit = $stmuser->fetch()){
				$userId = $rowuseredit['id'];
				$fname = $rowuseredit['fname'];
				$lname = $rowuseredit['lname'];
				$email = $rowuseredit['email'];
				$phone = $rowuseredit['phone'];
				$username = $rowuseredit['username'];
				$pass = $rowuseredit['password'];
			}
		}
		
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

/*
* Edit news
*/
if(isset($_POST['btnUpdateAdministrator'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('email', 'fname', 'lname', 'pass', 'username', 'phone');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$userId=$_POST['userId'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$username=$_POST['username'];
	$pass=$_POST['pass'];
	
	//check error array is empty
	if (empty($form_errors)){
		//hashing password
		$hash_pass = password_hash($pass, PASSWORD_DEFAULT);
		
		try {
			$sqlUpdate = 'UPDATE users SET fname = :fname, lname = :lname, email = :email, phone = :phone, username = :username, password = :pass WHERE id = :userId';
			$stmUp = $db->prepare($sqlUpdate);
			$stmUp->execute(array(':fname'=>$fname, ':lname'=>$lname,':email'=>$email,':phone'=>$phone, ':username'=>$username, ':pass'=>$hash_pass, ':userId'=>$userId));
			
			//Check update was succesful
			if($stmUp->rowCount()==1){
				//redirect to news with sweet alert message
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Updated Chorister $fname!\",
							  text: \"The chorister was succesfully updated...\",
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
						<h2>Edit Administrator</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Edit Administrator</span></li>
								
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
						
										<h2 class="panel-title">Edit Administrator Details</h2>
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
												<div class="col-md-6">
													<input type="hidden" name="userId" value="<?php if(isset($userId)) echo $userId; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">First Name</label>
												<div class="col-md-6">
													<input type="text" name="fname" value="<?php if(isset($fname)) echo $fname; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Last Name</label>
												<div class="col-md-6">
													<textarea name="lname" class="form-control" rows="3" id="textareaDefault"><?php  echo $lname; ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Email Address</label>
												<div class="col-md-6">
													<input type="email" name="email" value="<?php  echo $email; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Phone Number</label>
												<div class="col-md-6">
													<input type="phone" name="phone" value="<?php  echo $phone; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Username</label>
												<div class="col-md-6">
													<input type="text" name="username" value="<?php echo $username; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Password</label>
												<div class="col-md-6">
													<input type="password" name="pass" value="<?php  $password; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnUpdateAdministrator" class="btn btn-primary">Update Administrator</button>
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
			</div>

<?php
include_once "includes/footer.php";
?>