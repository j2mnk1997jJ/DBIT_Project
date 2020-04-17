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
	* retrieve list of users 
	*/
	$type = 'Admin';
	try {
		$sqlSeluser = 'SELECT * FROM users WHERE type = :type'; 
		$stmuser = $db->prepare($sqlSeluser);
		$stmuser->execute(array(':type'=>$type));
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

?>

<section role="main" class="content-body">
					<header class="page-header">
						<h2>Add Users </h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Users</span></li>
								
								<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
							</ol>
						</div>
					</header>


                      <section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
								</div>
						
								<h2 class="panel-title">List and Details Of Users</h2>
							</header>
							
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Email Address</th>
											<th>Phone Number</th>
											<th>Username</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<!-- List Of users -->
										<?php
										while($rowUsers= $stmuser->fetch()){
											$userId = $rowUsers['id'];
											$userfname = $rowUsers['fname'];
											$userlname = $rowUsers['lname'];
											$useremail = $rowUsers['email'];
											$phone = $rowUsers['phone'];
											$username= $rowUsers['username'];
											?>
											<tr class="gradeA">
												<td><?php  echo $userfname; ?></td>

												<td><?php echo $userlname; ?></td>
												<td><?php echo $useremail; ?></td>
											
												<td><?php echo $phone; ?></td>
												<td><?php echo $username; ?></td>
												
												
												<td class="center">
													<a href="admin-edit.php?userId=<?php  echo $userId; ?>" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" title="Edit User">
														<i class="fa fa-edit"></i></a>
													<a href= "admin-delete.php?userId=<?php  echo $userId; ?>" onclick="return confirm('Are you sure you want to delete chorister <?php echo $fname; ?> ?')" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" title="Delete event">
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