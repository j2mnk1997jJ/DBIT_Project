<?php
include_once "includes/session.php";
include_once "includes/connect.php";
include_once "includes/security_functions.php";

if(isset($_SESSION['chorister']) && isset($_SESSION['chorId'])){
	try {
		$sqlSelectUser = 'SELECT * FROM users WHERE id = :chorId'; 
		$stmUser = $db->prepare($sqlSelectUser);
		$stmUser->execute(array(':chorId'=>$_SESSION['chorId'])); //insert data into table
			
		while($rowUser = $stmUser->fetch()){
			$userFname = $rowUser['fname'];
			$userLname = $rowUser['lname'];
			$userEmail = $rowUser['email'];
			$userPhone = $rowUser['phone'];
			$userChoir = $rowUser['choir'];
		}
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- page title -->
	<title>Choir Events Platform</title>
	
	<!-- meta data -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Conference project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- css pages -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap4/bootstrap.min.css">
	<link href="assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="assets/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="assets/plugins/OwlCarousel2-2.2.1/animate.css">
	
	<!-- page custom style -->
	<?php if(isset($custom_css)) echo $custom_css; ?>
	
	<!-- SweetAlert -->
	<script src="assets/js/sweetalert.min.js"></script>
	<link href="assets/css/sweetalert.css" rel="stylesheet">
</head>

<body>
<div class="super_container">

	<!-- Menu -->

	<div class="menu trans_500">
		<div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
			<div class="menu_close_container"><div class="menu_close"></div></div>
			<div class="logo menu_logo">
				<a href="#">
					<div class="logo_container d-flex flex-row align-items-start justify-content-start">
						<div class="logo_image"><div><img src="assets/img/f.png" alt=""></div></div>
						<div class="logo_content">
							<div class="logo_text logo_text_not_ie">Online Choir Events Platform</div>
							<!--<div class="logo_sub">August 25, 2018 - Miami Marina Bay</div>-->
						</div>
					</div>
				</a>
			</div>
			<ul>
				<li class="menu_item"><a href="index.php">Home</a></li>
				<li class="menu_item"><a href="aboutUs">About Us</a></li>
				<?php if(isset($_SESSION['chorister']) && isset($_SESSION['chorId'])): ?>
					<li class="menu_item"><a href="news.php">News</a></li>
					<li class="menu_item"><a href="events.php">Events</a></li>
				<?php endif ?>
				<li class="menu_item"><a href="contactUs.php">Contact Us</a></li>
			</ul>
		</div>
		<div class="menu_social">
			<div class="menu_social_title">Follow uf on Social Media</div>
			<ul>
				<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</div>
	
	<!-- Home -->
	<?php if(isset($welcome_image)) echo $welcome_image; ?>
		<!-- Header -->

		<header class="header" id="header">
			<div>
				<div class="header_top">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="header_top_content d-flex flex-row align-items-center justify-content-start">
									<div>
										<a href="#">
											<div class="logo_container d-flex flex-row align-items-start justify-content-start">
												<div class="logo_image"><div><img src="assets/img/f.png" alt=""></div></div>
												<div class="logo_content">
													<div id="logo_text" class="logo_text logo_text_not_ie">Online Choir Events Platform</div>
													<!--<div class="logo_sub">August 25, 2018 - Miami Marina Bay</div>-->
												</div>
											</div>
										</a>	
									</div>
									<div class="header_social ml-auto">
										<ul>
											<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
										</ul>
									</div>
									<div class="hamburger ml-auto"><i class="fa fa-bars" aria-hidden="true"></i></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="header_nav" id="header_nav_pin">
					<div class="header_nav_inner">
						<div class="header_nav_container">
							<div class="container">
								<div class="row">
									<div class="col">
										<div class="header_nav_content d-flex flex-row align-items-center justify-content-start">
											<nav class="main_nav">
												<ul>
													<li class=""><a href="index.php">Home</a></li>
													<li><a href="aboutUs.php">About Us</a></li>
													<?php if(isset($_SESSION['chorister']) && isset($_SESSION['chorId'])): ?>
														<li><a href="news.php">News</a></li>
														<li><a href="events.php">Events</a></li>
													<?php endif ?>
													<li><a href="contactUs.php">Contact Us</a></li>
												</ul>
											</nav>
											<div class="header_extra ml-auto">
										
												<?php if(isset($_SESSION['chorister']) && isset($_SESSION['chorId'])): ?>
												Welcom Chorister,
													<?php if(isset($userFname)) echo $userFname; ?> 
													<?php if(isset($userLname)) echo $userLname; ?>
													<div class="button header_button"><a href="logout.php">Logout</a></div>
												<?php else : ?>	
													<div class="button header_button"><a href="login.php">Login</a></div>
												<?php endif ?>
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</header>