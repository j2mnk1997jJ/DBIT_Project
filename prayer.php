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
	$sqlSelectPray = "SELECT * FROM prayer WHERE pray_id = :prayerid ORDER BY pray_created_at DESC";
	$stmpray = $db->prepare($sqlSelectPray);
	$stmpray->execute(array(':choirId'=>$userChoir));
} catch (PDOException $ex) {
	echo "An error occured: ".$ex->getMessage();
}

?>
		
		<div class="home_content_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content d-flex flex-row align-items-end justify-content-start">
							<div class="current_page">Prayers / <?php if(isset($choirName)) echo $choirName; ?></div>
							<div class="breadcrumbs ml-auto">
								<ul>
									<li><a href="index.php">Home</a></li>
									<li>Prayers / <?php if(isset($choirName)) echo $choirName; ?></li>
								</ul>
							</div>
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
					if($stmpray->rowCount() > 0){
						while($rowEvents = $stmpray->fetch()){
							$prayerid = $rowEvents['pray_id'];
							$prayerchoirid = $rowEvents['pray_choir_id'];
							$prayerdetails = $rowEvents['pray_deatails'];
							
							
					?>
					
					<!-- print out event -->
					<div class="event">
						<div class="row row-lg-eq-height">
							<div class="col-lg-6 event_col">
								<div class="event_image_container">
									<div class="background_image" style="background-image:url(assets/img/event_9.jpg)"></div>
									
								</div>
							</div>
							<div class="col-lg-6 event_col">
								<div class="event_content">
									
									<div class="event_location"> Prayer hosted by <?php if(isset($prayerchoirid)) echo $prayerchoirid; ?> Choir</div>
									<div class="event_text">
										<p><?php if(isset($prayerdetails)) echo $prayerdetails; ?></p>
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