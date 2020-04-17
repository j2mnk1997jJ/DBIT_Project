<?php
$custom_css = '
	<link rel="stylesheet" type="text/css" href="assets/css/contact.css">
	<link rel="stylesheet" type="text/css" href="assets/css/contact_responsive.css">
	<link rel="stylesheet" type="text/css" href="assets/css/events.css">
	<link rel="stylesheet" type="text/css" href="assets/css/events_responsive.css">';
$welcome_image = '
	<div class="home">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="assets/img/events.jpg" data-speed="0.8"></div>';

$page_title = "";
include_once "includes/header.php";

/*
* check user logged in
*/
if(!isset($_SESSION['chorister']) && !isset($_SESSION['chorId'])){
	echo "<script type=\"text/javascript\">
				swal({
					title: \"User Not Logged In!\",
					text: \"Please login and proceed...\",
					type: 'error',
					timer: 3000,
					showConfirmButton: false
				});
				setTimeout(function(){
					window.location.href = 'login.php';
				}, 2000);
			</script>";
}

/*
*retrieve user choir
*/
try {
	$sqlSelectChoir = "SELECT ch_name FROM choirs WHERE id = :choirId";
	$stmchoir = $db->prepare($sqlSelectChoir);
	$stmchoir->execute(array(':choirId'=>$userChoir));
	
	while($rowChoir = $stmchoir->fetch()){
		$choirName = $rowChoir['ch_name'];
	}
	
} catch (PDOException $ex) {
	echo "An error occured: ".$ex->getMessage();
}


/*
* retrieve events of user's choir
*/
try {
	$sqlSelectEvent = "SELECT * FROM events WHERE event_choir_id = :choirId ORDER BY event_created_at DESC";
	$stmevent = $db->prepare($sqlSelectEvent);
	$stmevent->execute(array(':choirId'=>$userChoir));
} catch (PDOException $ex) {
	echo "An error occured: ".$ex->getMessage();
}

?>
		
		<div class="home_content_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content d-flex flex-row align-items-end justify-content-start">
							<div class="current_page">Events / <?php if(isset($choirName)) echo $choirName; ?></div>
							<div class="breadcrumbs ml-auto">
								<ul>
									<li><a href="index.php">Home</a></li>
									<li>Events / <?php if(isset($choirName)) echo $choirName; ?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Events -->

	<div class="events">
		<div class="container">
			<div class="row">
				<div class="col">
					
					<!-- list of events -->
					<?php
					if($stmevent->rowCount() > 0){
						while($rowEvents = $stmevent->fetch()){
							$eventId = $rowEvents['event_id'];
							$eventTitle = $rowEvents['event_title'];
							$eventDetails = $rowEvents['event_details'];
							$eventDate = $rowEvents['event_date'];
							$creatorId = $rowEvents['event_created_by'];
							
							//retrieve creator admin details
							$sqlCr = 'SELECT * FROM users WHERE id = :id'; 
							$stmCr = $db->prepare($sqlCr);
							$stmCr->execute(array(':id'=>$creatorId));
							while($rowCr = $stmCr->fetch()){
								$eventCreator = $rowCr['fname']." ".$rowCr['lname'];
							}
					?>
					
					<!-- print out event -->
					<div class="event">
						<div class="row row-lg-eq-height">
							<div class="col-lg-6 event_col">
								<div class="event_image_container">
									<div class="background_image" style="background-image:url(assets/img/event_9.jpg)"></div>
									<div class="date_container">
										<a href="#">
											<span class="date_content d-flex flex-column align-items-center justify-content-center">
												<!--<div class="date_day">15</div>-->
												<div class="date_month"><?php if(isset($eventDate)) echo $eventDate; ?></div>
											</span>
										</a>	
									</div>
								</div>
							</div>
							<div class="col-lg-6 event_col">
								<div class="event_content">
									<div class="event_title"><?php if(isset($eventTitle)) echo $eventTitle; ?></div>
									<div class="event_location"> Event hosted by <?php if(isset($choirName)) echo $choirName; ?> Choir</div>
									<div class="event_text">
										<p><?php if(isset($eventDetails)) echo $eventDetails; ?></p>
									</div>
									<div class="event_speakers">
										<!-- Event Creator -->
										<div class="event_speaker d-flex flex-row align-items-center justify-content-start">
											<div><div class="event_speaker_image"><img src="" alt=""></div></div>
											<div class="event_speaker_content">
												<div class="event_speaker_name"><?php if(isset($eventCreator)) echo $eventCreator; ?></div>
												<div class="event_speaker_title">Added By</div>
											</div>
										</div>
										<!-- Event Speaker --><!--
										<div class="event_speaker d-flex flex-row align-items-center justify-content-start">
											<div><div class="event_speaker_image"><img src="assets/img/event_speaker_2.jpg" alt=""></div></div>
											<div class="event_speaker_content">
												<div class="event_speaker_name">Jane Doe</div>
												<div class="event_speaker_title">Choir Chair Person</div>
											</div>
										</div>-->
									</div>
									<div class="event_buttons">
										<div class="button event_button event_button_1"><a href="news.php">View News</a></div>
									</div>
								</div>
							</div>
						</div>
					</div><?php
						}
					} else { ?>
						<h2>No Events Listed In your Choir</h2><?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	
<?php
include_once "includes/footer.php";

?>