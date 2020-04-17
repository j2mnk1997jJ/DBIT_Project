<?php
$custom_css = '
	<link rel="stylesheet" type="text/css" href="assets/css/contact.css">
	<link rel="stylesheet" type="text/css" href="assets/css/contact_responsive.css">
	<link rel="stylesheet" type="text/css" href="assets/css/news.css">
	<link rel="stylesheet" type="text/css" href="assets/css/news_responsive.css">';
$welcome_image = '
	<div class="home">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="assets/img/news.jpg" data-speed="0.8"></div>';

$page_title = "";
include_once "includes/header.php";

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
} else {
	if($userChoir != 0) { //user belongs to a choir
		//retrieve details of userChoir
		try {
			$sqlSelectChoir = 'SELECT * FROM choirs WHERE id = :userChoir'; 
			$stmChoir = $db->prepare($sqlSelectChoir);
			$stmChoir->execute(array(':userChoir'=>$userChoir));
				
			while($rowChoir = $stmChoir->fetch()){
				$choirName = $rowChoir['ch_name'];
				$choirDetails = $rowChoir['ch_details'];
			}
		} catch (PDOException $ex) {
			echo "An error occured: ".$ex->getMessage();
		}
	} else { //user does not belong to any choir
		//retrieve all the Choirs
		try {
			$sqlAllChoir = 'SELECT * FROM choirs'; 
			$stmAllChoir = $db->prepare($sqlAllChoir);
			$stmAllChoir->execute();
			
		} catch (PDOException $ex) {
			echo "An error occured: ".$ex->getMessage();
		}
	}
}

/*
* Select Choir / Update Selected Choir
*/
if(isset($_POST['btnSelectChoir'])){
	$choir_id=$_POST['selectedChoir'];
	try {
		$sqlUpdate = 'UPDATE users SET choir = :choir WHERE id = :user';
		//PDO prepared statement: sanitize data
		$stm = $db->prepare($sqlUpdate);
		$stm->execute(array(':choir'=>$choir_id, ':user'=>$_SESSION['chorId'])); //update data into table
			
		//Check update was succesful: One raw created
		if($stm->rowCount()==1){
			//call sweet alert
			echo "<script type=\"text/javascript\">
					swal({
					    title: \"New Choir Selected!\",
						text: \"You have been registered to a choir...\",
						type: 'success',
						timer: 3000,
						showConfirmButton: false
					});
					setTimeout(function(){
						window.location.href = 'news.php';
					}, 2000);
				 </script>";
		}
	} catch (PDOException $ex) {
			echo "An error occured: ".$ex->getMessage();
	}
}

/*
* retrieve news of user's choir
*/
try {
	$sqlSelectNews = "SELECT * FROM news WHERE news_choir_id = :choirId ORDER BY news_created_at DESC";
	$stmnews = $db->prepare($sqlSelectNews);
	$stmnews->execute(array(':choirId'=>$userChoir));
} catch (PDOException $ex) {
	echo "An error occured: ".$ex->getMessage();
}
?>
		
		<div class="home_content_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content d-flex flex-row align-items-end justify-content-start">
							<div class="current_page">
							<?php if($userChoir == 0): ?>
								No News To Show
							<?php else : ?>	
								News / <?php if(isset($choirName)) echo $choirName; ?>				
							<?php endif ?>
							</div>
							<div class="breadcrumbs ml-auto">
								<ul>
									<li><a href="index.php">Home</a></li>
									<li>News / <?php if(isset($choirName)) echo $choirName; ?> </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- News -->

	<div class="news">
		<div class="container">
			<?php if($userChoir == 0): ?>
			<div class="row">
				<div class="col-lg-8">
					<div class="col text-center">
						<h2 style="color: #000;">List Of Choirs Registered</h2><hr>
					</div>
					<div class="intro_content d-flex flex-row flex-wrap align-items-start justify-content-between">
						<!-- List Of Choirs -->
						<?php
						while($rowChoirs = $stmAllChoir->fetch()){
							$choirId = $rowChoirs['id'];
							$choirName = $rowChoirs['ch_name'];
							$choirDetails = $rowChoirs['ch_details'];
							?>						
							<div class="intro_item">
								<div class="intro_image"><img src="#" alt=""></div>
								<div class="intro_body">
									<div class="intro_title"><a href=""><?php if(isset($choirName)) echo $choirName; ?></a></div>
									<div class="intro_subtitle"><?php if(isset($choirDetails)) echo $choirDetails; ?></div>
								</div>
							</div><?php
						}
						?>
					</div>
				</div>

				<!-- Sidebar -->
				<div class="col-lg-4">
					<div class="sidebar">
						<div class="tickets">
							<div class="background_image" style="background-image:url(assets/img/tickets.jpg)"></div>
							<div class="tickets_inner text-center">
								<div class="tickets_title">Join A Choir</div>
								<div class="tickets_text">
									Select a choir to join
								</div>
								<form action="" method="post" class="contact_form">
									<select name="selectedChoir" class="contact_input">
										<option value="" >Select Choir</option>
										<?php
										$sqlChoirs = 'SELECT * FROM choirs'; 
										$stmCh = $db->prepare($sqlChoirs);
										$stmCh->execute();
										while($rowChoirSE = $stmCh->fetch()){
											$choirId = $rowChoirSE['id'];
											$choirName = $rowChoirSE['ch_name'];
											$choirDetails = $rowChoirSE['ch_details'];
											?>
											<option value="<?php if(isset($choirId)) echo $choirId; ?>"><?php if(isset($choirName)) echo $choirName; ?></option><?php
										}
										?>
									</select><br><br>
									<button type="submit" name="btnSelectChoir" class="button contact_button"><span>Join Choir</span></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php else : ?>
			<!-- output news of choir -->
			<div>
				<h2>Choir <?php echo $choirName; ?></h2>
				
				<!-- News -->
				<div class="news">
					<div class="container">
						<div class="row">
							<div class="col-lg-8">
								<div class="news_items">
									<!-- list of news -->
									<?php
									if($stmnews->rowCount() > 0){
										while($rowNews = $stmnews->fetch()){
											$newsId = $rowNews['news_id'];
											$newsTitle = $rowNews['news_title'];
											$newsDetails = $rowNews['news_details'];
											$creatorId = $rowNews['news_created_by'];
											$newsCreatedAt = $rowNews['news_created_at'];
											
											//retrieve creator admin details
											$sqlCr = 'SELECT * FROM users WHERE id = :id'; 
											$stmCr = $db->prepare($sqlCr);
											$stmCr->execute(array(':id'=>$creatorId));
											while($rowCr = $stmCr->fetch()){
												$newsCreator = $rowCr['fname']." ".$rowCr['lname'];
											}
									?>
								
									<!-- News Item -->
									<div class="news_item" style="margin-top: -12%">
										<div class="news_image_container">
											<div class="news_image" ><img src="assets/img/news_1.jpg" alt="" style="max-height: 200px; width: 100%"></div>
											<div class="date_container">
											<a href="#">
													<span class="">
														<!--<div class="date_day">15</div>-->
														<!--<div class="date_month"><?php if(isset($newsCreatedAt)) echo $newsCreatedAt; ?></div>-->
													</span>
												</a>	
											</div>
										</div>
										<div class="news_body">
											<div class="news_title"><a href="#"><?php if(isset($newsTitle)) echo $newsTitle; ?></a></div>
											<div class="news_info">
												<ul>
													<!-- News Author -->
													<li>
														<div class="news_author_image"><img src="images/news_author_1.jpg" alt=""></div>
														<span>by <a href="#"><?php if(isset($newsCreator)) echo $newsCreator; ?></a></span>
													</li>
													<!-- Tags -->
													<li><span>on <a href="#"><?php if(isset($newsCreatedAt)) echo $newsCreatedAt; ?></a></span></li>
												</ul>
											</div>
											<div class="news_text">
												<p><?php if(isset($newsDetails)) echo $newsDetails; ?></p>
											</div>
											<!--<div class="button news_button"><a href="#">Read More</a></div>-->
										</div>
									</div><?php
										}
									} else {
										echo "<h4>No News to show</h4>";
									}
									?>
								</div>
							</div>

							
							
						</div>
					</div>
				</div>
				
				
			</div>
			<?php endif ?>
		</div>
	</div>	
<?php
include_once "includes/footer.php";
?>