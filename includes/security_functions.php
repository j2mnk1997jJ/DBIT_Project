<?php

/**
* @param $required_fields_array, containing all the required fields 
* @return array, containing all errors
*/
function check_empty_fields($required_fields_array){
	//array to strore any error msg from the form
	$form_errors = array();
	
	//loop through required fields array
	foreach($required_fields_array as $name_of_field){
		if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL){
			$form_errors[] = $name_of_field ." is a required field";
		}
	}
	return $form_errors;
}

/**
* @param $fields_to_check_length, containing name of fields. e.g. array('username' => 5)
* @return array, containing all errors
*/
function check_min_lenght($fields_to_check_length){
	//array to strore error msg
	$form_errors = array();
	
	//loop through required fields array
	foreach($fields_to_check_length as $name_of_field => $min_length_required){
		if(strlen(trim($_POST[$name_of_field])) < $min_length_required){
			$form_errors[] = $name_of_field ." is too short, must be at least {$min_length_required} characters long";
		}
	}
	return $form_errors;
}


/**
* @param $form_errors_array, errors we want to loop through
* @return string, list that contains all error msg
*/
function show_errors($form_errors_array){
	$errors = "<p><ul style='color: red;'>";
	
	//loop through error array and display items in a list
	foreach($form_errors_array as $the_error){
		$errors .= "<li> {$the_error} </li>";
	}
	$errors .= "</ul></p>";
	return $errors;
}


/**
* @param $message, Information message we wanna print on screen
* param $passOrFail, success or failure message
* @return string, contains message
*/
function flashMessage($message, $passOrFail = "Fail"){
	if($passOrFail === "Pass"){
		$data = "<div class='alert alert-success'> {$message} ";
	}
	else {
		$data = "<div class='alert alert-danger'> {$message} ";
	}
	return $data;
}

/**
* Redirect to another page
*/
function redirectTo($page){
	header("Location: {$page}.php");
}

/**
* Check for duplicate username
*/
function checkDuplicateEntries($table, $column, $value, $db){
	try{
		$sqlQuery = 'SELECT * FROM ' .$table. ' WHERE ' .$column. '=:column';
		$stm = $db->prepare($sqlQuery);
		$stm->execute(array('column' => $value));
		
		if($row = $stm->fetch()){
			return true;
		}
		return false;
	} catch(PDOException $ex){
		//handle exception
	}
}

?>