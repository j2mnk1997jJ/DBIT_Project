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
		$sqlSelMsg = 'SELECT * FROM message ORDER BY msg_datetime DESC'; 
		$stmMsg = $db->prepare($sqlSelMsg);
		$stmMsg->execute();
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

?>

				<!-- main section -->
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Messages</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Messages</span></li>
								
								<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
							</ol>
						</div>
					</header>

					<!-- start: page -->
					<div class="row">
						<div class="col-md-6 col-lg-12 col-xl-6">
							<section class="panel panel-transparent">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
									</div>

									<h2 class="panel-title">Messages Received</h2>
								</header>
								<div class="panel-body">
									<section class="panel panel-group">
										<header class="panel-heading bg-primary">

											<div class="widget-profile-info">
												<div class="profile-picture">
													<img src="assets/img/!logged-user.jpg">
												</div>
												<div class="profile-info">
													<h4 class="name text-semibold"><?php if(isset($adminFname)) echo $adminFname." ".$adminLname; ?></h4>
													<h5 class="role">Administrator</h5>
													<div class="profile-footer">
														<!--<a href="#">(edit profile)</a>-->
													</div>
												</div>
											</div>

										</header>
										<div id="accordion">
											<div class="panel panel-accordion panel-accordion-first">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
															<i class="fa fa-comment"></i> Messages
														</a>
													</h4>
												</div>
												
												<div id="collapse1One" class="accordion-body collapse in">
													<div class="panel-body">
														<ul class="widget-todo-list">
															<!-- list of messages -->
															<?php
															while($rowMsg = $stmMsg->fetch()){
																$msgId = $rowMsg['msg_Id'];
																$msgSenderName = $rowMsg['msg_senderName'];
																$msgSenderEmail = $rowMsg['msg_senderEmail'];
																$msgSubject = $rowMsg['msg_subject'];
																$msgContent = $rowMsg['msg_fullText'];
																$msgStatus = $rowMsg['msg_status'];
																$msgDate = $rowMsg['msg_datetime'];
																?>
																<li>
																	<div class="checkbox-custom checkbox-default">
																		<label class="todo-label" for="todoListItem1" <?php if($msgStatus === 'unread') echo "style='font-weight: bold'"; ?> >
																			<a href="message-read.php?msgId=<?php echo $msgId ?>" title="Read Message">
																				<span>From: <?php if(isset($msgSenderName)) echo $msgSenderName; ?> | Subject: <?php if(isset($msgSubject)) echo $msgSubject; ?></span>
																			</a>
																		</label>
																	</div>
																	<div class="todo-actions">
																		<a class="" href="message-delete.php?msgId=<?php echo $msgId ?>" onclick="return confirm('Are you sure you want to delete this message?')" title="Delete Message">
																			<i class="fa fa-times" style="color: red"></i>
																		</a>
																	</div>
																</li><?php
															}
															?>
														</ul>
														<hr class="solid mt-sm mb-lg">
														
													</div>
												</div>
											</div>
											
											<!--
											<div class="panel panel-accordion">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1Two">
															 <i class="fa fa-comment"></i> Messages
														</a>
													</h4>
												</div>
												<div id="collapse1Two" class="accordion-body collapse">
													<div class="panel-body">
														<ul class="simple-user-list mb-xlg">
															<li>
																<figure class="image rounded">
																	<img src="assets/img/!sample-user.jpg" alt="Joseph Doe Junior" class="img-circle">
																</figure>
																<span class="title">Joseph Doe Junior</span>
																<span class="message">Lorem ipsum dolor sit.</span>
															</li>
															<li>
																<figure class="image rounded">
																	<img src="assets/img/!sample-user.jpg" alt="Joseph Junior" class="img-circle">
																</figure>
																<span class="title">Joseph Junior</span>
																<span class="message">Lorem ipsum dolor sit.</span>
															</li>
															<li>
																<figure class="image rounded">
																	<img src="assets/img/!sample-user.jpg" alt="Joe Junior" class="img-circle">
																</figure>
																<span class="title">Joe Junior</span>
																<span class="message">Lorem ipsum dolor sit.</span>
															</li>
															<li>
																<figure class="image rounded">
																	<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior" class="img-circle">
																</figure>
																<span class="title">Joseph Doe Junior</span>
																<span class="message">Lorem ipsum dolor sit.</span>
															</li>
														</ul>
													</div>
												</div>
											</div>
											-->
										</div>
									</section>
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