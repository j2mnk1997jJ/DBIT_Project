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
* get Id of choir & details
*/
if(isset($_GET['chId'])){
	$chId = $_GET['chId'];
	
	//retrieve choir details
	try {
		$sqlSelChoir = 'SELECT * FROM choirs WHERE id = :chId'; 
		$stmChoir = $db->prepare($sqlSelChoir);
		$stmChoir->execute(array(':chId'=>$chId));
		
		if($stmChoir->rowCount() > 0){
			while($rowChoir = $stmChoir->fetch()){
				$choirId = $rowChoir['id'];
				$choirName = $rowChoir['ch_name'];
				$choirDetails = $rowChoir['ch_details'];
			}
		}
		
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

/*
* Edit Choir
*/
if(isset($_POST['btnEditChoir'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('chId', 'chName', 'chDetails');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$chId=$_POST['chId'];
	$chName=$_POST['chName'];
	$chDetails=$_POST['chDetails'];
	
	//check error array is empty
	if (empty($form_errors)){
		try {
			$sqlUpdate = 'UPDATE choirs SET ch_name = :chName, ch_details = :chDetails WHERE id = :chId';
			$stmUp = $db->prepare($sqlUpdate);
			$stmUp->execute(array(':chName'=>$chName, ':chDetails'=>$chDetails, ':chId'=>$chId));
			
			//Check update was succesful
			if($stmUp->rowCount()==1){
				//redirect to choirs with sweet alert message
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Updated Choir $chName!\",
							  text: \"The Choir was succesfully updated...\",
							  type: 'success',
							  timer: 3000,
							  showConfirmButton: false
							});
							setTimeout(function(){
								window.location.href = 'choirs.php';
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
						<h2>Edit Choir</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Edit Choir</span></li>
								
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
						
										<h2 class="panel-title">Edit Details of Choir</h2>
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
													<input type="hidden" name="chId" value="<?php if(isset($choirId)) echo $choirId; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Choir Name</label>
												<div class="col-md-6">
													<input type="text" name="chName" value="<?php if(isset($choirName)) echo $choirName; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Choir Details</label>
												<div class="col-md-6">
													<textarea name="chDetails" class="form-control" rows="3" id="textareaDefault"><?php if(isset($choirDetails)) echo $choirDetails; ?></textarea>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnEditChoir" class="btn btn-primary">Update Choir</button>
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