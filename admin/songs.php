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
	* retrieve list of songs 
	*/
	try {
		$sqlSelsongs = 'SELECT * FROM songs'; 
		$stmsong= $db->prepare($sqlSelsongs);
		$stmsong->execute();
	} catch (PDOException $ex) {
		echo "An error occured: ".$ex->getMessage();
	}
}

?>

<section role="main" class="content-body">
					<header class="page-header">
						<h2>Add Songs </h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Songs</span></li>
								
								<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
							</ol>
						</div>
					</header>


                      <section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
								</div>
						
								<h2 class="panel-title">List Of Songs</h2>
							</header>
							
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Song Id</th>
											<th>Song Title</th>
											<th>Song Lyrics</th>
											<th>Song Created By</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<!-- List Of news -->
										<?php
										while($rowSongs= $stmsong->fetch()){
											$songId = $rowSongs['song_id'];
											$songtitle = $rowSongs['song_title'];
											$songlyrics = $rowSongs['song_lyrics'];
											$songcreatedby = $rowSongs['song_created_by'];
											$songCreatedAt = $rowSongs['song_created_at'];
											?>
											<tr class="gradeA">
												<td><?php  echo $songId; ?></td>
												<td><?php  echo $songtitle; ?></td>
												<td><?php  echo $songcreatedby; ?></td>
												<td><?php echo $songCreatedAt; ?></td>
												
												
												<td class="center">
													<a href="songs-edit.php?songId=<?php  echo $songId; ?>" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" title="Edit Song">
														<i class="fa fa-edit"></i></a>
													<a href= "songs-delete.php?songId=<?php  echo $songId; ?>" onclick="return confirm('Are you sure you want to delete event <?php echo $songtitle; ?> ?')" type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" title="Delete event">
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