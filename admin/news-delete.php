<?php
include_once "includes/header.php";

/*
* Delete news
*/
if(isset($_GET['newsId'])){
	$newsId = $_GET['newsId'];
	
	try {
		//delete news
		$sqlDelete = 'DELETE FROM news WHERE news_id=:newsId';
		$stmDel = $db->prepare($sqlDelete);
		$stmDel->execute(array(':newsId'=>$newsId));
			
		echo "<script type=\"text/javascript\">
				swal({
					  title: \"Successfull!\",
					  text: \"This information was succesfully deleted...\",
					  type: 'success',
					  timer: 3000,
					  showConfirmButton: false
					});
					setTimeout(function(){
						window.location.href = 'news.php';
					}, 2000);
				</script>";
				
	} catch (PDOException $ex) {
		$result = flashMessage("An error occured: ".$ex->getMessage());
	}
}

?>