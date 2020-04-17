<?php
include_once "includes/header.php";

/*
* Delete chorister
*/
if(isset($_GET['userId'])){
	$userId = $_GET['userId'];
	
	try {
		//delete chorister
		$sqlDelete = 'DELETE FROM users WHERE id=:userId';
		$stmDel = $db->prepare($sqlDelete);
		$stmDel->execute(array(':userId'=>$userId));
			
		echo "<script type=\"text/javascript\">
				swal({
					  title: \"Successfull!\",
					  text: \"The Administrator was succesfully deleted...\",
					  type: 'success',
					  timer: 3000,
					  showConfirmButton: false
					});
					setTimeout(function(){
						window.location.href = 'index.php';
					}, 2000);
				</script>";
				
	} catch (PDOException $ex) {
		$result = flashMessage("An error occured: ".$ex->getMessage());
	}
}

?>