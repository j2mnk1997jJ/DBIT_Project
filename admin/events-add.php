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
* Add Event
*/
if(isset($_POST['btnAddEvent'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('eventTitle', 'eventDetails', 'eventDate', 'eventChoir');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$eventTitle=$_POST['eventTitle'];
	$eventDetails=$_POST['eventDetails'];
	$eventDate=$_POST['eventDate'];
	$eventChoir=$_POST['eventChoir'];
	$eventCreator=$_SESSION['adminId'];
	
	//check error array is empty
	if (empty($form_errors)){
		try {
			$sqlInsert = 'INSERT INTO events (event_title, event_details, event_date, event_choir_id, event_created_by) 
					VALUES (:title, :details, :date, :choir, :creator)';
			//PDO prepared statement: sanitize data		
			$stmIn = $db->prepare($sqlInsert);
			$stmIn->execute(array(':title'=>$eventTitle, ':details'=>$eventDetails, ':date'=>$eventDate, ':choir'=>$eventChoir, ':creator'=>$eventCreator));
			
			//Check input was succesful: One raw created
			if($stmIn->rowCount()==1){
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Created Event $eventTitle!\",
							  text: \"The Event was succesfully Added...\",
							  type: 'success',
							  timer: 3000,
							  showConfirmButton: false
							});
							setTimeout(function(){
								window.location.href = 'events.php';
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
						<h2>Add New Event</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>New Event</span></li>
								
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
						
										<h2 class="panel-title">Fill In Details of Your Event</h2>
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
												<label class="col-md-3 control-label" for="inputDefault">Event Title</label>
												<div class="col-md-6">
													<input type="text" name="eventTitle" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Event Details</label>
												<div class="col-md-6">
													<textarea name="eventDetails" class="form-control" rows="3" id="textareaDefault"></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Event Date</label>
												<div class="col-md-6">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" data-plugin-datepicker class="form-control" name="eventDate">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Related Choir</label>
												<div class="col-md-6">
													<select data-plugin-selectTwo class="form-control populate" name="eventChoir">
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
														<button type="submit" name="btnAddEvent" class="btn btn-primary">Add Event</button>
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