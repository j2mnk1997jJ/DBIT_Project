<?php
include_once "includes/header.php";

/*
* Delete Choir
*/
if(isset($_GET['msgId'])){
	$msgId = $_GET['msgId'];
	
	try {
		//delete choir
		$sqlDelete = 'DELETE FROM message WHERE msg_id=:msgId';
		$stmDel = $db->prepare($sqlDelete);
		$stmDel->execute(array(':msgId'=>$msgId));
			
		echo "<script type=\"text/javascript\">
				swal({
					  title: \"Successfull!\",
					  text: \"The message was succesfully deleted...\",
					  type: 'success',
					  timer: 3000,
					  showConfirmButton: false
					});
					setTimeout(function(){
						window.location.href = 'messages.php';
					}, 2000);
				</script>";
				
	} catch (PDOException $ex) {
		$result = flashMessage("An error occured: ".$ex->getMessage());
	}
}

?>