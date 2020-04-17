<?php
include_once "includes/header.php";

/*
* Delete Event
*/
if(isset($_GET['eventId'])){
	$eventId = $_GET['eventId'];
	
	try {
		//delete choir
		$sqlDelete = 'DELETE FROM events WHERE event_id=:eventId';
		$stmDel = $db->prepare($sqlDelete);
		$stmDel->execute(array(':eventId'=>$eventId));
			
		echo "<script type=\"text/javascript\">
				swal({
					  title: \"Successfull!\",
					  text: \"This event was succesfully deleted...\",
					  type: 'success',
					  timer: 3000,
					  showConfirmButton: false
					});
					setTimeout(function(){
						window.location.href = 'events.php';
					}, 2000);
				</script>";
				
	} catch (PDOException $ex) {
		$result = flashMessage("An error occured: ".$ex->getMessage());
	}
}

?>