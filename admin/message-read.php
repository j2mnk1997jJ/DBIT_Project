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
	if(isset($_GET['msgId'])) {
		$msgId = $_GET['msgId'];
	
		/*
		* retrieve message 
		*/
		try {
			$sqlSelMsg = 'SELECT * FROM message WHERE msg_Id = :id';
			$stmMsg = $db->prepare($sqlSelMsg);
			$stmMsg->execute(array(':id'=>$msgId));
			
			if($stmMsg->rowCount() > 0){
				while($rowMsg = $stmMsg->fetch()){
					$msgId = $rowMsg['msg_Id'];
					$msgSenderName = $rowMsg['msg_senderName'];
					$msgSenderEmail = $rowMsg['msg_senderEmail'];
					$msgSubject = $rowMsg['msg_subject'];
					$msgContent = $rowMsg['msg_fullText'];
					$msgStatus = $rowMsg['msg_status'];
					$msgDate = $rowMsg['msg_datetime'];
				}
				
				//update massage status to read
				$newStatus = 'read';
				try {
					$sqlUpdate = 'UPDATE message SET msg_status = :status WHERE msg_Id = :id';
					$stmUp = $db->prepare($sqlUpdate);
					$stmUp->execute(array(':status'=>$newStatus, ':id'=>$msgId));
				} catch (PDOException $ex){
					echo "An error occured: ".$ex->getMessage();
				}
			}
		} catch (PDOException $ex) {
			echo "An error occured: ".$ex->getMessage();
		}
	} else {
		echo "<script type=\"text/javascript\">
				swal({
					title: \"Cannot load message!\",
					text: \"Please select message to read and continue...\",
					type: 'error',
					timer: 3000,
					showConfirmButton: false
				});
				setTimeout(function(){
					window.location.href = 'messages.php';
				}, 2000);
			</script>";
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
							<section class="panel panel-featured panel-featured-primary">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
									</div>

									<h2 class="panel-title">Subject: <b><?php if(isset($msgSubject)) echo $msgSubject; ?></b></h2>
									<p class="panel-subtitle">From: <b><?php if(isset($msgSenderName)) echo $msgSenderName; ?></b></p>
									<p class="panel-subtitle">Email: <b><?php if(isset($msgSenderEmail)) echo $msgSenderEmail; ?></b></p>
								</header>
								<div class="panel-body">
									<p><?php if(isset($msgContent)) echo $msgContent; ?></p>
								</div>
								<div class="panel-footer">
									<p><?php if(isset($msgDate)) echo $msgDate; ?></p>
									<a href="messages.php"><i class="fa fa-chevron-left"> Go Back </i></a>
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