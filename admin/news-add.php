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
* Add News
*/
if(isset($_POST['btnAddNews'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('newsTitle', 'newsDetails', 'newsChoir');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$newsTitle=$_POST['newsTitle'];
	$newsDetails=$_POST['newsDetails'];
	$newsChoir=$_POST['newsChoir'];
	$newsCreator=$_SESSION['adminId'];
	
	//check error array is empty
	if (empty($form_errors)){
		try {
			$sqlInsert = 'INSERT INTO news (news_title, news_details, news_choir_id, news_created_by) 
					VALUES (:title, :details, :choir, :creator)';
			//PDO prepared statement: sanitize data		
			$stmIn = $db->prepare($sqlInsert);
			$stmIn->execute(array(':title'=>$newsTitle, ':details'=>$newsDetails, ':choir'=>$newsChoir, ':creator'=>$newsCreator));
			
			//Check input was succesful: One raw created
			if($stmIn->rowCount()==1){
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Created News $newsTitle!\",
							  text: \"The News was succesfully Added...\",
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

/*
* retrieve list of choirs
*/
try {
	$sqlAllChoir = 'SELECT * FROM choirs'; 
	$stmAllChoir = $db->prepare($sqlAllChoir);
	$stmAllChoir->execute();
} catch (PDOException $ex) {
	echo "An error occured: ".$ex->getMessage();
}
?>

				<!-- main section -->
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Add News</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>New</span></li>
								
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
						
										<h2 class="panel-title">Fill In Details of Your News</h2>
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
												<label class="col-md-3 control-label" for="inputDefault">News Title</label>
												<div class="col-md-6">
													<input type="text" name="newsTitle" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">News Details</label>
												<div class="col-md-6">
													<textarea name="newsDetails" class="form-control" rows="3" id="textareaDefault"></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Related Choir</label>
												<div class="col-md-6">
													<select data-plugin-selectTwo class="form-control populate" name="newsChoir">
														<optgroup label="Select Choir">
															<option value=""></option>
															<!-- List Of Choirs -->
															<?php
															while($rowChoirs = $stmAllChoir->fetch()){
																$choirId = $rowChoirs['id'];
																$choirName = $rowChoirs['ch_name'];
																?>
																<option value="<?php if(isset($choirId)) echo $choirId; ?>"><?php if(isset($choirName)) echo $choirName; ?></option><?php
															}
															?>
														</optgroup>
													</select>
												</div>
											</div>
											
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnAddNews" class="btn btn-primary">Add News</button>
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