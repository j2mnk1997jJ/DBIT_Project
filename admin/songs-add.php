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
* Add songs
*/
if(isset($_POST['btnAddSong'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('songtitle', 'songlyrics');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$songtitle=$_POST['songtitle'];
	$songlyrics=$_POST['songlyrics'];
	//check choir name is not already used
	if(checkDuplicateEntries('songs', 'song_title', $songtitle, $db)){
		$result = flashMessage('SOng Title is already in use, please assign another name');
	}
	
	//check error array is empty
	else if (empty($form_errors)){
		try {
			$sqlInsert = 'INSERT INTO songs (song_title, song_lyrics,song_created_by) 
					VALUES (:songtitle, :songlyrics,:songcreatedby)';
			//PDO prepared statement: sanitize data		
			$stmIn = $db->prepare($sqlInsert);
			$stmIn->execute(array(':songtitle'=>$songtitle, ':songlyrics'=>$songlyrics,':songcreatedby'=>$songcreatedby)); //insert data into table
			
			//Check input was succesful: One raw created
			if($stmIn->rowCount()==1){
				//redirect to news with sweet alert message
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Created Song $songtitle!\",
							  text: \"The song was succesfully Added...\",
							  type: 'success',
							  timer: 3000,
							  showConfirmButton: false
							});
							setTimeout(function(){
								window.location.href = 'songs.php';
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
						<h2>Add Songs</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Songs</span></li>
								
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
						
										<h2 class="panel-title">Fill In Details of Your Songs</h2>
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
												<label class="col-md-3 control-label" for="inputDefault">Song Title</label>
												<div class="col-md-6">
													<input type="text" name="songtitle" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Song Lyrics</label>
												<div class="col-md-6">
													<textarea name="songlyrics" class="form-control" rows="3" id="textareaDefault"></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Song Created By</label>
												<div class="col-md-6">
													<textarea name="songcreatedby" class="form-control" rows="3" id="textareaDefault"></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnAddSong" class="btn btn-primary">Add Song</button>
														<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>&nbsp; &nbsp; Reset Form</button>
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
			

<?php
include_once "includes/footer.php";
?>