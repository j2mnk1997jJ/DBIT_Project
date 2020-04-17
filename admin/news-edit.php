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
if(isset($_GET['newsId'])){
	$newsId = $_GET['newsId'];
	
	//retrieve news details
	try {
		$sqlSelNews = 'SELECT * FROM news WHERE news_id = :newsId'; 
		$stmNews = $db->prepare($sqlSelNews);
		$stmNews->execute(array(':newsId'=>$newsId));
		
		if($stmNews->rowCount() > 0){
			while($rowNews = $stmNews->fetch()){
				$newsId = $rowNews['news_id'];
				$newsTitle = $rowNews['news_title'];
				$newsDetails = $rowNews['news_details'];
				$newsDate = $rowNews['news_created_at'];
				
			}
		}
		
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

/*
* Edit evnt
*/
if(isset($_POST['btnUpdateNews'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('newsId', 'newsTitle', 'newsDetails');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$newsId=$_POST['newsId'];
	$newsTitle=$_POST['newsTitle'];
	$newsDetails=$_POST['newsDetails'];

	
	//check error array is empty
	if (empty($form_errors)){
		try {
			$sqlUpdate = 'UPDATE news SET news_title = :newsTitle, news_details = :newsDetails WHERE news_id = :newsId';
			$stmUp = $db->prepare($sqlUpdate);
			$stmUp->execute(array(':newsTitle'=>$newsTitle, ':newsDetails'=>$newsDetails, ':newsId'=>$newsId));
			
			//Check update was succesful
			if($stmUp->rowCount()==1){
				//redirect to choirs with sweet alert message
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Updated news $newsTitle!\",
							  text: \"This news was succesfully updated...\",
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
						<h2>Edit news</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Edit news</span></li>
								
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
						
										<h2 class="panel-title">Edit news </h2>
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
													<input type="hidden" name="newsId" value="<?php if(isset($newsId)) echo $newsId; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">News Title</label>
												<div class="col-md-6">
													<input type="text" name="newsTitle" value="<?php  echo $newsTitle; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">News Details</label>
												<div class="col-md-6">
													<textarea name="newsDetails" class="form-control" rows="3" id="textareaDefault"><?php  echo $newsDetails; ?></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnUpdateNews" class="btn btn-primary">Update News</button>
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