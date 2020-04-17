<?php
$custom_css = '
	<link rel="stylesheet" type="text/css" href="assets/css/speakers.css">
	<link rel="stylesheet" type="text/css" href="assets/css/speakers_responsive.css">';
	$welcome_image = '
	<div class="home">
	<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="assets/img/speakers.jpg" data-speed="0.8"></div>';
$page_title = "";
include_once "includes/header.php";
?>
        <div class="home_content_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content d-flex flex-row align-items-end justify-content-start">
							<div class="current_page">About Us</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="speakers">
		<div class="container reset_container">

			<!-- Speaker -->
			<div class="row row-lg-eq-height">
				<div class="col-lg-6 speaker_col reset_col">
					<div class="speaker_image" style="background-image:url(assets/img/found.jpg)"></div>
				</div>
				<div class="col-lg-6">
					<div class="speaker_content d-flex flex-column align-items-start justify-content-center">
						<div class="speaker_title">Jeremie Ishimwe Sekamonyo</div><br>
						<div class="speaker_subtitle">System Builder</div>
						<div class="speaker_text">
							<p>Jeremie is the developer of this system. The platform  was created after 60 days of work I thank the good God who gave me good health which allows to work without interruption.</p>
						</div>
						<div class="button speaker_button"><a href="index.php">Go Back</a></div>
					</div>
				</div>
			</div>

		</div>
	    </div>
<?php
include_once "includes/footer.php";
?>
