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
} else {
	
	/*
	* retrieve list of events 
	*/
	try {
		$sqlSelEvents = 'SELECT * FROM events ORDER BY event_created_at DESC'; 
		$stmEvents = $db->prepare($sqlSelEvents);
		$stmEvents->execute();
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

?>

<section role="main" class="content-body">
					<header class="page-header">
						<h2>Add New Events</h2>
					
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


                      <section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
								</div>
						
								<h2 class="panel-title">List and Details Of Events</h2>
							</header>
							
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Event Title</th>
											<th>Event Date</th>
											<!--<th>Event Details</th>-->
											<th>Related Choir</th>
											<th>Added By</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<!-- List Of Events -->
										<?php
										while($rowEvents= $stmEvents->fetch()){
											$eventId = $rowEvents['event_id'];
											$eventTitle = $rowEvents['event_title'];
											$eventDetails = $rowEvents['event_details'];
											$eventDate = $rowEvents['event_date'];
											$choirId = $rowEvents['event_choir_id'];
											$creatorId = $rowEvents['event_created_by'];
											
											//retrieve choir details
											$sqlCh = 'SELECT * FROM choirs WHERE id = :id'; 
											$stmCh = $db->prepare($sqlCh);
											$stmCh->execute(array(':id'=>$choirId));
											while($rowCh = $stmCh->fetch()){
												$eventChoir = $rowCh['ch_name'];
											}
											
											//retrieve creator admin details
											$sqlCr = 'SELECT * FROM users WHERE id = :id'; 
											$stmCr = $db->prepare($sqlCr);
											$stmCr->execute(array(':id'=>$creatorId));
											while($rowCr = $stmCr->fetch()){
												$creatorFname = $rowCr['fname'];
												$creatorLname = $rowCr['lname'];
											}
											?>
											<tr class="gradeA">
												<td><?php  echo $eventTitle; ?></td>
												<td><?php  echo $eventDate; ?></td>
												<td><?php echo $eventChoir; ?></td>
												<td><?php echo $creatorFname." ".$creatorLname; ?></td>
												<!-- actions: edit / delete -->
												<td class="center">
													<a href="events-edit.php?eventId=<?php  echo $eventId; ?>" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" title="Edit Event">
														<i class="fa fa-edit"></i></a>
													<a href= "events-delete.php?eventId=<?php  echo $eventId; ?>" onclick="return confirm('Are you sure you want to delete event <?php echo $eventTitle; ?> ?')" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" title="Delete Event">
														<i class="fa fa-times"></i></a>
												</td>
											</tr><?php
										}
										?>
									</tbody>
								</table>
							</div>
						</section>	
<div class="row">
						
					</div>
					<!-- end: page -->
				</section>
			

<?php
include_once "includes/footer.php";
?>						