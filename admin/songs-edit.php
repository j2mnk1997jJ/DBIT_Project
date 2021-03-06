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
* get Id of news & details
*/
if(isset($_GET['songId'])){
	$songId = $_GET['songId'];
	
	//retrieve news details
	try {
		$sqlSelSongs = 'SELECT * FROM songs WHERE id = :songId'; 
		$stmsong = $db->prepare($sqlSelSongs);
		$stmsong->execute(array(':songId'=>$songId));
		
		if(stmsong){
			while($rowChoir = $stmNews->fetch()){
				$songId = $stmsong['song_id'];
				$songtitle = $stmsong['song_title'];
				$songlyrics = $stmsong['song_lyrics'];
				$songcreatedby = $stmsong['song_created_by'];
			}
		}
		
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

/*
* Edit news
*/
if(isset($_POST['btnEditSong'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('songId', 'songtitle', 'songlyrics','songcreatedby');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$songId=$_POST['songId'];
	$songtitle=$_POST['songtitle'];
	$songlyrics=$_POST['songlyrics'];
	$songcreatedby=$_POST['songcreatedby'];
	
	//check error array is empty
	if (empty($form_errors)){
		try {
			$sqlUpdate = 'UPDATE songs SET song_title = :songtitle, song_lyrics = :songlyrics,song_created_by = :songcreatedby WHERE id = :songId';
			$stmUp = $db->prepare($sqlUpdate);
			$stmUp->execute(array(':songtitle'=>$songtitle, ':songlyrics'=>$songlyrics,':songcreatedby'=>$songcreatedby, ':songId'=>$songId));
			
			//Check update was succesful
			if($stmUp->rowCount()==1){
				//redirect to news with sweet alert message
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Updated song $songtitle!\",
							  text: \"The song was succesfully updated...\",
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
						<h2>Edit Song</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Edit Song</span></li>
								
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
						
										<h2 class="panel-title">Edit Song Details</h2>
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
													<input type="hidden" name="songId" value="<?php if(isset($songId)) echo $songId; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Song Title</label>
												<div class="col-md-6">
													<input type="text" name="songtitle" value="<?php if(isset($songtitle)) echo $songtitle; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Song Lyrics</label>
												<div class="col-md-6">
													<textarea name="songlyrics" class="form-control" rows="3" id="textareaDefault"><?php  echo $songlyrics; ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Song Created By</label>
												<div class="col-md-6">
													<textarea name="songcreatedby" class="form-control" rows="3" id="textareaDefault"><?php  echo $songcreatedby; ?></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnEditSong" class="btn btn-primary">Update Song</button>
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