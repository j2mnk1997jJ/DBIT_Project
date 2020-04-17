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
	* retrieve list of news 
	*/
	try {
		$sqlSelNews = 'SELECT * FROM news ORDER BY news_created_at DESC'; 
		$stmNews = $db->prepare($sqlSelNews);
		$stmNews->execute();
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

?>

<section role="main" class="content-body">
					<header class="page-header">
						<h2>List of News</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>News</span></li>
								
								<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
							</ol>
						</div>
					</header>


                      <section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
								</div>
						
								<h2 class="panel-title">List and Details Of News</h2>
							</header>
							
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>News Title</th>
											<th>News Details</th>
											<th>News Created At</th>
											<!--<th>News Details</th>-->
											<th>Related Choir</th>
											<th>Added By</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<!-- List Of news -->
										<?php
										while($rowNews= $stmNews->fetch()){
											$newsId = $rowNews['news_id'];
											$newsTitle = $rowNews['news_title'];
											$newsDetails = $rowNews['news_details'];
											$newsDate = $rowNews['news_created_at'];
											$choirId = $rowNews['news_choir_id'];
											$creatorId = $rowNews['news_created_by'];
											
											//retrieve choir details
											$sqlCh = 'SELECT * FROM choirs WHERE id = :id'; 
											$stmCh = $db->prepare($sqlCh);
											$stmCh->execute(array(':id'=>$choirId));
											while($rowCh = $stmCh->fetch()){
												$newsChoir = $rowCh['ch_name'];
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
												<td><?php  echo $newsTitle; ?></td>
												<td><?php  echo $newsDetails; ?></td>
												<td><?php  echo $newsDate; ?></td>
												<td><?php echo $newsChoir; ?></td>
												<td><?php echo $creatorFname." ".$creatorLname; ?></td>
												<!-- actions: edit / delete -->
												<td class="center">
													<a href="news-edit.php?newsId=<?php  echo $newsId; ?>" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" title="Edit News">
														<i class="fa fa-edit"></i></a>
													<a href= "news-delete.php?newsId=<?php  echo $newsId; ?>" onclick="return confirm('Are you sure you want to delete news <?php echo $eventTitle; ?> ?')" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" title="Delete News">
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