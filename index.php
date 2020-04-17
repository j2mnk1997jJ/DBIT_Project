<?php
$custom_css = '
	<link rel="stylesheet" type="text/css" href="assets/css/main_styles.css">
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">';
$welcome_image = '
	<div class="home">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="assets/img/choir2.jpg" data-speed="0.8"></div>';

$page_title = "";
include_once "includes/header.php";
?>

		<div class="home_content_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content">
							<div class="home_date"></div>
							<div class="home_title">Welcome Choirs Now It's Time</div>	
							<div class="home_location">Of Changement Are You Ready?</div>
							<div class="home_text"></div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Intro -->

	<div class="intro">
		<div class="intro_content d-flex flex-row flex-wrap align-items-start justify-content-between">

			<!-- Intro Item -->
			
			
			<?php if(isset($_SESSION['chorister']) && isset($_SESSION['chorId'])): ?>
													
				 									
			<div class="intro_item">
				<div class="intro_image"><img src="assets/img/practice.jpg" alt=""></div>
				<div class="intro_body">
					
					<div class="intro_subtitle"></div>
				</div>
			</div>

			<!-- Intro Item -->
			<div class="intro_item">
				<div class="intro_image"><img src="assets/img/prayer.jpg" alt=""></div>
				<div class="intro_body">
					
					<div class="intro_subtitle"></div>
				</div>
			</div>

			<!-- Intro Item -->
			<div class="intro_item">
				<div class="intro_image"><img src="assets/img/song4.jpg" alt=""></div>
				<div class="intro_body">
					
					<div class="intro_subtitle"></div>
				</div>
			</div>

			
<?php endif ?>
		</div>
	</div>
	
	
	

<?php
include_once "includes/footer.php";
?>