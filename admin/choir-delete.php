<?php
include_once "includes/header.php";

/*
* Delete Choir
*/
if(isset($_GET['chId'])){
	$chId = $_GET['chId'];
	
	try {
		//delete choir
		$sqlDelete = 'DELETE FROM choirs WHERE id=:chId';
		$stmDel = $db->prepare($sqlDelete);
		$stmDel->execute(array(':chId'=>$chId));
			
		echo "<script type=\"text/javascript\">
				swal({
					  title: \"Successfull!\",
					  text: \"The Choir was succesfully deleted...\",
					  type: 'success',
					  timer: 3000,
					  showConfirmButton: false
					});
					setTimeout(function(){
						window.location.href = 'choirs.php';
					}, 2000);
				</script>";
				
	} catch (PDOException $ex) {
		$result = flashMessage("An error occured: ".$ex->getMessage());
	}
}

?>