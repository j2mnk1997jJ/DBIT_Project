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
	* retrieve list of choirs 
	*/
	try {
		$sqlSelChoirs = 'SELECT * FROM choirs'; 
		$stmChoirs = $db->prepare($sqlSelChoirs);
		$stmChoirs->execute();
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

?>

				<!-- main section -->
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Create New Choir</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>New Choir</span></li>
								
								<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
							</ol>
						</div>
					</header>

					<!-- start: page -->
						<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
								</div>
						
								<h2 class="panel-title">List and Details Of Choirs</h2>
							</header>
							
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Choir Name</th>
											<th>Creation Date</th>
											<th>Members</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<!-- List Of Choirs -->
										<?php
										while($rowChoirs = $stmChoirs->fetch()){
											$choirId = $rowChoirs['id'];
											$choirName = $rowChoirs['ch_name'];
											$choirDetails = $rowChoirs['ch_details'];
											$choirCreatedAt = $rowChoirs['ch_created_at'];
											?>
											<tr class="gradeA">
												<td><?php if(isset($choirName)) echo $choirName; ?></td>
												<td><?php if(isset($choirCreatedAt)) echo $choirCreatedAt; ?></td>
												<td class="center">
													<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info"><i class="fa fa-list-ul"></i> view members</button>
												</td>
												<td class="center">
													<a href="choir-edit.php?chId=<?php if(isset($choirId)) echo $choirId; ?>" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" title="Edit Choir">
														<i class="fa fa-edit"></i></a>
													<a href= "choir-delete.php?chId=<?php if(isset($choirId)) echo $choirId; ?>" onclick="return confirm('Are you sure you want to delete choir <?php echo $choirName; ?> ?')" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" title="Delete Choir">
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