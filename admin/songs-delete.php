<?php
include_once "includes/header.php";

/*
* Delete news
*/
if(isset($_GET['songId'])){
	$songId = $_GET['songId'];
	
	try {
		//delete choir
		$sqlDelete = 'DELETE FROM news WHERE id=:songId';
		$stmDel = $db->prepare($sqlDelete);
		$stmDel->execute(array(':songId'=>$songId));
			
		echo "<script type=\"text/javascript\">
				swal({
					  title: \"Successfull!\",
					  text: \"This song was succesfully deleted...\",
					  type: 'success',
					  timer: 3000,
					  showConfirmButton: false
					});
					setTimeout(function(){
						window.location.href = 'songs.php';
					}, 2000);
				</script>";
				
	} catch (PDOException $ex) {
		$result = flashMessage("An error occured: ".$ex->getMessage());
	}
}

?>