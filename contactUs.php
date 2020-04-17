<?php
$custom_css = '

	<link rel="stylesheet" type="text/css" href="assets/css/contact.css">
	<link rel="stylesheet" type="text/css" href="assets/css/plugins/OwlCarousel2-2.2.1/owl.carousel.css"> 
	<link rel="stylesheet" type="text/css" href="assets/css/OwlCarousel2-2.2.1/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="assets/css/OwlCarousel2-2.2.1/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/css/contact_responsive.css">';
	$welcome_image = '
	<div class="home">
	<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="assets/img/events.jpg" data-speed="0.8"></div>';
$page_title = "";
include_once "includes/header.php";
// insert data into table message
if(isset($_POST['submitmessage'])){
	
	$form_errors = array(); //initialize array
	
	//field validation
	$required_fields = array('fullname', 'email', 'subject', 'message');
	//call function to check empty fields & merge return data into $form_errors
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	

	//collect form data into variable
	$fullname=$_POST['fullname'];
	$email=$_POST['email'];
	$subject=$_POST['subject'];		
	$message=$_POST['message'];		

		try {
			$sqlinsert = 'INSERT INTO message (msg_senderName, msg_senderEmail, msg_fullText, msg_subject) 
					VALUES (:fullname, :email, :message, :subject)';
			//PDO prepared statement: sanitize data		
			$stm = $db->prepare($sqlinsert);
			$stm->execute(array(':fullname'=>$fullname, ':email'=>$email, ':subject'=>$subject, ':message'=>$message)); //insert data into table
			
			//Check input was succesful: One raw created
			if($stm->rowCount()==1){
				//call sweet alert
				echo $result="<script type=\"text/javascript\">
							swal({
							  title: \" Your Feedback Message has been sent!\",
							  text: \"Kindly wait for your response\",
							  type: 'success',
							  confirmButtonText: \"Thank You!\"
							}, function() {
								window.location.href = 'contactUs.php';
							});
						  </script>";
			}
		} catch (PDOException $ex) {
			$result = flashMessage("An error occured: ".$ex->getMessage());
		}
	
}
?>

<div class="home_content_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content d-flex flex-row align-items-end justify-content-start">
							<div class="current_page">Contact</div>
							<div class="breadcrumbs ml-auto">
								<ul>
									<li><a href="index.php">Home</a></li>
									<li>Contact</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="contact">
		
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="contact_form_container">
						<div class="contact_form_title">Send Your Feedback Message Here!!</div>
						<form method="POST" action="" class="contact_form" id="contact_form">
							<input placeholder="Enter your Full Name" class="contact_input" name="fullname" type="text" id="fullName" required autofocus />
							<input placeholder="Enter your email" class="contact_input" name="email" type="email" id="email" required />
							<input placeholder="Enter the subject" class="contact_input" name="subject" type="text" id="subject" required />
							<textarea placeholder="Enter the message" class="contact_textarea contact_input" name="message" id="subject" required style="height:170px" ></textarea>
							<button name="submitmessage" class="button contact_button"><span>Send Message</span></button>
						</form>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="contact_info_container">
						<div>
							<a href="#">
								<div class="logo_container d-flex flex-row align-items-start justify-content-start">
									<div class="logo_image"><div><img src="assets/img/f.png" alt=""></div></div>
									<div class="logo_content">
										<div id="logo_text" class="logo_text logo_text_not_ie">Online Choir Events Platform</div>
										<div class="logo_sub"></div>
									</div>
								</div>
							</a>	
						</div>
						<div class="contact_info_list_container">
							<ul class="contact_info_list">
								<li class="d-flex flex-row align-items-start justify-content-start">
									<div><div class="contact_info_icon text-center"><img src="assets/img/contact_1.png" alt=""></div></div>
									<div class="contact_info_text">Blvd Kanyamuhanga, 15A Accassias Les Volcans, Goma, DRC</div>
								</li>
								<li class="d-flex flex-row align-items-start justify-content-start">
									<div><div class="contact_info_icon text-center"><img src="assets/img/contact_2.png" alt=""></div></div>
									<div class="contact_info_text">+254 743 300247 &amp<br> +243 895 757294</div>
								</li>
								<li class="d-flex flex-row align-items-start justify-content-start">
									<div><div class="contact_info_icon text-center"><img src="assets/img/contact_3.png" alt=""></div></div>
									<div class="contact_info_text">jeremie.sekamonyo@strathmore.edu</div>
								</li>
							</ul>
						</div>
						<div class="contact_info_pin"><div></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
include_once "includes/footer.php";
?>