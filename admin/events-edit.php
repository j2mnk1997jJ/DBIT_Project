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
* get Id of events & details
*/
if(isset($_GET['eventId'])){
	$eventId = $_GET['eventId'];
	
	//retrieve event details
	try {
		$sqlSelEvents = 'SELECT * FROM events WHERE event_id = :eventId'; 
		$stmEvents = $db->prepare($sqlSelEvents);
		$stmEvents->execute(array(':eventId'=>$eventId));
		
		if($stmEvents->rowCount() > 0){
			while($rowEvents = $stmEvents->fetch()){
				$eventId = $rowEvents['event_id'];
				$eventTitle = $rowEvents['event_title'];
				$eventDetails = $rowEvents['event_details'];
				$eventDate = $rowEvents['event_date'];
				
			}
		}
		
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

/*
* Edit evnt
*/
if(isset($_POST['btnUpdateEvent'])){
	$form_errors = array(); //initialize error array
	
	//field validation
	$required_fields = array('eventId', 'eventTitle', 'eventDetails');
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//collect form data into variable
	$eventId=$_POST['eventId'];
	$eventTitle=$_POST['eventTitle'];
	$eventDetails=$_POST['eventDetails'];
	$eventDate=$_POST['eventDate'];
	
	//check error array is empty
	if (empty($form_errors)){
		try {
			$sqlUpdate = 'UPDATE events SET event_title = :eventTitle, event_details = :eventDetails, event_date = :eventDate WHERE event_id = :eventId';
			$stmUp = $db->prepare($sqlUpdate);
			$stmUp->execute(array(':eventTitle'=>$eventTitle, ':eventDetails'=>$eventDetails,':eventDate'=>$eventDate, ':eventId'=>$eventId));
			
			//Check update was succesful
			if($stmUp->rowCount()==1){
				//redirect to choirs with sweet alert message
				echo "<script type=\"text/javascript\">
						swal({
							  title: \"Updated Event $eventTitle!\",
							  text: \"This event was succesfully updated...\",
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
?>

				<!-- main section -->
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Edit Event</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Edit Event</span></li>
								
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
						
										<h2 class="panel-title">Edit Event </h2>
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
													<input type="hidden" name="eventId" value="<?php if(isset($eventId)) echo $eventId; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputDefault">Event Title</label>
												<div class="col-md-6">
													<input type="text" name="eventTitle" value="<?php  echo $eventTitle; ?>" class="form-control" id="inputDefault">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" for="textareaDefault">Event Details</label>
												<div class="col-md-6">
													<textarea name="eventDetails" class="form-control" rows="3" id="textareaDefault"><?php  echo $eventDetails; ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Event Date</label>
												<div class="col-md-6">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" data-plugin-datepicker class="form-control" name="eventDate" value="<?php  echo $eventDate; ?>">
													</div>
												</div>
											</div>
											
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<div class="row" >&nbsp;&nbsp; &nbsp;
														<button type="submit" name="btnUpdateEvent" class="btn btn-primary">Update Event</button>
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