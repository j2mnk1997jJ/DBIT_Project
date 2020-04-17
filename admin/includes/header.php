<?php
include_once "includes/session.php";
include_once "includes/connect.php";
include_once "includes/security_functions.php";

if(isset($_SESSION['admin']) && isset($_SESSION['adminId'])){
	// retrieve user information
	try {
		$sqlSelectUser = 'SELECT * FROM users WHERE id = :adminId'; 
		$stmUser = $db->prepare($sqlSelectUser);
		$stmUser->execute(array(':adminId'=>$_SESSION['adminId'])); //retrieve user data
			
		while($rowUser = $stmUser->fetch()){
			$adminFname = $rowUser['fname'];
			$adminLname = $rowUser['lname'];
			$adminEmail = $rowUser['email'];
			$adminPhone = $rowUser['phone'];
			$adminChoir = $rowUser['choir'];
		}
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
} else {
	//redirect to login
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
	

	<!-- page title -->
	<title>Admin Panel</title>
	
	<meta name="keywords" content="HTML5 Admin Template" />
	<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
	<meta name="author" content="JSOFT.net">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="assets/vendor/morris/morris.css" />
	<!-- datatable -->
	<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
	<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
	<!-- messages page -->
	<link rel="stylesheet" href="assets/vendor/summernote/summernote.css" />
	<link rel="stylesheet" href="assets/vendor/summernote/summernote-bs3.css" />
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="assets/<meta name="keywords" content="HTML5 Admin Template" />
	<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
	<meta name="author" content="JSOFT.net">

	<!-- Theme CSS -->
	<link rel="stylesheet" href="assets/css/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="assets/css/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="assets/css/theme-custom.css">

	<!-- Head Libs -->
	<script src="assets/vendor/modernizr/modernizr.js"></script>

	<!-- Skin CSS -->
	<link rel="stylesheet" href="assets/css/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="assets/css/theme-custom.css">

	<!-- Head Libs -->
	<script src="assets/vendor/modernizr/modernizr.js"></script>
	
	<!-- SweetAlert -->
	<script src="assets/js/sweetalert.min.js"></script>
	<link href="assets/css/sweetalert.css" rel="stylesheet">
</head>


<body>
		
		<section class="body">
			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="index.php" class="logo">
						<img src="assets/img/f.png" height="35" alt="JSOFT Admin" /> Online Choir Events Administrator
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<ul class="notifications">
						
						
					</ul>
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="assets/img/!logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/img/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
								<span class="name"><?php if(isset($adminFname)) echo $adminFname." ".$adminLname; ?></span>
								<span class="role">Administrator</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								
								<li>
									<a role="menuitem" tabindex="-1" href="logout.php" onclick="return confirm('Are you sure you want to logout ?')"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="index.php">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
									
									<!-- choirs -->
									<li class="nav-parent">
										<a>
											<i class="fa fa-group" aria-hidden="true"></i>
											<span>Choirs</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="choirs.php">
													 List Choirs
												</a>
											</li>
											<li>
												<a href="choir-add.php">
													 New Choir
												</a>
											</li>
										</ul>
									</li>
									
									<!-- events -->
									<li class="nav-parent">
										<a>
											<i class="fa fa-book" aria-hidden="true"></i>
											<span>Events</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="events.php">
													 List Events
												</a>
											</li>
											<li>
												<a href="events-add.php">
													 New Event
												</a>
											</li>
										</ul>
									</li>
									
									<!-- news -->
									<li class="nav-parent">
										<a>
											<i class="fa fa-paper-plane" aria-hidden="true"></i>
											<span>News</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="news.php">
													 List News
												</a>
											</li>
											<li>
												<a href="news-add.php">
													 Add News
												</a>
											</li>
										</ul>
									</li>
									
									<!-- feedback messages -->
									<li>
										<a href="messages.php">
											<span class="pull-right label label-primary">182</span>
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>Mailbox</span>
										</a>
									</li>
									
									<!-- users -->
									<li class="nav-parent">
										<a>
											<i class="fa fa-user" aria-hidden="true"></i>
											<span>Users</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="choristers.php">
													 List Of Choristers
												</a>
											</li>
											<li>
												<a href="admin.php">
													 List Of Admins
												</a>
											</li>
											<li>
												<a href="admin-add.php">
													 Add Admin
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</nav>
				
							<hr class="separator" />
						</div>
				
					</div>
				
				</aside>
				<!-- end: sidebar -->

